
<?php

$title = "Se connecter";
$errors = array();
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
        $errors['login'] = "Erreur lors de l'identification. Login ($email) et/ou mot de passe incorrects. Si vous venez de vous inscrire, veuillez vérifier votre boîte mail pour valider votre compte."; 
    }
    else {
        session_start();
        $_SESSION['user'] = $account;
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['isAdmin'] = $account['isAdmin'];
        $_SESSION['isVerified'] = $account['isVerified'];
        $_SESSION['username'] = $account['username'];

        }

    if (empty($errors)) {    
     header("Location: ../Views/home.php");
        
    }
}


include_once(__DIR__ . '/../Views/LogInView.php');



