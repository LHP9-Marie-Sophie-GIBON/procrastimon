<?php
require('../model/class-users.php');
require('../model/class-procrastimons.php');
require('../model/class-tasks.php');
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

    // Vérification de la confirmation de mot de passe
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
    if (isset($_POST['procrastimon'])) {
        $name = $_POST['procrastimon'];
    }
    if (empty($name)) { // Si le nom du procrastimon est vide, on envoie une erreur
        $arrayErrors['procrastimon'] = $missing;
    }

    // // Vérification de todo
    // if (isset($_POST['todo'])) {
    //     $todo = $_POST['todo'];
    // }
    // if (empty($todo)) { // Si le todo est vide, on envoie une erreur
    //     $arrayErrors['todo'] = $missing;
    // }
    // // Vérification de la priorité du todo
    // if (isset($_POST['priority'])) {
    //     $priority = $_POST['priority'];
    // }
    // if (empty($priority)) { // Si la priorité du todo est vide, on envoie une erreur
    //     $arrayErrors['priority'] = $missing;
    // }

    // // Vérification de goal
    // if (isset($_POST['goal'])) {
    //     $goal = $_POST['goal'];
    // }
    // if (empty($goal)) { // Si le goal est vide, on envoie une erreur
    //     $arrayErrors['goal'] = $missing;
    // }
    // // Vérification de la catagorie du goal
    // if (isset($_POST['category'])) {
    //     $category = $_POST['category'];
    // }
    // if (empty($category)) { // Si la catagorie du goal est vide, on envoie une erreur
    //     $arrayErrors['category'] = $missing;
    // }
    // // Vérification de la date du goal
    // if (isset($_POST['due_date'])) {
    //     $date = $_POST['due_date'];
    // }
    // if (empty($date)) { // Si la date du goal est vide, on envoie une erreur
    //     $arrayErrors['due_date'] = $missing;
    // }





    // si arrayErrors est vide, le formulaire est envoyé
    if (empty($arrayErrors)) {

        // on crée un nouvel utilisateur
        $user = new User();
        $user->login = $login;
        $user->mail = $mail;
        $user->password = $password;

        // on envoie les données dans la base de données
        $user->insertUser();

        // on récupère les données du table sprites
        $sprites = new Sprite();


        // vérification si l'utilisateur a été créé
        if ($user->_pdo->lastInsertId() > 0) {
        //    on crée un nouveau procrastimon
            $procrastimon = new Procrastimon();
            $procrastimon->name = $_POST['procrastimon'];
            $procrastimon->id_users = $user->_pdo->lastInsertId();
            // on récupère l'id du sprite
            $procrastimon->id_sprites = 1;

            // on envoie les données dans la base de données
            $procrastimon->insertProcrastimon();

        } else {
            echo "échec de la création de l'utilisateur";
            
        }




        // header('Location: controller-home.php');
        // exit;
    }
}




include '../views/view-login.php';
