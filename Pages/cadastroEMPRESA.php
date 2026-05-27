<?php
session_start();

require_once __DIR__ . '/../BE/DB/Database.php';
require_once __DIR__ . '/../BE/Controller/EmpresaController.php';

$errors = [];

$nome = '';
$email = '';
$cnpj = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim((string)($_POST['nome'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $cnpj = trim((string)($_POST['cnpj'] ?? ''));
    $senha = (string)($_POST['senha'] ?? '');
    $confirmarSenha = (string)($_POST['confirmar_senha'] ?? '');

    $cnpjNumeros = preg_replace('/\D+/', '', $cnpj);

    if ($nome === '' || $email === '' || $cnpjNumeros === '' || $senha === '') {
        $errors[] = 'Preencha todos os campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Informe um e-mail válido.';
    } elseif (strlen($cnpjNumeros) !== 14) {
        $errors[] = 'Informe um CNPJ válido (14 números).';
    } elseif ($senha !== $confirmarSenha) {
        $errors[] = 'As senhas não conferem.';
    } else {
        try {
            $controller = new EmpresaController($conn);
            $ok = $controller->cadastrarEmpresa($nome, $email, $cnpjNumeros, $senha);

            if (!$ok) {
                $errors[] = 'Já existe uma empresa cadastrada com este e-mail.';
            } else {
                // Faz login logo após cadastrar para criar sessão
                $empresa = $controller->loginEmpresa($email, $senha);
                if ($empresa) {
                    header('Location: usuario.php');
                    exit;
                }
                header('Location: usuario.php');
                exit;
            }
        } catch (Throwable $e) {
            $errors[] = 'Erro ao cadastrar.';
        }
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

        <label for="confirmar_senha">Confirmar senha</label><br />
        <input id="confirmar_senha" name="confirmar_senha" type="password" required />
        <br /><br />

        <button type="submit">Cadastrar</button>
        <a href="../index.php">Voltar</a>
    </form>
</body>
</html>
