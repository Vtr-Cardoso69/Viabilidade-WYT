<?php

class SimulacaoModel
{

    private $pdo;


    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function fatorTipoComercial($cidade_id, $empresa_id)
    {
        // Buscar empresa
        $stmtEmpresa = $this->pdo->prepare("SELECT * FROM empresas WHERE id = ?");
        $stmtEmpresa->execute([$empresa_id]);
        $empresa = $stmtEmpresa->fetch(PDO::FETCH_ASSOC);

        // Buscar cidade
        $stmtCidade = $this->pdo->prepare("SELECT * FROM cidades WHERE id = ?");
        $stmtCidade->execute([$cidade_id]);
        $cidade = $stmtCidade->fetch(PDO::FETCH_ASSOC);

        $fator1 = 0;
        if ($empresa && isset($empresa['tipo_comercio']) && $cidade) {
            switch ($empresa['tipo_comercio']) {
                case 'Alimentacao':
                    $fator1 = $cidade['comercio_alimentacao'];
                    break;
                case 'Moda':
                    $fator1 = $cidade['comercio_moda'];
                    break;
                case 'Tecnologia':
                    $fator1 = $cidade['comercio_tecnologia'];
                    break;
                case 'Varejo':
                    $fator1 = $cidade['comercio_varejo'];
                    break;
                case 'Servicos':
                    $fator1 = $cidade['comercio_servicos'];
                    break;
                case 'Turismo':
                    $fator1 = $cidade['comercio_turismo'];
                    break;
            }
        }
        return $fator1;
    }

    public function fatorPerfilEconomico($cidade_id, $empresa_id)
    {
        // Buscar empresa
        $stmtEmpresa = $this->pdo->prepare("SELECT * FROM empresas WHERE id = ?");
        $stmtEmpresa->execute([$empresa_id]);
        $empresa = $stmtEmpresa->fetch(PDO::FETCH_ASSOC);
        // Buscar cidade
        $stmtCidade = $this->pdo->prepare("SELECT * FROM cidades WHERE id = ?");
        $stmtCidade->execute([$cidade_id]);
        $cidade = $stmtCidade->fetch(PDO::FETCH_ASSOC);

        $fator2 = 0;
        if ($empresa && isset($empresa['perfil_economico']) && $cidade) {
            switch ($empresa['perfil_economico']) {
                case 'Baixa Renda':
                    if ($cidade['perfil_economico'] == "Baixa Renda") {
                        $fator2 = 20;
                    }
                    if ($cidade['perfil_economico'] == "Media Renda") {
                        $fator2 = 10;
                    }
                    if ($cidade['perfil_economico'] == "Alta Renda") {
                        $fator2 = 5;
                    }
                    break;

                case 'Media Renda':
                    if ($cidade['perfil_economico'] == "Baixa Renda") {
                        $fator2 = 7;
                    }
                    if ($cidade['perfil_economico'] == "Media Renda") {
                        $fator2 = 20;
                    }
                    if ($cidade['perfil_economico'] == "Alta Renda") {
                        $fator2 = 10;
                    }
                    break;

                case 'Alta Renda':
                    if ($cidade['perfil_economico'] == "Baixa Renda") {
                        $fator2 = 3;
                    }
                    if ($cidade['perfil_economico'] == "Media Renda") {
                        $fator2 = 10;
                    }
                    if ($cidade['perfil_economico'] == "Alta Renda") {
                        $fator2 = 20;
                    }
                    break;
            }
        }
        return $fator2;
    }

