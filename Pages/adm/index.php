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
        }

        h2 {
            margin-bottom: 20px;
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

        /* LADO ESQUERDO */
        .form-left {
            width: 50%;
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

        /* BOTÕES */
        button {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            font-size: 15px;
        }

        button[name="create"],
        button[name="update"] {
            background: #4CAF50;
        }

        .btn-cancel {
            padding: 12px 20px;
            background: gray;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-left: 10px;
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

                <input type="hidden" name="id"
                    value="<?= $cidadeEdit['id'] ?? '' ?>">

                <div class="form-group">
                    <label>Nome da Cidade</label>

                    <input
                        type="text"
                        name="nome"
                        value="<?= $cidadeEdit['nome'] ?? '' ?>"
                        required>
                </div>

                <div class="form-group">
                    <label>População</label>

                    <input
                        type="number"
                        name="populacao"
                        value="<?= $cidadeEdit['populacao_quant'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label>Perfil Etário</label>

                    <input
                        type="text"
                        name="perfil_etario"
                        value="<?= $cidadeEdit['perfil_etario'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label>Perfil Econômico</label>

                    <input
                        type="text"
                        name="perfil_economico"
                        value="<?= $cidadeEdit['perfil_economico'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label>Comércio Alimentação</label>

                    <input
                        type="number"
                        name="alimentacao"
                        value="<?= $cidadeEdit['comercio_alimentacao'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label>Comércio Moda</label>

                    <input
                        type="number"
                        name="moda"
                        value="<?= $cidadeEdit['comercio_moda'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label>Comércio Tecnologia</label>

                    <input
                        type="number"
                        name="tecnologia"
                        value="<?= $cidadeEdit['comercio_tecnologia'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label>Comércio Varejo</label>

                    <input
                        type="number"
                        name="varejo"
                        value="<?= $cidadeEdit['comercio_varejo'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label>Comércio Serviços</label>

                    <input
                        type="number"
                        name="servicos"
                        value="<?= $cidadeEdit['comercio_servicos'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label>Comércio Turismo</label>

                    <input
                        type="number"
                        name="turismo"
                        value="<?= $cidadeEdit['comercio_turismo'] ?? '' ?>">
                </div>

                <div>

                    <?php if (isset($cidadeEdit) && $cidadeEdit): ?>

                        <button type="submit" name="update">
                            Atualizar Cidade
                        </button>

                        <a href="index.php" class="btn-cancel">
                            Cancelar
                        </a>

                    <?php else: ?>

                        <button type="submit" name="create">
                            Criar Cidade
                        </button>

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