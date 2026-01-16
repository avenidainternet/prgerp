-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-06-2021 a las 23:58:37
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `simet_laboratorio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usr` varchar(40) NOT NULL,
  `pwd` varchar(20) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `nPerfil` char(2) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tpUsr` varchar(1) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `firma` varchar(100) NOT NULL,
  `vCAM` varchar(3) NOT NULL,
  `vRAM` varchar(3) NOT NULL,
  `vAM` varchar(3) NOT NULL,
  `resumenGral` varchar(3) NOT NULL,
  `cargoUsr` varchar(50) NOT NULL,
  `firmaUsr` varchar(100) NOT NULL,
  `responsableInforme` varchar(3) NOT NULL,
  `titPie` varchar(30) NOT NULL,
  `apruebaOfertas` varchar(3) NOT NULL,
  `status` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usr`, `pwd`, `usuario`, `nPerfil`, `email`, `tpUsr`, `celular`, `firma`, `vCAM`, `vRAM`, `vAM`, `resumenGral`, `cargoUsr`, `firmaUsr`, `responsableInforme`, `titPie`, `apruebaOfertas`, `status`) VALUES
('Alfredo.Artigas', 'alf123', 'Alfredo Artigas A.', '0', 'alfredo.artigas@usach.cl', '', '997032842', '', '', '', '', '', 'Director', 'aaa.png', 'on', 'Dr. Ing.', 'on', ''),
('10074437', 'f86382165', 'Francisco Olivares Rodriguez', 'WM', 'francisco.olivares.rodriguez@gmail.com', '', '984910930', '', '', '', '', '', 'Informatica', '10074437.png', 'off', '', 'off', ''),
('informes', 'control.2013', 'Editor Informes', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('MCV', 'simet.2014', 'Mario Córdova Villa', '1', 'mario.cordovav@usach.cl', '', '111111', '', '', '', '', '', 'Ingeniero de Procesos', 'mcv.png', 'off', 'Ing.', 'off', 'off'),
('Adm', '1234', 'Emma Barceló', '2', 'emma.barcelo@usach.cl', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('CMS', '8770', 'César Segovia', '1', 'simet.cms@usach.cl', '', '9', '', '', '', '', '', 'Gerente Técnico', 'cms.png', 'off', 'Ing.', 'off', ''),
('HBR', 'simet.2014', 'Héctor Bruna', '1', 'hector.bruna@usach.cl', '5', '84910930', '', '', '', '', '', 'Ingeniero de Procesos', 'hbr.png', 'off', 'Ing.', 'off', ''),
('ACA', 'simet.2014', 'Alejandro Castillo A.', '1', 'simet.aca@usach.cl', '', '99', '', '', '', '', '', 'Gerente de Investigación y Desarrollo', 'aca.png', 'on', 'Ing.', 'on', ''),
('AVR', 'simet.2014', 'Alejandro Valdés Rojas', '1', 'simet.avr@usach.cl', '', '+56', '', '', '', '', '', 'Ingeniero de Laboratorio', 'avr.png', 'on', 'Ing.', 'off', ''),
(' pantalla', 'simet.2014', 'Pantalla RAMs', '3', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(' muestras', 'simet123', 'Recepción de Muestras', '4', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('JNC', 'jnc123', 'Jaime Nova Chanqueo', '5', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('RAM', 'ram', 'Recepción de Muestras', '4', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('DPG', 'dpg123', 'Daniel Pavez G.', '1', 'simet.dpg@usach.cl', '', '11111111', '', '', '', '', '', 'Ingeniero de Procesos', 'DPG.png', 'on', 'Ing.', 'off', ''),
('SDA', 'SDA123', 'Sebastián Díaz A.', '1', 'simet.sda@usach.cl', '', '997032842', '', '', '', '', '', 'Ingeniero de Operaciones', 'SDA.png', 'on', 'Ing.', 'on', ''),
(' CMH', 'simet.2018', 'Camila Mercado H.', '3', 'camila.mercado@usach.cl', '', '11111111111', '', '', '', '', '', 'Tecnico Experto', '', 'off', '', 'off', 'off'),
('BAZ', 'baz123', 'Bruno Astorga Z.', '1', 'simet.baz@usach.cl', '', '+56958592724', '', '', '', '', '', 'Ingeniero  de Procesos', 'BAZ.png', 'on', 'Ing.', 'on', ''),
('RPM', 'RPM123', 'Raúl Palma M.', '1', 'simet.rpm@usach.cl', '', '+56984509718', '', '', '', '', '', 'Jefe de Laboratorio', 'RPM.png', 'on', 'Ing.', 'on', ''),
('CER', '123', 'Certificacion', '01', 'simet.avr@usach.cl', '', '56997032842', '', '', '', '', '', 'Jefe de Certificación', '', 'on', '', 'on', 'off'),
('GAO', 'gao123', 'Gonzalo Araos O.', '2', 'gonzalo.araos@usach.cl', '', '+5699999999', '', '', '', '', '', 'Encargado de Calidad', '', 'off', '', 'off', 'off'),
('MRR', 'mrr123', 'Matías Rodríguez R.', '1', 'simet.mrr@usach.cl', '', '+56961570812', '', '', '', '', '', 'Ingeniero de procesos', 'MRR.png', 'on', 'Ingeniero I+D', 'on', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
