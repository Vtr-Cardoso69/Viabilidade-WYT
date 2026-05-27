<?php
session_start();

require_once __DIR__ . '/../BE/Controller/EmpresaController.php';
require_once __DIR__ . '/../BE/Model/EmpresaModel.php';
require_once __DIR__ . '/../BE/DB/Database.php';

function getPDOConnection() {
    global $conn;
    return $conn;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = getPDOConnection();
    $empresaModel = new EmpresaModel($pdo);
    $empresaController = new EmpresaController($empresaModel);

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cnpj = $_POST['cnpj'];
    $senha = $_POST['senha'];

    $cadastro = $empresaController->cadastrarEmpresa($nome,$email,$cnpj,$senha);

    if($cadastro){
        $empresaController->loginEmpresa($email,$senha);
        header('Location: ../index.php');
    }else{
        echo "<script>alert('Email já cadastrado!');</script>";
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

    <form method="post" action="">
        <label for="nome">Nome</label><br />
        <input id="nome" name="nome" type="text" required />
        <br /><br />

        <label for="email">E-mail</label><br />
        <input id="email" name="email" type="email" required />
        <br /><br />

        <label for="cnpj">CNPJ</label><br />
        <input id="cnpj" name="cnpj" type="text" required placeholder="00.000.000/0000-00" />
        <br /><br />

        <label for="senha">Senha</label><br />
        <input id="senha" name="senha" type="password" required />
        <br /><br />

        <button type="submit">Cadastrar</button>
        <a href="../index.php">Voltar</a>
    </form>
</body>
</html>
