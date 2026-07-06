-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-07-2026 a las 21:38:03
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
-- Base de datos: `grupo_ruedacaminos`
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

--
-- Volcado de datos para la tabla `banco`
--

INSERT INTO `banco` (`cod_banco`, `nombre`, `estado`) VALUES
(1, 'BNC', 1),
(2, 'Banplus', 1),
(3, 'Banesco', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cambio_moneda`
--

CREATE TABLE `cambio_moneda` (
  `cod_cambio` int(11) NOT NULL,
  `tasa` float NOT NULL,
  `fecha` datetime NOT NULL,
  `cod_moneda` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cambio_moneda`
--

INSERT INTO `cambio_moneda` (`cod_cambio`, `tasa`, `fecha`, `cod_moneda`, `estado`) VALUES
(1, 602.25, '2026-06-18 00:00:00', 1, 1),
(2, 645.03, '2026-06-18 00:00:00', 3, 1),
(3, 805.12, '2026-06-18 00:00:00', 4, 1),
(7, 667.05, '2026-07-06 14:13:04', 1, 1),
(8, 763.19, '2026-07-06 14:15:50', 3, 1),
(9, 757.23, '2026-07-06 14:16:09', 4, 1),
(10, 12122, '2026-07-06 14:17:11', 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `cod_cargo` int(1) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`cod_cargo`, `nombre`, `estado`) VALUES
(1, 'administracion', 1),
(2, 'contaduria', 1),
(3, 'presidencia', 1),
(4, 'chofer', 1);

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

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`cod_ciudad`, `nombre`, `cod_municipio`, `estado`) VALUES
(1, 'Barquisimeto', 1, 1),
(2, 'Valencia', 3, 1),
(3, 'Maracaibo', 4, 1),
(4, 'Cabudare', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cod_cliente` int(10) NOT NULL,
  `doc_identidad` int(10) NOT NULL COMMENT 'puede ser el rif,cedula,etc',
  `razon_social` varchar(30) NOT NULL,
  `apellido` varchar(20) DEFAULT NULL,
  `telefono` varchar(11) NOT NULL,
  `email` varchar(80) DEFAULT NULL,
  `tipo_documento` varchar(1) NOT NULL COMMENT 'v=venezolano,j=juridico, e=extranjero, g=gubernamental',
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`cod_cliente`, `doc_identidad`, `razon_social`, `apellido`, `telefono`, `email`, `tipo_documento`, `estado`) VALUES
(9, 12345678, 'Maria', 'Pérez', '04125452001', 'malau200104@gmail.com', 'V', 1),
(13, 12345678, 'RUEDA', 'CAMINOS', '1231232', 'malsdasdl@fdsf', 'V', 1),
(22, 7777, 'yuan', 'perereadasd', '312123', 'mamdasmdska@ANSDMSAD', 'E', 1),
(23, 3333, 'juan', 'perereadasd', '312123', 'mamdasmdska@ANSDMSAD', 'E', 1);

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

--
-- Volcado de datos para la tabla `cuenta_banco`
--

INSERT INTO `cuenta_banco` (`cod_cuenta`, `telefono`, `numero_cuenta`, `cod_banco`, `estado`) VALUES
(1, '0412394949', '192912912112919', 3, 1),
(2, '04123838383', '011202010201444332', 2, 1),
(3, '04123838383', '01032020102033248', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `despacho`
--

CREATE TABLE `despacho` (
  `cod_despacho` int(11) NOT NULL,
  `cod_empleado` int(2) NOT NULL,
  `cod_vehiculo` int(2) NOT NULL,
  `cod_detalledespacho` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_despacho`
--

CREATE TABLE `detalle_despacho` (
  `cod_detalledespacho` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `estatus` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_despacho`
--

INSERT INTO `detalle_despacho` (`cod_detalledespacho`, `fecha`, `estatus`) VALUES
(1, '2026-06-19 00:20:29', 'Cargando'),
(2, '2026-06-19 00:21:09', 'Despachand'),
(3, '2026-06-19 00:21:49', 'Entregado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pago`
--

CREATE TABLE `detalle_pago` (
  `cod_detallepago` int(11) NOT NULL,
  `referencia` int(11) NOT NULL,
  `cod_metodopago` int(1) NOT NULL,
  `cod_banco` int(1) NOT NULL,
  `monto` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pago`
--

INSERT INTO `detalle_pago` (`cod_detallepago`, `referencia`, `cod_metodopago`, `cod_banco`, `monto`) VALUES
(1, 30232, 1, 3, 10000.00),
(2, 772791, 2, 1, 13892.50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `cod_empleado` int(2) NOT NULL,
  `cedula` varchar(8) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `telefono_emergencia` varchar(12) DEFAULT NULL,
  `cod_cargo` int(1) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`cod_empleado`, `cedula`, `nombre`, `apellido`, `telefono`, `telefono_emergencia`, `cod_cargo`, `estado`) VALUES
(2525, '', 'juan', 'jochis', '024255003', '565656', 2, 1),
(8888, '', 'mari', 'pere', '024255003', '565656', 1, 1),
(15151, '', 'antonis', 'caraqueña', '040656060', '87878481', 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio`
--

CREATE TABLE `envio` (
  `cod_envio` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `monto_total` decimal(8,2) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `cod_despacho` int(11) NOT NULL,
  `peso_total` decimal(6,2) NOT NULL,
  `anchura` decimal(5,2) NOT NULL,
  `altura` decimal(5,2) NOT NULL,
  `descrip_contenido` varchar(50) NOT NULL,
  `distancia_total` float(7,2) NOT NULL,
  `cod_unidadmedida` int(1) NOT NULL,
  `cod_gasto` int(11) NOT NULL,
  `cod_preciokilometraje` int(11) NOT NULL
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

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`cod_estado`, `nombre`, `estado`) VALUES
(1, 'Lara', 1),
(2, 'Carabobo', 1),
(3, 'Zulia', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos_funcionales`
--

CREATE TABLE `gastos_funcionales` (
  `cod_gasto` int(11) NOT NULL,
  `detalles` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gastos_funcionales`
--

INSERT INTO `gastos_funcionales` (`cod_gasto`, `detalles`) VALUES
(1, 'Viaticos'),
(2, 'Peajes'),
(3, 'Gasolina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `cod_marca` int(1) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`cod_marca`, `nombre`, `estado`) VALUES
(1, 'FORD', 1),
(2, 'FIAT', 1),
(3, 'CHEVROLET', 1);

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

--
-- Volcado de datos para la tabla `metodo_pago`
--

INSERT INTO `metodo_pago` (`cod_metodo`, `nombre`, `cod_moneda`, `estado`) VALUES
(1, 'Pago Movil', 2, 1),
(2, 'Transferencia', 2, 1),
(3, 'Efectivo', 1, 1),
(4, 'Zelle', 1, 1),
(5, 'PayPal', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo`
--

CREATE TABLE `modelo` (
  `cod_modelo` int(1) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `cod_marca` int(1) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modelo`
--

INSERT INTO `modelo` (`cod_modelo`, `nombre`, `cod_marca`, `estado`) VALUES
(1, 'Fiat', NULL, 1),
(2, 'Canguro', NULL, 1),
(3, 'Fiorino', NULL, 1);

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

--
-- Volcado de datos para la tabla `moneda`
--

INSERT INTO `moneda` (`cod_moneda`, `nombre`, `abreviatura`, `estado`) VALUES
(1, 'Dolar', 'USD', 1),
(2, 'Bolívar ', 'VES', 1),
(3, 'Euro', 'EUR', 1),
(4, 'Tether', 'USDT', 1);

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

--
-- Volcado de datos para la tabla `municipio`
--

INSERT INTO `municipio` (`cod_municipio`, `nombre`, `cod_estado`, `estado`) VALUES
(1, 'Irribaren', 1, 1),
(2, 'Palavecino', 1, 1),
(3, 'Valencia', 2, 1),
(4, 'Maracaibo', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `cod_pago` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` datetime NOT NULL,
  `monto` decimal(8,2) NOT NULL,
  `referencia` varchar(20) NOT NULL,
  `cod_envio` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `cod_detallepago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parroquia`
--

CREATE TABLE `parroquia` (
  `cod_parroquia` int(2) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `cod_ciudad` int(2) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `parroquia`
--

INSERT INTO `parroquia` (`cod_parroquia`, `nombre`, `cod_ciudad`, `estado`) VALUES
(1, 'Guerrera Ana Soto', 1, 1),
(2, 'Concepción', 1, 1),
(3, 'Catedral', 1, 1),
(4, 'Cabudare', 4, 1),
(5, 'Agua Viva', 4, 1),
(6, 'Candelaria', 2, 1),
(7, 'Antonio Borjas Romero', 3, 1),
(8, 'Bolívar', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participante_envio`
--

CREATE TABLE `participante_envio` (
  `cod_cliente` int(10) NOT NULL,
  `cod_envio` int(11) NOT NULL,
  `rol_cliente` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precio_kilometraje`
--

CREATE TABLE `precio_kilometraje` (
  `cod_preciokilometraje` int(11) NOT NULL,
  `kilometraje` decimal(7,2) NOT NULL,
  `monto_tarifa` decimal(7,2) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `precio_kilometraje`
--

INSERT INTO `precio_kilometraje` (`cod_preciokilometraje`, `kilometraje`, `monto_tarifa`, `estado`) VALUES
(1, 1.00, 2.36, 1),
(2, 5.00, 4.50, 1),
(3, 10.00, 9.00, 1),
(5, 6.00, 888.09, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `cod_rol` int(1) NOT NULL,
  `nombre` varchar(10) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`cod_rol`, `nombre`, `estado`) VALUES
(1, 'Administra', 1),
(2, 'Recepcioni', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_vehiculo`
--

CREATE TABLE `tipos_vehiculo` (
  `cod_tipovehiculo` int(1) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `altura_max` float DEFAULT NULL,
  `peso_max` float DEFAULT NULL,
  `largo_max` float DEFAULT NULL,
  `anchura_max` float DEFAULT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_vehiculo`
--

INSERT INTO `tipos_vehiculo` (`cod_tipovehiculo`, `nombre`, `altura_max`, `peso_max`, `largo_max`, `anchura_max`, `estado`) VALUES
(1, 'Grande', 200, 3000, 400, 200, 1),
(2, 'Mediano', 170, 2400, 300, 150, 1),
(3, 'Pequeño', 150, 1800, 220, 130, 1);

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

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`cod_ubicacion`, `descripcion`, `cod_parroquia`, `estado`) VALUES
(1, 'Av. Florencio Jiménez con calle 10 de Pueblo Nuevo', 1, 1),
(2, 'Av. Venezuela con calles 28 y 29', 3, 1);

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
-- Estructura de tabla para la tabla `unidad_medida`
--

CREATE TABLE `unidad_medida` (
  `cod_unidad` int(1) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `abreviatura` varchar(5) NOT NULL,
  `tipo` enum('Masa','Longitud') NOT NULL COMMENT 'Unidades utilizadas en los servicios prestados',
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidad_medida`
--

INSERT INTO `unidad_medida` (`cod_unidad`, `nombre`, `abreviatura`, `tipo`, `estado`) VALUES
(1, 'Centimetros', 'CM', 'Longitud', 1),
(2, 'Kilometros', 'KM', 'Longitud', 1),
(3, 'Kilogramos', 'KG', 'Masa', 1),
(4, 'Gramos', 'G', 'Masa', 1);

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

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`cod_usuario`, `nombre`, `password`, `telefono`, `cod_rol`, `estado`) VALUES
('1', 'Administrador', '123456', '04123838383', 1, 1),
('2', 'Recepcionista', '123456', '04243949940', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `cod_vehiculo` int(2) NOT NULL,
  `placa` varchar(7) NOT NULL,
  `color` varchar(6) NOT NULL,
  `cod_tipovehiculo` int(1) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `cod_modelo` int(1) NOT NULL,
  `ano` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`cod_vehiculo`, `placa`, `color`, `cod_tipovehiculo`, `estado`, `cod_modelo`, `ano`) VALUES
(8, 'ABC541', 'Blanco', 2, 1, 1, 2022),
(9, 'ABC1234', 'Blanco', 1, 1, 2, 2022),
(10, 'GHI1122', 'Gris', 1, 1, 3, 2023),
(11, 'XYZ9876', 'Rojo', 3, 0, 2, 2019),
(12, 'XYB9870', 'Negro', 2, 0, 2, 2004);

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
  ADD PRIMARY KEY (`cod_cliente`);

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
  ADD KEY `cod_empleado` (`cod_empleado`),
  ADD KEY `cod_vehiculo` (`cod_vehiculo`),
  ADD KEY `cod_detalledespacho` (`cod_detalledespacho`);

--
-- Indices de la tabla `detalle_despacho`
--
ALTER TABLE `detalle_despacho`
  ADD PRIMARY KEY (`cod_detalledespacho`);

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
  ADD KEY `cod_despacho` (`cod_despacho`),
  ADD KEY `cod_unidadmedida` (`cod_unidadmedida`),
  ADD KEY `cod_gasto` (`cod_gasto`),
  ADD KEY `cod_preciokilometraje` (`cod_preciokilometraje`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`cod_estado`);

--
-- Indices de la tabla `gastos_funcionales`
--
ALTER TABLE `gastos_funcionales`
  ADD PRIMARY KEY (`cod_gasto`);

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
-- Indices de la tabla `parroquia`
--
ALTER TABLE `parroquia`
  ADD PRIMARY KEY (`cod_parroquia`),
  ADD KEY `cod_ciudad` (`cod_ciudad`);

--
-- Indices de la tabla `participante_envio`
--
ALTER TABLE `participante_envio`
  ADD KEY `cod_envio` (`cod_envio`),
  ADD KEY `cod_cliente` (`cod_cliente`);

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
  ADD PRIMARY KEY (`cod_tipovehiculo`);

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
  ADD PRIMARY KEY (`cod_ubicacion`,`cod_envio`),
  ADD KEY `cod_ubicacion` (`cod_ubicacion`),
  ADD KEY `cod_envio` (`cod_envio`);

--
-- Indices de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
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
  ADD PRIMARY KEY (`cod_vehiculo`),
  ADD KEY `cod_tipovehiculo` (`cod_tipovehiculo`),
  ADD KEY `cod_modelo` (`cod_modelo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `banco`
--
ALTER TABLE `banco`
  MODIFY `cod_banco` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cambio_moneda`
--
ALTER TABLE `cambio_moneda`
  MODIFY `cod_cambio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `cod_cargo` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `cod_ciudad` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cod_cliente` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `cuenta_banco`
--
ALTER TABLE `cuenta_banco`
  MODIFY `cod_cuenta` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalle_despacho`
--
ALTER TABLE `detalle_despacho`
  MODIFY `cod_detalledespacho` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalle_pago`
--
ALTER TABLE `detalle_pago`
  MODIFY `cod_detallepago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `envio`
--
ALTER TABLE `envio`
  MODIFY `cod_envio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `cod_estado` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `gastos_funcionales`
--
ALTER TABLE `gastos_funcionales`
  MODIFY `cod_gasto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `cod_marca` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  MODIFY `cod_metodo` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `modelo`
--
ALTER TABLE `modelo`
  MODIFY `cod_modelo` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `moneda`
--
ALTER TABLE `moneda`
  MODIFY `cod_moneda` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `municipio`
--
ALTER TABLE `municipio`
  MODIFY `cod_municipio` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `cod_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `parroquia`
--
ALTER TABLE `parroquia`
  MODIFY `cod_parroquia` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `precio_kilometraje`
--
ALTER TABLE `precio_kilometraje`
  MODIFY `cod_preciokilometraje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `cod_rol` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `cod_ubicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  MODIFY `cod_unidad` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  MODIFY `cod_vehiculo` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
-- Filtros para la tabla `cuenta_banco`
--
ALTER TABLE `cuenta_banco`
  ADD CONSTRAINT `cuenta_banco_ibfk_1` FOREIGN KEY (`cod_banco`) REFERENCES `banco` (`cod_banco`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `despacho`
--
ALTER TABLE `despacho`
  ADD CONSTRAINT `despacho_ibfk_2` FOREIGN KEY (`cod_vehiculo`) REFERENCES `vehiculo` (`cod_vehiculo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `despacho_ibfk_3` FOREIGN KEY (`cod_detalledespacho`) REFERENCES `detalle_despacho` (`cod_detalledespacho`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `despacho_ibfk_4` FOREIGN KEY (`cod_empleado`) REFERENCES `empleado` (`cod_empleado`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `envio_ibfk_3` FOREIGN KEY (`cod_despacho`) REFERENCES `despacho` (`cod_despacho`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `envio_ibfk_4` FOREIGN KEY (`cod_unidadmedida`) REFERENCES `unidad_medida` (`cod_unidad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `envio_ibfk_5` FOREIGN KEY (`cod_gasto`) REFERENCES `gastos_funcionales` (`cod_gasto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `envio_ibfk_6` FOREIGN KEY (`cod_preciokilometraje`) REFERENCES `precio_kilometraje` (`cod_preciokilometraje`) ON DELETE CASCADE ON UPDATE CASCADE;

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
