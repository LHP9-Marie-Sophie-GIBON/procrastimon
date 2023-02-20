<?php 
require('../model/class-users.php');
require('../model/class-procrastimons.php');
require('../helper/database.php');
require('../config/connect.php'); 

$arrayErrors = []; 
$missing =  "<span class='danger'><i class='bi bi-exclamation-circle-fill'></i></span>";
$wrong = "<span class='danger'><i class='bi bi-x-circle-fill'></i></span>"; 

// Si le formulaire est envoyé, on vérifie les champs
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // Vérification du pseudo
    if (isset($_POST['login'])) {
        $login = $_POST['login'];
    }
    if (empty($login)) { // Si le pseudo est vide, on envoie une erreur
        $arrayErrors['login'] = $missing;
    }

// Vérification du mail
    if (isset($_POST['mail'])) {
        $mail = $_POST['mail'];
    }
    if (empty($mail)) { // Si le mail est vide, on envoie une erreur
        $arrayErrors['mail'] =  $missing;
    }

// Vérification du mot de passe
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    }
    if (empty($password)) { // Si le mot de passe est vide, on envoie une erreur
        $arrayErrors['password'] = $missing;
    }

// vérification de la confirmation de mot de passe
    if (isset($_POST['confirm-password'])) {
        $confirmPassword = $_POST['confirm-password'];
        // vérification que confirm-password est identique à password
        if ($confirmPassword !== $password) {
            $arrayErrors['confirm-password'] = $wrong;
        }
    }
    if (empty($confirmPassword)) { // Si le mot de passe est vide, on envoie une erreur
        $arrayErrors['confirm-password'] = $missing;
    }

// Vérification du nom du procrastimon
    if (isset($_POST['name'])) {
        $procrastimon = $_POST['name'];
    }
    if (empty($procrastimon)) { // Si le nom du procrastimon est vide, on envoie une erreur
        $arrayErrors['name'] = $missing;
    }

// Vérification de todo
    if (isset($_POST['todo'])) {
        $todo = $_POST['todo'];
    }
    if (empty($todo)) { // Si le todo est vide, on envoie une erreur
        $arrayErrors['todo'] = $missing;
    }

// Vérification de goal
    if (isset($_POST['goal'])) {
        $goal = $_POST['goal'];
    }
    if (empty($goal)) { // Si le goal est vide, on envoie une erreur
        $arrayErrors['goal'] = $missing;
    }

// si arrayErrors est vide, le formulaire est envoyé
    if (empty($arrayErrors)) {
        // on envoie les données dans la base de données, fonction insertUser
        $user = new User();
        $user->login = $login;
        $user->mail = $mail;
        $user->password = $password;
        $user->day_night = 1;
        $user->insertUser();

        $procrastimon = new Procrastimon();
        $procrastimon->name = $procrastimon;
        $procrastimon->level = 1;
        $procrastimon->hp = 100;
        $procrastimon->exp = 0;
        $procrastimon->insertProcrastimon();

        




        
        header('Location: controller-home.php');
        exit;
    }
}




include '../views/view-login.php';
