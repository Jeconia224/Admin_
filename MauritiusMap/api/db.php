<?php
// C:\wamp64\www\MauritiusMap\api\db.php
$host = 'localhost';
$db   = 'mauritian_map';
$user = 'root';
$pass = '';     // Empty password for WAMP
$charset = 'utf8mb4';

try {
    $dsn = "mysql:host=$host;port=3307;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die(json_encode([
        'success' => false,
        'message' => 'Database Connection Error: ' . $e->getMessage()
    ]));
}
?>