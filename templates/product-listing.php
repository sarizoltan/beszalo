<div class="container my-5">
    <div class="row">
        <!-- Bal oldalsáv a szűrőkkel -->
        <aside class="col-md-3">
            <?php include 'partials/sidebar-filters.php'; ?>
        </aside>

        <!-- Jobb oldali tartalom: Cím és a termékrács konténere -->
        <main class="col-md-9" id="product-main-content">
            <h1 class="mb-4"><?php echo escape($page_title); ?></h1>

            <div id="product-grid-container">
                <?php if (empty($products)): ?>
                    <div class="alert alert-info">Ebben a kategóriában jelenleg nincsenek termékek.</div>
                <?php else: ?>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                        <?php foreach ($products as $product): ?>
                            <div class="col">
                                <?php include 'partials/product-card.php'; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const filtersSidebar = document.getElementById('filters-sidebar');
    const productGridContainer = document.getElementById('product-grid-container');
    const resetFiltersBtn = document.getElementById('reset-filters-btn');

    if (!filtersSidebar || !productGridContainer) {
        return;
    }
    
    const pageType = <?php echo json_encode(basename($_SERVER['PHP_SELF'])); ?>;
    const initialId = <?php 
        if (isset($category_id)) echo json_encode($category_id);
        elseif (isset($manufacturer_id_from_url)) echo json_encode($manufacturer_id_from_url);
        elseif (isset($tag_id_from_url)) echo json_encode($tag_id_from_url);
        else echo 'null';
    ?>;

    function debounce(func, delay = 500) {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => { func.apply(this, args); }, delay);
        };
    }

    async function applyFilters() {
        productGridContainer.style.opacity = '0.5';

        const selectedManufacturers = Array.from(document.querySelectorAll('input[name="manufacturer"]:checked')).map(el => el.value);
        const selectedTags = Array.from(document.querySelectorAll('.tag-badge.active')).map(el => el.dataset.tagId);
        const minPrice = document.getElementById('min-price-input').value;
        const maxPrice = document.getElementById('max-price-input').value;
        
        const params = new URLSearchParams();

        if (pageType === 'category.php' && initialId) params.set('category_id', initialId);
        if (pageType === 'manufacturer.php' && initialId) params.append('manufacturers[]', initialId);
        if (pageType === 'tag.php' && initialId) params.append('tags[]', initialId);

        selectedManufacturers.forEach(id => {
            if (!params.getAll('manufacturers[]').includes(id)) {
                 params.append('manufacturers[]', id);
            }
        });
        selectedTags.forEach(id => {
            if (!params.getAll('tags[]').includes(id)) {
                 params.append('tags[]', id);
            }
        });

        const minPriceInput = document.getElementById('min-price-input');
        const maxPriceInput = document.getElementById('max-price-input');
        if (minPrice && minPrice !== minPriceInput.dataset.defaultValue) params.set('min_price', minPrice);
        if (maxPrice && maxPrice !== maxPriceInput.dataset.defaultValue) params.set('max_price', maxPrice);

        try {
            // === ITT A JAVÍTÁS ===
            // Eltávolítottuk a felesleges "/public" részt az URL-ből
            const apiUrl = `<?php echo PUBLIC_URL; ?>/api/filter-products.php?${params.toString()}`;
            const response = await fetch(apiUrl);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const html = await response.text();
            productGridContainer.innerHTML = html;
        } catch (error) {
            console.error('Hiba a szűrés során:', error);
            productGridContainer.innerHTML = '<div class="alert alert-danger">Hiba történt a termékek betöltése közben.</div>';
        } finally {
            productGridContainer.style.opacity = '1';
        }
    }

    const debouncedApplyFilters = debounce(applyFilters);

    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', function() {
            filtersSidebar.querySelectorAll('input[type="checkbox"]:checked').forEach(cb => cb.checked = false);
            filtersSidebar.querySelectorAll('.tag-badge.active').forEach(tag => tag.classList.remove('active'));
            const minPriceInput = document.getElementById('min-price-input');
            const maxPriceInput = document.getElementById('max-price-input');
            if (minPriceInput) minPriceInput.value = minPriceInput.dataset.defaultValue;
            if (maxPriceInput) maxPriceInput.value = maxPriceInput.dataset.defaultValue;
            applyFilters();
        });
    }

    filtersSidebar.addEventListener('click', function(e) {
        const tag = e.target.closest('.tag-badge');
        if (tag) {
            e.preventDefault();
            tag.classList.toggle('active');
            applyFilters();
        }
    });

    filtersSidebar.addEventListener('input', function(e) {
        if (e.target.matches('input[name="manufacturer"]')) {
            applyFilters();
        }
        if (e.target.matches('input[type="number"]')) {
            debouncedApplyFilters();
        }
    });
});
</script>