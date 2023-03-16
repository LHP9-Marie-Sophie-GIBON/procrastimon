<?php
session_start();

require('../model/class-users.php');
require('../model/class-procrastimons.php');
require('../model/class-sprites.php');
require('../model/class-goals.php');
require('../model/class-todos.php');
require('../model/class-trophies.php');
require('../helper/database.php');
require('../config/connect.php');

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
$dueDay = $goal->isDueDay($_SESSION['user_id']);// vérification des duedates


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

        // on redirige vers la page des goals
        header('Location: controller-goals.php');
        exit;
    }
}

// (GOAL STATUTE) 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Complete goal
    if (isset($_POST['checked'])) {
        $goal->checkGoal($_POST['goalId']);
        $procrastimon->addExp($_SESSION['user_id'], 10, $procrastimon->id);

        header('Location: controller-goals.php');
        exit;
    }

    // Delete goal 
    if (isset($_POST['delete'])) {
        $goal->deleteGoal($_POST['goalId']);
        $procrastimon->removeHp($_SESSION['user_id'], 5, $procrastimon->id);

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

    // Reset goal
    if (isset($_POST['reset'])) {
            $goal->editGoal($_POST['id'], $_POST['name'], $_POST['category'], $_POST['due_date']);
            $procrastimon->removeHp($_SESSION['user_id'], 10, $procrastimon->id);
            header('Location: controller-goals.php');
            exit;
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

// (LEVEL MAX) lorsque le procrastimon atteint le niveau 4
if ($procrastimon->level == 4) {
    header('Location: controller-endgame.php');
    exit;
}

// (GAME OVER) Lorsque le procrastimon est KO, rediriger vers controller-gameover.php
if ($procrastimon->hp <= 0) {
    header('Location: controller-gameover.php');
    exit;
}

// (GOAL TROPHIES) Création des trophés en fonction du nombre de goals accomplis
if (!isset($_SESSION['totalTrophies'])) {// initialiser une variable de session 'totalTrophies'
    $_SESSION['totalTrophies'] = 0;
}
$achievedGoals = $goal->countAchievedGoals($_SESSION['user_id']);// Récupération du nombre de goals

if ($achievedGoals == 1 && $_SESSION['totalTrophies'] < 1 ) {// si le nombre de goals atteints est égal au seuil de trophée suivant, créer un nouveau trophée
    $trophy = new Trophy();
    $trophy->id_users = $_SESSION['user_id'];
    $trophy->insertTrophy($trophy->id_users, 'Bronze goal\'s trophy');
    $_SESSION['totalTrophies']++;

    echo "You just won a Trophy, check it out in the trophy room";

} elseif ($achievedGoals == 3 && $_SESSION['totalTrophies'] < 2) {
    $trophy = new Trophy();
    $trophy->id_users = $_SESSION['user_id'];
    $trophy->insertTrophy($trophy->id_users, 'Silver goal\'s trophy');
    $_SESSION['totalTrophies']++;

    echo "You just won a Trophy, check it out in the trophy room";

} elseif ($achievedGoals == 5 && $_SESSION['totalTrophies'] < 3) {
    $trophy = new Trophy();
    $trophy->id_users = $_SESSION['user_id'];
    $trophy->insertTrophy($trophy->id_users, 'Gold goal\'s trophy');
    $_SESSION['totalTrophies']++;

    echo "You just won a Trophy, check it out in the trophy room";

} elseif ($achievedGoals == 10 && $_SESSION['totalTrophies'] < 5) {
    $trophy = new Trophy();
    $trophy->id_users = $_SESSION['user_id'];
    $trophy->insertTrophy($trophy->id_users, 'Diamond goal\'s trophy');
    $_SESSION['totalTrophies']++;

    echo "You just won a Trophy, check it out in the trophy room";
}














include '../views/view-goals.php';
