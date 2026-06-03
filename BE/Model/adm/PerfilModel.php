<?php

require_once __DIR__ . '/../../DB/Database.php';

class PerfilModel {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    /**
     * Obter dados da empresa por ID
     */
    public function getEmpresaById($empresaId) {
        $sql = "SELECT id, nome, email, cnpj FROM empresas WHERE id = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $empresaId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao buscar empresa: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obter histórico de simulações da empresa
     */
    public function getHistoricoSimulacoes($empresaId, $limit = null) {
        if (!is_numeric($empresaId) || $empresaId <= 0) {
            return [];
        }

        $sql = "SELECT
                    s.id,
                    s.probabilidade_sucesso,
                    s.renda_mensal,
                    s.break_even,
                    c.nome AS cidade_nome,
                    f.tipo_comercio,
                    f.valor_medio_produto,
                    f.publico_etario,
                    f.publico_economico,
                    f.quant_ancoras,
                    f.investimento
                FROM simulacoes s
                INNER JOIN cidades c ON c.id = s.cidade_id
                INNER JOIN form_empresa f ON f.id = s.form_empresa_id
                WHERE s.empresa_id = :empresa_id
                ORDER BY s.id DESC";

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
            error_log("Erro ao buscar histórico: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Listar eventos inscritos por participante
     * Retorna array associativo ou array vazio em caso de erro
     */
    public function listarEventosPorParticipante($id_participante) {
        if (!is_numeric($id_participante) || $id_participante <= 0) {
            return [];
        }

        $sql = "SELECT e.id, e.titulo, e.descricao, e.data, e.local
                FROM eventos e
                INNER JOIN inscricoes i ON e.id = i.id_evento
                WHERE i.id_participante = :id_participante
                ORDER BY e.data DESC";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id_participante', (int)$id_participante, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('Erro ao listar eventos por participante: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obter perfil completo (empresa + histórico de simulações)
     */
    public function getPerfilCompleto($empresaId) {
        $empresa = $this->getEmpresaById($empresaId);
        
        if (!$empresa) {
            return null;
        }

        $historico = $this->getHistoricoSimulacoes($empresaId);
        
        return [
            'empresa' => $empresa,
            'historico' => $historico
        ];
    }
}
?>
