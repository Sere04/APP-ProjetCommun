<?php
require_once(__DIR__ . '/connectToDB.php');

header('Content-Type: application/json');

$pdo = connectToDB();

$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action === 'list') {
    $stmt = $pdo->query("SELECT IDUser, firstName, lastName, mailUser, userName, phoneNumber, Permission, is_verified FROM User");
    echo json_encode($stmt->fetchAll());
    exit;
}

if ($action === 'add') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) { http_response_code(400); echo json_encode(['error'=>'Invalid data']); exit; }
    $hashed = password_hash($data['motDePasse'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO User (firstName, lastName, mailUser, userName, motDePasse, phoneNumber, Permission, is_verified) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
    $stmt->execute([$data['firstName'], $data['lastName'], $data['mailUser'], $data['userName'], $hashed, $data['phoneNumber'], $data['Permission']]);
    echo json_encode(['success'=>true]);
    exit;
}

if ($action === 'delete') {
    $id = $_POST['id'] ?? $_GET['id'] ?? null;
    if (!$id) { http_response_code(400); echo json_encode(['error'=>'Missing id']); exit; }
    $stmt = $pdo->prepare("DELETE FROM User WHERE IDUser = ?");
    $stmt->execute([$id]);
    echo json_encode(['success'=>true]);
    exit;
}

if ($action === 'update') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data || !isset($data['IDUser'])) { http_response_code(400); echo json_encode(['error'=>'Invalid data']); exit; }
    $fields = [];
    $params = [];
    foreach (['firstName','lastName','mailUser','userName','phoneNumber','Permission','is_verified'] as $f) {
        if (isset($data[$f])) { $fields[] = "$f=?"; $params[] = $data[$f]; }
    }
    if ($fields) {
        $params[] = $data['IDUser'];
        $stmt = $pdo->prepare("UPDATE User SET ".implode(',',$fields)." WHERE IDUser=?");
        $stmt->execute($params);
    }
    echo json_encode(['success'=>true]);
    exit;
}

if ($action === 'changepass') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data || !isset($data['IDUser'], $data['motDePasse'])) { http_response_code(400); echo json_encode(['error'=>'Invalid data']); exit; }
    $hashed = password_hash($data['motDePasse'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE User SET motDePasse=? WHERE IDUser=?");
    $stmt->execute([$hashed, $data['IDUser']]);
    echo json_encode(['success'=>true]);
    exit;
}

echo json_encode(['error'=>'Unknown action']);