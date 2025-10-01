<?php
// Ez a fájl a /public/templates/partials/ mappában található
?>
<!-- JAVÍTÁS 1: Hozzáadjuk az ID-t a fő konténerhez -->
<div class="filters-sidebar" id="filters-sidebar">
    
	<!-- === ÚJ GOMB KEZDETE === -->
    <div class="filter-group mb-4">
        <button id="reset-filters-btn" class="btn btn-secondary btn-sm w-100">
            <i class="bi bi-arrow-clockwise"></i> Szűrők törlése
        </button>
    </div>
    <!-- === ÚJ GOMB VÉGE === -->
	
    <!-- Kategóriák szűrő -->
    <div class="filter-group mb-4">
        <h5 class="filter-title">Kategóriák</h5>
        <ul class="list-unstyled filter-list">
            <?php foreach ($all_categories as $cat): 
                // Meghatározzuk, hogy az aktuális kategória aktív-e
                // A category_id csak a category.php-ban létezik, ezért ellenőrizni kell
                $is_active = (isset($category_id) && $cat['id'] == $category_id);
            ?>
                <li>
                    <a href="category.php?id=<?php echo $cat['id']; ?>" class="<?php echo $is_active ? 'active' : ''; ?>">
                        <?php echo escape($cat['name']); ?>
                        <span class="product-count">(<?php echo $cat['product_count']; ?>)</span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Árszűrő -->
    <div class="filter-group mb-4">
        <h5 class="filter-title">Ár</h5>
        <div class="price-slider-inputs d-flex justify-content-between">
            <input type="number" id="min-price-input" class="form-control me-2" value="<?php echo floor($price_range['min_price']); ?>" placeholder="Min">
            <input type="number" id="max-price-input" class="form-control" value="<?php echo ceil($price_range['max_price']); ?>" placeholder="Max">
        </div>
    </div>

    <!-- Gyártók szűrő -->
    <div class="filter-group mb-4">
        <h5 class="filter-title">Gyártók</h5>
        <ul class="list-unstyled filter-list">
            <?php foreach ($all_manufacturers as $man): ?>
                <li>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="manufacturer" value="<?php echo $man['id']; ?>" id="man-<?php echo $man['id']; ?>">
                        <label class="form-check-label" for="man-<?php echo $man['id']; ?>"><?php echo escape($man['name']); ?></label>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Címkék szűrő -->
    <div class="filter-group mb-4">
        <h5 class="filter-title">Címkék</h5>
        <div class="tag-cloud">
            <?php foreach ($all_tags as $tag): ?>
                <a href="tag.php?id=<?php echo $tag['id']; ?>" class="tag-badge" data-tag-id="<?php echo $tag['id']; ?>">
                    <?php echo escape($tag['name']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Ide jönnek majd az attribútum szűrők dinamikusan -->

</div>