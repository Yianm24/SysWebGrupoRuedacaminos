-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-08-2026 a las 23:13:37
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
  `nombre` varchar(60) NOT NULL,
  `cod_municipio` int(2) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(23, 3333, 'Juana', 'pereira', '312123', 'mamdasmdska@ANSDMSAD', 'E', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_banco`
--

CREATE TABLE `cuenta_banco` (
  `cod_cuenta` int(1) NOT NULL,
  `propietario` varchar(50) NOT NULL,
  `etiqueta` varchar(15) NOT NULL,
  `numero_cuenta` varchar(4) NOT NULL,
  `cod_banco` int(2) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuenta_banco`
--

INSERT INTO `cuenta_banco` (`cod_cuenta`, `propietario`, `etiqueta`, `numero_cuenta`, `cod_banco`, `estado`) VALUES
(1, 'Oswaldo', 'P2P', '5454', 2, 1),
(2, '04123838383', '', '0112', 2, 1),
(3, '04123838383', 'Popular', '0103', 1, 1),
(4, '415263', '', '7894', 2, 1),
(5, 'Ruben Perez', 'Pago Movil', '1234', 3, 1),
(6, 'Prueba', 'Transferencia', '1212', 2, 0),
(7, 'Prueba2', 'Pagomovil', '5555', 1, 1),
(8, 'Maria Oropeza', 'MovilPago', '4545', 1, 1),
(9, 'Praba', 'P2P', '0103', 1, 1),
(10, 'YOMYOM', 'P2P', '0103', 1, 0),
(11, 'Hola', 'PagoMV', '5666', 1, 1),
(12, 'YAN', 'POL', '0103', 1, 1),
(13, 'Ruben', 'Popular', '8904', 1, 1),
(14, 'YAN', 'MOlgol', '5656', 2, 1);

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
  `nombre` varchar(16) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`cod_estado`, `nombre`, `estado`) VALUES
(1, 'Amazonas', 1),
(2, 'Anzoátegui', 1),
(3, 'Apure', 1),
(4, 'Aragua', 1),
(5, 'Barinas', 1),
(6, 'Bolívar', 1),
(7, 'Carabobo', 1),
(8, 'Cojedes', 1),
(9, 'Delta Amacuro', 1),
(10, 'Distrito Capital', 1),
(11, 'Falcón', 1),
(12, 'Guárico', 1),
(13, 'La Guaira', 1),
(14, 'Lara', 1),
(15, 'Mérida', 1),
(16, 'Miranda', 1),
(17, 'Monagas', 1),
(18, 'Nueva Esparta', 1),
(19, 'Portuguesa', 1),
(20, 'Sucre', 1),
(21, 'Táchira', 1),
(22, 'Trujillo', 1),
(23, 'Yaracuy', 1),
(24, 'Zulia', 1);

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
(5, 'Paypal', 1, 1),
(6, 'Juan', 3, 0);

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
  `cod_municipio` int(3) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `cod_estado` int(2) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `municipio`
--

