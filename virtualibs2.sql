-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         10.4.8-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para virtualib
CREATE DATABASE IF NOT EXISTS `virtualib` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci */;
USE `virtualib`;

-- Volcando estructura para tabla virtualib.envios
CREATE TABLE IF NOT EXISTS `envios` (
  `id_user` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_libro` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_prestamo` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL,
  KEY `Fk_envio_usuario` (`id_user`),
  KEY `Fk_envios_prestamos` (`id_prestamo`),
  KEY `Fk_envios_libros` (`id_libro`),
  CONSTRAINT `Fk_envio_usuario` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`Dni`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Fk_envios_libros` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Fk_envios_prestamos` FOREIGN KEY (`id_prestamo`) REFERENCES `prestamos` (`Id_prestamo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla virtualib.envios: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `envios` DISABLE KEYS */;
/*!40000 ALTER TABLE `envios` ENABLE KEYS */;

-- Volcando estructura para tabla virtualib.libros
CREATE TABLE IF NOT EXISTS `libros` (
  `id` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `autor` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `editorial` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `categoria` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(250) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `imagen` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla virtualib.libros: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `libros` DISABLE KEYS */;
REPLACE INTO `libros` (`id`, `nombre`, `autor`, `editorial`, `categoria`, `descripcion`, `imagen`) VALUES
	('1', '2', '3', '4', '56', '6', '2.jpg'),
	('3', 'Harry potter', 'anonimo', 'separia', 'ficcion', 'trata de una escuela de brujeria', 'portadaAtras.jpg'),
	('Li12', 'No sé', 'Quien sabe', 'Ni idea', 'Eequis', 'Yolo', '1.jpg');
/*!40000 ALTER TABLE `libros` ENABLE KEYS */;

-- Volcando estructura para tabla virtualib.prestamos
CREATE TABLE IF NOT EXISTS `prestamos` (
  `Id_prestamo` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Domicilio` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Telefono` varchar(10) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Fecha_salida` datetime(6) NOT NULL,
  `Fecha_entrega` datetime(6) NOT NULL,
  `Id_libro` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT '0',
  `Dni_user` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id_prestamo`),
  KEY `Fk_usuarios_prestamos` (`Dni_user`),
  KEY `Fk_libros_prestamos` (`Id_libro`),
  CONSTRAINT `Fk_libros_prestamos` FOREIGN KEY (`Id_libro`) REFERENCES `libros` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Fk_usuarios_prestamos` FOREIGN KEY (`Dni_user`) REFERENCES `usuarios` (`Dni`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla virtualib.prestamos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `prestamos` DISABLE KEYS */;
/*!40000 ALTER TABLE `prestamos` ENABLE KEYS */;

-- Volcando estructura para tabla virtualib.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `Dni` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Nombre` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ApellidoP` varchar(25) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ApellidoM` varchar(25) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Telefono` varchar(10) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Direccion` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`Dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla virtualib.usuarios: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
