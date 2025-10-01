<?php
require_once __DIR__ . '/core/init.php';
// Az URL-ből lekérdezzük, hogy egy specifikus kategória alkategóriáit nézzük-e
// Ha nincs ID, akkor a fő kategóriákat (`parent_id` IS NULL) listázzuk
$parent_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Először megnézzük, hogy az adott ID-hez tartozó kategóriának vannak-e további alkategóriái
$subcat_check_stmt = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE parent_id = ?");
$subcat_check_stmt->execute([$parent_id]);
$has_subcategories = $subcat_check_stmt->fetchColumn() > 0;

// --- DÖNTÉSI LOGIKA ---
// Ha van ID az URL-ben, ÉS ehhez a kategóriához NINCSENEK további alkategóriák,
// akkor ez a hierarchia vége -> átirányítjuk a terméklistázó oldalra.
if ($parent_id && !$has_subcategories) {
    redirect('category.php?id=' . $parent_id);
}

// --- ADATOK LEKÉRDEZÉSE A MEGJELENÍTÉSHEZ ---

$page_title = "Kategóriák";
$categories_to_display = [];

if ($parent_id) {
    // Ha van ID, akkor az alkategóriákat kérdezzük le
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id = ? ORDER BY name ASC");
    $stmt->execute([$parent_id]);
    $categories_to_display = $stmt->fetchAll();

    // Az oldal címének beállítjuk a szülő kategória nevét
    $parent_cat_stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
    $parent_cat_stmt->execute([$parent_id]);
    $parent_cat_name = $parent_cat_stmt->fetchColumn();
    if ($parent_cat_name) {
        $page_title = $parent_cat_name;
    }

} else {
    // Ha nincs ID, a fő kategóriákat kérdezzük le
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id IS NULL ORDER BY name ASC");
    $stmt->execute();
    $categories_to_display = $stmt->fetchAll();
}

// --- MEGJELENÍTÉS ---
include __DIR__ . '/includes/header.php';
// Betöltjük az új kategória rács sablont
include __DIR__ . '/templates/category-grid.php';
include __DIR__ . '/includes/footer.php';
?>