<?php

/**
 * HTML kimenet "megtisztítása" a speciális karakterektől.
 */
function escape(?string $data): string
{
    if ($data === null) {
        return '';
    }
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/**
 * Átirányítás egy adott URL-re.
 */
function redirect(string $url): void
{
    header("Location: " . $url);
    exit();
}

/**
 * Átalakítja a normál videó URL-t beágyazható (embed) formátumra.
 */
function get_embed_url(?string $url): string
{
    if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
        return '';
    }

    // YouTube URL feldolgozása
    if (preg_match('/(youtube\.com|youtu\.be)\/(watch\?v=|embed\/|v\/|)([\w-]{11})/', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[3];
    }

    // Vimeo URL feldolgozása
    if (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $url, $matches)) {
        return 'https://player.vimeo.com/video/' . $matches[1];
    }

    return '';
}

function generate_slug(PDO $pdo, string $table, string $text, ?int $current_id = null): string {
    $slug = strtolower($text);
    $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');

    if (empty($slug)) {
        $slug = 'n-a-' . time();
    }

    $original_slug = $slug;
    $counter = 1;
    
    while (true) {
        $sql = "SELECT id FROM `$table` WHERE slug = ?";
        $params = [$slug];
        
        if ($current_id !== null) {
            $sql .= " AND id != ?";
            $params[] = $current_id;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        if ($stmt->fetch()) {
            $slug = $original_slug . '-' . $counter;
            $counter++;
        } else {
            break;
        }
    }
    
    return $slug;
}

/**
 * Javítja a képútvonalakat - nem távolítja el a public/ részt
 * mert a képek fizikailag ott vannak
 */
function fix_image_path($path) {
    if (empty($path)) {
        return 'assets/images/no-image.png';
    }
    
    // NE távolítsuk el a public/ részt, mert a képek ott vannak!
    return $path;
}

/**
 * Teljes kép URL generálása
 */
function get_image_url($image_path) {
    // Ha üres, akkor no-image
    if (empty($image_path)) {
        return ASSETS_URL . 'images/no-image.png';
    }
    
    // Ha már teljes URL
    if (strpos($image_path, 'http') === 0) {
        return $image_path;
    }
    
    // Ha a public/uploads mappából jön (termék képek)
    if (strpos($image_path, 'public/uploads/') === 0) {
        return SITE_URL . $image_path;
    }
    
    // Ha csak uploads/products/kep.jpg formátumú
    if (strpos($image_path, 'uploads/') === 0) {
        return SITE_URL . 'public/' . $image_path;
    }
    
    // Alapértelmezett: public/uploads/products/
    return UPLOADS_URL . 'products/' . basename($image_path);
}
?>