<?php

$title = "Mot de passe oublié";
$errors = array();
$successMessage = "";

if (isset($_POST) && isset($_POST['email'])) {
    $email = trim($_POST['email']);

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Veuillez saisir une adresse email valide.";
    } else {
        $successMessage = "Si un compte est associé à cette adresse email, un lien de réinitialisation vous a été envoyé.";
    }
}
include_once(__DIR__ . '/../Views/ForgotPasswordView.php');

