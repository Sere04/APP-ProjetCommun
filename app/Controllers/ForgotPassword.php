<?php

$title = "Mot de passe oublié";
$errors = array();
$successMessage = "";

require_once(__DIR__ . '/../../vendor/autoload.php'); 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST) && isset($_POST['email'])) {
    $email = trim($_POST['email']);   
     if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Veuillez saisir une adresse email valide.";
    } else {
    $token = bin2hex(random_bytes(16));
    $resetLink = "https://pulsezone.leroymeunier.fr/APP-ProjetCommun/app/Controllers/resetPassword.php?token=" . urlencode($token);
        // $resetLink = "http://localhost/APP-ProjetCommun/app/Controllers/resetPassword.php?token=" . urlencode($token);



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
        $mail->Subject = '[PulseZone] Réinitialisation du mot de passe';
        $mail->Body = "
        <html>
            <head><meta charset='UTF-8'></head>
            <body>
                <h2>Réinitialisation de votre mot de passe</h2>
                <p>Bonjour,</p>
                <p>Pour réinitialiser votre mot de passe, cliquez sur le lien suivant :</p>
                <p><a href='$resetLink'>Réinitialiser mon mot de passe</a></p>
                <p>Ce lien expirera dans 30 minutes.</p>
                <p>— L'équipe PulseZone</p>
            </body>
        </html>";
        $mail->send();
    } catch (Exception $e) {
        $errors['email'] = "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
    }
}
$successMessage = "Si un compte est associé à cette adresse email, un lien de réinitialisation vous a été envoyé.";
}

include_once(__DIR__ . '/../Views/ForgotPasswordView.php');
