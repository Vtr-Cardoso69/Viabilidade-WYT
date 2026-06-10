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

        public function verificarCnpjExistente($cnpj) {
        $sql = "SELECT COUNT(*) FROM empresas WHERE cnpj = :cnpj";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Salva os dados principais da empresa
    public function cadastrarEmpresa($nome, $email, $cnpj, $tipo_comercio, $perfil_economico, $perfil_etario, $senha, $cargo) {
        if ($this->verificarEmailExistente($email)) {
            return false; // Já existe o email
        }
        if ($this->verificarCnpjExistente($cnpj)) {
            return false; // Já existe o cnpj
        }

        $sql = "INSERT INTO empresas (nome, email, cnpj, tipo_comercio, perfil_economico, perfil_etario, senha, cargo)
                VALUES (:nome, :email, :cnpj, :tipo_comercio, :perfil_economico, :perfil_etario, :senha, :cargo)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':cnpj' => $cnpj,
            ':tipo_comercio' => $tipo_comercio,
            ':perfil_economico' => $perfil_economico,
            ':perfil_etario' => $perfil_etario,
            ':senha' => $senha,
            ':cargo' => $cargo,
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




    
    /**
     * Obter historico de simulacoes da empresa (todos os campos da tabela simulacoes)
     */
    public function obterHistoricoSimulacoes($empresaId, $limit = null) {
        if (!is_numeric($empresaId) || $empresaId <= 0) {
            return [];
        }

        $sql = "SELECT * FROM simulacoes WHERE empresa_id = :empresa_id ORDER BY id DESC";

        if ($limit !== null) {
            $limit = (int)$limit;
            if ($limit > 0) {
                $sql .= " LIMIT $limit";
            }
        }

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':empresa_id', (int)$empresaId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao buscar historico: " . $e->getMessage());
            return [];
        }
    }
}

?>
