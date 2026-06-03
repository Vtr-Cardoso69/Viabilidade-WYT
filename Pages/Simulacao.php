<?php

require_once 'C:/Turma2/xampp/htdocs/Viabilidade-WYT/BE/DB/Database.php';
require_once 'C:/Turma2/xampp/htdocs/Viabilidade-WYT/BE/Controller/SimulacaoController.php';
require_once 'C:/Turma2/xampp/htdocs/Viabilidade-WYT/BE/Controller/adm/cidadeC.php';

/* CONTROLADOR DAS CIDADES */
$cidadeController = new CidadeController();

/* BUSCAR TODAS AS CIDADES */
$cidades = $cidadeController->index();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php

session_start();

?>

<?php

if(!isset($_SESSION['empresa_id'])){
    echo "<script>alert('Faça login para acessar a simulação!');</script>";
    header('Location: ../index.php');
    exit;
}

?>
<body>
     <header>
        <img src="img/bussola.png" alt="Bússola">
        <img src="img/logo.png" alt="Logo">
        <?php if (isset($_SESSION['empresa_id'])) {
        echo "<p><a href='Pages/perfilUsuarios.php?id=" . $_SESSION['empresa_id'] . "'>Bem-vindo(a), " . $_SESSION['nome'] . "!</a></p>";
    } elseif(!isset($_SESSION['empresa_id'])){
        echo "<p><a href='Pages/cadastroEmpresa.php'>Cadastre-se</a></p> <p>ou</p> <p><a href='Pages/loginEmpresa.php'>Faça login</a></p>";
    }
    ?>
         <a href="">INICIAR</a>
         <p>ou</p>
            <a href="">CADASTRAR</a>
    </header>
    

    <nav>
            <a href="#"></a>
            <a href="#"></a>
            <a href="#"></a>
            <a href="#"></a>
             <a href="#"></a>
            <a href="#"></a>
    </nav>

<form method="POST">
   <label>Cidade:</label>
<select name="cidade_id" required>
    <option value="">
        -- Selecione --
    </option>
    <?php foreach ($cidades as $cidade): ?>
        <option value="<?= $cidade['id'] ?>">
            <?= htmlspecialchars($cidade['nome']) ?>
        </option>
    <?php endforeach; ?>
</select>
<style>
.tooltip {
    position: relative;
    display: inline-block;
    cursor: pointer;
    color: blue;
    text-decoration: underline;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 280px;
    background-color: #f8f8f8;
    color: #333;
    text-align: left;
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 10px;
    position: absolute;
    z-index: 1;
    top: 125%;
    left: 50%;
    transform: translateX(-50%);
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.tooltip.active .tooltiptext {
    visibility: visible;
}
</style>
<label for="investimento">Investimento: </label>
<input type="number" name="investimento" id="investimento" min="0" step="0.01" required><br><br>

<label for="quant_ancoras">
    Quantidade de
    <span class="tooltip" onclick="toggleTooltip(this)">
        Âncoras
        <span class="tooltiptext">
            Âncoras: pontos próximos que garantem a sustentação, atração e rentabilidade do negócio (escolas, empresas, comércios, etc.).
        </span>
    </span>:
</label>

<input type="number" name="quant_ancoras" id="quant_ancoras" min="0" required><br><br>

<label for="preco_medio">Preço Médio dos Produtos:</label>
<input type="number" name="preco_medio" id="preco_medio" min="0" step="0.01" required><br><br>

<input type="submit" value="Simular">

<script>
function toggleTooltip(element) {
    element.classList.toggle("active");
}
</script>
</form>

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


<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $simulacaoController = new SimulacaoController($pdo);

    
    $cidade_id = $_POST['cidade_id'];
    $empresa_id = $_SESSION['empresa_id'];
    $quant_ancoras = $_POST['quant_ancoras'];
    $preco_produto = $_POST['preco_medio'];
    $investimento = $_POST['investimento'];
    $preco_produto = $_POST['preco_medio'];
    $probabilidade_sucesso = $simulacaoController->calcularProbabilidadeSucesso($cidade_id, $empresa_id, $quant_ancoras);

    $renda_mensal = $simulacaoController->calcularRendaMensal($cidade_id, $empresa_id, $preco_produto);

    $break_even = $simulacaoController->calcularBreakEven($investimento, $cidade_id, $empresa_id, $preco_produto);

    $simulacaoController->fazerSimulacao($cidade_id, $empresa_id, $quant_ancoras, $preco_produto, $investimento, $probabilidade_sucesso, $renda_mensal, $break_even);

    echo "Probabilidade de Sucesso: " . $probabilidade_sucesso . "%<br>";
    echo "Caso seu negócio tenha sucesso: <br>";
    echo "Sua renda mensal será de: R$ " . $renda_mensal . "<br>";
    echo "Você atingirá o break even em: " . round($break_even,0) . " " . (round($break_even,0) == 1 ? "mês" : "meses") . ".<br>";
}

?>