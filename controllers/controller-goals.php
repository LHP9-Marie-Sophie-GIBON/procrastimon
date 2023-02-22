<?php
session_start();

require('../model/class-users.php');
require('../model/class-procrastimons.php');
require('../model/class-tasks.php');
require('../helper/database.php');
require('../config/connect.php');

$user = new User();
$procrastimon = new Procrastimon();
$sprite = new Sprite();

if (isset($_SESSION['user_id'])) {
   
    $user->id = $_SESSION['user_id'];
    $user->getUserById();

    $procrastimon->id = $_SESSION['user_id'];
    $procrastimon->getProcrastimonById();
    
    $sprite->id = $procrastimon->id_sprites;
    $sprite->getSpriteById();
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
    if (empty($name)) { // Si le pseudo est vide, on envoie une erreur
        $arrayErrors['goal'] = $missing;
    }

    // Vérification de category
    if (isset($_POST['category'])) {
        $category = $_POST['category'];
    }
    if (empty($category)) { // Si le category est vide, on envoie une erreur
        $arrayErrors['category'] =  $missing;
    }

    // Vérification de due_date
    if (isset($_POST['due_date'])) {
        $due_date = $_POST['due_date'];
    }
    if (empty($due_date)) { // Si le due_date est vide, on envoie une erreur
        $arrayErrors['due_date'] = $missing;
    }


    // si arrayErrors est vide, le formulaire est envoyé
    if (empty($arrayErrors)) {
       
        // on crée une nouvelle tâche
        $goal = new Goal();
        $goal->name = $name;
        $goal->category = $category;
        $goal->due_date = $due_date;
        $goal->id_users = $_SESSION['user_id'];

        var_dump($goal); 
        // on envoie les données dans la base de données
        $goal->insertGoal();
    } 
  
}





include '../views/view-goals.php';
