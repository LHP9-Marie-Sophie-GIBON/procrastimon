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
     * (DISPLAY) méthode pour afficher les objectifs d'un utilisateur
     */
    public function getGoals()
    {
        $query = $this->_pdo->prepare("SELECT * FROM goals WHERE id_users = :id_users
        AND statute = 0 ORDER BY due_date ASC");
        $query->bindValue(':id_users', $this->id_users, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * (GET) méthode pour récupérer les goals arrivés à échéance
     */
    public function getTodayGoals()
    {
        $query = $this->_pdo->prepare("SELECT name FROM goals WHERE id_users = :id_users 
        AND statute = 0 AND due_date = :due_date ORDER BY due_date ASC");
        $query->execute([
            ':id_users' => $this->id_users,
            ':due_date' => date('Y-m-d')
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * (COUNT) méthode compter le nombre d'objectifs d'un utilisateur
     */
    public function countGoals()
    {
        $query = $this->_pdo->prepare("SELECT COUNT(*) FROM goals WHERE id_users = :id_users AND statute = 0");
        $query->execute([
            ':id_users' => $this->id_users
        ]);
        return $query->fetchColumn();
    }

    /**
     * (CREATION) méthode pour insérer un objectif dans la base de données
     */
    public function insertGoal()
    {

        // préparation de la requête
        $query = $this->_pdo->prepare("INSERT INTO goals (name, category, creation, due_date, comments, id_users) 
        VALUES (:name, :category, :creation, :due_date, :comments, :id_users)");

        // appel de la méthode setDueDate pour calculer la date d'échéance
        $this->setDueDate();

        $query->bindValue(':name', $this->name);
        $query->bindValue(':category', $this->category);
        $query->bindValue(':creation', date('Y-m-d', strtotime($this->creation)));
        $query->bindValue(':due_date', date('Y-m-d', $this->due_date));
        $query->bindValue(':comments', $this->comments);
        $query->bindValue(':id_users', $this->id_users);

        $query->execute();
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
     * @param float $goalId id du goal visé
     * @return void
     */
    public function getRemainingDays(float $goalId)
    {
        $query = $this->_pdo->prepare("SELECT due_date FROM goals WHERE id = :id");
        $query->execute([
            ':id' => $goalId
        ]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $dueDate = strtotime($result['due_date']);
        $remainingDays = ceil(($dueDate - time()) / (60 * 60 * 24));
        return $remainingDays;
    }

    /**
     * (DELETE) méthode pour supprimer un goal
     * 
     * @param int $goalId id du goal à supprimer
     * @return void 
     */
    public function deleteGoal($goalId): void
    {
        $query = $this->_pdo->prepare("DELETE FROM goals WHERE id = :id");
        $query->bindValue(':id', $goalId, PDO::PARAM_INT);
        $query->execute();
    }

    /**
     * (COMPLETE) méthode pour check un goal
     *  
     * @param int $goalID id du goal complété
     * @return void 
     */
    public function completeGoal(int $goalId): void
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
    public function expiredGoal($goalId): void
    {
        $query = $this->_pdo->prepare("UPDATE goals SET statute = 2 WHERE id = :id");
        $query->execute([
            ':id' => $goalId
        ]);
    }


    /**
     * (BOARDING HOME) méthode pour afficher les goals dont la date est égale ou inférieur a evolution_day
     * 
     * @param int $id_procrastimon id du procrastimon
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

// AFFICHAGE DES CATEGORIES
function displayCategory($category)
{
    if ($category === 1) {
        echo '<button class="btn body" disabled><img src="https://img.icons8.com/ios-glyphs/25/FFFFFF/fire-heart.png"/></button>';
    } elseif ($category === 2) {
        echo '<button class="btn mind" disabled><img src="https://img.icons8.com/pastel-glyph/25/FFFFFF/lotus--v1.png"/></button>';
    } elseif ($category === 3) {
        echo '<button class="btn work" disabled><img src="https://img.icons8.com/sf-regular-filled/25/FFFFFF/business.png"/></button>';
    } elseif ($category === 4) {
        echo '<button class="btn other" disabled><img src="https://img.icons8.com/ios-glyphs/25/FFFFFF/more.png"/></button>';
    }
}
