-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 07-11-2023 a las 05:15:11
-- Versión del servidor: 10.6.15-MariaDB-cll-lve
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `xura_torneo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesos`
--

CREATE TABLE `accesos` (
  `acce_ide` int(11) NOT NULL,
  `acce_usua_ide` int(11) DEFAULT NULL,
  `acce_role_ide` int(11) DEFAULT NULL,
  `acce_freg` timestamp NULL DEFAULT current_timestamp(),
  `acce_esta_ide` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `accesos`
--

INSERT INTO `accesos` (`acce_ide`, `acce_usua_ide`, `acce_role_ide`, `acce_freg`, `acce_esta_ide`) VALUES
(1, 1, 1, '2022-12-17 23:11:34', 1),
(2, 1, 2, '2022-12-17 23:14:07', 1),
(3, 2, 2, '2022-12-17 23:14:19', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad`
--

CREATE TABLE `entidad` (
  `enti_ide` int(11) NOT NULL,
  `enti_nombre` varchar(45) DEFAULT NULL,
  `enti_menu` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `entidad`
--

INSERT INTO `entidad` (`enti_ide`, `enti_nombre`, `enti_menu`) VALUES
(1, 'Perú 4K', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `esta_ide` int(11) NOT NULL,
  `esta_nombre` varchar(45) DEFAULT NULL,
  `esta_etiqueta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`esta_ide`, `esta_nombre`, `esta_etiqueta`) VALUES
(1, 'Activo', NULL),
(2, 'Eliminado', NULL),
(3, 'En curso', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscritos`
--

CREATE TABLE `inscritos` (
  `insc_ide` int(11) NOT NULL,
  `insc_torn_ide` int(11) DEFAULT NULL,
  `insc_nick` varchar(45) DEFAULT NULL,
  `insc_nombres` varchar(45) DEFAULT NULL,
  `insc_apellidos` varchar(45) DEFAULT NULL,
  `insc_nive_ide` int(11) DEFAULT NULL,
  `insc_estrellas` int(11) DEFAULT NULL,
  `insc_email` varchar(45) DEFAULT NULL,
  `insc_celular` varchar(45) DEFAULT NULL,
  `insc_freg` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

CREATE TABLE `juegos` (
  `jueg_ide` int(11) NOT NULL,
  `jueg_nombre` varchar(45) DEFAULT NULL,
  `jueg_esta_ide` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `juegos`
--

INSERT INTO `juegos` (`jueg_ide`, `jueg_nombre`, `jueg_esta_ide`) VALUES
(1, 'DOTA 2', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `modu_ide` int(11) NOT NULL,
  `modu_nombre` varchar(45) DEFAULT NULL,
  `modu_icono` varchar(45) DEFAULT NULL,
  `modu_orden` int(11) DEFAULT NULL,
  `modu_clase` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`modu_ide`, `modu_nombre`, `modu_icono`, `modu_orden`, `modu_clase`) VALUES
(1, 'Inscripciones', 'ti-write', 1, 'info'),
(2, 'Operaciones', 'ti-settings', 4, 'success');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles`
--

CREATE TABLE `niveles` (
  `nive_ide` int(11) NOT NULL,
  `nive_nombre` varchar(45) DEFAULT NULL,
  `nive_peso` int(11) DEFAULT NULL,
  `nive_jueg_ide` int(11) DEFAULT NULL,
  `nive_img` varchar(45) DEFAULT NULL,
  `nive_esta_ide` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `niveles`
--

INSERT INTO `niveles` (`nive_ide`, `nive_nombre`, `nive_peso`, `nive_jueg_ide`, `nive_img`, `nive_esta_ide`) VALUES
(1, 'Heraldo', 10, 1, NULL, 1),
(2, 'Guardián', 20, 1, NULL, 1),
(3, 'Cruzado', 30, 1, NULL, 1),
(4, 'Arconte', 40, 1, NULL, 1),
(5, 'Leyenda', 50, 1, NULL, 1),
(6, 'Ancéstral', 60, 1, NULL, 1),
(7, 'Divino', 70, 1, NULL, 1),
(8, 'Inmortal', 80, 1, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `role_ide` int(11) NOT NULL,
  `role_modu_ide` int(11) DEFAULT NULL,
  `role_nombre` varchar(45) DEFAULT NULL,
  `role_descripcion` text DEFAULT NULL,
  `role_icono` varchar(45) DEFAULT NULL,
  `role_orden` int(11) DEFAULT NULL,
  `role_url` varchar(45) DEFAULT NULL,
  `role_esta_nombre` enum('ACTIVO','INACTIVO') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`role_ide`, `role_modu_ide`, `role_nombre`, `role_descripcion`, `role_icono`, `role_orden`, `role_url`, `role_esta_nombre`) VALUES
(1, 2, 'Asignar roles', 'Asignará roles a cada uno de los usuarios dependiendo de las funciones que viene cumpliendo dentro de la entidad', NULL, 91, '/accesos', 'ACTIVO'),
(2, 1, 'Inscribirme', 'Bienvenido, llene el formulario para inscribirte en el Torneo.', NULL, 11, '/inscribir', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneos`
--

CREATE TABLE `torneos` (
  `torn_ide` int(11) NOT NULL,
  `torn_nombre` varchar(45) DEFAULT NULL,
  `torn_descripcion` text DEFAULT NULL,
  `torn_jueg_ide` int(11) DEFAULT NULL,
  `torn_fecha` date DEFAULT NULL,
  `torn_esta_ide` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `torneos`
--

INSERT INTO `torneos` (`torn_ide`, `torn_nombre`, `torn_descripcion`, `torn_jueg_ide`, `torn_fecha`, `torn_esta_ide`) VALUES
(1, 'Torneo de DOTA 2 - Navidad 2022', '...', 1, '2022-12-25', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usua_ide` int(11) NOT NULL,
  `usua_enti_ide` int(11) DEFAULT NULL,
  `usua_paterno` varchar(45) DEFAULT NULL,
  `usua_materno` varchar(45) DEFAULT NULL,
  `usua_nombres` varchar(45) DEFAULT NULL,
  `usua_user` varchar(45) DEFAULT NULL,
  `usua_pass` varchar(45) DEFAULT NULL,
  `usua_esta_ide` int(11) DEFAULT NULL,
  `usua_created_at` datetime DEFAULT NULL,
  `usua_updated_at` datetime DEFAULT NULL,
  `usua_deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usua_ide`, `usua_enti_ide`, `usua_paterno`, `usua_materno`, `usua_nombres`, `usua_user`, `usua_pass`, `usua_esta_ide`, `usua_created_at`, `usua_updated_at`, `usua_deleted_at`) VALUES
(1, 1, 'ROMERO', 'CRUZ', 'MARIO', 'admin', 'dota2022', 1, NULL, NULL, NULL),
(2, 1, 'PERU ', '4K', 'LAN CENTER', 'inscripciones', 'T48@5hUx', 1, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesos`
--
ALTER TABLE `accesos`
  ADD PRIMARY KEY (`acce_ide`),
  ADD KEY `fk_accesos_usuarios1_idx` (`acce_usua_ide`),
  ADD KEY `fk_accesos_roles1_idx` (`acce_role_ide`),
  ADD KEY `fk_accesos_estados1_idx` (`acce_esta_ide`);

--
-- Indices de la tabla `entidad`
--
ALTER TABLE `entidad`
  ADD PRIMARY KEY (`enti_ide`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`esta_ide`);

--
-- Indices de la tabla `inscritos`
--
ALTER TABLE `inscritos`
  ADD PRIMARY KEY (`insc_ide`),
  ADD KEY `fk_inscritos_torneos1_idx` (`insc_torn_ide`),
  ADD KEY `fk_inscritos_niveles1_idx` (`insc_nive_ide`);

--
-- Indices de la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`jueg_ide`),
  ADD KEY `fk_juegos_estados1_idx` (`jueg_esta_ide`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`modu_ide`);

--
-- Indices de la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`nive_ide`),
  ADD KEY `fk_niveles_juegos1_idx` (`nive_jueg_ide`),
  ADD KEY `fk_niveles_estados1_idx` (`nive_esta_ide`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_ide`),
  ADD KEY `fk_roles_modulos1_idx` (`role_modu_ide`);

--
-- Indices de la tabla `torneos`
--
ALTER TABLE `torneos`
  ADD PRIMARY KEY (`torn_ide`),
  ADD KEY `fk_torneos_estados1_idx` (`torn_esta_ide`),
  ADD KEY `fk_torneos_juegos1_idx` (`torn_jueg_ide`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usua_ide`),
  ADD KEY `fk_usuarios_estados1_idx` (`usua_esta_ide`),
  ADD KEY `fk_usuarios_entidad1_idx` (`usua_enti_ide`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accesos`
--
ALTER TABLE `accesos`
  MODIFY `acce_ide` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `entidad`
--
ALTER TABLE `entidad`
  MODIFY `enti_ide` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `esta_ide` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `inscritos`
--
ALTER TABLE `inscritos`
  MODIFY `insc_ide` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `jueg_ide` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `modu_ide` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `niveles`
--
ALTER TABLE `niveles`
  MODIFY `nive_ide` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `role_ide` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `torneos`
--
ALTER TABLE `torneos`
  MODIFY `torn_ide` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usua_ide` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accesos`
--
ALTER TABLE `accesos`
  ADD CONSTRAINT `fk_accesos_estados1` FOREIGN KEY (`acce_esta_ide`) REFERENCES `estados` (`esta_ide`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_accesos_roles1` FOREIGN KEY (`acce_role_ide`) REFERENCES `roles` (`role_ide`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_accesos_usuarios1` FOREIGN KEY (`acce_usua_ide`) REFERENCES `usuarios` (`usua_ide`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inscritos`
--
ALTER TABLE `inscritos`
  ADD CONSTRAINT `fk_inscritos_niveles1` FOREIGN KEY (`insc_nive_ide`) REFERENCES `niveles` (`nive_ide`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscritos_torneos1` FOREIGN KEY (`insc_torn_ide`) REFERENCES `torneos` (`torn_ide`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD CONSTRAINT `fk_juegos_estados1` FOREIGN KEY (`jueg_esta_ide`) REFERENCES `estados` (`esta_ide`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD CONSTRAINT `fk_niveles_estados1` FOREIGN KEY (`nive_esta_ide`) REFERENCES `estados` (`esta_ide`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_niveles_juegos1` FOREIGN KEY (`nive_jueg_ide`) REFERENCES `juegos` (`jueg_ide`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `fk_roles_modulos1` FOREIGN KEY (`role_modu_ide`) REFERENCES `modulos` (`modu_ide`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `torneos`
--
ALTER TABLE `torneos`
  ADD CONSTRAINT `fk_torneos_estados1` FOREIGN KEY (`torn_esta_ide`) REFERENCES `estados` (`esta_ide`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_torneos_juegos1` FOREIGN KEY (`torn_jueg_ide`) REFERENCES `juegos` (`jueg_ide`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_entidad1` FOREIGN KEY (`usua_enti_ide`) REFERENCES `entidad` (`enti_ide`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuarios_estados1` FOREIGN KEY (`usua_esta_ide`) REFERENCES `estados` (`esta_ide`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
