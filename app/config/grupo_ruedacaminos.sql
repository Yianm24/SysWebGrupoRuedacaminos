-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-09-2026 a las 02:33:53
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
(3, 'Banesco', 1),
(4, 'Bancamiga', 1);

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
(13, 12345678, 'RUEDA', 'CAMINOS', '1231232', 'malsdasdl@fdsf', 'V', 0),
(22, 7777, 'yuan', 'perereadasd', '312123', 'mamdasmdska@ANSDMSAD', 'E', 0),
(23, 3333, 'Juana', 'pereira', '312123', 'mamdasmdska@ANSDMSAD', 'E', 0);

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
  `cod_vehiculo` int(2) NOT NULL
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
(1, '18335555', 'Juan', 'Mendez', '04123441222', '04123401444', 3, 1),
(2, '29201408', 'Juan', 'Pérez', '04242550034', '04123565656', 2, 1),
(3, '30300100', 'María', 'Pérez', '04242550038', '04223568080', 1, 1),
(4, '22800120', 'Antonio', 'Requena', '04161356060', '04128788481', 4, 1);

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
-- Estructura de tabla para la tabla `gastos_despacho`
--

CREATE TABLE `gastos_despacho` (
  `cod_gastodespacho` int(15) NOT NULL,
  `descripcion` varchar(70) NOT NULL,
  `monto` decimal(6,2) NOT NULL,
  `estado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gastos_despacho`
--

INSERT INTO `gastos_despacho` (`cod_gastodespacho`, `descripcion`, `monto`, `estado`) VALUES
(1, '', 0.00, 0),
(2, '', 0.00, 0),
(3, '', 0.00, 0);

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
(3, 'CHEVROLET', 1),
(4, 'pdasd', 0);

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
(6, 'Juan', 3, 0),
(7, 'Rapipago', 2, 0),
(8, 'Rapipago', 3, 0);

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
(4, 'Tether', 'USDT', 1),
(5, 'Petrico', 'PTG', 0),
(6, 'Yenes', 'Y', 0),
(7, 'Yenes', 'Y', 0),
(8, 'Yenes', 'Y', 0);

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
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `cod_ubicacion` int(11) NOT NULL,
  `descripcion` varchar(70) NOT NULL,
  `cod_municipio` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones_envio`
--

CREATE TABLE `ubicaciones_envio` (
  `cod_ubicacion` int(11) NOT NULL,
  `cod_envio` int(11) NOT NULL,
  `tipo_ubicacion` enum('DespachoEspecifico','Destino') NOT NULL
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
(6, 'Pedro', 22222, '878787878', 2, 1),
(7, 'Yancamacaro', 55557, 'f', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `cod_vehiculo` int(2) NOT NULL,
  `placa` varchar(7) NOT NULL,
  `color` varchar(6) NOT NULL,
  `anio` int(4) NOT NULL,
  `anchura` decimal(2,0) NOT NULL,
  `altura` decimal(2,0) NOT NULL,
  `peso_max` decimal(1,0) NOT NULL,
  `cod_modelo` int(1) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`cod_vehiculo`, `placa`, `color`, `anio`, `anchura`, `altura`, `peso_max`, `cod_modelo`, `estado`) VALUES
(8, 'ABC541', 'Blanco', 2022, 0, 0, 0, 1, 1),
(9, 'ABC1234', 'Blanco', 2022, 0, 0, 0, 2, 1),
(10, 'GHI1122', 'Gris', 2023, 0, 0, 0, 3, 1),
(11, 'XYZ9876', 'Rojo', 2019, 0, 0, 0, 2, 0),
(12, 'XYB9870', 'Negro', 2004, 0, 0, 0, 2, 0);

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
  ADD KEY `cod_vehiculo` (`cod_vehiculo`);

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
  ADD KEY `cod_preciokilometraje` (`cod_preciokilometraje`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`cod_estado`);

--
-- Indices de la tabla `gastos_despacho`
--
ALTER TABLE `gastos_despacho`
  ADD PRIMARY KEY (`cod_gastodespacho`);

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
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`cod_ubicacion`),
  ADD KEY `cod_municipio` (`cod_municipio`);

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
  ADD KEY `cod_modelo` (`cod_modelo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `banco`
--
ALTER TABLE `banco`
  MODIFY `cod_banco` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT de la tabla `detalle_pago`
--
ALTER TABLE `detalle_pago`
  MODIFY `cod_detallepago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `cod_empleado` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15152;

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
-- AUTO_INCREMENT de la tabla `gastos_despacho`
--
ALTER TABLE `gastos_despacho`
  MODIFY `cod_gastodespacho` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `gastos_funcionales`
--
ALTER TABLE `gastos_funcionales`
  MODIFY `cod_gasto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `cod_marca` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  MODIFY `cod_metodo` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `modelo`
--
ALTER TABLE `modelo`
  MODIFY `cod_modelo` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `moneda`
--
ALTER TABLE `moneda`
  MODIFY `cod_moneda` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `municipio`
--
ALTER TABLE `municipio`
  MODIFY `cod_municipio` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=342;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `cod_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `cod_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Filtros para la tabla `participante_envio`
--
ALTER TABLE `participante_envio`
  ADD CONSTRAINT `participante_envio_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `cliente` (`cod_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participante_envio_ibfk_2` FOREIGN KEY (`cod_envio`) REFERENCES `envio` (`cod_envio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD CONSTRAINT `ubicacion_ibfk_1` FOREIGN KEY (`cod_municipio`) REFERENCES `municipio` (`cod_municipio`);

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
  ADD CONSTRAINT `vehiculo_ibfk_3` FOREIGN KEY (`cod_modelo`) REFERENCES `modelo` (`cod_modelo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
