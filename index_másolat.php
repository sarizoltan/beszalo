<?php
// Core rendszer betöltése
require_once __DIR__ . '/core/init.php';

// Oldal specifikus adatok lekérdezése
$page_title = "Főoldal";
$settings = $pdo->query("SELECT * FROM settings")->fetchAll(PDO::FETCH_KEY_PAIR);
$slides = $pdo->query("SELECT * FROM slides WHERE is_visible = 1 ORDER BY sort_order ASC")->fetchAll();
$is_logged_in = isset($_SESSION['user_id']); // Ezt a header is használhatja
$username = $_SESSION['username'] ?? ''; // Ezt a header is használhatja

// --- MEGJELENÍTÉS ---
// Betöltjük a közös fejlécet
include __DIR__ . '/includes/header.php';
?>

<!-- ================================================================= -->
<!-- DINAMIKUS SLIDER KEZDETE                                           -->
<!-- ================================================================= -->
<?php if (!empty($slides)): ?>
<div id="mainSlider" class="carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php foreach ($slides as $index => $slide): ?>
        <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>" aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>"></button>
        <?php endforeach; ?>
    </div>
    <div class="carousel-inner">
        <?php foreach ($slides as $index => $slide): ?>
        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
            <!-- A kép mostantól egy <img> tag, ami reszponzívabb -->
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
<!-- ================================================================= -->
<!-- DINAMIKUS SLIDER VÉGE                                             -->
<!-- ================================================================= -->

<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Üdvözöljük a Főoldalon!</h1>
            <p>Itt jelenhetnek meg a kiemelt termékek, legújabb akciók, stb.</p>
        </div>
    </div>
</div>

<?php
// Betöltjük a közös láblécet
include __DIR__ . '/includes/footer.php';
?>