INSERT INTO `municipio` (`cod_municipio`, `nombre`, `cod_estado`, `estado`) VALUES
(1, 'Alto Orinoco', 1, 1),
(2, 'Atabapo', 1, 1),
(3, 'Atures', 1, 1),
(4, 'Autana', 1, 1),
(5, 'Manapiare', 1, 1),
(6, 'Maroa', 1, 1),
(7, 'Río Negro', 1, 1),
(8, 'Anaco', 2, 1),
(9, 'Aragua', 2, 1),
(10, 'Simón Bolívar', 2, 1),
(11, 'Manuel Ezequiel Bruzual', 2, 1),
(12, 'Juan Manuel Cajigal', 2, 1),
(13, 'Francisco del Carmen Carvajal', 2, 1),
(14, 'Diego Bautista Urbaneja', 2, 1),
(15, 'Pedro María Freites', 2, 1),
(16, 'San José de Guanipa', 2, 1),
(17, 'Guanta', 2, 1),
(18, 'Independencia', 2, 1),
(19, 'Libertad', 2, 1),
(20, 'Sir Arthur McGregor', 2, 1),
(21, 'Francisco de Miranda', 2, 1),
(22, 'José Tadeo Monagas', 2, 1),
(23, 'Fernando de Peñalver', 2, 1),
(24, 'Píritu', 2, 1),
(25, 'San Juan Capistrano', 2, 1),
(26, 'Santa Ana', 2, 1),
(27, 'Simón Rodríguez', 2, 1),
(28, 'Juan Antonio Sotillo', 2, 1),
(29, 'Achaguas', 3, 1),
(30, 'Biruaca', 3, 1),
(31, 'Pedro Camejo', 3, 1),
(32, 'Muñoz', 3, 1),
(33, 'José Antonio Páez', 3, 1),
(34, 'Rómulo Gallegos', 3, 1),
(35, 'San Fernando', 3, 1),
(36, 'Bolívar', 4, 1),
(37, 'Camatagua', 4, 1),
(38, 'Francisco Linares Alcántara', 4, 1),
(39, 'Girardot', 4, 1),
(40, 'José Ángel Lamas', 4, 1),
(41, 'José Félix Ribas', 4, 1),
(42, 'José Rafael Revenga', 4, 1),
(43, 'Libertador', 4, 1),
(44, 'Mario Briceño Iragorry', 4, 1),
(45, 'Ocumare de la Costa de Oro', 4, 1),
(46, 'San Casimiro', 4, 1),
(47, 'San Sebastián', 4, 1),
(48, 'Santiago Mariño', 4, 1),
(49, 'Sucre', 4, 1),
(50, 'Tovar', 4, 1),
(51, 'Urdaneta', 4, 1),
(52, 'Ezequiel Zamora', 4, 1),
(53, 'Alberto Arvelo Torrealba', 5, 1),
(54, 'Andrés Eloy Blanco', 5, 1),
(55, 'Antonio José de Sucre', 5, 1),
(56, 'Arismendi', 5, 1),
(57, 'Barinas', 5, 1),
(58, 'Bolívar', 5, 1),
(59, 'Cruz Paredes', 5, 1),
(60, 'Ezequiel Zamora', 5, 1),
(61, 'Obispos', 5, 1),
(62, 'Pedraza', 5, 1),
(63, 'Rojas', 5, 1),
(64, 'Sosa', 5, 1),
(65, 'Bolivariano Angostura', 6, 1),
(66, 'Caroní', 6, 1),
(67, 'Cedeño', 6, 1),
(68, 'El Callao', 6, 1),
(69, 'Gran Sabana', 6, 1),
(70, 'Angostura del Orinoco', 6, 1),
(71, 'Padre Pedro Chien', 6, 1),
(72, 'Piar', 6, 1),
(73, 'Roscio', 6, 1),
(74, 'Sifontes', 6, 1),
(75, 'Sucre', 6, 1),
(76, 'Bejuma', 7, 1),
(77, 'Carlos Arvelo', 7, 1),
(78, 'Diego Ibarra', 7, 1),
(79, 'Guacara', 7, 1),
(80, 'Juan José Mora', 7, 1),
(81, 'Libertador', 7, 1),
(82, 'Los Guayos', 7, 1),
(83, 'Miranda', 7, 1),
(84, 'Montalbán', 7, 1),
(85, 'Naguanagua', 7, 1),
(86, 'Puerto Cabello', 7, 1),
(87, 'San Diego', 7, 1),
(88, 'San Joaquín', 7, 1),
(89, 'Valencia', 7, 1),
(90, 'Anzoátegui', 8, 1),
(91, 'Falcón', 8, 1),
(92, 'Girardot', 8, 1),
(93, 'Lima Blanco', 8, 1),
(94, 'Pao de San Juan Bautista', 8, 1),
(95, 'Ricaurte', 8, 1),
(96, 'Rómulo Gallegos', 8, 1),
(97, 'San Carlos', 8, 1),
(98, 'Tinaco', 8, 1),
(99, 'Antonio Díaz', 9, 1),
(100, 'Casacoima', 9, 1),
(101, 'Pedernales', 9, 1),
(102, 'Tucupita', 9, 1),
(103, 'Libertador', 10, 1),
(104, 'Acosta', 11, 1),
(105, 'Bolívar', 11, 1),
(106, 'Buchivacoa', 11, 1),
(107, 'Cacique Manaure', 11, 1),
(108, 'Carirubana', 11, 1),
(109, 'Colina', 11, 1),
(110, 'Dabajuro', 11, 1),
(111, 'Democracia', 11, 1),
(112, 'Falcón', 11, 1),
(113, 'Federación', 11, 1),
(114, 'Jacura', 11, 1),
(115, 'Los Taques', 11, 1),
(116, 'Mauroa', 11, 1),
(117, 'Miranda', 11, 1),
(118, 'Monseñor Iturriza', 11, 1),
(119, 'Palmasola', 11, 1),
(120, 'Petit', 11, 1),
(121, 'Píritu', 11, 1),
(122, 'San Francisco', 11, 1),
(123, 'José Laurencio Silva', 11, 1),
(124, 'Sucre', 11, 1),
(125, 'Tocópero', 11, 1),
(126, 'Unión', 11, 1),
(127, 'Urumaco', 11, 1),
(128, 'Zamora', 11, 1),
(129, 'Camaguán', 12, 1),
(130, 'Chaguaramas', 12, 1),
(131, 'El Socorro', 12, 1),
(132, 'Francisco de Miranda', 12, 1),
(133, 'José Félix Ribas', 12, 1),
(134, 'José Tadeo Monagas', 12, 1),
(135, 'Juan Germán Roscio Nieves', 12, 1),
(136, 'Julián Mellado', 12, 1),
(137, 'Las Mercedes', 12, 1),
(138, 'Leonardo Infante', 12, 1),
(139, 'Ortiz', 12, 1),
(140, 'Pedro Zaraza', 12, 1),
(141, 'San Gerónimo de Guayabal', 12, 1),
(142, 'San José de Guaribe', 12, 1),
(143, 'Santa María de Ipire', 12, 1),
(144, 'Vargas', 13, 1),
(145, 'Andrés Eloy Blanco', 14, 1),
(146, 'Crespo', 14, 1),
(147, 'Iribarren', 14, 1),
(148, 'Jiménez', 14, 1),
(149, 'Morán', 14, 1),
(150, 'Palavecino', 14, 1),
(151, 'Simón Planas', 14, 1),
(152, 'Torres', 14, 1),
(153, 'Urdaneta', 14, 1),
(154, 'Alberto Adriani', 15, 1),
(155, 'Andrés Bello', 15, 1),
(156, 'Antonio Pinto Salinas', 15, 1),
(157, 'Aricagua', 15, 1),
(158, 'Arzobispo Chacón', 15, 1),
(159, 'Campo Elías', 15, 1),
(160, 'Caracciolo Parra Olmedo', 15, 1),
(161, 'Cardenal Quintero', 15, 1),
(162, 'Guaraque', 15, 1),
(163, 'Julio César Salas', 15, 1),
(164, 'Justo Briceño', 15, 1),
(165, 'Libertador', 15, 1),
(166, 'Miranda', 15, 1),
(167, 'Obispo Ramos de Lora', 15, 1),
(168, 'Padre Noguera', 15, 1),
(169, 'Pueblo Llano', 15, 1),
(170, 'Rangel', 15, 1),
(171, 'Rivas Dávila', 15, 1),
(172, 'Santos Marquina', 15, 1),
(173, 'Sucre', 15, 1),
(174, 'Tovar', 15, 1),
(175, 'Tulio Febres Cordero', 15, 1),
(176, 'Zea', 15, 1),
(177, 'Acevedo', 16, 1),
(178, 'Andrés Bello', 16, 1),
(179, 'Baruta', 16, 1),
(180, 'Brión', 16, 1),
(181, 'Buroz', 16, 1),
(182, 'Carrizal', 16, 1),
(183, 'Chacao', 16, 1),
(184, 'Cristóbal Rojas', 16, 1),
(185, 'El Hatillo', 16, 1),
(186, 'Guaicaipuro', 16, 1),
(187, 'Independencia', 16, 1),
(188, 'Tomás Lander', 16, 1),
(189, 'Los Salias', 16, 1),
(190, 'José Antonio Páez', 16, 1),
(191, 'Paz Castillo', 16, 1),
(192, 'Pedro Gual', 16, 1),
(193, 'Plaza', 16, 1),
(194, 'Simón Bolívar', 16, 1),
(195, 'Sucre', 16, 1),
(196, 'Urdaneta', 16, 1),
(197, 'Zamora', 16, 1),
(198, 'Acosta', 17, 1),
(199, 'Aguasay', 17, 1),
(200, 'Bolívar', 17, 1),
(201, 'Caripe', 17, 1),
(202, 'Cedeño', 17, 1),
(203, 'Ezequiel Zamora', 17, 1),
(204, 'Libertador', 17, 1),
(205, 'Maturín', 17, 1),
(206, 'Piar', 17, 1),
(207, 'Punceres', 17, 1),
(208, 'Santa Bárbara', 17, 1),
(209, 'Sotillo', 17, 1),
(210, 'Uracoa', 17, 1),
(211, 'Antolín del Campo', 18, 1),
(212, 'Arismendi', 18, 1),
(213, 'Díaz', 18, 1),
(214, 'García', 18, 1),
(215, 'Gómez', 18, 1),
(216, 'Maneiro', 18, 1),
(217, 'Marcano', 18, 1),
(218, 'Mariño', 18, 1),
(219, 'Península de Macanao', 18, 1),
(220, 'Tubores', 18, 1),
(221, 'Villalba', 18, 1),
(222, 'Agua Blanca', 19, 1),
(223, 'Araure', 19, 1),
(224, 'Esteller', 19, 1),
(225, 'Guanare', 19, 1),
(226, 'Guanarito', 19, 1),
(227, 'Monseñor José Vicente de Unda', 19, 1),
(228, 'Ospino', 19, 1),
(229, 'Páez', 19, 1),
(230, 'Papelón', 19, 1),
(231, 'San Genaro de Boconoí', 19, 1),
(232, 'San Rafael de Onoto', 19, 1),
(233, 'Santa Rosalía', 19, 1),
(234, 'Sucre', 19, 1),
(235, 'Turén', 19, 1),
(236, 'Andrés Eloy Blanco', 20, 1),
(237, 'Andrés Mata', 20, 1),
(238, 'Arismendi', 20, 1),
(239, 'Benítez', 20, 1),
(240, 'Bermúdez', 20, 1),
(241, 'Bolívar', 20, 1),
(242, 'Cajigal', 20, 1),
(243, 'Cruz Salmerón Acosta', 20, 1),
(244, 'Libertador', 20, 1),
(245, 'Mariño', 20, 1),
(246, 'Mejía', 20, 1),
(247, 'Montes', 20, 1),
(248, 'Ribero', 20, 1),
(249, 'Sucre', 20, 1),
(250, 'Valdez', 20, 1),
(251, 'Andrés Bello', 21, 1),
(252, 'Antonio Rómulo Costa', 21, 1),
(253, 'Ayacucho', 21, 1),
(254, 'Bolívar', 21, 1),
(255, 'Cárdenas', 21, 1),
(256, 'Córdoba', 21, 1),
(257, 'Fernández Feo', 21, 1),
(258, 'Francisco de Miranda', 21, 1),
(259, 'García de Hevia', 21, 1),
(260, 'Guásimos', 21, 1),
(261, 'Independencia', 21, 1),
(262, 'Jáuregui', 21, 1),
(263, 'José María Vargas', 21, 1),
(264, 'Junín', 21, 1),
(265, 'Libertad', 21, 1),
(266, 'Libertador', 21, 1),
(267, 'Lobatera', 21, 1),
(268, 'Michelena', 21, 1),
(269, 'Panamericano', 21, 1),
(270, 'Pedro María Ureña', 21, 1),
(271, 'Rafael Urdaneta', 21, 1),
(272, 'Samuel Darío Maldonado', 21, 1),
(273, 'San Cristóbal', 21, 1),
(274, 'San Judas Tadeo', 21, 1),
(275, 'Seboruco', 21, 1),
(276, 'Simón Rodríguez', 21, 1),
(277, 'Sucre', 21, 1),
(278, 'Torbes', 21, 1),
(279, 'Uribante', 21, 1),
(280, 'Andrés Bello', 22, 1),
(281, 'Boconó', 22, 1),
(282, 'Bolívar', 22, 1),
(283, 'Candelaria', 22, 1),
(284, 'Carache', 22, 1),
(285, 'Escuque', 22, 1),
(286, 'José Felipe Márquez Cañizales', 22, 1),
(287, 'Juan Vicente Campo Elías', 22, 1),
(288, 'La Ceiba', 22, 1),
(289, 'Márquez Bustillos', 22, 1),
(290, 'Miranda', 22, 1),
(291, 'Monte Carmelo', 22, 1),
(292, 'Motatán', 22, 1),
(293, 'Pampán', 22, 1),
(294, 'Pampanito', 22, 1),
(295, 'Rafael Rangel', 22, 1),
(296, 'San Rafael de Carvajal', 22, 1),
(297, 'Sucre', 22, 1),
(298, 'Trujillo', 22, 1),
(299, 'Urdaneta', 22, 1),
(300, 'Valera', 22, 1),
(301, 'Arístides Bastidas', 23, 1),
(302, 'Bolívar', 23, 1),
(303, 'Bruzual', 23, 1),
(304, 'Cocorote', 23, 1),
(305, 'Independencia', 23, 1),
(306, 'José Antonio Páez', 23, 1),
(307, 'La Trinidad', 23, 1),
(308, 'Manuel Monge', 23, 1),
(309, 'Nirgua', 23, 1),
(310, 'Peña', 23, 1),
(311, 'San Felipe', 23, 1),
(312, 'Sucre', 23, 1),
(313, 'Urachiche', 23, 1),
(314, 'Veroes', 23, 1),
(315, 'Almirante Padilla', 24, 1),
(316, 'Baralt', 24, 1),
(317, 'Cabimas', 24, 1),
(318, 'Catatumbo', 24, 1),
(319, 'Colón', 24, 1),
(320, 'Francisco Javier Pulgar', 24, 1),
(321, 'Jesús Enrique Lossada', 24, 1),
(322, 'Jesús María Semprún', 24, 1),
(323, 'La Cañada de Urdaneta', 24, 1),
(324, 'Lagunillas', 24, 1),
(325, 'Machiques de Perijá', 24, 1),
(326, 'Mara', 24, 1),
(327, 'Maracaibo', 24, 1),
(328, 'Miranda', 24, 1),
(329, 'Guajira', 24, 1),
(330, 'Rosario de Perijá', 24, 1),
(331, 'San Francisco', 24, 1),
(332, 'Santa Rita', 24, 1),
(333, 'Simón Bolívar', 24, 1),
(334, 'Sucre', 24, 1),
(335, 'Valmore Rodríguez', 24, 1);

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
  `cod_parroquia` int(4) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `cod_municipio` int(3) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `parroquia`
