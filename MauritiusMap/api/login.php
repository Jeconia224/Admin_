<?php
header('Content-Type: application/json');
require_once 'db.php';

session_start();

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['mail'] ?? $data['Email'] ?? '';
$password = $data['password'] ?? $data['Password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(["success" => false, "message" => "Email and password are required"]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM logins WHERE mail = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) { 
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['email'] = $user['mail'];
        $_SESSION['role'] = $user['role'];
        
        echo json_encode([
            "success" => true, 
            "message" => "Login Successful",
            "user" => [
                "id" => $user['id'],
                "email" => $user['mail'],
                "role" => $user['role']
            ]
        ]);
    } else {
        http_response_code(401);
        echo json_encode(["success" => false, "message" => "Invalid email or password"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Server error: " . $e->getMessage()]);
}
?>