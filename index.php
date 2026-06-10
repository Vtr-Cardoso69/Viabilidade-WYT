<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INICIO</title>
    <link rel="stylesheet" href="CSS/index.css">
</head>
<body>

    <nav class="nav1">

   <header>
        <img width="100" height="100" src="img/bussola.png" alt="Bússola" class="bussola" id="bussola">
        <img width="100" height="100" src="img/logo.png" alt="Logo" class="logo">
        <?php
    if (isset($_SESSION['empresa_id'])) {
        echo "<p><a href='Pages/perfilUsuarios.php?id=" . $_SESSION['empresa_id'] . "'>Bem-vindo(a), " .$_SESSION['nome'] . "!</a></p>";
    } elseif(!isset($_SESSION['empresa_id'])){
        echo "<p><a href='Pages/cadastroEMPRESA.php'>Cadastre-se</a></p> <p>ou</p> <p><a href='Pages/login.php'>Faça login</a></p>";
    }

    ?>
    </header>
    
   
          
    </nav>
    
    <nav class="nav2" id="menu">

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

    <?php
if (isset($_SESSION['empresa_id'])) {

    if ($_SESSION['cargo'] === 'ADM') {
        echo "<p class='adm'><a href='Pages/adm/index.php'>Admin Cidades</a></p>";
    }
}
?>

   <div class="conteudo">

    <section class="primeiro">
            <h1>Bem-vindo ao WYT!</h1>
            <p>Na WYT, transformamos ideias em oportunidades por meio de análises estratégicas e estudos de viabilidade. Oferecemos soluções precisas e seguras para decisões inteligentes e sustentáveis.</p>
    </section>


    <section class="segundo">
        <h2>Precisão, estratégia e confiança definem a WYT. Com 98,2% de precisão em nossas análises, ajudamos empresas a tomarem decisões seguras e alcançarem resultados consistentes.</h2>
    </section>


    <div class="terceiro">
        <img src="#" alt="">
    </div>


    <section class="quarto">
        <p>Acreditamos que grandes negócios começam com planejamento. Por isso, criamos análises que reduzem riscos, identificam oportunidades e fortalecem projetos com estratégia e confiança.</p>
    </section>

   

</div>


<script>
    const bussola = document.getElementById("bussola");
    const menu = document.getElementById("menu");

    bussola.addEventListener("click", () => {
        bussola.classList.toggle("girada");
        menu.classList.toggle("abrir");
    });
</script>

</body>
 <footer >

    <p>&copy; 2026 WYT - Todos os direitos reservados</p>

</footer> 

</html>
