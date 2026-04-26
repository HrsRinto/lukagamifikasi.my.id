<?php

// 1. Siapkan folder temporary untuk Laravel di Vercel (karena Read-Only)
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

// 2. Arahkan cache Laravel ke folder /tmp
putenv("APP_STORAGE=/tmp");
putenv("APP_CONFIG_CACHE=/tmp/config.php");
putenv("APP_ROUTES_CACHE=/tmp/routes.php");
putenv("APP_SERVICES_CACHE=/tmp/services.php");
putenv("APP_PACKAGES_CACHE=/tmp/packages.php");

// 3. Jalankan aplikasi
require __DIR__ . "/../public/index.php";
