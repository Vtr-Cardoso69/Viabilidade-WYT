<?php
session_start();

require_once __DIR__ . '/../BE/DB/Database.php';

if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: ../index.php');
    exit;
}

$empresa = null;
$error = null;

try {
    if (!empty($_SESSION['empresa_id'])) {
        $stmt = $conn->prepare('SELECT id, nome, email, cnpj FROM empresas WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => (int)$_SESSION['empresa_id']]);
        $empresa = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
} catch (Throwable $e) {
    $error = 'Erro ao carregar seus dados.';
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Usuário</title>
</head>
<body>
    <h1>Usuário</h1>
    <p>
        <a href="cadastro.php">Cadastro</a> |
        <a href="adm.php">Admin</a> |
        <a href="../index.php">Início</a>
    </p>

    <?php if ($error): ?>
        <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <?php if (!$empresa): ?>
        <p>Nenhum usuário carregado. Cadastre uma empresa para entrar.</p>
        <p><a href="cadastro.php">Ir para cadastro</a></p>
    <?php else: ?>
        <p><strong>ID:</strong> <?= htmlspecialchars((string)$empresa['id'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Nome:</strong> <?= htmlspecialchars((string)$empresa['nome'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>E-mail:</strong> <?= htmlspecialchars((string)$empresa['email'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>CNPJ:</strong> <?= htmlspecialchars((string)$empresa['cnpj'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><a href="?logout=1">Sair</a></p>
    <?php endif; ?>
</body>
</html>
