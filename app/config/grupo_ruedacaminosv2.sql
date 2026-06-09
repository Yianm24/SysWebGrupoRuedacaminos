-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-06-2026 a las 02:01:08
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `grupo_ruedacaminosv2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banco`
--

CREATE TABLE `banco` (
  `cod_banco` int(1) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cambio_moneda`
--

CREATE TABLE `cambio_moneda` (
  `cod_cambio` int(11) NOT NULL,
  `tasa` float NOT NULL,
  `fecha` date NOT NULL,
  `cod_moneda` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `cod_cargo` int(1) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `cod_ciudad` int(2) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `cod_municipio` int(2) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cod_cliente` varchar(10) NOT NULL,
  `razon_social` varchar(30) NOT NULL,
  `apellido` varchar(20) DEFAULT NULL,
  `telefono` varchar(11) NOT NULL,
  `correo_electronico` varchar(80) DEFAULT NULL,
  `cod_tipodoc` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_banco`
--

CREATE TABLE `cuenta_banco` (
  `cod_cuenta` int(1) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `numero_cuenta` varchar(20) NOT NULL,
  `cod_banco` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `despacho`
--

CREATE TABLE `despacho` (
  `cod_despacho` int(11) NOT NULL,
  `cod_empleado` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pago`
--

CREATE TABLE `detalle_pago` (
  `cod_detallepago` int(11) NOT NULL,
  `referencia` int(11) NOT NULL,
  `cod_metodopago` int(1) NOT NULL,
  `cod_banco` int(1) NOT NULL,
  `monto` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `cod_empleado` varchar(8) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `telefono_emergencia` varchar(12) DEFAULT NULL,
  `cod_cargo` int(1) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio`
--

CREATE TABLE `envio` (
  `cod_envio` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `monto_total` float NOT NULL,
  `cod_paqueteria` int(11) NOT NULL,
  `cod_vehiculo` varchar(7) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `cod_despacho` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `cod_estado` int(2) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `cod_marca` int(1) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodo_pago`
--

CREATE TABLE `metodo_pago` (
  `cod_metodo` int(1) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `cod_moneda` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo`
--

CREATE TABLE `modelo` (
  `cod_modelo` int(1) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `cod_marca` int(1) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moneda`
--

CREATE TABLE `moneda` (
  `cod_moneda` int(1) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `abreviatura` varchar(5) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipio`
--

CREATE TABLE `municipio` (
  `cod_municipio` int(2) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `cod_estado` int(2) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `cod_pago` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` datetime NOT NULL,
  `monto` float NOT NULL,
  `referencia` varchar(20) NOT NULL,
  `cod_envio` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `cod_detallepago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paqueteria`
--

CREATE TABLE `paqueteria` (
  `cod_paqueteria` int(11) NOT NULL,
  `descripcion_contenido` text NOT NULL,
  `peso_total` float NOT NULL,
  `altura_total` float NOT NULL,
  `anchura_total` float NOT NULL,
  `cod_unidadmedida` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parroquia`
--

CREATE TABLE `parroquia` (
  `cod_parroquia` int(2) NOT NULL,
  `nombre` int(15) NOT NULL,
  `cod_ciudad` int(2) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participante_envio`
--

CREATE TABLE `participante_envio` (
  `cod_cliente` varchar(10) NOT NULL,
  `cod_envio` int(11) NOT NULL,
  `rol_cliente` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precio_kilometraje`
--

CREATE TABLE `precio_kilometraje` (
  `cod_preciokilometraje` int(11) NOT NULL,
  `monto_tarifa` int(5) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `cod_rol` int(1) NOT NULL,
  `nombre` varchar(10) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_vehiculo`
--

CREATE TABLE `tipos_vehiculo` (
  `cod_tipovehiculo` int(1) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `altura__max` float NOT NULL,
  `peso_max` float NOT NULL,
  `largo_max` float NOT NULL,
  `anchura_max` float NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `cod_preciokilometraje` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `cod_tipodocumento` int(1) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `abreviatura` int(5) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `cod_ubicacion` int(11) NOT NULL,
  `descripcion` varchar(70) NOT NULL,
  `cod_parroquia` int(2) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones_envio`
--

CREATE TABLE `ubicaciones_envio` (
  `cod_ubicacion` int(11) NOT NULL,
  `cod_envio` int(11) NOT NULL,
  `tipo_ubicacion` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades_medida`
--

CREATE TABLE `unidades_medida` (
  `cod_unidad` int(1) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `abreviatura` varchar(5) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `cod_usuario` varchar(11) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `password` varchar(20) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `cod_rol` int(1) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `placa` varchar(7) NOT NULL,
  `color` varchar(6) NOT NULL,
  `cod_tipovehiculo` int(1) NOT NULL,
  `disponibilidad` int(1) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `cod_modelo` int(1) NOT NULL,
  `ano` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `banco`
--
ALTER TABLE `banco`
  ADD PRIMARY KEY (`cod_banco`);

--
-- Indices de la tabla `cambio_moneda`
--
ALTER TABLE `cambio_moneda`
  ADD PRIMARY KEY (`cod_cambio`),
  ADD KEY `cod_moneda` (`cod_moneda`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`cod_cargo`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`cod_ciudad`),
  ADD KEY `cod_municipio` (`cod_municipio`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cod_cliente`),
  ADD KEY `cod_tipodoc` (`cod_tipodoc`);

--
-- Indices de la tabla `cuenta_banco`
--
ALTER TABLE `cuenta_banco`
  ADD PRIMARY KEY (`cod_cuenta`),
  ADD KEY `cod_banco` (`cod_banco`);

--
-- Indices de la tabla `despacho`
--
ALTER TABLE `despacho`
  ADD PRIMARY KEY (`cod_despacho`),
  ADD KEY `cod_empleado` (`cod_empleado`);

--
-- Indices de la tabla `detalle_pago`
--
ALTER TABLE `detalle_pago`
  ADD PRIMARY KEY (`cod_detallepago`),
  ADD KEY `cod_metodopago` (`cod_metodopago`),
  ADD KEY `cod_banco` (`cod_banco`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`cod_empleado`),
  ADD KEY `cod_cargo` (`cod_cargo`);

--
-- Indices de la tabla `envio`
--
ALTER TABLE `envio`
  ADD PRIMARY KEY (`cod_envio`),
  ADD KEY `cod_paqueteria` (`cod_paqueteria`),
  ADD KEY `cod_vehiculo` (`cod_vehiculo`),
  ADD KEY `cod_despacho` (`cod_despacho`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`cod_estado`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`cod_marca`);

--
-- Indices de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  ADD PRIMARY KEY (`cod_metodo`),
  ADD KEY `cod_moneda` (`cod_moneda`);

--
-- Indices de la tabla `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`cod_modelo`),
  ADD KEY `cod_marca` (`cod_marca`);

--
-- Indices de la tabla `moneda`
--
ALTER TABLE `moneda`
  ADD PRIMARY KEY (`cod_moneda`);

--
-- Indices de la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD PRIMARY KEY (`cod_municipio`),
  ADD KEY `cod_estado` (`cod_estado`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`cod_pago`),
  ADD KEY `cod_envio` (`cod_envio`),
  ADD KEY `cod_detallepago` (`cod_detallepago`);

--
-- Indices de la tabla `paqueteria`
--
ALTER TABLE `paqueteria`
  ADD PRIMARY KEY (`cod_paqueteria`),
  ADD KEY `cod_unidadmedida` (`cod_unidadmedida`);

--
-- Indices de la tabla `parroquia`
--
ALTER TABLE `parroquia`
  ADD PRIMARY KEY (`cod_parroquia`),
  ADD KEY `cod_ciudad` (`cod_ciudad`);

--
-- Indices de la tabla `participante_envio`
--
ALTER TABLE `participante_envio`
  ADD KEY `cod_participante` (`cod_cliente`),
  ADD KEY `cod_envio` (`cod_envio`);

--
-- Indices de la tabla `precio_kilometraje`
--
ALTER TABLE `precio_kilometraje`
  ADD PRIMARY KEY (`cod_preciokilometraje`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`cod_rol`);

--
-- Indices de la tabla `tipos_vehiculo`
--
ALTER TABLE `tipos_vehiculo`
  ADD PRIMARY KEY (`cod_tipovehiculo`),
  ADD KEY `cod_preciokilometraje` (`cod_preciokilometraje`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`cod_tipodocumento`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`cod_ubicacion`),
  ADD KEY `cod_parroquia` (`cod_parroquia`);

--
-- Indices de la tabla `ubicaciones_envio`
--
ALTER TABLE `ubicaciones_envio`
  ADD KEY `cod_ubicacion` (`cod_ubicacion`),
  ADD KEY `cod_envio` (`cod_envio`);

--
-- Indices de la tabla `unidades_medida`
--
ALTER TABLE `unidades_medida`
  ADD PRIMARY KEY (`cod_unidad`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`cod_usuario`),
  ADD KEY `cod_rol` (`cod_rol`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`placa`),
  ADD KEY `cod_tipovehiculo` (`cod_tipovehiculo`),
  ADD KEY `cod_modelo` (`cod_modelo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `banco`
--
ALTER TABLE `banco`
  MODIFY `cod_banco` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cambio_moneda`
--
ALTER TABLE `cambio_moneda`
  MODIFY `cod_cambio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `cod_cargo` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `cod_ciudad` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuenta_banco`
--
ALTER TABLE `cuenta_banco`
  MODIFY `cod_cuenta` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_pago`
--
ALTER TABLE `detalle_pago`
  MODIFY `cod_detallepago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `envio`
--
ALTER TABLE `envio`
  MODIFY `cod_envio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `cod_estado` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `cod_marca` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  MODIFY `cod_metodo` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `moneda`
--
ALTER TABLE `moneda`
  MODIFY `cod_moneda` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `municipio`
--
ALTER TABLE `municipio`
  MODIFY `cod_municipio` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `cod_pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paqueteria`
--
ALTER TABLE `paqueteria`
  MODIFY `cod_paqueteria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `parroquia`
--
ALTER TABLE `parroquia`
  MODIFY `cod_parroquia` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `precio_kilometraje`
--
ALTER TABLE `precio_kilometraje`
  MODIFY `cod_preciokilometraje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `cod_rol` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos_vehiculo`
--
ALTER TABLE `tipos_vehiculo`
  MODIFY `cod_tipovehiculo` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `cod_tipodocumento` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `cod_ubicacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `unidades_medida`
--
ALTER TABLE `unidades_medida`
  MODIFY `cod_unidad` int(1) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cambio_moneda`
--
ALTER TABLE `cambio_moneda`
  ADD CONSTRAINT `cambio_moneda_ibfk_1` FOREIGN KEY (`cod_moneda`) REFERENCES `moneda` (`cod_moneda`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD CONSTRAINT `ciudad_ibfk_1` FOREIGN KEY (`cod_municipio`) REFERENCES `municipio` (`cod_municipio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`cod_tipodoc`) REFERENCES `tipo_documento` (`cod_tipodocumento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cuenta_banco`
--
ALTER TABLE `cuenta_banco`
  ADD CONSTRAINT `cuenta_banco_ibfk_1` FOREIGN KEY (`cod_banco`) REFERENCES `banco` (`cod_banco`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `despacho`
--
ALTER TABLE `despacho`
  ADD CONSTRAINT `despacho_ibfk_1` FOREIGN KEY (`cod_empleado`) REFERENCES `empleado` (`cod_empleado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_pago`
--
ALTER TABLE `detalle_pago`
  ADD CONSTRAINT `detalle_pago_ibfk_1` FOREIGN KEY (`cod_metodopago`) REFERENCES `metodo_pago` (`cod_metodo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_pago_ibfk_2` FOREIGN KEY (`cod_banco`) REFERENCES `banco` (`cod_banco`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`cod_cargo`) REFERENCES `cargo` (`cod_cargo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `envio`
--
ALTER TABLE `envio`
  ADD CONSTRAINT `envio_ibfk_1` FOREIGN KEY (`cod_paqueteria`) REFERENCES `paqueteria` (`cod_paqueteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `envio_ibfk_2` FOREIGN KEY (`cod_vehiculo`) REFERENCES `vehiculo` (`placa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `envio_ibfk_3` FOREIGN KEY (`cod_despacho`) REFERENCES `despacho` (`cod_despacho`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  ADD CONSTRAINT `metodo_pago_ibfk_1` FOREIGN KEY (`cod_moneda`) REFERENCES `moneda` (`cod_moneda`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `modelo`
--
ALTER TABLE `modelo`
  ADD CONSTRAINT `modelo_ibfk_1` FOREIGN KEY (`cod_marca`) REFERENCES `marca` (`cod_marca`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD CONSTRAINT `municipio_ibfk_1` FOREIGN KEY (`cod_estado`) REFERENCES `estado` (`cod_estado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_2` FOREIGN KEY (`cod_envio`) REFERENCES `envio` (`cod_envio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pago_ibfk_3` FOREIGN KEY (`cod_detallepago`) REFERENCES `detalle_pago` (`cod_detallepago`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `paqueteria`
--
ALTER TABLE `paqueteria`
  ADD CONSTRAINT `paqueteria_ibfk_1` FOREIGN KEY (`cod_unidadmedida`) REFERENCES `unidades_medida` (`cod_unidad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `parroquia`
--
ALTER TABLE `parroquia`
  ADD CONSTRAINT `parroquia_ibfk_1` FOREIGN KEY (`cod_ciudad`) REFERENCES `ciudad` (`cod_ciudad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `participante_envio`
--
ALTER TABLE `participante_envio`
  ADD CONSTRAINT `participante_envio_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `cliente` (`cod_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participante_envio_ibfk_2` FOREIGN KEY (`cod_envio`) REFERENCES `envio` (`cod_envio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tipos_vehiculo`
--
ALTER TABLE `tipos_vehiculo`
  ADD CONSTRAINT `tipos_vehiculo_ibfk_1` FOREIGN KEY (`cod_preciokilometraje`) REFERENCES `precio_kilometraje` (`cod_preciokilometraje`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD CONSTRAINT `ubicacion_ibfk_1` FOREIGN KEY (`cod_parroquia`) REFERENCES `parroquia` (`cod_parroquia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ubicaciones_envio`
--
ALTER TABLE `ubicaciones_envio`
  ADD CONSTRAINT `ubicaciones_envio_ibfk_1` FOREIGN KEY (`cod_ubicacion`) REFERENCES `ubicacion` (`cod_ubicacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ubicaciones_envio_ibfk_2` FOREIGN KEY (`cod_envio`) REFERENCES `envio` (`cod_envio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`cod_rol`) REFERENCES `rol` (`cod_rol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD CONSTRAINT `vehiculo_ibfk_2` FOREIGN KEY (`cod_tipovehiculo`) REFERENCES `tipos_vehiculo` (`cod_tipovehiculo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vehiculo_ibfk_3` FOREIGN KEY (`cod_modelo`) REFERENCES `modelo` (`cod_modelo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