--

INSERT INTO `parroquia` (`cod_parroquia`, `nombre`, `cod_municipio`, `estado`) VALUES
(1, 'Alto Orinoco', 1, 1),
(2, 'Huachamacare', 1, 1),
(3, 'Marawaka', 1, 1),
(4, 'Mavaca', 1, 1),
(5, 'Sierra Parima', 1, 1),
(6, 'Ucata', 2, 1),
(7, 'Yapacana', 2, 1),
(8, 'Caname', 2, 1),
(9, 'Fernando Girón Tovar', 3, 1),
(10, 'Luis Alberto Gómez', 3, 1),
(11, 'Pahueña', 3, 1),
(12, 'Platanillal', 3, 1),
(13, 'Samariapo', 4, 1),
(14, 'Sipapo', 4, 1),
(15, 'Munduapo', 4, 1),
(16, 'Guayapo', 4, 1),
(17, 'Alto Ventuari', 5, 1),
(18, 'Medio Ventuari', 5, 1),
(19, 'Bajo Ventuari', 5, 1),
(20, 'Victorino', 6, 1),
(21, 'Comunidad', 6, 1),
(22, 'Casiquiare', 7, 1),
(23, 'Cocuy', 7, 1),
(24, 'San Carlos de Río Negro', 7, 1),
(25, 'Solano', 7, 1),
(26, 'Anaco', 8, 1),
(27, 'San Joaquín', 8, 1),
(28, 'Cachipo', 9, 1),
(29, 'Aragua de Barcelona', 9, 1),
(30, 'El Carmen', 10, 1),
(31, 'San Cristóbal', 10, 1),
(32, 'Bergantín', 10, 1),
(33, 'Caigua', 10, 1),
(34, 'El Pilar', 10, 1),
(35, 'Naricual', 10, 1),
(36, 'Valle de Guanape', 11, 1),
(37, 'Santa Bárbara', 11, 1),
(38, 'Clarines', 11, 1),
(39, 'Onoto', 12, 1),
(40, 'San Pablo', 12, 1),
(41, 'Valle de Guanape', 13, 1),
(42, 'Santa Bárbara', 13, 1),
(43, 'Lechería', 14, 1),
(44, 'El Morro', 14, 1),
(45, 'Cantaura', 15, 1),
(46, 'Libertador', 15, 1),
(47, 'Santa Rosa', 15, 1),
(48, 'Urica', 15, 1),
(49, 'San José de Guanipa', 16, 1),
(50, 'Guanta', 17, 1),
(51, 'Chorrerón', 17, 1),
(52, 'Mamo', 18, 1),
(53, 'Soledad', 18, 1),
(54, 'San Mateo', 19, 1),
(55, 'El Carito', 19, 1),
(56, 'Santa Inés', 19, 1),
(57, 'La Romereña', 19, 1),
(58, 'El Chaparro', 20, 1),
(59, 'Tomás Alfaro', 20, 1),
(60, 'Calatrava', 20, 1),
(61, 'Pariaguán', 21, 1),
(62, 'Atapirire', 21, 1),
(63, 'Boca del Pao', 21, 1),
(64, 'El Pao', 21, 1),
(65, 'Mapire', 22, 1),
(66, 'Piar', 22, 1),
(67, 'Santa Clara', 22, 1),
(68, 'San Diego de Cabrutica', 22, 1),
(69, 'Uverito', 22, 1),
(70, 'Zuata', 22, 1),
(71, 'Puerto Píritu', 23, 1),
(72, 'San Miguel', 23, 1),
(73, 'Sucre', 23, 1),
(74, 'Píritu', 24, 1),
(75, 'San Francisco', 24, 1),
(76, 'Boca de Uchire', 25, 1),
(77, 'Boca de Chávez', 25, 1),
(78, 'Pueblo Nuevo', 26, 1),
(79, 'Santa Ana', 26, 1),
(80, 'Edmundo Barrios', 27, 1),
(81, 'Miguel Otero Silva', 27, 1),
(82, 'Puerto La Cruz', 28, 1),
(83, 'Pozuelos', 28, 1),
(84, 'Achaguas', 29, 1),
(85, 'Apurito', 29, 1),
(86, 'El Yagual', 29, 1),
(87, 'Guachara', 29, 1),
(88, 'Mucuritas', 29, 1),
(89, 'Queseras del Medio', 29, 1),
(90, 'Biruaca', 30, 1),
(91, 'San Juan de Payara', 31, 1),
(92, 'Codazzi', 31, 1),
(93, 'Cunaviche', 31, 1),
(94, 'Bruzual', 32, 1),
(95, 'Mantecal', 32, 1),
(96, 'Quintero', 32, 1),
(97, 'Rincón Hondo', 32, 1),
(98, 'San Vicente', 32, 1),
(99, 'Guasdualito', 33, 1),
(100, 'Aramendi', 33, 1),
(101, 'El Amparo', 33, 1),
(102, 'San Camilo', 33, 1),
(103, 'Urdaneta', 33, 1),
(104, 'Elorza', 34, 1),
(105, 'La Trinidad', 34, 1),
(106, 'San Fernando', 35, 1),
(107, 'El Recreo', 35, 1),
(108, 'Peñalver', 35, 1),
(109, 'San Rafael de Atamaica', 35, 1),
(110, 'Altagracia', 104, 1),
(111, 'Antímano', 104, 1),
(112, 'Candelaria', 104, 1),
(113, 'Caricuao', 104, 1),
(114, 'Catedral', 104, 1),
(115, 'Coche', 104, 1),
(116, 'El Valle', 104, 1),
(117, 'El Recreo', 104, 1),
(118, 'La Pastora', 104, 1),
(119, 'La Vega', 104, 1),
(120, 'Macarao', 104, 1),
(121, 'San Agustín', 104, 1),
(122, 'San Bernardino', 104, 1),
(123, 'San Juan', 104, 1),
(124, 'San Pedro', 104, 1),
(125, 'Santa Rosalía', 104, 1),
(126, 'Santa Teresa', 104, 1),
(127, 'Sucre (Catia)', 104, 1),
(128, '23 de Enero', 104, 1),
(129, 'El Paraíso', 104, 1),
(130, 'San José', 104, 1),
(131, 'Macarao', 104, 1),
(132, 'San Mateo', 36, 1),
(133, 'Camatagua', 37, 1),
(134, 'Carmen de Cura', 37, 1),
(135, 'Santa Rita', 38, 1),
(136, 'Francisco de Miranda', 38, 1),
(137, 'Monseñor Feliciano González', 38, 1),
(138, 'Pedro José Ovalles', 39, 1),
(139, 'Joaquín Crespo', 39, 1),
(140, 'José Casanova Godoy', 39, 1),
(141, 'Madre María de San José', 39, 1),
(142, 'Andrés Eloy Blanco', 39, 1),
(143, 'Los Tacariguas', 39, 1),
(144, 'Las Delicias', 39, 1),
(145, 'Choroní', 39, 1),
(146, 'Santa Cruz', 40, 1),
(147, 'José Félix Ribas', 41, 1),
(148, 'Castor Nieves Ríos', 41, 1),
(149, 'Las Guacamayas', 41, 1),
(150, 'Pao de Zárate', 41, 1),
(151, 'Zuata', 41, 1),
(152, 'José Rafael Revenga', 42, 1),
(153, 'Palo Negro', 43, 1),
(154, 'San Martín de Porres', 43, 1),
(155, 'El Limón', 44, 1),
(156, 'Caña de Azúcar', 44, 1),
(157, 'Ocumare de la Costa', 45, 1),
(158, 'San Casimiro', 46, 1),
(159, 'Güiripa', 46, 1),
(160, 'Ollas de Caramacate', 46, 1),
(161, 'Valle Morín', 46, 1),
(162, 'San Sebastián', 47, 1),
(163, 'Turmero', 48, 1),
(164, 'Arevalo Aponte', 48, 1),
(165, 'Chuao', 48, 1),
(166, 'Samán de Güere', 48, 1),
(167, 'Alfredo Pacheco Miranda', 48, 1),
(168, 'Cagua', 49, 1),
(169, 'Bella Vista', 49, 1),
(170, 'Colonia Tovar', 50, 1),
(171, 'Barbacoas', 51, 1),
(172, 'Las Peñitas', 51, 1),
(173, 'San Francisco de Cara', 51, 1),
(174, 'Taguay', 51, 1),
(175, 'Villa de Cura', 52, 1),
(176, 'Magdaleno', 52, 1),
(177, 'San Francisco de Asís', 52, 1),
(178, 'Valles de Tucutunemo', 52, 1),
(179, 'Augusto Mijares', 52, 1),
(180, 'Sabaneta', 53, 1),
(181, 'Juan Antonio Rodríguez Domínguez', 53, 1),
(182, 'El Cantón', 54, 1),
(183, 'Santa Cruz de Guacas', 54, 1),
(184, 'Puerto Vivas', 54, 1),
(185, 'Ticoporo', 55, 1),
(186, 'Andrés Bello', 55, 1),
(187, 'Nicolás Pulido', 55, 1),
(188, 'Arismendi', 56, 1),
(189, 'Guadarrama', 56, 1),
(190, 'La Unión', 56, 1),
(191, 'San Antonio', 56, 1),
(192, 'Barinas', 57, 1),
(193, 'Alberto Arvelo Larriva', 57, 1),
(194, 'San Silvestre', 57, 1),
(195, 'Santa Inés', 57, 1),
(196, 'Santa Lucía', 57, 1),
(197, 'Torunos', 57, 1),
(198, 'El Carmen', 57, 1),
(199, 'Rómulo Betancourt', 57, 1),
(200, 'Corazón de Jesús', 57, 1),
(201, 'Ramón Ignacio Méndez', 57, 1),
(202, 'Alto Barinas', 57, 1),
(203, 'Manuel Palacio Fajardo', 57, 1),
(204, 'Juan Antonio Rodríguez Domínguez', 57, 1),
(205, 'Dominga Ortiz de Páez', 57, 1),
(206, 'Barinitas', 58, 1),
(207, 'Altamira de Cáceres', 58, 1),
(208, 'Calderas', 58, 1),
(209, 'Barrancas', 59, 1),
(210, 'El Socorro', 59, 1),
(211, 'Masparrito', 59, 1),
(212, 'Santa Bárbara', 60, 1),
(213, 'Pedro Briceño Méndez', 60, 1),
(214, 'Ramón Ignacio Méndez', 60, 1),
(215, 'José Ignacio del Pumar', 60, 1),
(216, 'Obispos', 61, 1),
(217, 'Guadarrama', 61, 1),
(218, 'El Real', 61, 1),
(219, 'La Luz', 61, 1),
(220, 'Ciudad Bolivia', 62, 1),
(221, 'José Ignacio del Pumar', 62, 1),
(222, 'Ignacio Briceño', 62, 1),
(223, 'Páez', 62, 1),
(224, 'Libertad', 63, 1),
(225, 'Dolores', 63, 1),
(226, 'Santa Rosa', 63, 1),
(227, 'Palacios Fajardo', 63, 1),
(228, 'Ciudad de Nutrias', 64, 1),
(229, 'El Regalo', 64, 1),
(230, 'Puerto de Nutrias', 64, 1),
(231, 'Santa Catalina', 64, 1),
(232, 'Ciudad Piar', 65, 1),
(233, 'San Francisco', 65, 1),
(234, 'Barceloneta', 65, 1),
(235, 'Santa Bárbara', 65, 1),
(236, 'Cachamay', 66, 1),
(237, 'Chirica', 66, 1),
(238, 'Dalla Costa', 66, 1),
(239, 'Once de Abril', 66, 1),
(240, 'Simón Bolívar', 66, 1),
(241, 'Unare', 66, 1),
(242, 'Universidad', 66, 1),
(243, 'Vista al Sol', 66, 1),
(244, 'Pozo Verde', 66, 1),
(245, 'Yocoima', 66, 1),
(246, '5 de Julio', 66, 1),
(247, 'Caicara del Orinoco', 67, 1),
(248, 'Altagracia', 67, 1),
(249, 'Ascensión Farreras', 67, 1),
(250, 'Guaniamo', 67, 1),
(251, 'La Urbana', 67, 1),
(252, 'Pijiguaos', 67, 1),
(253, 'El Callao', 68, 1),
(254, 'Santa Elena de Uairén', 69, 1),
(255, 'Ikabarú', 69, 1),
(256, 'Catedral', 70, 1),
(257, 'Zea', 70, 1),
(258, 'Orinoco', 70, 1),
(259, 'José Antonio Páez', 70, 1),
(260, 'Marhuanta', 70, 1),
(261, 'Agua Salada', 70, 1),
(262, 'Vista Hermosa', 70, 1),
(263, 'La Sabanita', 70, 1),
(264, 'Panapana', 70, 1),
(265, 'Andrés Eloy Blanco', 71, 1),
(266, 'Pedro Cova', 71, 1),
(267, 'Upata', 72, 1),
(268, 'Andrés Eloy Blanco', 72, 1),
(269, 'Pedro Cova', 72, 1),
(270, 'Guasipati', 73, 1),
(271, 'Salom', 73, 1),
(272, 'Tumeremo', 74, 1),
(273, 'Dalla Costa', 74, 1),
(274, 'San Isidro', 74, 1),
(275, 'Maripa', 75, 1),
(276, 'Aripao', 75, 1),
(277, 'Guarataro', 75, 1),
(278, 'Las Majadas', 75, 1),
(279, 'Moitaco', 75, 1),
(280, 'Bejuma', 76, 1),
(281, 'Canoabo', 76, 1),
(282, 'Simón Bolívar', 76, 1),
(283, 'Güigüe', 77, 1),
(284, 'Belén', 77, 1),
(285, 'Tacarigua', 77, 1),
(286, 'Mariara', 78, 1),
(287, 'Aguas Calientes', 78, 1),
(288, 'Guacara', 79, 1),
(289, 'Ciudad Alianza', 79, 1),
(290, 'Yagua', 79, 1),
(291, 'Morón', 80, 1),
(292, 'Urama', 80, 1),
(293, 'Tocuyito', 81, 1),
(294, 'Independencia', 81, 1),
(295, 'Los Guayos', 82, 1),
(296, 'Miranda', 83, 1),
(297, 'Montalbán', 84, 1),
(298, 'Naguanagua', 85, 1),
(299, 'Bartolomé Salom', 86, 1),
(300, 'Democracia', 86, 1),
(301, 'Fraternidad', 86, 1),
(302, 'Goaigoaza', 86, 1),
(303, 'Juan José Flores', 86, 1),
(304, 'Unión', 86, 1),
(305, 'Borburata', 86, 1),
(306, 'Patanemo', 86, 1),
(307, 'San Diego', 87, 1),
(308, 'San Joaquín', 88, 1),
(309, 'Candelaria', 89, 1),
(310, 'Catedral', 89, 1),
(311, 'El Socorro', 89, 1),
(312, 'Miguel Peña', 89, 1),
(313, 'Rafael Urdaneta', 89, 1),
(314, 'San Blas', 89, 1),
(315, 'San José', 89, 1),
(316, 'Santa Rosa', 89, 1),
(317, 'Negro Primero', 89, 1),
(318, 'Cojedes', 90, 1),
(319, 'Juan de Mata Suárez', 90, 1),
(320, 'Tinaquillo', 91, 1),
(321, 'El Baúl', 92, 1),
(322, 'Sucre', 92, 1),
(323, 'Macapo', 93, 1),
(324, 'La Aguadita', 93, 1),
(325, 'El Pao', 94, 1),
(326, 'El Amparo', 95, 1),
(327, 'Libertad de Cojedes', 95, 1),
(328, 'Las Vegas', 96, 1),
(329, 'San Carlos de Austria', 97, 1),
(330, 'Juan Ángel Bravo', 97, 1),
(331, 'Manuel Manrique', 97, 1),
(332, 'General en Jefe José Laurencio Silva', 98, 1),
(333, 'Curiapo', 99, 1),
(334, 'Almirante Luis Brión', 99, 1),
(335, 'Francisco Aniceto Lugo', 99, 1),
(336, 'Manuel Renaud', 99, 1),
(337, 'Padre Barral', 99, 1),
(338, 'Santos de Abelgas', 99, 1),
(339, 'Imataca', 100, 1),
(340, 'Cinco de Julio', 100, 1),
(341, 'Juan Bautista Arismendi', 100, 1),
(342, 'Manuel Piar', 100, 1),
(343, 'Rómulo Gallegos', 100, 1),
(344, 'Pedernales', 101, 1),
(345, 'Luis Beltrán Prieto Figueroa', 101, 1),
(346, 'San José', 102, 1),
(347, 'José Vidal Marcano', 102, 1),
(348, 'Juan Millán', 102, 1),
(349, 'Leonardo Ruíz Pineda', 102, 1),
(350, 'Mariscal Antonio José de Sucre', 102, 1),
(351, 'Monseñor Argimiro García', 102, 1),
(352, 'San Rafael', 102, 1),
(353, 'Virgen del Valle', 102, 1),
(354, 'Capadare', 104, 1),
(355, 'La Pastora', 104, 1),
(356, 'Libertador', 104, 1),
(357, 'San Juan de los Cayos', 104, 1),
(358, 'Aracua', 105, 1),
(359, 'La Peña', 105, 1),
(360, 'San Luis', 105, 1),
(361, 'Bariro', 106, 1),
(362, 'Borojó', 106, 1),
(363, 'Capatárida', 106, 1),
(364, 'Guajiro', 106, 1),
(365, 'Seque', 106, 1),
(366, 'Zazárida', 106, 1),
(367, 'Cacique Manaure', 107, 1),
(368, 'Norte', 108, 1),
(369, 'Carirubana', 108, 1),
(370, 'Santa Ana', 108, 1),
(371, 'Punta Cardón', 108, 1),
(372, 'La Vela de Coro', 109, 1),
(373, 'Acurigua', 109, 1),
(374, 'Guaibacoa', 109, 1),
(375, 'Las Calderas', 109, 1),
(376, 'Macoruca', 109, 1),
(377, 'Dabajuro', 110, 1),
(378, 'Agua Clara', 111, 1),
(379, 'Avaria', 111, 1),
(380, 'Pedregal', 111, 1),
(381, 'Piedra Grande', 111, 1),
(382, 'Purureche', 111, 1),
(383, 'Adícora', 112, 1),
(384, 'Baraived', 112, 1),
(385, 'Buena Vista', 112, 1),
(386, 'Jadacaquiva', 112, 1),
(387, 'El Vínculo', 112, 1),
(388, 'El Hato', 112, 1),
(389, 'Moruy', 112, 1),
(390, 'Pueblo Nuevo', 112, 1),
(391, 'San José de la Costa', 112, 1),
(392, 'Agua Larga', 113, 1),
(393, 'El Churuguara', 113, 1),
(394, 'Independencia', 113, 1),
(395, 'Mapararí', 113, 1),
(396, 'Tupí', 113, 1),
(397, 'Agua Linda', 114, 1),
(398, 'Araurima', 114, 1),
(399, 'Jacura', 114, 1),
(400, 'Los Taques', 115, 1),
(401, 'Judibana', 115, 1),
(402, 'Casigua', 116, 1),
(403, 'Mene de Mauroa', 116, 1),
(404, 'San Félix', 116, 1),
(405, 'San Antonio', 117, 1),
(406, 'San Gabriel', 117, 1),
(407, 'Santa Ana', 117, 1),
(408, 'Guzmán Guillermo', 117, 1),
(409, 'Mitare', 117, 1),
(410, 'Sabaneta', 117, 1),
(411, 'Río Seco', 117, 1),
(412, 'Boca de Tocuyo', 118, 1),
(413, 'Chichiriviche', 118, 1),
(414, 'Tocuyo de la Costa', 118, 1),
(415, 'Palmasola', 119, 1),
(416, 'Cabure', 120, 1),
(417, 'Colina', 120, 1),
(418, 'Curimagua', 120, 1),
(419, 'San José de la Costa', 121, 1),
(420, 'Píritu', 121, 1),
(421, 'Mirimire', 122, 1),
(422, 'Tucacas', 123, 1),
(423, 'Boca de Aroa', 123, 1),
(424, 'Sucre', 124, 1),
(425, 'Pecaya', 124, 1),
(426, 'Tocópero', 125, 1),
(427, 'El Charal', 126, 1),
(428, 'Las Vegas del Tuy', 126, 1),
(429, 'Santa Cruz de Bucaral', 126, 1),
(430, 'Bruzual', 127, 1),
(431, 'Urumaco', 127, 1),
(432, 'Puerto Cumarebo', 128, 1),
(433, 'La Ciénaga', 128, 1),
(434, 'La Macolla', 128, 1),
(435, 'Pueblo Cumarebo', 128, 1),
(436, 'Zazárida', 128, 1),
(437, 'Camaguán', 129, 1),
(438, 'Puerto Miranda', 129, 1),
(439, 'Uverito', 129, 1),
(440, 'Chaguaramas', 130, 1),
(441, 'El Socorro', 131, 1),
(442, 'Calabozo', 132, 1),
(443, 'El Rastro', 132, 1),
(444, 'Guardatinajas', 132, 1),
(445, 'Tucupido', 133, 1),
(446, 'San Rafael de Laya', 133, 1),
(447, 'Altagracia de Orituco', 134, 1),
(448, 'San Rafael de Orituco', 134, 1),
(449, 'San Francisco Javier de Lezama', 134, 1),
(450, 'Paso Real de Macaira', 134, 1),
(451, 'Carlos Soublette', 134, 1),
(452, 'San Francisco de Macaira', 134, 1),
(453, 'Libertad de Orituco', 134, 1),
(454, 'San Juan de los Morros', 135, 1),
(455, 'Cantagallo', 135, 1),
(456, 'Parapara', 135, 1),
(457, 'El Sombrero', 136, 1),
(458, 'Sosa', 136, 1),
(459, 'Las Mercedes', 137, 1),
(460, 'Santa Rita de Manapire', 137, 1),
(461, 'Cabruta', 137, 1),
(462, 'Valle de la Pascua', 138, 1),
(463, 'Espino', 138, 1),
(464, 'Ortiz', 139, 1),
(465, 'San José de Tiznados', 139, 1),
(466, 'San Francisco de Tiznados', 139, 1),
(467, 'San Lorenzo de Tiznados', 139, 1),
(468, 'Zaraza', 140, 1),
(469, 'San José de Unare', 140, 1),
(470, 'Guayabal', 141, 1),
(471, 'Cazorla', 141, 1),
(472, 'San José de Guaribe', 142, 1),
(473, 'Santa María de Ipire', 143, 1),
(474, 'Altamira', 143, 1),
(475, 'Caraballeda', 144, 1),
(476, 'Carayaca', 144, 1),
(477, 'Carlos Soublette', 144, 1),
(478, 'Caruao', 144, 1),
(479, 'Catia La Mar', 144, 1),
(480, 'El Junko', 144, 1),
(481, 'La Guaira', 144, 1),
(482, 'Macuto', 144, 1),
(483, 'Maiquetía', 144, 1),
(484, 'Naiguatá', 144, 1),
(485, 'Urimare', 144, 1),
(486, 'Quebrada Honda de Guache', 145, 1),
(487, 'Pío Tamayo', 145, 1),
(488, 'Yacambú', 145, 1),
(489, 'Freitez', 146, 1),
(490, 'José María Blanco', 146, 1),
(491, 'Aguedo Felipe Alvarado', 147, 1),
(492, 'Buena Vista', 147, 1),
(493, 'Catedral', 147, 1),
(494, 'Concepción', 147, 1),
(495, 'El Cují', 147, 1),
(496, 'Juárez', 147, 1),
(497, 'Ana Soto', 147, 1),
(498, 'Santa Rosa', 147, 1),
(499, 'Tamaca', 147, 1),
(500, 'Unión', 147, 1),
(501, 'Juan Bautista Rodríguez', 148, 1),
(502, 'Cuara', 148, 1),
(503, 'Diego de Lozada', 148, 1),
(504, 'Paraíso de San José', 148, 1),
(505, 'San Miguel', 148, 1),
(506, 'Tintorero', 148, 1),
(507, 'Anzoátegui', 149, 1),
(508, 'Bolívar', 149, 1),
(509, 'Guárico', 149, 1),
(510, 'Hilario Luna y Luna', 149, 1),
(511, 'Humocaro Alto', 149, 1),
(512, 'Humocaro Bajo', 149, 1),
(513, 'La Candelaria', 149, 1),
(514, 'Morán', 149, 1),
(515, 'Cabudare', 150, 1),
(516, 'José Bernardo Dorante', 150, 1),
(517, 'Agua Viva', 150, 1),
(518, 'Buría', 151, 1),
(519, 'Gustavo Vegas León', 151, 1),
(520, 'Sarare', 151, 1),
(521, 'Altagracia', 152, 1),
(522, 'Antonio Díaz', 152, 1),
(523, 'Camacaro', 152, 1),
(524, 'Castañeda', 152, 1),
(525, 'Cecilio Zubillaga', 152, 1),
(526, 'Chiquinquirá', 152, 1),
(527, 'El Blanco', 152, 1),
(528, 'Espinoza de los Monteros', 152, 1),
(529, 'Lara', 152, 1),
(530, 'Las Mercedes', 152, 1),
(531, 'Manuel Morillo', 152, 1),
(532, 'Montaña Verde', 152, 1),
(533, 'Montes de Oca', 152, 1),
(534, 'Torres', 152, 1),
(535, 'Trinidad Samuel', 152, 1),
(536, 'Reyes Vargas', 152, 1),
(537, 'Siquisique', 153, 1),
(538, 'Moroturo', 153, 1),
(539, 'San Miguel', 153, 1),
(540, 'Xaguas', 153, 1),
(541, 'Presidente Betancourt', 154, 1),
(542, 'Presidente Páez', 154, 1),
(543, 'Presidente Rómulo Gallegos', 154, 1),
(544, 'Gabriel Picón González', 154, 1),
(545, 'Héctor Amengual', 154, 1),
(546, 'José Nucete Sardi', 154, 1),
(547, 'Pulido Méndez', 154, 1),
(548, 'La Azulita', 155, 1),
(549, 'Santa Cruz de Mora', 156, 1),
(550, 'Mesa Bolívar', 156, 1),
(551, 'Mesa de Las Palmas', 156, 1),
(552, 'Aricagua', 157, 1),
(553, 'San Antonio', 157, 1),
(554, 'Canaguá', 158, 1),
(555, 'Capurí', 158, 1),
(556, 'Chacantá', 158, 1),
(557, 'El Molino', 158, 1),
(558, 'Guaimaral', 158, 1),
(559, 'Mucutuy', 158, 1),
(560, 'Mucuchachí', 158, 1),
(561, 'Fernández Peña', 159, 1),
(562, 'Matriz', 159, 1),
(563, 'Montalbán', 159, 1),
(564, 'Acequias', 159, 1),
(565, 'Jají', 159, 1),
(566, 'La Mesa', 159, 1),
(567, 'San José del Sur', 159, 1),
(568, 'Tucaní', 160, 1),
(569, 'Florencio Ramírez', 160, 1),
(570, 'Las Piedras', 161, 1),
(571, 'Santo Domingo', 161, 1),
(572, 'Guaraque', 162, 1),
(573, 'Mesa de Quintero', 162, 1),
(574, 'Río Negro', 162, 1),
(575, 'Arapuey', 163, 1),
(576, 'Palmira', 163, 1),
(577, 'San Cristóbal de Torondoy', 164, 1),
(578, 'Torondoy', 164, 1),
(579, 'Antonio Spinetti Dini', 165, 1),
(580, 'Arias', 165, 1),
(581, 'Caracciolo Parra Pérez', 165, 1),
(582, 'Domingo Peña', 165, 1),
(583, 'El Llano', 165, 1),
(584, 'Gonzalo Picón Febres', 165, 1),
(585, 'Jacinto Plaza', 165, 1),
(586, 'Juan Rodríguez Suárez', 165, 1),
(587, 'Lasso de la Vega', 165, 1),
(588, 'Mariano Picón Salas', 165, 1),
(589, 'Milla', 165, 1),
(590, 'Osuna Rodríguez', 165, 1),
(591, 'Sagrario', 165, 1),
(592, 'El Morro', 165, 1),
(593, 'Los Nevados', 165, 1),
(594, 'Andrés Eloy Blanco', 166, 1),
(595, 'La Venta', 166, 1),
(596, 'Piñango', 166, 1),
(597, 'Timotes', 166, 1),
(598, 'Santa Elena de Arenales', 167, 1),
(599, 'Eloy Paredes', 167, 1),
(600, 'San Rafael de Alcázar', 167, 1),
(601, 'Santa María de Caparo', 168, 1),
(602, 'Pueblo Llano', 169, 1),
(603, 'Cacute', 170, 1),
(604, 'La Toma', 170, 1),
(605, 'Mucuchíes', 170, 1),
(606, 'Mucurubá', 170, 1),
(607, 'San Rafael', 170, 1),
(608, 'Bailadores', 171, 1),
(609, 'Gerónimo Maldonado', 171, 1),
(610, 'Tabay', 172, 1),
(611, 'Chiguará', 173, 1),
(612, 'Estánques', 173, 1),
(613, 'Lagunillas', 173, 1),
(614, 'La Trampa', 173, 1),
(615, 'Pueblo Nuevo del Sur', 173, 1),
(616, 'San Juan', 173, 1),
(617, 'El Amparo', 174, 1),
(618, 'El Llano', 174, 1),
(619, 'San Francisco', 174, 1),
(620, 'Tovar', 174, 1),
(621, 'Independencia', 175, 1),
(622, 'María de la Concepción Palacios Blanco', 175, 1),
(623, 'Nueva Bolivia', 175, 1),
(624, 'Santa Apolonia', 175, 1),
(625, 'Zea', 176, 1),
(626, 'Caño El Tigre', 176, 1),
(627, 'Aragüita', 177, 1),
(628, 'Arévalo González', 177, 1),
(629, 'Capaya', 177, 1),
(630, 'Caucagua', 177, 1),
(631, 'El Café', 177, 1),
(632, 'Marizapa', 177, 1),
(633, 'Panaquire', 177, 1),
(634, 'Ribas', 177, 1),
(635, 'Cumbo', 178, 1),
(636, 'San José de Barlovento', 178, 1),
(637, 'El Cafetal', 179, 1),
(638, 'Las Minas', 179, 1),
(639, 'Nuestra Señora del Rosario de Baruta', 179, 1),
(640, 'Higuerote', 180, 1),
(641, 'Curiepe', 180, 1),
(642, 'Tacarigua', 180, 1),
(643, 'Mamporal', 181, 1),
(644, 'Carrizal', 182, 1),
(645, 'Chacao', 183, 1),
(646, 'Charallave', 184, 1),
(647, 'Las Brisas', 184, 1),
(648, 'El Hatillo', 185, 1),
(649, 'Altagracia de la Montaña', 186, 1),
(650, 'Cecilio Acosta', 186, 1),
(651, 'El Jarillo', 186, 1),
(652, 'Los Teques', 186, 1),
(653, 'Paracotos', 186, 1),
(654, 'San Pedro', 186, 1),
(655, 'Tácata', 186, 1),
(656, 'Cartanal', 187, 1),
(657, 'Santa Teresa del Tuy', 187, 1),
(658, 'La Democracia', 188, 1),
(659, 'Ocumare del Tuy', 188, 1),
(660, 'Santa Bárbara', 188, 1),
(661, 'San Antonio de los Altos', 189, 1),
(662, 'El Guapo', 190, 1),
(663, 'Río Chico', 190, 1),
(664, 'San Fernando del Guapo', 190, 1),
(665, 'Tacarigua de la Laguna', 190, 1),
(666, 'Paparo', 190, 1),
(667, 'Santa Lucía del Tuy', 191, 1),
(668, 'Cúpira', 192, 1),
(669, 'Machurucuto', 192, 1),
(670, 'Guarenas', 193, 1),
(671, 'San Antonio de Yare', 194, 1),
(672, 'San Francisco de Yare', 194, 1),
(673, 'Leoncio Martínez', 195, 1),
(674, 'Petare', 195, 1),
(675, 'Caucagüita', 195, 1),
(676, 'Filas de Mariche', 195, 1),
(677, 'La Dolorita', 195, 1),
(678, 'Cúa', 196, 1),
(679, 'Nueva Cúa', 196, 1),
(680, 'Bolívar', 197, 1),
(681, 'Guatire', 197, 1),
(682, 'San Antonio de Capayacuar', 198, 1),
(683, 'San Francisco de Maturín', 198, 1),
(684, 'Aguasay', 199, 1),
(685, 'Caripito', 200, 1),
(686, 'Caripe', 201, 1),
(687, 'Teresén', 201, 1),
(688, 'El Guácharo', 201, 1),
(689, 'San Agustín', 201, 1),
(690, 'La Guanota', 201, 1),
(691, 'Sabana de Piedra', 201, 1),
(692, 'Caicara de Maturín', 202, 1),
(693, 'Areo', 202, 1),
(694, 'San Félix de Cantalicio', 202, 1),
(695, 'Viento Fresco', 202, 1),
(696, 'Punta de Mata', 203, 1),
(697, 'El Tejero', 203, 1),
(698, 'Temblador', 204, 1),
(699, 'Tabasca', 204, 1),
(700, 'Las Alhuacas', 204, 1),
(701, 'Chaguaramas', 204, 1),
(702, 'Alto de los Godos', 205, 1),
(703, 'Boquerón', 205, 1),
(704, 'Las Cocuizas', 205, 1),
(705, 'La Cruz', 205, 1),
(706, 'San Simón', 205, 1),
(707, 'El Corozo', 205, 1),
(708, 'El Furrial', 205, 1),
(709, 'Jusepín', 205, 1),
(710, 'La Pica', 205, 1),
(711, 'San Vicente', 205, 1),
(712, 'Aragua de Maturín', 206, 1),
(713, 'Chaguaramal', 206, 1),
(714, 'Guanaguana', 206, 1),
(715, 'Aparicio', 206, 1),
(716, 'Taguaya', 206, 1),
(717, 'El Pinto', 206, 1),
(718, 'La Toscana', 206, 1),
(719, 'Cachipo', 207, 1),
(720, 'Quiriquire', 207, 1),
(721, 'Santa Bárbara', 208, 1),
(722, 'Morón', 208, 1),
(723, 'Barrancas del Orinoco', 209, 1),
(724, 'Los Barrancos de Fajardo', 209, 1),
(725, 'Uracoa', 210, 1),
(726, 'Antolín del Campo', 211, 1),
(727, 'Arismendi', 212, 1),
(728, 'San Juan Bautista', 213, 1),
(729, 'Zabala', 213, 1),
(730, 'García', 214, 1),
(731, 'Francisco Fajardo', 214, 1),
(732, 'Bolívar', 215, 1),
(733, 'Guevara', 215, 1),
(734, 'Matasiete', 215, 1),
(735, 'Santa Ana', 215, 1),
(736, 'Sucre', 215, 1),
(737, 'Aguirre', 216, 1),
(738, 'Pampatar', 216, 1),
(739, 'Adrián', 217, 1),
(740, 'Juan Griego', 217, 1),
(741, 'Porlamar', 218, 1),
(742, 'Boca del Río', 219, 1),
(743, 'San Francisco', 219, 1),
(744, 'Tubores', 220, 1),
(745, 'Los Barales', 220, 1),
(746, 'Vicente Fuentes', 221, 1),
(747, 'Villalba', 221, 1),
(748, 'Agua Blanca', 222, 1),
(749, 'Araure', 223, 1),
(750, 'Río Acarigua', 223, 1),
(751, 'Píritu', 224, 1),
(752, 'Uveral', 224, 1),
(753, 'Guanare', 225, 1),
(754, 'Córdoba', 225, 1),
(755, 'San José de la Montaña', 225, 1),
(756, 'San Juan de Guanaguanare', 225, 1),
(757, 'Virgen de la Coromoto', 225, 1),
(758, 'Guanarito', 226, 1),
(759, 'Trinidad de la Capilla', 226, 1),
(760, 'Divina Pastora', 226, 1),
(761, 'Peña Blanca', 227, 1),
(762, 'Chabasquén', 227, 1),
(763, 'Aparición', 228, 1),
(764, 'La Estación', 228, 1),
(765, 'Ospino', 228, 1),
(766, 'Acarigua', 229, 1),
(767, 'Payara', 229, 1),
(768, 'Pimpinela', 229, 1),
(769, 'Ramón Peraza', 229, 1),
(770, 'Caño Delgadito', 230, 1),
(771, 'Papelón', 230, 1),
(772, 'Antolín Tovar Aquino', 231, 1),
(773, 'Boconoí', 231, 1),
(774, 'Santa Fe', 232, 1),
(775, 'San Rafael de Onoto', 232, 1),
(776, 'El Playón', 233, 1),
(777, 'Florida', 233, 1),
(778, 'Biscucuy', 234, 1),
(779, 'Concepción', 234, 1),
(780, 'San José de Saguaz', 234, 1),
(781, 'San Rafael de Palo Alzado', 234, 1),
(782, 'Uvencio Antonio Velásquez', 234, 1),
(783, 'Villa Rosa', 234, 1),
(784, 'Canelones', 235, 1),
(785, 'Santa Cruz', 235, 1),
(786, 'San Isidro Labrador', 235, 1),
(787, 'Villa Bruzual', 235, 1),
(788, 'Mariño', 236, 1),
(789, 'Rómulo Gallegos', 236, 1),
(790, 'San José de Aerocuar', 237, 1),
(791, 'Tavera Acosta', 237, 1),
(792, 'San Juan Bautista', 238, 1),
(793, 'San Juan de las Galdonas', 238, 1),
(794, 'Río Caribe', 238, 1),
(795, 'El Morro', 238, 1),
(796, 'Puerto Santo', 238, 1),
(797, 'El Pilar', 239, 1),
(798, 'El Rincón', 239, 1),
(799, 'General Francisco Antonio Váldez', 239, 1),
(800, 'Guaraúnos', 239, 1),
(801, 'Tunapuicito', 239, 1),
(802, 'Unión', 239, 1),
(803, 'Bolívar', 240, 1),
(804, 'Macarapana', 240, 1),
(805, 'Santa Catalina', 240, 1),
(806, 'Santa Rosa', 240, 1),
(807, 'Santa Teresa', 240, 1),
(808, 'Marigüitar', 241, 1),
(809, 'Libertad', 242, 1),
(810, 'El Paujil', 242, 1),
(811, 'Yaguaraparo', 242, 1),
(812, 'Araya', 243, 1),
(813, 'Chacopata', 243, 1),
(814, 'Manicuare', 243, 1),
(815, 'Tunapuy', 244, 1),
(816, 'Campo Elías', 244, 1),
(817, 'Irapa', 245, 1),
(818, 'Campo Claro', 245, 1),
(819, 'Maraval', 245, 1),
(820, 'San Antonio de Irapa', 245, 1),
(821, 'Soro', 245, 1),
(822, 'San Antonio del Golfo', 246, 1),
(823, 'Arenas', 247, 1),
(824, 'Aricagua', 247, 1),
(825, 'Cumanacoa', 247, 1),
(826, 'San Fernando', 247, 1),
(827, 'San Lorenzo', 247, 1),
(828, 'San Juan', 247, 1),
(829, 'Cariaco', 248, 1),
(830, 'Catuaro', 248, 1),
(831, 'Rendón', 248, 1),
(832, 'Santa Cruz', 248, 1),
(833, 'Santa María', 248, 1),
(834, 'Altagracia', 249, 1),
(835, 'Ayacucho', 249, 1),
(836, 'Santa Inés', 249, 1),
(837, 'San Juan', 249, 1),
(838, 'Valentín Valiente', 249, 1),
(839, 'Raúl Leoni', 249, 1),
(840, 'Gran Mariscal', 249, 1),
(841, 'Bideau', 250, 1),
(842, 'Cristóbal Colón', 250, 1),
(843, 'Güiria', 250, 1),
(844, 'Punta de Piedras', 250, 1),
(845, 'Cordero', 251, 1),
(846, 'Las Mesas', 252, 1),
(847, 'San Juan de Colón', 253, 1),
(848, 'Rivas Berti', 253, 1),
(849, 'San Pedro del Río', 253, 1),
(850, 'San Antonio', 254, 1),
(851, 'Palotal', 254, 1),
(852, 'General Juan Vicente Gómez', 254, 1),
(853, 'Isaías Medina Angarita', 254, 1),
(854, 'Táriba', 255, 1),
(855, 'Amenodoro Rangel Lamús', 255, 1),
(856, 'La Florida', 255, 1),
(857, 'Santa Ana', 256, 1),
(858, 'San Rafael del Piñal', 257, 1),
(859, 'Alberto Adriani', 257, 1),
(860, 'Santo Domingo', 257, 1),
(861, 'San José de Bolívar', 258, 1),
(862, 'La Tendida', 259, 1),
(863, 'Boca de Grita', 259, 1),
(864, 'José Antonio Páez', 259, 1),
(865, 'Palmira', 260, 1),
(866, 'Capacho Nuevo', 261, 1),
(867, 'Juan Germán Roscio', 261, 1),
(868, 'Román Cárdenas', 261, 1),
(869, 'La Grita', 262, 1),
(870, 'Emilio Constantino Guerrero', 262, 1),
(871, 'Monseñor Miguel Antonio Salas', 262, 1),
(872, 'El Cobre', 263, 1),
(873, 'Rubio', 264, 1),
(874, 'Bramón', 264, 1),
(875, 'La Petrólea', 264, 1),
(876, 'Quinimarí', 264, 1),
(877, 'Capacho Viejo', 265, 1),
(878, 'Cipriano Castro', 265, 1),
(879, 'Manuel Felipe Rugeles', 265, 1),
(880, 'Abejales', 266, 1),
(881, 'Doradas', 266, 1),
(882, 'Emeterio Ochoa', 266, 1),
(883, 'San Joaquín de Navay', 266, 1),
(884, 'Lobatera', 267, 1),
(885, 'Constitución', 267, 1),
(886, 'Michelena', 268, 1),
(887, 'Coloncito', 269, 1),
(888, 'La Palmita', 269, 1),
(889, 'Ureña', 270, 1),
(890, 'Nueva Arcadia', 270, 1),
(891, 'Delicias', 271, 1),
(892, 'La Tendida', 272, 1),
(893, 'Boconó', 272, 1),
(894, 'Hernández', 272, 1),
(895, 'La Concordia', 273, 1),
(896, 'San Juan Bautista', 273, 1),
(897, 'Pedro María Morantes', 273, 1),
(898, 'San Sebastián', 273, 1),
(899, 'Francisco Romero Lobo', 273, 1),
(900, 'Umuquena', 274, 1),
(901, 'Seboruco', 275, 1),
(902, 'San Simón', 276, 1),
(903, 'Queniquea', 277, 1),
(904, 'Eleazar López Contreras', 277, 1),
(905, 'San Pablo', 277, 1),
(906, 'San José Obrero', 278, 1),
(907, 'Pregonero', 279, 1),
(908, 'Cárdenas', 279, 1),
(909, 'Juan Pablo Peñaloza', 279, 1),
(910, 'Potosí', 279, 1),
(911, 'Araguaney', 280, 1),
(912, 'El Jaguito', 280, 1),
(913, 'La Esperanza', 280, 1),
(914, 'Santa Isabel', 280, 1),
(915, 'Boconó', 281, 1),
(916, 'El Carmen', 281, 1),
(917, 'Mosquey', 281, 1),
(918, 'Ayacucho', 281, 1),
(919, 'Burbusay', 281, 1),
(920, 'General Ribas', 281, 1),
(921, 'Guaramacal', 281, 1),
(922, 'Vega de Guaramacal', 281, 1),
(923, 'Monseñor Jáuregui', 281, 1),
(924, 'Rafael Rangel', 281, 1),
(925, 'San José', 281, 1),
(926, 'San Miguel', 281, 1),
(927, 'Sabana Grande', 282, 1),
(928, 'Cheregüé', 282, 1),
(929, 'Granados', 282, 1),
(930, 'Chejendé', 283, 1),
(931, 'Arnoldo Gabaldón', 283, 1),
(932, 'Bolivia', 283, 1),
(933, 'Carrillo', 283, 1),
(934, 'Cegarra', 283, 1),
(935, 'San José', 283, 1),
(936, 'Manuel Salvador Ulloa', 283, 1),
(937, 'Carache', 284, 1),
(938, 'La Concepción', 284, 1),
(939, 'Cuicas', 284, 1),
(940, 'Panamericana', 284, 1),
(941, 'Santa Cruz', 284, 1),
(942, 'Escuque', 285, 1),
(943, 'La Unión', 285, 1),
(944, 'Santa Rita', 285, 1),
(945, 'Sabana Libre', 285, 1),
(946, 'El Socorro', 286, 1),
(947, 'Los Caprichos', 286, 1),
(948, 'Antonio José de Sucre', 286, 1),
(949, 'Campo Elías', 287, 1),
(950, 'Arnoldo Gabaldón', 287, 1),
(951, 'La Ceiba', 288, 1),
(952, 'Santa Apolonia', 288, 1),
(953, 'El Progreso', 288, 1),
(954, 'Tres de Febrero', 288, 1),
(955, 'Márquez Bustillos', 289, 1),
(956, 'El Dividive', 290, 1),
(957, 'Agua Santa', 290, 1),
(958, 'Agua Caliente', 290, 1),
(959, 'El Cenizo', 290, 1),
(960, 'Monte Carmelo', 291, 1),
(961, 'Buena Vista', 291, 1),
(962, 'Santa María del Horcón', 291, 1),
(963, 'Motatán', 292, 1),
(964, 'El Baño', 292, 1),
(965, 'Jalisco', 292, 1),
(966, 'Pampán', 293, 1),
(967, 'Flor de Patria', 293, 1),
(968, 'La Paz', 293, 1),
(969, 'Santa Ana', 293, 1),
(970, 'Pampanito', 294, 1),
(971, 'La Concepción', 294, 1),
(972, 'Pampanito II', 294, 1),
(973, 'Betijoque', 295, 1),
(974, 'José Gregorio Hernández', 295, 1),
(975, 'La Pueblita', 295, 1),
(976, 'Los Cedros', 295, 1),
(977, 'Carvajal', 296, 1),
(978, 'Campo Alegre', 296, 1),
(979, 'Antonio Nicolás Briceño', 296, 1),
(980, 'José Leonardo Suárez', 296, 1),
(981, 'Sabana de Mendoza', 297, 1),
(982, 'Junín', 297, 1),
(983, 'Valmore Rodríguez', 297, 1),
(984, 'El Paraíso', 297, 1),
(985, 'Andrés Linares', 298, 1),
(986, 'Chiquinquirá', 298, 1),
(987, 'Cristóbal Mendoza', 298, 1),
(988, 'Cruz Carrillo', 298, 1),
(989, 'Matriz', 298, 1),
(990, 'Monseñor Carrillo', 298, 1),
(991, 'Tres Esquinas', 298, 1),
(992, 'Cabimbú', 299, 1),
(993, 'Jajó', 299, 1),
(994, 'La Mesa de Esnujaque', 299, 1),
(995, 'Santiago', 299, 1),
(996, 'Tuñame', 299, 1),
(997, 'La Quebrada', 299, 1),
(998, 'Juan Ignacio Montilla', 300, 1),
(999, 'La Beatriz', 300, 1),
(1000, 'Mercedes Díaz', 300, 1),
(1001, 'San Luis', 300, 1),
(1002, 'Mendoza Fría', 300, 1),
(1003, 'La Puerta', 300, 1),
(1004, 'San Pablo', 301, 1),
(1005, 'Aroa', 302, 1),
(1006, 'Chivacoa', 303, 1),
(1007, 'Campo Elías', 303, 1),
(1008, 'Cocorote', 304, 1),
(1009, 'Independencia', 305, 1),
(1010, 'Sabana de Parra', 306, 1),
(1011, 'Boraure', 307, 1),
(1012, 'Yumare', 308, 1),
(1013, 'Salóm', 309, 1),
(1014, 'Temerla', 309, 1),
(1015, 'Nirgua', 309, 1),
(1016, 'San Juan Bautista', 310, 1),
(1017, 'Yaritagua', 310, 1),
(1018, 'San Javier', 311, 1),
(1019, 'Albarico', 311, 1),
(1020, 'San Felipe', 311, 1),
(1021, 'Guama', 312, 1),
(1022, 'Urachiche', 313, 1),
(1023, 'El Guayabo', 314, 1),
(1024, 'Farriar', 314, 1),
(1025, 'Isla de Toas', 315, 1),
(1026, 'Monagas', 315, 1),
(1027, 'San Timoteo', 316, 1),
(1028, 'General Urdaneta', 316, 1),
(1029, 'Libertador', 316, 1),
(1030, 'Marcelino Briceño', 316, 1),
(1031, 'Nuevo Naranjo', 316, 1),
(1032, 'Manuel Guanipa Matos', 316, 1),
(1033, 'Ambrosio', 317, 1),
(1034, 'Carmen Herrera', 317, 1),
(1035, 'La Rosa', 317, 1),
(1036, 'Jorge Hernández', 317, 1),
(1037, 'San Benito', 317, 1),
(1038, 'Rómulo Betancourt', 317, 1),
(1039, 'Arístides Calvani', 317, 1),
(1040, 'Germán Ríos Linares', 317, 1),
(1041, 'Punta Gorda', 317, 1),
(1042, 'Encontrados', 318, 1),
(1043, 'Udón Pérez', 318, 1),
(1044, 'San Carlos del Zulia', 319, 1),
(1045, 'Santa Cruz del Zulia', 319, 1),
(1046, 'Santa Bárbara', 319, 1),
(1047, 'Urribarrí', 319, 1),
(1048, 'El Moralito', 319, 1),
(1049, 'Simón Rodríguez', 320, 1),
(1050, 'Carlos Quevedo', 320, 1),
(1051, 'Francisco Javier Pulgar', 320, 1),
(1052, 'La Concepción', 321, 1),
(1053, 'San José', 321, 1),
(1054, 'Mariano Parra León', 321, 1),
(1055, 'José Ramón Yépez', 321, 1),
(1056, 'Jesús María Semprún', 322, 1),
(1057, 'Barí', 322, 1),
(1058, 'Concepción', 323, 1),
(1059, 'Andrés Bello', 323, 1),
(1060, 'Chiquinquirá', 323, 1),
(1061, 'El Carmelo', 323, 1),
(1062, 'Potreritos', 323, 1),
(1063, 'Libertad', 324, 1),
(1064, 'Alonso de Ojeda', 324, 1),
(1065, 'Venezuela', 324, 1),
(1066, 'Eleazar López Contreras', 324, 1),
(1067, 'Campo Lara', 324, 1),
(1068, 'El Danto', 324, 1),
(1069, 'Bartolomé de las Casas', 325, 1),
(1070, 'Libertad', 325, 1),
(1071, 'Río Negro', 325, 1),
(1072, 'San José de Perijá', 325, 1),
(1073, 'San Rafael', 326, 1),
(1074, 'La Sierrita', 326, 1),
(1075, 'Las Parcelas', 326, 1),
(1076, 'Luis de Vicente', 326, 1),
(1077, 'Monseñor Marcos Sergio Godoy', 326, 1),
(1078, 'Ricaurte', 326, 1),
(1079, 'Tamare', 326, 1),
(1080, 'Antonio Borjas Romero', 327, 1),
(1081, 'Bolívar', 327, 1),
(1082, 'Cacique Mara', 327, 1),
(1083, 'Caracciolo Parra Pérez', 327, 1),
(1084, 'Cecilio Acosta', 327, 1),
(1085, 'Cristo de Aranza', 327, 1),
(1086, 'Coquivacoa', 327, 1),
(1087, 'Chiquinquirá', 327, 1),
(1088, 'Francisco Eugenio Bustamante', 327, 1),
(1089, 'Idelfonso Vásquez', 327, 1),
(1090, 'Juana de Ávila', 327, 1),
(1091, 'Luis Hurtado Higuera', 327, 1),
(1092, 'Manuel Dagnino', 327, 1),
(1093, 'Olegario Villalobos', 327, 1),
(1094, 'Raúl Leoni', 327, 1),
(1095, 'Santa Lucía', 327, 1),
(1096, 'San Isidro', 327, 1),
(1097, 'Venancio Pulgar', 327, 1),
(1098, 'Altagracia', 328, 1),
(1099, 'Faría', 328, 1),
(1100, 'Ana María Campos', 328, 1),
(1101, 'San Antonio', 328, 1),
(1102, 'San José', 328, 1),
(1103, 'Sinamaica', 329, 1),
(1104, 'Alta Guajira', 329, 1),
(1105, 'Elías Sánchez Rubio', 329, 1),
(1106, 'Guajira', 329, 1),
(1107, 'El Rosario', 330, 1),
(1108, 'Donaldo García', 330, 1),
(1109, 'Sixto Zambrano', 330, 1),
(1110, 'San Francisco', 331, 1),
(1111, 'El Bajo', 331, 1),
(1112, 'Domitila Flores', 331, 1),
(1113, 'Francisco Ochoa', 331, 1),
(1114, 'Los Cortijos', 331, 1),
(1115, 'Marcial Hernández', 331, 1),
(1116, 'José Domingo Rus', 331, 1),
(1117, 'Santa Rita', 332, 1),
(1118, 'El Mene', 332, 1),
(1119, 'Pedro Lucas Urribarrí', 332, 1),
(1120, 'José Cenobio Urribarrí', 332, 1),
(1121, 'Rafael Maria Baralt', 333, 1),
(1122, 'Manuel Manrique', 333, 1),
(1123, 'Rafael Urdaneta', 333, 1),
(1124, 'Bobures', 334, 1),
(1125, 'Gibraltar', 334, 1),
(1126, 'Heras', 334, 1),
(1127, 'Monseñor Arturo Álvarez', 334, 1),
(1128, 'Rómulo Gallegos', 334, 1),
(1129, 'El Batey', 334, 1),
(1130, 'Rafael Urdaneta', 335, 1),
(1131, 'La Victoria', 335, 1),
(1132, 'Raúl Cuenca', 335, 1);

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
  `nombre` varchar(20) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`cod_rol`, `nombre`, `estado`) VALUES
