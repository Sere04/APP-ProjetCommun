<?php

session_start();

$maxAttempts = 5;
$lockoutTime = 300; // 5 minutes

$errors = array();

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = 0;
}

// Check if user is locked out
if ($_SESSION['login_attempts'] >= $maxAttempts) {
    $remaining = $lockoutTime - (time() - $_SESSION['last_attempt_time']);
    if ($remaining > 0) {
        $errors['login'] = "Trop de tentatives de connexion. Veuillez réessayer dans " . ceil($remaining / 60) . " minutes.";
        include_once(__DIR__ . '/../Views/LogInView.php');
        exit;
    } else {
        // Reset attempts after lockout period
        $_SESSION['login_attempts'] = 0;
    }
}

$title = "Se connecter";
$isAuthPage = true;

if (isset($_POST) && count($_POST) > 0) {
    if (!isset($_POST['emailOrUsername'])|| empty(trim($_POST['emailOrUsername']))) {
        $errors['emailOrUsername'] = "Veuillez remplir tous les champs";
    }
    if (!isset($_POST['password'])|| empty(trim($_POST['password']))) {
        $errors['emailOrUsername'] = "Veuillez remplir tous les champs";
    }

    $email = htmlentities($_POST['emailOrUsername']);
    $password = htmlentities($_POST['password']);

    require_once(__DIR__ . '/Check_LogIn.php');
    $account = areCrendentialsCorrect($email, $password);

    if (!$account) {
        $_SESSION['login_attempts']++;
        $_SESSION['last_attempt_time'] = time();
        $errors['login'] = "Erreur lors de l'identification. Login ($email) et/ou mot de passe incorrects. Si vous venez de vous inscrire, veuillez vérifier votre boîte mail pour valider votre compte."; 
    }
    else {
        $_SESSION['login_attempts'] = 0; // Reset on success
        $_SESSION['user'] = $account;
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['isVerified'] = $account['isVerified'];
        $_SESSION['username'] = $account['username'];
        $_SESSION['Permission'] = $account['Permission'];
    }

    if (empty($errors)) {    
        header("Location: ../Views/home.php");
        exit;
    }
}

include_once(__DIR__ . '/../Views/LogInView.php');



