<?php
session_start();

require_once __DIR__ . '/../BE/Controller/EmpresaController.php';
require_once __DIR__ . '/../BE/Model/EmpresaModel.php';
require_once __DIR__ . '/../BE/DB/Database.php';



// para verificar se o cadastro recebera cargo de ADM 
$createCargo = 'EMPRESA';
$fromAdminCreate = false;
if (isset($_GET['cargo']) && $_GET['cargo'] === 'ADM') {
    if (!isset($_SESSION['cargo']) || $_SESSION['cargo'] !== 'ADM') {
        header('Location: ../index.php');
        exit;
    }
    $createCargo = 'ADM';
    $fromAdminCreate = true;
}




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

    $cargo = $createCargo;

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
        // Se o cadastro foi iniciado pelo ADM (criando outra conta ADM), não trocar a sessão atual
        if ($fromAdminCreate) {
            header('Location: adm/index.php');
            exit;
        }

        // Configurar sessão após cadastro público bem-sucedido
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
    <link rel="stylesheet" href="../CSS/cadastro.css" />
    <title>Cadastro de Empresa</title>
</head>
<body>

 <header>
        <img width="100" height="100" src="../img/bussola.png" alt="Bússola">
        <img width="100" height="100" src="../img/logo.png" alt="Logo">
       
</header>

    <h1>cadastro Empresa</h1>

    <form method="post" action="">
        <div class="campo">
        <label for="nome">Nome</label><br />
        <input id="nome" name="nome" type="text" required />
        <br /><br />
        </div>

        <div class="campo">
        <label for="email">E-mail</label><br />
        <input id="email" name="email" type="email" required />
        <br /><br />
        </div>

        <div class="campo">
        <label for="cnpj">CNPJ</label><br />
        <input id="cnpj" name="cnpj" type="text" maxlength="18" required placeholder="00.000.000/0000-00" />
        
        <br /><br />

        <div class= "campo">
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
        </div>


        <div class= "campo">
        <label for="perfil_economico">Perfil Econômico</label><br />
        <select id="perfil_economico" name="perfil_economico" required>
            <option value="">Selecione</option>
            <option value="Baixa Renda">Baixa Renda</option>
            <option value="Media Renda">Média Renda</option>
            <option value="Alta Renda">Alta Renda</option>
        </select>
        <br /><br />
        </div>

        <div class= "campo">
        <label for="perfil_etario">Perfil Etário</label><br />
        <select id="perfil_etario" name="perfil_etario" required>
            <option value="">Selecione</option>
            <option value="Criancas (0-12 anos)">Crianças (0-12 anos)</option>
            <option value="Jovens (13-29 anos)">Jovens (13-29 anos)</option>
            <option value="Adultos (30-59 anos)">Adultos (30-59 anos)</option>
            <option value="Idosos (60 anos ou mais)">Idosos (60 anos ou mais)</option>
        </select>
        <br /><br />
        </div>

        <div class= "campo">
        <label for="senha">Senha</label><br />
        <input id="senha" name="senha" type="password" required />
        <br /><br />
        </div>

        <button type="submit">Cadastrar</button>
        
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