-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2020 at 02:25 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `virtualib`
--

-- --------------------------------------------------------

--
-- Table structure for table `envios`
--

CREATE TABLE `envios` (
  `id_user` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_libro` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_prestamo` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `libros`
--

CREATE TABLE `libros` (
  `id` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `autor` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `editorial` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `categoria` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(250) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `imagen` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `libros`
--

INSERT INTO `libros` (`id`, `nombre`, `autor`, `editorial`, `categoria`, `descripcion`, `imagen`) VALUES
('1', '2', '3', '4', '56', '6', '2.jpg'),
('3', 'Harry potter', 'anonimo', 'separia', 'ficcion', 'trata de una escuela de brujeria', 'portadaAtras.jpg'),
('Li12', 'No sé', 'Quien sabe', 'Ni idea', 'Eequis', 'Yolo', '1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `prestamos`
--

CREATE TABLE `prestamos` (
  `Id_prestamo` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Domicilio` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Telefono` varchar(10) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Fecha_salida` datetime(6) NOT NULL,
  `Fecha_entrega` datetime(6) NOT NULL,
  `Id_libro` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT '0',
  `Dni_user` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `Dni` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Nombre` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ApellidoP` varchar(25) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ApellidoM` varchar(25) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Telefono` varchar(10) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Direccion` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `envios`
--
ALTER TABLE `envios`
  ADD KEY `Fk_envio_usuario` (`id_user`),
  ADD KEY `Fk_envios_prestamos` (`id_prestamo`),
  ADD KEY `Fk_envios_libros` (`id_libro`);

--
-- Indexes for table `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`Id_prestamo`),
  ADD KEY `Fk_usuarios_prestamos` (`Dni_user`),
  ADD KEY `Fk_libros_prestamos` (`Id_libro`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Dni`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `envios`
--
ALTER TABLE `envios`
  ADD CONSTRAINT `Fk_envio_usuario` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`Dni`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Fk_envios_libros` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Fk_envios_prestamos` FOREIGN KEY (`id_prestamo`) REFERENCES `prestamos` (`Id_prestamo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `Fk_libros_prestamos` FOREIGN KEY (`Id_libro`) REFERENCES `libros` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Fk_usuarios_prestamos` FOREIGN KEY (`Dni_user`) REFERENCES `usuarios` (`Dni`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
