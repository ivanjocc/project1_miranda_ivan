-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-12-2023 a las 06:48:21
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
-- Base de datos: `ecom1_project`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `address`
--

CREATE TABLE `address` (
  `id` bigint(20) NOT NULL,
  `street_name` varchar(255) NOT NULL,
  `street_nb` int(11) NOT NULL,
  `city` varchar(40) NOT NULL,
  `province` varchar(40) NOT NULL,
  `zip_code` varchar(6) NOT NULL,
  `country` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `address`
--

INSERT INTO `address` (`id`, `street_name`, `street_nb`, `city`, `province`, `zip_code`, `country`) VALUES
(1, 'langelier', 20, 'montreal', 'quebec', 'hasdjn', 'canada'),
(2, 'asdasd', 23, 'asdasd', 'asdasd', 'asdasd', 'asdasd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_has_product`
--

CREATE TABLE `order_has_product` (
  `order_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `id` bigint(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `img_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`id`, `name`, `quantity`, `price`, `img_url`, `description`, `img_path`) VALUES
(1, 'Product 1', 50, 19.99, '/public/img/product1.png', 'Description Product 1', ''),
(2, 'Product 2', 30, 29.99, '/public/img/product2.jpg', 'Description Product 2', ''),
(3, 'Product 3', 20, 39.99, '/public/img/product3.jpg', 'Description Product 3', ''),
(4, 'tigro', 23, 20.00, 'public/img/product5.jpg', 'gato contento', '../../public/img/product5.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `id` bigint(20) NOT NULL,
  `name` varchar(10) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`id`, `name`, `description`) VALUES
(1, 'superadmin', 'Super Administrator'),
(2, 'client', 'Client');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `billing_address_id` bigint(20) NOT NULL,
  `shipping_address_id` bigint(20) NOT NULL,
  `token` varchar(255) NOT NULL,
  `role_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `user_name`, `email`, `pwd`, `fname`, `lname`, `billing_address_id`, `shipping_address_id`, `token`, `role_id`) VALUES
(1, 'superadmin', 'superadmin@admin.ca', '$2y$10$XbVZVwOxlwfv4iiSvMhZdOXiuWWlWhqWJIgZQ5aM5UiUyDhhcHKMa', 'Super', 'Admin', 1, 1, '', 1),
(2, 'client', 'test@example.com', '$2y$10$WvUt5YLCr9E6H/sbCdtemeyfdK0xKdxd2cj1.pBpKa42QrIK46qpS', 'test', 'client', 2, 2, '', 2),
(3, 'ivanjose', 'ivanjose@gmail.com', '$2y$10$kv1pHMROTxunKkvWMEEmDeLwPeOnzi5l8Ed9sLRJZZdtklhe3MFZG', 'test', 'atunes', 0, 0, '', 1),
(6, 'prueba', 'queso@gmail.com', '$2y$10$vlZnXov0tiYKpnIbYW5cWO1cl4KCFK.DsWLhjdiADOMtAMGOomtKS', '', '', 0, 0, '', 2),
(7, 'queso', 'atunes@gmail.com', '$2y$10$Uyjlzdz7CmeenNmhOlIkAeMSC7NHpM8yeYJ93bjD6Sv76KMpGEDRG', 'test', 'testo', 0, 0, '', 2),
(8, '', 'daisjdas@afasd.com', '$2y$10$S7GYXdQYwpxbbCfmchJYh.PzwkJkdr0w2w.EN/3fBy6bea01yaJyW', 'ivan', 'jose', 1, 1, '', 2),
(9, 'kjh', 'kjashdkjasd@fasdasd.com', '$2y$10$HBadq47FcIY1P9R7.9w6OOi1mk17aGoZ/UcUXvBk6SAuYp0bQVmO6', 'jkljklj', 'lkjlk', 2, 2, '', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_order`
--

CREATE TABLE `user_order` (
  `id` bigint(20) NOT NULL,
  `ref` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user_order`
--

INSERT INTO `user_order` (`id`, `ref`, `date`, `total`, `user_id`) VALUES
(1, 'ORDER-656d17aa309ba', '2023-12-03', 0.00, 7),
(2, 'ORDER-656d17c585a43', '2023-12-03', 0.00, 7),
(3, 'ORDER-656d235ecf48b', '2023-12-03', 0.00, 7),
(4, 'ORDER-656d55d4b8be4', '2023-12-03', 0.00, 9),
(5, 'ORDER-656d578b3dc88', '2023-12-03', 0.00, 9),
(6, 'ORDER-656d581de55f2', '2023-12-03', 0.00, 9),
(7, 'ORDER-656d5b5730a32', '2023-12-03', 19.99, 9),
(8, 'ORDER-656d5bb8037a9', '2023-12-03', 19.99, 9),
(9, 'ORDER-656d5bdb1a3aa', '2023-12-03', 19.99, 9),
(10, 'ORDER-656d5c337775d', '2023-12-03', 19.99, 9),
(11, 'ORDER-656d5d1855cda', '2023-12-04', 19.99, 9),
(12, 'ORDER-656d5dba21fbf', '2023-12-04', 19.99, 9),
(13, 'ORDER-656d5e253e59f', '2023-12-04', 19.99, 9),
(14, '656d5f3f5e5de', '2023-12-04', 19.99, 9),
(15, '656d5f703bb3c', '2023-12-04', 19.99, 9),
(16, '656d5f8f866b6', '2023-12-04', 19.99, 9),
(17, '', '2023-12-04', 19.99, 9);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `order_has_product`
--
ALTER TABLE `order_has_product`
  ADD PRIMARY KEY (`product_id`,`order_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD KEY `role_id` (`role_id`);

--
-- Indices de la tabla `user_order`
--
ALTER TABLE `user_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `address`
--
ALTER TABLE `address`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `role`
--
ALTER TABLE `role`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `user_order`
--
ALTER TABLE `user_order`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `order_has_product`
--
ALTER TABLE `order_has_product`
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`order_id`) REFERENCES `user_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_order`
--
ALTER TABLE `user_order`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
