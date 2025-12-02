-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-12-2025 a las 18:45:04
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
-- Base de datos: `practica9`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_roles`
--

CREATE TABLE `acl_roles` (
  `cod_acl_role` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `perm1` tinyint(1) NOT NULL DEFAULT 0,
  `perm2` tinyint(1) NOT NULL DEFAULT 0,
  `perm3` tinyint(1) NOT NULL DEFAULT 0,
  `perm4` tinyint(1) NOT NULL DEFAULT 0,
  `perm5` tinyint(1) NOT NULL DEFAULT 0,
  `perm6` tinyint(1) NOT NULL DEFAULT 0,
  `perm7` tinyint(1) NOT NULL DEFAULT 0,
  `perm8` tinyint(1) NOT NULL DEFAULT 0,
  `perm9` tinyint(1) NOT NULL DEFAULT 0,
  `perm10` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `acl_roles`
--

INSERT INTO `acl_roles` (`cod_acl_role`, `nombre`, `perm1`, `perm2`, `perm3`, `perm4`, `perm5`, `perm6`, `perm7`, `perm8`, `perm9`, `perm10`) VALUES
(1, 'profesor', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'alumno', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'administrador', 1, 1, 1, 1, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_usuarios`
--

CREATE TABLE `acl_usuarios` (
  `cod_acl_usuario` int(11) NOT NULL,
  `nick` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `contrasenia` varchar(64) NOT NULL,
  `cod_acl_role` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `acl_usuarios`
--

INSERT INTO `acl_usuarios` (`cod_acl_usuario`, `nick`, `nombre`, `contrasenia`, `cod_acl_role`, `borrado`) VALUES
(1, 'jaime', 'Q3PBoi9MaYsZ88XDNclJN', 'fbea31c7083ef34d19f4b946b94b60560c709e34', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cod_usuario` int(11) NOT NULL,
  `nick` varchar(50) NOT NULL COMMENT 'acl',
  `nombre` varchar(50) NOT NULL DEFAULT '''''' COMMENT 'igual que acl',
  `nif` varchar(10) NOT NULL DEFAULT '''''',
  `direccion` varchar(50) NOT NULL DEFAULT '''''',
  `poblacion` varchar(30) NOT NULL DEFAULT '''''',
  `provincia` varchar(30) NOT NULL DEFAULT '''''',
  `CP` char(5) NOT NULL DEFAULT '00000',
  `fecha_nacimiento` date DEFAULT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `foto` varchar(50) NOT NULL DEFAULT ''''''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cod_usuario`, `nick`, `nombre`, `nif`, `direccion`, `poblacion`, `provincia`, `CP`, `fecha_nacimiento`, `borrado`, `foto`) VALUES
(1, 'nata_', 'natalia', '25878945G', 'C/Codo', 'Mollinee', 'Malaga', '00000', '2025-12-03', 1, '\''),
(10, 'jaime', 'Q3PBoi9MaYsZ88XDNclJN', '234567J', 'c/alameda', 'antequera', 'malaga', '00000', '2003-12-18', 1, 'defecto.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acl_roles`
--
ALTER TABLE `acl_roles`
  ADD PRIMARY KEY (`cod_acl_role`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  ADD PRIMARY KEY (`cod_acl_usuario`),
  ADD UNIQUE KEY `uq_acl_roles_1` (`nick`),
  ADD KEY `cod_acl_role` (`cod_acl_role`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cod_usuario`),
  ADD UNIQUE KEY `nick` (`nick`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acl_roles`
--
ALTER TABLE `acl_roles`
  MODIFY `cod_acl_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  MODIFY `cod_acl_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `cod_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  ADD CONSTRAINT `fk_acl_roles_1` FOREIGN KEY (`cod_acl_role`) REFERENCES `acl_roles` (`cod_acl_role`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
