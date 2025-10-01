<?php
require_once __DIR__ . '/core/init.php';

$slug = filter_input(INPUT_GET, 'slug', FILTER_SANITIZE_STRING);
if (!$slug) {
    redirect(SITE_URL);
}

$category_stmt = $pdo->prepare("SELECT * FROM categories WHERE slug = ?");
$category_stmt->execute([$slug]);
$category = $category_stmt->fetch();

if (!$category) {
    http_response_code(404);
    die("A kategória nem található.");
}

$category_id = $category['id'];
$page_title = $category['name'];

// Termékek lekérdezése (változatlan)
$products_stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND is_visible = 1 ORDER BY created_at DESC");
$products_stmt->execute([$category_id]);
$products = $products_stmt->fetchAll();

// Szűrőkhöz szükséges adatok lekérdezése, SLUG-gal kiegészítve
$all_categories = $pdo->query("SELECT c.id, c.name, c.slug, (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id) as product_count FROM categories c ORDER BY c.name ASC")->fetchAll();
$all_tags = $pdo->query("SELECT id, name, slug FROM tags ORDER BY name ASC")->fetchAll();
$all_manufacturers = $pdo->query("SELECT id, name, slug FROM manufacturers ORDER BY name ASC")->fetchAll();
$price_range_stmt = $pdo->prepare("SELECT MIN(price) as min_price, MAX(price) as max_price FROM products WHERE is_visible = 1 AND category_id = ?");
$price_range_stmt->execute([$category_id]);
$price_range = $price_range_stmt->fetch();

// --- MEGJELENÍTÉS ---
include __DIR__ . '/includes/header.php';
include __DIR__ . '/templates/product-listing.php';
include __DIR__ . '/includes/footer.php';
?>