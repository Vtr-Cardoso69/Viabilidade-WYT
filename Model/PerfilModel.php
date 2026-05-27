<?php

require_once __DIR__ . '/../BE/DB/Database.php';

class PerfilModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Obter dados da empresa por ID
     */
    public function getEmpresaById($empresaId) {
        $sql = "SELECT id, nome, email, cnpj FROM empresas WHERE id = :id";
        try {
            $resultado = $this->db->query($sql, [':id' => $empresaId]);
            return $resultado ? $resultado[0] : null;
        } catch (Exception $e) {
            error_log("Erro ao buscar empresa: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obter histórico de simulações da empresa
     */
    public function getHistoricoSimulacoes($empresaId, $limit = 50) {
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
                ORDER BY s.id DESC
                LIMIT :limit";
        
        try {
            return $this->db->query($sql, [':empresa_id' => $empresaId, ':limit' => $limit]) ?? [];
        } catch (Exception $e) {
            error_log("Erro ao buscar histórico: " . $e->getMessage());
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
