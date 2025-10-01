<div class="container my-5">
    <div class="row">
        <!-- Galéria bal oldalon -->
        <div class="col-md-5 d-flex">
            <?php if (!empty($gallery_images)): ?>
                <div class="d-flex flex-column align-items-center me-3" style="gap:10px;">
                    <?php foreach ($gallery_images as $image_path): ?>
                        <img src="<?php echo get_image_url($image_path); ?>"
                             class="img-fluid rounded border product-thumbnail"
                             style="width:64px; height:64px; object-fit:cover; cursor:pointer;"
                             alt="Thumbnail"
                             onerror="this.src='<?php echo SITE_URL; ?>assets/images/no-image.png'">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="flex-grow-1">
                <!-- Fő kép kattintható, modalban nagyítható -->
                <a href="#" id="main-image-link" data-bs-toggle="modal" data-bs-target="#imageModal">
                    <img src="<?php echo get_image_url($product['image_path']); ?>"
                         class="img-fluid rounded border w-100" id="main-product-image"
                         alt="<?php echo escape($product['name']); ?>"
                         onerror="this.src='<?php echo SITE_URL; ?>assets/images/no-image.png'">
                </a>
            </div>
        </div>

        <!-- Termék adatok -->
        <div class="col-md-7">
            <!-- === ITT VANNAK A VÉGLEGES, JAVÍTOTT LINKEK === -->
            <div class="mb-2 d-flex align-items-center flex-wrap" style="gap:10px;">
                <?php if (!empty($product['manufacturer_slug'])): ?>
                    <a href="<?php echo SITE_URL; ?>gyarto/<?php echo $product['manufacturer_slug']; ?>" class="text-muted text-decoration-underline me-2">
                        <i class="bi bi-person-badge"></i> <?php echo escape($product['manufacturer_name']); ?>
                    </a>
                <?php endif; ?>
                <?php if (!empty($product['category_slug'])): ?>
                    <a href="<?php echo SITE_URL; ?>kategoria/<?php echo $product['category_slug']; ?>" class="badge bg-light text-dark border me-2">
                        <i class="bi bi-folder2"></i> <?php echo escape($product['category_name']); ?>
                    </a>
                <?php endif; ?>
                <?php if (!empty($product_tags)): ?>
                    <?php foreach ($product_tags as $tag): ?>
                        <a href="<?php echo SITE_URL; ?>cimke/<?php echo $tag['slug']; ?>" class="badge bg-secondary me-1 text-decoration-none">
                            <i class="bi bi-tag"></i> <?php echo escape($tag['name']); ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <h1 class="fw-bold"><?php echo escape($product['name']); ?></h1>

            <!-- Akciós ár, badge, megtakarítás -->
            <div class="h3 my-3 d-flex align-items-center gap-3">
                <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): 
                    $percent = round((1 - $product['sale_price']/$product['price'])*100);
                ?>
                    <span class="text-danger fw-bold"><?php echo number_format($product['sale_price'], 0, ',', ' '); ?> Ft</span>
                    <s class="text-muted"><?php echo number_format($product['price'], 0, ',', ' '); ?> Ft</s>
                    <span class="badge bg-danger fs-6">-<?php echo $percent; ?>%</span>
                <?php else: ?>
                    <span class="fw-bold"><?php echo number_format($product['price'], 0, ',', ' '); ?> Ft</span>
                <?php endif; ?>
            </div>
            <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): ?>
                <div class="mb-2 text-success small">
                    Ön most megtakarít: <?php echo number_format($product['price'] - $product['sale_price'], 0, ',', ' '); ?> Ft
                </div>
                <?php if (!empty($product['sale_price_end_date'])): ?>
                    <div id="sale-timer"
                        data-end="<?php echo $product['sale_price_end_date']; ?>"
                        class="mb-2 text-danger fw-bold"></div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Készlet -->
            <?php if ($product['stock_quantity'] > 0): ?>
                <p class="text-success mb-2"><i class="bi bi-check-circle-fill"></i> Készleten (<?php echo $product['stock_quantity']; ?> db)</p>
            <?php else: ?>
                <p class="text-danger mb-2"><i class="bi bi-x-circle-fill"></i> Nincs készleten</p>
            <?php endif; ?>
            
            <!-- Rövid leírás -->
            <div class="lead my-3">
                <?php echo $product['short_description']; ?>
            </div>

            <!-- ATTRIBÚTUMOK KIVÁLASZTÁSA -->
            <?php if (!empty($product_attributes)): ?>
                <div id="attribute-selection" class="mb-3">
                    <?php foreach ($product_attributes as $group_name => $attributes): ?>
                        <div class="form-group mb-2">
                            <label for="attr-<?php echo escape($group_name); ?>" class="form-label fw-bold"><?php echo escape($group_name); ?>:</label>
                            <select name="attributes[<?php echo escape($group_name); ?>]" id="attr-<?php echo escape($group_name); ?>" class="form-select attribute-select" required>
                                <option value="" selected disabled>Válassz egy lehetőséget...</option>
                                <?php foreach ($attributes as $attribute): ?>
                                    <option value="<?php echo $attribute['attribute_id']; ?>"><?php echo escape($attribute['attribute_value']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Kosár gomb -->
            <div class="d-flex align-items-end gap-3 mb-3">
                <div>
                    <label for="quantity" class="form-label">Mennyiség</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>" style="width: 90px;">
                </div>
                <button class="btn btn-primary btn-lg add-to-cart-btn" data-product-id="<?php echo $product['id']; ?>">
                    <i class="bi bi-cart-plus"></i> Kosárba
                </button>
            </div>

            <!-- Szállítási információk blokk -->
            <div class="card mb-3">
                <div class="card-body py-2">
                    <h6 class="mb-1 fw-bold">Kiszállítási információk:</h6>
                    <ul class="mb-1 ps-3">
                        <li><strong>Futárcégek:</strong> GLS és MPL futárszolgálattal szállítjuk a megrendeléseket.</li>
                        <li><strong>Várható szállítás:</strong> 1-3 munkanap</li>
                        <li><strong>Ingyenes szállítás</strong> 25.000 Ft felett!</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Leírás, specifikációk és videó -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-content" type="button" role="tab" aria-controls="description-content" aria-selected="true">Termékleírás</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs-content" type="button" role="tab" aria-controls="specs-content" aria-selected="false">Specifikáció</button>
                </li>
                <?php if (!empty($product['video_url'])): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="video-tab" data-bs-toggle="tab" data-bs-target="#video-content" type="button" role="tab" aria-controls="video-content" aria-selected="false">Videó</button>
                </li>
                <?php endif; ?>
            </ul>
            <div class="tab-content p-3 border border-top-0" id="productTabContent">
                <!-- Teljes leírás -->
                <div class="tab-pane fade show active" id="description-content" role="tabpanel" aria-labelledby="description-tab">
                    <?php echo $product['description']; ?>
                </div>
                <!-- Specifikáció (attribútumok) -->
                <div class="tab-pane fade" id="specs-content" role="tabpanel" aria-labelledby="specs-tab">
                    <?php if (!empty($product_attributes)): ?>
                        <div class="row">
                        <?php foreach ($product_attributes as $group_name => $attributes): ?>
                            <div class="col-md-6">
                                <h4><?php echo escape($group_name); ?></h4>
                                <table class="table table-striped">
                                    <tbody>
                                    <?php foreach ($attributes as $attribute): ?>
                                        <tr>
                                            <td><?php echo escape($attribute['attribute_value']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p>Ehhez a termékhez nincsenek megadva specifikációk.</p>
                    <?php endif; ?>
                </div>
                 <!-- Videó -->
                <?php if (!empty($product['video_url'])): ?>
                <div class="tab-pane fade" id="video-content" role="tabpanel" aria-labelledby="video-tab">
                    <div class="ratio ratio-16x9">
                        <iframe src="<?php echo escape(get_embed_url($product['video_url'])); ?>" title="Termék videó" allowfullscreen></iframe>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Lightbox modal a fő képhez -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel"><?php echo escape($product['name']); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="<?php echo get_image_url($product['image_path']); ?>" class="img-fluid" id="modalImage" alt="Nagyított kép">
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- MENNYISÉG KEZELÉSE ---
    const quantityInput = document.getElementById('quantity');
    const addToCartBtn = document.querySelector('.add-to-cart-btn'); // CLASS selector, nem ID!
    
    if (quantityInput && addToCartBtn) {
        quantityInput.addEventListener('change', function() {
            const quantity = parseInt(this.value) || 1;
            addToCartBtn.dataset.quantity = quantity;
        });
    }

    // --- ATTRIBÚTUM VÁLASZTÁS KEZELÉSE ---
    const attributeSelects = document.querySelectorAll('.attribute-select');

    function checkAttributes() {
        if (!addToCartBtn || attributeSelects.length === 0) return;
        
        let allSelected = true;
        attributeSelects.forEach(select => {
            if (select.value === '') {
                allSelected = false;
            }
        });
        addToCartBtn.disabled = !allSelected;
    }

    if (attributeSelects.length > 0 && addToCartBtn) {
        addToCartBtn.disabled = true;
        attributeSelects.forEach(select => {
            select.addEventListener('change', checkAttributes);
        });
    }

    // --- FŐ KÉP CSERÉJE THUMBNAIL-RE KATTINTVA ---
    const mainImage = document.getElementById('main-product-image');
    const modalImage = document.getElementById('modalImage');
    const thumbnails = document.querySelectorAll('.product-thumbnail');

    thumbnails.forEach(thumb => {
        thumb.addEventListener('click', function(e) {
            e.preventDefault();
            const newSrc = this.src;
            if (mainImage) mainImage.src = newSrc;
            if (modalImage) modalImage.src = newSrc;
        });
    });

    // --- AKCIÓS VISSZASZÁMLÁLÓ ---
    const timer = document.getElementById('sale-timer');
    if (timer) {
        const end = new Date(timer.dataset.end);
        const pad = (num) => num.toString().padStart(2, '0');

        function updateTimer() {
            const now = new Date();
            const diff = end - now;

            if (diff > 0) {
                const d = Math.floor(diff / (1000 * 60 * 60 * 24));
                const h = Math.floor((diff / (1000 * 60 * 60)) % 24);
                const m = Math.floor((diff / (1000 * 60)) % 60);
                const s = Math.floor((diff / 1000) % 60);
                timer.innerHTML = `
                    <i class="bi bi-clock"></i> Az akció vége: 
                    <strong>${d}</strong> nap 
                    <strong>${pad(h)}</strong> óra 
                    <strong>${pad(m)}</strong> perc 
                    <strong>${pad(s)}</strong> mp`;
            } else {
                timer.textContent = "Az akció lejárt!";
                clearInterval(timerInterval);
            }
        }
        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer();
    }
});
</script>