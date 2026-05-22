<?php

require_once __DIR__ . '/../Model/SimulacaoModel.php';

class SimulacaoController {

    private $model;

    public function __construct($pdo) {
        $this->model = new SimulacaoModel($pdo);
    }

    public function listarCidades() {
        return $this->model->listarCidades();
    }

    public function listarEmpresas() {
        return $this->model->listarEmpresas();
    }

    public function calcularProbabilidadeSucesso($cidade_id, $empresa_id, $investimento = null, $quant_ancoras = null, $preco_medio = null) {
        if (func_num_args() == 3) {
            return $this->model->calcularProbabilidadeSucesso($cidade_id, $empresa_id, $investimento);
        }

        return $this->model->simularViabilidade(
            $cidade_id,
            $empresa_id,
            $investimento,
            $quant_ancoras,
            $preco_medio
        );
    }
}

?>
