<?php
require_once(__DIR__ . '/connectToDB.php');
if (!isset($_GET['id'], $_GET['name'])) { http_response_code(400); exit; }
$pdo = connectToDBALL();
$stmt = $pdo->prepare("UPDATE capteur_actionneur SET description = ? WHERE id_objet = ?");
$stmt->execute([$_GET['name'], $_GET['id']]);
echo json_encode(['success'=>true]);
?>