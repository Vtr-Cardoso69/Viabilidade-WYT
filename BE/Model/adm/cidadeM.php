<?php
require_once __DIR__ . '/../../DB/Database.php';

class CidadeModel {

    private $pdo;

    public function __construct() {
        global $pdo; // pega variável do Database.php
        $this->pdo = $pdo;
    }

    public function create($data) {

        $sql = "INSERT INTO cidades (
            nome, populacao_quant, perfil_etario, perfil_economico,
            comercio_alimentacao, comercio_moda, comercio_tecnologia,
            comercio_varejo, comercio_servicos, comercio_turismo
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $data['nome'],
            $data['populacao'],
            $data['perfil_etario'],
            $data['perfil_economico'],
            $data['alimentacao'],
            $data['moda'],
            $data['tecnologia'],
            $data['varejo'],
            $data['servicos'],
            $data['turismo']
        ]);
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM cidades");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM cidades WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data) {

        $sql = "UPDATE cidades SET
            nome = ?,
            populacao_quant = ?,
            perfil_etario = ?,
            perfil_economico = ?,
            comercio_alimentacao = ?,
            comercio_moda = ?,
            comercio_tecnologia = ?,
            comercio_varejo = ?,
            comercio_servicos = ?,
            comercio_turismo = ?
            WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $data['nome'],
            $data['populacao'],
            $data['perfil_etario'],
            $data['perfil_economico'],
            $data['alimentacao'],
            $data['moda'],
            $data['tecnologia'],
            $data['varejo'],
            $data['servicos'],
            $data['turismo'],
            $data['id']
        ]);
    }

     public function delete($id) {
        // Exclui dados dependentes (FK SimulacaoEmpresa)
        $sql = "DELETE FROM simulacoes WHERE cidade_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        // Exclui a empresa da tabela empresas
        $sql = "DELETE FROM cidades WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}