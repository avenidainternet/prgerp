-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-04-2017 a las 03:36:13
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES latin1 */;

--
-- Base de datos: `simet_laboratorio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descripcionpropuesta`
--

CREATE TABLE `descripcionpropuesta` (
  `itemPropuesta` int(1) NOT NULL,
  `titPropuesta` varchar(50) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `descripcionpropuesta`
--

INSERT INTO `descripcionpropuesta` (`itemPropuesta`, `titPropuesta`, `descripcion`) VALUES
(1, 'OBJETIVO:', 'El objetivo de esta propuesta es "$objetivoGeneral" cuyo alcance es el siguiente:'),
(2, 'PROPUESTA TÉCNICA:', 'La metodología a utilizar es la siguiente:'),
(3, 'PLAZO DE ENTREGA DEL INFORME:', 'El plazo de entrega del informes es de $Habiles días hábiles, contados de recepción delas muestras y la aceptación formal del trabajo, con todos los antecedentes entregados por parte del mandante.\n\nLa entrega de resultados y/o informes queda sujete a la regularización de pago.'),
(4, 'PROPUESTA ECONÓMICA:', 'El valor final del presente estudio es de $totalOfertaUF UF más IVA, para comenzar con los servicios se deberá aceptar formalmente este documento, el tiempo de validez de este presupuesto es de 30 días de la fecha de elaboración de la presente propuesta.'),
(5, 'CONSIDERACIONES GENERALES:', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
