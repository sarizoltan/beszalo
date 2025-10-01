<?php
// Hozzáfér a $section, $config, és $pdo változókhoz.
$banners = $config['banners'] ?? [];
?>

<section class="homepage-section promo-banners-section py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($banners as $banner): ?>
                <?php
                // Csak akkor jelenítjük meg a bannert, ha legalább egy kép és egy cím meg van adva
                if (empty($banner['image_path']) || empty($banner['title'])) {
                    continue;
                }
                ?>
                <div class="col-lg-4 col-md-6">
                    <a href="<?php echo escape($banner['link'] ?? '#'); ?>" class="promo-banner-card text-decoration-none" style="background-image: url('<?php echo PUBLIC_URL . '/' . escape($banner['image_path']); ?>');">
                        <div class="promo-banner-content">
                            <?php if (!empty($banner['tag'])): ?>
                                <span class="promo-tag"><?php echo escape($banner['tag']); ?></span>
                            <?php endif; ?>

                            <h3 class="promo-title"><?php echo escape($banner['title']); ?></h3>
                            
                            <?php if (!empty($banner['subtitle'])): ?>
                                <p class="promo-subtitle"><?php echo escape($banner['subtitle']); ?></p>
                            <?php endif; ?>
                            
                            <?php if (!empty($banner['button_text'])): ?>
                                <div class="promo-button"><?php echo escape($banner['button_text']); ?> &raquo;</div>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>