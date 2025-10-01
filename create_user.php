<?php

// Core rendszer betöltése
require_once __DIR__ . '/core/init.php';

echo '<!DOCTYPE html><html lang="hu"><head><meta charset="utf-8"><title>Felhasználó Létrehozó</title>';
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css"></head><body>';
echo '<h1>Új Admin Felhasználó Létrehozása</h1>';

try {
    // Új, garantáltan jó jelszó
    $new_password = 'teszt';
    $new_hash = password_hash($new_password, PASSWORD_DEFAULT);

    echo "<p>Az új jelszó: <strong>" . $new_password . "</strong></p>";
    echo "<p>A generált hash: " . $new_hash . "</p>";

    // Töröljük a régi, problémás felhasználót
    $pdo->exec("DELETE FROM users WHERE id = 1");
    echo "<p>Régi felhasználó (ID: 1) sikeresen törölve.</p>";

    // Hozzuk létre az új felhasználót a frissen generált hash-sel
    $stmt = $pdo->prepare("INSERT INTO users (id, name, email, password) VALUES (1, 'Test Admin', 'test@example.com', ?)");
    $stmt->execute([$new_hash]);

    echo "<h2>Sikeres!</h2>";
    echo "<p>Egy új felhasználó lett létrehozva a 'users' táblában a következő adatokkal:</p>";
    echo "<ul>";
    echo "<li><strong>E-mail:</strong> test@example.com</li>";
    echo "<li><strong>Jelszó:</strong> teszt</li>";
    echo "</ul>";
    echo '<p><a href="admin/login.php">Most próbálj meg bejelentkezni ezekkel az adatokkal!</a></p>';

} catch (Exception $e) {
    echo "<h2>Hiba történt!</h2>";
    echo "<p>A művelet nem sikerült: " . $e->getMessage() . "</p>";
}

echo '</body></html>';