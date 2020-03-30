-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-03-2020 a las 18:03:32
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `grupito`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedido`
--

CREATE TABLE `detallepedido` (
  `idDetallePedido` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `detallepedido`
--

INSERT INTO `detallepedido` (`idDetallePedido`, `idPedido`, `idProducto`, `cantidad`, `precio`) VALUES
(4, 2, 1, 1, '5.95'),
(5, 2, 2, 1, '13.25'),
(6, 3, 7, 2, '4.90'),
(7, 3, 8, 2, '14.99'),
(8, 4, 8, 1, '14.99'),
(9, 4, 1, 3, '5.95'),
(10, 5, 2, 2, '13.25'),
(11, 5, 8, 1, '14.99'),
(12, 5, 5, 1, '5.95');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `nombre` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`nombre`) VALUES
('Cancelado'),
('Entregado'),
('Enviado'),
('Preparando');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `estado` varchar(64) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'Preparando'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`idPedido`, `idUsuario`, `fecha`, `total`, `estado`) VALUES
(2, 3, '2020-02-20 14:00:53', '19.20', 'Enviado'),
(3, 3, '2020-02-20 14:02:55', '39.78', 'Preparando'),
(4, 3, '2020-02-27 13:20:05', '32.84', 'Preparando'),
(5, 3, '2020-02-27 13:43:49', '47.44', 'Entregado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `nombre` varchar(128) COLLATE utf8mb4_spanish_ci NOT NULL,
  `introDescripcion` varchar(128) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL,
  `imagen` varchar(128) COLLATE utf8mb4_spanish_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `precioOferta` decimal(10,2) NOT NULL,
  `online` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `nombre`, `introDescripcion`, `descripcion`, `imagen`, `precio`, `precioOferta`, `online`) VALUES
(1, 'Yelmo cines', 'Entrada para todos los cines', 'Entrada al cine con opción de menú en Yelmo Madrid o resto de península (hasta 44% de descuento)', 'yelmo.jpg', '9.10', '5.95', 1),
(2, 'Invernalia', 'Patinaje sobre hielo', 'En Valladolid el personal es muy amable y se pasa un buen rato. Los patines bastante incómodos, pero supongo que forma parte de estos sitios y es difícil que queden bien a todo el mundo. Desde el año pasado cobran por el osito-guía, creo que está bien para', 'hielo.jpg', '19.00', '13.25', 1),
(5, 'Telepizza', '1 pizza mediana de masa fina de hasta 5 ingredientes', 'Oferta válida para recoger en local o para entrega a domicilio; por cada pizza comprada se tendrá acceso a 1 película', 'pizza.jpg', '15.95', '5.95', 1),
(6, 'Centro Shén', 'Limpieza facial completa con tratamiento orbicular', 'Se puede elegir limpieza facial con tratamiento orbicular, con luz led, radiofrecuencia, peeling con ultrasonidos o fotorrejuvenecimiento', 'rosa.jpg', '30.00', '12.95', 1),
(7, 'Multicines Norte', 'Entrada al cine y combo mediano para 1, 2 o 4 personas desde 4,90 € en Multicines Norte', 'Un auténtico \"superviviente\" del cine en Vigo o \"cómo reinventarse para seguir en la brecha\". Cine en V. O., retransmisiones de Ópera, eventos, obras de autor,... Sinceramente, ¡enhorabuena!', 'cine.jpg', '9.50', '4.90', 0),
(8, 'Arepa Olé Street Vigo', 'Menú para 2 o 4 personas con entrante, arepa, postre y bebida en Arepa Ole Street Vigo (hasta 45% de descuento)', 'Arepa Olé es una franquicia de restaurantes especializada en comida caribeña. El local está situado en la calle de Rosalía de Castro, Vigo. Ofrecen una amplia variedad de arepas de tres o más ingredientes como carne mechada, pollo, frijoles negros, plátano', 'comida.jpg', '26.40', '14.99', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_spanish_ci NOT NULL,
  `password` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(64) COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellidos` varchar(64) COLLATE utf8mb4_spanish_ci NOT NULL,
  `direccion` varchar(128) COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono` varchar(24) COLLATE utf8mb4_spanish_ci NOT NULL,
  `online` tinyint(1) NOT NULL DEFAULT 1,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `email`, `password`, `nombre`, `apellidos`, `direccion`, `telefono`, `online`, `admin`) VALUES
(2, 'mauro@gmail.com', '$2y$10$2pSo9my2YoKswcM0axYKxuwe7FRvRO9rdbb/W6nr9DdY21M0KVcGm', 'mauro', 'ds', 'ds', '9863', 0, 0),
(3, 'ana@gmail.com', '$2y$10$NJ23TiU0.95lyEprPVM12eSUIY5bP.6jCO81WtgmyEs2qCRj3/.xO', 'Ana', 'Malvido', 'aqui', '9863214', 1, 0),
(4, 'adri@gmail.com', '$2y$10$9kiCq8Yox6EZE6ptyrqXmuB2UYT/./T/4FLzxyJEGBpsqgcybmWdO', 'adri', 'dsahfkjdsafds kjhdfskjhdjskhds', 'dsfdshkds', '123654789', 1, 1),
(5, 'juan@gmail.com', '$2y$10$TETkFnP74rZXXmT8jInYHO.FpJGRv6MQORRcRaamEJzPQSOfEKKy6', 'juan', 'dsahfkjdsafds kjhdfskjhdjskhds', 'aqui', '9863', 1, 0),
(6, 'ana.malvido86@gmail.com', '$2y$10$yFnOqjZDls/mauAbFHDl9O9QBe1nG659K4Peoaf8RGi1d3xrXmRDW', 'ana', 'dsahfkjdsafds kjhdfskjhdjskhds', 'aqui', '9863', 0, 0),
(7, 'captcha@prueba', '$2y$10$//XBhdaKWXtBc0MxqCOV0.wKJknitr5GcBa6CbOPiXulEbIvO2E6K', 'ana', 'ds', 'aqui', '9863', 1, 0),
(8, 'pepito@gmail.com', '$2y$10$.ghPP8V3qfHxFYfd781OB./V2/64woiSvhA8tkS38mZ7vO0Aic33a', 'pepe', 'Malvido', 'casa', '1326', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD PRIMARY KEY (`idDetallePedido`),
  ADD KEY `idPedido` (`idPedido`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`nombre`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `estado` (`estado`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  MODIFY `idDetallePedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD CONSTRAINT `detallepedido_ibfk_1` FOREIGN KEY (`idPedido`) REFERENCES `pedidos` (`idPedido`),
  ADD CONSTRAINT `detallepedido_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`estado`) REFERENCES `estados` (`nombre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
