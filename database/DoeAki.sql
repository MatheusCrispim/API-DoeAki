-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 01-Nov-2018 às 03:51
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
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `description` text NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `cnpj` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Institutions_donation_data`
--

CREATE TABLE `Institutions_donation_data` (
  `id` int(11) NOT NULL,
  `donationID` varchar(100) NOT NULL,
  `verified` tinyint(1) NOT NULL,
  `cnpj` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Session`
--

CREATE TABLE `Session` (
  `id` int(11) NOT NULL,
  `session_id` varchar(32) NOT NULL,
  `user_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Institutions`
--
ALTER TABLE `Institutions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cnpj` (`cnpj`),
  ADD KEY `cnpj_2` (`cnpj`);

--
-- Indexes for table `Institutions_donation_data`
--
ALTER TABLE `Institutions_donation_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cnpj` (`cnpj`);

--
-- Indexes for table `Session`
--
ALTER TABLE `Session`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_id` (`session_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Institutions`
--
ALTER TABLE `Institutions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Institutions_donation_data`
--
ALTER TABLE `Institutions_donation_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Session`
--
ALTER TABLE `Session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
