<?php
// === GLOBÁLIS VÁLTOZÓK DEFINÍCIÓJA ===
// Ezekre minden oldalon szükség van a header helyes működéséhez.

// 1. Menüpontok
$menu_stmt = $pdo->query("SELECT label, url FROM menu_items ORDER BY sort_order ASC, label ASC");
$menu_items = $menu_stmt->fetchAll();

// 2. Általános beállítások (logó, felső sáv)
$settings_stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
$settings = $settings_stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// 3. Bejelentkezési állapot
$is_logged_in = isset($_SESSION['user_id']);
$username = $_SESSION['username'] ?? '';

// 4. Kosár inicializálása
require_once __DIR__ . '/Cart.php';
$cart = new Cart($pdo);
$cart_count = $cart->getItemCount();
$cart_total = $cart->getTotal();

// === VÁLTOZÓK DEFINÍCIÓJÁNAK VÉGE ===
?>
<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SP Store | <?php echo escape($page_title ?? 'Üdvözöljük!'); ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/listing.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/categories.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/homepage.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/cart.css">
</head>
<body>

<!-- 1. FELSŐ HEADER SÁV -->
<div class="top-header bg-light py-2">
    <div class="container">
        <div class="row text-center text-muted small">
            <div class="col-md-4">
                <?php echo $settings['top_header_col1'] ?? ''; ?>
            </div>
            <div class="col-md-4">
                <?php echo $settings['top_header_col2'] ?? ''; ?>
            </div>
            <div class="col-md-4">
                <?php echo $settings['top_header_col3'] ?? ''; ?>
            </div>
        </div>
    </div>
</div>

<!-- 2. FŐ FEJLÉC (LOGÓ, MENÜ, IKONOK) -->
<header class="main-header py-3">
    <div class="container">
        <div class="row align-items-center">
            <!-- Bal oldal: Logó -->
            <div class="col-md-3">
                <?php if (($settings['logo_type'] ?? 'text') === 'image' && !empty($settings['logo_image_path'])): ?>
                    <a href="<?php echo SITE_URL; ?>"><img src="<?php echo SITE_URL . '/' . escape($settings['logo_image_path']); ?>" alt="SP Store Logo" style="max-height: 50px;"></a>
                <?php else: ?>
                    <a href="<?php echo SITE_URL; ?>" class="fs-4 text-dark text-decoration-none"><?php echo $settings['logo_text'] ?? '<b>SP</b> Store'; ?></a>
                <?php endif; ?>
            </div>

            <!-- Középső rész: Menü -->
            <nav class="col-md-6 text-center">
                <ul class="nav justify-content-center">
                    <?php foreach ($menu_items as $item): ?>
                        <?php
                            $url = (str_starts_with($item['url'], 'http')) 
                                ? escape($item['url']) 
                                : SITE_URL . '/' . ltrim(escape($item['url']), '/');
                        ?>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase" href="<?php echo $url; ?>"><?php echo escape($item['label']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <!-- Jobb oldal: Ikonok -->
            <div class="col-md-3 text-end">
                <?php if ($is_logged_in): ?>
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-fill"></i> <?php echo escape($username); ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/profile.php">Profilom</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/logout.php">Kijelentkezés</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="#" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#userModal"><i class="bi bi-person"></i></a>
                <?php endif; ?>
                
                <a href="#" class="btn btn-light"><i class="bi bi-search"></i></a>
                
                <!-- KOSÁR DROPDOWN -->
                <div class="btn-group">
                    <button type="button" class="btn btn-light position-relative" id="cartDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCountBadge">
                            <?php echo $cart_count; ?>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end cart-dropdown" id="cartDropdown">
                        <div class="cart-dropdown-header">
                            <h6 class="mb-0">Kosár (<span id="cartItemCount"><?php echo $cart_count; ?></span>)</h6>
                        </div>
                        <div class="cart-dropdown-body" id="cartItemsContainer">
                            <!-- Itt jelennek meg a kosár tételek AJAX-szal -->
                        </div>
                        <div class="cart-dropdown-footer">
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Összesen:</strong>
                                <strong id="cartTotalAmount"><?php echo number_format($cart_total, 0, ',', ' '); ?> Ft</strong>
                            </div>
                            <a href="<?php echo SITE_URL; ?>/kosar.php" class="btn btn-primary w-100 mb-2">Kosár megtekintése</a>
                            <a href="<?php echo SITE_URL; ?>/penztar.php" class="btn btn-success w-100">Pénztár</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="main-content">