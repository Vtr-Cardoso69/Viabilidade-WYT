<?php
/**
 * teste-perfil.php - Arquivo de teste para simular acesso ao perfil
 * Use este arquivo para testar a integração completa
 */

// Simular uma sessão autenticada com um ID de empresa
session_start();
$_SESSION['empresa_id'] = 1; // Substitua por um ID válido no seu banco

// Redirecionar para a página de perfil
header('Location: Pages/perfilUsuarios.php');
exit;
?>
