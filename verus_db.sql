-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/09/2025 às 18:51
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
CREATE DATABASE IF NOT EXISTS `verus_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
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
(2, '12.345.678/0001-90', 'Empresa Teste LTDA', 'Tecnologia', 'contato@empresateste.com', '123456', '2025-08-31 01:30:54', 1),
(3, '', '', '', '', '', '2025-09-12 18:19:45', 1),
(6, '23.323.232/2323-23', 'Ailer', 'ti', 'Ailer@vesgo.com', '123', '2025-09-12 18:22:13', 1);

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
(1, 'funcionario@empresateste.com', 'João Silva', 2, 'Desenvolvedor', '123456', '2025-08-31 01:30:54', 1),
(2, 's@a', 's', 2, 's', 's', '2025-09-12 18:02:58', 1),
(3, 'murilomendonca967@gmail.com', 'Murilo', 6, 'Escravo', '1', '2025-09-19 16:40:14', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `questionarios`
--

CREATE TABLE `questionarios` (
  `id` int(11) NOT NULL,
  `funcionario_id` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `comunicacao` int(11) DEFAULT NULL CHECK (`comunicacao` between 1 and 5),
  `lideranca` int(11) DEFAULT NULL,
  `ambiente` int(11) DEFAULT NULL CHECK (`ambiente` between 1 and 5),
  `reconhecimento` int(11) DEFAULT NULL CHECK (`reconhecimento` between 1 and 5),
  `crescimento` int(11) DEFAULT NULL CHECK (`crescimento` between 1 and 5),
  `equilibrio` int(11) DEFAULT NULL CHECK (`equilibrio` between 1 and 5),
  `beneficios` int(11) DEFAULT NULL,
  `relacionamento` int(11) DEFAULT NULL,
  `estrutura` int(11) DEFAULT NULL,
  `climaOrganizacional` int(11) DEFAULT NULL,
  `sugestoes` text DEFAULT NULL,
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp(),
  `anonimo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `questionarios`
--

