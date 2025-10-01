<?php
// Ez a fájl az index.php-n belül töltődik be.
// Hozzáfér a $section, $config, és $pdo változókhoz.

// Adatok kinyerése a config-ból, alapértelmezett értékekkel
$category_ids = $config['category_ids'] ?? [];
$limit = (int)($config['limit'] ?? 6);

// Ha nincsenek kategóriák kiválasztva, ne csináljunk semmit
if (empty($category_ids)) {
    return;
}

// Biztonságos placeholder-ek generálása az IN() záradékhoz
$in_placeholders = implode(',', array_fill(0, count($category_ids), '?'));

// Lekérdezzük a kiválasztott kategóriákat és a termékszámot
// LEFT JOIN-t használunk, hogy a 0 termékes kategóriák is megjelenjenek.
$sql = "
    SELECT 
        c.id, 
        c.name, 
        c.image_path,
        (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id AND p.is_visible = 1) as product_count
    FROM 
        categories c
    WHERE 
        c.id IN ($in_placeholders)
    LIMIT $limit
";

$stmt = $pdo->prepare($sql);
$stmt->execute($category_ids);
$categories = $stmt->fetchAll();

// Ha a lekérdezés nem adott vissza eredményt, szintén ne csináljunk semmit
if (empty($categories)) {
    return;
}
?>

<section class="homepage-section top-categories-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-4">
            <h2 class="section-title"><?php echo escape($section['title']); ?></h2>
            <a href="categories.php" class="view-more-link">Összes megtekintése &raquo;</a>
        </div>

        <div class="row g-4 justify-content-center">
            <?php foreach ($categories as $category): ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="categories.php?id=<?php echo $category['id']; ?>" class="category-showcase-card text-decoration-none">
                        <div class="icon-wrapper">
                            <?php 
                                $image_url = $category['image_path'] 
                                    ? PUBLIC_URL . '/' . escape($category['image_path']) 
                                    : 'https://via.placeholder.com/100.png?text=Kép';
                            ?>
                            <img src="<?php echo $image_url; ?>" alt="<?php echo escape($category['name']); ?>">
                        </div>
                        <h5 class="category-title"><?php echo escape($category['name']); ?></h5>
                        <p class="item-count"><?php echo $category['product_count']; ?> termék</p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>