-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-01-2026 a las 23:56:00
-- Versión del servidor: 12.1.2-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tiendaproductos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_roles`
--

CREATE TABLE `acl_roles` (
  `cod_acl_roles` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_usuarios`
--

CREATE TABLE `acl_usuarios` (
  `cod_acl_usuario` int(11) NOT NULL,
  `cod_acl_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `cod_categoria` int(5) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `cod_compra` int(11) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `importe_base` float NOT NULL,
  `importe_iva` float NOT NULL,
  `importe_total` float NOT NULL,
  `importe_pago` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_lineas`
--

CREATE TABLE `compra_lineas` (
  `cod_compra_linea` int(11) NOT NULL,
  `cod_compra` int(11) NOT NULL,
  `cod_producto` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `unidades` int(11) NOT NULL,
  `precio_unidad` float NOT NULL,
  `iva` int(11) NOT NULL,
  `importe_base` float NOT NULL,
  `importe_iva` float NOT NULL,
  `importe_total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cons_compras`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cons_compras` (
`cod_compra` int(11)
,`cod_usuario` int(11)
,`fecha` date
,`importe_base` float
,`importe_iva` float
,`importe_total` float
,`importe_pago` float
,`usuario_nick` varchar(10)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cons_compra_lineas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cons_compra_lineas` (
`cod_compra_linea` int(11)
,`cod_compra` int(11)
,`cod_producto` int(11)
,`orden` int(11)
,`unidades` int(11)
,`precio_unidad` float
,`iva` int(11)
,`importe_base` float
,`importe_iva` float
,`importe_total` float
,`producto_nombre` varchar(15)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cons_productos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cons_productos` (
`cod_producto` int(5)
,`cod_categoria` int(5)
,`nombre` varchar(15)
,`fabricante` varchar(15)
,`fecha_alta` date
,`unidades` int(11)
,`precio_base` float
,`iva` int(11)
,`precio_iva` float
,`precio_venta` int(11)
,`foto` varchar(50)
,`borrado` int(11)
,`categoria_nombre` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `cod_producto` int(5) NOT NULL,
  `cod_categoria` int(5) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `fabricante` varchar(15) NOT NULL,
  `fecha_alta` date NOT NULL,
  `unidades` int(11) NOT NULL,
  `precio_base` float NOT NULL,
  `iva` int(11) NOT NULL,
  `precio_iva` float NOT NULL,
  `precio_venta` int(11) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `borrado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cod_usuario` int(11) NOT NULL,
  `nick` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura para la vista `cons_compras`
--
DROP TABLE IF EXISTS `cons_compras`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cons_compras`  AS SELECT `co`.`cod_compra` AS `cod_compra`, `co`.`cod_usuario` AS `cod_usuario`, `co`.`fecha` AS `fecha`, `co`.`importe_base` AS `importe_base`, `co`.`importe_iva` AS `importe_iva`, `co`.`importe_total` AS `importe_total`, `co`.`importe_pago` AS `importe_pago`, `u`.`nick` AS `usuario_nick` FROM (`compras` `co` left join `usuarios` `u` on(`co`.`cod_usuario` = `u`.`cod_usuario`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `cons_compra_lineas`
--
DROP TABLE IF EXISTS `cons_compra_lineas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cons_compra_lineas`  AS SELECT `l`.`cod_compra_linea` AS `cod_compra_linea`, `l`.`cod_compra` AS `cod_compra`, `l`.`cod_producto` AS `cod_producto`, `l`.`orden` AS `orden`, `l`.`unidades` AS `unidades`, `l`.`precio_unidad` AS `precio_unidad`, `l`.`iva` AS `iva`, `l`.`importe_base` AS `importe_base`, `l`.`importe_iva` AS `importe_iva`, `l`.`importe_total` AS `importe_total`, `p`.`nombre` AS `producto_nombre` FROM (`compra_lineas` `l` left join `productos` `p` on(`l`.`cod_producto` = `p`.`cod_producto`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `cons_productos`
--
DROP TABLE IF EXISTS `cons_productos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cons_productos`  AS SELECT `p`.`cod_producto` AS `cod_producto`, `p`.`cod_categoria` AS `cod_categoria`, `p`.`nombre` AS `nombre`, `p`.`fabricante` AS `fabricante`, `p`.`fecha_alta` AS `fecha_alta`, `p`.`unidades` AS `unidades`, `p`.`precio_base` AS `precio_base`, `p`.`iva` AS `iva`, `p`.`precio_iva` AS `precio_iva`, `p`.`precio_venta` AS `precio_venta`, `p`.`foto` AS `foto`, `p`.`borrado` AS `borrado`, `c`.`descripcion` AS `categoria_nombre` FROM (`productos` `p` left join `categorias` `c` on(`p`.`cod_categoria` = `c`.`cod_categoria`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acl_roles`
--
ALTER TABLE `acl_roles`
  ADD PRIMARY KEY (`cod_acl_roles`);

--
-- Indices de la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  ADD PRIMARY KEY (`cod_acl_usuario`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`cod_categoria`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`cod_compra`),
  ADD UNIQUE KEY `cod_usuario` (`cod_usuario`);

--
-- Indices de la tabla `compra_lineas`
--
ALTER TABLE `compra_lineas`
  ADD PRIMARY KEY (`cod_compra_linea`),
  ADD UNIQUE KEY `cod_compra` (`cod_compra`),
  ADD UNIQUE KEY `cod_producto` (`cod_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`cod_producto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cod_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
