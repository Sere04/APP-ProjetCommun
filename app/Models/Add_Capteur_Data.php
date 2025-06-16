<?php
require_once(__DIR__ . '/connectToDB.php');
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['id'], $data['valeur'])) { http_response_code(400); exit; }
$date = !empty($data['date']) ? $data['date'] : date('Y-m-d H:i:s');
$pdo = connectToDBALL();
$stmt = $pdo->prepare("INSERT INTO mesures (id_objet, valeur_mesure, date_mesure) VALUES (?, ?, ?)");
$stmt->execute([$data['id'], $data['valeur'], $date]);
echo json_encode(['success'=>true]);
?>