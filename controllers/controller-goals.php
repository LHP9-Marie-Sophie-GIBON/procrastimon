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



// récupération des données de session
$user->login($user, $procrastimon, $sprite);

// récupération des goals
$goal = new Goal();
$goal->id_users = $_SESSION['user_id'];
// vérification des duedates
$result = $goal->isDueDay();
$Dday = [];
if (empty($result)) {
    $Dday['result'] = '';
} else {
    $Dday['result'] = 'modalDday';
}


// (GOAL CREATION) 
$arrayErrors = [];
$missing =  "<span class='danger error-message'><i class='bi bi-exclamation-circle-fill'></i></span>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification que tous les champs sont remplis
    if (isset($_POST['goal'])) {
        $name = $_POST['goal'];
    }
    if (empty($name)) {
        $arrayErrors['goal'] = $missing;
    }

    if (isset($_POST['category'])) {
        $category = $_POST['category'];
    }
    if (empty($category)) {
        $arrayErrors['category'] =  $missing;
    }

    if (isset($_POST['due_date'])) {
        $due_date = $_POST['due_date'];
    }
    if (empty($due_date)) {
        $arrayErrors['due_date'] = $missing;
    }

    // si arrayErrors est vide, le formulaire est envoyé
    if (empty($arrayErrors) && isset($_POST['insert'])) {

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

// (GOAL STATUTE) 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Goal complete
    if (isset($_POST['checked'])) {
        $goal->checkGoal($_POST['goalId']);
        $procrastimon->addExp($_SESSION['user_id'], 10, $procrastimon->id);

        header('Location: controller-goals.php');
        exit;
    }

    // Delete goal 
    if (isset($_POST['delete'])) {
        $goal->deleteGoal($_POST['goalId']);
        $procrastimon->removeHp($_SESSION['user_id'], 10, $procrastimon->id);

        header('Location: controller-goals.php');
        exit;
    }

    // Edit goal 
    if (isset($_POST['edit'])) {
        if (empty($arrayErrors)) {
            $goal->editGoal($_POST['goalId'], $_POST['goal'], $_POST['category'], $_POST['duedate']);
            header('Location: controller-goals.php');
            exit;
        }
    }
}


// (LEVEL UP) Si le procrastimon a atteint l'expérience maximale
if ($procrastimon->exp >= 100) {
    $procrastimon->level += 1;
    $procrastimon->exp = 0;

    // le sprite prendd + 1 tant que l'on est strictement inférieur au level 4
    if ($procrastimon->level < 4) {
        $procrastimon->id_sprites += 1;
    }

    // le procrastimon monte de niveau
    $procrastimon->levelUp($_SESSION['user_id'], $procrastimon, $procrastimon->id);
}


// (BOARDING HOME) lorsque le procrastimon atteint le niveau 4, redirection vers controller-start.php?new
if ($procrastimon->level == 4) {
    header('Location: controller-home.php?new');
    exit;
}

// (GAME OVER) Lorsque le procrastimon est KO, rediriger vers controller-gameover.php
if ($procrastimon->hp <= 0) {
    header('Location: controller-gameover.php');
    exit;
}












include '../views/view-goals.php';
