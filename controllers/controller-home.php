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

// AFFICHAGE DE LA PAGE D'ACCUEIL
if (isset($_SESSION['user_id'])) {
    $user->login($user, $procrastimon, $sprite);
}

// BADGES
$goal = new Goal();
$todo = new Todo();
$goal->id_users = $_SESSION['user_id'];
$todo->id_users = $_SESSION['user_id'];
$numberOfGoals = $goal->countGoals(); //nombre de goals en cours
$numberOfTodos = $todo->countTodos(); //nombre de todos en cours

// TOASTS
$todayGoals = $goal->getTodayGoals(); //goals du jour
$todayTodos = $todo->getTodayTodos(); //todos du jour


// vérification du formulaire de modification du profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $arrayErrors = [];
    $missing =  "<span class='danger'><i class='bi bi-exclamation-circle-fill'></i></span>";
    $wrong = "<span class='danger'><i class='bi bi-x-circle-fill'></i></span>";
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

    // Vérification que le mot de passe correspond au mot de passe enregistré
    if (isset($_POST['oldPassword'])) {
        $oldPassword = $_POST['oldPassword'];
        if (!password_verify($oldPassword, $user->password)) {
            $arrayErrors['oldPassword'] = $wrong;
        }
    }

    // Nouveau password 
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
        if (strlen($password) < 8) { // Si le mot de passe a moins de 8 caractères, on envoie une erreur
            $arrayErrors['password'] = $wrong;
        } else if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) { // Si le mot de passe ne contient pas au moins une lettre et un chiffre, on envoie une erreur
            $arrayErrors['password'] = $wrong;
        }
    }

    // Vérification de la confirmation de mot de passe
    if (isset($_POST['confirmPassword'])) {
        $confirmPassword = $_POST['confirmPassword'];
        // vérification que confirm-password est identique à password
        if ($confirmPassword !== $password) {
            $arrayErrors['confirm-password'] = $wrong;
        }
    }


    // Vérification du nom du procrastimon
    if (isset($_POST['procrastimon'])) {
        $name = $_POST['procrastimon'];
    }
    if (empty($name)) { // Si le nom du procrastimon est vide, on envoie une erreur
        $arrayErrors['procrastimon'] = $missing;
    }

    // si arrayErrors est vide, le formulaire est envoyé
    if (empty($arrayErrors)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // hachage du mot de passe

        // modifier le user
        $user->login = $login;
        $user->mail = $mail;
        $user->password = $hashedPassword;
        $user->updateUser();

        // modifier le procrastimon
        $procrastimon->name = $name;
        $procrastimon->updateProcrastimon();

        header('Location: controller-home.php');
        exit;

    } else {

        echo "fail";
    }
}



include '../views/view-home.php';
