-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/05/2026 às 12:53
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `wyt`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cidades`
--

CREATE TABLE `cidades` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `populacao_quant` int(11) NOT NULL,
  `perfil_etario` varchar(255) NOT NULL,
  `perfil_economico` varchar(255) NOT NULL,
  `comercio_alimentacao` int(11) NOT NULL,
  `comercio_moda` int(11) NOT NULL,
  `comercio_tecnologia` int(11) NOT NULL,
  `comercio_varejo` int(11) NOT NULL,
  `comercio_servicos` int(11) NOT NULL,
  `comercio_turismo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cnpj` varchar(255) NOT NULL,
  `tipo_comercio` varchar(255) NOT NULL,
  `perfil_economico` varchar(255) NOT NULL,
  `perfil_etario` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `simulacoes`
--

CREATE TABLE `simulacoes` (
  `id` int(11) NOT NULL,
  `investimento` varchar(255) NOT NULL,
  `preco_produto` varchar(255) NOT NULL,
  `quant_ancoras` varchar(255) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `cidade_id` int(11) NOT NULL,
  `probabilidade_sucesso` varchar(255) NOT NULL,
  `renda_mensal` varchar(255) NOT NULL,
  `break_even` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `simulacoes`
--
ALTER TABLE `simulacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `SimulacaoCidade` (`cidade_id`),
  ADD KEY `SimulacaoEmpresa` (`empresa_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cidades`
--
ALTER TABLE `cidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `simulacoes`
--
ALTER TABLE `simulacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `simulacoes`
--
ALTER TABLE `simulacoes`
  ADD CONSTRAINT `SimulacaoCidade` FOREIGN KEY (`cidade_id`) REFERENCES `cidades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `SimulacaoEmpresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
