<?php
session_start();

require('../model/class-users.php');
require('../model/class-procrastimons.php');
require('../model/class-sprites.php');
require('../model/class-goals.php');
require('../model/class-todos.php');
require('../helper/database.php');
require('../config/connect.php');

$user = new User();
$procrastimon = new Procrastimon();
$sprite = new Sprite();
$goal = new Goal();

if (isset($_SESSION['user_id'])) {

    // récupération des données de session
    $user->login($user, $procrastimon, $sprite, $goal);

    // récupération des goals et vérification des duedates
    $goal->id_users = $_SESSION['user_id'];
    $result = $goal->isDueDay();
    $Dday = []; 
    if (empty($result)) {
        $Dday['result'] = ''; 
        
    } else {
        $Dday['result'] = 'modalDday'; 
    }
    
}


// vérification du formulaire new goal
$arrayErrors = [];
$missing =  "<span class='danger error-message'><i class='bi bi-exclamation-circle-fill'></i></span>";


// Si le formulaire est envoyé, on vérifie les champs
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification de goal
    if (isset($_POST['goal'])) {
        $name = $_POST['goal'];
    }
    if (empty($name)) {
        $arrayErrors['goal'] = $missing;
    }

    // Vérification de category
    if (isset($_POST['category'])) {
        $category = $_POST['category'];
    }
    if (empty($category)) {
        $arrayErrors['category'] =  $missing;
    }

    // Vérification de due_date
    if (isset($_POST['due_date'])) {
        $due_date = $_POST['due_date'];
    }
    if (empty($due_date)) {
        $arrayErrors['due_date'] = $missing;
    }

    // si arrayErrors est vide, le formulaire est envoyé
    if (empty($arrayErrors)) {

        // déterminer le jour actuel
        $today = date('Y-m-d');

        // on crée une nouvelle tâche
        $goal = new Goal();
        $goal->name = $name;
        $goal->category = $category;
        $goal->creation = $today; 
        $goal->due_date = $due_date;
        $goal->id_users = $_SESSION['user_id'];

        // on envoie les données dans la base de données
        $goal->insertGoal();
    }
}

// Modal de checked et delete 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['checked'])) {
        $goal->checkGoal($_POST['goalId']); 
        $procrastimon->addExp($_SESSION['user_id'], 10, $procrastimon->id);
        
        header('Location: controller-goals.php');
        exit;
    }

    if (isset($_POST['delete'])) {
        $goal->deleteGoal($_POST['goalId']);
        $procrastimon->removeHp($_SESSION['user_id'], 10, $procrastimon->id);

        header('Location: controller-goals.php');
        exit;
    }
}

// Lorsque l'exp du procrastimon atteint 100, level up
if ($procrastimon->exp >= 100) {
    $procrastimon->levelUp($_SESSION['user_id'], $procrastimon, $procrastimon->id);
}

// Lorsque le procrastimon est KO, rediriger vers controller-gameover.php
if ($procrastimon->hp <= 0) {
    header('Location: controller-gameover.php');
    exit;
}

// lorsque le procrastimon atteint le niveau 4, redirection vers controller-start.php?new
if ($procrastimon->level == 4) {
    header('Location: controller-home.php?new');
    exit;
}













include '../views/view-goals.php';
