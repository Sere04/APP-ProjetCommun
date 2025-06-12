
<?php

session_start();

$title = "Inscription";
$errors = array();
$isAuthPage = true;

//require_once '.../Models/SignUpModele.php';
require_once(__DIR__ . '/Check_SignUp.php');
require_once(__DIR__ . '/../Models/SignUpModele.php');


$nom = $email = $telephone = $prenom = $motDePasse = $pseudonyme = "";

if (isset($_POST) && count($_POST) > 0) {
    $nom = test_input(data: $_POST["nom"]);
    $prenom = test_input($_POST["prenom"]);
    $motDePasse = test_input($_POST["motDePasse"]);
    $motDePasseConfirmed = test_input($_POST["motDePasseConfirmed"]);
    $pseudonyme = test_input($_POST["pseudonyme"]);
    $email = test_input($_POST["email"]);
    $telephone = test_input($_POST["telephone"]);

    $validateEmail = validateEmail($email);
    $validateEmailUnique = uniqueMail($email);
    $validatePhone = validateTelephone($telephone);
    $validatePassword = validatePassword($motDePasse);
    $hashedPassword = validatePassword($motDePasse);
    $validateLengthNom = lengthNom($nom);
    $validateLengthPrenom = lengthPrenom($prenom);
    $validateLengthPseudonyme = lengthPseudonyme($pseudonyme);
    $validatePseudonymeUnique = uniquePseudonyme($pseudonyme);

    if (!$validateEmail) {
        $errors['email'] = "Veuillez saisir un mail valide.";
    }
    if (!$validateEmailUnique) {
        $errors['email'] = "Ce mail existe déjà";
    }
    if (!$validatePhone) {
        $errors['telephone'] = "Veuillez saisir un téléphone valide";
    }
    if (!$validatePassword) {
        $errors['motDePasse'] = "Veuillez saisir un mot de passe valide.</br> Il doit contenir au moins :</br>"
            . '- Un chiffre.</br>'
            . "- Une majuscule.</br>"
            . "- Une minuscule.</br>"
            . "- Un caractère spécial (#?!@$%^&*-).</br>"
            . "- Longueur minimale de 8 caractères.";
    }
    if (!$validateLengthNom) {
        $errors['nom'] = "Veuillez saisir un nom avec moins de 50 caractères";
    }
    if (!$validateLengthPrenom) {
        $errors['prenom'] = "Veuillez saisir un prénom avec moins de 50 caractères";
    }
    if (!$validateLengthPseudonyme) {
        $errors['pseudonyme'] = "Veuillez saisir un pseudonyme avec moins de 50 caractères";
    }
    if (!$validatePseudonymeUnique) {
        $errors['pseudonymeUnique'] = "Ce pseudonyme existe déjà, veuillez en créer un nouveau";
    }
    if ($motDePasse !== $motDePasseConfirmed) {
        $errors['ConfirmdPassword'] = "Les mots de passe ne correspondent pas";
    }

    if (!isset($_POST['prenom'])|| empty(trim($_POST['prenom']))) {
        $errors['prenom'] = "Le champ prenom est obligatoire";
    }
    if (!isset($_POST['nom'])|| empty(trim($_POST['nom']))) {
        $errors['nom'] = "Le champ nom est obligatoire";
    }
    if (!isset($_POST['pseudonyme'])|| empty(trim($_POST['pseudonyme']))) {
        $errors['pseudonyme'] = "Le champ pseudonyme est obligatoire";
    }
    if (!isset($_POST['email'])|| empty(trim($_POST['email']))) {
        $errors['email'] = "Le champ email est obligatoire";
    }


    if (empty($errors)) {
        if ($validateEmail && $validatePhone && $validatePassword) {
            $hashedPassword = hashPassword($motDePasse);
            $token = bin2hex(random_bytes(16));
            $result = insertUser($prenom, $nom, $email, $pseudonyme, $hashedPassword, $telephone, $token);
            if ($result) {
                $_SESSION['success'] = "Inscription réussie ! Veuillez vérifier votre email pour valider votre compte.";
            } else {
                $errors['database'] = "Erreur lors de l'inscription, veuillez réessayer plus tard.";
            }

             $to = $email;
             $validationLink = "./validateMail.php?token=$token";
             $from = "no-reply@pulseZone.fr";
             $subject = "[PulseZone] Confirmation d'inscription";
             $message = "
                 <html>
                     <head>
                         <title>Inscription</title>
                     </head>
        
                     <body>
                         <h1>Confirmez votre inscription</h1><br>
                         <button><a href=\"" . $validationLink . "\">Confirmez</a></button><br><br>
                         <p>Cliquez sur le lien pour confirmer votre mail: <a href=\"" . $validationLink . "\">ici</a>.</p><br><br>
                         <p>Merci de votre confiance.</p><br>
                         <p>L'équipe de MakerHub.</p>
                     </body>
                 </html>
                 ";

             $headers = "From: " . $from . "\r\n" .
                 "Content-Type: text/html; charset=UTF-8\r\n" .
                 "MIME-Version: 1.0\r\n";

             if (mail($to, $subject, $message, $headers)) {
                 echo '<script>alert("Email sent successfully !")</script>';
             } else {
                 echo "Failed to send email.";
             }
            header("Location: ../Views/home.php");
        }
    }
}
include_once(__DIR__ . '/../Views/SignUpView.php');


