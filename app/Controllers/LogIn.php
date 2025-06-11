<?php

$title = "Connexion";
$errors = array();

if (isset($_POST) && count($_POST) > 0) {
    $emailOrUsername = $_POST["emailOrUsername"] ?? '';
    $password = $_POST["password"] ?? '';

    if (empty($emailOrUsername) || empty($password)) {
        $errors['form'] = "Veuillez remplir tous les champs.";
    } else {
        $errors['form'] = "Email/pseudo ou mot de passe incorrect.";
    }
}

include_once(__DIR__ . '/../Views/LogInView.php');


