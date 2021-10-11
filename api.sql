-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-10-2021 a las 19:44:31
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `api`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID_PRODUCTOS` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(30) NOT NULL,
  `stock` int(10) NOT NULL,
  `url` varchar(200) NOT NULL,
  `imageName` varchar(100) NOT NULL,
  `IDtoken` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID_PRODUCTOS`, `name`, `description`, `stock`, `url`, `imageName`, `IDtoken`) VALUES
(4, 'hugo', 'fgdsfgdsfgdfs', 1254, 'http://apiphp8.test/public/Images/61646f4b6070e5.71526911_mjfhqlpeikgon.jpeg', '61646f4b6070e5.71526911_mjfhqlpeikgon', 'bfe8996c52594c9b04be12e59d507f1c');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_USUARIO` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `dni` varchar(50) NOT NULL,
  `correo` varchar(30) NOT NULL,
  `rol` int(11) NOT NULL,
  `password` varchar(500) NOT NULL,
  `IDToken` varchar(500) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_USUARIO`, `nombre`, `dni`, `correo`, `rol`, `password`, `IDToken`, `fecha`) VALUES
(6, 'hugo', '12345', 'prueba@prueba.com', 1, '$2y$10$Ew1xoDU9iRHuThIgClWWmeLZE.K06QqJrsmxypWTOoWtaPIp/ggA2', '0e9765bcddfe134e8074c154e22f07b9815fc94e2a543cd0d3c1710498730cb8eb84145e9af1e6ab7c7110d5f76bdfdf6a0dd0e9f079df07b94f7d1285869097', '2021-10-06 01:07:11'),
(8, 'prueba', '123456789', 'prueba3@prueba.com', 1, '$2y$10$Z1iZCuo5WMgvCX1vCrxnl.XZxkMut1aK6s21IaWuaVd7KmM9xxNtG', '2664bf38f0b3afbdde0685defaa62dc382d12e4080f07887de00cb575cdc91792b6e09151ed00605803fb8042679f6641e8e96a3c591511bf2d8458fee58f67c', '2021-10-07 19:41:10'),
(12, 'pablo', '11433', 'prueba1@prueba.com', 2, '$2y$10$d9IZYiis2KlapQWNYWO7W.t2hWSE3g7EnK.n16lrFp7SwJGNolQDe', '5a2f8e6e553815d253e40fa7da9e2d4985814d7a8914d75677d2d06c6fbf9d267657106109c3f76c4e86a7b1914cfdfe7743e741700f4940f070e891530c49be', '2021-10-11 00:44:07'),
(13, 'carlos', '125487', 'prueba2@prueba.com', 3, '$2y$10$c.seDWDRCC.ARJO788UvuOBzaOKJckTX0A6DIwG74UiYc8jaSbOeG', 'afab23638f00f97088e7e577b6743a90663395f2616b3ed02ce7b8301e7d8002a1acac1870e67f337eedecf24a3c3358cca6d45709d7ce0d0c32e42c1345d06b', '2021-10-11 00:46:02');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID_PRODUCTOS`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_USUARIO`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID_PRODUCTOS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
