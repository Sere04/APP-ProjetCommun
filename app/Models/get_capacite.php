<?php
require_once(__DIR__ . '/connectToDB.php');
$pdo = connectToDB();
$stmt = $pdo->query("SELECT value, timestamp FROM Occupation ORDER BY id DESC LIMIT 1");
$last = $stmt->fetch();
if ($last) {
    echo json_encode([
        'compteur' => intval($last['value']),
        'heure' => date('d/m/Y H:i:s', strtotime($last['timestamp']))
    ]);
} else {
    echo json_encode([
        'compteur' => 0,
        'heure' => 'Aucune mesure'
    ]);
}