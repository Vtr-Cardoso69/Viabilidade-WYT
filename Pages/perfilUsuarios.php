<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../Controller/PerfilController.php';

/**
 * Obter ID da empresa da sessão ou via query string
 */
$empresaId = $_SESSION['empresa_id'] ?? $_SESSION['id_empresa'] ?? $_GET['id'] ?? null;
$empresaId = is_numeric($empresaId) ? (int)$empresaId : null;

/**
 * Se não houver ID de empresa, mostrar erro de autenticação
 */
if (!$empresaId) {
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
$perfilEmpresa = $controller->obterPerfilCompleto($empresaId);

/**
 * Validar se o perfil da empresa existe
 */
if (!$perfilEmpresa || !$perfilEmpresa['empresa']) {
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
         <header>
        <img width="100" height="100" src="img/bussola.png" alt="Bússola">
        <img width="100" height="100" src="img/logo.png" alt="Logo">
       
</header>
        <div class="wrap">
            <div class="card">
                <h1>Perfil não encontrado</h1>
                <p>O perfil de usuário solicitado não existe.</p>
                <a class="btn" href="../index.php">Ir para o início</a>
            </div>
        </div>
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
    exit;
}

/**
 * Extrair dados para a View
 */
$empresa = $perfilEmpresa['empresa'];
$historicoEmpresa = $perfilEmpresa['historico'] ?? [];
$usuario = null;
$historicoUsuario = [];

/**
 * Incluir a View para renderizar os dados
 */
include __DIR__ . '/../View/PerfilView.php';
