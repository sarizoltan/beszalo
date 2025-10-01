<?php
// Lekérdezzük a beállításokat, ha még nem történt meg.
if (!@$settings) {
    $settings_stmt = $pdo->query("SELECT * FROM settings");
    $settings = $settings_stmt->fetchAll(PDO::FETCH_KEY_PAIR);
}
?>
</main> <!-- /.main-content -->

<!-- ================================================================= -->
<!-- ÚJ, DINAMIKUS LÁBLÉC                                              -->
<!-- ================================================================= -->
<footer class="site-footer mt-auto">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <!-- 1. Oszlop: Rólunk -->
                <div class="col-lg-3 col-md-6 footer-col">
                    <?php if (isset($settings['logo_image_path']) && $settings['logo_type'] === 'image'): ?>
                        <a href="<?php echo SITE_URL; ?>"><img src="<?php echo SITE_URL . '/' . escape($settings['logo_image_path']); ?>" alt="logo" class="footer-logo mb-3"></a>
                    <?php else: ?>
                        <a href="<?php echo SITE_URL; ?>" class="footer-logo-text mb-3 d-block"><?php echo $settings['logo_text'] ?? '<b>SP</b> Store'; ?></a>
                    <?php endif; ?>
                    <p><?php echo nl2br(escape($settings['footer_col1_description'] ?? '')); ?></p>
                    <ul class="contact-info">
                        <?php if (!empty($settings['footer_col1_phone'])): ?><li><i class="bi bi-telephone"></i> <?php echo escape($settings['footer_col1_phone']); ?></li><?php endif; ?>
                        <?php if (!empty($settings['footer_col1_address'])): ?><li><i class="bi bi-geo-alt"></i> <?php echo escape($settings['footer_col1_address']); ?></li><?php endif; ?>
                        <?php if (!empty($settings['footer_col1_email'])): ?><li><i class="bi bi-envelope"></i> <?php echo escape($settings['footer_col1_email']); ?></li><?php endif; ?>
                        <?php if (!empty($settings['footer_col1_hours'])): ?><li><i class="bi bi-clock"></i> <?php echo escape($settings['footer_col1_hours']); ?></li><?php endif; ?>
                    </ul>
                </div>

                <!-- 2. Oszlop: Linkek -->
                <div class="col-lg col-md-6 footer-col">
                    <h5 class="footer-title"><?php echo escape($settings['footer_col2_title'] ?? ''); ?></h5>
                    <div class="footer-links"><?php echo $settings['footer_col2_content'] ?? ''; ?></div>
                </div>

                <!-- 3. Oszlop: Linkek -->
                <div class="col-lg col-md-6 footer-col">
                    <h5 class="footer-title"><?php echo escape($settings['footer_col3_title'] ?? ''); ?></h5>
                    <div class="footer-links"><?php echo $settings['footer_col3_content'] ?? ''; ?></div>
                </div>
                
                <!-- 4. Oszlop: Linkek -->
                <div class="col-lg col-md-6 footer-col">
                    <h5 class="footer-title"><?php echo escape($settings['footer_col4_title'] ?? ''); ?></h5>
                    <div class="footer-links"><?php echo $settings['footer_col4_content'] ?? ''; ?></div>
                </div>

                <!-- 5. Oszlop: App/Fizetés -->
                <div class="col-lg-3 col-md-6 footer-col">
                    <h5 class="footer-title"><?php echo escape($settings['footer_col5_title'] ?? ''); ?></h5>
                    <div class="footer-html-content"><?php echo $settings['footer_col5_content'] ?? ''; ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <p class="copyright-text mb-0">&copy; <?php echo date('Y'); ?> SP Store. Minden jog fenntartva.</p>
            <div class="social-links">
                <?php if (!empty($settings['footer_social_facebook'])): ?><a href="<?php echo escape($settings['footer_social_facebook']); ?>" target="_blank"><i class="bi bi-facebook"></i></a><?php endif; ?>
                <?php if (!empty($settings['footer_social_twitter'])): ?><a href="<?php echo escape($settings['footer_social_twitter']); ?>" target="_blank"><i class="bi bi-twitter-x"></i></a><?php endif; ?>
                <?php if (!empty($settings['footer_social_linkedin'])): ?><a href="<?php echo escape($settings['footer_social_linkedin']); ?>" target="_blank"><i class="bi bi-linkedin"></i></a><?php endif; ?>
                <?php if (!empty($settings['footer_social_youtube'])): ?><a href="<?php echo escape($settings['footer_social_youtube']); ?>" target="_blank"><i class="bi bi-youtube"></i></a><?php endif; ?>
            </div>
        </div>
    </div>
</footer>

<!-- Scroll to Top gomb -->
<a href="#" class="scroll-to-top"><i class="bi bi-arrow-up"></i></a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Kosár kezelő JS -->
<script src="<?php echo SITE_URL; ?>/assets/js/cart.js"></script>

<!-- Scroll to top -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const scrollTopBtn = document.querySelector('.scroll-to-top');
    if (scrollTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollTopBtn.classList.add('show');
            } else {
                scrollTopBtn.classList.remove('show');
            }
        });
        scrollTopBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});
</script>
</body>
</html>