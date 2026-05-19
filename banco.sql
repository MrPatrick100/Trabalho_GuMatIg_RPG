-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/05/2026 às 22:59
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
-- Banco de dados: `banco`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `habilidade`
--

CREATE TABLE `habilidade` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `ciclo` varchar(20) DEFAULT NULL,
  `estilo` varchar(40) DEFAULT NULL,
  `custo` int(11) DEFAULT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `inventario`
--

CREATE TABLE `inventario` (
  `id_personagem` int(11) DEFAULT NULL,
  `cabeca` varchar(255) DEFAULT NULL,
  `peitoral` varchar(255) DEFAULT NULL,
  `calca` varchar(255) DEFAULT NULL,
  `calcado` varchar(255) DEFAULT NULL,
  `arma1` varchar(255) DEFAULT NULL,
  `arma2` varchar(255) DEFAULT NULL,
  `amuleto` varchar(255) DEFAULT NULL,
  `itens` text DEFAULT NULL,
  `moedas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pericias`
--

CREATE TABLE `pericias` (
  `id_personagem` int(11) DEFAULT NULL,
  `acrobacia` int(11) NOT NULL,
  `adestramento` int(11) NOT NULL,
  `artes` int(11) NOT NULL,
  `atletismo` int(11) NOT NULL,
  `diplomacia` int(11) NOT NULL,
  `enganacao` int(11) NOT NULL,
  `fortitude` int(11) NOT NULL,
  `furtividade` int(11) NOT NULL,
  `intimidacao` int(11) NOT NULL,
  `intuicao` int(11) NOT NULL,
  `investigacao` int(11) NOT NULL,
  `luta_briga` int(11) NOT NULL,
  `medicina` int(11) NOT NULL,
  `ocultismo` int(11) NOT NULL,
  `percepcao` int(11) NOT NULL,
  `pontaria` int(11) NOT NULL,
  `reflexos_iniciativa` int(11) NOT NULL,
  `religiao` int(11) NOT NULL,
  `tatica` int(11) NOT NULL,
  `vontade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `personagem`
--

CREATE TABLE `personagem` (
  `id_usuario` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `idade` int(11) DEFAULT NULL,
  `raca` varchar(40) NOT NULL,
  `nivel` int(11) NOT NULL,
  `agilidade` int(11) NOT NULL,
  `forca` int(11) NOT NULL,
  `intelecto` int(11) NOT NULL,
  `constituicao` int(11) NOT NULL,
  `carisma` int(11) NOT NULL,
  `magia` int(11) NOT NULL,
  `aparencia` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `personagem_habilidade`
--

CREATE TABLE `personagem_habilidade` (
  `id_personagem` int(11) NOT NULL,
  `id_habilidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` char(64) NOT NULL COMMENT 'Hash SHA256 da senha',
  `criado_em` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `criado_em`) VALUES
(1, 'Ash Ketchum', 'admin@email.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2026-05-19 16:12:18');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `habilidade`
--
ALTER TABLE `habilidade`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `inventario`
--
ALTER TABLE `inventario`
  ADD KEY `id_personagem` (`id_personagem`);

--
-- Índices de tabela `pericias`
--
ALTER TABLE `pericias`
  ADD KEY `id_personagem` (`id_personagem`);

--
-- Índices de tabela `personagem`
--
ALTER TABLE `personagem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_personagem_usuario` (`id_usuario`);

--
-- Índices de tabela `personagem_habilidade`
--
ALTER TABLE `personagem_habilidade`
  ADD PRIMARY KEY (`id_personagem`,`id_habilidade`),
  ADD KEY `id_habilidade` (`id_habilidade`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `habilidade`
--
ALTER TABLE `habilidade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `personagem`
--
ALTER TABLE `personagem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`id_personagem`) REFERENCES `personagem` (`id`);

--
-- Restrições para tabelas `pericias`
--
ALTER TABLE `pericias`
  ADD CONSTRAINT `pericias_ibfk_1` FOREIGN KEY (`id_personagem`) REFERENCES `personagem` (`id`);

--
-- Restrições para tabelas `personagem`
--
ALTER TABLE `personagem`
  ADD CONSTRAINT `fk_personagem_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Restrições para tabelas `personagem_habilidade`
--
ALTER TABLE `personagem_habilidade`
  ADD CONSTRAINT `fk_personagem` FOREIGN KEY (`id_personagem`) REFERENCES `personagem` (`id`),
  ADD CONSTRAINT `personagem_habilidade_ibfk_2` FOREIGN KEY (`id_habilidade`) REFERENCES `habilidade` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
