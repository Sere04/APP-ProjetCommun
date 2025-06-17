<?php
session_start();

$title = "Reset password";
$errors = array();
$isAuthPage = true;


//require_once '.../Models/SignUpModele.php';
require_once(__DIR__ . '/Check_SignUp.php');
require_once(__DIR__ . '/../Models/RestorePasswordModele.php');
$email =  $motDePasse = $pseudonyme = "";

if (isset($_POST) && count($_POST) > 0) {
    $motDePasse = test_input($_POST["motDePasse"]);
    $motDePasseConfirmed = test_input($_POST["motDePasseConfirmed"]);
    $pseudonymeOuMail = test_input($_POST["emailOrUsername"]);

    $validatePassword = validatePassword($motDePasse);
    $hashedPassword = validatePassword($motDePasse);

  
    if (!$validatePassword) {
        $errors['motDePasse'] = "Veuillez saisir un mot de passe valide.</br> Il doit contenir au moins :</br>"
            . '- Un chiffre.</br>'
            . "- Une majuscule.</br>"
            . "- Une minuscule.</br>"
            . "- Un caractère spécial (#?!@$%^&*-).</br>"
            . "- Longueur minimale de 8 caractères.";
    }
    if ($motDePasse !== $motDePasseConfirmed) {
        $errors['ConfirmdPassword'] = "Les mots de passe ne correspondent pas";
    }
    if (!isset($_POST['emailOrUsername'])|| empty(trim($_POST['emailOrUsername']))) {
        $errors['pseudonyme'] = "Le champ pseudonyme est obligatoire";
    }

    if (empty($errors)) {
        if ($validatePassword) {
            $hashedPassword = hashPassword($motDePasse);
            $result = updatePassword($pseudonymeOuMail, $hashedPassword);
           if ($result) {
                $_SESSION['success'] = "Inscription réussie ! Veuillez vérifier votre email pour valider votre compte.";

                    echo "<script>alert('Modification réussie ! '); window.location.href = '../Views/home.php';</script>";
                    exit();
            } else {
                $errors['database'] = "Erreur lors de la modification, veuillez réessayer plus tard.";
            }
            header("Location: ../Views/home.php");
        }
    }
}

include_once(__DIR__ . '/../Views/RestorePasswordView.php');
