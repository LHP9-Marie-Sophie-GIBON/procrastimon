<?php 

require('../model/class-users.php');
require('../model/class-procrastimons.php');
require('../model/class-sprites.php');
require('../model/class-goals.php');
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
$todolist = $todo->getTodos();
$empty = empty($todolist);

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

// (task CREATION) Insertion dans la BDD méthod get
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['newTask'])) {
        // déterminer le jour actuel
        $today = date('Y-m-d');

        // on crée une nouvelle tâche
        $task = new Todo();

        $task->name = $_SESSION['newTask']['task'];
        $task->task_priority_level = $_SESSION['newTask']['task_priority_level'];
        $task->creation = $today;
        $task->id_users = $_SESSION['user_id'];

        // on envoie les données dans la base de données
        $task->insertTodo();

        // on supprime la variable de session
        unset($_SESSION['newTask']);

        // on redirige vers la page des tasks
        header('Location: controller-todos.php');
        exit;
        
    }
}


include '../views/view-todos.php';