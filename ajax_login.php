<?php
require_once __DIR__ . '/core/init.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Ismeretlen hiba.'];

if (empty($_POST['email']) || empty($_POST['password'])) {
    $response['message'] = 'Minden mező kitöltése kötelező.';
    echo json_encode($response);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$_POST['email']]);
$user = $stmt->fetch();

if ($user && password_verify($_POST['password'], $user['password'])) {
    // JAVÍTVA: A session 'username' kulcsába a 'name' oszlop értékét tesszük
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['name'];
    
    $response['success'] = true;
    $response['message'] = 'Sikeres bejelentkezés!';
} else {
    $response['message'] = 'Hibás email cím vagy jelszó.';
}

echo json_encode($response);