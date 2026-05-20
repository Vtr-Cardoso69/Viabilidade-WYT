<?php

require_once __DIR__ . '/../../Model/adm/cidadeM.php';

class CidadeController {

    private $model;

    public function __construct() {
        $this->model = new CidadeModel();
    }

    public function store($data) {
        return $this->model->create($data);
    }

    public function index() {
        return $this->model->getAll();
    }

    public function edit($id) {
        return $this->model->getById($id);
    }

    public function update($data) {
        return $this->model->update($data);
    }

    public function delete($id) {
        return $this->model->delete($id);
    }
}