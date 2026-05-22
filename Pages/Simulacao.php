<?php

require_once __DIR__ . '/../BE/DB/Database.php';
require_once __DIR__ . '/../BE/Controller/SimulacaoController.php';

$simulacaoController = new SimulacaoController($pdo);
$cidades = $simulacaoController->listarCidades();
$empresas = $simulacaoController->listarEmpresas();
$resultado = null;
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $resultado = $simulacaoController->calcularProbabilidadeSucesso(
            $_POST['cidade_id'],
            $_POST['empresa_id'],
            $_POST['investimento'],
            $_POST['quant_ancoras'],
            $_POST['preco_medio']
        );
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}

function formatarDinheiro($valor) {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulacao</title>
</head>
<body>

<form method="POST">

    <label for="cidade_id">Cidade: </label>
    <select name="cidade_id" id="cidade_id" required>
        <option value="">Selecione</option>
        <?php foreach ($cidades as $cidade): ?>
            <option value="<?= $cidade['id'] ?>">
                <?= htmlspecialchars($cidade['nome']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="empresa_id">Empresa: </label>
    <select name="empresa_id" id="empresa_id" required>
        <option value="">Selecione</option>
        <?php foreach ($empresas as $empresa): ?>
            <option value="<?= $empresa['id'] ?>">
                <?= htmlspecialchars($empresa['nome'] . ' - ' . $empresa['tipo_comercio']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="investimento">Investimento: </label>
    <input type="number" name="investimento" id="investimento" min="0" step="0.01"><br><br>

    <label for="ancoras">Quantidade de Ancoras: </label>
    <input type="number" name="quant_ancoras" id="quant_ancoras" min="0"><br><br>

    <label for="preco_medio">Preco Medio dos Produtos: </label>
    <input type="number" name="preco_medio" id="preco_medio" min="0" step="0.01"><br><br>

    <input type="submit" value="Simular">

</form>

<?php if ($erro): ?>
    <p><?= htmlspecialchars($erro) ?></p>
<?php endif; ?>

<?php if ($resultado): ?>
    <h2>Resultado</h2>

    <p>Clientes por mes: <?= number_format($resultado['clientes_mensais'], 0, ',', '.') ?></p>
    <p>Faturamento mensal: <?= formatarDinheiro($resultado['faturamento_mensal']) ?></p>
    <p>Lucro mensal: <?= formatarDinheiro($resultado['lucro_mensal']) ?></p>
    <p>Break-even: <?= number_format($resultado['break_even'], 1, ',', '.') ?> meses</p>
    <p>Chance de viabilidade: <?= number_format($resultado['probabilidade_sucesso'], 0, ',', '.') ?>%</p>
<?php endif; ?>

</body>
</html>
