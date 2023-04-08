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



// vérification des formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // OPENTOAST
    $toast = []; 
    
    // MODAL EDIT PROFIL
    $arrayErrors = [];
    $missing =  "<span class='danger'><i class='bi bi-exclamation-circle-fill'></i></span>";
    $wrong = "<span class='danger'><i class='bi bi-x-circle-fill'></i></span>";

    if (isset($_POST['login'])) { // Vérification du pseudo
        $login = $_POST['login'];
    }
    if (empty($login)) {
        $arrayErrors['login'] = $missing;
        $arrayErrors['login-error'] = 'Login required';
        $arrayErrors['danger'] = 'text-danger';
    }


    if (isset($_POST['mail'])) { // Vérification du mail
        $mail = $_POST['mail'];
    }
    if (empty($mail)) {
        $arrayErrors['mail'] =  $missing;
        $arrayErrors['mail-error'] = 'Mail required';
        $arrayErrors['danger'] = 'text-danger';
    } else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $arrayErrors['mail'] = $wrong;
        $arrayErrors['mail-error'] = 'Mail not valid';
        $arrayErrors['danger'] = 'text-danger';
    }

    if (isset($_POST['procrastimon'])) { // Vérification du nom du procrastimon
        $name = $_POST['procrastimon'];
    }
    if (empty($name)) { // Si le nom du procrastimon est vide, on envoie une erreur
        $arrayErrors['procrastimon'] = $missing;
        $arrayErrors['procrastimon-error'] = 'Procrastimon name required';
        $arrayErrors['danger'] = 'text-danger';
    }

    // si arrayErrors est vide, le formulaire est envoyé
    if (empty($arrayErrors)) {

        // modifier le user
        $user->login = htmlspecialchars($login);
        $user->mail = htmlspecialchars($mail);
        $procrastimon->name = htmlspecialchars($name);

        $user->updateUser();
        $procrastimon->updateProcrastimon();

        
        header('Location: home.php?action=editprofil');
        exit;

    } else {
        echo "fail";
    }

    // MODAL EDIT PASSWORD
    $passwordErrors = [];
    $missing =  "<span class='danger'><i class='bi bi-exclamation-circle-fill'></i></span>";
    $wrong = "<span class='danger'><i class='bi bi-x-circle-fill'></i></span>";

    // Vérification que le mot de passe correspond au mot de passe enregistré
    if (isset($_POST['oldPassword'])) {
        $oldPassword = $_POST['oldPassword'];
        if (!password_verify($oldPassword, $user->password)) {
            $passwordErrors['oldPassword'] = $wrong;
            $passwordErrors['oldPassword-error'] = 'Passwords do not match';
            $passwordErrors['danger'] = 'text-danger';
        }
    }

    // Nouveau password 
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
        if (strlen($password) < 8) { // Si le mot de passe a moins de 8 caractères, on envoie une erreur
            $passwordErrors['password'] = $wrong;
            $passwordErrors['password-error'] = 'Password must contain 8 characters';
            $passwordErrors['danger'] = 'text-danger';
        } else if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) { // Si le mot de passe ne contient pas au moins une lettre et un chiffre, on envoie une erreur
            $passwordErrors['password'] = $wrong;
            $passwordErrors['password-error'] = 'Password must contain one letter and one number';
            $passwordErrors['danger'] = 'text-danger';
        }
    }
    if (empty($password)) { // Si le mot de passe est vide, on envoie une erreur
        $passwordErrors['password'] = $missing;
        $passwordErrors['password-error'] = 'new password required';
        $passwordErrors['danger'] = 'text-danger';
    }

    // Vérification de la confirmation de mot de passe
    if (isset($_POST['confirmPassword'])) {
        $confirmPassword = $_POST['confirmPassword'];
        // vérification que confirm-password est identique à password
        if ($confirmPassword !== $password) {
            $passwordErrors['confirm-password'] = $wrong;
            $passwordErrors['confirm-password-error'] = 'Passwords do not match';
            $passwordErrors['danger'] = 'text-danger';
        }
    }

    if (empty($passwordErrors)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // hachage du mot de passe
        $toast = 'openToast'; 

        // modifier le user
        $user->password = $hashedPassword;
        $user->updatePassword();

        header('Location: home.php?action=editpassword');
        exit;
    } else {

        echo "fail";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'editprofil') {
            $toast['profil'] = 'openToast';
        } else if ($_GET['action'] === 'editpassword') {
            $toast['password'] = 'openToast';
        }
    }
}

include '../views/view-home.php';