    public function fatorPerfilEtario($cidade_id, $empresa_id)
    {
        // Buscar empresa
        $stmtEmpresa = $this->pdo->prepare("SELECT * FROM empresas WHERE id = ?");
        $stmtEmpresa->execute([$empresa_id]);
        $empresa = $stmtEmpresa->fetch(PDO::FETCH_ASSOC);
        // Buscar cidade
        $stmtCidade = $this->pdo->prepare("SELECT * FROM cidades WHERE id = ?");
        $stmtCidade->execute([$cidade_id]);
        $cidade = $stmtCidade->fetch(PDO::FETCH_ASSOC);

        $fator3 = 0;
        if ($empresa && isset($empresa['perfil_etario']) && $cidade) {
            switch ($empresa['perfil_etario']) {
                case "Crianças (0-12 anos)":
                    if ($cidade['perfil_etario'] == "Crianças (0-12 anos)") {
                        $fator3 = 20;
                    }
                    if ($cidade['perfil_etario'] == "Jovens (13-29 anos)") {
                        $fator3 = 14;
                    }
                    if ($cidade['perfil_etario'] == "Adultos (30-59 anos)") {
                        $fator3 = 9;
                    }
                    if ($cidade['perfil_etario'] == "Idosos (60 anos ou mais)") {
                        $fator3 = 2;
                    }
                    break;

                case "Jovens (13-29 anos)":
                    if ($cidade['perfil_etario'] == "Crianças (0-12 anos)") {
                        $fator3 = 15;
                    }
                    if ($cidade['perfil_etario'] == "Jovens (13-29 anos)") {
                        $fator3 = 20;
                    }
                    if ($cidade['perfil_etario'] == "Adultos (30-59 anos)") {
                        $fator3 = 11;
                    }
                    if ($cidade['perfil_etario'] == "Idosos (60 anos ou mais)") {
                        $fator3 = 5;
                    }
                    break;

                case "Adultos (30-59 anos)":
                    if ($cidade['perfil_etario'] == "Crianças (0-12 anos") {
                        $fator3 = 7;
                    }
                    if ($cidade['perfil_etario'] == "Jovens (13-29 anos)") {
                        $fator3 = 13;
                    }
                    if ($cidade['perfil_etario'] == "Adultos (30-59 anos)") {
                        $fator3 = 20;
                    }
                    if ($cidade['perfil_etario'] == "Idosos (60 anos ou mais)") {
                        $fator3 = 8;
                    }
                    break;

                case "Idosos (60 anos ou mais)":
                    if ($cidade['perfil_etario'] == "Crianças (0-12 anos") {
                        $fator3 = 3;
                    }
                    if ($cidade['perfil_etario'] == "Jovens (13-29 anos)") {
                        $fator3 = 7;
                    }
                    if ($cidade['perfil_etario'] == "Adultos (30-59 anos)") {
                        $fator3 = 12;
                    }
                    if ($cidade['perfil_etario'] == "Idosos (60 anos ou mais)") {
                        $fator3 = 20;
                    }
                    break;
            }
        }

        return $fator3;
    }

    public function fatorFluxo($cidade_id, $empresa_id)
    {
        // Buscar cidade
        $stmtCidade = $this->pdo->prepare("SELECT * FROM cidades WHERE id = ?");
        $stmtCidade->execute([$cidade_id]);
        $cidade = $stmtCidade->fetch(PDO::FETCH_ASSOC);

        $fator4 = 0;
        $fluxo = 0;

        $fatorComercio = $this->fatorTipoComercial($cidade_id, $empresa_id);

        if ($fatorComercio >= 15 && $fatorComercio <= 20) {
            $fluxo = $cidade['populacao_quant'] * 0.06; // 6% da população
        } elseif ($fatorComercio >= 10 && $fatorComercio < 15) {
            $fluxo = $cidade['populacao_quant'] * 0.04; // 4% da população
        } elseif ($fatorComercio >= 5 && $fatorComercio < 10) {
            $fluxo = $cidade['populacao_quant'] * 0.02; // 2% da população
        } elseif ($fatorComercio >= 0 && $fatorComercio < 5) {
            $fluxo = $cidade['populacao_quant'] * 0.009; // 0,9% da população
        };
        if ($fluxo >= 10000) {
            $fator4 = 20;
        } elseif ($fluxo >= 5000 && $fluxo < 10000) {
            $fator4 = 15;
        } elseif ($fluxo >= 1000 && $fluxo < 5000) {
            $fator4 = 10;
        } elseif ($fluxo >= 500 && $fluxo < 1000) {
            $fator4 = 5;
        } elseif ($fluxo >= 100 && $fluxo < 500) {
            $fator4 = 3;
        } elseif ($fluxo < 100) {
            $fator4 = 0;
        }

        return $fator4;
    }

