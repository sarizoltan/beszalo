<?php
// A szekció beállításaiból (config) kiolvassuk a termék ID-kat
$product_ids = $config['products'] ?? [];

if (!empty($product_ids)) {
    // Létrehozunk egy placeholder stringet a lekérdezéshez, pl. '?,?,?'
    $placeholders = rtrim(str_repeat('?,', count($product_ids)), ',');

    // === ITT A JAVÍTÁS ===
    // A lekérdezést kiegészítjük a 'slug' oszloppal
    $sql = "SELECT id, name, slug, price, sale_price, image_path 
            FROM products 
            WHERE id IN ($placeholders) AND is_visible = 1";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($product_ids);
    $products_in_section = $stmt->fetchAll();

    // Az eredményeket az eredeti sorrendbe rendezzük
    $sorted_products = [];
    $product_map = [];
    foreach ($products_in_section as $product) {
        $product_map[$product['id']] = $product;
    }
    foreach ($product_ids as $id) {
        if (isset($product_map[$id])) {
            $sorted_products[] = $product_map[$id];
        }
    }
} else {
    $sorted_products = [];
}
?>

<?php if (!empty($sorted_products)): ?>
<div class="container my-5">
    <h2 class="text-center mb-4"><?php echo escape($section['title']); ?></h2>
    
    <div class="glide trending-slider">
        <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">
                <?php foreach ($sorted_products as $product): ?>
                    <li class="glide__slide">
                        <?php 
                        // Itt újra felhasználjuk a központi termékkártya sablont,
                        // ami már a helyes, "szép" URL-t fogja generálni,
                        // mivel most már megkapja a '$product['slug']' adatot.
                        include __DIR__ . '/../../partials/product-card.php'; 
                        ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <div class="glide__arrows" data-glide-el="controls">
            <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="bi bi-chevron-left"></i></button>
            <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="bi bi-chevron-right"></i></button>
        </div>
    </div>
</div>
<?php endif; ?>