<?php
require_once __DIR__ . '/core/init.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Ismeretlen hiba.'];

// JAVÍTVA: 'name' ellenőrzése
if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password_confirm'])) {
    $response['message'] = 'Minden mező kitöltése kötelező.';
    echo json_encode($response);
    exit;
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $response['message'] = 'Érvénytelen email formátum.';
    echo json_encode($response);
    exit;
}

if ($_POST['password'] !== $_POST['password_confirm']) {
    $response['message'] = 'A két jelszó nem egyezik.';
    echo json_encode($response);
    exit;
}

// JAVÍTVA: Csak az email egyediségét ellenőrizzük, mivel a 'name' nem egyedi kulcs
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$_POST['email']]);
if ($stmt->fetch()) {
    $response['message'] = 'Ez az email cím már foglalt.';
    echo json_encode($response);
    exit;
}

// JAVÍTVA: A 'name' oszlopba mentünk
$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");

if ($stmt->execute([$_POST['name'], $_POST['email'], $password_hash])) {
    // JAVÍTVA: A session-be a 'name' kerül
    $_SESSION['user_id'] = $pdo->lastInsertId();
    $_SESSION['username'] = $_POST['name'];
    $response['success'] = true;
    $response['message'] = 'Sikeres regisztráció!';
} else {
    $response['message'] = 'Adatbázis hiba történt a regisztráció során.';
}

echo json_encode($response);