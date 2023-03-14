<?php

class Sprite
{

    private int $id;
    private string $sprite;
    private string $chibi; 
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

    // méthode pour récupérer le sprite par son id
    public function getSpriteById()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("SELECT * FROM sprites WHERE id = :id");

        // exécution de la requête
        $query->execute([
            ':id' => $this->id
        ]);

        // récupération des données
        $data = $query->fetch(PDO::FETCH_ASSOC);

        // hydratation de l'objet
        $this->sprite = $data['sprite'];
        $this->chibi = $data['chibi'];
    }

    // méthode pour afficher aléatoirement un starter à la création d'un nouveau procrastimon
    public function getRandomStarter()
    {
        $query = $this->_pdo->prepare("SELECT * FROM sprites WHERE (id - 1) % 3 = 0 ORDER BY RAND() LIMIT 1");
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);

        $this->id = $data['id'];
        $this->sprite = $data['sprite'];
        $this->chibi = $data['chibi']; 
    }

    
}
