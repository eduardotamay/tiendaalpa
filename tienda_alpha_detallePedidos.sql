-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-07-2020 a las 18:06:01
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_alpha`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedidos`
--

CREATE TABLE `detallepedidos` (
  `id_pedido` int(10) NOT NULL,
  `sku` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `precio_unitario` double NOT NULL,
  `cantidad` double NOT NULL,
  `importe` double NOT NULL,
  `iva` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(10) NOT NULL,
  `status` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `id_usuario` int(255) NOT NULL,
  `a_nombre_de` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `requiere_factura` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `num_partidas` int(255) NOT NULL,
  `calle` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `num_ext` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `num_int` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `codigo_postal` varchar(7) COLLATE utf8_spanish2_ci NOT NULL,
  `colonia` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `municipio` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `pais` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `forma_envio` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `forma_pago` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `factura` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `subtotal` double NOT NULL,
  `iva` double NOT NULL,
  `total` double NOT NULL,
  `costo_envio` double DEFAULT NULL,
  `costo_sobrepeso` double DEFAULT NULL,
  `fecha_entrega` double DEFAULT NULL,
  `fecha_estimada` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detallepedidos`
--
ALTER TABLE `detallepedidos`
  ADD PRIMARY KEY (`id_pedido`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
