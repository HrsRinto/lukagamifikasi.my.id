<?php

// Aktifkan error reporting paling mentah
error_reporting(E_ALL);
ini_set("display_errors", "1");

try {
    // Siapkan folder temporary
    $storageDirs = [
        "/tmp/storage/framework/views",
        "/tmp/storage/framework/cache",
        "/tmp/storage/framework/sessions",
        "/tmp/storage/bootstrap/cache",
    ];

    foreach ($storageDirs as $dir) {
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
    }

    // Paksa Laravel menggunakan /tmp untuk cache
    putenv("APP_CONFIG_CACHE=/tmp/config.php");
    putenv("APP_ROUTES_CACHE=/tmp/routes.php");
    putenv("APP_SERVICES_CACHE=/tmp/services.php");
    putenv("APP_PACKAGES_CACHE=/tmp/packages.php");

    require __DIR__ . "/../public/index.php";

} catch (\Throwable $e) {
    echo "<h1>Laravel Boot Error</h1>";
    echo "<p><strong>Message:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . " (Line: " . $e->getLine() . ")</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    exit(1);
}
