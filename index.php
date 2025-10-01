<?php
// Core rendszer betöltése
require_once __DIR__ . '/core/init.php';

// =================================================================
// === JAVÍTOTT, ROBUSZTUS ROUTER LOGIKA KEZDETE ===
// =================================================================

// 1. A kért útvonal lekérdezése
$request_uri = $_SERVER['REQUEST_URI'];

// 2. Az útvonal "megtisztítása" a megbízhatóbb működésért
// Eltávolítjuk a query stringet (a '?' utáni részt), ha van
if (strpos($request_uri, '?') !== false) {
    $request_uri = substr($request_uri, 0, strpos($request_uri, '?'));
}
// Eltávolítjuk a projekt mappájának nevét
$base_path = '/sp_store/';
$route = str_replace($base_path, '', $request_uri);
// Eltávolítjuk a felesleges '/' karaktereket az elejéről és a végéről
$route = trim($route, '/');

// 3. Az útvonal feldarabolása a '/' mentén
$parts = explode('/', $route);

// 4. Az URL első, "döntő" részének kinyerése
$page_slug = $parts[0] ?? 'home';

// =================================================================
// === ROUTER LOGIKA VÉGE ===
// =================================================================


// 5. Útvonalválasztó (Switch)
switch ($page_slug) {
    case 'termek':
        $_GET['slug'] = $parts[1] ?? null; 
        require __DIR__ . '/product.php';
        break;

    case 'kategoria':
        $_GET['slug'] = $parts[1] ?? null;
        require __DIR__ . '/category.php';
        break;

    case 'cimke':
        $_GET['slug'] = $parts[1] ?? null;
        require __DIR__ . '/tag.php';
        break;

    case 'gyarto':
        $_GET['slug'] = $parts[1] ?? null;
        require __DIR__ . '/manufacturer.php';
        break;

    // Ide jöhetnek a jövőben további oldalak, pl. 'kosar', 'kapcsolat' stb.

    case 'home':
    case '': // Ha az URL üres (pl. /sp_store/), akkor is a főoldal kell.
    default:
        // =================================================================
        // EZ A TE EREDETI, TELJES FŐOLDALI KÓDOD, VÁLTOZTATÁS NÉLKÜL
        // =================================================================

        $page_title = "Főoldal";
        $slides = $pdo->query("SELECT * FROM slides WHERE is_visible = 1 ORDER BY sort_order ASC")->fetchAll();
        $sections = $pdo->query("SELECT * FROM homepage_sections WHERE is_visible = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();

        include __DIR__ . '/includes/header.php';
        ?>

        <?php if (!empty($slides)): ?>
        <div id="mainSlider" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php foreach ($slides as $index => $slide): ?>
                <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>" aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>"></button>
                <?php endforeach; ?>
            </div>
            <div class="carousel-inner">
                <?php foreach ($slides as $index => $slide): ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <img src="<?php echo escape($slide['image_path']); ?>" class="d-block w-100" alt="<?php echo escape($slide['title']); ?>">
                    <div class="carousel-caption d-none d-md-block text-<?php echo escape($slide['text_align']); ?>">
                        <h2><?php echo escape($slide['title']); ?></h2>
                        <p><?php echo escape($slide['description']); ?></p>
                        <?php if (!empty($slide['button_text']) && !empty($slide['button_url'])): ?>
                        <p><a class="btn btn-lg btn-primary" href="<?php echo escape($slide['button_url']); ?>"><?php echo escape($slide['button_text']); ?></a></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#mainSlider" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>
            <button class="carousel-control-next" type="button" data-bs-target="#mainSlider" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button>
        </div>
        <?php endif; ?>

        <?php
        if (empty($sections)) {
            echo '<div class="container my-5"><div class="alert alert-info text-center">A főoldal további tartalma még nincs beállítva. Látogass el az admin felületre a szekciók hozzáadásához!</div></div>';
        } else {
            foreach ($sections as $section) {
                $config = json_decode($section['config'] ?? '[]', true);
                $section_template_path = __DIR__ . '/templates/homepage_sections/_' . $section['section_type'] . '.php';
                if (file_exists($section_template_path)) {
                    include $section_template_path;
                }
            }
        }
        ?>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.core.min.css">
        <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const trendingSliders = document.querySelectorAll('.trending-slider');
                if (trendingSliders.length > 0) {
                    trendingSliders.forEach(slider => {
                        new Glide(slider, {
                            type: 'carousel', startAt: 0, perView: 5, gap: 30,
                            breakpoints: { 1200: { perView: 4 }, 992: { perView: 3 }, 768: { perView: 2 }, 576: { perView: 1 } }
                        }).mount();
                    });
                }
                const brandSliders = document.querySelectorAll('.brand-slider');
                if (brandSliders.length > 0) {
                    brandSliders.forEach(slider => {
                        new Glide(slider, {
                            type: 'carousel', startAt: 0, perView: 6, gap: 40, autoplay: 3000, hoverpause: true,
                            breakpoints: { 1200: { perView: 5 }, 992: { perView: 4 }, 768: { perView: 3 }, 576: { perView: 2 } }
                        }).mount();
                    });
                }
            });
        </script>

        <?php
        include __DIR__ . '/includes/footer.php';
        break; // A default case lezárása
}
?>