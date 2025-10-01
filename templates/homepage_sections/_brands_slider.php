<?php
// Hozzáfér a $section, $config, és $pdo változókhoz.
$manufacturer_ids = $config['manufacturer_ids'] ?? [];
$limit = (int)($config['limit'] ?? 12);

if (empty($manufacturer_ids)) {
    return;
}

$in_placeholders = implode(',', array_fill(0, count($manufacturer_ids), '?'));

// === ITT A JAVÍTÁS ===
// A lekérdezésben a 'logo_path' oszlopot átírtuk a te rendszeredben használt 'image_path'-ra.
$sql = "SELECT id, name, image_path FROM manufacturers WHERE id IN ($in_placeholders) AND image_path IS NOT NULL AND image_path != '' LIMIT $limit";
$stmt = $pdo->prepare($sql);
$stmt->execute($manufacturer_ids);
$brands = $stmt->fetchAll();

if (empty($brands)) {
    return;
}
?>

<section class="homepage-section brands-slider-section py-5">
    <div class="container">
        <div class="section-header text-center mb-4">
            <h2 class="section-title"><?php echo escape($section['title']); ?></h2>
        </div>

        <div class="glide brand-slider">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    <?php foreach ($brands as $brand): ?>
                        <li class="glide__slide">
                            <a href="manufacturer.php?id=<?php echo $brand['id']; ?>" class="brand-item" title="<?php echo escape($brand['name']); ?>">
                                <!-- A kép elérési útját is javítjuk, mivel a te rendszered a gyökérmappából indul. -->
                                <img src="<?php echo escape($brand['image_path']); ?>" alt="<?php echo escape($brand['name']); ?> logo">
                            </a>
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
</section>