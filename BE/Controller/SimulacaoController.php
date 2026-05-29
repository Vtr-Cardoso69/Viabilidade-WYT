<?php

require_once '../Model/SimulacaoModel.php';

class SimulacaoController {

    private $model;

    public function __construct($pdo) {
        $this->model = new SimulacaoModel($pdo);
    }

    public function calcularProbabilidadeSucesso($cidade_id, $empresa_id, $quant_ancoras){
        return $this->model->calcularProbabilidadeSucesso($cidade_id, $empresa_id, $quant_ancoras);
    }

    public function fazerSimulacao($cidade_id, $empresa_id, $quant_ancoras, $preco_produto, $investimento, $probabilidade_sucesso, $renda_mensal, $break_even){
        return $this->model->fazerSimulacao($cidade_id, $empresa_id, $quant_ancoras, $preco_produto, $investimento, $probabilidade_sucesso, $renda_mensal, $break_even);
    }

}



?>
