<?php
session_start();

require_once __DIR__ . '/../BE/DB/Database.php';
require_once __DIR__ . '/../BE/Model/EmpresaModel.php';
require_once __DIR__ . '/../BE/Controller/EmpresaController.php';

if (isset($_POST['deletar_conta'])) {
    $idEmpresa = $_SESSION['empresa_id'];
    $controller = new EmpresaController($pdo);
    $controller->deletarEmpresa($idEmpresa);
    session_destroy();
    header("Location: ../index.php");
    exit;
}

$empresaId = $_SESSION['empresa_id'] ?? $_SESSION['id_empresa'] ?? $_GET['id'] ?? null;
$empresaId = is_numeric($empresaId) ? (int)$empresaId : null;

if (!$empresaId) {
    http_response_code(401);
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Perfil da Empresa</title>
        
    </head>
    <body>
        <div class="wrap">
            <div class="card">
                <h1>Perfil da Empresa</h1>
                <p class="muted">Você precisa estar logado para ver o perfil e histórico.</p>
                <a class="btn" href="../index.php">Ir para o início</a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

$empresaModel = new EmpresaModel($pdo);
$empresa = $empresaModel->listarInformacoesEmpresa($empresaId);
$simulacoes = $empresaModel->obterHistoricoSimulacoes($empresaId);


function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/index.css">


    <title>Perfil da Empresa</title>
    <style>
        :root{
            --bg:#0b1220;
            --card:#121b2f;
            --card2:#0f182b;
            --txt:#e6eefc;
            --muted:rgba(230,238,252,.72);
            --line:rgba(255,255,255,.10);
            --brand:#2a6cff;
            --ok:#29d9a1;
        }
        *{ box-sizing:border-box; }
        body{ font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; background:var(--bg); color:var(--txt); margin:0; }
        .wrap{ max-width: 1100px; margin: 0 auto; padding: 24px 16px 40px; }
        header{ display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:16px; }
        .brand{ display:flex; align-items:center; gap:10px; }
        .brand img{ height:34px; width:auto; }
        .actions{ display:flex; gap:10px; flex-wrap:wrap; }
        .btn{ border:0; cursor:pointer; padding:10px 14px; border-radius: 10px; font-weight:700; color:#fff; background:var(--brand); 
        text-decoration:none; display:inline-flex; align-items:center; gap:8px; }
        .btn.secondary{ background: transparent; border:1px solid var(--line); color:var(--txt); }
        .grid{ display:grid; grid-template-columns: 1fr; gap:14px; }
        @media(min-width: 900px){ .grid{ grid-template-columns: 360px 1fr; } }
        .card{ background:var(--card); border:1px solid var(--line); border-radius: 16px; padding: 16px; }
        .card h2{ margin: 0 0 10px; font-size: 18px; }
        .kv{ display:grid; grid-template-columns: 1fr; gap:10px; }
        .kv .row{ background: var(--card2); border:1px solid var(--line); border-radius: 12px; padding: 12px; }
        .k{ font-size:12px; color:var(--muted); text-transform:uppercase; letter-spacing:.06em; }
        .v{ font-size:14px; margin-top:4px; word-break:break-word; }
        .pill{ display:inline-flex; align-items:center; gap:8px; padding: 8px 10px; background: rgba(41,217,161,.10); border:1px solid rgba(41,217,161,.35); color: var(--ok); border-radius: 999px; font-weight:700; font-size:12px; }
        table{ width:100%; border-collapse: separate; border-spacing: 0; overflow:hidden; border:1px solid var(--line); border-radius: 14px; }
        thead th{ text-align:left; font-size:12px; color:var(--muted); padding: 12px; background: rgba(255,255,255,.04); border-bottom:1px solid var(--line); }
        tbody td{ padding: 12px; border-bottom:1px solid rgba(255,255,255,.06); vertical-align:top; font-size:13px; }
        tbody tr:last-child td{ border-bottom:0; }
        .muted{ color:var(--muted); }
        .empty{ padding: 14px; border:1px dashed var(--line); border-radius: 14px; background: rgba(255,255,255,.02); }
        .print-area{ display:block; }
       .delete{ background: rgba(255,0,0,.10); border:1px solid rgba(255, 255, 255, 0.35); color: var(--error); border-radius: 16px; padding: 16px; display:flex; }
       .delete .p{align-self:center; color:var(--muted); font-size:14px; margin-left: 20px; }
       .btn-D{ background: rgba(199, 10, 10, 0.81); border:1px solid rgba(112, 79, 79, 0.35); color: var(--error); border-radius: 10px; padding:10px 14px; margin-left: 10px; font-weight:700; cursor:pointer; }
        @media print{
            body{ background:#fff; color:#000; }
            header, .no-print{ display:none !important; }
            .wrap{ max-width: none; padding: 0; }
            .card{ border:0; padding:0; background:#fff; }
            table{ border:1px solid #ddd; }
            thead th{ color:#000; background:#f3f3f3; }
            .muted{ color:#444; }
        }
    </style>
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


    <div class="wrap">
        <header class="no-print">
            <div class="actions">
                <a class="btn" href="cadastroEMPRESA.php?editar=1">Editar Perfil</a>
                <a class="btn" href="logout.php">Sair da Conta</a>
            </div>
        </header>

        <div class="grid print-area">
            <aside class="card">
                <h2>Informações da empresa</h2>
                

                <div class="kv">
                    <div class="row">
                        <div class="k">Nome</div>
                        <div class="v"><?= h((string)($empresa['nome'] ?? '')) ?></div>
                    </div>
                    <div class="row">
                        <div class="k">Email</div>
                        <div class="v"><?= h((string)($empresa['email'] ?? '')) ?></div>
                    </div>
                    <div class="row">
                        <div class="k">CNPJ</div>
                        <div class="v"><?= h((string)($empresa['cnpj'] ?? '')) ?></div>
                    </div>
                    <div class="row">
                        <div class="k">Tipo de Comércio</div>
                        <div class="v"><?= h((string)($empresa['tipo_comercio'] ?? '')) ?></div>
                    </div>
                </div>

            </aside>

            <br>
            <br>
            
            <main class="card">
                <h2>Histórico de simulações</h2>

                <?php if (empty($simulacoes)): ?>
                    <div class="empty">
                        <strong>Nenhuma simulação encontrada.</strong>
                        <div class="muted">Quando você fizer uma análise, ela aparecerá aqui.</div>
                    </div>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table aria-label="Histórico de simulações" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>Quant. Âncoras</th>
                                    <th>Preço Produto</th>
                                    <th>Investimento</th>
                                    <th>Prob. Sucesso (%)</th>
                                    <th>Renda Mensal</th>
                                    <th>Break Even (meses)</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($simulacoes as $simulacao): ?>
                                <tr>
                                    <td><?= h((string)($simulacao['quant_ancoras'] ?? '')) ?></td>
                                    <td>R$ <?= h((string)($simulacao['preco_produto'] ?? '0')) ?></td>
                                    <td>R$ <?= h((string)($simulacao['investimento'] ?? '0')) ?></td>
                                    <td><?= h((string)($simulacao['probabilidade_sucesso'] ?? '0')) ?>%</td>
                                    <td>R$ <?= h((string)($simulacao['renda_mensal'] ?? '0')) ?></td>
                                    <td><?= h((string)(round($simulacao['break_even'], 0) ?? 'N/A')) ?></td>
                                    
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </main>
        </div>

        <br>
      
        <?php 
        $cargo = strtoupper($_SESSION['cargo'] ?? '');
        if ($cargo !== 'ADM'): 
        ?>
            <h2 style="color:#dc3545; margin-top:30px; margin-bottom:10px;">ATENÇÃO - ÁREA DE RISCO</h2>

            <div class="delete" style="display:flex; align-items:center; gap:15px; margin-top:20px;">

                <form method="POST" style="margin:0;">
                    <button class="btn-D"
                        type="submit"
                        name="deletar_conta"
                        onclick="return confirm('Tem certeza que deseja excluir sua conta?');">
                        Deletar minha conta
                    </button>
                </form>

                <p style="margin:0;">
                    Esta ação é permanente e não pode ser desfeita.
                </p>

            </div>
        <?php endif; ?>
    </div>

</body>
</html>
<script>
    const bussola = document.getElementById("bussola");
    const menu = document.getElementById("menu");

    bussola.addEventListener("click", () => {
        bussola.classList.toggle("girada");
        menu.classList.toggle("abrir");
    });
</script>