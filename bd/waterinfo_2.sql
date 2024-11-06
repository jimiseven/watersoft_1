-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-11-2024 a las 16:16:29
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `waterinfo_2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alertas`
--

CREATE TABLE `alertas` (
  `alerta_id` bigint(20) NOT NULL,
  `medidor_id` bigint(20) DEFAULT NULL,
  `tipo_alerta` text DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_alerta` date DEFAULT NULL,
  `estado` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alertas`
--

INSERT INTO `alertas` (`alerta_id`, `medidor_id`, `tipo_alerta`, `descripcion`, `fecha_alerta`, `estado`) VALUES
(1, 1, 'Fuga de agua', 'Posible fuga detectada', '2023-04-03', 'no resuelto'),
(2, 2, 'Consumo alto', 'Consumo superior al promedio', '2023-04-07', 'resuelto'),
(3, 3, 'Mantenimiento', 'Revisión de medidor recomendada', '2023-04-12', 'no resuelto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumos`
--

CREATE TABLE `consumos` (
  `consumo_id` bigint(20) NOT NULL,
  `medidor_id` bigint(20) DEFAULT NULL,
  `fecha_lectura` date DEFAULT NULL,
  `lectura_anterior` decimal(10,2) DEFAULT NULL,
  `lectura_actual` decimal(10,2) DEFAULT NULL,
  `consumo_m3` decimal(10,2) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consumos`
--

INSERT INTO `consumos` (`consumo_id`, `medidor_id`, `fecha_lectura`, `lectura_anterior`, `lectura_actual`, `consumo_m3`, `observaciones`) VALUES
(1, 1, '2023-04-01', 100.50, 150.70, 50.20, 'Consumo regular'),
(2, 2, '2023-04-05', 200.00, 240.30, 40.30, 'Consumo alto'),
(3, 3, '2023-04-10', 150.20, 180.10, 29.90, 'Consumo bajo'),
(4, 1, '2024-11-06', 1.00, 100.00, 99.00, 'sin obs'),
(5, 2, '2024-11-06', 240.30, 250.00, 9.70, 'sin obs'),
(6, 4, '2024-11-06', 0.00, 100.00, 100.00, 'sin obs');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturacion`
--

CREATE TABLE `facturacion` (
  `factura_id` bigint(20) NOT NULL,
  `consumo_id` bigint(20) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `estado` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturacion`
--

INSERT INTO `facturacion` (`factura_id`, `consumo_id`, `monto`, `fecha_emision`, `fecha_vencimiento`, `estado`) VALUES
(1, 1, 150.75, '2023-04-02', '2023-04-15', 'pendiente'),
(2, 2, 120.50, '2023-04-06', '2023-04-20', 'pagado'),
(3, 3, 90.30, '2023-04-11', '2023-04-25', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medidores`
--

CREATE TABLE `medidores` (
  `medidor_id` bigint(20) NOT NULL,
  `usuario_id` bigint(20) DEFAULT NULL,
  `numero_medidor` text DEFAULT NULL,
  `fecha_instalacion` date DEFAULT NULL,
  `ubicacion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medidores`
--

INSERT INTO `medidores` (`medidor_id`, `usuario_id`, `numero_medidor`, `fecha_instalacion`, `ubicacion`) VALUES
(1, 1, 'MED12345', '2023-01-15', 'Sector Norte'),
(2, 2, 'MED67890', '2023-02-20', 'Sector Sur'),
(3, 3, 'MED54321', '2023-03-25', 'Sector Centro'),
(4, 5, 'med23434', '2024-11-28', 'zona a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `pago_id` bigint(20) NOT NULL,
  `factura_id` bigint(20) DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `monto_pagado` decimal(10,2) DEFAULT NULL,
  `metodo_pago` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`pago_id`, `factura_id`, `fecha_pago`, `monto_pagado`, `metodo_pago`) VALUES
(1, 2, '2023-04-18', 120.50, 'Tarjeta de crédito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_usuarios`
--

CREATE TABLE `roles_usuarios` (
  `rol_id` bigint(20) NOT NULL,
  `nombre_rol` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles_usuarios`
--

INSERT INTO `roles_usuarios` (`rol_id`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Cliente'),
(3, 'Técnico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` bigint(20) NOT NULL,
  `nombre` text DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `telefono` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `estado` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `nombre`, `direccion`, `telefono`, `email`, `fecha_registro`, `estado`) VALUES
(1, 'Juan Pérez', 'Calle Falsa 123', '71234567', 'juan.perez@example.com', '2023-01-10', 'activo'),
(2, 'María López', 'Avenida Real 456', '76453210', 'maria.lopez@example.com', '2023-02-15', 'activo'),
(3, 'Carlos García', 'Calle 9 de Abril 789', '78453267', 'carlos.garcia@example.com', '2023-03-20', 'inactivo'),
(4, 'jimi', 'torrico', '782576523', 'tano@gmail.com', '2024-11-21', 'activo'),
(5, 'jimi to', 'zona a', '875676533', 'jimi@gmail.com', '2024-11-12', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_roles`
--

CREATE TABLE `usuarios_roles` (
  `usuario_id` bigint(20) NOT NULL,
  `rol_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_roles`
--

INSERT INTO `usuarios_roles` (`usuario_id`, `rol_id`) VALUES
(1, 1),
(2, 2),
(3, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alertas`
--
ALTER TABLE `alertas`
  ADD PRIMARY KEY (`alerta_id`),
  ADD KEY `medidor_id` (`medidor_id`);

--
-- Indices de la tabla `consumos`
--
ALTER TABLE `consumos`
  ADD PRIMARY KEY (`consumo_id`),
  ADD KEY `medidor_id` (`medidor_id`);

--
-- Indices de la tabla `facturacion`
--
ALTER TABLE `facturacion`
  ADD PRIMARY KEY (`factura_id`),
  ADD KEY `consumo_id` (`consumo_id`);

--
-- Indices de la tabla `medidores`
--
ALTER TABLE `medidores`
  ADD PRIMARY KEY (`medidor_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`pago_id`),
  ADD KEY `factura_id` (`factura_id`);

--
-- Indices de la tabla `roles_usuarios`
--
ALTER TABLE `roles_usuarios`
  ADD PRIMARY KEY (`rol_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Indices de la tabla `usuarios_roles`
--
ALTER TABLE `usuarios_roles`
  ADD PRIMARY KEY (`usuario_id`,`rol_id`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alertas`
--
ALTER TABLE `alertas`
  MODIFY `alerta_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `consumos`
--
ALTER TABLE `consumos`
  MODIFY `consumo_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `facturacion`
--
ALTER TABLE `facturacion`
  MODIFY `factura_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `medidores`
--
ALTER TABLE `medidores`
  MODIFY `medidor_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `pago_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles_usuarios`
--
ALTER TABLE `roles_usuarios`
  MODIFY `rol_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alertas`
--
ALTER TABLE `alertas`
  ADD CONSTRAINT `alertas_ibfk_1` FOREIGN KEY (`medidor_id`) REFERENCES `medidores` (`medidor_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `consumos`
--
ALTER TABLE `consumos`
  ADD CONSTRAINT `consumos_ibfk_1` FOREIGN KEY (`medidor_id`) REFERENCES `medidores` (`medidor_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `facturacion`
--
ALTER TABLE `facturacion`
  ADD CONSTRAINT `facturacion_ibfk_1` FOREIGN KEY (`consumo_id`) REFERENCES `consumos` (`consumo_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `medidores`
--
ALTER TABLE `medidores`
  ADD CONSTRAINT `medidores_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`factura_id`) REFERENCES `facturacion` (`factura_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios_roles`
--
ALTER TABLE `usuarios_roles`
  ADD CONSTRAINT `usuarios_roles_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuarios_roles_ibfk_2` FOREIGN KEY (`rol_id`) REFERENCES `roles_usuarios` (`rol_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
