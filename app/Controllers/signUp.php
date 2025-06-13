
<?php
session_start();

$title = "Inscription";
$errors = array();
$isAuthPage = true;


//require_once '.../Models/SignUpModele.php';
require_once(__DIR__ . '/Check_SignUp.php');
require_once(__DIR__ . '/../Models/SignUpModele.php');
require_once(__DIR__ . '/../../vendor/autoload.php'); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


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
            $validationLink = "http://localhost/APP-ProjetCommun/app/Controllers/validateMail.php?token=" . urlencode($token);
            $result = insertUser($prenom, $nom, $email, $pseudonyme, $hashedPassword, $telephone, $token);
           if ($result) {
                $_SESSION['success'] = "Inscription réussie ! Veuillez vérifier votre email pour valider votre compte.";

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'pulsezonecompany@gmail.com';
                    $mail->Password = 'opvl fdon uvhr vftt';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;  
              
                    $mail->setFrom('pulsezonecompany@gmail.com', 'PulseZone');
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = "[PulseZone] Confirmation d'inscription";
                    $mail->Body = "
    <html>
        <head>
            <title>Inscription</title>
            <meta charset='UTF-8'>
        </head>
        <body>
            <h1>Confirmez votre inscription</h1>
            <p>Bonjour $prenom $nom,</p>
            <p>Merci de votre inscription. Veuillez confirmer votre compte en cliquant sur le lien ci-dessous :</p>
            <p><a href='$validationLink'>Confirmer mon inscription</a></p>
            <br>
            <p>
            L'équipe de PulseZone.
            </p>
        </body>
    </html>";

                    $mail->send();
                    echo "<script>alert('Inscription réussie ! Un email de confirmation a été envoyé.'); window.location.href = '../Views/home.php';</script>";
                    exit();
                } catch (Exception $e) {
                        $errorMessage = "L'email n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}";
                    echo "<script>console.error('$errorMessage');</script>";
                }
            } else {
                $errors['database'] = "Erreur lors de l'inscription, veuillez réessayer plus tard.";
            }
            header("Location: ../Views/home.php");
        }
    }
}

include_once(__DIR__ . '/../Views/SignUpView.php');
?>


