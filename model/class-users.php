<?php

class User
{
    private int $id;
    private string $login;
    private string $mail;
    private string $password;
    private int $day_night; 
    
    private object $_pdo; 

    // méthode magique pour GET les attributs
    public function __get($attribut)
    {
        return $this->$attribut;
    }

    // méthode magique pour SET les attributs
    public function __set($attribut, $value)
    {
        $this->$attribut = $value;
    }

    // constructeur pour instancier la connexion PDO
    public function __construct()
    {
        $this->_pdo = Database::connect();
    }

    // méthode pour insérer un utilisateur dans la base de données
    public function insertUser()
    {
        $sql = "INSERT INTO users (login, mail, password, day_night) VALUES (:login, :mail, :password, :day_night)";
        $stmt = $this->_pdo->prepare($sql);
        $stmt->bindValue(':login', $this->login);
        $stmt->bindValue(':mail', $this->mail);
        $stmt->bindValue(':password', $this->password);
        $stmt->bindValue(':day_night', $this->day_night);
        $stmt->execute();
    }

}