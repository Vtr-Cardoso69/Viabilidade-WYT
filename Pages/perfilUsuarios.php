<?php
session_start();

require_once __DIR__ . '/../BE/DB/Database.php';
require_once __DIR__ . '/../BE/Model/EmpresaModel.php';

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
                <p class="muted">Voce precisa estar logado para ver o perfil e historico.</p>
                <a class="btn" href="../index.php">Ir para o inicio</a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

$empresaModel = new EmpresaModel($pdo);
$empresa = $empresaModel->listarInformacoesEmpresa($empresaId);

if (!$empresa) {
    http_response_code(404);
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Perfil nao encontrado</title>
       
    </head>
    <body>
        <div class="wrap">
            <div class="card">
                <h1>Perfil nao encontrado</h1>
                <p>O perfil solicitado nao existe.</p>
                <a class="btn" href="../index.php">Ir para o inicio</a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

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
        .btn{ border:0; cursor:pointer; padding:10px 14px; border-radius: 10px; font-weight:700; color:#fff; background:var(--brand); text-decoration:none; display:inline-flex; align-items:center; gap:8px; }
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
    <div class="wrap">
        <header class="no-print">
            <div class="brand">
                <img src="../img/logo.png" alt="WYT">
                <strong>Perfil da Empresa</strong>
            </div>
            <div class="actions">
                <a class="btn secondary" href="../index.php">Inicio</a>
                <button class="btn" type="button" onclick="window.print()">Imprimir historico</button>
            </div>
        </header>

        <div class="grid print-area">
            <aside class="card">
                <h2>Informacoes da empresa</h2>
                

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
                        <div class="k">Tipo de Comercio</div>
                        <div class="v"><?= h((string)($empresa['tipo_comercio'] ?? '')) ?></div>
                    </div>
                </div>

            </aside>

            <br>
            <br>
            
            <main class="card">
                <h2>Historico de simulacoes</h2>

                <?php if (empty($simulacoes)): ?>
                    <div class="empty">
                        <strong>Nenhuma simulacao encontrada.</strong>
                        <div class="muted">Quando voce fizer uma analise, ela aparecera aqui.</div>
                    </div>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table aria-label="Historico de simulacoes" style="font-size: 12px;">
                            <thead>
                                <tr>
                                     <th>Data Simulacao</th>
                                    <th>Quant. Ancoras</th>
                                    <th>Preco Produto</th>
                                    <th>Investimento</th>
                                    <th>Prob. Sucesso (%)</th>
                                    <th>Renda Mensal</th>
                                    <th>Break Even (meses)</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($simulacoes as $row): ?>
                                <tr>
                                   <td><?= h((string)($row['data_simulacao'] ?? 'N/A')) ?></td>
                                    <td><?= h((string)($row['quant_ancoras'] ?? '')) ?></td>
                                    <td>R$ <?= h((string)($row['preco_produto'] ?? '0')) ?></td>
                                    <td>R$ <?= h((string)($row['investimento'] ?? '0')) ?></td>
                                    <td><?= h((string)($row['probabilidade_sucesso'] ?? '0')) ?>%</td>
                                    <td>R$ <?= h((string)($row['renda_mensal'] ?? '0')) ?></td>
                                    <td><?= h((string)($row['break_even'] ?? 'N/A')) ?></td>
                                    
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>
</body>
</html>
