
<?php
require_once(__DIR__ . '/../Models/SignUpModele.php');
require_once(__DIR__ . '/../Models/connectToDB.php');
require_once(__DIR__ . '/../../vendor/autoload.php'); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $pdo = connectToDB();
    $stmt = $pdo->prepare("SELECT * FROM User WHERE token = :valtoken AND is_verified = 0");

    $stmt->execute([
        ':valtoken' => $token
    ]);
    $User = $stmt->fetch();

    if ($User) {
        $stmt = $pdo->prepare("UPDATE User SET is_verified = 1, token = NULL WHERE token = :valtoken");
        $stmt->execute([
            ':valtoken' => $token
        ]);
   $mailer = new PHPMailer(true);
try {
    $mailer->isSMTP();
    $mailer->Host = 'smtp.gmail.com';
    $mailer->SMTPAuth = true;
    $mailer->Username = 'pulsezonecompany@gmail.com';
    $mailer->Password = 'opvl fdon uvhr vftt'; 
    $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mailer->Port = 587;

    $mailer->setFrom('pulsezonecompany@gmail.com', 'PulseZone');
    $mailer->addAddress($User['mailUser']);
    $mailer->isHTML(true);
    $mailer->Subject = 'Compte valide';
    $mailer->Body = '
        <html>
        <head><title>Validation de votre inscription</title>
            <meta charset="UTF-8">
        </head>
        <body>
            <h1>Validation de votre inscription</h1>
            <p>Votre compte a été confirmé. Vous pouvez désormais vous connecter.</p>
            <p>Merci de votre confiance.</p>
            <p>
            L\'équipe de PulseZone.
        </p>        </body>
        </html>';
        $mailer->send();
            echo "<script>alert('Inscription réussie ! Vous pouvez vous connecter'); window.location.href = '../Controllers/LogIn.php';</script>";
            header("Location: ../Controllers/LogIn.php");
        exit();
} catch (Exception $e) {
    error_log("Erreur envoi mail confirmation : " . $mailer->ErrorInfo);
}
} else {
    echo "Aucun jeton fourni.";
}
}
