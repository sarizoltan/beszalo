<?php
// Hozzáfér a $section, $config, és $pdo változókhoz.
if (empty($config['image_path'])) {
    return; // Ne jelenítsük meg a szekciót, ha nincs háttérkép beállítva.
}

$text_align = $config['text_align'] ?? 'center';
?>

<section class="homepage-section large-banner-section my-5">
    <div class="container">
        <div class="large-banner-wrapper" style="background-image: url('<?php echo PUBLIC_URL . '/' . escape($config['image_path']); ?>');">
            <div class="large-banner-content text-<?php echo $text_align; ?>">
                
                <?php if (!empty($config['pre_title'])): ?>
                    <p class="pre-title"><?php echo escape($config['pre_title']); ?></p>
                <?php endif; ?>

                <?php if (!empty($config['title'])): ?>
                    <h1 class="main-title"><?php echo escape($config['title']); ?></h1>
                <?php endif; ?>

                <?php if (!empty($config['subtitle'])): ?>
                    <p class="subtitle"><?php echo escape($config['subtitle']); ?></p>
                <?php endif; ?>

                <?php if (!empty($config['button_text']) && !empty($config['button_link'])): ?>
                    <a href="<?php echo escape($config['button_link']); ?>" class="btn btn-primary btn-lg mt-3">
                        <?php echo escape($config['button_text']); ?>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>