<?php

use Illuminate\Http\Request;

// 1. Siapkan folder temporary di RAM Vercel agar tidak Read-Only Error
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/bootstrap/cache',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// 2. Load Laravel secara manual
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. PAKSA SEMUA PATH KE /tmp SECARA TOTAL
$app->useStoragePath('/tmp/storage');
$app->bind('path.public', function() {
    return __DIR__ . '/../public';
});

// Override konfigurasi runtime agar tidak mencoba menulis ke folder terlarang
config([
    'view.compiled' => '/tmp/storage/framework/views',
    'cache.stores.file.path' => '/tmp/storage/framework/cache',
    'session.driver' => 'cookie',
    'logging.channels.stderr.path' => 'php://stderr',
]);

// 4. Jalankan aplikasi
$app->handleRequest(Request::capture());
