
<?php
session_start();

$title = "Contact";
$errors = array();
$isAuthPage = true;
if (!isset($_SESSION['user'])) {
    $_SESSION['login_required'] = true;
    header("Location: ../Controllers/LogIn.php");
    exit();
}

//require_once '.../Models/SignUpModele.php';
require_once(__DIR__ . '/../../vendor/autoload.php'); 
require_once(__DIR__ . '/Check_SignUp.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$name = $email = $message = "";

if (isset($_POST) && count($_POST) > 0) {
    $name = test_input(data: $_POST["name"]);
    $email = test_input($_POST["email"]);
    $message = test_input($_POST["message"]);



    if (!isset($_POST['name'])|| empty(trim($_POST['name']))) {
        $errors['name'] = "Le champ Nom est obligatoire";

    }
    if (!isset($_POST['message'])|| empty(trim($_POST['message']))) {
        $errors['message'] = "Le champ message est obligatoire";
    }

    if (!isset($_POST['email'])|| empty(trim($_POST['email']))) {
        $errors['email'] = "Le champ email est obligatoire";
    }


    if (empty($errors)) {
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
                    $mail->addReplyTo($email, $name);
                    $mail->addAddress('pulsezonecompany@gmail.com', 'PulseZone'); 
                    $mail->Subject = "[PulseZone] Nouveau message de contact";
                    $mail->isHTML(true);
                    $mail->Body = "
    <html>
        <head>
            <title>Contact</title>
            <meta charset='UTF-8'>
        </head>
        <body>
            <h1>Besoin d'aide</h1>
            <p>Bonjour l'équipe de PulseZone,</p>
            <p>$message</p>
            <br>
            <p>
            Cordialement,<br>
            $name
            </p>
        </body>
    </html>";

                    $mail->send();
                    echo "<script>alert('Mail envoyé! Vous aurez une réponse dans un bref délai'); window.location.href = '../Views/home.php';</script>";
                    exit();
                } catch (Exception $e) {
                        $errorMessage = "L'email n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}";
                    echo "<script>console.error('$errorMessage');</script>";
                }
            
            header("Location: ../Views/home.php");
            
    }
}

include_once(__DIR__ . '/../Views/ContactPageView.php');
?>


