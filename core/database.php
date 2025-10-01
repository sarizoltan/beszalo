<?php
// Ez a fájl a core/init.php-n keresztül töltődik be, ami már betöltötte a config.php-t.

// Adatbázis-kapcsolat létrehozása PDO-val (biztonságosabb, mint a mysqli)
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (\PDOException $e) {
    // Fejlesztés alatt kiírjuk a hibát, éles környezetben naplózni kellene.
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>