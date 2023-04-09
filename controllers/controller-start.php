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
        
        $arrayErrors = [];
        $missing =  "<span class='danger'><i class='bi bi-exclamation-circle-fill'></i></span>";
        $wrong = "<span class='danger'><i class='bi bi-x-circle-fill'></i></span>";
        
        // Vérification du pseudo
        if (isset($_POST['login'])) {
            $login = $_POST['login'];
        }
        if (empty($login)) { // Si le pseudo est vide, on envoie une erreur
            $arrayErrors['login'] = $missing;
            $arrayErrors['login-error'] = 'Login required';
            $arrayErrors['danger'] = 'text-danger' ;
            
        }

        // Vérification du mail
        if (isset($_POST['mail'])) {
            $mail = $_POST['mail'];
        }
        if (empty($mail)) { // Si le mail est vide, on envoie une erreur
            $arrayErrors['mail'] =  $missing;
            $arrayErrors['mail-error'] = 'Mail required';
            $arrayErrors['danger'] = 'text-danger' ;
        } else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) { // Si le mail n'est pas valide, on envoie une erreur
            $arrayErrors['mail'] = $wrong;
            $arrayErrors['mail-error'] = 'Mail not valid';
            $arrayErrors['danger'] = 'text-danger' ;
        }

        // Vérification du mot de passe
        if (isset($_POST['password'])) {
            $password = $_POST['password'];
            if (strlen($password) < 8) { // Si le mot de passe a moins de 8 caractères, on envoie une erreur
                $arrayErrors['password'] = $wrong;
                $arrayErrors['password-error'] = 'Password must contain 8 characters';
                $arrayErrors['danger'] = 'text-danger' ;
            } else if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) { // Si le mot de passe ne contient pas au moins une lettre et un chiffre, on envoie une erreur
                $arrayErrors['password'] = $wrong;
                $arrayErrors['password-error'] = 'Password must contain one letter and one number';
                $arrayErrors['danger'] = 'text-danger' ;
            }
        }
        if (empty($password)) { // Si le mot de passe est vide, on envoie une erreur
            $arrayErrors['password'] = $missing;
            $arrayErrors['password-error'] = 'Password required';
            $arrayErrors['danger'] = 'text-danger' ;
        }

        // Vérification de la confirmation de mot de passe
        if (isset($_POST['confirm-password'])) {
            $confirmPassword = $_POST['confirm-password'];
            // vérification que confirm-password est identique à password
            if ($confirmPassword !== $password) {
                $arrayErrors['confirm-password'] = $wrong;
                $arrayErrors['confirm-password-error'] = 'Passwords do not match';
                $arrayErrors['danger'] = 'text-danger' ;
            }
        }
        if (empty($confirmPassword)) { // Si le mot de passe est vide, on envoie une erreur
            $arrayErrors['confirm-password'] = $missing;
            $arrayErrors['confirm-password-error'] = 'Password required';
            $arrayErrors['danger'] = 'text-danger' ;
        }

        // Vérification du nom du procrastimon
        if (isset($_POST['procrastimon'])) {
            $name = $_POST['procrastimon'];
        }
        if (empty($name)) { // Si le nom du procrastimon est vide, on envoie une erreur
            $arrayErrors['procrastimon'] = $missing;
            $arrayErrors['procrastimon-error'] = 'Procrastimon name required';
            $arrayErrors['danger'] = 'text-danger' ;
        }

      
        // si arrayErrors est vide, le formulaire est envoyé
        if (empty($arrayErrors)) {

            $Captcha = new Login();
            $Captcha->verifyCaptcha();


            if (empty($login->errors)) {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // hachage du mot de passe

                $user = new User();
                $user->login = $login;
                $user->mail = htmlspecialchars($mail);
                $user->password = $hashedPassword;


                if ($user->checkLogin()) { // on vérifie si le pseudo et le mail est déjà utilisé
                    $arrayErrors['login-error'] = "Login already exists";
                    $arrayErrors['danger'] = 'text-danger' ;
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

                    header('Location: home.php?tutorial');
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

    $errorsLogin = [];
    $missing = "<span class='danger error-message'><i class='bi bi-exclamation-circle-fill'></i></span>";
    $wrong = "<span class='danger error-message'><i class='bi bi-x-circle-fill'></i></span>";

    // si les champs sont vide : echo "erreur"
    if (empty($_POST['user']) || empty($_POST['user-password'])) {
        $errorsLogin['danger'] = 'text-danger'; 
        $errorsLogin['login'] = $missing;
        $errorsLogin['Login-error'] = 'Login required';
        $errorsLogin['password'] = $missing;
        $errorsLogin['password-error'] = 'Password required';

    } else if (isset($_POST['user']) && isset($_POST['user-password'])) {
        $login = $_POST['user'];
        $password = $_POST['user-password'];

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

                header('Location: home.php');
                exit;
            } else {
                $errorsLogin['password'] = $wrong;
                $errorsLogin['password-errors'] = 'Wrong password';
            }
        } else {
            // Authentification échouée : afficher un message d'erreur
            $errorsLogin['login'] = $wrong;
            $errorsLogin['password'] = $wrong;
            $success = false;
        }
    }
}


include '../views/view-start.php';
