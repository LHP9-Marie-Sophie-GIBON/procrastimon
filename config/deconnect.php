<?php
session_start();
session_unset();
session_destroy();
header("Location: ../index.php"); // Rediriger l'utilisateur vers la page d'accueil
exit;
