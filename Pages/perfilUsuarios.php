<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../Controller/PerfilController.php';

/**
 * Obter IDs da sessão
 */
$empresaId = $_SESSION['empresa_id'] ?? $_SESSION['id_empresa'] ?? null;
$usuarioId = $_SESSION['user_id'] ?? null;

$empresaId = is_numeric($empresaId) ? (int)$empresaId : null;
$usuarioId = is_numeric($usuarioId) ? (int)$usuarioId : null;

/**
 * Se não houver ID, mostrar erro de autenticação
 */
if (!$empresaId && !$usuarioId) {
    http_response_code(401);
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Perfil do Usuário</title>
        <style>
            body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; background:#0b1220; color:#e6eefc; margin:0; }
            .wrap{ max-width: 980px; margin: 0 auto; padding: 28px 16px; }
            .card{ background: #121b2f; border: 1px solid rgba(255,255,255,.08); border-radius: 16px; padding: 18px; }
            a.btn{ display:inline-block; padding:10px 14px; border-radius: 10px; background:#2a6cff; color:#fff; text-decoration:none; font-weight:600; }
            .muted{ color: rgba(230,238,252,.75); }
        </style>
    </head>
    <body>
        <div class="wrap">
            <div class="card">
                <h1>Perfil do Usuário</h1>
                <p class="muted">Você precisa estar logado para ver seu perfil e histórico.</p>
                <a class="btn" href="../index.php">Ir para o início</a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

/**
 * Instanciar controller e obter dados do perfil com histórico
 */
$controller = new PerfilController();

$perfilEmpresa = null;
$perfilUsuario = null;

if ($empresaId) {
    $perfilEmpresa = $controller->obterPerfilCompleto($empresaId);
}

if ($usuarioId && $usuarioId !== $empresaId) {
    $perfilUsuario = $controller->obterPerfilCompleto($usuarioId);
}

/**
 * Validar se há pelo menos um perfil encontrado
 */
if ((!$perfilEmpresa || !$perfilEmpresa['empresa']) && (!$perfilUsuario || !$perfilUsuario['empresa'])) {
    http_response_code(404);
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Perfil não encontrado</title>
        <style>
            body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; background:#0b1220; color:#e6eefc; margin:0; }
            .wrap{ max-width: 980px; margin: 0 auto; padding: 28px 16px; }
            .card{ background: #121b2f; border: 1px solid rgba(255,255,255,.08); border-radius: 16px; padding: 18px; }
            a.btn{ display:inline-block; padding:10px 14px; border-radius: 10px; background:#2a6cff; color:#fff; text-decoration:none; font-weight:600; }
        </style>
    </head>
    <body>
        <div class="wrap">
            <div class="card">
                <h1>Perfil não encontrado</h1>
                <p>O perfil de usuário solicitado não existe.</p>
                <a class="btn" href="../index.php">Ir para o início</a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

/**
 * Extrair dados para a View
 */
$empresa = $perfilEmpresa['empresa'] ?? null;
$historicoEmpresa = $perfilEmpresa['historico'] ?? [];
$usuario = $perfilUsuario['empresa'] ?? null;
$historicoUsuario = $perfilUsuario['historico'] ?? [];

if (!$empresa && $usuario) {
    $empresa = $usuario;
}

/**
 * Incluir a View para renderizar os dados
 */
// Combinar históricos da empresa e do usuário (evitar duplicados)
$historico = [];
if (!empty($historicoEmpresa) && !empty($historicoUsuario)) {
    $map = [];
    foreach ($historicoEmpresa as $row) {
        if (isset($row['id'])) {
            $map[(int)$row['id']] = $row;
        }
    }
    foreach ($historicoUsuario as $row) {
        if (isset($row['id'])) {
            $map[(int)$row['id']] = $row;
        }
    }
    $historico = array_values($map);
    usort($historico, function($a, $b) {
        return ((int)$b['id']) <=> ((int)$a['id']);
    });
} elseif (!empty($historicoEmpresa)) {
    $historico = $historicoEmpresa;
} elseif (!empty($historicoUsuario)) {
    $historico = $historicoUsuario;
}

include __DIR__ . '/../View/PerfilView.php';
