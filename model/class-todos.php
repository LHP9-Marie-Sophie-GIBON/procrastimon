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