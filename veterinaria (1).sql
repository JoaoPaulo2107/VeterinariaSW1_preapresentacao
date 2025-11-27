-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/11/2025 às 01:23
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
-- Banco de dados: `veterinaria`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `animal`
--

CREATE TABLE `animal` (
  `Raca` varchar(50) DEFAULT NULL,
  `Nome` varchar(50) DEFAULT NULL,
  `ID_Animal` int(11) NOT NULL,
  `Idade` int(11) DEFAULT NULL,
  `Sexo` varchar(10) DEFAULT NULL,
  `Especie` varchar(50) DEFAULT NULL,
  `Peso` decimal(5,2) DEFAULT NULL,
  `Observacao` varchar(255) DEFAULT NULL,
  `idDono_animal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `animal`
--

INSERT INTO `animal` (`Raca`, `Nome`, `ID_Animal`, `Idade`, `Sexo`, `Especie`, `Peso`, `Observacao`, `idDono_animal`) VALUES
('Persa', 'Betty', 2, 5, 'Fêmea', 'Gato', 5.60, 'Alergia leve', 2),
('Persa', 'Jasmin', 4, 5, 'Fêmea', 'Gato', 13.00, 'Ela é pequena', 1),
('Pastor Alemão', 'Elizabeth', 5, 2, 'Fêmea', 'Cachorro', 22.00, 'Ela é grande', 2),
('Persa', 'Taylor', 6, 11, 'Macho', 'Gato', 12.00, 'Ele é agitado.', 1),
('Labrador', 'Justin', 10, 5, 'Macho', 'Cachorro', 50.00, 'come muito', 1),
('Beija-flor', 'Shawn', 17, 11, 'Fêmea', 'Gato', 11.00, 'Ela é pequena', 2),
('Beija-flor', 'Taylor', 20, 5, 'Macho', 'Cachorro', 13.00, 'ela é violenta.', 5),
('Labrador', 'Justin', 21, 2, 'Macho', 'Cachorro', 50.00, 'Ela é pequena', 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `consulta`
--

CREATE TABLE `consulta` (
  `ID_consulta` int(11) NOT NULL,
  `Data_consulta` date DEFAULT NULL,
  `Procedimento` varchar(100) DEFAULT NULL,
  `Horario` varchar(30) DEFAULT NULL,
  `Observacao` varchar(255) DEFAULT NULL,
  `ID_Animal` int(11) DEFAULT NULL,
  `ID_veterinario` int(11) DEFAULT NULL,
  `Status` enum('Pendente','Aceita','Recusada') DEFAULT 'Pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `consulta`
--

INSERT INTO `consulta` (`ID_consulta`, `Data_consulta`, `Procedimento`, `Horario`, `Observacao`, `ID_Animal`, `ID_veterinario`, `Status`) VALUES
(2, '2024-01-16', 'Check-up', '14:00', 'Consulta de rotina', 2, 2, 'Recusada');

-- --------------------------------------------------------

--
-- Estrutura para tabela `dono_animal`
--

CREATE TABLE `dono_animal` (
  `Telefone` varchar(20) DEFAULT NULL,
  `Nome` varchar(80) DEFAULT NULL,
  `ID_Dono_animal` int(11) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `CPF` varchar(14) DEFAULT NULL,
  `Endereco` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `dono_animal`
--

INSERT INTO `dono_animal` (`Telefone`, `Nome`, `ID_Dono_animal`, `Email`, `CPF`, `Endereco`) VALUES
('(11) 9999-8888', 'João', 1, 'joao@email.com', '123.456.789-00', 'Rua das Flores, 100'),
('(11) 7777-6666', 'Maria', 2, 'maria@email.com', '987.654.321-00', 'Av. Central, 200');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `ID_veterinario` int(11) NOT NULL,
  `CRMV` varchar(20) DEFAULT NULL,
  `Nome` varchar(80) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Telefone` varchar(20) DEFAULT NULL,
  `Especialidade` varchar(50) DEFAULT NULL,
  `Horario` varchar(30) DEFAULT NULL,
  `Sexo` varchar(10) DEFAULT NULL,
  `Data_Nascimento` date DEFAULT NULL,
  `CPF` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionario`
--

INSERT INTO `funcionario` (`ID_veterinario`, `CRMV`, `Nome`, `Email`, `Telefone`, `Especialidade`, `Horario`, `Sexo`, `Data_Nascimento`, `CPF`) VALUES
(2, '67890-SP', 'Dra. Ana', 'ana@vet.com', '(11) 97777-6666', 'Cirurgia', '09:00-18:00', NULL, '1990-08-15', '555.666.777-88'),
(3, '12345-SP', 'Dr. Carlo', 'carlos@vet.com', '(11) 98888-7777', 'Clínico Geral', NULL, 'Masculino', '2025-07-19', '111.222.333-44');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `ID_usuario` int(11) NOT NULL,
  `idDono_animal` int(11) DEFAULT NULL,
  `Telefone` varchar(20) DEFAULT NULL,
  `Tipo` varchar(20) DEFAULT NULL,
  `CPF` varchar(14) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Senha` varchar(255) DEFAULT NULL,
  `Nome` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`ID_usuario`, `idDono_animal`, `Telefone`, `Tipo`, `CPF`, `Email`, `Senha`, `Nome`) VALUES
