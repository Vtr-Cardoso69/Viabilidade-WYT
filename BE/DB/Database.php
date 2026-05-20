<?php

$host = 'localhost';
$username = 'root'; 
$password = '';
$Database = 'wyt';

try {
    $conn = new PDO("mysql:host=$host;dbname=$Database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}

?>