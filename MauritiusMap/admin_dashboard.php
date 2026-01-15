<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: login.html"); exit; }

// Simple logic for Create and Delete
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_place'])) {
    $stmt = $pdo->prepare("INSERT INTO places (Title, Latitude, Longitude, Status) VALUES (?, ?, ?, 'Active')");
    $stmt->execute([$_POST['title'], $_POST['lat'], $_POST['lng']]);
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM places WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
}

$places = $pdo->query("SELECT * FROM places")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Mauritius Map</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4">Admin Panel: Manage Heritage Sites</h2>
        
        <div class="card mb-4 p-3">
            <h5>Add New Place</h5>
            <form method="POST" class="row g-2">
                <div class="col-md-4"><input type="text" name="title" class="form-control" placeholder="Title" required></div>
                <div class="col-md-3"><input type="text" name="lat" class="form-control" placeholder="Latitude" required></div>
                <div class="col-md-3"><input type="text" name="lng" class="form-control" placeholder="Longitude" required></div>
                <div class="col-md-2"><button type="submit" name="add_place" class="btn btn-primary w-100">Add</button></div>
            </form>
        </div>

        <table class="table table-bordered bg-white shadow-sm">
            <thead class="table-dark">
                <tr><th>ID</th><th>Title</th><th>Coordinates</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($places as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['Title']) ?></td>
                    <td><?= $p['Latitude'] ?>, <?= $p['Longitude'] ?></td>
                    <td><a href="?delete=<?= $p['id'] ?>" class="btn btn-danger btn-sm">Delete</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>