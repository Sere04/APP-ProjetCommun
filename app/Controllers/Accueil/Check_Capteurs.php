<?php

// Connexion à la base de données (adapte les identifiants si besoin)
$host = '144.76.54.100';
$db   = 'G2';
$user = 'G2';
$pass = 'APPG2-BDD';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Récupère tous les capteurs/actionneurs
    $stmt = $pdo->query("SELECT id_objet, nom, description FROM capteur_actionneur");
    $capteurs = $stmt->fetchAll();

    $result = [];

    // Pour chaque capteur, récupère la dernière mesure
    foreach ($capteurs as $capteur) {
        $stmtMesure = $pdo->prepare(
            "SELECT valeur_mesure, date_mesure 
             FROM mesures 
             WHERE id_objet = ? 
             ORDER BY date_mesure DESC 
             LIMIT 1"
        );
        $stmtMesure->execute([$capteur['id_objet']]);
        $mesure = $stmtMesure->fetch();

        $result[] = [
            'id_objet'      => $capteur['id_objet'],
            'nom'           => $capteur['nom'],
            'description'   => $capteur['description'],
            'valeur_mesure' => $mesure['valeur_mesure'] ?? null,
            'date_mesure'   => $mesure['date_mesure'] ?? null
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($result);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

?>