    public function fatorQuantidadeAncoras($quant_ancoras){
        
        $fator5 = 0;
        if ($quant_ancoras >= 10) {
            $fator5 = 20;
        } elseif ($quant_ancoras >= 5 && $quant_ancoras < 10) {
            $fator5 = 15;
        } elseif ($quant_ancoras >= 1 && $quant_ancoras < 5) {
            $fator5 = 11;
        } elseif ($quant_ancoras == 0) {
            $fator5 = 0;
        }

        return $fator5;
    }

    public function calcularProbabilidadeSucesso($cidade_id, $empresa_id, $quant_ancoras)
    {
        $fator1 = $this->fatorTipoComercial($cidade_id, $empresa_id);
        $fator2 = $this->fatorPerfilEconomico($cidade_id, $empresa_id);
        $fator3 = $this->fatorPerfilEtario($cidade_id, $empresa_id);
        $fator4 = $this->fatorFluxo($cidade_id, $empresa_id);
        $fator5 = $this->fatorQuantidadeAncoras($quant_ancoras);

        $probabilidade_sucesso = $fator1 + $fator2 + $fator3 + $fator4 + $fator5;
        return $probabilidade_sucesso;
    }

    public function calcularRendaMensal($cidade_id, $empresa_id, $preco_produto)
    {
        // Buscar cidade
        $stmtCidade = $this->pdo->prepare("SELECT * FROM cidades WHERE id = ?");
        $stmtCidade->execute([$cidade_id]);
        $cidade = $stmtCidade->fetch(PDO::FETCH_ASSOC);
        $fluxo = 0;

        $fatorComercio = $this->fatorTipoComercial($cidade_id, $empresa_id);

        if ($fatorComercio >= 15 && $fatorComercio <= 20) {
            $fluxo = $cidade['populacao_quant'] * 0.06; // 6% da população
        } elseif ($fatorComercio >= 10 && $fatorComercio < 15) {
            $fluxo = $cidade['populacao_quant'] * 0.04; // 4% da população
        } elseif ($fatorComercio >= 5 && $fatorComercio < 10) {
            $fluxo = $cidade['populacao_quant'] * 0.02; // 2% da população
        } elseif ($fatorComercio >= 0 && $fatorComercio < 5) {
            $fluxo = $cidade['populacao_quant'] * 0.009; // 0,9% da população
        };

        $renda_mensal = $fluxo * $preco_produto;
        return $renda_mensal;
    }

    public function calcularBreakEven($investimento, $cidade_id, $empresa_id, $preco_produto)
    {
        $renda_mensal = $this->calcularRendaMensal($cidade_id, $empresa_id, $preco_produto);
        $break_even = $investimento / $renda_mensal;
        return $break_even;
    }

    public function fazerSimulacao($cidade_id, $empresa_id, $quant_ancoras, $preco_produto, $investimento, $probabilidade_sucesso, $renda_mensal, $break_even)
    {
        $sql = "INSERT INTO simulacoes (cidade_id, empresa_id, quant_ancoras, preco_produto, investimento, probabilidade_sucesso, renda_mensal, break_even) VALUES (:cidade_id, :empresa_id, :quant_ancoras, :preco_produto, :investimento, :probabilidade_sucesso, :renda_mensal, :break_even)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':cidade_id' => $cidade_id,
            ':empresa_id' => $empresa_id,
            ':quant_ancoras' => $quant_ancoras,
            ':preco_produto' => $preco_produto,
            ':investimento' => $investimento,
            ':probabilidade_sucesso' => $probabilidade_sucesso,
            ':renda_mensal' => $renda_mensal,
            ':break_even' => $break_even
        ]);
    }
}
