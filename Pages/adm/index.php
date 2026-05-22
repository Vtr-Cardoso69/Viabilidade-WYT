<?php

require_once __DIR__ . '/../../BE/Controller/adm/cidadeC.php';

$controller = new CidadeController();

/* CREATE */
if (isset($_POST['create'])) {
    $controller->store($_POST);
    header("Location: index.php");
    exit;
}

/* UPDATE */
if (isset($_POST['update'])) {
    $controller->update($_POST);
    header("Location: index.php");
    exit;
}

/* DELETE */
if (isset($_GET['delete'])) {
    $controller->delete($_GET['delete']);
    header("Location: index.php");
    exit;
}

/* EDIT */
$cidadeEdit = null;

if (isset($_GET['edit'])) {
    $cidadeEdit = $controller->edit($_GET['edit']);
}

/* LIST */
$cidades = $controller->index();

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Cidades</title>

    <!-- ESTILO PARA SITE -->
    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
            margin-top: 25px;
        }

        h3 {
            color: #333;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* CONTAINER PRINCIPAL */
        .form-container {
            display: flex;
            gap: 20px;
        }

        .form-left {
            width: 50%;
        }

        .form-left h2 {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
        }

        /* LADO DIREITO */
        .form-right {
            width: 50%;
            background: #f5f5f5;
            border-radius: 10px;
            padding: 20px;
            min-height: 400px;
            border: 2px dashed #ccc;
        }

        /* GRUPOS */
        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 18px;
        }

        /* LABEL */
        .form-group label {
            margin-bottom: 6px;
            font-weight: bold;
        }

        /* INPUT */
        .form-group input {
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            font-size: 15px;
        }

        /* SELECT */
        .form-group select {
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            font-size: 15px;
            background-color: white;
            cursor: pointer;
        }

        /* BOTÕES */
        button {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            font-size: 15px;
            transition: background-color 0.3s ease;
        }



        button[name="create"],
        button[name="update"] {
            background: #4CAF50;
        }
        button[name="cancel"] {
            background: #c41717;
        }

        button[name="create"]:hover,
        button[name="update"]:hover {
            background: #45a049;
        }
        button[name="cancel"]:hover {
            background: #a51e1e;
        }



        .btn-cancel {
            padding: 12px 20px;
            background: gray;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-left: 10px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .btn-cancel:hover {
            background: #555;
        }

        /* TABELA */

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th {
            background: #4CAF50;
            color: white;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        tr:hover {
            background: #f5f5f5;
        }

        /* BOTÕES DA TABELA */

        .btn-edit {
            background: #2196F3;
            color: white;
            padding: 7px 12px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-delete {
            background: #f44336;
            color: white;
            padding: 7px 12px;
            text-decoration: none;
            border-radius: 5px;
        }

        /* INFO BOX */

        .info-box h3 {
            margin-bottom: 15px;
        }

        .info-box p {
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .info-box ul {
            margin-left: 20px;
            margin-top: 10px;
        }

        .info-box li {
            margin-bottom: 10px;
        }

    </style>

    <!-- ESTILOS PARA OS TOGGLES -->
    <style>
        .toggle-btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #5a88b9;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .toggle-btn:hover {
            background-color: #4a7aa0;
        }

        .hidden-box {
            display: flex;
            margin-top: 10px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .hidden-box.active {
            display: flex;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .radio-item input[type="radio"] {
            cursor: pointer;
            margin: 0;
        }

        .radio-item label {
            cursor: pointer;
            margin: 0;
            font-weight: normal;
            user-select: none;
        }
    </style>

    <!-- SCRIPT PARA OS TOGGLES -->
    <script>
        /**
         * Função genérica para alternar visibilidade de um box
         * @param {string} boxId - ID do elemento a ser alternado
         */
        function toggleBox(boxId) {
            const box = document.getElementById(boxId);
            if (box) {
                box.classList.toggle('active');
            }
        }
    </script>

</head>

<body>

    <h1>Painel Administrativo</h1>

    <h2>
        <?= isset($cidadeEdit) && $cidadeEdit ? 'Editar Cidade' : 'Criar Nova Cidade' ?>
    </h2>

    <form method="POST">

        <div class="form-container">

            <!-- ESQUERDA -->
            
            <div class="form-left">

                <!-- ID OCULTO -->
                <input type="hidden" name="id" value="<?= htmlspecialchars($cidadeEdit['id'] ?? '') ?>">

                <!-- NOME DA CIDADE -->
                <div class="form-group">
                    <label>Nome da Cidade</label>
                    <input
                        type="text"
                        name="nome"
                        value="<?= htmlspecialchars($cidadeEdit['nome'] ?? '') ?>"
                        required>
                </div>

               <!-- POPULAÇÃO -->
                <div class="form-group">

                    <label>População</label>
                    <input
                        type="number"
                        name="populacao"
                        min="1000"
                        max="5000000"
                        placeholder="0000000"
                        value="<?= htmlspecialchars($cidadeEdit['populacao_quant'] ?? '') ?>">
                    </div>
                
                    <!-- PERFIL ETÁRIO -->
                <div class="form-group">
                    <label>Perfil Etário</label>
                    <select name="perfil_etario">
                        <option value="">-- Selecione --</option>
                        <option value="Crianças (0-12 anos)"
                            <?= (($cidadeEdit['perfil_etario'] ?? '') == 'Crianças (0-12 anos)') ? 'selected' : '' ?>>
                            Crianças (0-12 anos)
                        </option>
                        <option value="Jovens (13-29 anos)"
                            <?= (($cidadeEdit['perfil_etario'] ?? '') == 'Jovens (13-29 anos)') ? 'selected' : '' ?>>
                            Jovens (13-29 anos)
                        </option>
                        <option value="Adultos (30-59 anos)"
                            <?= (($cidadeEdit['perfil_etario'] ?? '') == 'Adultos (30-59 anos)') ? 'selected' : '' ?>>
                            Adultos (30-59 anos)
                        </option>
                        <option value="Idosos (60 anos ou mais)"
                            <?= (($cidadeEdit['perfil_etario'] ?? '') == 'Idosos (60 anos ou mais)') ? 'selected' : '' ?>>
                            Idosos (60 anos ou mais)
                        </option>
                    </select>
                </div>

                <!-- PERFIL ECONÔMICO -->
                <div class="form-group">
                    <label>Perfil Econômico</label>
                    <select name="perfil_economico">
                        <option value="">-- Selecione --</option>
                        <option value="Baixa Renda" <?= (($cidadeEdit['perfil_economico'] ?? '') == 'Baixa Renda') ? 'selected' : '' ?>>
                            Baixa Renda
                        </option>
                        <option value="Média Renda" <?= (($cidadeEdit['perfil_economico'] ?? '') == 'Média Renda') ? 'selected' : '' ?>>
                            Média Renda
                        </option>
                        <option value="Alta Renda" <?= (($cidadeEdit['perfil_economico'] ?? '') == 'Alta Renda') ? 'selected' : '' ?>>
                            Alta Renda
                        </option>
                    </select>
                </div>
              
         <h2>Avalie a Cidade com Chances de Negócio</h2>

                <!-- ALIMENTAÇÃO -->
                <div class="form-group">
                    <button type="button" class="toggle-btn" onclick="toggleBox('alimentacao-box')">
                        Comércio Alimentação ▼
                    </button>
                    <div id="alimentacao-box" class="hidden-box">
                        <?php for ($i = 0; $i <= 20; $i++): ?>
                            <label class="radio-item">
                                <input
                                    type="radio"
                                    name="alimentacao"
                                    value="<?= $i ?>"
                                    <?= (($cidadeEdit['comercio_alimentacao'] ?? 0) == $i) ? 'checked' : '' ?>>
                                <?= $i ?>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- MODA -->
                <div class="form-group">
                    <button type="button" class="toggle-btn" onclick="toggleBox('moda-box')">
                        Comércio Moda ▼
                    </button>
                    <div id="moda-box" class="hidden-box">
                        <?php for ($i = 0; $i <= 20; $i++): ?>
                            <label class="radio-item">
                                <input
                                    type="radio"
                                    name="moda"
                                    value="<?= $i ?>"
                                    <?= (($cidadeEdit['comercio_moda'] ?? 0) == $i) ? 'checked' : '' ?>>
                                <?= $i ?>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- TECNOLOGIA -->
                <div class="form-group">
                    <button type="button" class="toggle-btn" onclick="toggleBox('tecnologia-box')">
                        Comércio Tecnologia ▼
                    </button>
                    <div id="tecnologia-box" class="hidden-box">
                        <?php for ($i = 0; $i <= 20; $i++): ?>
                            <label class="radio-item">
                                <input
                                    type="radio"
                                    name="tecnologia"
                                    value="<?= $i ?>"
                                    <?= (($cidadeEdit['comercio_tecnologia'] ?? 0) == $i) ? 'checked' : '' ?>>
                                <?= $i ?>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- VAREJO -->
                <div class="form-group">
                    <button type="button" class="toggle-btn" onclick="toggleBox('varejo-box')">
                        Comércio Varejo ▼
                    </button>
                    <div id="varejo-box" class="hidden-box">
                        <?php for ($i = 0; $i <= 20; $i++): ?>
                            <label class="radio-item">
                                <input
                                    type="radio"
                                    name="varejo"
                                    value="<?= $i ?>"
                                    <?= (($cidadeEdit['comercio_varejo'] ?? 0) == $i) ? 'checked' : '' ?>>
                                <?= $i ?>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- SERVIÇOS -->
                <div class="form-group">
                    <button type="button" class="toggle-btn" onclick="toggleBox('servicos-box')">
                        Comércio Serviços ▼
                    </button>
                    <div id="servicos-box" class="hidden-box">
                        <?php for ($i = 0; $i <= 20; $i++): ?>
                            <label class="radio-item">
                                <input
                                    type="radio"
                                    name="servicos"
                                    value="<?= $i ?>"
                                    <?= (($cidadeEdit['comercio_servicos'] ?? 0) == $i) ? 'checked' : '' ?>>
                                <?= $i ?>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- TURISMO -->
                <div class="form-group">
                    <button type="button" class="toggle-btn" onclick="toggleBox('turismo-box')">
                        Comércio Turismo ▼
                    </button>
                    <div id="turismo-box" class="hidden-box">
                        <?php for ($i = 0; $i <= 20; $i++): ?>
                            <label class="radio-item">
                                <input
                                    type="radio"
                                    name="turismo"
                                    value="<?= $i ?>"
                                    <?= (($cidadeEdit['comercio_turismo'] ?? 0) == $i) ? 'checked' : '' ?>>
                                <?= $i ?>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- BOTÕES DE AÇÃO -->
                <div class="form-group">
                    <?php if (isset($cidadeEdit) && $cidadeEdit): ?>
                        <button type="submit" name="update">Atualizar Cidade</button>
                       <br>
                        <button type="button" name="cancel" onclick="window.location.href='index.php'" >Cancelar</button>
                    <?php else: ?>
                        <button type="submit" name="create">Criar Cidade</button>
                    <?php endif; ?>
                </div>

            </div>

            <!-- DIREITA -->
            <div class="form-right">

                <div class="info-box">

                    <h3>Painel de Informações</h3>

                    <p>
                        Esta área pode ser usada futuramente para:
                    </p>

                    <ul>
                        <li>Mostrar gráficos</li>
                        <li>Chance de sucesso da cidade</li>
                        <li>Dados econômicos</li>
                        <li>Resumo automático</li>
                        <li>Estatísticas do sistema</li>
                        <li>Análise empresarial</li>
                    </ul>

                </div>

            </div>

        </div>

    </form>

    <h2>Cidades Cadastradas</h2>

    <?php if (!empty($cidades)): ?>

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>População</th>
                    <th>Perfil Etário</th>
                    <th>Perfil Econômico</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($cidades as $cidade): ?>

                    <tr>

                        <td><?= htmlspecialchars($cidade['id']) ?></td>

                        <td><?= htmlspecialchars($cidade['nome']) ?></td>

                        <td><?= htmlspecialchars($cidade['populacao_quant']) ?></td>

                        <td><?= htmlspecialchars($cidade['perfil_etario']) ?></td>

                        <td><?= htmlspecialchars($cidade['perfil_economico']) ?></td>

                        <td>

                            <a
                                href="?edit=<?= $cidade['id'] ?>"
                                class="btn-edit">

                                Editar

                            </a>

                            <a
                                href="?delete=<?= $cidade['id'] ?>"
                                class="btn-delete"
                                onclick="return confirm('Tem certeza que deseja deletar?');">

                                Deletar

                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php else: ?>

        <p>Nenhuma cidade cadastrada.</p>

    <?php endif; ?>

</body>

</html>