(1, NULL, '1111111111', NULL, '1111111111', 'gabi@gmail.com', '$2y$10$Q0VoBwD4xlLA4KyO9MRYduhPl0cuO/qY6qrSIzbI60b09ss36Z8kK', 'Gabriela Romano'),
(2, NULL, '13131313', NULL, '1111111112', 'a@gmail.com', '$2y$10$HeXc0SbvVty8.2c1.9VPSeKtC2uksnRVz4CfFFzux4yF8fxly/5xi', 'Taylor Swift'),
(3, NULL, '12', NULL, '12', 'sofi@gmail.com', '$2y$10$V6UvCH6m.ZBtGpu29KjaUOP6th3eNoHF3bouNL/veaRr0kZBrKG1u', 'Sofia'),
(4, NULL, '13131313', NULL, '1111111112', 'sofia@gmail.com', '$2y$10$py.gB0VTdJqDujXCVGDcmOruBCY7gCfJ7sONV.bl3.ztds96DhUZe', 'Sofia'),
(5, NULL, '13131313', NULL, '1111111111', 'c@gmail.com', '$2y$10$oa6KNb1w6Ja7IufUDvz3P.ur.v4L2ylURG3ux9tYpXzpJyyw0erpq', 'Clara'),
(6, NULL, '13131313', NULL, '1111111111', 'isa@gmail.com', '$2y$10$Iyq2J78cOueOM1B7130BZup3NshnXFD9dXx4rR4v9hGeEuBHmlvfG', 'Isabela'),
(7, NULL, '11999999999', NULL, '00000000000', 'admin@vet.com', '$2y$10$Q0VoBwD4xlLA4KyO9MRYduhPl0cuO/qY6qrSIzbI60b09ss36Z8kK', 'Administrador');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`ID_Animal`),
  ADD KEY `fk_animal_usuario` (`idDono_animal`);

--
-- Índices de tabela `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`ID_consulta`),
  ADD KEY `fk_consulta_animal` (`ID_Animal`),
  ADD KEY `fk_consulta_funcionario` (`ID_veterinario`);

--
-- Índices de tabela `dono_animal`
--
ALTER TABLE `dono_animal`
  ADD PRIMARY KEY (`ID_Dono_animal`);

--
-- Índices de tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`ID_veterinario`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `animal`
--
ALTER TABLE `animal`
  MODIFY `ID_Animal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `consulta`
--
ALTER TABLE `consulta`
  MODIFY `ID_consulta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `dono_animal`
--
ALTER TABLE `dono_animal`
  MODIFY `ID_Dono_animal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `ID_veterinario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `fk_animal_usuario` FOREIGN KEY (`idDono_animal`) REFERENCES `usuario` (`ID_usuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `fk_consulta_animal` FOREIGN KEY (`ID_Animal`) REFERENCES `animal` (`ID_Animal`),
  ADD CONSTRAINT `fk_consulta_funcionario` FOREIGN KEY (`ID_veterinario`) REFERENCES `funcionario` (`ID_veterinario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
