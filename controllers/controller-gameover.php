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

$user->login($user, $procrastimon, $sprite);

$arrayErrors = [];
$missing =  "<span class='danger'><i class='bi bi-exclamation-circle-fill'></i></span>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['newProcrastimon'])) {
        $name = $_POST['newProcrastimon'];
    }
    if (empty($name)) { // Si le nom du procrastimon est vide, on envoie une erreur
        $arrayErrors['procrastimon'] = $missing;
    }

    // si arrayErrors est vide, le formulaire est envoyé
    if (empty($arrayErrors)) {
        // On efface l'ancien procrastimon
        $user_id = $_SESSION['user_id'];
        $procrastimon_id = $procrastimon->id;
        $procrastimon->deleteProcrastimon($user_id, $procrastimon_id);

        // on créer le nouveau procrastimon
        $procrastimon = new Procrastimon();
        $procrastimon->name = $name;
        $procrastimon->id_users = $user_id;

        // on utilise la fonction getRandomStarter pour générer un sprite
        $sprite = new Sprite();
        $sprite->getRandomStarter();
        $procrastimon->id_sprites = $sprite->id;

        // on envoie les données dans la base de données
        $procrastimon->insertProcrastimon();

        // on redirige vers home.php
        header('Location: home.php');
    }
}



include '../views/view-gameover.php';
