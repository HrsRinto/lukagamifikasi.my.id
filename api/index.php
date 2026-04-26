<?php
$host = "gateway01.ap-southeast-1.prod.aws.tidbcloud.com";
$user = "RdgZXwrycN4vWB7.root";
$pass = "nvtHXSX2Krb5y1yX";
$db   = "test";
$port = 4000;

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $options = [PDO::MYSQL_ATTR_SSL_CA => true, PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false];
    $pdo = new PDO($dsn, $user, $pass, $options);
    die("<h1 style=\"color:green\">KONEKSI DATABASE SUKSES!</h1><p>Jika Anda melihat ini, berarti database TiDB Anda sudah terhubung sempurna. Masalah 500 tadi murni karena settingan internal Laravel.</p>");
} catch (PDOException $e) {
    die("<h1 style=\"color:red\">KONEKSI DATABASE GAGAL!</h1><p>Error: " . $e->getMessage() . "</p>");
}

