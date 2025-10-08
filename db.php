<?php
// db.php - MySQL via PDO
$DB_HOST = getenv('MYSQL_HOST') ?: 'localhost';
$DB_PORT = getenv('MYSQL_PORT') ?: '3306';
$DB_NAME = getenv('MYSQL_DB')   ?: 'ayam_monitoring';
$DB_USER = getenv('MYSQL_USER') ?: 'root';
$DB_PASS = getenv('MYSQL_PASS') ?: '';

try {
    $dsn = "mysql:host={$DB_HOST};port={$DB_PORT};dbname={$DB_NAME};charset=utf8mb4";
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo "Koneksi DB gagal: " . htmlspecialchars($e->getMessage());
    exit;
}
