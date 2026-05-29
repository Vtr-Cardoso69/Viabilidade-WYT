<?php

require_once '../Model/SimulacaoModel.php';

class SimulacaoController {

    private $model;

    public function __construct($pdo) {
        $this->model = new SimulacaoModel($pdo);
    }

    
}



?>
