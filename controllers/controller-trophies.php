<?php
session_start();

require('../model/class-users.php');
require('../model/class-procrastimons.php');
require('../model/class-sprites.php');
require('../model/class-goals.php');
require('../model/class-todos.php');
require('../model/class-trophies.php');
require('../helper/database.php');
require('../config/connect.php');

// INSTANCIATION DES CLASSES
$user = new User();
$procrastimon = new Procrastimon();
$sprite = new Sprite();
$goal = new Goal();
$todo = new Todo();
$trophy = new Trophy();


// AFFICHAGE DE LA PAGE
$user->login($user, $procrastimon, $sprite); // récupération des données de session

$trophy->id_users = $_SESSION['user_id'];
$trophiesList = $trophy->displayTrophies(); // récupération des trophés
$empty = empty($trophiesList);

$goal->id_users = $_SESSION['user_id'];
$goalsList = $goal->getAchievedGoals(); // récupération des objectifs







include '../views/view-trophies.php';
