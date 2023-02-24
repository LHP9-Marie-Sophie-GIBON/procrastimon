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
        $query = $this->_pdo->prepare("INSERT INTO procrastimons (name, id_users, id_sprites) VALUES (:name, :id_users, :id_sprites)");
        $query->execute([
            ':name' => $this->name,
            ':id_users' => $this->id_users,
            ':id_sprites' => $this->id_sprites

        ]);
    }

    // méthode pour récupérer un procrastimon par son id
    public function getProcrastimonById()
    {
        $query = $this->_pdo->prepare("SELECT * FROM procrastimons WHERE id = :id");
        $query->execute([
            ':id' => $this->id
        ]);
        $data = $query->fetch(PDO::FETCH_ASSOC);

        $this->name = $data['name'];
        $this->level = $data['level'];
        $this->hp = $data['hp'];
        $this->exp = $data['exp'];
        $this->id_users = $data['id_users'];
        $this->id_sprites = $data['id_sprites'];
    }

    // méthode pour récupérer tous les procrastimon sauf le dernier
    public function getOldProcrastimons()
    {
        $query = $this->_pdo->prepare("SELECT * FROM procrastimons WHERE id_users = :id_users ORDER BY id DESC LIMIT 1, 100");
        $query->execute([
            ':id_users' => $this->id_users
        ]);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->level = $data['level'];
        $this->hp = $data['hp'];
        $this->exp = $data['exp'];
        $this->id_users = $data['id_users'];
        $this->id_sprites = $data['id_sprites'];
    }

    // méthode pour récupérer le dernier procrastimon crée
    public function getLastProcrastimon()
    {
        $query = $this->_pdo->prepare("SELECT * FROM procrastimons WHERE id_users = :id_users ORDER BY id DESC LIMIT 1");
        $query->execute([
            ':id_users' => $this->id_users
        ]);
        $data = $query->fetch(PDO::FETCH_ASSOC);

        $this->id = $data['id'];
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
        $query = $this->_pdo->prepare("UPDATE procrastimons SET exp = exp + $exp WHERE id_users = :id_users");
        $query->execute([
            ':id_users' => $user
        ]);
    }

    // méthode pour enlever de hp à procrastimon
    public function removeHp($user, $hp)
    {
        $query = $this->_pdo->prepare("UPDATE procrastimons SET hp = hp - $hp WHERE id_users = :id_users");
        $query->execute([
            ':id_users' => $user
        ]);
    }

    // méthode pour levelUp 
    public function levelUp($user, $procrastimon)
    {
        // Si le procrastimon a atteint l'expérience maximale
        if ($procrastimon->exp == 100) {
            $procrastimon->level += 1;
            if ($procrastimon->level >= 2) {
                $procrastimon->id_sprites += 1;
            }

            // Mettre à jour le procrastimon dans la base de données
            $query = $this->_pdo->prepare("UPDATE procrastimons SET level = :level, id_sprites = :id_sprites, exp = 0 WHERE id_users = :id_users");
            $query->execute([
                ':level' => $procrastimon->level,
                ':id_sprites' => $procrastimon->id_sprites,
                ':id_users' => $user
            ]);
        }
    }

    // méthode pour reset le procrastimon lorsque ses hp sont à 0
    public function reset($user, $procrastimon)
    {
        $query = $this->_pdo->prepare("UPDATE procrastimons SET level = 1, hp = 100, exp = 0, id_sprites = 1 WHERE id_users = :id_users");
        $query->execute([
            ':id_users' => $user
        ]);
    }
    
}



class Sprite
{

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
