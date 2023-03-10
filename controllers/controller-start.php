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

    $arrayErrors = [];
    $missing = "<span class='danger error-message'><i class='bi bi-exclamation-circle-fill'></i></span>"; 
    $wrong = "<span class='danger error-message'><i class='bi bi-x-circle-fill'></i></span>"; 

    // si les champs sont vide : echo "erreur"
    if (empty($_POST['login']) || empty($_POST['password'])) {
        $arrayErrors['login'] = $missing;
        
    } else if (isset($_POST['login']) && isset($_POST['password'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];
    
        // Vérifier si l'utilisateur existe	
        $user = new User();
        $user->login = $login;
        $user->getUserByLogin();
        $existingUser = $user->login;

        // Vérifier si le mot de passe est correct
        if ($existingUser) {
            if ($user && password_verify($password, $user->password)) {
                // Authentification réussie : enregistrer l'utilisateur dans la session et rediriger vers la page privée
                $_SESSION['user_id'] = $user->id;
               
                header('Location: controller-home.php');
                exit;
            } else {
                $arrayErrors['password'] = $wrong;
               
            }
        } else {
            // Authentification échouée : afficher un message d'erreur
            $arrayErrors['login'] = $wrong;
            $arrayErrors['password'] = $wrong;
            $success = false;
        }
    } 

}
include '../views/view-start.php';
