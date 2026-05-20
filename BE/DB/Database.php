<?php

$host = 'localhost';
$username = 'root'; 
$password = '';
$Database = 'wyt';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$Database;charset=utf8",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}