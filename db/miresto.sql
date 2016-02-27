-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-02-2016 a las 15:41:22
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cartas`
--

INSERT INTO `cartas` (`id`, `id_restriccion_dia`, `id_restriccion_hora`, `nombre`, `creador`) VALUES
(1, 1, 1, 'Carta Default', 1),
(2, 1, 2, 'Carta nueva', 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `dni`, `nombre`, `direccion`, `telefono`, `email`, `cuit`, `password`) VALUES
(2, 35795285, 'leo', 'Zapiola 1267 Dpto 10', 2914128136, 'leogilardi6@gmail.com', 20357952858, '8535e86c8118bbbb0a18ac72d15d3a2b37b18d1bce1611fc60165f322cf57386'),
(4, 4545, 'fede', 'fede', 4545, 'fede@fede.com', 45454, '5d942a1d73fd8f28d71e6b03d2e42f44721db94b734c2edcfe6fcd48b76a74f9');

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `info_carta`
--

INSERT INTO `info_carta` (`id`, `id_carta`, `id_seccion`, `id_producto`, `id_lista_precio`) VALUES
(1, 1, 1, 2, 1),
(2, 1, 2, 3, 1),
(5, 1, 2, 4, 2),
(6, 1, 2, 6, 1),
(7, 2, 2, 11, 2),
(9, 1, 1, 12, 1),
(10, 2, 1, 10, 1),
(11, 1, 1, 8, 1),
(12, 1, 1, 9, 1),
(13, 1, 1, 5, 1),
(14, 1, 1, 7, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `info_lista_precio`
--

INSERT INTO `info_lista_precio` (`id`, `id_producto`, `id_lista_precio`, `precio`) VALUES
(1, 2, 1, 15),
(2, 3, 1, 25),
(3, 4, 2, 2),
(4, 5, 1, 5),
(5, 6, 1, 8),
(6, 7, 1, 10),
(7, 8, 1, 5),
(8, 9, 1, 10),
(9, 10, 1, 5),
(10, 11, 2, 45),
(11, 12, 2, 45),
(12, 12, 1, 15);

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
  `fecha_s` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `info_pedidos`
--

INSERT INTO `info_pedidos` (`id`, `id_mesa`, `id_producto`, `id_lista_precio`, `id_pedidor`, `fecha_e`, `fecha_p`, `fecha_s`) VALUES
(3, 1, 3, 1, 'IN74LP', '2016-02-27 09:42:00', NULL, NULL),
(4, 1, 8, 1, 'UCMN3U', '2016-02-27 00:00:00', '2016-02-27 00:14:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_promociones`
--

