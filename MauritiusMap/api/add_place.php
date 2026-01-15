<?php
header('Content-Type: application/json');
require_once 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$title = $data['title'] ?? '';
$cat_id = $data['category_id'] ?? null;

if (!empty($title) && !empty($cat_id)) {
    try {
        // Updated to use Title and Categoryid
        $stmt = $pdo->prepare("INSERT INTO places (Title, Categoryid, Status) VALUES (?, ?, 'Active')");
        $stmt->execute([$title, $cat_id]);
        echo json_encode(["success" => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Missing Title or Category"]);
}
?>