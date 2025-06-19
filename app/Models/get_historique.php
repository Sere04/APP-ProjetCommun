<?php
require_once __DIR__ . '/connectToDB.php';
$pdo = connectToDB();
$stmt = $pdo->query("SELECT timestamp, value FROM Occupation ORDER BY id DESC");
$historique = $stmt->fetchAll();
echo json_encode($historique);