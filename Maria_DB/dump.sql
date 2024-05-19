-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-05-2024 a las 01:45:33
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dump`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operarios`
--

CREATE TABLE `operarios` (
  `id_operario` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `marca_motocarro` varchar(100) DEFAULT NULL,
  `modelo_motocarro` varchar(100) DEFAULT NULL,
  `año_motocarro` int(11) DEFAULT NULL,
  `placa_motocarro` varchar(20) DEFAULT NULL,
  `foto_motocarro` varchar(255) DEFAULT NULL,
  `foto_2` varchar(255) DEFAULT NULL,
  `foto_3` varchar(255) DEFAULT NULL,
  `foto_4` varchar(255) DEFAULT NULL,
  `foto_5` varchar(255) DEFAULT NULL,
  `foto_6` varchar(255) DEFAULT NULL,
  `foto_7` varchar(255) DEFAULT NULL,
  `foto_8` varchar(255) DEFAULT NULL,
  `foto_9` varchar(255) DEFAULT NULL,
  `foto_10` varchar(255) DEFAULT NULL,
  `direccion_domicilio` varchar(255) DEFAULT NULL,
  `certificado_antecedentes_judiciales` varchar(255) DEFAULT NULL,
  `certificado_seguridad_social` varchar(255) DEFAULT NULL,
  `licencia_conduccion` varchar(50) DEFAULT NULL,
  `seguro_vehiculo` varchar(255) DEFAULT NULL,
  `calificacion` int(11) DEFAULT NULL,
  `otros_detalles` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `operarios`
--

INSERT INTO `operarios` (`id_operario`, `id_usuario`, `marca_motocarro`, `modelo_motocarro`, `año_motocarro`, `placa_motocarro`, `foto_motocarro`, `foto_2`, `foto_3`, `foto_4`, `foto_5`, `foto_6`, `foto_7`, `foto_8`, `foto_9`, `foto_10`, `direccion_domicilio`, `certificado_antecedentes_judiciales`, `certificado_seguridad_social`, `licencia_conduccion`, `seguro_vehiculo`, `calificacion`, `otros_detalles`) VALUES
(1, 3, 'pepe', '2011', 2011, 'eag09c', 'media/fotos/descargar (2).jpg', 'media/fotos/descargar (6).jpg', 'media/fotos/descargar (4).jpg', 'media/fotos/descargar (3).jpg', 'media/fotos/descargar (1).jpg', 'media/fotos/descargar (5).jpg', 'media/fotos/descargar.jpg', 'media/fotos/descargar (2).jpg', 'media/fotos/descargar (5).jpg', 'media/fotos/descargar (5).jpg', 'calle 2', 'media/certificados/antecedentes/RO42hZ9.png', 'media/certificados/seguridad/descargar (4).jpg', 'media/certificados/licencia/descargar (3).jpg', 'media/certificados/seguro/descargar (5).jpg', 3, 'SDFGHGFD');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `operarios`
--
ALTER TABLE `operarios`
  ADD PRIMARY KEY (`id_operario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `operarios`
--
ALTER TABLE `operarios`
  MODIFY `id_operario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `operarios`
--
ALTER TABLE `operarios`
  ADD CONSTRAINT `operarios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
