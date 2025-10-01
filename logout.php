<?php
require_once __DIR__ . '/core/init.php';

// Session törlése
session_destroy();

// Átirányítás a főoldalra
redirect('index.php');