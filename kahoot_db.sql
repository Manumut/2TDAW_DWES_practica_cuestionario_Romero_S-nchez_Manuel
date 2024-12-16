-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-12-2024 a las 09:15:37
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
(1, 'Cual es el animal nacional de Australia?', 'Canguro'),
(2, 'Cual es el pais mas pequenio del mundo?', 'El Vaticano'),
(3, 'Cual es el rio más largo del mundo?', 'Rio Nilo'),
(4, 'Cual es la capital de Espania?', 'Madrid'),
(5, 'Cuanto es 7 + 5?', '12'),
(6, 'Que planeta es conocido como el Planeta Rojo?', 'Marte'),
(7, 'Cuantos dias tiene una semana?', '7'),
(8, 'Cuantos minutos tiene una hora?', '60'),
(9, 'Cual es el oceano mas grande del mundo?', 'Pacifico'),
(10, 'Estas vivo?', 'si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(2) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `tiempIni` timestamp NULL DEFAULT NULL,
  `tiempFin` timestamp NULL DEFAULT NULL,
  `score` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `tiempIni`, `tiempFin`, `score`) VALUES
(28, 'ds', '2024-12-16 07:45:25', '2024-12-16 07:45:59', 4),
(29, 'sdf', '2024-12-16 07:50:22', NULL, NULL),
(30, 'dsdf', '2024-12-16 07:53:24', '2024-12-16 07:53:56', 3);

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
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
