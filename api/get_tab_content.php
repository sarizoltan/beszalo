<?php
require_once __DIR__ . '/../core/init.php';

header('Content-Type: text/html');

$categoryId = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
$limit = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT) ?: 8;

if (!$categoryId) {
    http_response_code(400); // Bad Request
    echo '<div class="alert alert-danger">Hiányzó kategória azonosító.</div>';
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND is_visible = 1 LIMIT ?");
    $stmt->execute([$categoryId, $limit]);
    $products = $stmt->fetchAll();

    if (empty($products)) {
        echo '<div class="alert alert-info">Ebben a kategóriában jelenleg nincsenek termékek.</div>';
    } else {
        echo '<div class="row g-4">';
        foreach ($products as $product) {
            echo '<div class="col-6 col-md-4 col-lg-3">';
            // A product-card.php sablon betöltése minden termékhez
            include __DIR__ . '/../templates/partials/product-card.php';
            echo '</div>';
        }
        echo '</div>';
    }
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo '<div class="alert alert-danger">Hiba történt a termékek betöltése közben.</div>';
    // Fejlesztéshez: error_log('Get tab content error: ' . $e->getMessage());
}