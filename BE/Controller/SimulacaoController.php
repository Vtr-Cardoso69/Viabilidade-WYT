<?php
require_once '../Model/SimulacaoModel.php';
require_once '../DB/Database.php';

class SimulacaoController{
    private $simulacaoModel;

    public function __construct($pdo) {
        $this->simulacaoModel = new SimulacaoModel($pdo);
    }

    public function calcularProbabilidadeSucesso($cidade_id, $empresa_id, $quant_ancoras) {
        $probabilidade_sucesso = $this->simulacaoModel->calcularProbabilidadeSucesso($cidade_id, $empresa_id, $quant_ancoras);
        return $probabilidade_sucesso;

}

}

?>