<?php
require_once(__DIR__ . '/connectToDB.php');

if (!isset($_GET['id'])) { http_response_code(400); exit; }
$id = $_GET['id'];

$pdo = connectToDB();
$stmt = $pdo->prepare("SELECT backup_date FROM Backups WHERE id_objet = ? ORDER BY backup_date DESC LIMIT 1");
$stmt->execute([$id]);
$row = $stmt->fetch();

if ($row) {
    echo json_encode(['hasBackup' => true, 'date' => $row['backup_date']]);
} else {
    echo json_encode(['hasBackup' => false]);
}
?>