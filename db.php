<?php
// db.php - Neon (Postgres) connection via PDO
$DB_HOST = getenv('NEON_HOST') ?: 'your-neon-host';
$DB_PORT = getenv('NEON_PORT') ?: '5432';
$DB_NAME = getenv('NEON_DB')   ?: 'your_db';
$DB_USER = getenv('NEON_USER') ?: 'your_user';
$DB_PASS = getenv('NEON_PASS') ?: 'your_password';

try {
    $dsn = "pgsql:host={$DB_HOST};port={$DB_PORT};dbname={$DB_NAME};sslmode=require";
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo "Koneksi DB gagal: " . htmlspecialchars($e->getMessage());
    exit;
}
?>
