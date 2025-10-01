<?php
/**
 * Ez a fájl fogadja a szűrő AJAX kéréseit, és visszaadja a termékek HTML-jét.
 */

// JAVÍTÁS: Az útvonal most már helyes, csak egyet lépünk vissza.
require_once __DIR__ . '/../core/init.php';

try {
    // --- 1. Szűrőparaméterek begyűjtése és tisztítása ---
    $categoryId = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
    $manufacturers = isset($_GET['manufacturers']) && is_array($_GET['manufacturers']) ? $_GET['manufacturers'] : [];
    $tags = isset($_GET['tags']) && is_array($_GET['tags']) ? $_GET['tags'] : [];
    $minPrice = filter_input(INPUT_GET, 'min_price', FILTER_VALIDATE_FLOAT);
    $maxPrice = filter_input(INPUT_GET, 'max_price', FILTER_VALIDATE_FLOAT);

    // Biztonsági szűrés: csak számok maradhatnak a tömbökben
    $manufacturerIds = array_filter($manufacturers, 'is_numeric');
    $tagIds = array_filter($tags, 'is_numeric');

    // --- 2. Dinamikus SQL lekérdezés építése ---
    $sql = "SELECT DISTINCT p.id, p.name, p.price, p.sale_price, p.image_path, p.created_at 
            FROM products p";
    $joins = [];
    $conditions = ['p.is_visible = 1'];
    $params = [];

    // Címkék szűrése (JOIN szükséges)
    if (!empty($tagIds)) {
        $joins[] = "JOIN product_tags pt ON p.id = pt.product_id";
        $in_clause = implode(',', array_fill(0, count($tagIds), '?'));
        $conditions[] = "pt.tag_id IN ($in_clause)";
        $params = array_merge($params, $tagIds);
    }

    // Kategória szűrése
    if ($categoryId) {
        $conditions[] = "p.category_id = ?";
        $params[] = $categoryId;
    }

    // Gyártók szűrése
    if (!empty($manufacturerIds)) {
        $in_clause = implode(',', array_fill(0, count($manufacturerIds), '?'));
        $conditions[] = "p.manufacturer_id IN ($in_clause)";
        $params = array_merge($params, $manufacturerIds);
    }
    
    // Ár szűrése
    if ($minPrice !== null && $minPrice !== false) {
        $conditions[] = "p.price >= ?";
        $params[] = $minPrice;
    }
    if ($maxPrice !== null && $maxPrice !== false) {
        $conditions[] = "p.price <= ?";
        $params[] = $maxPrice;
    }

    // A lekérdezés összeállítása
    if (!empty($joins)) {
        $sql .= " " . implode(" ", $joins);
    }
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
    $sql .= " ORDER BY p.created_at DESC";

    // --- 3. Lekérdezés futtatása és eredmények megjelenítése ---
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll();

    if (empty($products)) {
        echo '<div class="alert alert-info">A megadott szűrési feltételekkel nem található termék.</div>';
    } else {
        // A termékkártyák rácsának újragenerálása
        echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">';
        foreach ($products as $product) {
            // A product-card.php sablon betöltése minden termékhez
            // Fontos, hogy az útvonal a filter-products.php-hoz képest helyes legyen
            echo '<div class="col">';
            include __DIR__ . '/../templates/partials/product-card.php';
            echo '</div>';
        }
        echo '</div>';
    }

} catch (Exception $e) {
    // Hiba esetén adjunk egyértelmű visszajelzést
    // Ezt a hibát a fejlesztői konzolban fogod látni, ha az AJAX hívás hibára fut
    http_response_code(500); // Belső szerverhiba
    echo '<div class="alert alert-danger">Szerverhiba történt a szűrés közben.</div>';
    // Fejlesztéshez hasznos lehet a hiba kiírása is:
    // error_log('Filter products error: ' . $e->getMessage());
}