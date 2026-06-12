<?php
session_start();

require_once __DIR__ . '/../BE/Controller/EmpresaController.php';
require_once __DIR__ . '/../BE/Model/EmpresaModel.php';
require_once __DIR__ . '/../BE/DB/Database.php';

$edicao = isset($_GET['editar']) && isset($_SESSION['empresa_id']);

$empresa = null;

if ($edicao) {

    $empresaController = new EmpresaController($pdo);

    $empresa = $empresaController->listarInformacoesEmpresa(
        $_SESSION['empresa_id']
    );
}

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
    
    // Se estiver em edição e senha estiver vazia, mantém a senha atual
    if ($edicao && empty($senha)) {
        $senhaHash = $empresa['senha'];
    } else {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    }

    $cargo = $createCargo;

    if ($edicao) {

        $resultado = $empresaController->editarEmpresa(
            $nome,
            $email,
            $cnpj,
            $tipo_comercio,
            $perfil_economico,
            $perfil_etario,
            $senhaHash,
            $_SESSION['empresa_id']
        );

        if ($resultado) {

            $_SESSION['nome'] = $nome;
            $_SESSION['email'] = $email;

            header('Location: perfilUsuarios.php');
            exit;
        } else {
            echo "<script>alert('Erro ao atualizar informações!');</script>";
        }

    } else {

        $resultado = $empresaController->cadastroEmpresa(
            $nome,
            $email,
            $cnpj,
            $tipo_comercio,
            $perfil_economico,
            $perfil_etario,
            $senhaHash,
            $cargo
        );

        if ($resultado) {

            if ($fromAdminCreate) {
                header('Location: adm/index.php');
                exit;
            }

            $stmt = $pdo->prepare("SELECT * FROM empresas WHERE email = ?");
            $stmt->execute([$email]);
            $empresa = $stmt->fetch();

            if ($empresa) {
                $_SESSION['empresa_id'] = $empresa['id'];
                $_SESSION['nome'] = $empresa['nome'];
                $_SESSION['email'] = $empresa['email'];
                $_SESSION['cargo'] = $empresa['cargo'];
            }

            header('Location: ../index.php');
            exit;
        } else {
            echo "<script>alert('Email ou CNPJ já cadastrado!');</script>";
        }

    }
}
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../CSS/cadastro.css" />
    <link rel="stylesheet" href="../CSS/index.css" />
    <title><?= $edicao ? 'Editar Empresa' : 'Cadastro de Empresa' ?></title>
