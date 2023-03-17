<?php

class Trophy {
    private int $id; 
    private string $title; 
    private string $creation;
    private int $id_users;

    private object $_pdo;

    // (GET) méthode magique pour GET les attributs
    public function __get($attribut)
    {
        return $this->$attribut;
    }

    // (SET) méthode magique pour SET les attributs
    public function __set($attribut, $value)
    {
        $this->$attribut = $value;
    }

    // (PDO) constructeur pour instancier la connexion PDO
    public function __construct()
    {
        $this->_pdo = Database::connect();
    }

    // (LOGIN) méthode pour récupérer tous les trophées d'un utilisateur
    public function getTrophies()
    {
        $query = $this->_pdo->prepare("SELECT * FROM trophies WHERE id_users = :id_users");
        $query->execute([
            ':id_users' => $this->id_users
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // (CREATION) méthode pour insérer un trophée dans la base de données
    public function insertTrophy($title)
    {
        $this->creation = date('Y-m-d');

        // préparation de la requête
        $query = $this->_pdo->prepare("INSERT INTO trophies (creation, title, id_users) VALUES (:creation, :title, :id_users)");
        $query->execute([
            ':creation' => $this->creation,
            ':title' => $title,
            ':id_users' => $this->id_users,
        ]);
    }

    // (DISPLAY) méthode pour afficher les trophées de l'utilisateur
    public function displayTrophies()
    {
        $query = $this->_pdo->prepare("SELECT * FROM trophies WHERE id_users = :id_users");
        $query->execute([
            ':id_users' => $this->id_users
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

}