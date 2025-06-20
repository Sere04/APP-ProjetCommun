<?php
require_once __DIR__ . '/connectToDB.php';

// Connexion à la BDD privée
$pdoPrivee = connectToDB();

// Connexion à la BDD publique
$pdoPublique = connectToDBALL();

// Synchronisation Occupation -> mesures
$id_objet = 4;

$privates = $pdoPrivee->query("SELECT timestamp, value FROM Occupation ORDER BY id ASC")->fetchAll();
foreach ($privates as $row) {
    // Ajoute 2h au timestamp avant insertion
    $date = new DateTime($row['timestamp']);
    $date->modify('+2 hours');
    $timestampPlus2h = $date->format('Y-m-d H:i:s');

    $stmt = $pdoPublique->prepare("SELECT COUNT(*) FROM mesures WHERE id_objet = ? AND date_mesure = ?");
    $stmt->execute([$id_objet, $timestampPlus2h]);
    if ($stmt->fetchColumn() == 0) {
        $stmtInsert = $pdoPublique->prepare("INSERT INTO mesures (id_objet, date_mesure, valeur_mesure) VALUES (?, ?, ?)");
        $stmtInsert->execute([$id_objet, $timestampPlus2h, $row['value']]);
    }
}

echo json_encode(['status' => 'ok']);
?>