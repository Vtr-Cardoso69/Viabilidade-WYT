<?php

require_once __DIR__ . '/../Model/EmpresaModel.php';

class EmpresaController{
    private $model;

    public function __construct($modelOrPdo) {
        if ($modelOrPdo instanceof EmpresaModel) {
            $this->model = $modelOrPdo;
            return;
        }

        $this->model = new EmpresaModel($modelOrPdo);
    }

    public function cadastrarEmpresa($nome, $email, $cnpj, $tipo_comercio, $perfil_economico, $perfil_etario, $senha) {
        return $this->model->cadastrarEmpresa($nome, $email, $cnpj, $tipo_comercio, $perfil_economico, $perfil_etario, $senha);
    }

    public function cadastroEmpresa($nome, $email, $cnpj, $tipo_comercio, $perfil_economico, $perfil_etario, $senha) {
        return $this->cadastrarEmpresa($nome, $email, $cnpj, $tipo_comercio, $perfil_economico, $perfil_etario, $senha);
    }

    public function loginEmpresa($email, $senha) {
        return $this->model->loginEmpresa($email, $senha);
    }

    public function listarInformacoesEmpresa($id) {
        return $this->model->listarInformacoesEmpresa($id);
    }

    public function editarEmpresa($nome, $email, $cnpj, $senha, $id) {
        return $this->model->editarEmpresa($nome, $email, $cnpj, $senha, $id);
    }

    public function deletarEmpresa($id) {
        return $this->model->deletarEmpresa($id);
    }

    public function listarEmpresa($id) {
        return $this->model->listarInformacoesEmpresa($id);
    }
}

?>

