<?php

use Illuminate\Http\Request;

// 1. Siapkan folder temporary
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

// 2. Load Laravel secara manual agar bisa kita paksa pindah folder
require __DIR__ . "/../vendor/autoload.php";
$app = require_once __DIR__ . "/../bootstrap/app.php";

// 3. PAKSA Laravel menggunakan folder /tmp untuk menulis file
$app->useStoragePath("/tmp/storage");

// 4. Jalankan aplikasi
$app->handleRequest(Request::capture());
