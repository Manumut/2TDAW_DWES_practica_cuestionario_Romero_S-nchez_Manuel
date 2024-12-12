-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-12-2024 a las 12:50:23
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `kahoot_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `idPreg` int(2) NOT NULL,
  `pregun` varchar(500) NOT NULL,
  `respuesPreg` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`idPreg`, `pregun`, `respuesPreg`) VALUES
(1, '¿Cuál es el animal nacional de Australia?', 'Canguro'),
(2, '¿Cuál es el país más pequeño del mundo?', 'El Vaticano'),
(3, '¿Cuál es el río más largo del mundo?', 'Rio Nilo'),
(4, '¿Cuál es la capital de España?', 'Madrid'),
(5, '¿Cuánto es 7 + 5?', '12'),
(6, '¿Qué planeta es conocido como el Planeta Rojo?', 'Marte'),
(7, '¿Cuántos días tiene una semana?', '7'),
(8, '¿Cuántos minutos tiene una hora?', '60'),
(9, '¿Cuál es el océano más grande del mundo?', 'Pacifico'),
(10, 'Escribe tres frutas separadas por coma', 'manzana,platano,naranja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(2) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `tiempIni` timestamp NULL DEFAULT NULL,
  `tiempFin` timestamp NULL DEFAULT NULL,
  `tiempTot` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `tiempIni`, `tiempFin`, `tiempTot`) VALUES
(2, 'erty', '2024-12-12 11:41:34', NULL, NULL),
(3, 'ertyftyj', '2024-12-12 11:41:37', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`idPreg`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
