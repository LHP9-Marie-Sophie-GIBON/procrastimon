<?php

class User
{
    private int $id;
    private string $login;
    private string $mail;
    private string $password;
    private int $total_goal_trophies;
    private int $total_todo_trophies;

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

    // méthode pour insérer un utilisateur dans la base de données
    public function insertUser()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("INSERT INTO users (login, mail, password) VALUES (:login, :mail, :password)");

        // exécution de la requête 
        $query->execute([
            ':login' => $this->login,
            ':mail' => $this->mail,
            ':password' => $this->password
        ]);
    }

    // méthode pour récupérer un utilisateur par son id
    public function getUserById()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("SELECT * FROM users WHERE id = :id");

        // exécution de la requête
        $query->execute([
            ':id' => $this->id
        ]);

        // récupération des données
        $data = $query->fetch(PDO::FETCH_ASSOC);

        // hydratation de l'objet
        $this->login = $data['login'];
        $this->mail = $data['mail'];
        $this->password = $data['password'];
    }

    // méthode pour récupérer un utilisateur par son login
    public function getUserByLogin()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("SELECT * FROM users WHERE login = :login");

        // exécution de la requête
        $query->execute([
            ':login' => $this->login
        ]);


        // vérification si l'utilisateur existe
        if ($query->rowCount() > 0) {
            // récupération des données
            $data = $query->fetch(PDO::FETCH_ASSOC);

            // hydratation de l'objet
            $this->id = $data['id'];
            $this->mail = $data['mail'];
            $this->password = $data['password'];

            return $data;
        } else {
            return false;
        }
    }

    // méthode pour vérifier que le login et le mail n'existe pas déja
    public function checkLogin()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("SELECT * FROM users WHERE login = :login OR mail = :mail");

        // exécution de la requête
        $query->execute([
            ':login' => $this->login,
            ':mail' => $this->mail
        ]);

        // check if any rows were returned from the query
        $data = $query->fetch(PDO::FETCH_ASSOC);
        // return whether a user was found with the given login or email
        return $data !== false;
    }

    // méthode pour se connecter à son compte
    public function login($user, $procrastimon, $sprite)
    {
        $user->id = $_SESSION['user_id'];
        $user->getUserById();

        $procrastimon->id_users = $_SESSION['user_id'];
        $procrastimon->getLastProcrastimon();

        $sprite->id = $procrastimon->id_sprites;
        $sprite->getSpriteById();
    }

    public function updateUser()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("UPDATE users SET login = :login, mail = :mail WHERE id = :id");

        // binding des paramètres
        $query->bindValue(':login', $this->login, PDO::PARAM_STR);
        $query->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $query->bindValue(':id', $this->id, PDO::PARAM_INT);

        // exécution de la requête
        $query->execute();
    }

    // méthode pour update le password
    public function updatePassword()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("UPDATE users SET password = :password WHERE id = :id");

        // exécution de la requête
        $query->execute([
            ':password' => $this->password,
            ':id' => $this->id
        ]);
    }

    // méthode pour supprimer l'utilisateur
    public function deleteUser()
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("DELETE FROM users WHERE id = :id");

        // exécution de la requête
        $query->execute([
            ':id' => $this->id
        ]);
    }

    // méthode pour ajouter un trophée à un utilisateur
    public function addTrophy($total_trophies)
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("UPDATE users SET $total_trophies = $total_trophies+1 WHERE id = :id");
        $query->execute([
            ':id' => $this->id
        ]);
    }

    // méthode pour récupérer le nombre de trophées d'un utilisateur
    public function getTotalTrophies($total_trophies)
    {
        // préparation de la requête
        $query = $this->_pdo->prepare("SELECT $total_trophies FROM users WHERE id = :id");
        $query->execute([
            ':id' => $this->id
        ]);

        // récupération des données
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
