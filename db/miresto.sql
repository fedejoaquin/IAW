-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-03-2016 a las 16:04:37
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `miresto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE IF NOT EXISTS `calificaciones` (
  `id` int(11) NOT NULL,
  `id_mozo` int(10) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `calificacion` tinyint(3) unsigned NOT NULL,
  `observaciones` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cartas`
--

CREATE TABLE IF NOT EXISTS `cartas` (
  `id` int(10) unsigned NOT NULL,
  `id_restriccion_dia` int(10) unsigned NOT NULL,
  `id_restriccion_hora` int(10) unsigned NOT NULL,
  `nombre` tinytext NOT NULL,
  `creador` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cartas`
--

INSERT INTO `cartas` (`id`, `id_restriccion_dia`, `id_restriccion_hora`, `nombre`, `creador`) VALUES
(3, 2, 3, 'Carta uno - solo tarde', 5),
(4, 2, 4, 'Carta dos - solo mañana', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuadriculas_base`
--

CREATE TABLE IF NOT EXISTS `cuadriculas_base` (
  `id` int(11) NOT NULL,
  `nombre` tinytext NOT NULL,
  `ancho` tinyint(3) unsigned NOT NULL,
  `largo` tinyint(3) unsigned NOT NULL,
  `pisos` tinyint(3) unsigned NOT NULL,
  `creador` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE IF NOT EXISTS `empleados` (
  `id` int(10) unsigned NOT NULL,
  `dni` int(10) unsigned NOT NULL,
  `nombre` tinytext NOT NULL,
  `direccion` tinytext NOT NULL,
  `telefono` int(10) unsigned NOT NULL,
  `email` tinytext NOT NULL,
  `cuit` bigint(20) unsigned NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `dni`, `nombre`, `direccion`, `telefono`, `email`, `cuit`, `password`) VALUES
(5, 36704824, 'fede', 'direccion', 2, 'fede@fede.com', 20367048248, '5d942a1d73fd8f28d71e6b03d2e42f44721db94b734c2edcfe6fcd48b76a74f9'),
(6, 45454, 'leo', 'dire', 122, 'leo@leo.com', 205422, '8535e86c8118bbbb0a18ac72d15d3a2b37b18d1bce1611fc60165f322cf57386'),
(7, 45454, 'user', 'dire', 12121, 'user@user.com', 45454, '04f8996da763b7a969b1028ee3007569eaf3a635486ddab211d512c85b9df8fb');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturaciones`
--

CREATE TABLE IF NOT EXISTS `facturaciones` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `total_facturado` float unsigned NOT NULL,
  `id_mesa` int(10) unsigned NOT NULL,
  `id_cajero` int(10) unsigned NOT NULL,
  `id_mozo` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fecha_cuadricula`
--

CREATE TABLE IF NOT EXISTS `fecha_cuadricula` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_carta`
--

CREATE TABLE IF NOT EXISTS `info_carta` (
  `id` int(10) unsigned NOT NULL,
  `id_carta` int(10) unsigned NOT NULL,
  `id_seccion` int(10) unsigned NOT NULL,
  `id_producto` int(10) unsigned NOT NULL,
  `id_lista_precio` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `info_carta`
--

INSERT INTO `info_carta` (`id`, `id_carta`, `id_seccion`, `id_producto`, `id_lista_precio`) VALUES
(15, 3, 3, 13, 3),
(16, 3, 3, 14, 3),
(17, 3, 4, 15, 4),
(18, 3, 4, 16, 4),
(19, 4, 4, 15, 3),
(20, 4, 4, 16, 3),
(21, 4, 5, 17, 4),
(22, 4, 5, 18, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_cuadriculas_base`
--

CREATE TABLE IF NOT EXISTS `info_cuadriculas_base` (
  `id` int(11) NOT NULL,
  `pos_x` tinyint(3) unsigned NOT NULL,
  `pos_y` tinyint(3) unsigned NOT NULL,
  `piso` tinyint(3) unsigned NOT NULL,
  `contenido` tinyint(3) unsigned NOT NULL,
  `id_cuadricula_base` tinyint(3) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_cuadriculas_fecha`
--

CREATE TABLE IF NOT EXISTS `info_cuadriculas_fecha` (
  `id` int(11) NOT NULL,
  `pos_x` tinyint(3) unsigned NOT NULL,
  `pos_y` tinyint(3) unsigned NOT NULL,
  `contenido` tinyint(3) unsigned NOT NULL,
  `id_fecha` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_lista_precio`
--

CREATE TABLE IF NOT EXISTS `info_lista_precio` (
  `id` int(10) unsigned NOT NULL,
  `id_producto` int(10) unsigned NOT NULL,
  `id_lista_precio` int(10) unsigned NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

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
(24, 18, 4, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_pedidos`
--

CREATE TABLE IF NOT EXISTS `info_pedidos` (
  `id` int(10) unsigned NOT NULL,
  `id_mesa` int(10) unsigned NOT NULL,
  `id_producto` int(10) unsigned NOT NULL,
  `id_lista_precio` int(10) unsigned NOT NULL,
  `id_pedidor` tinytext NOT NULL,
  `fecha_e` datetime NOT NULL,
  `fecha_p` datetime DEFAULT NULL,
  `fecha_s` datetime DEFAULT NULL,
  `comentarios` tinytext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=203 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_pedidos_promociones`
--

CREATE TABLE IF NOT EXISTS `info_pedidos_promociones` (
  `id` int(10) unsigned NOT NULL,
  `id_mesa` int(10) unsigned NOT NULL,
  `id_promocion` int(10) unsigned NOT NULL,
  `id_pedidor` tinytext NOT NULL,
  `fecha_e` datetime NOT NULL,
  `fecha_p` datetime NOT NULL,
  `fecha_s` datetime NOT NULL,
  `comentarios` tinytext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_promociones`
--

CREATE TABLE IF NOT EXISTS `info_promociones` (
  `id` int(10) unsigned NOT NULL,
  `id_promocion` int(10) unsigned NOT NULL,
  `id_producto` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

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
(14, 9, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_roles`
--

CREATE TABLE IF NOT EXISTS `info_roles` (
  `id` int(11) NOT NULL,
  `id_empleado` int(10) unsigned NOT NULL,
  `rol` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `info_roles`
--

INSERT INTO `info_roles` (`id`, `id_empleado`, `rol`) VALUES
(14, 5, 3),
(15, 6, 1),
(16, 6, 4),
(17, 6, 5),
(18, 7, 1),
(19, 7, 2),
(20, 7, 3),
(21, 7, 4),
(22, 7, 5),
(23, 7, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_precio`
--

CREATE TABLE IF NOT EXISTS `lista_precio` (
  `id` int(10) unsigned NOT NULL,
  `nombre` tinytext NOT NULL,
  `fecha_modificacion` date NOT NULL,
  `creador` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

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

CREATE TABLE IF NOT EXISTS `mesas` (
  `id` int(10) unsigned NOT NULL,
  `numero` smallint(5) unsigned NOT NULL,
  `abierta` tinyint(1) NOT NULL DEFAULT '0',
  `id_mozo` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `numero`, `abierta`, `id_mozo`) VALUES
(2, 1, 1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas_pedidores`
--

CREATE TABLE IF NOT EXISTS `mesas_pedidores` (
  `id_pedidor` text NOT NULL,
  `id_mesa` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa_cuadricula`
--

CREATE TABLE IF NOT EXISTS `mesa_cuadricula` (
  `id` int(11) NOT NULL,
  `pos_x` tinyint(3) unsigned NOT NULL,
  `pos_y` tinyint(3) unsigned NOT NULL,
  `id_cuadricula` tinyint(3) unsigned NOT NULL,
  `piso` tinyint(3) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE IF NOT EXISTS `notificaciones` (
  `id` int(10) unsigned NOT NULL,
  `id_mesa` int(10) unsigned NOT NULL,
  `producto` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidores`
--

CREATE TABLE IF NOT EXISTS `pedidores` (
  `id` text NOT NULL,
  `nombre` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(10) unsigned NOT NULL,
  `nombre` tinytext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`) VALUES
(13, 'Asado de tira'),
(14, 'Chorizo Asado'),
(15, 'Picada especial'),
(16, 'Picada Chica'),
(17, 'Vaso coca cola'),
(18, 'Copa de vino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE IF NOT EXISTS `promociones` (
  `id` int(10) unsigned NOT NULL,
  `id_carta` int(10) unsigned NOT NULL,
  `nombre` tinytext NOT NULL,
  `precio` float unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `promociones`
--

INSERT INTO `promociones` (`id`, `id_carta`, `nombre`, `precio`) VALUES
(6, 3, 'Promo 1 - tarde', 200),
(7, 3, 'Promo 2 - tarde', 210),
(8, 4, 'Promo 3 - mañana', 198),
(9, 4, 'Promo 4 - Mañana', 205);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE IF NOT EXISTS `reservas` (
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

CREATE TABLE IF NOT EXISTS `restricciones_dia` (
  `id` int(10) unsigned NOT NULL,
  `nombre` tinytext NOT NULL,
  `1` tinyint(1) NOT NULL DEFAULT '0',
  `2` tinyint(1) NOT NULL DEFAULT '0',
  `3` tinyint(1) NOT NULL DEFAULT '0',
  `4` tinyint(1) NOT NULL DEFAULT '0',
  `5` tinyint(1) NOT NULL DEFAULT '0',
  `6` tinyint(1) NOT NULL DEFAULT '0',
  `0` tinyint(1) NOT NULL DEFAULT '0',
  `creador` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `restricciones_dia`
--

INSERT INTO `restricciones_dia` (`id`, `nombre`, `1`, `2`, `3`, `4`, `5`, `6`, `0`, `creador`) VALUES
(2, 'Todos los dias', 1, 1, 1, 1, 1, 1, 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restricciones_hora`
--

CREATE TABLE IF NOT EXISTS `restricciones_hora` (
  `id` int(10) unsigned NOT NULL,
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
  `creador` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

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

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL,
  `descripcion` tinytext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

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

CREATE TABLE IF NOT EXISTS `secciones` (
  `id` int(10) unsigned NOT NULL,
  `nombre` tinytext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

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
  ADD PRIMARY KEY (`id`), ADD KEY `id_empleado` (`id_empleado`), ADD KEY `id_empleado_2` (`id_empleado`);

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
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `cuadriculas_base`
--
ALTER TABLE `cuadriculas_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
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
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
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
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT de la tabla `info_pedidos`
--
ALTER TABLE `info_pedidos`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=203;
--
-- AUTO_INCREMENT de la tabla `info_pedidos_promociones`
--
ALTER TABLE `info_pedidos_promociones`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `info_promociones`
--
ALTER TABLE `info_promociones`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `info_roles`
--
ALTER TABLE `info_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `lista_precio`
--
ALTER TABLE `lista_precio`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `mesa_cuadricula`
--
ALTER TABLE `mesa_cuadricula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `restricciones_dia`
--
ALTER TABLE `restricciones_dia`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `restricciones_hora`
--
ALTER TABLE `restricciones_hora`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `secciones`
--
ALTER TABLE `secciones`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
