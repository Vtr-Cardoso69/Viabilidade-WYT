<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Termos de Uso - WYT</title>
     <link rel="stylesheet" href="../CSS/termos.css">
</head>
<body>
    <nav class="nav1">
   <header>
        <img width="100" height="100" src="../img/bussola.png" alt="Bússola" class="bussola" id="bussola">
        <img width="100" height="100" src="../img/logo.png" alt="Logo" class="logo">
        <?php
    if (isset($_SESSION['empresa_id'])) {
        echo "<p><a href='Pages/perfilUsuarios.php?id=" . $_SESSION['empresa_id'] . "'>Bem-vindo(a), " . $_SESSION['nome'] . "!</a></p>";
    } elseif(!isset($_SESSION['empresa_id'])){
        echo "<p><a href='../Pages/cadastroEMPRESA.php'><strong>Cadastre-se</strong></a></p> <p>ou</p> <p><a href='../Pages/login.php'><strong>Faça login</strong></a></p>";
    }

    ?>
    </header>
    </nav>

    <nav class="nav2" id="menu">  

     <a href="http://localhost/viabilidade-wyt">Início</a>
        
    <div>
      <h3>SUPORTE</h3>
      <ul>
        <li><a href="central.php">Central de Ajuda</a></li>
        <li><a href="../sobre.php">Sobre nós</a></li>
        <li><a href="termos.php">Termos de Uso</a></li>
  
      </ul>
    </div>

 <div>
      <h3>SOCIAL</h3>
      <ul>
        <li><a href="#">Instagram</a></li>
        <li><a href="#">Facebook</a></li>
        <li><a href="#">Tiktok</a></li>
      </ul>

      <h3>CONSULTA</h3>
          <p><a href='../Pages/Simulacao.php'>Simulação</a></p>
    </nav>

    <?php
if (isset($_SESSION['empresa_id'])) {

    if ($_SESSION['cargo'] === 'ADM') {
        echo "<p><a href='Pages/adm/index.php'>Admin Cidades</a></p>";
    }
}
?>

<section class="termos">
    <h1>Termos de Uso</h1>

   
    <p>
        Bem-vindo ao site da WYT Viabilidade de Negócios. Ao acessar e utilizar este site,
        você concorda com os presentes Termos de Uso. Caso não concorde com qualquer condição,
        recomendamos que não utilize nossos serviços.
    </p>
   

    <h2>1. Objetivo do Site</h2>


    <p>
        O site da WYT tem como finalidade apresentar informações institucionais,
        serviços de análise de viabilidade de negócios e canais de contato para
        clientes localizados no estado de São Paulo.
    </p>

    <h2>2. Utilização das Informações</h2>

    <p>
        Todo o conteúdo disponibilizado neste site possui caráter informativo.
        As informações apresentadas não constituem garantia de resultados e não
        substituem análises personalizadas realizadas por nossa equipe.
    </p>


    <h2>3. Responsabilidades do Usuário</h2>

    <p>Ao utilizar este site, o usuário compromete-se a:</p>

    <ul>
        <li>Fornecer informações verdadeiras quando solicitado;</li>
        <li>Não utilizar o site para atividades ilícitas;</li>
        <li>Respeitar os direitos de propriedade intelectual da empresa;</li>
        <li>Não tentar acessar áreas restritas ou sistemas internos.</li>
    </ul>


    <h2>4. Propriedade Intelectual</h2>

    <p>
        Todos os textos, imagens, logotipos, marcas e demais conteúdos presentes
        neste site são de propriedade da WYT ou utilizados mediante autorização,
        sendo proibida sua reprodução sem consentimento prévio.
    </p>

    <h2>5. Limitação de Responsabilidade</h2>

    <p>
        A WYT realiza análises baseadas em dados, pesquisas e metodologias próprias.
        Entretanto, decisões empresariais e investimentos envolvem fatores externos
        que podem influenciar os resultados, não sendo possível garantir sucesso
        absoluto em qualquer empreendimento.
    </p>

    <h2>6. Privacidade e Confidencialidade</h2>

    <p>
        As informações fornecidas pelos usuários serão tratadas de forma segura e
        confidencial, conforme nossa Política de Privacidade.
    </p>

    <h2>7. Alterações dos Termos</h2>

    
        <p>
            A WYT poderá modificar estes Termos de Uso a qualquer momento, sem aviso
            prévio. Recomendamos a consulta periódica desta página.
        </p>
  

    <h2>8. Contato</h2>

    <p>
        Em caso de dúvidas sobre estes Termos de Uso, entre em contato pelos
        canais oficiais disponibilizados em nosso site.
    </p>

    <p>
        Última atualização: Junho de 2026.
    </p>
</section>
   

    </div>

<footer >
    <p>&copy; 2026 WYT - Todos os direitos reservados</p>
</footer>

 <script>
        const bussola = document.getElementById("bussola");
        const menu = document.getElementById("menu");

        bussola.addEventListener("click", () => {
            bussola.classList.toggle("girada");
            menu.classList.toggle("abrir");
        });
    </script>

</body>
</html>