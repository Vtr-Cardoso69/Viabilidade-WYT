<?php
session_start();

require_once __DIR__ . '/../BE/DB/Database.php';
require_once __DIR__ . '/../BE/Controller/EmpresaController.php';
require_once __DIR__ . '/../BE/Model/EmpresaModel.php';

$errors = [];

$nome = '';
$email = '';
$cnpj = '';
$senha = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = $conn;

    $empresaModel = new EmpresaModel($pdo);
    $empresaController = new EmpresaController($pdo);

    $nome = (string)($_POST['nome'] ?? '');
    $email = (string)($_POST['email'] ?? '');
    $cnpj = (string)($_POST['cnpj'] ?? '');
    $senha = (string)($_POST['senha'] ?? '');

    $cnpjNumeros = preg_replace('/\D+/', '', $cnpj);

    try {
        $cadastro = $empresaController->cadastrarEmpresa($nome, $email, $cnpjNumeros, $senha);

        if ($cadastro) {
            $empresaController->loginEmpresa($email, $senha);
            header('Location: ../index.php');
            exit;
        } else {
            echo "<script>alert('Email já cadastrado!');</script>";
        }
    } catch (Throwable $e) {
        $errors[] = 'Erro ao cadastrar.';
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>cadastro EMPRESA</title>
</head>
<body>
    <h1>cadastro EMPRESA</h1>

    <?php if ($errors): ?>
        <p><strong>Confira:</strong></p>
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars((string)$err, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="">
        <label for="nome">Nome</label><br />
        <input id="nome" name="nome" type="text" required value="<?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') ?>" />
        <br /><br />

        <label for="email">E-mail</label><br />
        <input id="email" name="email" type="email" required value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" />
        <br /><br />

        <label for="cnpj">CNPJ</label><br />
        <input id="cnpj" name="cnpj" type="text" required placeholder="00.000.000/0000-00" value="<?= htmlspecialchars($cnpj, ENT_QUOTES, 'UTF-8') ?>" />
        <br /><small>Somente números são salvos.</small>
        <br /><br />

        <label for="senha">Senha</label><br />
        <input id="senha" name="senha" type="password" required />
        <br /><br />

        <button type="submit">Cadastrar</button>
        <a href="../index.php">Voltar</a>
    </form>
</body>
</html>
