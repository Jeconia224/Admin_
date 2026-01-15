<?php
header('Content-Type: application/json');
require_once '../db.php';
$stats = [
    "totalCategories" => $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn(),
    "totalPlaces" => $pdo->query("SELECT COUNT(*) FROM places")->fetchColumn(),
    "totalQRCodes" => 0, 
    "recentPlaces" => $pdo->query("SELECT p.Title as title, c.name as categoryName, p.Status as status 
                                   FROM places p 
                                   LEFT JOIN categories c ON p.Categoryid = c.id 
                                   ORDER BY p.id DESC LIMIT 5")->fetchAll()
];
echo json_encode($stats);
?>