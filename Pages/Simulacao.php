<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<form method="POST">
    <label for="tipoComercio">Tipo de Comércio: </label>
    <select name="comercio" id="comercio">
        <option value="" disabled selected>Escolha uma opção</option>
        <option value="Alimentacao">Alimentação</option>
        <option value="Moda">Moda</option>
        <option value="Tecnologia">Tecnologia</option>
        <option value="Varejo">Varejo</option>
        <option value="Servicos">Serviços</option>
        <option value="Turismo">Turismo</option>
    </select><br>

    <label for="perfilEtario">Perfil Etário: </label>
    <select name="perfil_etario" id="perfil_etario">
        <option value="" disabled selected>Escolha uma opção</option>
        <option value="Crianças">Crianças (0-12 anos)</option>
        <option value="Jovens">Jovens (13-29 anos)</option>
        <option value="Adultos">Adultos (30-59 anos)</option>
        <option value="Idosos">Idosos (60+ anos)</option>
    </select><br>

    <label for="perfilEconomico">Perfil Econômico: </label>
    <select name="perfil_economico" id="perfil_economico">
        <option value="" disabled selected>Escolha uma opção</option>
        <option value="Baixo">Baixo</option>
        <option value="Médio">Médio</option>
        <option value="Alto">Alto</option>
    </select><br>

    <label for="ancoras">Quantidade de Ancoras: </label>
    <input type="number" name="quant_ancoras" id="quant_ancoras" min="0"><br><br>

    <label for="investimento">Investimento: </label>
    <input type="number" name="investimento" id="investimento" min="0" step="0.01"><br><br>

    <input type="submit" value="Simular">
</form>


</body>
</html>