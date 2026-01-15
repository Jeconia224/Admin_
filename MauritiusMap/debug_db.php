<?php
echo "<h2>MariaDB Connection Debug</h2>";

try {
    $pdo = new PDO('mysql:host=localhost;dbname=mauritian_map;charset=utf8mb4', 'root', '');
    echo "Connected to 'mauritian_map' database!<br>";
    
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables found: " . implode(', ', $tables) . "<br>";
    
} catch (PDOException $e) {
    echo "Failed to connect to 'mauritian_map': " . $e->getMessage() . "<br>";
}

echo "<hr>";

try {
    $pdo2 = new PDO('mysql:host=localhost;charset=utf8mb4', 'root', '');
    echo " Connected to MariaDB server (no database selected)<br>";
    
    $databases = $pdo2->query("SHOW DATABASES")->fetchAll(PDO::FETCH_COLUMN);
    echo "All databases: <br>";
    foreach ($databases as $db) {
        echo "&nbsp;&nbsp;- $db<br>";
    }
    
} catch (PDOException $e) {
    echo "Cannot connect to MariaDB at all: " . $e->getMessage() . "<br>";
    echo "Make sure MariaDB service is running in WAMP!<br>";
}

echo "<hr>";

$passwords = ['', 'root', 'password'];
foreach ($passwords as $pass) {
    try {
        $test = new PDO('mysql:host=localhost;dbname=mauritian_map;charset=utf8mb4', 'root', $pass);
        echo "✅ Password found: '$pass' works!<br>";
        break;
    } catch (Exception $e) {
    }
}
?>