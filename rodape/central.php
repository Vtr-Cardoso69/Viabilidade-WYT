<!DOCTYPE html>

    <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central de ajuda</title>
    <link rel="stylesheet" href="../CSS/central.css">
</head>
<body>

<nav class="nav1">

   <header>
        <img width="100" height="100" src="../img/bussola.png" alt="Bússola" class="bussola" id="bussola">
        <img width="100" height="100" src="../img/logo.png" alt="Logo" class="logo" >
        <?php
    if (isset($_SESSION['empresa_id'])) {
        echo "<p><a href='Pages/perfilUsuarios.php?id=" . $_SESSION['empresa_id'] . "'>Bem-vindo(a), " . $_SESSION['nome'] . "!</a></p>";
    } elseif(!isset($_SESSION['empresa_id'])){
        echo "<p><a href='Pages/cadastroEMPRESA.php'><strong>Cadastre-se</strong></a></p> <p>ou</p> <p><a href='Pages/login.php'><strong>Faça login</strong></a></p>";
    }
    
    ?>
    </header>

</nav>
    
    <nav class="nav2"id="menu" > 

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
    </div>
 
       <h3>CONSULTA</h3>
        <p><a href='../Pages/Simulacao.php'>Simulação</a></p>

    </nav>

    <div class="conteudo">
    
    <h2>Bem-vindo à Central de Ajuda da WYT Viabilidade de Negócios. Aqui você encontra respostas para as dúvidas mais comuns sobre nossos serviços, processos e atendimento.</h2>

    <div class="campo">
        <strong>O que é um estudo de viabilidade?</strong>
        <p>O estudo de viabilidade é uma análise estratégica que avalia se um empreendimento possui potencial para alcançar resultados positivos. Através de pesquisas e análises detalhadas, identificamos oportunidades, riscos e fatores que podem impactar o sucesso do negócio.</p>
    </div>

    <div class="campo">
        <strong>Como funciona o processo de análise?</strong>
        <p>Nosso processo é dividido em etapas: 
<ul>
    <li>Coleta de informações do projeto.</li>
    <li>Pesquisa de mercado e concorrência.</li>
    <li>Análise financeira e estratégica.</li>
    <li>Desenvolvimento do relatório.</li>
    <li>Entrega das recomendações finais.</li>
</ul>
    </div>

    <div class="campo">
        <strong>Quais informações preciso fornecer?</strong>
        <p>Para iniciar uma análise, recomendamos fornecer:</p>
        <ul>
            <li></li>Ramo de atividade.</li>
            <li>Cidade ou região de interesse.</li>
            <li>Valor estimado para investimento.</li>
            <li>Público-alvo.</li>
            <li>Objetivos do negócio.</li>
        </ul>
    </div>

    <div class="campo">
        <strong>Quanto tempo leva para receber o relatório?</strong>
            <p>O prazo varia conforme a complexidade do projeto. Em média, nossos estudos são concluídos entre 5 e 15 dias úteis.</p>
    </div>

    <div class="campo">
        <strong>Os dados enviados são seguros?</strong>
        <p>Sim. Todas as informações compartilhadas são tratadas com total sigilo e utilizadas apenas para a realização das análises contratadas.</p>
    </div>

    <div class="campo">
        <strong>Posso solicitar alterações ou revisões?</strong>
        <p>Sim. Caso haja necessidade de ajustes ou esclarecimentos, nossa equipe está disponível para analisar sua solicitação.</p>
    </div>

    <div class="campo">
        <strong>Como entrar em contato?</strong>
            <p>Você pode entrar em contato através de:</p>
            <ul>
                <li>Email:wyt@gmail.com.br</li>
                <li>Telefone: (11) 99845-3598</li>
            </ul>
    </div>
        </div>
    
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