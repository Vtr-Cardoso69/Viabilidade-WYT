<?php

class EmpresaModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

     public function verificarEmailExistente($email) {
        $sql = "SELECT COUNT(*) FROM empresas WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Salva os dados principais da empresa
    public function cadastrarEmpresa($nome, $email, $cnpj, $tipo_comercio, $perfil_economico, $perfil_etario, $senha) {
        if ($this->verificarEmailExistente($email)) {
            return false; // Já existe o email
        }

        $sql = "INSERT INTO empresas (nome, email, cnpj, tipo_comercio, perfil_economico, perfil_etario, senha)
                VALUES (:nome, :email, :cnpj, :tipo_comercio, :perfil_economico, :perfil_etario, :senha)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':cnpj' => $cnpj,
            ':tipo_comercio' => $tipo_comercio,
            ':perfil_economico' => $perfil_economico,
            ':perfil_etario' => $perfil_etario,
            ':senha' => $senha,
        ]);
        return true;
    }

    public function loginEmpresa($email, $senha) {
        $sql = "SELECT * FROM empresas WHERE email = :email AND senha = :senha";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();

        $empresa = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($empresa) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['empresa_id'] = $empresa['id'];
            $_SESSION['nome'] = $empresa['nome'];
            $_SESSION['email'] = $empresa['email'];
            return $empresa;
        }
        return null;
    }

    public function listarEmpresas() {
        $stmt = $this->pdo->query("SELECT * FROM empresas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editarEmpresa($nome, $email, $cnpj, $senha, $id) {
        $sql = "UPDATE empresas
                SET nome = ?, email = ?, cnpj = ?, senha = ?
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $email, $cnpj, $senha, $id]);
    }

    public function deletarEmpresa($id) {
        // Exclui dados dependentes (FK SimulacaoEmpresa)
        $sql = "DELETE FROM simulacoes WHERE empresa_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        // Exclui a empresa da tabela empresas
        $sql = "DELETE FROM empresas WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function listarInformacoesEmpresa($id) {
        $sql = "SELECT * FROM empresas WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
