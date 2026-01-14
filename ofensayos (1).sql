-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-04-2017 a las 04:37:04
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
-- Estructura de tabla para la tabla `ofensayos`
--

CREATE TABLE `ofensayos` (
  `nDescEnsayo` int(2) NOT NULL,
  `idEnsayo` varchar(3) NOT NULL,
  `nomEnsayo` varchar(50) NOT NULL,
  `Descripcion` text NOT NULL,
  `Status` varchar(3) NOT NULL,
  `Generico` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ofensayos`
--

INSERT INTO `ofensayos` (`nDescEnsayo`, `idEnsayo`, `nomEnsayo`, `Descripcion`, `Status`, `Generico`) VALUES
(2, '', 'Ensayos no destructivos', 'Estos ensayos se pueden realizar mediante tintas, ultrasonido, partículas magnéticas, radiografías. La elección del tipo de ensayo se realizar en virtud del cumplimiento del objetivo a menos que el mandante estime lo contrario, lo cual debe ser establecido previamente entre las partes.', 'on', 'on'),
(1, '', 'Análisis Dimensional', 'Se realizarán las mediciones necesarias, con los instrumentos indicados para la confirmación o ratificación de las medidas especificadas por normas, planos y/o especificación del cliente.', 'on', 'on'),
(4, 'Qu', 'Análisis Químico', 'El análisis químico de las muestra(s) de estudio es realizado por espectrometría de emisión óptica (base Fe, Cu y Al), según norma ASTM A571. En el caso que la muestra sea muy pequeña y/o  encontrase con un metal en otra base, se podrá hacer un ensayo de análisis semicuantitativo de elementos por microscopia electrónica de barrido (EDS).', 'on', 'on'),
(3, '', 'Analisis Fractográfico', 'analizará la superficie de la fractura de la o las piezas de estudios.', 'on', 'on'),
(10, '', 'Medición de Rugosidad Superficial', 'La rugosidad superficial, se podrán determinar los parámetros Ra y/o  Rz, dependiendo de las características y necesidades del estudio, basándose en la norma ASTM XXXX o alguna norma equivalente.', 'off', 'on'),
(5, '', 'Macrografias', 'Se requiere para el análisis realizar una macrografía para evaluar los sectores de interes observando posibles anomalías en las muestras, este ensayo se basa en la norma ASTM E XXX.', 'off', 'on'),
(6, 'M', 'Análisis Metalográfico', 'Se realizarán los sectores de interés para el posterior análisis metalográfico, para poder analizar las microestructuras. La preparación de las muestras se realiza mediante la norma ASTM E3 y la selección del ataque químico según la norma ASTM E407.', 'off', 'on'),
(7, 'Tr', 'Ensayos Tracción', 'Los ensayos de tracción se realizaran en base a la norma ASTM E8, o equivalente dependiendo de los requerimientos (API, AWS, ASME, ASTMA 370, etc.).', 'off', 'on'),
(8, 'Do', 'Ensayos de Doblado', 'Los ensayos de doblado se realizaran según norma que corresponda (API, AWS, ASME, ASTM, etc.).', 'off', 'on'),
(9, 'Du', 'Ensayos de Dureza', 'Dependiendo de la naturaleza del análisis, se podrán realizara microdurezavickers(norma ASTM 999)o durezas de otros tipos, como Brinell (norma ASTM XXXX), Rockwell A, B, C, 30T, etc (norma ASTM XXXX), o Shor A (norma ASTM XXXX).', 'off', 'on'),
(11, 'S', 'Microscopia Electrónica de Barrido', 'Se realizará microscopia electrónica para observar las zonas de interés y además, si es necesario, se realizarán cuantificación de elementos por microsonda (EDS).', '', 'on'),
(12, '', 'Curvas de Polarización', 'Como resultado de este estudio, además de determinar las curvas de polarización, se pueden determinar la corriente y potencial de corrosión en distintos medios, además con los mismos datos es posible determinar la velocidad de corrosión en MPY, este ensayo se basa en la norma ASTM XXXX.', '', 'on'),
(13, '', 'Ensayo de Cámara de Niebla Salina', 'El ensayo esta normado bajo la norma ASTM B117, el cual puede ser modificado si el ensayo lo requiere, la cantidad de horas de exposición es de "...1000...".horas.', '', 'on'),
(15, '', 'Otros ensayos', 'Los ensayos adicionales a la realizar son los siguiente:', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
