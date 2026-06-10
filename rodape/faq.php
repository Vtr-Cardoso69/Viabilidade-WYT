<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - WYT</title>
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

    <h1>Perguntas Frequentes (FAQ)</h1>

    <h2>O que é a WYT?</h2>
    <p>
        A WYT é uma empresa especializada em estudos de viabilidade de negócios,
        auxiliando empreendedores e empresas na tomada de decisões estratégicas.
    </p>

    <h2>Quais serviços a WYT oferece?</h2>
    <p>
        Realizamos estudos de viabilidade, análise de mercado, avaliação de localização,
        análise da concorrência e relatórios estratégicos para novos empreendimentos.
    </p>

    <h2>Quem pode contratar os serviços da WYT?</h2>
    <p>
        Empreendedores, pequenas empresas, médias empresas e investidores que desejam
        avaliar oportunidades de negócio no estado de São Paulo.
    </p>

    <h2>Em quais regiões a WYT atende?</h2>
    <p>
        Nossa sede está localizada em São Paulo e atendemos exclusivamente clientes
        dentro do estado de São Paulo.
    </p>

    <h2>Como solicitar uma análise?</h2>
    <p>
        Basta entrar em contato através da página de contato e fornecer informações
        básicas sobre seu projeto ou negócio.
    </p>

    <h2>Quanto tempo leva para receber o relatório?</h2>
    <p>
        O prazo varia conforme a complexidade do projeto, geralmente entre 5 e 15 dias úteis.
    </p>

    <h2>Quais informações preciso fornecer?</h2>
    <p>
        Informações sobre o ramo de atividade, local de interesse, público-alvo,
        investimento estimado e objetivos do empreendimento.
    </p>

    <h2>As informações enviadas são confidenciais?</h2>
    <p>
        Sim. Todos os dados fornecidos pelos clientes são tratados com sigilo e segurança.
    </p>

    <h2>A WYT garante o sucesso do negócio?</h2>
    <p>
        Nenhuma empresa pode garantir resultados futuros. No entanto, nossas análises
        auxiliam na redução de riscos e apresentam uma taxa histórica de sucesso de 98,2%.
    </p>

    <h2>Posso solicitar alterações no relatório?</h2>
    <p>
        Sim. Nossa equipe poderá analisar solicitações de revisão ou complementação
        das informações apresentadas.
    </p>

    <h2>Como entro em contato com a equipe?</h2>
    <p>
        Você pode utilizar os canais de atendimento disponíveis na página de contato
        do site.
    </p>

    <h2>Qual é a missão da WYT?</h2>
    <p>
        Fornecer análises estratégicas e estudos de viabilidade que contribuam para
        decisões mais seguras e para o crescimento sustentável dos negócios.
    </p>
<footer >

     <div>
      <h3>Suporte</h3>
      <ul>
        <li><a href="central.php">Central de Ajuda</a></li>
        <li><a href="politica.php">Política de Privacidade</a></li>
        <li><a href="termos.php">Termos de Uso</a></li>
        <li><a href="faq.php">FAQ</a></li>
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