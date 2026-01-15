<?php
header('Content-Type: application/json');
require_once 'db.php'; 

try {
    $sql = "SELECT p.id, p.Title, p.Latitude, p.Longitude, p.Status, c.name as category_name 
            FROM places p
            LEFT JOIN categories c ON p.Categoryid = c.id 
            WHERE p.Status = 'Active'";  
            
    $stmt = $pdo->query($sql);
    echo json_encode($stmt->fetchAll());
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>