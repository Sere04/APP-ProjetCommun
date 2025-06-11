<?php
session_start();

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

ob_start();
include_once __DIR__ . '/../Views/LogIn.php';
$body = ob_get_clean();

include_once __DIR__ . '/../Views/components/template.php';