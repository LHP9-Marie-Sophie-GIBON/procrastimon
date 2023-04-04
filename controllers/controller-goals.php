<?php

require('../model/class-users.php');
require('../model/class-procrastimons.php');
require('../model/class-sprites.php');
require('../model/class-goals.php');
require('../model/class-trophies.php');
require('../helper/database.php');
require('../config/connect.php');
session_start();

// INSTANCIATION DES CLASSES
$user = new User();
$procrastimon = new Procrastimon();
$sprite = new Sprite();
$goal = new Goal();
 

// AFFICHAGE DE LA PAGE
$user->login($user, $procrastimon, $sprite);// récupération des données de session
$goal->id_users = $_SESSION['user_id'];
$goalsList = $goal->getGoals(); // affichage des goals
$empty = empty($goal->getGoals());// s'il n'y pas de goals enregistrés
$expiredDate = $goal->getExpiredGoals(); //Jour dépassé

// (GOAL CREATION) vérification du formulaire et insertion dans la BDD
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

    if (isset($_POST['comment'])) {
        $comment = $_POST['comment'];
    }

    // si arrayErrors est vide, le formulaire est envoyé
    if (empty($arrayErrors) && isset($_POST['insert'])) {
        // Créer une variable de session newGoal avec les données de $_POST
        $_SESSION['newGoal'] = $_POST;
        $Fonction = '<script>disableLoader(); </script>';
        
    }
}

// (GOAL CREATION) Insertion dans la BDD méthod get
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['newGoal'])) {
        // déterminer le jour actuel
        $today = date('Y-m-d');

        // // // on crée une nouvelle tâche
        $goal = new Goal();

        $goal->name = $_SESSION['newGoal']['goal'];
        $goal->category = $_SESSION['newGoal']['category'];
        $goal->creation = $today;
        $goal->due_date = $_SESSION['newGoal']['due_date'];
        $goal->comments = $_SESSION['newGoal']['comment'];
        $goal->id_users = $_SESSION['user_id'];

        // on envoie les données dans la base de données
        $goal->insertGoal();

        // on supprime la variable de session
        unset($_SESSION['newGoal']);

        // on redirige vers la page des goals
        header('Location: goals.php');
        exit;
    }
}


// (GOAL STATUTE) 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Complete goal
    if (isset($_POST['checked'])) {
        $goal->completeGoal($_POST['goalId']);
        $procrastimon->addExp(10, $procrastimon->id);

        header('Location: goals.php?addexp');
    }

    // Delete goal 
    if (isset($_POST['delete'])) {
        $goal->deleteGoal($_POST['goalId']);
        $procrastimon->removeHp(5, $procrastimon->id);

        header('Location: goals.php?removehp');
        exit;
    }
}

$message = []; 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   
    if (isset($_GET['addexp'])) {
        $message['addexp'] = 'openToast';
    } 

    if (isset($_GET['removehp'])) {
        $message['removehp'] = 'openToast'; 
    }
}

// (LEVEL UP) Si le procrastimon a atteint l'expérience maximale
if ($procrastimon->exp >= 100) {
    $procrastimon->level ++;
    $procrastimon->exp = 0;

    // le sprite prendd + 1 tant que l'on est strictement inférieur au level 4
    if ($procrastimon->level < 4) {
        $procrastimon->id_sprites ++;
    }

    // le procrastimon monte de niveau
    $procrastimon->levelUp($procrastimon->id);

    // header
    header('Location: todos.php?action=levelup');
}

if (isset($_GET['action']) && isset($_GET['action']) == 'levelup') {
    $Fonction = '<script>letsEvolve(); disabledLoader(); </script>';
}

// (LEVEL MAX) lorsque le procrastimon atteint le niveau 4
if ($procrastimon->level == 4) {
    $procrastimon->setEvolutionDay($_SESSION['user_id'], $procrastimon->id);
    header('Location: endgame.php');
    exit;
}

// (GAME OVER) Lorsque le procrastimon est KO, rediriger vers gameover.php
if ($procrastimon->hp <= 0) {
    header('Location: gameover.php');
    exit;
}

// (GOAL TROPHIES) Création des trophés en fonction du nombre de goals accomplis
$achievedGoals = $goal->countAchievedGoals();// Récupération du nombre de goals
$totalTrophies = $user->getTotalTrophies('total_goal_trophies'); 
 
if ($achievedGoals === 1 && $totalTrophies['total_goal_trophies'] < 1) {// si le nombre de goals atteints est égal au seuil de trophée suivant, créer un nouveau trophée
    $trophy = new Trophy();
    $trophy->id_users = $_SESSION['user_id'];
    $trophy->insertTrophy('1st goal\'s trophy', '../assets/img/trophies/goal_trophy01.jpg');
    $user->addTrophy('total_goal_trophies');
    $message['trophy'] = 'OpenToast';
   
} elseif ($achievedGoals === 3 && $totalTrophies['total_goal_trophies'] < 2) {
    $trophy = new Trophy();
    $trophy->id_users = $_SESSION['user_id'];
    $trophy->insertTrophy('3 goal\'s trophy', '../assets/img/trophies/goal_trophy02.jpg');
    $user->addTrophy('total_goal_trophies');
    $message['trophy'] = 'OpenToast';
   
} elseif ($achievedGoals === 5 && $totalTrophies['total_goal_trophies'] < 3) {
    $trophy = new Trophy();
    $trophy->id_users = $_SESSION['user_id'];
    $trophy->insertTrophy('5 goal\'s trophy', '../assets/img/trophies/goal_trophy03.jpg');
    $user->addTrophy('total_goal_trophies');
    $message['trophy'] = 'OpenToast';
   

} elseif ($achievedGoals === 10 && $totalTrophies['total_goal_trophies'] < 4) {
    $trophy = new Trophy();
    $trophy->id_users = $_SESSION['user_id'];
    $trophy->insertTrophy('10 goal\'s trophy', '../assets/img/trophies/goal_trophy04.jpg');
    $user->addTrophy('total_goal_trophies');
    $message['trophy'] = 'OpenToast';
   
} elseif ($achievedGoals === 20 && $totalTrophies['total_goal_trophies'] < 5) {
    $trophy = new Trophy();
    $trophy->id_users = $_SESSION['user_id'];
    $trophy->insertTrophy('20 goal\'s trophy', '../assets/img/trophies/goal_trophy05.jpg');
    $user->addTrophy('total_goal_trophies');
    $message['trophy'] = 'OpenToast';

} 

















include '../views/view-goals.php';
