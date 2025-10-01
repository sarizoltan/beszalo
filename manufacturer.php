<?php
require_once __DIR__ . '/core/init.php';
// --- ADATOK LEKÉRDEZÉSE ---

// 1. Gyártó azonosító az URL-ből
$manufacturer_id_from_url = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$manufacturer_id_from_url) {
    redirect(SITE_URL); // Ha nincs ID, irányítsuk a főoldalra
}

// 2. Aktuális gyártó adatainak lekérdezése (a címhez)
$man_stmt = $pdo->prepare("SELECT name FROM manufacturers WHERE id = ?");
$man_stmt->execute([$manufacturer_id_from_url]);
$manufacturer = $man_stmt->fetch();
if (!$manufacturer) {
    http_response_code(404);
    die("A gyártó nem található.");
}
$page_title = 'Termékek a következő gyártótól: ' . $manufacturer['name'];


// 3. Termékek lekérdezése az adott gyártótól
$products_stmt = $pdo->prepare("SELECT id, name, price, sale_price, image_path, created_at FROM products WHERE manufacturer_id = ? AND is_visible = 1 ORDER BY created_at DESC");
$products_stmt->execute([$manufacturer_id_from_url]);
$products = $products_stmt->fetchAll();


// 4. Szűrőkhöz szükséges adatok lekérdezése (ezek változatlanok)
$all_categories = $pdo->query("SELECT id, name, (SELECT COUNT(*) FROM products WHERE category_id = categories.id) as product_count FROM categories ORDER BY name ASC")->fetchAll();
$all_tags = $pdo->query("SELECT id, name FROM tags ORDER BY name ASC")->fetchAll();
$all_manufacturers = $pdo->query("SELECT id, name FROM manufacturers ORDER BY name ASC")->fetchAll();
$price_range = $pdo->query("SELECT MIN(price) as min_price, MAX(price) as max_price FROM products WHERE is_visible = 1")->fetch();

// --- MEGJELENÍTÉS ---
// Ugyanazokat a sablonokat használjuk, mint a kategória oldalon!
include __DIR__ . '/includes/header.php';
include __DIR__ . '/templates/product-listing.php';
include __DIR__ . '/includes/footer.php';
?>