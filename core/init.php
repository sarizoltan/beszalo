<?php
// === HIBAKEZELŐ BEKAPCSOLÁSA (EZ LEGYEN AZ ELSŐ) ===
require_once __DIR__ . '/error_handler.php';

// TARTALOMBIZTONSÁGI IRÁNYELV (CSP)
// VÉGLEGES JAVÍTÁS: Hozzáadva a cdn.tiny.cloud a style-src-hez az admin editor miatt.
$cspHeader = "default-src 'self'; ";
$cspHeader .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdn.tiny.cloud; ";
$cspHeader .= "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com https://cdn.tiny.cloud; "; // <-- ITT A JAVÍTÁS
$cspHeader .= "font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net; ";
$cspHeader .= "img-src 'self' data: https: sp.tinymce.com; ";
$cspHeader .= "connect-src 'self' https://cdn.tiny.cloud; ";
$cspHeader .= "frame-src https://www.youtube.com https://player.vimeo.com;";
header("Content-Security-Policy: " . $cspHeader);


// SESSION INDÍTÁSA
// Biztonságos session beállítások
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_httponly', 1);
// Helyi fejlesztés alatt a 'secure' cookie nem szükséges, de élesben igen.
ini_set('session.cookie_secure', false); 
session_start();

// ADATBÁZIS KAPCSOLAT
$db_host = 'localhost';
$db_name = 'sp_store';
$db_user = 'root';
$db_pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$db_host;dbname=$db_name;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (\PDOException $e) {
    // A hibakezelőnk most már elkapja és szépen megjeleníti ezt a hibát is.
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// ... (a fájl eleje változatlan)

// ... (a fájl eleje változatlan)

// ALAP KONFIGURÁCIÓS VÁLTOZÓK
define('BASE_URL', 'http://localhost/sp_store');

// JAVÍTÁS: A PUBLIC_URL mostantól ugyanaz, mint a BASE_URL
define('PUBLIC_URL', BASE_URL); 

define('ADMIN_URL', BASE_URL . '/admin');

// JAVÍTÁS: A SITE_URL is a gyökérre mutat
define('SITE_URL', BASE_URL . '/'); 

// ... (a fájl többi része változatlan)

// ... (a fájl többi része változatlan)

// === ÚJ SOR KEZDETE ===
// Globális beállítások
define('VAT_RATE', 1.27);
// === ÚJ SOR VÉGE ===


// SEGÉDFÜGGVÉNYEK BEHÍVÁSA
require_once __DIR__ . '/functions.php';

?>