<?php
class Todo
{
    private $id;
    private string $name;
    private int $task_priority_level;
    private string $creation; 
    private string $due_date;
    private int $statute;
 

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
                $this->due_date = time() + (3 * 24 * 60 * 60); // 3 jours
                break;
            case 3:
                $this->due_date = time() + (5 * 24 * 60 * 60); // 5 jours
                break;
            default:
                $this->due_date = time() + (1 * 24 * 60 * 60); // par défaut, 1 jour
        }
    }

    // méthode pour insérer une tâche dans la base de données
    public function insertTodo()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("INSERT INTO todolist (name, task_priority_level, creation, due_date, id_users) VALUES (:name, :task_priority_level, :creation, :due_date, :id_users)");

        //calcule de la date d'échéance
        
        $this->setDueDate();

        // exécution de la requête
        $query->execute([
            ':name' => $this->name,
            ':task_priority_level' => $this->task_priority_level,
            ':creation' => $this->creation,
            ':due_date' => date('Y-m-d', $this->due_date), // conversion en format de date MySQL
            ':id_users' => $this->id_users
        ]);
    }

    // méthode pour récupérer les tâches d'un utilisateur
    public function getTodos()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("SELECT * FROM todolist WHERE id_users = :id_users ORDER BY due_date ASC");

        // exécution de la requête
        $query->execute([
            ':id_users' => $this->id_users
        ]);

        // récupération des données
        $todos = $query->fetchAll(PDO::FETCH_ASSOC);

        // retour des données
        return $todos;
    }

    // Time left, méthode pour calculer le temps restant entre la création de la todo et la due-date
    public function timeLeft()
    {
        // récupération de la date de création et la date d'échéance
        $creation = $this->creation;
        $due_date = $this->due_date;

        // calcul du temps restant
        $time_left = $due_date - $creation;

        // retour du temps restant
        return $time_left;
    }

    // méthode pour supprimer une tache
    public function deleteTodo()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("DELETE FROM todolist WHERE id = :id");

        // exécution de la requête
        $query->execute([
            ':id' => $this->id
        ]);
    }
}