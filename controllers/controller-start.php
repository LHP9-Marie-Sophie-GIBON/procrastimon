<?php
session_start();

require('../model/class-users.php');
require('../model/class-procrastimons.php');
require('../model/class-sprites.php');
require('../model/class-goals.php');
require('../model/class-todos.php');
require('../helper/database.php');
require('../config/connect.php');

$user = new User();
$procrastimon = new Procrastimon();
$sprite = new Sprite();

// BADGES
$goal = new Goal();
$todo = new Todo();
if (isset($_SESSION['user_id'])) {
    $goal->id_users = $_SESSION['user_id'];
    $todo->id_users = $_SESSION['user_id'];
    $numberOfGoals = $goal->countGoals(); //nombre de goals en cours
    $numberOfTodos = $todo->countTodos(); //nombre de todos en cours
}


$arrayErrors = [];
$missing =  "<span class='danger'><i class='bi bi-exclamation-circle-fill'></i></span>";
$wrong = "<span class='danger'><i class='bi bi-x-circle-fill'></i></span>";

// fonction verifyCaptcha
class Login
{
    public array $errors = [];
    public string $success = '';

    public function verifyCaptcha()
    {
        if (isset($_POST['g-recaptcha-response'])) {
            $captcha = $_POST['g-recaptcha-response'];
            $secretKey = "6Lfv6xwlAAAAAPMmumu7u1dZF6GVqwkEOWGOKuSS";
            $ip = $_SERVER['REMOTE_ADDR'];
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);
            $responseKeys = json_decode($response, true);
            var_dump($responseKeys);
            if ($responseKeys['score'] < 0.5) {
                $this->errors[] = 'Veuillez cocher la case "Je ne suis pas un robot"';
            }
            if (intval($responseKeys["success"]) !== 1) {
                $this->errors[] = 'Veuillez cocher la case "Je ne suis pas un robot"';
            } else {
                $this->success = 'Vous êtes un humain';
            }
        } else {
            $this->errors = 'Veuillez cocher la case "Je ne suis pas un robot"';
        }
    }
}


// Si le formulaire est envoyé, on vérifie les champs
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du pseudo
    if (isset($_POST['login'])) {
        $login = $_POST['login'];
    }
    if (empty($login)) { // Si le pseudo est vide, on envoie une erreur
        $arrayErrors['login'] = $missing;
    }

    // Vérification du mail
    if (isset($_POST['mail'])) {
        $mail = $_POST['mail'];
    }
    if (empty($mail)) { // Si le mail est vide, on envoie une erreur
        $arrayErrors['mail'] =  $missing;
    }

    // Vérification du mot de passe
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
        if (strlen($password) < 8) { // Si le mot de passe a moins de 8 caractères, on envoie une erreur
            $arrayErrors['password'] = $wrong;
        } else if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) { // Si le mot de passe ne contient pas au moins une lettre et un chiffre, on envoie une erreur
            $arrayErrors['password'] = $wrong;
        }
    }
    if (empty($password)) { // Si le mot de passe est vide, on envoie une erreur
        $arrayErrors['password'] = $missing;
    }

    // Vérification de la confirmation de mot de passe
    if (isset($_POST['confirm-password'])) {
        $confirmPassword = $_POST['confirm-password'];
        // vérification que confirm-password est identique à password
        if ($confirmPassword !== $password) {
            $arrayErrors['confirm-password'] = $wrong;
        }
    }
    if (empty($confirmPassword)) { // Si le mot de passe est vide, on envoie une erreur
        $arrayErrors['confirm-password'] = $missing;
    }

    // Vérification du nom du procrastimon
    if (isset($_POST['procrastimon'])) {
        $name = $_POST['procrastimon'];
    }
    if (empty($name)) { // Si le nom du procrastimon est vide, on envoie une erreur
        $arrayErrors['procrastimon'] = $missing;
    }

    // si arrayErrors est vide, le formulaire est envoyé
    if (empty($arrayErrors)) {

        $Captcha = new Login();
        $Captcha->verifyCaptcha();


        if (empty($login->errors)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // hachage du mot de passe

            $user = new User();
            $user->login = $login;
            $user->mail = $mail;
            $user->password = $hashedPassword;


            if ($user->checkLogin()) { // on vérifie si le pseudo et le mail est déjà utilisé
                $message = " already exists";
            } else { // on envoie les données dans la base de données
                $user->insertUser();

                session_start(); // création d'une variable de session 
                $_SESSION['user_id'] = $user->_pdo->lastInsertId();

                // vérification si l'utilisateur a été créé
                if ($user->_pdo->lastInsertId() > 0) {
                    //    on crée un nouveau procrastimon
                    $procrastimon = new Procrastimon();
                    $procrastimon->name = $_POST['procrastimon'];
                    $procrastimon->id_users = $user->_pdo->lastInsertId();

                    // on utilise la fonction getRandomStarter pour générer un sprite
                    $sprite = new Sprite();
                    $sprite->getRandomStarter();
                    $procrastimon->id_sprites = $sprite->id;

                    // on envoie les données dans la base de données
                    $procrastimon->insertProcrastimon();
                } else {
                    echo "échec de la création de l'utilisateur";
                }

                header('Location: controller-home.php');
                exit;
            }
        } else {
            $message = $login->errors[0];
        }
    }
}


if (isset($_SESSION['user_id'])) {
    $user->login($user, $procrastimon, $sprite);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $arrayErrors = [];
    $missing = "<span class='danger error-message'><i class='bi bi-exclamation-circle-fill'></i></span>";
    $wrong = "<span class='danger error-message'><i class='bi bi-x-circle-fill'></i></span>";

    // si les champs sont vide : echo "erreur"
    if (empty($_POST['login']) || empty($_POST['password'])) {
        $arrayErrors['login'] = $missing;
    } else if (isset($_POST['login']) && isset($_POST['password'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];

        // Vérifier si l'utilisateur existe	
        $user = new User();
        $user->login = $login;
        $user->getUserByLogin();
        $existingUser = $user->login;

        // Vérifier si le mot de passe est correct
        if ($existingUser) {
            if ($user && password_verify($password, $user->password)) {
                // Authentification réussie : enregistrer l'utilisateur dans la session et rediriger vers la page privée
                $_SESSION['user_id'] = $user->id;

                header('Location: controller-home.php');
                exit;
            } else {
                $arrayErrors['password'] = $wrong;
            }
        } else {
            // Authentification échouée : afficher un message d'erreur
            $arrayErrors['login'] = $wrong;
            $arrayErrors['password'] = $wrong;
            $success = false;
        }
    }
}
include '../views/view-start.php';
