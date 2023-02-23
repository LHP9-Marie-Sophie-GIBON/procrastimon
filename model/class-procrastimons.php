<?php

class Procrastimon 
{
    private int $id;
    private string $name;
    private int $level;
    private int $hp;
    private int $exp;
    private int $id_users;
    private int $id_sprites;
    
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

    
    // methode pour insérer un nouveau procrastimon
    public function insertProcrastimon()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("INSERT INTO procrastimons (name, id_users, id_sprites) VALUES (:name, :id_users, :id_sprites)");

        // exécution de la requête
        $query->execute([
            ':name' => $this->name,
            ':id_users' => $this->id_users,
            ':id_sprites' => $this->id_sprites

        ]);

    }

    // méthode pour récupérer un procrastimon par son id
    public function getProcrastimonById()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("SELECT * FROM procrastimons WHERE id = :id");

        // exécution de la requête
        $query->execute([
            ':id' => $this->id
        ]);

        // récupération des données
        $data = $query->fetch(PDO::FETCH_ASSOC);

        // hydratation de l'objet
        $this->name = $data['name'];
        $this->level = $data['level'];
        $this->hp = $data['hp'];
        $this->exp = $data['exp'];
        $this->id_users = $data['id_users'];
        $this->id_sprites = $data['id_sprites'];
    }

     // méthode pour ajouter de l'exp à procratimon
        public function addExp($user, $exp)
        {
            // préparation de la requête
            $query = $this->_pdo->prepare("UPDATE procrastimons SET exp = exp + $exp WHERE id_users = :id_users");
    
            // exécution de la requête
            $query->execute([
                ':id_users' => $user
            ]);
        }

        // méthode pour enlever de hp à procrastimon
        public function removeHp($user, $hp)
        {
            // préparation de la requête
            $query = $this->_pdo->prepare("UPDATE procrastimons SET hp = hp - $hp WHERE id_users = :id_users");
    
            // exécution de la requête
            $query->execute([
                ':id_users' => $user
            ]);
        }

        // méthode pour faire évoluer le procrastimon lorsque exp = 100
        public function levelUp($user)
        {
            // préparation de la requête
            $query = $this->_pdo->prepare("UPDATE procrastimons SET level = level + 1, exp = 0 WHERE id_users = :id_users");
    
            // exécution de la requête
            $query->execute([
                ':id_users' => $user
            ]);
        }
}

class Sprite {

    private int $id;
    private string $sprite; 
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
    }
}