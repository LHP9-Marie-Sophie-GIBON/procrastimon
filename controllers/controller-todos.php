<?php 

require('../model/class-users.php');
require('../model/class-procrastimons.php');
require('../model/class-sprites.php');
require('../model/class-todos.php');
require('../model/class-trophies.php');
require('../helper/database.php');
require('../config/connect.php');
session_start();

// INSTANCIATION DES CLASSES
$user = new User();
$procrastimon = new Procrastimon();
$sprite = new Sprite();
$todo = new Todo();
 

// AFFICHAGE DE LA PAGE
$user->login($user, $procrastimon, $sprite);// récupération des données de session
$todo->id_users = $_SESSION['user_id'];
$todolist = $todo->getTodos(); // récupération des tâches de l'utilisateur
$empty = empty($todolist);
$expiredTodos = $todo->getExpiredTodos(); // récupération des tâches expirées


// Vérification du formulaire de création de Todo
$arrayErrors = [];
$missing =  "<span class='danger error-message'><i class='bi bi-exclamation-circle-fill'></i></span>";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification que tous les champs sont remplis
    if (isset($_POST['task'])) {
        $name = $_POST['task'];
    }
    if (empty($name)) {
        $arrayErrors['task'] = $missing;
    }

    if (isset($_POST['task_priority_level'])) {
        $category = $_POST['task_priority_level'];
    }
    if (empty($category)) {
        $arrayErrors['task_priority_level'] =  $missing;
    }

    // si arrayErrors est vide, le formulaire est envoyé
    if (empty($arrayErrors) && isset($_POST['insert'])) {
        // Créer une variable de session newtask avec les données de $_POST
        $_SESSION['newTask'] = $_POST;
       
        
    }
}

// (CREATION) Insertion dans la BDD de la nouvelle tâche
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['newTask'])) {
        // déterminer le jour actuel
        $today = date('Y-m-d');

        // on crée une nouvelle tâche
        $todo = new Todo();

        $todo->name = $_SESSION['newTask']['task'];
        $todo->task_priority_level = $_SESSION['newTask']['task_priority_level'];
        $todo->creation = $today;
        $todo->id_users = $_SESSION['user_id'];

        // on envoie les données dans la base de données
        $todo->insertTodo();

        // on supprime la variable de session
        unset($_SESSION['newTask']);

        // on redirige vers la page des tasks
        header('Location: controller-todos.php');
        exit;
        
    }
}

// (TODO STATUTE) 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Complete todo
    if (isset($_POST['checked'])) {
        $todo->id = $_POST['taskId']; 
        $todo->completeTodo();
        $procrastimon->addExp(5, $procrastimon->id);
        
        header('Location: controller-todos.php');
    }

    // Delete todo 
    if (isset($_POST['delete'])) {
        $todo->id = $_POST['taskId'];
        $todo->deleteTodo();
        $procrastimon->removeHp(2, $procrastimon->id);

        header('Location: controller-todos.php');
        exit;
    }
 
}

// (LEVEL UP) Si le procrastimon a atteint l'expérience maximale
if ($procrastimon->exp >= 100) {
    $procrastimon->level ++;
    $procrastimon->exp = 0;

    // le sprite prend + 1 tant que l'on est strictement inférieur au level 4
    if ($procrastimon->level < 4) {
        $procrastimon->id_sprites ++;
    }

    // le procrastimon monte de niveau
    $procrastimon->levelUp($procrastimon->id);
    // header
    header('Location: controller-todos.php');
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

// (TROPHIES)Création des trophés en fonction du nombre de taches réalisées
$completeTodos = $todo->countCompletedTodos();
$totalTrophies = $user->getTotalTrophies('total_todo_trophies'); 
if ($completeTodos === 10 && $totalTrophies < 1) {// si le nombre de goals atteints est égal au seuil de trophée suivant, créer un nouveau trophée
    $trophy = new Trophy();
    $trophy->id_users = $_SESSION['user_id'];
    $trophy->insertTrophy('Wood to-do\'s trophy');
    $user->addTrophy('total_todo_trophies');
    echo "You just won a Trophy, check it out in the trophy room";
} 
elseif ($completeTodos === 25 && $totalTrophies < 2) {
    $trophy = new Trophy();
    $trophy->id_users = $_SESSION['user_id'];
    $trophy->insertTrophy('Steel to-do\'s trophy');
    $user->addTrophy('total_todo_trophies');
    echo "You just won a Trophy, check it out in the trophy room";
} 
elseif ($completeTodos === 50 && $totalTrophies < 3) {
    $trophy = new Trophy();
    $trophy->id_users = $_SESSION['user_id'];
    $trophy->insertTrophy('Marble todo\'s trophy');
    $user->addTrophy('total_todo_trophies');
    echo "You just won a Trophy, check it out in the trophy room";

} elseif ($completeTodos === 100 && $totalTrophies < 4) {
    $trophy = new Trophy();
    $trophy->id_users = $_SESSION['user_id'];
    $trophy->insertTrophy($trophy->id_users, 'Moonstone todo\'s trophy');
    $user->addTrophy('total_todo_trophies');
    echo "You just won a Trophy, check it out in the trophy room";
}



include '../views/view-todos.php';