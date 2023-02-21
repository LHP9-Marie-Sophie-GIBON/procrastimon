<?php 
session_start();

require('../model/class-users.php');
require('../model/class-procrastimons.php');
require('../model/class-tasks.php');
require('../helper/database.php');
require('../config/connect.php');


var_dump ($_SESSION); 

if (isset($_SESSION['user_id'])) {
    $user = new User();
    $user->id = $_SESSION['user_id'];
    $user->getUserById();

    $procrastimon = new Procrastimon();
    $procrastimon->id = $_SESSION['user_id'];
    $procrastimon->getProcrastimonById();

    // afficher un  message de connexion à user
    echo "Bienvenue " . $user->login . " !";
    echo "Ton procrastimon est " . $procrastimon->name . " !";
    echo "Tu as " . $procrastimon->exp . " points d'expérience !";
    echo "Tu es au niveau " . $procrastimon->level . " !";
    echo "Tu as " . $procrastimon->hp . " points de vie !";
    

   




}

include '../views/view-home.php';