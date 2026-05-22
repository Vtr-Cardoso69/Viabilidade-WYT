<?php

require_once '../DB/Database.php';
require_once '../Controller/SimulacaoController.php';

$simulacaoController = new SimulacaoController($pdo);

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
    

<form method="POST">

    <label for="cidade">Cidade: </label>
    <select></select><br><br>
   
    <label for="investimento">Investimento: </label>
    <input type="number" name="investimento" id="investimento" min="0" step="0.01"><br><br>

    <label for="ancoras">Quantidade de Ancoras: </label>
    <input type="number" name="quant_ancoras" id="quant_ancoras" min="0"><br><br>

    <label for = "preco_medio"> Preço Médio dos Produtos: </label>
    <input type="number" name="preco_medio" id="preco_medio" min="0" step="0.01"><br><br>

    <input type="submit" value="Simular">

</form>


</body>
</html>


<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cidade_id = $_POST['cidade_id'];
    $empresa_id = $_SESSION['id'];
    $quant_ancoras = $_POST['quant_ancoras'];

    $probabilidade_sucesso = $simulacaoController->calcularProbabilidadeSucesso($cidade_id, $empresa_id, $quant_ancoras);

    echo "Probabilidade de Sucesso: " . $probabilidade_sucesso . "%";
}

?>