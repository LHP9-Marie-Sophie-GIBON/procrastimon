<?php

class Database
{

    private static object $_pdo;

    public static function connect(): object
    {
        // instation d'un objet PDO à l'aide des constantes définies dans le fichier env.php
        self::$_pdo = new PDO(DSN, USER, PASSWORD);

        // nous activons les erreurs PDO et les exceptions PDO
        self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
        // nous retournons l'objet PDO
        return self::$_pdo;
    }
}





