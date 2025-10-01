<?php
// config.php

// Alapvető útvonalak
define('BASE_PATH', dirname(__DIR__)); // C:\xampp\htdocs\sp_store
define('PUBLIC_PATH', BASE_PATH . '/public');

// Web URL-ek
define('SITE_URL', 'http://localhost/sp_store/');
define('ASSETS_URL', SITE_URL . 'assets/');
define('UPLOADS_URL', SITE_URL . 'public/uploads/');

// Adatbázis konfiguráció
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sp_store');