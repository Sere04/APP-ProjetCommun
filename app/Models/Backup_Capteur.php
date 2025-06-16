<?php
require_once(__DIR__ . '/connectToDB.php');

if (!isset($_GET['id'])) { http_response_code(400); exit; }
$id = $_GET['id'];

// Connexion à la BDD G2C
$pdo = connectToDB();

// Création de la table si elle n'existe pas
$pdo->exec("
    CREATE TABLE IF NOT EXISTS Backups (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_objet INT NOT NULL,
        backup_data LONGTEXT NOT NULL,
        backup_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    )
");

// Récupère les données du capteur depuis la BDD G2
$pdoG2 = connectToDBALL();
$stmt = $pdoG2->prepare("SELECT valeur_mesure, date_mesure FROM mesures WHERE id_objet = ? ORDER BY date_mesure ASC");
$stmt->execute([$id]);
$data = $stmt->fetchAll();

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Aucune donnée à sauvegarder']);
    exit;
}

// Sauvegarde dans la table Backups
$stmt = $pdo->prepare("INSERT INTO Backups (id_objet, backup_data) VALUES (?, ?)");
$stmt->execute([$id, json_encode($data)]);

echo json_encode(['success' => true, 'message' => 'Backup effectuée']);
?>