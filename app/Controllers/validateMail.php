
<?php
require_once(__DIR__ . '/../Models/SignUpModele.php');
require_once(__DIR__ . '/../Models/connectToDB.php');


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
    $to = $User['mail'];
    $subject = 'Compte validé';
    $message = "<html>
                    <head>
                        <title>Inscription</title>
                    </head>
        
                    <body>
                        <h1>Validation de votre inscription</h1><br>
                        <p>Votre compte a été confirmé. Maintenant vous pouvez vous connecter.</p><br><br>
                        <p>Merci de votre confiance.</p><br>
                        <p>L'équipe de PulseZone.</p>
                    </body>
                </html>";
    $from = "no-reply@pulseZone.fr";
    $headers = "From: " . $from . "\r\n" . 
                        "Content-Type: text/html; charset=UTF-8\r\n" .
                        "MIME-Version: 1.0\r\n";
    mail($to, $subject, $message, $headers);
        header("Location: ./LogIn.php"); 
    } else {
        echo "Lien de validation invalide ou déjà utilisé.";
    }
} else {
    echo "Aucun jeton fourni.";
}
