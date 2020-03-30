-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-03-2020 a las 16:53:50
-- Versión del servidor: 10.4.10-MariaDB
-- Versión de PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `framework`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `id_usuario` int(11) NOT NULL,
  `imdbID` varchar(10) NOT NULL,
  `tipo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `favoritos`
--

INSERT INTO `favoritos` (`id_usuario`, `imdbID`, `tipo`) VALUES
(29, 'tt0086190', 'Pelicula'),
(29, 'tt0232500', 'Pelicula'),
(29, 'tt1596343', 'Pelicula');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `para_ver`
--

CREATE TABLE `para_ver` (
  `id_usuario` int(11) NOT NULL,
  `imdbID` varchar(11) NOT NULL,
  `tipo` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `para_ver`
--

INSERT INTO `para_ver` (`id_usuario`, `imdbID`, `tipo`) VALUES
(29, 'tt0080684', 'Pelicula');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `apellido` varchar(200) NOT NULL,
  `edad` int(3) NOT NULL,
  `ci` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `edad`, `ci`, `email`, `pass`) VALUES
(28, 'Admin', 'Admin', 99, '12345678', 'admin@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b'),
(27, 'Bernardo', 'Firpo', 0, 'Montevideo', 'bfirpo@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b'),
(25, 'Edinson', 'Cavani', 27, '33333', 'edi@cavani.com', '7c4a8d09ca3762af61e59520943dc26494f8941b'),
(24, 'luis', 'suarez', 22, '333', 'luisito@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b'),
(29, 'Maxi', 'Minetto', 25, '47725190', 'maximinetto@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id_usuario`,`imdbID`);

--
-- Indices de la tabla `para_ver`
--
ALTER TABLE `para_ver`
  ADD PRIMARY KEY (`id_usuario`,`imdbID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
