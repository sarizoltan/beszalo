<?php
// Core rendszer betöltése
require_once __DIR__ . '/core/init.php';

// --- ADATOK LEKÉRDEZÉSE AZ OLDALHOZ ---

// 1. Oldal címe
$page_title = "Összes termék";

// 2. Szűrőhöz szükséges adatok lekérdezése

// === JAVÍTÁS 1: Ár lekérdezés alias-ok javítása ===
// A sablon 'min_price' és 'max_price' neveket vár, nem 'min_p' és 'max_p'-t.
$price_range_stmt = $pdo->query("SELECT MIN(price) as min_price, MAX(price) as max_price FROM products WHERE is_visible = 1");
$price_range = $price_range_stmt->fetch();

// === JAVÍTÁS 2: Kategóriák lekérdezése a termékszámmal együtt ===
// A sablon elvárja a 'product_count' értéket minden kategóriához.
$all_categories_stmt = $pdo->query("
    SELECT 
        c.id, 
        c.name, 
        (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id AND p.is_visible = 1) as product_count
    FROM 
        categories c
    ORDER BY 
        c.name ASC
");
$all_categories = $all_categories_stmt->fetchAll();

// A többi szűrő adat lekérdezése változatlan
$all_manufacturers = $pdo->query("SELECT id, name FROM manufacturers ORDER BY name ASC")->fetchAll();
$all_tags = $pdo->query("SELECT id, name FROM tags ORDER BY name ASC")->fetchAll();


// 3. Kezdeti terméklista lekérdezése (az összes látható termék)
$products_stmt = $pdo->query("SELECT * FROM products WHERE is_visible = 1 ORDER BY created_at DESC");
$products = $products_stmt->fetchAll();


// --- MEGJELENÍTÉS ---

// Betöltjük a közös fejlécet
include __DIR__ . '/includes/header.php';

// Betöltjük a terméklistázó sablont.
include __DIR__ . '/templates/product-listing.php';

// Betöltjük a közös láblécet
include __DIR__ . '/includes/footer.php';
?>