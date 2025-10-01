<?php
require_once __DIR__ . '/core/init.php';

// --- ADATOK LEKÉRDEZÉSE ---

$slug = filter_input(INPUT_GET, 'slug', FILTER_SANITIZE_STRING);
if (!$slug) {
    redirect(SITE_URL);
}

// Aktuális címke adatainak lekérdezése slug alapján
$tag_stmt = $pdo->prepare("SELECT id, name FROM tags WHERE slug = ?");
$tag_stmt->execute([$slug]);
$tag = $tag_stmt->fetch();
if (!$tag) {
    http_response_code(404);
    die("A címke nem található.");
}
$tag_id = $tag['id'];
$page_title = 'Termékek a következő címkével: ' . $tag['name'];

// Termékek lekérdezése az adott címke alapján (JOIN-nal)
$products_stmt = $pdo->prepare("
    SELECT p.* 
    FROM products p
    JOIN product_tags pt ON p.id = pt.product_id
    WHERE pt.tag_id = ? AND p.is_visible = 1 
    ORDER BY p.created_at DESC
");
$products_stmt->execute([$tag_id]);
$products = $products_stmt->fetchAll();

// Szűrőkhöz szükséges adatok lekérdezése, SLUG-gal kiegészítve
$all_categories = $pdo->query("SELECT c.id, c.name, c.slug, (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id) as product_count FROM categories c ORDER BY c.name ASC")->fetchAll();
$all_tags = $pdo->query("SELECT id, name, slug FROM tags ORDER BY name ASC")->fetchAll();
$all_manufacturers = $pdo->query("SELECT id, name, slug FROM manufacturers ORDER BY name ASC")->fetchAll();
$price_range = $pdo->query("SELECT MIN(price) as min_price, MAX(price) as max_price FROM products WHERE is_visible = 1")->fetch();

// --- MEGJELENÍTÉS ---
include __DIR__ . '/includes/header.php';
include __DIR__ . '/templates/product-listing.php';
include __DIR__ . '/includes/footer.php';
?>