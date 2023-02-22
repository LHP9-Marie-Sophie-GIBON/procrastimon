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

    // méthode pour calculer la date d'échéance en fonction du niveau de priorité
    public function setDueDate()
    {
        switch ($this->task_priority_level) {
            case 1:
                $this->due_date = time() + (1 * 24 * 60 * 60); // 1 jour
                break;
            case 2:
                $this->due_date = time() + (2 * 24 * 60 * 60); // 2 jours
                break;
            case 3:
                $this->due_date = time() + (3 * 24 * 60 * 60); // 3 jours
                break;
            default:
                $this->due_date = time() + (1 * 24 * 60 * 60); // par défaut, 1 jour
        }
    }

    // méthode pour insérer une tâche dans la base de données
    public function insertTodo()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("INSERT INTO todos (name, task_priority_level, due_date, statute, penality) VALUES (:name, :task_priority_level, :due_date, :statute, :penality)");

        // appel de la méthode setDueDate pour calculer la date d'échéance
        $this->setDueDate();

        // exécution de la requête
        $query->execute([
            ':name' => $this->name,
            ':task_priority_level' => $this->task_priority_level,
            ':due_date' => date('Y-m-d', $this->due_date), // conversion en format de date MySQL
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
    private int $id_users;

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
        $query = $this->_pdo->prepare("INSERT INTO goals (name, category, due_date, id_users) VALUES (:name, :category, :due_date, :id_users)");

        // appel de la méthode setDueDate pour calculer la date d'échéance
        $this->setDueDate();

        // exécution de la requête
        $query->execute([
            ':name' => $this->name,
            ':category' => $this->category,
            ':due_date' => date('Y-m-d', $this->due_date), // conversion en format de date MySQL
            ':id_users' => $this->id_users, 
            
        ]);
    }

    // méthode pour définir la date d'échéance en fonction du niveau de priorité
    public function setDueDate()
    {
        switch ($this->due_date) {
            case 1:
                $this->due_date = strtotime('+1 month');
                break;
            case 2:
                $this->due_date = strtotime('+6 months');
                break;
            case 3:
                $this->due_date = strtotime('+1 year');
                break;
            default:
                // si le niveau de priorité n'est pas 1, 2 ou 3, on utilise une date par défaut dans 3 mois
                $this->due_date = strtotime('+3 months');
                break;
        }
    }

    // méthode pour récupérer tous les objectifs d'un utilisateur
    public function getGoals()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("SELECT * FROM goals WHERE id_users = :id_users");

        // exécution de la requête
        $query->execute([
            ':id_users' => $this->id_users
        ]);

        // récupération des résultats
        return $query->fetchAll(PDO::FETCH_ASSOC);
        
    }
}

