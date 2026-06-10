<?php

require_once __DIR__ . '/../Model/SimulacaoModel.php';

class SimulacaoController {

    private $model;

    public function __construct($pdo) {
        $this->model = new SimulacaoModel($pdo);
    }

    public function calcularProbabilidadeSucesso($cidade_id, $empresa_id, $quant_ancoras){
        return $this->model->calcularProbabilidadeSucesso($cidade_id, $empresa_id, $quant_ancoras);
    }

    public function calcularRendaMensal($cidade_id, $empresa_id, $preco_produto){
        return $this->model->calcularRendaMensal($cidade_id, $empresa_id, $preco_produto);
    }

    public function calcularBreakEven($investimento, $cidade_id, $empresa_id, $preco_produto){
        return $this->model->calcularBreakEven($investimento, $cidade_id, $empresa_id, $preco_produto);
    }

    public function fazerSimulacao($cidade_id, $empresa_id, $quant_ancoras, $preco_produto, $investimento, $probabilidade_sucesso, $renda_mensal, $break_even){
        return $this->model->fazerSimulacao($cidade_id, $empresa_id, $quant_ancoras, $preco_produto, $investimento, $probabilidade_sucesso, $renda_mensal, $break_even);
    }

}



?>
