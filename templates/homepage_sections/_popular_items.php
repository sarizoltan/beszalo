<?php
// Hozzáfér a $section, $config, és $pdo változókhoz.
$tabs_config = array_filter($config['tabs'] ?? [], function($tab) {
    return !empty($tab['category_id']);
});
$limit = (int)($config['limit'] ?? 8);

if (empty($tabs_config)) {
    return;
}

// Az első fül adatainak előtöltése
$first_tab = reset($tabs_config);
$first_tab_category_id = $first_tab['category_id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND is_visible = 1 LIMIT ?");
$stmt->execute([$first_tab_category_id, $limit]);
$initial_products = $stmt->fetchAll();
?>

<section class="homepage-section popular-items-section py-5 bg-light">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0"><?php echo escape($section['title']); ?></h2>
            <a href="products.php" class="view-more-link">Összes termék &raquo;</a>
        </div>
        
        <!-- Fülek Navigációja -->
        <ul class="nav nav-tabs popular-items-tabs mb-4" id="popularItemsTab" role="tablist">
            <?php foreach ($tabs_config as $index => $tab_data): ?>
                <?php
                    $category_id = $tab_data['category_id'];
                    // Lekérdezzük a kategória nevét, ha nincs egyedi cím megadva
                    $tab_title = $tab_data['title'];
                    if (empty($tab_title)) {
                        $cat_stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
                        $cat_stmt->execute([$category_id]);
                        $tab_title = $cat_stmt->fetchColumn();
                    }
                    $is_active = ($index === key($tabs_config)); // Az első elem aktív
                ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo $is_active ? 'active' : ''; ?>" 
                            id="tab-<?php echo $section['id'] . '-' . $category_id; ?>" 
                            data-bs-toggle="tab" 
                            data-bs-target="#pane-<?php echo $section['id'] . '-' . $category_id; ?>" 
                            type="button" role="tab"
                            data-category-id="<?php echo $category_id; ?>"
                            data-limit="<?php echo $limit; ?>">
                        <?php echo escape($tab_title); ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Fülek Tartalma -->
        <div class="tab-content" id="popularItemsTabContent">
            <?php foreach ($tabs_config as $index => $tab_data): ?>
                <?php
                    $category_id = $tab_data['category_id'];
                    $is_active = ($index === key($tabs_config));
                ?>
                <div class="tab-pane fade <?php echo $is_active ? 'show active' : ''; ?>" 
                     id="pane-<?php echo $section['id'] . '-' . $category_id; ?>" 
                     role="tabpanel">
                    
                    <?php if ($is_active): ?>
                        <!-- Az első fül tartalma már be van töltve -->
                        <div class="row g-4">
                            <?php foreach ($initial_products as $product): ?>
                                <div class="col-6 col-md-4 col-lg-3">
                                    <?php include __DIR__ . '/../../templates/partials/product-card.php'; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <!-- A többi fül ide töltődik be AJAX-szal, egy "loading" jelzéssel -->
                        <div class="text-center p-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const popularItemsTabs = document.querySelectorAll('.popular-items-tabs .nav-link');
    popularItemsTabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', async function (event) {
            const pane = document.querySelector(event.target.dataset.bsTarget);
            // Csak akkor töltsünk, ha még nincs benne tartalom (a spinneren kívül)
            if (pane && !pane.querySelector('.row')) {
                const categoryId = event.target.dataset.categoryId;
                const limit = event.target.dataset.limit;
                
                try {
                    const response = await fetch(`<?php echo PUBLIC_URL; ?>/api/get_tab_content.php?category_id=${categoryId}&limit=${limit}`);
                    if (!response.ok) throw new Error('Network response was not ok');
                    const html = await response.text();
                    pane.innerHTML = html;
                } catch (error) {
                    console.error('Hiba a fül tartalmának betöltésekor:', error);
                    pane.innerHTML = '<div class="alert alert-danger">Hiba történt a tartalom betöltésekor.</div>';
                }
            }
        });
    });
});
</script>