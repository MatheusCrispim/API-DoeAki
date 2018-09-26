-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 25-Set-2018 às 07:18
-- Versão do servidor: 5.6.30-1
-- PHP Version: 7.2.4-1+b1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `DoeAki`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `Institutions`
--

CREATE TABLE `Institutions` (
  `ID` int(11) NOT NULL,
  `CNPJ` varchar(10) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `ADRESS` varchar(100) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `CAUSE` varchar(100) NOT NULL,
  `BANKERDATA` int(11) NOT NULL,
  `LATITUDE` float NOT NULL,
  `LONGITUDE` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `Institutions`
--

INSERT INTO `Institutions` (`ID`, `CNPJ`, `NAME`, `ADRESS`, `DESCRIPTION`, `CAUSE`, `BANKERDATA`, `LATITUDE`, `LONGITUDE`) VALUES
(1, '111111111', 'Instituição', 'Avenida Santa Elizabete, Número 1', 'Fazemos Caridade', 'Caridade', 2013548578, -7.0795, -34.8481);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Institutions`
--
ALTER TABLE `Institutions`
  ADD PRIMARY KEY (`ID`,`CNPJ`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Institutions`
--
ALTER TABLE `Institutions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