CREATE TABLE IF NOT EXISTS `info_promociones` (
  `id` int(10) unsigned NOT NULL,
  `id_promocion` int(10) unsigned NOT NULL,
  `id_producto` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `info_promociones`
--

INSERT INTO `info_promociones` (`id`, `id_promocion`, `id_producto`) VALUES
(1, 3, 2),
(2, 3, 3),
(3, 3, 4),
(4, 4, 7),
(5, 4, 8),
(6, 5, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_roles`
--

CREATE TABLE IF NOT EXISTS `info_roles` (
  `id` int(11) NOT NULL,
  `id_empleado` int(10) unsigned NOT NULL,
  `rol` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `info_roles`
--

INSERT INTO `info_roles` (`id`, `id_empleado`, `rol`) VALUES
(4, 2, 4),
(5, 2, 5),
(6, 2, 6),
(7, 3, 1),
(8, 4, 1),
(9, 4, 3),
(10, 4, 2),
(11, 4, 4),
(12, 4, 5),
(13, 4, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_precio`
--

CREATE TABLE IF NOT EXISTS `lista_precio` (
  `id` int(10) unsigned NOT NULL,
  `nombre` tinytext NOT NULL,
  `fecha_modificacion` date NOT NULL,
  `creador` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `lista_precio`
--

INSERT INTO `lista_precio` (`id`, `nombre`, `fecha_modificacion`, `creador`) VALUES
(1, 'Economica', '2016-02-17', 2),
(2, 'Cara', '2016-02-11', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE IF NOT EXISTS `mesas` (
  `id` int(10) unsigned NOT NULL,
  `numero` smallint(5) unsigned NOT NULL,
  `abierta` tinyint(1) NOT NULL DEFAULT '0',
  `id_mozo` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `numero`, `abierta`, `id_mozo`) VALUES
(1, 1, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas_pedidores`
--

CREATE TABLE IF NOT EXISTS `mesas_pedidores` (
  `id_pedidor` text NOT NULL,
  `id_mesa` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mesas_pedidores`
--

INSERT INTO `mesas_pedidores` (`id_pedidor`, `id_mesa`) VALUES
('46EUVU', 1);

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
-- Estructura de tabla para la tabla `pedidores`
--

CREATE TABLE IF NOT EXISTS `pedidores` (
  `id` text NOT NULL,
  `nombre` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pedidores`
--

INSERT INTO `pedidores` (`id`, `nombre`) VALUES
('46EUVU', 'fede');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_procesados`
--

CREATE TABLE IF NOT EXISTS `pedidos_procesados` (
  `id` int(11) NOT NULL,
  `id_info_pedido` int(10) unsigned NOT NULL,
  `id_empleado` int(10) unsigned NOT NULL,
  `hora_salida` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(10) unsigned NOT NULL,
  `nombre` tinytext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`) VALUES
(2, 'Cafe'),
(3, 'Helado'),
(4, 'Vaso Coca cola 500 cm3'),
(5, 'Baggio'),
(6, 'Fanta'),
(7, 'Torta'),
(8, 'Coñac'),
(9, 'Pastel de papa'),
(10, 'Noquis'),
(11, 'Sprite'),
(12, 'Pepsi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE IF NOT EXISTS `promociones` (
  `id` int(10) unsigned NOT NULL,
  `id_carta` int(10) unsigned NOT NULL,
  `nombre` tinytext NOT NULL,
  `precio` float unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `promociones`
--

INSERT INTO `promociones` (`id`, `id_carta`, `nombre`, `precio`) VALUES
(3, 1, 'Promocion 1', 256.3),
(4, 1, 'Promocion 2', 25),
(5, 2, 'Promocion 3', 56);

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
  `1` tinyint(1) NOT NULL DEFAULT '0',
  `2` tinyint(1) NOT NULL DEFAULT '0',
  `3` tinyint(1) NOT NULL DEFAULT '0',
  `4` tinyint(1) NOT NULL DEFAULT '0',
  `5` tinyint(1) NOT NULL DEFAULT '0',
  `6` tinyint(1) NOT NULL DEFAULT '0',
  `0` tinyint(1) NOT NULL DEFAULT '0',
  `creador` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `restricciones_dia`
--

INSERT INTO `restricciones_dia` (`id`, `1`, `2`, `3`, `4`, `5`, `6`, `0`, `creador`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restricciones_hora`
--

CREATE TABLE IF NOT EXISTS `restricciones_hora` (
  `id` int(10) unsigned NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `restricciones_hora`
--

INSERT INTO `restricciones_hora` (`id`, `0`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `creador`) VALUES
(1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2),
(2, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `secciones`
--

INSERT INTO `secciones` (`id`, `nombre`) VALUES
(1, 'Cafes'),
(2, 'Postres');

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
-- Indices de la tabla `pedidores`
--
ALTER TABLE `pedidores`
  ADD PRIMARY KEY (`id`(6));

--
-- Indices de la tabla `pedidos_procesados`
--
ALTER TABLE `pedidos_procesados`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `cuadriculas_base`
--
ALTER TABLE `cuadriculas_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
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
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
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
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `info_pedidos`
--
ALTER TABLE `info_pedidos`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `info_promociones`
--
ALTER TABLE `info_promociones`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `info_roles`
--
ALTER TABLE `info_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `lista_precio`
--
ALTER TABLE `lista_precio`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `mesa_cuadricula`
--
ALTER TABLE `mesa_cuadricula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pedidos_procesados`
--
ALTER TABLE `pedidos_procesados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `restricciones_dia`
--
ALTER TABLE `restricciones_dia`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `restricciones_hora`
--
ALTER TABLE `restricciones_hora`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `secciones`
--
ALTER TABLE `secciones`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
