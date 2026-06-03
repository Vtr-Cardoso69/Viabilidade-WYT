<?php

require_once __DIR__ . '/../../Model/PerfilModel.php';

class PerfilController {
    private $modelo;

    public function __construct() {
        $this->modelo = new PerfilModel();
    }

    /**
     * Obter perfil completo da empresa (empresa + histórico de simulações)
     * Retorna array com 'empresa' e 'historico', ou null se não encontrado
     */
    public function obterPerfilCompleto($empresaId) {
        // Validar se é um ID numérico válido
        if (!is_numeric($empresaId) || $empresaId <= 0) {
            return null;
        }

        // Chamar model para obter dados
        return $this->modelo->getPerfilCompleto((int)$empresaId);
    }

    /**
     * Obter apenas o histórico de simulações da empresa
     */
    public function obterHistoricoEmpresa($empresaId, $limit = null) {
        if (!is_numeric($empresaId) || $empresaId <= 0) {
            return [];
        }

        return $this->modelo->getHistoricoSimulacoes((int)$empresaId, $limit);
    }
}


?>
