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
    $procrastimon->id = $_SESSION['user_id'];
    $procrastimon->getProcrastimonById();

    $sprite = new Sprite(); 
    $sprite->id = $procrastimon->id_sprites; 
    $sprite ->getSpriteById();

}

include '../views/view-home.php';