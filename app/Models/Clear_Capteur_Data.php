<?php
require_once(__DIR__ . '/connectToDB.php');
if (!isset($_GET['id'])) { http_response_code(400); exit; }
$pdo = connectToDBALL();
$stmt = $pdo->prepare("DELETE FROM mesures WHERE id_objet = ?");
$stmt->execute([$_GET['id']]);
echo json_encode(['success'=>true]);
?>