INSERT INTO `questionarios` (`id`, `funcionario_id`, `empresa_id`, `comunicacao`, `lideranca`, `ambiente`, `reconhecimento`, `crescimento`, `equilibrio`, `beneficios`, `relacionamento`, `estrutura`, `climaOrganizacional`, `sugestoes`, `data_envio`, `anonimo`) VALUES
(2, 1, 2, 1, 1, 1, 1, 1, 2, 1, 1, 2, 1, 'ddd', '2025-09-19 16:44:55', 0),
(4, 1, 2, 1, 2, 1, 1, 2, 2, 1, 2, 1, 2, 'd', '2025-09-19 16:46:58', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `sessoes`
--

CREATE TABLE `sessoes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `tipo_usuario` enum('funcionario','empresa') NOT NULL,
  `token` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_expiracao` timestamp NULL DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `sessoes`
--

INSERT INTO `sessoes` (`id`, `usuario_id`, `tipo_usuario`, `token`, `data_criacao`, `data_expiracao`, `ativo`) VALUES
(1, 2, 'empresa', 'f2aed1a6e63e90a41199f56e8e4dcae0848b4754e6dd471cace4906781f03552', '2025-08-31 01:31:47', '2025-09-01 06:31:47', 1),
(2, 2, 'empresa', 'dadbd1549ec547305a980efcdac570ec767e8f00e3c41a0802a7800fc2034a19', '2025-08-31 01:31:51', '2025-09-01 06:31:51', 1),
(3, 2, 'empresa', 'f8c401b928da818f81a2f2455c06ef4a78ddbcbe6dbd960788fef6f89b70175f', '2025-08-31 01:32:13', '2025-09-01 06:32:13', 1),
(4, 1, 'funcionario', '2f08634b156727fda7a85b5766e5b93e885b9775d3c695fae7409411f5976d8e', '2025-08-31 01:33:03', '2025-09-01 06:33:03', 1),
(5, 2, 'empresa', 'a434356f19fb04e812cfd02d6040aa99a5fa9b67f1a4b1e8e8c9a9e1ca328cf4', '2025-08-31 01:39:30', '2025-09-01 06:39:30', 1),
(6, 1, 'funcionario', '0dd3db71d9f8b311338035c8db7ee5cb3e3435f3ea221aca275efd40e6212182', '2025-08-31 01:39:50', '2025-09-01 06:39:50', 1),
(7, 2, 'empresa', '57648812acf1887ccdb72a0f7f93ef22c2b3d915dacac65c3ebc30d4a4ad0be1', '2025-08-31 01:41:27', '2025-09-01 06:41:27', 1),
(8, 1, 'funcionario', '44f4e58bd3b0492dc5953bd6d5ce6f9a07a3615414cff5746429f844005dedab', '2025-08-31 01:41:52', '2025-09-01 06:41:52', 1),
(9, 1, 'funcionario', '797c09a49641ca16a02297f55def8bfe61bf0f5d05f332244832147abd318818', '2025-08-31 01:45:21', '2025-09-01 06:45:21', 1),
(10, 2, 'empresa', 'dbfb780358aa17c90350824ec3b7856c6396e9931dc7816b16297dd65528152e', '2025-08-31 01:45:41', '2025-09-01 06:45:41', 1),
(11, 1, 'funcionario', 'd257290a0fc9622df417d93b9ea70e399f705defe2378249c1640300c5121180', '2025-08-31 01:46:11', '2025-09-01 06:46:11', 1),
(12, 2, 'empresa', '7dc41dad0147dd99d00eaa1f202e2635b2e042089ad680c7b733c3e09ae035d6', '2025-08-31 01:55:31', '2025-09-01 06:55:31', 1),
(13, 1, 'funcionario', 'b3c5aae9ab811e832a2ab4ed3121fe13e104fdd9678dbed232ca152d3116269f', '2025-08-31 01:55:41', '2025-09-01 06:55:41', 1),
(14, 1, 'funcionario', 'c622b1fca6d79883999b54fb76238737b1812386dbb289f26e518be7dd11aa5c', '2025-08-31 02:04:37', '2025-09-01 07:04:37', 1),
(15, 2, 'empresa', 'c09fb1adc735e1213862fa4ee25d7c58742b0df5f0227bbb21e474dc4e7aa875', '2025-08-31 02:04:53', '2025-09-01 07:04:53', 1),
(16, 1, 'funcionario', 'a7e9c568927a9edb9939daee7d54385fd88b0f7ca269575d1e989dd399b77414', '2025-08-31 02:05:41', '2025-09-01 07:05:41', 1),
(17, 2, 'empresa', '599df1e7311bed7dc86c58bf83d3be8d75bdf80c4c33e0059c852051155a15fa', '2025-08-31 02:06:13', '2025-09-01 07:06:13', 1),
(18, 1, 'funcionario', '5132bee3bb0d9c8efde44d3ccdd87f7d57f32290d08c30e6c0e77a5f95ed0b67', '2025-08-31 02:08:02', '2025-09-01 07:08:02', 1),
(19, 1, 'funcionario', '189fcdb92e283e37d58b6048b16a683b45daf252dccaeed91e090aa12fa69df2', '2025-09-12 00:36:26', '2025-09-13 05:36:26', 1),
(20, 2, 'empresa', 'd569334544ea397f9562c541bb4f086bfb6f90ff82cfa29f613565d41152a3bc', '2025-09-12 00:38:02', '2025-09-13 05:38:02', 1),
(21, 2, 'empresa', '36476074e2a240a465254d21c0528b9372f87787323f096e5524af2af785862b', '2025-09-12 00:38:19', '2025-09-13 05:38:19', 1),
(22, 2, 'empresa', '5dcdc02b2f870163511603d64e9a283b5509e54fc6e0d18510e9f779eecf0a79', '2025-09-12 00:48:03', '2025-09-13 05:48:03', 1),
(23, 2, 'empresa', 'a4e4b78e400a632396b195167e53b982b6f0f0096cac16356de9782f4722b7fd', '2025-09-12 00:48:42', '2025-09-13 05:48:42', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cnpj` (`cnpj`);

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `empresa_id` (`empresa_id`);

--
-- Índices de tabela `questionarios`
--
ALTER TABLE `questionarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `funcionario_id` (`funcionario_id`),
  ADD KEY `empresa_id` (`empresa_id`);

--
-- Índices de tabela `sessoes`
--
ALTER TABLE `sessoes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `questionarios`
--
ALTER TABLE `questionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `sessoes`
--
ALTER TABLE `sessoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD CONSTRAINT `funcionarios_ibfk_1` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `questionarios`
--
ALTER TABLE `questionarios`
  ADD CONSTRAINT `questionarios_ibfk_1` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `questionarios_ibfk_2` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
