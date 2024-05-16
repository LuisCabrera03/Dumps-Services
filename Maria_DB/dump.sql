-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-05-2024 a las 17:45:34
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
CREATE DATABASE IF NOT EXISTS `dump` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dump`;

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
  `otros_detalles` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `tipo_documento` enum('cc','ce') NOT NULL,
  `numero_documento` varchar(20) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `rol` enum('administrador','operador_logistico','solicitante_transporte') NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `fecha_nacimiento`, `tipo_documento`, `numero_documento`, `correo`, `rol`, `contrasena`) VALUES
(2, 'luis', 'Cabrera', '2024-04-29', 'cc', '10258748', 'cabrerasarrialu3is@gmail.com', 'solicitante_transporte', '123456789'),
(3, 'luis', 'Cabrera', '2024-04-29', 'cc', '10258748', 'cabrerasarrialuis@gmail.com', 'operador_logistico', '123456789'),
(4, 'admin', 'admin', '1990-01-01', 'cc', '123456789', 'admin@example.com', 'administrador', '123456789');

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
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `operarios`
--
ALTER TABLE `operarios`
  MODIFY `id_operario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
