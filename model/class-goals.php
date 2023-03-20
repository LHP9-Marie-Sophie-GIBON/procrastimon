<?php

class Goal
{
    private $id;
    private string $name;
    private int $category;
    private string $creation;
    private int $due_date;
    private string $comments;
    private int $statute;
    private string $achievement_day;
    private int $id_users;

    private object $_pdo;

    /**
     * (GET) méthode magique pour GET les attributs
     */ 
    public function __get($attribut)
    {
        return $this->$attribut;
    }

    /**
     * (SET) méthode magique pour SET les attributs
     */ 
    public function __set($attribut, $value)
    {
        $this->$attribut = $value;
    }

    /**
     * (PDO) constructeur pour instancier la connexion PDO
     */ 
    public function __construct()
    {
        $this->_pdo = Database::connect();
    }

    /**
     * (DISPLAY) méthode pour récupérer tous les objectifs d'un utilisateur
     */ 
    public function getGoals()
    {
        $query = $this->_pdo->prepare("SELECT * FROM goals WHERE id_users = :id_users AND statute = 0 ORDER BY due_date ASC");
        $query->execute([
            ':id_users' => $this->id_users
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * (CREATION) méthode pour insérer un objectif dans la base de données
     */ 
    public function insertGoal()
    {

        // préparation de la requête
        $query = $this->_pdo->prepare("INSERT INTO goals (name, category, creation, due_date, comments, id_users) VALUES (:name, :category, :creation, :due_date, :comments, :id_users)");

        // appel de la méthode setDueDate pour calculer la date d'échéance
        $this->setDueDate();

        $query->execute([
            ':name' => $this->name,
            ':category' => $this->category,
            ':creation' => date('Y-m-d', strtotime($this->creation)),
            ':due_date' => date('Y-m-d', $this->due_date), 
            ':comments' => $this->comments, 
            ':id_users' => $this->id_users,

        ]);
    }

    /**
     * (DUE DATE) méthode pour définir la date d'échéance en fonction du niveau de priorité
     */ 
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

    /**
     * (DUE DATE - TIME LEFT) méthode pour déterminer le nombre de jours restants avant l'échéance
     * 
     * @param int $goalId id du goal visé
     * @return void
     */ 
    public function getRemainingDays($goalId) : void
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

    /**
     * (DELETE) méthode pour supprimer un goal
     * 
     * @param int $goalId id du goal à supprimer
     * @return void 
     */ 
    public function deleteGoal($goalId) : void
    {
        $query = $this->_pdo->prepare("DELETE FROM goals WHERE id = :id");
        $query->execute([
            ':id' => $goalId
        ]);
    }

    /**
     * (EDIT) méthode pour modifier un goal
     * 
     * @param int $goalId id du goal à modifier
     * @param string $goalName du nom à modifier
     * @param string $goalCategory de la catégorie à modifier
     * @param string $goalDuedate de la date d'échéance à modifier
     * @param string $goalComments des commentaires à modifier
     * @return void
     */
    public function editGoal($goalId, $goalName, $goalCategory, $goalDuedate, $goalComment) : void
    {
        $query = $this->_pdo->prepare("UPDATE goals SET name = :name, category = :category, due_date = :due_date, comments= :comments WHERE id = :id");
        $query->execute([
            ':name' => $goalName,
            ':category' => $goalCategory,
            ':due_date' => date('Y-m-d', $goalDuedate),
            ':comments' => $goalComment,
            ':id' => $goalId
        ]);
    }

    /**
     * (COMPLETE) méthode pour check un goal
     *  
     * @param int $goalID id du goal complété
     * @return void 
     */ 
    public function completeGoal(int $goalId) : void
    {
        // set le jour de l'accomplissement du goal
        $this->achievement_day = date('Y-m-d');

        $query = $this->_pdo->prepare("UPDATE goals SET statute = 1, achievement_day = :achievement_day WHERE id = :id");
        $query->execute([
            ':id' => $goalId,
            ':achievement_day' => $this->achievement_day
        ]);
    }

    /**
     * (GAME OVER - EXPIRED DATE) méthode pour récupérer les goals expirés
     */ 
    public function getExpiredGoals()
    {
        $query = $this->_pdo->prepare("SELECT * FROM goals WHERE id_users = :id_users AND due_date < :due_date AND statute = 0");
        $query->execute([
            ':id_users' => $this->id_users,
            ':due_date' => date('Y-m-d')
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * méthode pour passer le goal expired en statute 2
     * 
     * @param int $goalId id du goal à modifier
     * @return void
     */ 
    public function expiredGoal($goalId) : void
    {
        $query = $this->_pdo->prepare("UPDATE goals SET statute = 2 WHERE id = :id");
        $query->execute([
            ':id' => $goalId
        ]);
    }

    /**
     * (GAME OVER - DUE DATE IS TODAY) méthode pour afficher un goal dont la due_date est aujourdh'ui
     */ 
    public function isDueDay()
    {
        $query = $this->_pdo->prepare("SELECT * FROM goals WHERE id_users = :id_users AND due_date = :due_date");
        $query->execute([
            ':id_users' => $this->id_users,
            ':due_date' => date('Y-m-d')
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * (BOARDING HOME) méthode pour afficher les goals dont la date est égale ou inférieur a evolution_day
     * 
     * @param int $id_procrastimon id du procrastimon
     * @return void	
     * 
     */ 
    public function getGoalsHistory(int $id_procrastimon)
    {
        $query = $this->_pdo->prepare("SELECT goals.* FROM goals JOIN procrastimons ON goals.id_users = procrastimons.id_users WHERE goals.id_users = :id_users AND goals.achievement_day BETWEEN procrastimons.birthday AND procrastimons.final_evolution AND procrastimons.id = :procrastimons_id ");
        $query->execute([
            ':id_users' => $this->id_users,
            ':procrastimons_id' => $id_procrastimon
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * (TROPHY) méthode récupérant le nombre de goals accomplis par l'utilisateur
     */ 
    public function countAchievedGoals()
    {
        $query = $this->_pdo->prepare("SELECT COUNT(*) FROM goals WHERE id_users = :id_users AND statute = 1");
        $query->execute([
            ':id_users' => $this->id_users
        ]);
        return $query->fetchColumn();
    }

    /**
     * (TROPHY) méthode récupérant les goals accomplis par l'utilisateur
     */ 
    public function getAchievedGoals()
    {
        $query = $this->_pdo->prepare("SELECT * FROM goals WHERE id_users = :id_users AND statute = 1");
        $query->execute([
            ':id_users' => $this->id_users
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

   // méthode pour récupérer les tâches manquées de l'utilisateur
   public function getMissedGoals()
   {
       // préparation de la requête
       $query = $this->_pdo->prepare("SELECT * FROM goals WHERE id_users = :id_users AND statute = 2 ORDER BY due_date ASC");
       $query->execute([
           ':id_users' => $this->id_users
       ]);
       return $query->fetchAll(PDO::FETCH_ASSOC);
   }
}
