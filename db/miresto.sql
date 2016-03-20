-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-03-2016 a las 23:49:00
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `miresto`
--
CREATE DATABASE IF NOT EXISTS `miresto` DEFAULT CHARACTER SET latin1 COLLATE latin1_spanish_ci;
USE `miresto`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

DROP TABLE IF EXISTS `calificaciones`;
CREATE TABLE `calificaciones` (
  `id` int(11) NOT NULL,
  `id_mozo` int(10) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `calificacion` tinyint(3) UNSIGNED NOT NULL,
  `observaciones` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cartas`
--

DROP TABLE IF EXISTS `cartas`;
CREATE TABLE `cartas` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_restriccion_dia` int(10) UNSIGNED NOT NULL,
  `id_restriccion_hora` int(10) UNSIGNED NOT NULL,
  `nombre` tinytext NOT NULL,
  `creador` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cartas`
--

INSERT INTO `cartas` (`id`, `id_restriccion_dia`, `id_restriccion_hora`, `nombre`, `creador`) VALUES
(3, 2, 3, 'Carta uno - solo tarde', 5),
(4, 2, 4, 'Carta dos - Solo mañana', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cartas_promociones`
--

DROP TABLE IF EXISTS `cartas_promociones`;
CREATE TABLE `cartas_promociones` (
  `id_carta` int(10) UNSIGNED NOT NULL,
  `id_promocion` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cartas_promociones`
--

INSERT INTO `cartas_promociones` (`id_carta`, `id_promocion`) VALUES
(3, 6),
(3, 7),
(4, 8),
(4, 9),
(9, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuadriculas_base`
--

DROP TABLE IF EXISTS `cuadriculas_base`;
CREATE TABLE `cuadriculas_base` (
  `id` int(11) NOT NULL,
  `nombre` tinytext NOT NULL,
  `ancho` tinyint(3) UNSIGNED NOT NULL,
  `largo` tinyint(3) UNSIGNED NOT NULL,
  `pisos` tinyint(3) UNSIGNED NOT NULL,
  `creador` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

DROP TABLE IF EXISTS `empleados`;
CREATE TABLE `empleados` (
  `id` int(10) UNSIGNED NOT NULL,
  `dni` int(10) UNSIGNED NOT NULL,
  `nombre` tinytext NOT NULL,
  `direccion` tinytext NOT NULL,
  `telefono` int(10) UNSIGNED NOT NULL,
  `email` tinytext NOT NULL,
  `cuit` bigint(20) UNSIGNED NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `dni`, `nombre`, `direccion`, `telefono`, `email`, `cuit`, `password`) VALUES
(5, 36704824, 'Federico Joaquin', 'Undiano 69 - 1 - 13', 2392487559, 'fedejoaquin.mail@gmail.com', 20367048248, '5d942a1d73fd8f28d71e6b03d2e42f44721db94b734c2edcfe6fcd48b76a74f9'),
(6, 45454, 'leo', 'dire', 122, 'leo@leo.com', 205422, '8535e86c8118bbbb0a18ac72d15d3a2b37b18d1bce1611fc60165f322cf57386'),
(7, 45454, 'user', 'dire', 12121, 'user@user.com', 45454, '04f8996da763b7a969b1028ee3007569eaf3a635486ddab211d512c85b9df8fb');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturaciones`
--

DROP TABLE IF EXISTS `facturaciones`;
CREATE TABLE `facturaciones` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `total_facturado` float UNSIGNED NOT NULL,
  `id_mesa` int(10) UNSIGNED NOT NULL,
  `id_cajero` int(10) UNSIGNED NOT NULL,
  `id_mozo` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fecha_cuadricula`
--

DROP TABLE IF EXISTS `fecha_cuadricula`;
CREATE TABLE `fecha_cuadricula` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_carta`
--

DROP TABLE IF EXISTS `info_carta`;
CREATE TABLE `info_carta` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_carta` int(10) UNSIGNED NOT NULL,
  `id_seccion` int(10) UNSIGNED NOT NULL,
  `id_producto` int(10) UNSIGNED NOT NULL,
  `id_lista_precio` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `info_carta`
--

INSERT INTO `info_carta` (`id`, `id_carta`, `id_seccion`, `id_producto`, `id_lista_precio`) VALUES
(16, 3, 3, 14, 3),
(17, 3, 4, 15, 4),
(25, 4, 5, 17, 4),
(50, 3, 3, 13, 3),
(59, 4, 5, 18, 4),
(60, 3, 4, 16, 4),
(61, 4, 3, 13, 3),
(62, 4, 3, 14, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_cuadriculas_base`
--

DROP TABLE IF EXISTS `info_cuadriculas_base`;
CREATE TABLE `info_cuadriculas_base` (
  `id` int(11) NOT NULL,
  `pos_x` tinyint(3) UNSIGNED NOT NULL,
  `pos_y` tinyint(3) UNSIGNED NOT NULL,
  `piso` tinyint(3) UNSIGNED NOT NULL,
  `contenido` tinyint(3) UNSIGNED NOT NULL,
  `id_cuadricula_base` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_cuadriculas_fecha`
--

DROP TABLE IF EXISTS `info_cuadriculas_fecha`;
CREATE TABLE `info_cuadriculas_fecha` (
  `id` int(11) NOT NULL,
  `pos_x` tinyint(3) UNSIGNED NOT NULL,
  `pos_y` tinyint(3) UNSIGNED NOT NULL,
  `contenido` tinyint(3) UNSIGNED NOT NULL,
  `id_fecha` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_lista_precio`
--

DROP TABLE IF EXISTS `info_lista_precio`;
CREATE TABLE `info_lista_precio` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_producto` int(10) UNSIGNED NOT NULL,
  `id_lista_precio` int(10) UNSIGNED NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `info_lista_precio`
--

INSERT INTO `info_lista_precio` (`id`, `id_producto`, `id_lista_precio`, `precio`) VALUES
(13, 13, 3, 1000),
(14, 14, 3, 1000),
(15, 15, 3, 1000),
(16, 16, 3, 1000),
(17, 17, 3, 1000),
(18, 18, 3, 1000),
(19, 13, 4, 10),
(20, 14, 4, 10),
(21, 15, 4, 10),
(22, 16, 4, 10),
(23, 17, 4, 10),
(24, 18, 4, 10),
(25, 28, 3, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_pedidos`
--

DROP TABLE IF EXISTS `info_pedidos`;
CREATE TABLE `info_pedidos` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_mesa` int(10) UNSIGNED NOT NULL,
  `id_producto` int(10) UNSIGNED NOT NULL,
  `id_lista_precio` int(10) UNSIGNED NOT NULL,
  `id_pedidor` tinytext NOT NULL,
  `fecha_e` datetime NOT NULL,
  `fecha_p` datetime DEFAULT NULL,
  `fecha_s` datetime DEFAULT NULL,
  `comentarios` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_pedidos_promociones`
--

DROP TABLE IF EXISTS `info_pedidos_promociones`;
CREATE TABLE `info_pedidos_promociones` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_mesa` int(10) UNSIGNED NOT NULL,
  `id_promocion` int(10) UNSIGNED NOT NULL,
  `id_pedidor` tinytext NOT NULL,
  `fecha_e` datetime NOT NULL,
  `fecha_p` datetime DEFAULT NULL,
  `fecha_s` datetime DEFAULT NULL,
  `comentarios` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_promociones`
--

DROP TABLE IF EXISTS `info_promociones`;
CREATE TABLE `info_promociones` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_promocion` int(10) UNSIGNED NOT NULL,
  `id_producto` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `info_promociones`
--

INSERT INTO `info_promociones` (`id`, `id_promocion`, `id_producto`) VALUES
(7, 6, 13),
(8, 6, 14),
(9, 7, 15),
(10, 7, 16),
(11, 8, 13),
(12, 8, 17),
(13, 9, 13),
(14, 9, 18),
(19, 6, 18),
(20, 6, 15),
(21, 6, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_roles`
--

DROP TABLE IF EXISTS `info_roles`;
CREATE TABLE `info_roles` (
  `id` int(11) NOT NULL,
  `id_empleado` int(10) UNSIGNED NOT NULL,
  `rol` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `info_roles`
--

INSERT INTO `info_roles` (`id`, `id_empleado`, `rol`) VALUES
(18, 7, 1),
(19, 7, 2),
(20, 7, 3),
(21, 7, 4),
(22, 7, 5),
(23, 7, 6),
(37, 5, 1),
(38, 5, 3),
(39, 5, 6),
(46, 6, 1),
(47, 6, 4),
(48, 6, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_precio`
--

DROP TABLE IF EXISTS `lista_precio`;
CREATE TABLE `lista_precio` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` tinytext NOT NULL,
  `fecha_modificacion` date NOT NULL,
  `creador` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `lista_precio`
--

INSERT INTO `lista_precio` (`id`, `nombre`, `fecha_modificacion`, `creador`) VALUES
(3, 'CARA', '2016-03-01', 5),
(4, 'BARATA', '2016-03-01', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

DROP TABLE IF EXISTS `mesas`;
CREATE TABLE `mesas` (
  `id` int(10) UNSIGNED NOT NULL,
  `numero` smallint(5) UNSIGNED NOT NULL,
  `estado` tinytext NOT NULL,
  `id_mozo` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `numero`, `estado`, `id_mozo`) VALUES
(2, 1, 'Abierta', 6),
(3, 2, 'Cerrada', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas_pedidores`
--

DROP TABLE IF EXISTS `mesas_pedidores`;
CREATE TABLE `mesas_pedidores` (
  `id_pedidor` text NOT NULL,
  `id_mesa` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa_cuadricula`
--

DROP TABLE IF EXISTS `mesa_cuadricula`;
CREATE TABLE `mesa_cuadricula` (
  `id` int(11) NOT NULL,
  `pos_x` tinyint(3) UNSIGNED NOT NULL,
  `pos_y` tinyint(3) UNSIGNED NOT NULL,
  `id_cuadricula` tinyint(3) UNSIGNED NOT NULL,
  `piso` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
CREATE TABLE `notificaciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_mesa` int(10) UNSIGNED NOT NULL,
  `mensaje` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidores`
--

DROP TABLE IF EXISTS `pedidores`;
CREATE TABLE `pedidores` (
  `id` text NOT NULL,
  `nombre` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`) VALUES
(13, 'Chorizo Asado'),
(14, 'Asado de tira'),
(15, 'Picada especial'),
(16, 'Picada Chica'),
(17, 'Vaso coca cola'),
(18, 'Copa de vino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

DROP TABLE IF EXISTS `promociones`;
CREATE TABLE `promociones` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` tinytext NOT NULL,
  `precio` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `promociones`
--

INSERT INTO `promociones` (`id`, `nombre`, `precio`) VALUES
(6, 'Promo 1 : tarde', 200),
(7, 'Promo 2: Tarde', 210),
(8, 'Promo 3: mañana', 198),
(9, 'Promo 4: mañana', 205);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

DROP TABLE IF EXISTS `reservas`;
CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `a_nombre_de` tinytext NOT NULL,
  `hora` time NOT NULL,
  `mesa_cuadricula` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restricciones_dia`
--

DROP TABLE IF EXISTS `restricciones_dia`;
CREATE TABLE `restricciones_dia` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` tinytext NOT NULL,
  `1` tinyint(1) NOT NULL DEFAULT '0',
  `2` tinyint(1) NOT NULL DEFAULT '0',
  `3` tinyint(1) NOT NULL DEFAULT '0',
  `4` tinyint(1) NOT NULL DEFAULT '0',
  `5` tinyint(1) NOT NULL DEFAULT '0',
  `6` tinyint(1) NOT NULL DEFAULT '0',
  `0` tinyint(1) NOT NULL DEFAULT '0',
  `creador` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `restricciones_dia`
--

INSERT INTO `restricciones_dia` (`id`, `nombre`, `1`, `2`, `3`, `4`, `5`, `6`, `0`, `creador`) VALUES
(2, 'Todos los dias', 1, 1, 1, 1, 1, 1, 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restricciones_hora`
--

DROP TABLE IF EXISTS `restricciones_hora`;
CREATE TABLE `restricciones_hora` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` tinytext NOT NULL,
  `0` tinyint(1) NOT NULL DEFAULT '0',
  `1` tinyint(1) NOT NULL DEFAULT '0',
  `2` tinyint(1) NOT NULL DEFAULT '0',
  `3` tinyint(1) NOT NULL DEFAULT '0',
  `4` tinyint(1) NOT NULL DEFAULT '0',
  `5` tinyint(1) NOT NULL DEFAULT '0',
  `6` tinyint(1) NOT NULL DEFAULT '0',
  `7` tinyint(1) NOT NULL DEFAULT '0',
  `8` tinyint(1) NOT NULL DEFAULT '0',
  `9` tinyint(1) NOT NULL DEFAULT '0',
  `10` tinyint(1) NOT NULL DEFAULT '0',
  `11` tinyint(1) NOT NULL DEFAULT '0',
  `12` tinyint(1) NOT NULL DEFAULT '0',
  `13` tinyint(1) NOT NULL DEFAULT '0',
  `14` tinyint(1) NOT NULL DEFAULT '0',
  `15` tinyint(1) NOT NULL DEFAULT '0',
  `16` tinyint(1) NOT NULL DEFAULT '0',
  `17` tinyint(1) NOT NULL DEFAULT '0',
  `18` tinyint(1) NOT NULL DEFAULT '0',
  `19` tinyint(1) NOT NULL DEFAULT '0',
  `20` tinyint(1) NOT NULL DEFAULT '0',
  `21` tinyint(1) NOT NULL DEFAULT '0',
  `22` tinyint(1) NOT NULL DEFAULT '0',
  `23` tinyint(1) NOT NULL DEFAULT '0',
  `creador` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `restricciones_hora`
--

INSERT INTO `restricciones_hora` (`id`, `nombre`, `0`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `creador`) VALUES
(3, 'Solo tarde', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 5),
(4, 'Solo mañana', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `descripcion` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `descripcion`) VALUES
(1, 'Admin'),
(2, 'Cajero'),
(3, 'Gerente'),
(4, 'Mozo'),
(5, 'Cocinero'),
(6, 'Recepcionista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secciones`
--

DROP TABLE IF EXISTS `secciones`;
CREATE TABLE `secciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `secciones`
--

INSERT INTO `secciones` (`id`, `nombre`) VALUES
(3, 'Carnes'),
(4, 'Fiambres'),
(5, 'Bebidas');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cartas`
--
ALTER TABLE `cartas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuadriculas_base`
--
ALTER TABLE `cuadriculas_base`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facturaciones`
--
ALTER TABLE `facturaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fecha_cuadricula`
--
ALTER TABLE `fecha_cuadricula`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_carta`
--
ALTER TABLE `info_carta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_cuadriculas_base`
--
ALTER TABLE `info_cuadriculas_base`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_cuadriculas_fecha`
--
ALTER TABLE `info_cuadriculas_fecha`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_lista_precio`
--
ALTER TABLE `info_lista_precio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_pedidos`
--
ALTER TABLE `info_pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_pedidos_promociones`
--
ALTER TABLE `info_pedidos_promociones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_promociones`
--
ALTER TABLE `info_promociones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_roles`
--
ALTER TABLE `info_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_empleado_2` (`id_empleado`);

--
-- Indices de la tabla `lista_precio`
--
ALTER TABLE `lista_precio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesa_cuadricula`
--
ALTER TABLE `mesa_cuadricula`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidores`
--
ALTER TABLE `pedidores`
  ADD PRIMARY KEY (`id`(6));

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `restricciones_dia`
--
ALTER TABLE `restricciones_dia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `restricciones_hora`
--
ALTER TABLE `restricciones_hora`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `secciones`
--
ALTER TABLE `secciones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cartas`
--
ALTER TABLE `cartas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `cuadriculas_base`
--
ALTER TABLE `cuadriculas_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `facturaciones`
--
ALTER TABLE `facturaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `fecha_cuadricula`
--
ALTER TABLE `fecha_cuadricula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `info_carta`
--
ALTER TABLE `info_carta`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT de la tabla `info_cuadriculas_base`
--
ALTER TABLE `info_cuadriculas_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `info_cuadriculas_fecha`
--
ALTER TABLE `info_cuadriculas_fecha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `info_lista_precio`
--
ALTER TABLE `info_lista_precio`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT de la tabla `info_pedidos`
--
ALTER TABLE `info_pedidos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT de la tabla `info_pedidos_promociones`
--
ALTER TABLE `info_pedidos_promociones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT de la tabla `info_promociones`
--
ALTER TABLE `info_promociones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `info_roles`
--
ALTER TABLE `info_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT de la tabla `lista_precio`
--
ALTER TABLE `lista_precio`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `mesa_cuadricula`
--
ALTER TABLE `mesa_cuadricula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `restricciones_dia`
--
ALTER TABLE `restricciones_dia`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `restricciones_hora`
--
ALTER TABLE `restricciones_hora`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `secciones`
--
ALTER TABLE `secciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
