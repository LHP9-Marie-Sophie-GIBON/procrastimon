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
        // préparation de la requête
        $query = $this->_pdo->prepare("INSERT INTO users (login, mail, password) VALUES (:login, :mail, :password)");

        // exécution de la requête 
        $query->execute([
            ':login' => $this->login,
            ':mail' => $this->mail,
            ':password' => $this->password
        ]);
    }

    // méthode pour récupérer un utilisateur par son id
    public function getUserById()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("SELECT * FROM users WHERE id = :id");

        // exécution de la requête
        $query->execute([
            ':id' => $this->id
        ]);

        // récupération des données
        $data = $query->fetch(PDO::FETCH_ASSOC);

        // hydratation de l'objet
        $this->login = $data['login'];
        $this->mail = $data['mail'];
        $this->password = $data['password'];
        $this->day_night = $data['day_night'];
    }

    // méthode pour récupérer un utilisateur par son login
    public function getUserByLogin()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("SELECT * FROM users WHERE login = :login");

        // exécution de la requête
        $query->execute([
            ':login' => $this->login
        ]);

        // récupération des données
        $data = $query->fetch(PDO::FETCH_ASSOC);

        // hydratation de l'objet
        $this->id = $data['id'];
        $this->mail = $data['mail'];
        $this->password = $data['password'];
        $this->day_night = $data['day_night'];
    }

    // méthode pour vérifier que le login et le mail n'existe pas déja
    public function checkLogin()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("SELECT * FROM users WHERE login = :login OR mail = :mail");

        // exécution de la requête
        $query->execute([
            ':login' => $this->login,
            ':mail' => $this->mail
        ]);

        // check if any rows were returned from the query
        $data = $query->fetch(PDO::FETCH_ASSOC);
        // return whether a user was found with the given login or email
        return $data !== false;

        // // récupération des données
        // $data = $query->fetch(PDO::FETCH_ASSOC);

        // // hydratation de l'objet
        // $this->id = $data['id'];
        // $this->login = $data['login'];
        // $this->mail = $data['mail'];
        // $this->password = $data['password'];
        // $this->day_night = $data['day_night'];
    }
}
