<?php

// TES KONEKSI
echo "<!-- SISTEM BOOTING -->";

error_reporting(E_ALL);
ini_set("display_errors", "1");

try {
    $storageDirs = ["/tmp/storage/framework/views", "/tmp/storage/framework/cache", "/tmp/storage/framework/sessions", "/tmp/storage/bootstrap/cache"];
    foreach ($storageDirs as $dir) { if (!is_dir($dir)) { @mkdir($dir, 0755, true); } }
    
    putenv("APP_STORAGE=/tmp");
    putenv("APP_CONFIG_CACHE=/tmp/config.php");
    putenv("APP_ROUTES_CACHE=/tmp/routes.php");

    require __DIR__ . "/../public/index.php";

} catch (\Throwable $e) {
    die("<h1>FATAL ERROR:</h1> " . $e->getMessage() . "<br>File: " . $e->getFile());
}
