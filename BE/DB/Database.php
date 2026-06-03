<?php

$host = 'localhost';
$username = 'root';
$password = '';
$Database = 'wyt';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$Database;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Compatibilidade com código que usa $conn
    $conn = $pdo;
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}

function getPDOConnection() {
    global $pdo;
    return $pdo;
}

?>

