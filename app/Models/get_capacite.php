<?php
require_once __DIR__ . '/connectToDB.php';
$pdo = connectToDB();
$stmt = $pdo->query("SELECT value, timestamp FROM Occupation ORDER BY id DESC LIMIT 1");
$last = $stmt->fetch();
if ($last) {
    // Ajout de 2h à la date
    $date = new DateTime($last['timestamp']);
    $date->modify('+2 hours');
    echo json_encode([
        'compteur' => intval($last['value']),
        'heure' => $date->format('d/m/Y H:i:s')
    ]);
} else {
    echo json_encode([
        'compteur' => 0,
        'heure' => 'Aucune mesure'
    ]);
}