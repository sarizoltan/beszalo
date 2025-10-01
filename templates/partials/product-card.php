<?php
// Meghatározzuk, hogy egy termék újnak számít-e (pl. az elmúlt 30 napban hozták létre)
$is_new = (strtotime($product['created_at']) > strtotime('-30 days'));
$has_sale = ($product['sale_price'] && $product['sale_price'] < $product['price']);


?>

<div class="card product-card h-100 shadow-sm">
    <a href="<?php echo SITE_URL; ?>termek/<?php echo $product['slug']; ?>" class="product-image-link">
        <span class="product-image-wrapper">
            <img src="<?php echo escape($product['image_path']); ?>" class="card-img-top" alt="<?php echo escape($product['name']); ?>">
        </span>
        <!-- Akciós badge (változatlan) -->
        <?php if (isset($product['sale_price']) && $product['sale_price'] < $product['price']): 
            $percent = round((1 - $product['sale_price']/$product['price'])*100);
        ?>
            <span class="badge bg-danger position-absolute top-0 end-0 m-2">-<?php echo $percent; ?>%</span>
        <?php endif; ?>
    </a>
    <div class="card-body d-flex flex-column">
        <h5 class="card-title product-title">
            <a href="<?php echo SITE_URL; ?>termek/<?php echo $product['slug']; ?>" class="text-dark text-decoration-none">
                <?php echo escape($product['name']); ?>
            </a>
        </h5>
        <div class="mt-auto">
            <div class="d-flex justify-content-between align-items-center">
                <div class="product-price">
                    <?php if (isset($product['sale_price']) && $product['sale_price'] < $product['price']): ?>
                        <span class="sale-price"><?php echo number_format($product['sale_price'], 0, ',', ' '); ?> Ft</span>
                        <s class="original-price"><?php echo number_format($product['price'], 0, ',', ' '); ?> Ft</s>
                    <?php else: ?>
                        <span class="price"><?php echo number_format($product['price'], 0, ',', ' '); ?> Ft</span>
                    <?php endif; ?>
                </div>
                <a href="#" class="btn btn-primary btn-sm add-to-cart-btn" data-product-id="<?php echo $product['id']; ?>">
                    <i class="bi bi-cart-plus"></i>
                </a>
            </div>
        </div>
    </div>
</div>