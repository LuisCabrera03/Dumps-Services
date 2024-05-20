-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-05-2024 a las 19:59:04
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
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `id_solicitud` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha_envio` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `id_solicitud`, `id_usuario`, `mensaje`, `fecha_envio`) VALUES
(1, 6, 3, 'x', '2024-05-19 17:49:48'),
(2, 6, 2, 'hola amigo ', '2024-05-19 17:50:04'),
(3, 6, 3, 'gr\r\n', '2024-05-19 17:56:46'),
(4, 6, 3, 'paulllll', '2024-05-19 17:57:23'),
(5, 9, 3, 'kmkmk\r\n', '2024-05-19 18:26:58');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` int(11) NOT NULL,
  `id_operario` int(11) NOT NULL,
  `id_solicitante` int(11) NOT NULL,
  `direccion_acarreo` varchar(255) NOT NULL,
  `detalles_acarreo` text DEFAULT NULL,
  `fecha_solicitud` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(50) NOT NULL DEFAULT 'Espera'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id`, `id_operario`, `id_solicitante`, `direccion_acarreo`, `detalles_acarreo`, `fecha_solicitud`, `estado`) VALUES
(5, 1, 2, 'calle 2', 'ddfdfdfd', '2024-05-19 14:41:19', 'Cancelado'),
(6, 1, 2, 'calle 2', 'poara ffsds', '2024-05-19 14:43:55', 'Entregado'),
(7, 1, 2, 'calle 2', 'ddfdfdfd', '2024-05-19 14:50:04', 'Entregado'),
(8, 1, 2, 'calle 2', 'asasas', '2024-05-19 14:50:16', 'Rechazado'),
(9, 1, 5, 'sasass', 'asasasa', '2024-05-19 18:25:56', 'Entregado');

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
  `contrasena` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `fecha_nacimiento`, `tipo_documento`, `numero_documento`, `correo`, `rol`, `contrasena`, `telefono`) VALUES
(2, 'Luis Alfredo c', 'Cabrera', '2024-04-29', 'cc', '10258748', 'cabrerasarrialu3is@gmail.com', 'solicitante_transporte', '123456789', '3166004016'),
(3, 'luis', 'Cabrera', '2024-04-29', 'cc', '10258748', 'cabrerasarrialuis@gmail.com', 'operador_logistico', '123456789', '3116554742'),
(4, 'admin', 'admin', '1990-01-01', 'cc', '123456789', 'admin@example.com', 'administrador', '123456789', '3259551435');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `operarios`
--
ALTER TABLE `operarios`
  ADD PRIMARY KEY (`id_operario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_operario` (`id_operario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `operarios`
--
ALTER TABLE `operarios`
  MODIFY `id_operario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `operarios`
--
ALTER TABLE `operarios`
  ADD CONSTRAINT `operarios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`id_operario`) REFERENCES `operarios` (`id_operario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
