<?php
header('Content-Type: application/json');
require_once 'db.php';  

try {
    $stmt = $pdo->query("SELECT id, name FROM categories ORDER BY id ASC");
    $categories = $stmt->fetchAll();
    echo json_encode($categories);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>