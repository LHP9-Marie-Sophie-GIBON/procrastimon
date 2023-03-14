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

    // méthode pour récupérer tous les procrastimon sauf le dernier
    public function getOldProcrastimons()
    {
        $query = $this->_pdo->prepare("SELECT * FROM procrastimons WHERE id_users = :id_users ORDER BY id DESC LIMIT 1, 100");
        $query->execute([
            ':id_users' => $this->id_users
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
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
    public function addExp($user, $exp, $procrastimon_id)
    {
        $query = $this->_pdo->prepare("UPDATE procrastimons SET exp = exp + $exp WHERE id_users = :id_users AND id = :id");
        $query->execute([
            ':id_users' => $user,
            ':id' => $procrastimon_id
        ]);
    }

    // méthode pour enlever de hp à procrastimon
    public function removeHp($user_id, $hp, $procrastimon_id)
    {
        $query = $this->_pdo->prepare("UPDATE procrastimons SET hp = hp - $hp WHERE id_users = :id_users AND id = :id");
        $query->execute([
            ':id_users' => $user_id,
            ':id' => $procrastimon_id
        ]);
    }

    // (LEVEL UP) méthode pour monter de niveau 
    public function levelUp($user_id, $procrastimon, $procrastimon_id)
    {
        // Si le procrastimon a atteint l'expérience maximale
        if ($procrastimon->exp == 100) {
            $procrastimon->level += 1;
            if ($procrastimon->level >= 2) {
                $procrastimon->id_sprites += 1;
            }

            // Mettre à jour le procrastimon dans la base de données
            $query = $this->_pdo->prepare("UPDATE procrastimons SET level = :level, id_sprites = :id_sprites , exp = 0 WHERE id_users = :id_users AND id = :id");
            $query->execute([
                ':level' => $procrastimon->level,
                ':id_sprites' => $procrastimon->id_sprites,
                ':id_users' => $user_id,
                ':id' => $procrastimon_id
            ]);
        }
    }

    // (GAMEOVER) methode pour reset le procrastimon 
    public function resetProcrastimon($user_id, $procrastimon_id)
    {
        $query = $this->_pdo->prepare("UPDATE procrastimons SET level = 1, hp = 100, exp = 0, id_sprites = 1 WHERE id_users = :id_users AND id = :id");
        $query->execute([
            ':id_users' => $user_id,
            ':id' => $procrastimon_id
        ]);
    }

    // (GAMEOVER) methode pour supprimer le procrastimon 
    public function deleteProcrastimon($user_id, $procrastimon_id)
    {
        $query = $this->_pdo->prepare("DELETE FROM procrastimons WHERE id_users = :id_users AND id = :id");
        $query->execute([
            ':id_users' => $user_id,
            ':id' => $procrastimon_id
        ]);
    }
    
}



