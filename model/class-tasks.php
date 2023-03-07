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
    private string $creation;
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

    // méthode pour insérer un objectif dans la base de données
    public function insertGoal()
    {

        // préparation de la requête
        $query = $this->_pdo->prepare("INSERT INTO goals (name, category, creation, due_date, id_users) VALUES (:name, :category, :creation, :due_date, :id_users)");

        // appel de la méthode setDueDate pour calculer la date d'échéance
        $this->setDueDate();

        $query->execute([
            ':name' => $this->name,
            ':category' => $this->category,
            ':creation' => date('Y-m-d', strtotime($this->creation)), 
            ':due_date' => date('Y-m-d', $this->due_date), // conversion en format de date MySQL
            ':id_users' => $this->id_users,

        ]);
    }

    // méthode pour récupérer tous les objectifs d'un utilisateur
    public function getGoals()
    {
        $query = $this->_pdo->prepare("SELECT * FROM goals WHERE id_users = :id_users AND statute = 0");
        $query->execute([
            ':id_users' => $this->id_users
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // méthode pour supprimer un goal 
    public function deleteGoal($goalId)
    {
        $query = $this->_pdo->prepare("DELETE FROM goals WHERE id = :id");
        $query->execute([
            ':id' => $goalId
        ]);
    }

    // méthode pour check un goal
    public function checkGoal($goalId)
    {
        $query = $this->_pdo->prepare("UPDATE goals SET statute = 1, category = 'achieved', due_date = null WHERE id = :id");
        $query->execute([
            ':id' => $goalId
        ]);

    }

    // méthode pour déterminer le nombre de jours restants avant l'échéance
    public function getRemainingDays($goalId)
    {
        $query = $this->_pdo->prepare("SELECT due_date FROM goals WHERE id = :id");
        $query->execute([
            ':id' => $goalId
        ]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $dueDate = strtotime($result['due_date']);
        $remainingDays = ceil(($dueDate - time()) / (60 * 60 * 24));
        echo $remainingDays;
    }

    // méthode pour afficher un goal dont la due_date est aujourdh'ui
    public function isDueDay()
    {
        $query = $this->_pdo->prepare("SELECT * FROM goals WHERE id_users = :id_users AND due_date = :due_date");
        $query->execute([
            ':id_users' => $this->id_users,
            ':due_date' => date('Y-m-d')
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

}

