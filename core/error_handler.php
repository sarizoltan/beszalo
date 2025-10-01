<?php
/**
 * Egyszerű, de hatékony hibakezelő fejlesztési környezethez.
 * Jelenítse meg az összes PHP hibát és kezeletlen kivételt.
 */

// Hibajelentés bekapcsolása a legmagasabb szintre
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Egyedi hibakezelő függvény.
 * Elkapja a PHP hibákat (Warnings, Notices, stb.) és formázva kiírja őket.
 */
function development_error_handler($severity, $message, $file, $line) {
    // Ha a hibajelentés ki van kapcsolva, vagy a @ operátort használják, ne csináljunk semmit.
    if (!(error_reporting() & $severity) || error_reporting() === 0) {
        return false;
    }

    // Formázott kimenet a jobb olvashatóságért
    echo '<div style="
        border: 2px solid #dc3545;
        background-color: #f8d7da;
        color: #721c24;
        padding: 15px;
        margin: 15px;
        border-radius: 5px;
        font-family: monospace;
        z-index: 9999;
        position: relative;
    ">';
    echo '<strong>Hiba:</strong> ' . htmlspecialchars($message) . '<br>';
    echo '<strong>Fájl:</strong> ' . htmlspecialchars($file) . '<br>';
    echo '<strong>Sor:</strong> ' . $line . '<br>';
    echo '</div>';

    return true; // Megakadályozzuk, hogy a beépített PHP hibakezelő is lefusson.
}

/**
 * Egyedi kivételkezelő függvény.
 * Elkapja a nem kezelt kivételeket (Exceptions).
 */
function development_exception_handler($exception) {
    echo '<div style="
        border: 2px solid #ffc107;
        background-color: #fff3cd;
        color: #664d03;
        padding: 15px;
        margin: 15px;
        border-radius: 5px;
        font-family: monospace;
        z-index: 9999;
        position: relative;
    ">';
    echo '<strong>Kezeletlen kivétel:</strong> ' . htmlspecialchars($exception->getMessage()) . '<br>';
    echo '<strong>Fájl:</strong> ' . htmlspecialchars($exception->getFile()) . '<br>';
    echo '<strong>Sor:</strong> ' . $exception->getLine() . '<br>';
    echo '<pre style="white-space: pre-wrap; word-wrap: break-word;">' . htmlspecialchars($exception->getTraceAsString()) . '</pre>';
    echo '</div>';
}

// Beállítjuk a saját hibakezelő függvényeinket.
set_error_handler('development_error_handler');
set_exception_handler('development_exception_handler');

?>