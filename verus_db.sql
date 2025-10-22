-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/10/2025 às 04:22
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
-- Banco de dados: `verus_db`
--
CREATE DATABASE IF NOT EXISTS `verus_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `verus_db`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `setor` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `ativo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `empresas`
--

INSERT INTO `empresas` (`id`, `cnpj`, `nome`, `setor`, `email`, `senha`, `data_cadastro`, `ativo`) VALUES
(1, '99.999.999/9999-99', 'Empresateste', 'ti', 'empresateste@gmail.com', '123', '2025-10-22 02:13:23', 1),
(2, '88.888.888/8888-88', 'Empresateste2', 'varejo', 'empresateste2@gmail.com', '1234', '2025-10-22 02:14:47', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `ativo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `email`, `nome`, `empresa_id`, `cargo`, `senha`, `data_cadastro`, `ativo`) VALUES
(1, 'funcionario@gmail.com', 'Funcionario', 1, 'Desenvolvedor', '123', '2025-10-22 02:13:48', 1),
(2, 'funcionario2@gmail.com', 'Funcionario2', 2, 'Desenvolvedor', '1234', '2025-10-22 02:15:33', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `questionarios`
--

CREATE TABLE `questionarios` (
  `id` int(11) NOT NULL,
  `funcionario_id` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `comunicacao` int(11) DEFAULT NULL,
  `lideranca` int(11) DEFAULT NULL,
  `ambiente` int(11) DEFAULT NULL,
  `reconhecimento` int(11) DEFAULT NULL,
  `crescimento` int(11) DEFAULT NULL,
  `equilibrio` int(11) DEFAULT NULL,
  `beneficios` int(11) DEFAULT NULL,
  `relacionamento` int(11) DEFAULT NULL,
  `estrutura` int(11) DEFAULT NULL,
  `climaOrganizacional` int(11) DEFAULT NULL,
  `sugestoes` text DEFAULT NULL,
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp(),
  `anonimo` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `questionarios`
--

INSERT INTO `questionarios` (`id`, `funcionario_id`, `empresa_id`, `comunicacao`, `lideranca`, `ambiente`, `reconhecimento`, `crescimento`, `equilibrio`, `beneficios`, `relacionamento`, `estrutura`, `climaOrganizacional`, `sugestoes`, `data_envio`, `anonimo`) VALUES
(1, 1, 1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 'Estou satisfeito com a empresa', '2025-10-22 02:14:13', 1),
(2, 2, 2, 4, 4, 4, 4, 4, 3, 4, 4, 4, 3, 'Estou mais ou menos satisfeito com o clima na empresa', '2025-10-22 02:16:13', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `questionarios`
--
ALTER TABLE `questionarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `questionarios`
--
ALTER TABLE `questionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
