-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/08/2025 às 03:28
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
-- Banco de dados: `public`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `referencia` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `enderecos`
--

INSERT INTO `enderecos` (`id`, `id_usuario`, `bairro`, `endereco`, `numero`, `referencia`) VALUES
(1, 1, 'São Jorge ', 'Rua Andres Jose Tumang', '603', 'Residencial Nova Suiça 2,  Casa 11'),
(4, 5, 'São Jorge', 'Rua São João', '377', 'Nova Suiça 2 casa 11');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `referencia` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `endereco`, `bairro`, `numero`, `referencia`, `foto`) VALUES
(1, 'LUCAS TITONELLI FERNANDES', 'titonellilucas100@gmail.com', '$2y$10$4am.SrcBeIN8.vxWrFe8IeMznpJPJ7IWsxI.20JkjJYCjQsNdb2iq', NULL, NULL, NULL, NULL, NULL),
(5, 'LUCAS', 'titonellilucas000@gmail.com', '$2y$10$RIiYNOwT4yOaJMfJn9FK0uaym8Kj4zDj65KrgbDgrNN2L/qoIRyqi', 'Rua São João, 377', 'Artemis', '521', 'Fundo', 'user_5.jpg');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `enderecos`
--
ALTER TABLE `enderecos`
  ADD CONSTRAINT `enderecos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
