<?php

session_start();

require_once __DIR__ . '/../BE/DB/Database.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare(
        "SELECT * FROM empresas WHERE email = ?"
    );

    $stmt->execute([$email]);

    $empresas = $stmt->fetch();

    if (!$empresas) {
        $erro = "Empresa não encontrada";
    } elseif (!password_verify($senha, $empresas['senha'])) {
        $erro = "Senha incorreta";
    } else {
        // CRIA A SESSÃO
        $_SESSION['empresa_id'] = $empresas['id'];
        $_SESSION['nome'] = $empresas['nome'];
        $_SESSION['email'] = $empresas['email'];

        header("Location: ../index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<body>

<h1>Login Empresa</h1>

<?php if ($erro): ?>
    <p style="color: red;"><?php echo htmlspecialchars($erro); ?></p>
<?php endif; ?>

<form method="POST">

    <label>Email:</label>
    <input type="email" name="email" required>
    <br><br>

    <label>Senha:</label>
    <input type="password" name="senha" required>
    <br><br>

    <button type="submit">
        Entrar
    </button>

</form>

<p><a href="../index.php">Voltar</a></p>

</body>
</html>