<?php
// Hozzáfér a $section, $config, és $pdo változókhoz.
$items = array_filter($config['items'] ?? [], function($item) {
    return !empty($item['icon']) && !empty($item['title']);
});

if (empty($items)) {
    return;
}
?>

<section class="homepage-section info-bar-section py-4">
    <div class="container">
        <div class="row">
            <?php foreach ($items as $item): ?>
                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                    <div class="info-box d-flex align-items-center">
                        <div class="info-icon me-3">
                            <i class="bi bi-<?php echo escape($item['icon']); ?>"></i>
                        </div>
                        <div class="info-text">
                            <h6 class="info-title mb-0"><?php echo escape($item['title']); ?></h6>
                            <?php if (!empty($item['subtitle'])): ?>
                                <p class="info-subtitle mb-0"><?php echo escape($item['subtitle']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>