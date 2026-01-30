<?php 

// $server = 'localhost';
// $username = 'root';
// $password = '';
// $database = 'inventory_db';

$server = 'localhost';
$username = 'np03cs4a240251';
$password = 'B9WvLgGxX6';
$database = 'np03cs4a240251';


try {
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    $pdo = new PDO(
        "mysql:host=$server;dbname=$database;charset=utf8mb4",
        $username,
        $password,
        $options
    );

   //echo "<h3 style='color:green;'>Database connected</h3>";

} catch (PDOException $e) {
    die("Connection Failed: " . $e->getMessage());
}

?>
