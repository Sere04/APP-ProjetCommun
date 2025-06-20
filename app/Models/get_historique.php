<?php
require_once __DIR__ . '/connectToDB.php';
$pdo = connectToDB();
$stmt = $pdo->query("SELECT timestamp, value FROM Occupation ORDER BY id DESC");
$historique = $stmt->fetchAll();

// Ajout de 2h à chaque timestamp
foreach ($historique as &$h) {
    $date = new DateTime($h['timestamp']);
    $date->modify('+2 hours');
    $h['timestamp'] = $date->format('Y-m-d H:i:s');
}
unset($h);

echo json_encode($historique);