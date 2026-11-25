-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 25, 2026 at 01:01 PM
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
('ALW-M16-0012', 'Alienware m16 R2', 'Diseño gamer con iluminacion RGB.', 'Intel Core Ultra 9 185H', 'NVIDIA RTX 4070', 32, 1000, 'SSD', 8999.00, 9899.00, 4, '1795590794_6b068a8a2e0ee.jpg', 1, '2026-11-25 07:08:52'),
('ALW-M18-0014', 'Alienware m18 R2', 'Pantalla de 18 pulgadas para escritorio portatil.', 'Intel Core i9-14900HX', 'NVIDIA RTX 4090', 64, 2000, 'SSD', 15999.00, 17499.00, 4, '1795590893_6b068aed6d1e2.jpg', 1, '2026-11-25 07:08:52'),
('ALW-X16-0013', 'Alienware x16 R2', 'Gama alta para jugar en 4K.', 'Intel Core Ultra 9 185H', 'NVIDIA RTX 4080', 32, 2000, 'SSD', 12499.00, NULL, 4, '1795590923_6b068b0b76301.jpg', 1, '2026-11-25 07:08:52'),
('ASU-TUF-0003', 'TUF Gaming F15', 'Laptop gamer resistente con buena refrigeracion.', 'Intel Core i7-12700H', 'NVIDIA RTX 4060', 16, 512, 'SSD', 4599.00, 5199.00, 1, '1795590955_6b068b2b552b6.jpg', 1, '2026-11-25 07:08:52'),
('ASU-VB15-0001', 'Vivobook 15', 'Laptop ligera para estudio y oficina.', 'Intel Core i5-1235U', 'Intel Iris Xe', 8, 512, 'SSD', 2199.00, 2599.00, 1, '1795591132_6b068bdc8aed3.jpg', 1, '2026-11-25 07:08:52'),
('ASU-VB16-0004', 'Vivobook 16X', 'Pantalla grande para multitarea.', 'AMD Ryzen 7 7735HS', 'AMD Radeon 680M', 16, 512, 'SSD', 3199.00, NULL, 1, '1795591123_6b068bd3ea234.jpg', 1, '2026-11-25 07:08:52'),
('ASU-ZB14-0002', 'Zenbook 14 OLED', 'Pantalla OLED 2.8K y gran autonomia.', 'Intel Core Ultra 7 155H', 'Intel Arc', 16, 1000, 'SSD', 4299.00, NULL, 1, '1795590704_6b068a300ef96.jpg', 1, '2026-11-25 07:08:52'),
('DEL-INS-0008', 'Inspiron 15 3520', 'Equipo economico para el dia a dia.', 'Intel Core i3-1215U', 'Intel UHD Graphics', 8, 256, 'SSD', 1699.00, NULL, 3, '1795590880_6b068ae05d71c.jpg', 1, '2026-11-25 07:08:52'),
('DEL-LAT-0011', 'Latitude 5440', 'Laptop corporativa con alta seguridad.', 'Intel Core i7-1355U', 'Intel Iris Xe', 16, 512, 'SSD', 4799.00, NULL, 3, '1795590909_6b068afd9e9fa.jpg', 0, '2026-11-25 07:08:52'),
('DEL-VOS-0009', 'Vostro 3420', 'Pensada para pequeñas empresas.', 'Intel Core i5-1235U', 'Intel Iris Xe', 8, 512, 'SSD', 2399.00, 2699.00, 3, '1795590937_6b068b1903741.jpg', 1, '2026-11-25 07:08:52'),
('DEL-XPS-0010', 'XPS 13 Plus', 'Ultradelgada con acabado premium.', 'Intel Core i7-1360P', 'Intel Iris Xe', 16, 512, 'SSD', 6299.00, NULL, 3, '1795591114_6b068bca44c5f.jpg', 1, '2026-11-25 07:08:52'),
('HP-15F-0019', 'HP 15-fd0000', 'Laptop basica para tareas de oficina.', 'Intel Core i5-1334U', 'Intel Iris Xe', 8, 512, 'SSD', 2099.00, 2399.00, 6, '1795591147_6b068beb42b39.jpg', 1, '2026-11-25 07:08:52'),
('HP-VIC-0020', 'Victus 15', 'Laptop gamer con pantalla de 144 Hz.', 'AMD Ryzen 5 7535HS', 'NVIDIA RTX 2050', 8, 512, 'SSD', 2899.00, NULL, 6, '1795590697_6b068a299cf59.jpg', 1, '2026-11-25 07:08:52'),
('LEN-IP3-0015', 'IdeaPad 3 15', 'Buen precio para estudiantes.', 'AMD Ryzen 5 7520U', 'AMD Radeon 610M', 8, 512, 'SSD', 1899.00, 2199.00, 5, '1795590873_6b068ad9cbd41.jpg', 1, '2026-11-25 07:08:52'),
('LEN-IPS5-0016', 'IdeaPad Slim 5', 'Delgada, ligera y con buena bateria.', 'AMD Ryzen 7 7730U', 'AMD Radeon Graphics', 16, 512, 'SSD', 2999.00, NULL, 5, '1795590901_6b068af52d61e.jpg', 1, '2026-11-25 07:08:52'),
('LEN-LOQ-0017', 'LOQ 15IRH8', 'Iniciacion gamer con buena relacion precio-rendimiento.', 'Intel Core i5-12450H', 'NVIDIA RTX 3050', 8, 512, 'SSD', 3299.00, 3799.00, 5, '1795590886_6b068ae6b73ec.jpg', 1, '2026-11-25 07:08:52'),
('LEN-TPE-0018', 'ThinkPad E14 Gen 5', 'Teclado comodo y gran durabilidad.', 'Intel Core i5-1335U', 'Intel Iris Xe', 16, 1000, 'HDD', 3599.00, NULL, 5, '1795591108_6b068bc47f895.jpg', 1, '2026-11-25 07:08:52'),
('ROG-FLW-0007', 'Flow X13', 'Convertible 2 en 1 con pantalla tactil.', 'AMD Ryzen 9 7940HS', 'NVIDIA RTX 4050', 16, 512, 'SSD', 6599.00, 7299.00, 2, '1795591140_6b068be495c15.jpg', 1, '2026-11-25 07:08:52'),
('ROG-STX-0005', 'Strix G16', 'Alto rendimiento para juegos competitivos.', 'Intel Core i9-13980HX', 'NVIDIA RTX 4070', 16, 1000, 'SSD', 7499.00, 8299.00, 2, '1795590685_6b068a1d3ca4f.jpg', 1, '2026-11-25 07:08:52'),
('ROG-ZEP-0006', 'Zephyrus G14', 'Compacta y potente, chasis de aluminio.', 'AMD Ryzen 9 8945HS', 'NVIDIA RTX 4060', 32, 1000, 'SSD', 8199.00, NULL, 2, '1795590771_6b068a732b678.jpg', 1, '2026-11-25 07:08:52');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` enum('admin','cliente') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cliente',
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `password`, `rol`, `foto`, `creado_en`) VALUES
(12, 'kevin@nexuscorp.com', 'Kevin Medina', '$2y$12$CBDI1LXpSZfK1dB.Wh.pIu4h/WEZLcAmLQk.HWay13x8zOvSUsPQ2', 'admin', '1795611595_6b06dbcb635a7.jpg', '2026-11-24 00:28:49'),
(15, 'derick@nexuscorp.com', 'Derick Vasquez', '$2y$12$YPyEQJPtdK1pZxVqAWx1xe/y4Pfg/PPYnio2KGUSPa1dmC32Jv1TO', 'admin', '1795611612_6b06dbdc42a47.jpg', '2026-11-25 09:33:17');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
