CREATE TABLE IF NOT EXISTS `medias_setor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_comercio` varchar(255) NOT NULL,
  `investimento_inicial` decimal(10,2) NOT NULL,
  `ticket_medio` decimal(10,2) NOT NULL,
  `margem_lucro` decimal(5,2) NOT NULL,
  `taxa_clientes` decimal(5,2) NOT NULL DEFAULT 2.00,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tipo_comercio` (`tipo_comercio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `medias_setor` (`tipo_comercio`, `investimento_inicial`, `ticket_medio`, `margem_lucro`, `taxa_clientes`) VALUES
('Papelaria', 48000.00, 30.00, 40.00, 2.00),
('Alimentacao', 80000.00, 45.00, 35.00, 2.50),
('Moda', 70000.00, 120.00, 45.00, 1.50),
('Tecnologia', 120000.00, 250.00, 30.00, 1.00),
('Varejo', 65000.00, 80.00, 38.00, 2.00),
('Servicos', 40000.00, 150.00, 55.00, 1.80),
('Turismo', 90000.00, 220.00, 32.00, 1.20)
ON DUPLICATE KEY UPDATE
  investimento_inicial = VALUES(investimento_inicial),
  ticket_medio = VALUES(ticket_medio),
  margem_lucro = VALUES(margem_lucro),
  taxa_clientes = VALUES(taxa_clientes);
