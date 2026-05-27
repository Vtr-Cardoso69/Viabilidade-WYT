<?php

require_once __DIR__ . '/../Model/EmpresaModel.php';

class EmpresaController{
    private $model;

    public function __construct($pdo) {
        $this->model = new EmpresaModel($pdo);
    }

    public function cadastrarEmpresa($nome, $email, $cnpj, $senha) {
        return $this->model->cadastrarEmpresa($nome, $email, $cnpj, $senha);
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

