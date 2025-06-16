<?php
require_once(__DIR__ . '/connectToDB.php');

if (!isset($_GET['id'])) { http_response_code(400); exit; }
$id = $_GET['id'];

// Connexion à la BDD G2C
$pdo = connectToDB();

// Récupère la dernière backup
$stmt = $pdo->prepare("SELECT backup_data FROM Backups WHERE id_objet = ? ORDER BY backup_date DESC LIMIT 1");
$stmt->execute([$id]);
$row = $stmt->fetch();

if (!$row) {
    echo json_encode(['success' => false, 'message' => 'Aucune backup trouvée']);
    exit;
}

$data = json_decode($row['backup_data'], true);

// Restaure dans la BDD G2 (supprime les anciennes données puis insère la backup)
$pdoG2 = connectToDBALL();
$pdoG2->prepare("DELETE FROM mesures WHERE id_objet = ?")->execute([$id]);
$stmtInsert = $pdoG2->prepare("INSERT INTO mesures (id_objet, valeur_mesure, date_mesure) VALUES (?, ?, ?)");
foreach ($data as $mesure) {
    $stmtInsert->execute([$id, $mesure['valeur_mesure'], $mesure['date_mesure']]);
}

echo json_encode(['success' => true, 'message' => 'Backup restaurée']);
?>