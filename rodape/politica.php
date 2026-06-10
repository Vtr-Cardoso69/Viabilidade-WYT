<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POLÍTICA DE PRIVACIDADE</title>
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

    <title>Política da Empresa - WYT</title>

    
</head>
<body>

<div >

    <div>
        <h1>Política da Empresa</h1>
        <p>Compromisso, transparência e excelência em cada análise.</p>
    </div>

    <div >
        <h2>Missão</h2>
        <p>
            Fornecer estudos de viabilidade e análises estratégicas que
            auxiliem empreendedores e empresas na tomada de decisões seguras,
            reduzindo riscos e identificando oportunidades de crescimento.
        </p>
    </div>

    <div >
        <h2>Visão</h2>
        <p>
            Ser referência em estudos de viabilidade no estado de São Paulo,
            reconhecida pela qualidade, precisão e confiabilidade de nossos serviços.
        </p>
    </div>

    <div >
        <h2>Valores</h2>
        <ul>
            <li>Ética e transparência.</li>
            <li>Compromisso com resultados.</li>
            <li>Respeito aos clientes.</li>
            <li>Sigilo das informações.</li>
            <li>Inovação e melhoria contínua.</li>
            <li>Responsabilidade profissional.</li>
        </ul>
    </div>

    <div>
        <h2>Política de Qualidade</h2>
        <p>
            A WYT busca continuamente aperfeiçoar seus processos para oferecer
            análises precisas e confiáveis, garantindo alto padrão de qualidade
            em todos os projetos realizados.
        </p>
    </div>

    <div>
        <h2>Política de Confidencialidade</h2>
        <p>
            Todas as informações compartilhadas por nossos clientes são tratadas
            com total sigilo e segurança. Nenhum dado é divulgado sem autorização
            prévia, exceto em situações previstas por lei.
        </p>
    </div>

    <div>
        <h2>Política de Atendimento</h2>
        <p>
            Nosso atendimento é pautado pela cordialidade, agilidade e eficiência,
            buscando sempre compreender as necessidades de cada cliente e oferecer
            soluções adequadas para cada projeto.
        </p>
    </div>

    <div>
        <h2>Compromisso WYT</h2>
        <p>
            Com sede em São Paulo e atuação exclusiva no estado, a WYT possui
            uma taxa de sucesso de <strong>98,2%</strong>, resultado de análises
            detalhadas, metodologias eficientes e compromisso com a excelência.
        </p>
    </div>

</div>

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