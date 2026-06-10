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
        $_SESSION['cargo'] = $empresas['cargo'];

        header("Location: ../index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../CSS/login.css">
    </head>
<body>
 <header>
        <img width="100" height="100" src="../img/bussola.png" alt="Bússola">
        <img width="100" height="100" src="../img/logo.png" alt="Logo">
       <p><a href="../index.php">Voltar</a></p>
</header>
<h1>Login Empresa</h1>

<?php if ($erro): ?>
    <p style="color: red;"><?php echo htmlspecialchars($erro); ?></p>
<?php endif; ?>

<form method="POST">

    <div class="campo">
    <label>Email:</label>
    <input type="email" name="email" required>
    <br><br>
    </div>

    <div class="campo">
    <label>Senha:</label>
    <input type="password" name="senha" required>
    <br><br>
    </div>

    <button type="submit">
        entrar
    </button>

</form>



    <footer >
    <p>&copy; 2026 WYT - Todos os direitos reservados</p>
</footer>
</body>
</html>