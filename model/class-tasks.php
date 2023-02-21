<?php

class Todo
{
    private $id;
    private string $name;
    private int $task_priority_level;
    private int $due_date;
    private int $statute;
    private int $penality;

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

    // méthode pour insérer une tâche dans la base de données
    public function insertTodo()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("INSERT INTO todos (name, task_priority_level, due_date, statute, penality) VALUES (:name, :task_priority_level, :due_date, :statute, :penality)");

        // exécution de la requête
        $query->execute([
            ':name' => $this->name,
            ':task_priority_level' => $this->task_priority_level,
            ':due_date' => $this->due_date,
            ':statute' => $this->statute,
            ':penality' => $this->penality
        ]);
    }
}

class Goal
{
    private $id;
    private string $name;
    private string $category;
    private int $due_date;
    private int $statute;
    private int $penality;

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

    // méthode pour insérer un objectif dans la base de données
    public function insertGoal()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("INSERT INTO goals (name, category, due_date, statute, penality) VALUES (:name, :category, :due_date, :statute, :penality)");

        // exécution de la requête
        $query->execute([
            ':name' => $this->name,
            ':category' => $this->category,
            ':due_date' => $this->due_date,
            ':statute' => $this->statute,
            ':penality' => $this->penality
        ]);
    }
}
