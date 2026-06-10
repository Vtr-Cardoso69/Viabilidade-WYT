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
<body>
 <header>
        <img width="100" height="100" src="img/bussola.png" alt="Bússola">
        <img width="100" height="100" src="img/logo.png" alt="Logo">
       
</header>
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

    <footer >

     <div>
      <h3>Suporte</h3>
      <ul>
        <li><a href="#">Central de Ajuda</a></li>
        <li><a href="#">Política de Privacidade</a></li>
        <li><a href="#">Termos de Uso</a></li>
        <li><a href="#">FAQ</a></li>
      </ul>
    </div>

    <div>
      <h3>Contato</h3>
      <p> Avenida Paulista, 1636 – Bela Vista, São Paulo – SP, 01310-200</p>
      <p>(11) 99845-3598</p>
      <p> wyt@gmail.com.br</p>
    </div>

 <div>
      <h3>Social</h3>
      <ul>
        <li><a href="#">Instagram</a></li>
        <li><a href="#">Facebook</a></li>
        <li><a href="#">Tiktok</a></li>
      </ul>
    </div>

    <p>&copy; 2026 WYT - Todos os direitos reservados</p>
</footer>
</body>
</html>