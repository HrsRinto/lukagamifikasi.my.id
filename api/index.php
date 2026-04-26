<?php

use Illuminate\Http\Request;

// 1. Definisikan path storage ke /tmp SEBELUM Laravel dimuat
putenv('APP_STORAGE=/tmp/storage');
$_ENV['APP_STORAGE'] = '/tmp/storage';

// 2. Siapkan folder temporary di RAM Vercel
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

// 3. Load Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 4. Paksa Laravel menggunakan path baru
$app->useStoragePath('/tmp/storage');

// 5. Jalankan aplikasi
$app->handleRequest(Request::capture());
