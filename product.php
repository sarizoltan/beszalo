<?php
require_once __DIR__ . '/core/init.php';

// --- Adatok lekérdezése slug alapján ---

// 1. Slug fogadása az URL-ből a .htaccess átirányítás után
$slug = $_GET['slug'] ?? null;
if (!$slug) {
    // Ha nincs slug paraméter, átirányítjuk a főoldalra
    redirect(SITE_URL); 
}

// 2. Termék fő adatainak lekérdezése slug alapján.
// A lekérdezés már tartalmazza a kategória és gyártó nevét és slug-ját is a linkekhez.
$stmt = $pdo->prepare("
    SELECT 
        p.*, 
        c.name as category_name,
        c.slug as category_slug,
        m.name as manufacturer_name,
        m.slug as manufacturer_slug
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN manufacturers m ON p.manufacturer_id = m.id
    WHERE p.slug = ? AND p.is_visible = 1
");
$stmt->execute([$slug]);
$product = $stmt->fetch();

// 3. Ellenőrzés: ha a termék nem létezik, 404-es hiba.
if (!$product) {
    http_response_code(404);
    $page_title = "A termék nem található";
    include __DIR__ . '/includes/header.php';
    echo '<div class="container my-5 text-center"><h1>404</h1><p>A keresett termék nem található vagy nem elérhető.</p><a href="' . SITE_URL . '" class="btn btn-primary">Vissza a főoldalra</a></div>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

// 4. A termék ID-jának elmentése a további, ID-alapú lekérdezésekhez.
$product_id = $product['id'];

// 5. Termék galéria képeinek lekérdezése
$gallery_stmt = $pdo->prepare("SELECT image_path FROM product_images WHERE product_id = ? ORDER BY sort_order ASC");
$gallery_stmt->execute([$product_id]);
$gallery_images = $gallery_stmt->fetchAll(PDO::FETCH_COLUMN);

// 6. Termékhez tartozó címkék lekérdezése (ID, név és slug)
$tags_stmt = $pdo->prepare("
    SELECT t.id, t.name, t.slug
    FROM tags t
    JOIN product_tags pt ON t.id = pt.tag_id
    WHERE pt.product_id = ?
");
$tags_stmt->execute([$product_id]);
$product_tags = $tags_stmt->fetchAll(PDO::FETCH_ASSOC);

// 7. Termékhez rendelt attribútumok lekérdezése, csoportosítva
$attributes_stmt = $pdo->prepare("
    SELECT 
        ag.name as group_name, 
		a.id as attribute_id,
        a.value as attribute_value
    FROM product_attributes pa
    JOIN attributes a ON pa.attribute_id = a.id
    JOIN attribute_groups ag ON a.group_id = ag.id
    WHERE pa.product_id = ?
    ORDER BY ag.name, a.value
");
$attributes_stmt->execute([$product_id]);
$product_attributes = $attributes_stmt->fetchAll(PDO::FETCH_GROUP);


// --- Oldal betöltése ---
$page_title = $product['name']; // Az oldal címe a termék neve lesz

// Betöltjük a frontend keretrendszerét
include __DIR__ . '/includes/header.php';
include __DIR__ . '/templates/product-details.php'; // Ez a fájl fogja megjeleníteni az adatokat
include __DIR__ . '/includes/footer.php';
?>