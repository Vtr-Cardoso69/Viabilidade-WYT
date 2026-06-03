<?php

session_start();

if (
    !isset($_SESSION['empresa_id']) ||
    $_SESSION['cargo'] !== 'ADM'
) {
    die('Acesso negado');
}

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
            /* =========================
            RESET
            ========================= */

            *{
                margin:0;
                padding:0;
                box-sizing:border-box;
            }

            /* =========================
            BODY
            ========================= */

            body{

                font-family:Arial, sans-serif;

                background:#f4f4f4;

                padding:30px;

                color:#333;
            }

            /* =========================
            TÍTULOS
            ========================= */

            h1{

                margin-bottom:20px;

                color:#2c3e50;
            }

            h2{

                margin-bottom:20px;

                margin-top:25px;

                color:#2c3e50;
            }

            h3{
                color:#333;
            }

            /* =========================
            FORMULÁRIO
            ========================= */

            form{

                background:white;

                padding:25px;

                border-radius:16px;

                margin-bottom:30px;

                box-shadow:
                    0 4px 15px rgba(0,0,0,0.08);
            }

            /* =========================
            CONTAINER PRINCIPAL
            ========================= */

            .form-container{

                display:flex;
              

                gap:25px;
            }

            /* =========================
            LADO ESQUERDO
            ========================= */

            .form-left{

                width:50%;
            }

            .form-left h2{

                margin-top:35px;

                padding-bottom:10px;

                border-bottom:3px solid #4CAF50;
            }

            /* =========================
            LADO DIREITO
            ========================= */

            .form-right{

                width:50%;

                background:#fafafa;

                border-radius:14px;

                padding:20px;

                min-height:400px;

                border:2px dashed #ccc;
            }

            /* =========================
            FORM GROUP
            ========================= */

            .form-group{

                display:flex;

                flex-direction:column;

                margin-bottom:20px;
            }

            /* =========================
            LABEL
            ========================= */

            .form-group label{

                margin-bottom:8px;

                font-weight:600;
            }

            /* =========================
            INPUTS
            ========================= */

            .form-group input,
            .form-group select{

                padding:13px;

                border-radius:8px;

                border:1px solid #d5d5d5;

                width:100%;

                font-size:15px;

                transition:0.2s ease;

                background:white;
            }

            /* FOCUS */

            .form-group input:focus,
            .form-group select:focus{

                outline:none;

                border-color:#4CAF50;

                box-shadow:
                    0 0 0 4px rgba(76,175,80,0.15);
            }

            /* =========================
            BOTÕES PRINCIPAIS
            ========================= */

            button{

                padding:13px 20px;

                border:none;

                border-radius:10px;

                cursor:pointer;

                color:white;

                font-size:15px;

                font-weight:600;

                transition:0.25s ease;
            }

            /* CRIAR / UPDATE */

            button[name="create"],
            button[name="update"]{

                background:linear-gradient(
                    135deg,
                    #4CAF50,
                    #43a047
                );
            }

            button[name="create"]:hover,
            button[name="update"]:hover{

                transform:translateY(-2px);

                box-shadow:
                    0 6px 15px rgba(76,175,80,0.25);
            }

            /* CANCELAR */

            button[name="cancel"]{

                background:linear-gradient(
                    135deg,
                    #d32f2f,
                    #b71c1c
                );
            }

            button[name="cancel"]:hover{

                transform:translateY(-2px);

                box-shadow:
                    0 6px 15px rgba(211,47,47,0.25);
            }

            /* =========================
            BOTÃO CANCELAR LINK
            ========================= */

            .btn-cancel{

                padding:13px 20px;

                background:#757575;

                color:white;

                text-decoration:none;

                border-radius:10px;

                display:inline-block;

                transition:0.25s ease;

                font-weight:600;
            }

            .btn-cancel:hover{

                background:#616161;

                transform:translateY(-2px);
            }

            /* =========================
            TABELA
            ========================= */

            table{

                width:100%;

                border-collapse:collapse;

                background:white;

                border-radius:14px;

                overflow:hidden;

                box-shadow:
                    0 4px 15px rgba(0,0,0,0.08);
            }

            /* CABEÇALHO */

            th{

                background:#4CAF50;

                color:white;
            }

            th,
            td{

                padding:15px;

                border-bottom:1px solid #eaeaea;

                text-align:left;
            }

            /* HOVER */

            tr:hover{

                background:#f8f8f8;
            }

            /* =========================
            BOTÕES DA TABELA
            ========================= */

            .btn-edit{

                background:#2196F3;

                color:white;

                padding:8px 13px;

                text-decoration:none;

                border-radius:8px;

                transition:0.2s ease;
            }

            .btn-edit:hover{

                background:#1976D2;
            }

            .btn-delete{

                background:#f44336;

                color:white;

                padding:8px 13px;

                text-decoration:none;

                border-radius:8px;

                transition:0.2s ease;
            }

            .btn-delete:hover{

                background:#d32f2f;
            }

            /* =========================
            INFO BOX
            ========================= */

            .info-box h3{

                margin-bottom:15px;
            }

            .info-box p{

                margin-bottom:10px;

                line-height:1.6;
            }

            .info-box ul{

                margin-left:20px;

                margin-top:10px;
            }

            .info-box li{

                margin-bottom:10px;
            }

            /* =========================
            ÁREA DE NEGÓCIOS
            ========================= */

            .business-section{

                margin-top:35px;
            }

            .business-section h2{

                font-size:24px;

                color:#2c3e50;

                margin-bottom:25px;

                padding-bottom:12px;

                border-bottom:3px solid #4CAF50;
            }

            /* =========================
            CARD
            ========================= */

            .score-card{

                background:white;

                border:1px solid #e5e5e5;

                border-radius:16px;

                overflow:hidden;

                margin-bottom:20px;

                transition:0.25s ease;

                box-shadow:
                    0 3px 10px rgba(0,0,0,0.05);
            }

            .score-card:hover{

                transform:translateY(-2px);

                box-shadow:
                    0 8px 20px rgba(0,0,0,0.08);
            }

            /* =========================
            TOGGLE BUTTON
            ========================= */

            .toggle-btn{

                width:100%;

                border:none;

                background:linear-gradient(
                    135deg,
                    #4CAF50,
                    #43a047
                );

                color:white;

                padding:18px 22px;

                cursor:pointer;

                display:flex;

                align-items:center;

                justify-content:space-between;

                text-align:left;
            }

            /* HOVER */

            .toggle-btn:hover{

                filter:brightness(1.05);
            }

            /* TEXTO */

            .toggle-content{

                display:flex;

                flex-direction:column;
            }

            /* TÍTULO */

            .toggle-title{

                font-size:17px;

                font-weight:700;

                margin-bottom:4px;
            }

            /* SUBTÍTULO */

            .toggle-subtitle{

                font-size:13px;

                color:rgba(255,255,255,0.85);

                font-weight:400;
            }

            /* SETA */

            .toggle-arrow{

                font-size:18px;

                transition:0.2s ease;
            }

            /* =========================
            ÁREA DAS OPÇÕES
            ========================= */

            .hidden-box{

                display:none;

                padding:22px;

                background:#fafafa;

                border-top:1px solid #ececec;

                gap:12px;

                flex-wrap:wrap;
            }

            /* =========================
            RADIO ITEM
            ========================= */

            .radio-item{

                position:relative;
            }

            /* ESCONDE RADIO */

            .radio-item input{

                display:none;
            }

            /* NÚMERO */

            .radio-item span{

                width:45px;

                height:45px;

                border-radius:12px;

                display:flex;

                align-items:center;

                justify-content:center;

                background:#f1f1f1;

                border:2px solid transparent;

                font-weight:bold;

                font-size:15px;

                cursor:pointer;

                transition:0.2s ease;

                user-select:none;
            }

            /* HOVER */

            .radio-item span:hover{

                background:#e8f5e9;

                border-color:#4CAF50;

                transform:translateY(-2px);
            }

            /* SELECIONADO */

            .radio-item input:checked + span{

                background:#4CAF50;

                color:white;

                border-color:#43a047;

                transform:scale(1.08);

                box-shadow:
                    0 5px 12px rgba(76,175,80,0.35);
            }

            /* =========================
            RESPONSIVO
            ========================= */

            @media (max-width:768px){

                .form-container{

                    flex-direction:column;
                }

                .form-left,
                .form-right{

                    width:100%;
                }

                .hidden-box{

                    justify-content:center;
                }

                .toggle-title{

                    font-size:15px;
                }

                .toggle-subtitle{

                    font-size:12px;
                }
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

    <p><a href="../cadastroEMPRESA.php?cargo=ADM">Cadastrar novo ADM</a></p>

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
<div name=" GERAL ">     
        
    <div class="business-section">
        <!-- CARD -->
        <div class="score-card">
            <button
                type="button"
                class="toggle-btn"
                onclick="toggleBox('alimentacao-box')">
                <div>
                    Comércio Alimentação
                    <div class="score-subtitle">
                        Potencial do setor alimentício na cidade
                    </div>
                </div>
                <span>▼</span>
            </button>
            <div id="alimentacao-box" class="hidden-box">

                <?php for ($i = 0; $i <= 20; $i++): ?>

                    <label class="radio-item">
                        <input
                            type="radio"
                            name="alimentacao"
                            value="<?= $i ?>"
                            <?= (($cidadeEdit['comercio_alimentacao'] ?? 0) == $i) ? 'checked' : '' ?>>
                        <span><?= $i ?></span>
                    </label>
                <?php endfor; ?>
            </div>
        </div>
    </div>


    <div class="business-section">
        <!-- CARD -->
        <div class="score-card">
            <button
                type="button"
                class="toggle-btn"
                onclick="toggleBox('moda-box')">
                <div>
                    Comércio Moda
                    <div class="score-subtitle">
                        Potencial do setor de moda na cidade
                    </div>
                </div>
                <span>▼</span>
            </button>
            <div id="moda-box" class="hidden-box">

                <?php for ($i = 0; $i <= 20; $i++): ?>

                    <label class="radio-item">
                        <input
                            type="radio"
                            name="moda"
                            value="<?= $i ?>"
                            <?= (($cidadeEdit['comercio_moda'] ?? 0) == $i) ? 'checked' : '' ?>>
                        <span><?= $i ?></span>
                    </label>
                <?php endfor; ?>
            </div>
        </div>
    </div>


    <div class="business-section">
        <!-- CARD -->
        <div class="score-card">
            <button
                type="button"
                class="toggle-btn"
                onclick="toggleBox('tecnologia-box')">
                <div>
                    Comércio Tecnologia
                    <div class="score-subtitle">
                        Potencial do setor de tecnologia na cidade
                    </div>
                </div>
                <span>▼</span>
            </button>
            <div id="tecnologia-box" class="hidden-box">

                <?php for ($i = 0; $i <= 20; $i++): ?>

                    <label class="radio-item">
                        <input
                            type="radio"
                            name="tecnologia"
                            value="<?= $i ?>"
                            <?= (($cidadeEdit['comercio_tecnologia'] ?? 0) == $i) ? 'checked' : '' ?>>
                        <span><?= $i ?></span>
                    </label>
                <?php endfor; ?>
            </div>
        </div>
    </div>


    <div class="business-section">
        <!-- CARD -->
        <div class="score-card">
            <button
                type="button"
                class="toggle-btn"
                onclick="toggleBox('varejo-box')">
                <div>
                    Comércio Varejo
                    <div class="score-subtitle">
                        Potencial do setor de varejo na cidade
                    </div>
                </div>
                <span>▼</span>
            </button>
            <div id="varejo-box" class="hidden-box">

                <?php for ($i = 0; $i <= 20; $i++): ?>

                    <label class="radio-item">
                        <input
                            type="radio"
                            name="varejo"
                            value="<?= $i ?>"
                            <?= (($cidadeEdit['comercio_varejo'] ?? 0) == $i) ? 'checked' : '' ?>>
                        <span><?= $i ?></span>
                    </label>
                <?php endfor; ?>
            </div>
        </div>
    </div>


    <div class="business-section">
        <!-- CARD -->
        <div class="score-card">
            <button
                type="button"
                class="toggle-btn"
                onclick="toggleBox('servicos-box')">
                <div>
                    Comércio Serviços
                    <div class="score-subtitle">
                        Potencial do setor de Serviços na cidade
                    </div>
                </div>
                <span>▼</span>
            </button>
            <div id="servicos-box" class="hidden-box">

                <?php for ($i = 0; $i <= 20; $i++): ?>

                    <label class="radio-item">
                        <input
                            type="radio"
                            name="servicos"
                            value="<?= $i ?>"
                            <?= (($cidadeEdit['comercio_servicos'] ?? 0) == $i) ? 'checked' : '' ?>>
                        <span><?= $i ?></span>
                    </label>
                <?php endfor; ?>
            </div>
        </div>
    </div>


    <div class="business-section">
        <!-- CARD -->
        <div class="score-card">
            <button
                type="button"
                class="toggle-btn"
                onclick="toggleBox('turismo-box')">
                <div>
                    Comércio Turismo
                    <div class="score-subtitle">
                        Potencial do setor de Turismo na cidade
                    </div>
                </div>
                <span>▼</span>
            </button>
            <div id="turismo-box" class="hidden-box">

                <?php for ($i = 0; $i <= 20; $i++): ?>

                    <label class="radio-item">
                        <input
                            type="radio"
                            name="turismo"
                            value="<?= $i ?>"
                            <?= (($cidadeEdit['comercio_turismo'] ?? 0) == $i) ? 'checked' : '' ?>>
                        <span><?= $i ?></span>
                    </label>
                <?php endfor; ?>
            </div>
        </div>
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