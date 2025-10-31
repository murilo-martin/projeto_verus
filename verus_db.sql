-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 31/10/2025 às 04:05
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
(1, '99.999.999/9999-99', 'empresa1', 'ti', 'empresa1@empresa.com', '123', '2025-10-31 03:02:22', 1);

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
(1, 'adm@adm.com', 'admverus@verus.com', 0, 'ADM', '123adm', '2025-10-31 03:01:35', 1),
(2, 'funcionario@gmail.com', 'Funcionario 1', 1, 'Auxiliar', '123', '2025-10-31 03:03:28', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `perguntas`
--

CREATE TABLE `perguntas` (
  `id` int(11) NOT NULL,
  `primeirapergunta` varchar(99) DEFAULT NULL,
  `segundapergunta` varchar(99) DEFAULT NULL,
  `terceirapergunta` varchar(99) DEFAULT NULL,
  `quartapergunta` varchar(99) DEFAULT NULL,
  `quintapergunta` varchar(99) DEFAULT NULL,
  `sextapergunta` varchar(99) DEFAULT NULL,
  `setimapergunta` varchar(99) DEFAULT NULL,
  `oitavapergunta` varchar(99) DEFAULT NULL,
  `nonapergunta` varchar(99) DEFAULT NULL,
  `decimapergunta` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `perguntas`
--

INSERT INTO `perguntas` (`id`, `primeirapergunta`, `segundapergunta`, `terceirapergunta`, `quartapergunta`, `quintapergunta`, `sextapergunta`, `setimapergunta`, `oitavapergunta`, `nonapergunta`, `decimapergunta`) VALUES
(1, 'Como você avalia o ambiente de trabalho  ', 'Como você avalia a liderança e gestão em sua área', 'Como você avalia a comunicação interna da empresa', 'Como você avalia as oportunidades de crescimento profissional', 'Como você avalia o reconhecimento e valorização dos funcionários', 'Como você avalia o equilíbrio entre vida pessoal e profissional', 'Como você avalia os benefícios oferecidos pela empresa', 'Como você avalia o relacionamento com seus colegas de trabalho', 'Como você avalia a estrutura e processos organizacionais', ' Como você avalia o clima organizacional geral na empresa');

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
-- Índices de tabela `perguntas`
--
ALTER TABLE `perguntas`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `perguntas`
--
ALTER TABLE `perguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `questionarios`
--
ALTER TABLE `questionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
