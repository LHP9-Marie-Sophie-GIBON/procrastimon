<?php

class Procratismon 
{
    private int $id;
    private string $name;
    private int $level;
    private int $hp;
    private int $exp;
    
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

//    methode pour insérer un nouveau procrastimon
    public function insertProcrastimon()
    {
        $sql = "INSERT INTO procrastimons (name, level, hp, exp) VALUES (:name, :level, :hp, :exp)";
        $stmt = $this->_pdo->prepare($sql);
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':level', $this->level);
        $stmt->bindValue(':hp', $this->hp);
        $stmt->bindValue(':exp', $this->exp);
        $stmt->execute();
    }

}
