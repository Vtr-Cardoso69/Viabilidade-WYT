<?php

require_once '../BE/DB/Database.php';
require_once '../BE/Controller/SimulacaoController.php';
require_once '../BE/Controller/adm/cidadeC.php';


$simulacaoController = new SimulacaoController($pdo);

/* CONTROLADOR DAS CIDADES */
$cidadeController = new CidadeController();

/* BUSCAR TODAS AS CIDADES */
$cidades = $cidadeController->index();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php

session_start();

?>
<body>
     <header>
        <img src="bussola.php" alt="Bússola">
        <img src="logo.php" alt="Logo">
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


    <label for="investimento">Investimento: </label>
    <input type="number" name="investimento" id="investimento" min="0" step="0.01" required><br><br>

    <label for="ancoras">Quantidade de Ancoras: </label>
    <input type="number" name="quant_ancoras" id="quant_ancoras" min="0" required><br><br>

    <label for = "preco_medio"> Preço Médio dos Produtos: </label>
    <input type="number" name="preco_medio" id="preco_medio" min="0" step="0.01" required><br><br>

    <input type="submit" value="Simular">

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
    $cidade_id = $_POST['cidade_id'];
    $empresa_id = $_SESSION['id'];
    $quant_ancoras = $_POST['quant_ancoras'];

    $probabilidade_sucesso = $simulacaoController->calcularProbabilidadeSucesso($cidade_id, $empresa_id, $quant_ancoras);

    echo "Probabilidade de Sucesso: " . $probabilidade_sucesso . "%";

    echo "Caso seu negócio tenha sucesso: <br>";
}

?>