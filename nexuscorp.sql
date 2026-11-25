-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 24, 2026 at 06:04 PM
-- Server version: 5.7.24
-- PHP Version: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nexuscorp`
--

-- --------------------------------------------------------

--
-- Table structure for table `fabricantes`
--

CREATE TABLE `fabricantes` (
  `id_fabricante` int(10) UNSIGNED NOT NULL,
  `nombre_fabricante` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fabricantes`
--

INSERT INTO `fabricantes` (`id_fabricante`, `nombre_fabricante`) VALUES
(4, 'ALIENWARE'),
(1, 'ASUS'),
(3, 'DELL'),
(6, 'HP'),
(5, 'LENOVO'),
(2, 'ROG');

-- --------------------------------------------------------

--
-- Table structure for table `laptops`
--

CREATE TABLE `laptops` (
  `numero_serie` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modelo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `procesador` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tarjeta_grafica` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ram_gb` smallint(5) UNSIGNED NOT NULL,
  `almacenamiento_gb` smallint(5) UNSIGNED NOT NULL,
  `tipo_almacenamiento` enum('SSD','HDD') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SSD',
  `precio` decimal(10,2) NOT NULL,
  `precio_anterior` decimal(10,2) DEFAULT NULL,
  `id_fabricante` int(10) UNSIGNED NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laptops`
--

INSERT INTO `laptops` (`numero_serie`, `modelo`, `descripcion`, `procesador`, `tarjeta_grafica`, `ram_gb`, `almacenamiento_gb`, `tipo_almacenamiento`, `precio`, `precio_anterior`, `id_fabricante`, `foto`, `activo`, `creado_en`) VALUES
('234567890ertyi', 'testdds', 'test', 'i9 11900', 'RTX 3050 TI', 356, 500, 'SSD', 4999.00, 5999.00, 5, '1795535925_6b05b435ef895.jpg', 1, '2026-11-24 15:58:45'),
('3467hhhf21', 'Serie 4000', 'test', 'i9 11900', 'RTX 3050 TI', 16, 500, 'SSD', 700.00, NULL, 3, '1795491787_6b0507cb647eb.png', 1, '2026-11-24 03:43:07'),
('3467hhhf21dsd2', 'Serie 4000', 'test pesh', 'i9 11900', 'RTX 3060 TI', 12, 1024, 'SSD', 4999.00, 5999.00, 3, '1795492088_6b0508f8b6a67.png', 1, '2026-11-24 03:48:08');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` enum('admin','cliente') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cliente',
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `rol`, `foto`, `creado_en`) VALUES
(12, 'Kevin@admin.com', '$2y$12$CBDI1LXpSZfK1dB.Wh.pIu4h/WEZLcAmLQk.HWay13x8zOvSUsPQ2', 'admin', '1795495688_6b051708201e0.png', '2026-11-24 00:28:49'),
(13, 'alonso@gmail.com', '$2y$12$qTspci7BPEtnGVEeWrAcy.1wVrd.YT3DIm74N9gcVFyp7YHRUJ6Wq', 'cliente', '1795537643_6b05baeb4be1f.png', '2026-11-24 16:27:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fabricantes`
--
ALTER TABLE `fabricantes`
  ADD PRIMARY KEY (`id_fabricante`),
  ADD UNIQUE KEY `nombre_fabricante` (`nombre_fabricante`);

--
-- Indexes for table `laptops`
--
ALTER TABLE `laptops`
  ADD PRIMARY KEY (`numero_serie`),
  ADD KEY `fk_laptops_fabricante` (`id_fabricante`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fabricantes`
--
ALTER TABLE `fabricantes`
  MODIFY `id_fabricante` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `laptops`
--
ALTER TABLE `laptops`
  ADD CONSTRAINT `fk_laptops_fabricante` FOREIGN KEY (`id_fabricante`) REFERENCES `fabricantes` (`id_fabricante`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
