<?php
session_start();

require_once __DIR__ . '/../BE/Controller/EmpresaController.php';
require_once __DIR__ . '/../BE/Model/EmpresaModel.php';
require_once __DIR__ . '/../BE/DB/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $empresaController = new EmpresaController($pdo);

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cnpj = preg_replace('/\D+/', '', $_POST['cnpj']);
    $tipo_comercio = $_POST['tipoComercio'];
    $perfil_economico = $_POST['perfil_economico'];
    $perfil_etario = $_POST['perfil_etario'];
    $senha = $_POST['senha'];
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $cargo = $_POST['cargo'] ?? 'EMPRESA'; // Define cargo como 'EMPRESA' por padrão
    $cadastro = $empresaController->cadastroEmpresa(
        $nome,
        $email,
        $cnpj,
        $tipo_comercio,
        $perfil_economico,
        $perfil_etario,
        $senhaHash,
        $cargo
    );

    if ($cadastro) {
        // Configurar sessão após cadastro bem-sucedido
        require_once __DIR__ . '/../BE/DB/Database.php';
        
        $stmt = $pdo->prepare("SELECT * FROM empresas WHERE email = ?");
        $stmt->execute([$email]);
        $empresa = $stmt->fetch();
        
        if ($empresa) {
            $_SESSION['empresa_id'] = $empresa['id'];
            $_SESSION['nome'] = $empresa['nome'];
            $_SESSION['email'] = $empresa['email'];
            $_SESSION['cargo'] = $empresa['cargo']; // Armazena o cargo na sessão
        }
        
        header('Location: ../index.php');
        exit;
    } else {
        echo "<script>alert('Email ou CNPJ já cadastrado!');</script>";
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>cadastro Empresa</title>
</head>
<body>
    <h1>cadastro Empresa</h1>

    <form method="post" action="">
        <label for="nome">Nome</label><br />
        <input id="nome" name="nome" type="text" required />
        <br /><br />

        <label for="email">E-mail</label><br />
        <input id="email" name="email" type="email" required />
        <br /><br />

        <label for="cnpj">CNPJ</label><br />
        <input id="cnpj" name="cnpj" type="text" maxlength="18" required placeholder="00.000.000/0000-00" />
        
        <br /><br />

        <label for="tipoComercio">Tipo de Comércio</label><br />
        <select id="tipoComercio" name="tipoComercio" required>
            <option value="">Selecione</option>
            <option value="Alimentacao">Alimentação</option>
            <option value="Moda">Moda</option>
            <option value="Tecnologia">Tecnologia</option>
            <option value="Varejo">Varejo</option>
            <option value="Servicos">Serviços</option>
            <option value="Turismo">Turismo</option>
        </select>
        <br /><br />

        <label for="perfil_economico">Perfil Econômico</label><br />
        <select id="perfil_economico" name="perfil_economico" required>
            <option value="">Selecione</option>
            <option value="Baixa Renda">Baixa Renda</option>
            <option value="Media Renda">Média Renda</option>
            <option value="Alta Renda">Alta Renda</option>
        </select>
        <br /><br />

        <label for="perfil_etario">Perfil Etário</label><br />
        <select id="perfil_etario" name="perfil_etario" required>
            <option value="">Selecione</option>
            <option value="Criancas (0-12 anos)">Crianças (0-12 anos)</option>
            <option value="Jovens (13-29 anos)">Jovens (13-29 anos)</option>
            <option value="Adultos (30-59 anos)">Adultos (30-59 anos)</option>
            <option value="Idosos (60 anos ou mais)">Idosos (60 anos ou mais)</option>
        </select>
        <br /><br />

        <label for="senha">Senha</label><br />
        <input id="senha" name="senha" type="password" required />
        <br /><br />

        <button type="submit">Cadastrar</button>
        <a href="../index.php">Voltar</a>
    </form>

<script>
 // Máscara CNPJ
        document.getElementById('cnpj').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            if (value.length > 14) value = value.substring(0, 14);
            
            let formatted = '';
            if (value.length > 0) formatted = value.substring(0, 2) + '.';
            if (value.length > 2) formatted += value.substring(2, 5) + '.';
            if (value.length > 5) formatted += value.substring(5, 8) + '/';
            if (value.length > 8) formatted += value.substring(8, 12) + '-';
            if (value.length > 12) formatted += value.substring(12, 14);
            
            e.target.value = formatted;
       
       });
</script>

</body>
</html>