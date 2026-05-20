<?php
session_start();

require_once __DIR__ . '/../BE/DB/Database.php';

$errors = [];
$success = null;

$nome = '';
$email = '';
$cnpj = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim((string)($_POST['nome'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $senha = (string)($_POST['senha'] ?? '');
    $confirmarSenha = (string)($_POST['confirmar_senha'] ?? '');
    $cnpj = trim((string)($_POST['cnpj'] ?? ''));
    $cnpjNumeros = preg_replace('/\D+/', '', $cnpj);

    if ($nome === '' || $email === '' || $senha === '' || $cnpjNumeros === '') {
        $errors[] = 'Preencha todos os campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Informe um e-mail válido.';
    } elseif (strlen($cnpjNumeros) !== 14) {
        $errors[] = 'Informe um CNPJ válido (14 números).';
    } elseif ($senha !== $confirmarSenha) {
        $errors[] = 'As senhas não conferem.';
    } else {
        try {
            $stmt = $conn->prepare('SELECT id FROM empresas WHERE email = :email OR cnpj = :cnpj LIMIT 1');
            $stmt->execute([':email' => $email, ':cnpj' => $cnpjNumeros]);

            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                $errors[] = 'Já existe uma empresa cadastrada com este e-mail ou CNPJ.';
            } else {
                // Mantém compatível com tabela sem AUTO_INCREMENT
                $nextIdStmt = $conn->query('SELECT COALESCE(MAX(id), 0) + 1 FROM empresas');
                $nextId = (int)($nextIdStmt->fetchColumn() ?: 1);

                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                $insert = $conn->prepare('INSERT INTO empresas (id, nome, email, senha, cnpj) VALUES (:id, :nome, :email, :senha, :cnpj)');
                $insert->execute([
                    ':id' => $nextId,
                    ':nome' => $nome,
                    ':email' => $email,
                    ':senha' => $senhaHash,
                    ':cnpj' => $cnpjNumeros,
                ]);

                $_SESSION['empresa_id'] = $nextId;
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
    <title>Cadastro de Empresa</title>
</head>
<body>
    <h1>Cadastro de Empresa</h1>
    <p>Preencha os dados para criar sua conta.</p>

            <?php if ($success): ?>
                <p><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>

            <?php if ($errors): ?>
                <p><strong>Confira:</strong></p>
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars((string)$err, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <form method="post" action="">
                <label for="nome">Nome da empresa</label>
                <input id="nome" name="nome" type="text" autocomplete="organization" required value="<?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') ?>" /><br /><br />

                <label for="email">E-mail</label>
                <input id="email" name="email" type="email" autocomplete="email" required value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" /><br /><br />

                <label for="cnpj">CNPJ</label>
                <input id="cnpj" name="cnpj" type="text" inputmode="numeric" autocomplete="off" required placeholder="00.000.000/0000-00" value="<?= htmlspecialchars($cnpj, ENT_QUOTES, 'UTF-8') ?>" />
                <small>Somente números são salvos (14 dígitos).</small>
                <br /><br />

                <label for="senha">Senha</label>
                <input id="senha" name="senha" type="password" autocomplete="new-password" required /><br /><br />

                <label for="confirmar_senha">Confirmar senha</label>
                <input id="confirmar_senha" name="confirmar_senha" type="password" autocomplete="new-password" required /><br /><br />

                <button type="submit">Cadastrar</button>
                <a href="../index.php">Voltar</a>
            </form>
</body>
</html>
