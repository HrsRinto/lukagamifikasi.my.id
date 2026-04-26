<?php
$host = "gateway01.ap-southeast-1.prod.aws.tidbcloud.com";
$user = "RdgZXwrycN4vWB7.root";
$pass = "nvtHXSX2Krb5y1yX";
$db   = "test";
$port = 4000;

echo "<h1>Tes Koneksi TiDB Cloud</h1>";
try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $options = [
        PDO::MYSQL_ATTR_SSL_CA => true,
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "<h2 style=\"color:green\">SUKSES! Koneksi ke TiDB Cloud Berhasil.</h2>";
    echo "<p>Sekarang kita tahu bahwa database Anda OK. Masalahnya ada di konfigurasi Laravel.</p>";
} catch (PDOException $e) {
    echo "<h2 style=\"color:red\">GAGAL! Error:</h2> " . $e->getMessage();
}

echo "<hr><p>Mencoba memuat Laravel...</p>";
require __DIR__ . "/../public/index.php";
