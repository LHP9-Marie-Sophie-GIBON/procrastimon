<?php
session_start();

require('../model/class-users.php');
require('../model/class-procrastimons.php');
require('../model/class-tasks.php');
require('../helper/database.php');
require('../config/connect.php');


if (isset($_SESSION['user_id'])) {
    $user = new User();
    $user->id = $_SESSION['user_id'];
    $user->getUserById();

    $procrastimon = new Procrastimon();
    $procrastimon->id_users = $_SESSION['user_id'];
    $procrastimon->getLastProcrastimon();

    $sprite = new Sprite();
    $sprite->id = $procrastimon->id_sprites;
    $sprite->getSpriteById();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['login']) && isset($_POST['password'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];
    
        // Vérifier si l'utilisateur existe	
        $user = new User();
        $user->login = $login;
        $user->getUserByLogin();

        // Vérifier si le mot de passe est correct
        if ($user && password_verify($password, $user->password)) {
            // Authentification réussie : enregistrer l'utilisateur dans la session et rediriger vers la page privée
            $_SESSION['user_id'] = $user->id;
           
            header('Location: controller-home.php');
            exit;
        } else {
            // Authentification échouée : afficher un message d'erreur
           echo 'Nom d\'utilisateur ou mot de passe invalide';
        }

    } else {
        // Champs manquants : afficher un message d'erreur
        echo 'Veuillez saisir votre nom d\'utilisateur et votre mot de passe';
    }

}
include '../views/view-start.php';
