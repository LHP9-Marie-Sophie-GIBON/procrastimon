<?php
session_start();

require('../model/class-users.php');
require('../model/class-procrastimons.php');
require('../model/class-sprites.php');
require('../model/class-goals.php');
require('../model/class-todos.php');
require('../helper/database.php');
require('../config/connect.php');

// INSTANCIATION DES CLASSES
$user = new User();
$procrastimon = new Procrastimon();
$sprite = new Sprite();


// AFFICHAGE DE LA PAGE
$user->login($user, $procrastimon, $sprite);// récupération des données de session
$procrastimonList = $procrastimon->getOldProcrastimons();




include '../views/view-boarding-home.php';