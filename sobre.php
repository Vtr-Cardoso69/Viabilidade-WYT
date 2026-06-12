
    <?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOBRE</title>
    <link rel="stylesheet" href="CSS/sobre.css">
</head>
<body>
  <nav class="nav1">
   <header>
        <img width="100" height="100" src="img/bussola.png" alt="Bússola" class="bussola" id="bussola">
        <img width="100" height="100" src="img/logo.png" alt="Logo" class="logo">
        <?php
    if (isset($_SESSION['empresa_id'])) {
        "<p><a href='Pages/perfilUsuarios.php?id=" . $_SESSION['empresa_id'] . "'>Bem-vindo(a), " . $_SESSION['nome'] . "!</a></p>";
    } elseif(!isset($_SESSION['empresa_id'])){
        "<p><a href='Pages/cadastroEMPRESA.php'><strong>Cadastre-se</strong></a></p> <p>ou</p> <p><a href='Pages/login.php'><strong>Faça login</strong></a></p>";
    }
    
    ?>
    </header>
    </nav>

    <nav class="nav2" id="menu">

    
     <a href="http://localhost/viabilidade-wyt">Início</a>

     <div>
      <h3>SUPORTE</h3>
      <ul>
       <li><a href="rodape/central.php">Central de Ajuda</a></li>
        <li><a href="sobre. php">Sobre nós</a></li>
        <li><a href="rodape/termos.php">Termos de Uso</a></li>

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
         
        <h3>CONSULTA</h3>
          <p><a href='Pages/Simulacao.php'>Simulação</a></p>

    </nav>
    

     <div class="bloco">
        <p>Fundada em São Paulo, a WYT nasceu com o propósito de transformar ideias em negócios viáveis e bem estruturados. Atuando exclusivamente no estado de São Paulo, nossa empresa oferece análises estratégicas e estudos de viabilidade que auxiliam empreendedores e empresas a tomarem decisões com mais segurança e confiança.

Ao longo de nossa trajetória, desenvolvemos uma metodologia baseada em dados, pesquisa de mercado e avaliação de oportunidades, permitindo identificar riscos, potencial de crescimento e fatores essenciais para o sucesso de cada projeto. </p>

<img src="img/predio.png" alt="WYT">

</div>


<div class="bloco">
    <img src="img/recepcao.png" alt="WYT">

   <p> Com uma taxa de sucesso de 98,2%, a WYT se destaca pelo compromisso com a excelência, precisão das análises e atendimento personalizado. Nossa missão é fornecer informações confiáveis que contribuam para a construção de negócios sólidos, rentáveis e preparados para os desafios do mercado.

Localizada em São Paulo, a WYT atende exclusivamente empresas e empreendedores dentro do estado, oferecendo soluções estratégicas que impulsionam resultados e fortalecem o desenvolvimento dos negócios paulistas.

Se quiser algo mais moderno e com cara de empresa grande, também pode usar:

Transformando projetos em oportunidades!</p>

</div>

<div class="bloco">
<p>
A WYT é uma empresa especializada em estudos de viabilidade e inteligência estratégica para negócios. Com sede em São Paulo e atuação em todo o estado, ajudamos empreendedores a avaliar oportunidades, reduzir riscos e tomar decisões mais assertivas antes de investir.

Nossa equipe trabalha com análises detalhadas, indicadores de mercado e planejamento estratégico para fornecer diagnósticos precisos e confiáveis. Graças à qualidade dos nossos processos, alcançamos uma taxa de sucesso de 98,2%, refletindo nosso compromisso com resultados concretos e a satisfação de nossos clientes.

Na WYT, acreditamos que grandes negócios começam com decisões inteligentes. Por isso, transformamos informações em estratégias e estratégias em crescimento.</p> 
<img src="img/cartao.png" alt="WYT">
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