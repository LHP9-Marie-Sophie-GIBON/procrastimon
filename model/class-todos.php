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
                $this->due_date = strtotime('today midnight');
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
        $query = $this->_pdo->prepare("SELECT * FROM todolist WHERE id_users = :id_users and statute = 0 ORDER BY due_date ASC");

        // exécution de la requête
        $query->execute([
            ':id_users' => $this->id_users
        ]);

        // récupération des données
        $todos = $query->fetchAll(PDO::FETCH_ASSOC);

        // retour des données
        return $todos;
    }

    // méthode pour récupérer les tâches de l'utilisateur à accomplir aujourd'hui
    public function getTodayTodos()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("SELECT * FROM todolist WHERE id_users = :id_users and statute = 0 and due_date = :due_date ORDER BY due_date ASC");
        $query->execute([
            ':id_users' => $this->id_users,
            ':due_date' => date('Y-m-d') 
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // méthode pour récupérer le nombre de tâches en cours d'un utilisateur
    public function countTodos()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("SELECT COUNT(*) FROM todolist WHERE id_users = :id_users and statute = 0");
        $query->execute([
            ':id_users' => $this->id_users
        ]);
        return $query->fetchColumn();
    }

    // Time left, méthode pour calculer le temps restant entre la création de la todo et la due-date
    public function timeLeft()
    {
        $dueDate = strtotime($this->due_date);

        // calcul du temps restant
        $time_left = ceil(($dueDate - time()) / (60 * 60 * 24));
    
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

    // méthode pour compléter une tache
    public function completeTodo()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("UPDATE todolist SET statute = 1 WHERE id = :id");

        // exécution de la requête
        $query->execute([
            ':id' => $this->id
        ]);
    }

    // méthode pour récupérer les tâches expirées de l'utilisateur
    public function getExpiredTodos()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("SELECT * FROM todolist WHERE id_users = :id_users and statute = 0 and due_date < :due_date ORDER BY due_date ASC");
        $query->execute([
            ':id_users' => $this->id_users,
            ':due_date' => date('Y-m-d') 
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // méthode pour update la tâche en statute 2
    public function expiredTodo($todo_id)
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("UPDATE todolist SET statute = 2 WHERE id = :id");

        // exécution de la requête
        $query->execute([
            ':id' => $todo_id
        ]);
    }

    // méthode pour récupérer les tâches complétées de l'utilisateur
    public function getCompletedTodos()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("SELECT * FROM todolist WHERE id_users = :id_users and statute = 1 ORDER BY due_date ASC");
        $query->execute([
            ':id_users' => $this->id_users
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // méthode pour calculer le nombre de tâches complétées par l'utilisateur
    public function countCompletedTodos()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("SELECT COUNT(*) FROM todolist WHERE id_users = :id_users and statute = 1");
        $query->execute([
            ':id_users' => $this->id_users
        ]);
        return $query->fetchColumn();
    }

    // méthode pour récupérer les tâches manquées de l'utilisateur
    public function getMissedTodos()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("SELECT * FROM todolist WHERE id_users = :id_users AND statute = 2 ORDER BY due_date ASC");
        $query->execute([
            ':id_users' => $this->id_users
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
}