</head>
<body>

      <nav class="nav1">

   <header>
        <img width="100" height="100" src="../img/bussola.png" alt="Bússola" class="bussola" id="bussola">
        <img width="100" height="100" src="../img/logo.png" alt="Logo" class="logo">
    </header>
          
    </nav>
    
    <nav class="nav2" id="menu">


      <a href="http://localhost/viabilidade-wyt">Início</a>
    

    <div>
        <h3>NOSSA HISTORIA</h3>
        <a href="sobre.php">Sobre Nós</a>
    </div>

     <div>
      <h3>SUPORTE</h3>
      <ul>
        <li><a href="rodape/central.php">Central de Ajuda</a></li>
        <li><a href="rodape/politica.php">Política de Privacidade</a></li>
        <li><a href="rodape/termos.php">Termos de Uso</a></li>
        <li><a href="rodape/faq.php">FAQ</a></li>
      </ul>
    </div>
    
    <div>
      <h3>SOCIAL</h3>
      <ul>
        <li><a href="#">Instagram</a></li>
        <li><a href="#">Facebook</a></li>
        <li><a href="#">Tiktok</a></li>
      </ul>
    </div>

   </nav>

    <h1><?= $edicao ? 'EDIÇÃO DE EMPRESA' : 'CADASTRO DE EMPRESA' ?></h1>

    <form method="post" action="">
    <div class="campo">
            <label for="nome">Nome</label><br />
            <input
            id="nome"
            name="nome"
            type="text"
            required
            value="<?= $empresa['nome'] ?? '' ?>"
        />
    </div>

    <br /><br />

    <div class="campo">
            <label for="email">E-mail</label><br />
            <input
            id="email"
            name="email"
            type="email"
            required
            value="<?= $empresa['email'] ?? '' ?>"
        />
    </div>
      
    <br /><br />

    <div class="campo">
            <label for="cnpj">CNPJ</label><br />
            <input
            id="cnpj"
            name="cnpj"
            type="text"
            maxlength="18"
            required
            placeholder="00.000.000/0000-00"
            value="<?= $empresa['cnpj'] ?? '' ?>"
        />
    </div>
    
    <br /><br />

    
    <div class="campo">
                <label for="tipoComercio">Tipo de Comércio</label><br />
                <select id="tipoComercio" name="tipoComercio" required>
                    <option value="">Selecione</option>
                    <option value="Alimentacao"<?= (($empresa['tipo_comercio'] ?? '') == 'Alimentacao') ? 'selected' : '' ?>>Alimentação</option>
                    <option value="Moda"<?= (($empresa['tipo_comercio'] ?? '') == 'Moda') ? 'selected' : '' ?>>Moda</option>
                    <option value="Tecnologia"<?= (($empresa['tipo_comercio'] ?? '') == 'Tecnologia') ? 'selected' : '' ?>>Tecnologia</option>
                    <option value="Varejo"<?= (($empresa['tipo_comercio'] ?? '') == 'Varejo') ? 'selected' : '' ?>>Varejo</option>
                    <option value="Servicos"<?= (($empresa['tipo_comercio'] ?? '') == 'Servicos') ? 'selected' : '' ?>>Serviços</option>
                    <option value="Turismo"<?= (($empresa['tipo_comercio'] ?? '') == 'Turismo') ? 'selected' : '' ?>>Turismo</option>
                </select>
                <br /><br />
            </div>


            <div class="campo">
                <label for="perfil_economico">Perfil Econômico</label><br />
                <select id="perfil_economico" name="perfil_economico" required>
                    <option value="">Selecione</option>
                    <option value="Baixa Renda"<?= (($empresa['perfil_economico'] ?? '') == 'Baixa Renda') ? 'selected' : '' ?>>Baixa Renda</option>
                    <option value="Media Renda"<?= (($empresa['perfil_economico'] ?? '') == 'Media Renda') ? 'selected' : '' ?>>Média Renda</option>
                    <option value="Alta Renda"<?= (($empresa['perfil_economico'] ?? '') == 'Alta Renda') ? 'selected' : '' ?>>Alta Renda</option>
                </select>
                <br /><br />
            </div>

            <div class="campo">
                <label for="perfil_etario">Perfil Etário</label><br />
                <select id="perfil_etario" name="perfil_etario" required>
                    <option value="">Selecione</option>
                    <option value="Criancas (0-12 anos)"<?= (($empresa['perfil_etario'] ?? '') == 'Criancas (0-12 anos)') ? 'selected' : '' ?>>Crianças (0-12 anos)</option>
                    <option value="Jovens (13-29 anos)"<?= (($empresa['perfil_etario'] ?? '') == 'Jovens (13-29 anos)') ? 'selected' : '' ?>>Jovens (13-29 anos)</option>
                    <option value="Adultos (30-59 anos)"<?= (($empresa['perfil_etario'] ?? '') == 'Adultos (30-59 anos)') ? 'selected' : '' ?>>Adultos (30-59 anos)</option>
                    <option value="Idosos (60 anos ou mais)"<?= (($empresa['perfil_etario'] ?? '') == 'Idosos (60 anos ou mais)') ? 'selected' : '' ?>>Idosos (60 anos ou mais)</option>
                </select>
                <br /><br />
            </div>

            <div class="campo">
                <label for="senha">Senha</label><br />
                <input id="senha" name="senha" type="password" <?= $edicao ? '' : 'required' ?> placeholder="<?= $edicao ? 'Novo senha (opcional)' : '' ?>" />
                <br /><br />
            </div>

            <button type="submit"><?= $edicao ? 'Salvar Alterações' : 'Cadastrar' ?></button>

                                        </form>
    
        
<footer>
         <p>&copy; 2026 WYT - Todos os direitos reservados</p>
</footer>

</body>
        
<script>
    // Máscara CNPJ
    document.getElementById('cnpj').addEventListener('input', function (e) {
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

    // script do nav 
    
    const bussola = document.getElementById("bussola");
    const menu = document.getElementById("menu");

    bussola.addEventListener("click", () => {
        bussola.classList.toggle("girada");
        menu.classList.toggle("abrir");
    });

</script>

</html>