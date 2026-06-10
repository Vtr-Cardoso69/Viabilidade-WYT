<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INICIO</title>
    <link rel="stylesheet" href="CSS/.css">
</head>
<body>
   <header>
        <img width="100" height="100" src="img/bussola.png" alt="Bússola">
        <img width="100" height="100" src="img/logo.png" alt="Logo">
        <?php
    if (isset($_SESSION['empresa_id'])) {
        echo "<p><a href='Pages/perfilUsuarios.php?id=" . $_SESSION['empresa_id'] . "'>Bem-vindo(a), " . $_SESSION['nome'] . "!</a></p>";
    } elseif(!isset($_SESSION['empresa_id'])){
        echo "<p><a href='Pages/cadastroEMPRESA.php'>Cadastre-se</a></p> <p>ou</p> <p><a href='Pages/login.php'>Faça login</a></p>";
    }

    ?>
    </header>
    
    <nav>
            <a href="#"></a>
            <a href="#"></a>
            <a href="#"></a>
            <a href="#"></a>
             <a href="#"></a>
            <a href="#"></a>
          <p><a href='Pages/Simulacao.php'>Simulação</a></p>
    </nav>

    <?php
if (isset($_SESSION['empresa_id'])) {

    if ($_SESSION['cargo'] === 'ADM') {
        echo "<p><a href='Pages/adm/index.php'>Admin Cidades</a></p>";
    }
}
?>

    <section>
            <h1>Bem-vindo ao WYT!</h1>
            <p>Na WYT, transformamos ideias em oportunidades por meio de análises estratégicas e estudos de viabilidade. Oferecemos soluções precisas e seguras para decisões inteligentes e sustentáveis.</p>
    </section>

    <section>
        <h2>Precisão, estratégia e confiança definem a WYT. Com 98,2% de precisão em nossas análises, ajudamos empresas a tomarem decisões seguras e alcançarem resultados consistentes.</h2>
    </section>

    <div>
        <img src="#" alt="">
    </div>

    <section>
        <p>Acreditamos que grandes negócios começam com planejamento. Por isso, criamos análises que reduzem riscos, identificam oportunidades e fortalecem projetos com estratégia e confiança.</p>
    </section>


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