(1, 'Administrador', 0),
(2, 'Recepcionista', 1),
(3, 'Trabajador', 1),
(4, 'Chambeadora', 0),
(5, 'Chofer', 1);

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
  `cod_usuario` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `cedula` int(9) NOT NULL,
  `password` varchar(20) NOT NULL,
  `cod_rol` int(1) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`cod_usuario`, `nombre`, `cedula`, `password`, `cod_rol`, `estado`) VALUES
(1, 'maria', 3032411, '12121', 2, 1),
(2, 'Juana', 222333, '4444', 5, 1),
(3, 'Pedra', 232323, '333', 2, 1),
(4, 'Mariano', 333, 'ffff', 3, 0),
(5, 'Johnatan', 10101010, '554545454', 3, 1),
(6, 'Pedro', 22222, '878787878', 2, 1);

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
  ADD KEY `cod_ciudad` (`cod_municipio`);

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
  MODIFY `cod_cuenta` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `cod_estado` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `cod_metodo` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `cod_municipio` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=336;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `cod_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `parroquia`
--
ALTER TABLE `parroquia`
  MODIFY `cod_parroquia` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1133;

--
-- AUTO_INCREMENT de la tabla `precio_kilometraje`
--
ALTER TABLE `precio_kilometraje`
  MODIFY `cod_preciokilometraje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `cod_rol` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `cod_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  ADD CONSTRAINT `parroquia_ibfk_1` FOREIGN KEY (`cod_municipio`) REFERENCES `municipio` (`cod_municipio`) ON DELETE CASCADE ON UPDATE CASCADE;

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
