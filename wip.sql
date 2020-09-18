-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-09-2020 a las 18:17:19
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `wip`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `block`
--

CREATE TABLE `block` (
  `id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bloque_padre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `test_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `block`
--

INSERT INTO `block` (`id`, `position`, `alias`, `estado`, `bloque_padre`, `test_id`) VALUES
(26, 4, 'block', 'Desactivado', 'No', 20),
(46, 2, 'b2', 'No realizada', 'Diseno Avisos', 20),
(66, 2, 'nnnn', 'No realizada', '', 42),
(67, 1, 'aaaaa', 'No realizada', 'No', 28),
(68, 1, 'bbb', 'No realizada', 'No', 28),
(69, 2, 'cccc', 'No realizada', 'No', 28),
(70, 1, 'sadf', 'No realizada', 'No', 28),
(71, 1, 'sadfdsa', 'No realizada', 'No', 28),
(72, 1, 'dsfgasdgf', 'No realizada', 'No', 28),
(73, 2, 'fdsaf', 'No realizada', '', 28);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pm_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pm_mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `customer`
--

INSERT INTO `customer` (`id`, `nombre`, `alias`, `pm_nombre`, `pm_mail`, `estado`) VALUES
(1, 'Customer 1', 'C1', 'Customer 1', 'customer1@customer1.com', 1),
(2, 'Customer 2', 'C2', 'Customer 2', 'customer2@customer2.com', 1),
(4, 'Customer 3', 'C3', 'Customer 3', 'customer3@customer3.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer_user`
--

CREATE TABLE `customer_user` (
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `customer_user`
--

INSERT INTO `customer_user` (`customer_id`, `user_id`) VALUES
(1, 27),
(1, 29),
(1, 31),
(1, 38),
(2, 27),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(2, 35),
(2, 36),
(2, 37),
(2, 38),
(4, 26),
(4, 27),
(4, 28),
(4, 29),
(4, 30),
(4, 37);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20200907090534', '2020-09-07 11:06:00', 1151),
('DoctrineMigrations\\Version20200908080403', '2020-09-08 10:19:25', 208),
('DoctrineMigrations\\Version20200908120946', '2020-09-08 14:10:49', 107),
('DoctrineMigrations\\Version20200908150522', '2020-09-08 17:05:32', 124),
('DoctrineMigrations\\Version20200909100905', '2020-09-09 12:09:15', 129),
('DoctrineMigrations\\Version20200909154901', '2020-09-09 17:49:10', 104),
('DoctrineMigrations\\Version20200910071753', '2020-09-10 09:18:07', 77),
('DoctrineMigrations\\Version20200910075324', '2020-09-10 09:53:32', 74),
('DoctrineMigrations\\Version20200910080156', '2020-09-10 10:02:01', 82),
('DoctrineMigrations\\Version20200910084508', '2020-09-10 10:45:17', 149),
('DoctrineMigrations\\Version20200910090813', '2020-09-10 11:08:22', 44),
('DoctrineMigrations\\Version20200914100344', '2020-09-14 12:03:55', 140),
('DoctrineMigrations\\Version20200914101141', '2020-09-14 12:11:55', 204),
('DoctrineMigrations\\Version20200914120503', '2020-09-14 14:05:09', 99),
('DoctrineMigrations\\Version20200915094224', '2020-09-15 11:42:34', 113),
('DoctrineMigrations\\Version20200915094400', '2020-09-15 11:44:09', 107),
('DoctrineMigrations\\Version20200916070613', '2020-09-16 09:06:25', 126),
('DoctrineMigrations\\Version20200916111811', '2020-09-16 13:18:21', 95);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `customers_id` int(11) DEFAULT NULL,
  `fecha_alta` date NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_test` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_production` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desactivar` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `project`
--

INSERT INTO `project` (`id`, `customers_id`, `fecha_alta`, `alias`, `url_test`, `url_production`, `estado`, `tipo`, `desactivar`) VALUES
(9, 1, '2015-05-05', 'P1', 'dfsagfd', 'gfdsgfdsg', 'ALPHA', 'Wordpress', 0),
(10, 2, '2015-01-01', 'P2', 'fsdafsda', 'fsdafsdafdas', 'CERRADO A TESTING', 'Prestashop', 0),
(11, 1, '2015-01-01', 'P3', 'dfsgfdg', 'fdgfdsgfd', 'ALPHA', 'Symfony', 0),
(12, 1, '2015-01-01', 'P4', 'dsfsdaf', 'fsdafsd', 'PRODUCCION', 'Social Media', 0),
(13, 4, '2015-01-01', 'Proyecto C3', 'fdg', 'sdgfsdfg', 'ALPHA', 'Symfony', 0),
(14, 4, '2015-01-01', 'Proyecto C3-2', 'fdgs', 'gfdsgfd', 'ALPHA', 'Wordpress', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_user`
--

CREATE TABLE `project_user` (
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `project_user`
--

INSERT INTO `project_user` (`project_id`, `user_id`) VALUES
(9, 28),
(10, 26),
(11, 29),
(12, 28),
(13, 35),
(13, 36),
(13, 37),
(14, 28),
(14, 29),
(14, 35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observaciones` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `block_id` int(11) DEFAULT NULL,
  `desactivar` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `question`
--

INSERT INTO `question` (`id`, `description`, `observaciones`, `imagen`, `estado`, `block_id`, `desactivar`) VALUES
(18, 'dsafdsa', 'fsdafsda', 'fac256fcbe6c8bd56089054556ebc2b8.png', 'NO TESTADO', 26, 0),
(25, 'dsfsda', 'fsdafasd', 'perro.png', 'NO TESTADO', 26, 0),
(26, 'fgdsgfd', 'dfgsdf', 'perro.png', 'NO TESTADO', 46, 0),
(27, 'dsfgdf', 'gdfsg', 'perro.png', 'NO TESTADO', 46, 0),
(28, 'sdgfg', 'fdsgdf', 'perro.png', 'NO TESTADO', 26, 0),
(29, 'dfgfds', 'gdfsg', 'perro.png', 'NO TESTADO', 26, 0),
(43, 'fdsg', 'fdgfdsgd', 'd9e2aa8930434485102f1e2160b8244e.png', 'NO TESTADO', 26, 0),
(44, 'fsdaf', 'dfs', '996e598250812cb0925ff2aa74f1ad5e.png', 'NO TESTADO', 26, 0),
(45, 'jhgfdjh--', 'hfgjgfhjfgh--', '0f94d191f64a1b1d056f99609da2765f.jpg', 'NO TESTADO', 26, 0),
(46, 'sdfas', 'fasdf', 'be32d74593b878a7f9286f5a9f883739.png', 'NO TESTADO', 26, 0),
(47, 'dsaf', 'sdafasd', '385c2398b89cc8de3c3614db5adebd88.png', 'NO TESTADO', 26, 0),
(48, 'etry', 'ytrutyruyt', '22dc060442ba4ea403dc22f4715fd024.png', 'NO TESTADO', 26, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reset_password_request`
--

INSERT INTO `reset_password_request` (`id`, `user_id`, `selector`, `hashed_token`, `requested_at`, `expires_at`) VALUES
(26, 35, 'JUq5fzdoCWa4oNuD3jlh', 'ILhqPOpOqFJZ6OiJxkGAmtp2x/NhmlsYMqfhfdRHVvQ=', '2020-09-14 11:19:44', '2020-09-14 12:19:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `server`
--

CREATE TABLE `server` (
  `id` int(11) NOT NULL,
  `nombrevps` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urlacceso` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `psw` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `server`
--

INSERT INTO `server` (`id`, `nombrevps`, `alias`, `ip`, `urlacceso`, `usuario`, `psw`, `tipo`, `activo`) VALUES
(1, 'Server 1', 'S1', '4321543542', 'ghfjhgf', 'badyalberto@gmail.com', '1234', 'Desarrollo', 0),
(5, 'Server 2', 'S2', '76578685', 'kjhgkjhgkhj', 'User 2', '1111', 'Produccion', 1),
(6, 'Server 3', 'S3', '563456543', 'bgfdshgfdh', 'User 3', '3333', 'Desarrollo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desactivar` tinyint(1) NOT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `test`
--

INSERT INTO `test` (`id`, `customer_id`, `project_id`, `user_id`, `alias`, `tipo`, `desactivar`, `estado`) VALUES
(20, 1, 12, 26, 'Test 1', 'ALPHA', 0, 'No Iniciado'),
(28, 2, 10, 26, 'gfdgd', 'ALPHA', 1, 'Desactivado'),
(29, 1, 11, 26, 'Test 5', 'ALPHA', 0, 'No Iniciado'),
(30, 2, 10, 26, 'sdafdsa', 'ALPHA', 1, 'Desactivado'),
(31, 1, 9, 26, 'sdfadf', 'ALPHA', 0, 'No Iniciado'),
(32, 1, 11, 26, 'fdsgdfg', 'ALPHA', 0, 'Realizado'),
(36, 1, 9, 26, 'Test correcto', 'BETA', 0, 'No Iniciado'),
(37, 4, 14, 26, 'Test Proyecto C3', 'BETA', 1, 'Desactivado'),
(38, 4, 14, 26, 'Test Proyecto C3', 'BETA', 0, 'No Iniciado'),
(39, 2, 10, 26, 'dsafasd', 'ALPHA', 0, 'No Iniciado'),
(40, 4, 14, 26, 'AAAAAAAAAAAAAAAAA', 'ALPHA', 0, 'No Iniciado'),
(41, 1, 12, 26, 'BBBBBBB', 'ALPHA', 0, 'No Iniciado'),
(42, 1, 12, 26, 'dfsgsdfg', 'ALPHA', 0, 'No Iniciado'),
(43, 1, 12, 26, 'dafsad', 'ALPHA', 0, 'No Iniciado'),
(44, 1, 12, 26, 'dafsad', 'ALPHA', 0, 'No Iniciado'),
(45, 1, 12, 26, 'dafsad', 'ALPHA', 0, 'No Iniciado'),
(46, 1, 12, 26, 'dafsad', 'ALPHA', 0, 'No Iniciado'),
(47, 1, 12, 26, 'cxzvxcfsdz', 'ALPHA', 0, 'No Iniciado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `nombre`, `correo`, `tipo`, `password`, `activo`, `roles`) VALUES
(26, 'wip', 'wip@wip.com', 'WIIP', '$2y$13$WSidQwdLhinGbC4udV3j7eu6X7wMswXfeax5O/DAzY1EjlPeZJUcS', 1, '[\"ROLE_USER\"]'),
(27, 'User 1', 'user1@user1.com', 'CLIENTE', '$2y$13$DKnwQ8v6e2e3IZnOqZ5aju.UYlgTf5w2NIwZAullWMpLhCSH36yse', 1, '[\"ROLE_USER\"]'),
(28, 'wip2', 'wip2@wip2.com', 'WIIP', '$2y$13$GurvdTBGVRrDOgFKeWLGrOrTu8xSVe5Zpbgvnr/xQBr84eEbtkQhK', 1, '[\"ROLE_WIP\"]'),
(29, 'wip3', 'wip3@wip3.com', 'WIIP', '$2y$13$5jpAdbNm/A5Me0rQdnNoguW1B5WtVsAYaQcVbQvxfewfrrqVcNzVu', 1, '[\"ROLE_WIP\"]'),
(30, 'User 2', 'user2@user2.com', 'CLIENTE', '$2y$13$a7.dF15YkIII9luqi/QZ8OMYMGEsg.sz1gI58dQhn9Y5kFzmcg9jC', 1, '[\"ROLE_USER\"]'),
(31, 'User 4', 'user4@user4.com', 'CLIENTE', '$2y$13$bgz7suA4McJ4aaDKXKBM9edyg9mL4gK/Ep9qJpRwrGLM18agfebky', 1, '[\"ROLE_USER\"]'),
(35, 'Alberto', 'badyalberto@gmail.com', 'WIIP', '$2y$13$SAx.CK8IVJexO2WzLQXaeunbccgoijJsqONUABA3nwckafuIXl4vm', 1, '[\"ROLE_WIP\"]'),
(36, 'fgdhgfh', 'hgfdh@e2rfewq.com', 'WIIP', '$2y$13$U8.vu6nDoO1KO.f8VvyyU.2Lj823Dz0GyqWebN5VS9FmovFLN4Eta', 0, '[\"ROLE_WIP\"]'),
(37, 'fdsgd', 'gfd@vsadf.com', 'WIIP', '$2y$13$Q20bhLvntsXEQW4jzfIBReqTqKR1eXoUC4K0LJCFcDQBWL3h.pCra', 0, '[\"ROLE_WIP\"]'),
(38, 'sadfds', '2313214@dwfd.com', 'WIIP', '$2y$13$cRCygquM9BvpTpCjW0hIgePcNCk0l0oj5Km9CMthIMIXRwS3X8Tl2', 0, '[\"ROLE_WIP\"]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_project`
--

CREATE TABLE `user_project` (
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user_project`
--

INSERT INTO `user_project` (`project_id`, `user_id`) VALUES
(9, 27),
(10, 30),
(11, 27),
(12, 27),
(13, 30),
(14, 30);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `block`
--
ALTER TABLE `block`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_831B97221E5D0459` (`test_id`);

--
-- Indices de la tabla `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_81398E09F4F389F` (`pm_mail`);

--
-- Indices de la tabla `customer_user`
--
ALTER TABLE `customer_user`
  ADD PRIMARY KEY (`customer_id`,`user_id`),
  ADD KEY `IDX_D902723E9395C3F3` (`customer_id`),
  ADD KEY `IDX_D902723EA76ED395` (`user_id`);

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2FB3D0EEC3568B40` (`customers_id`);

--
-- Indices de la tabla `project_user`
--
ALTER TABLE `project_user`
  ADD PRIMARY KEY (`project_id`,`user_id`),
  ADD KEY `IDX_B4021E51166D1F9C` (`project_id`),
  ADD KEY `IDX_B4021E51A76ED395` (`user_id`);

--
-- Indices de la tabla `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6F7494EE9ED820C` (`block_id`);

--
-- Indices de la tabla `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Indices de la tabla `server`
--
ALTER TABLE `server`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D87F7E0C9395C3F3` (`customer_id`),
  ADD KEY `IDX_D87F7E0C166D1F9C` (`project_id`),
  ADD KEY `IDX_D87F7E0CA76ED395` (`user_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D64977040BC9` (`correo`);

--
-- Indices de la tabla `user_project`
--
ALTER TABLE `user_project`
  ADD PRIMARY KEY (`project_id`,`user_id`),
  ADD KEY `IDX_77BECEE4166D1F9C` (`project_id`),
  ADD KEY `IDX_77BECEE4A76ED395` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `block`
--
ALTER TABLE `block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `server`
--
ALTER TABLE `server`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `block`
--
ALTER TABLE `block`
  ADD CONSTRAINT `FK_831B97221E5D0459` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`);

--
-- Filtros para la tabla `customer_user`
--
ALTER TABLE `customer_user`
  ADD CONSTRAINT `FK_D902723E9395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D902723EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `FK_2FB3D0EEC3568B40` FOREIGN KEY (`customers_id`) REFERENCES `customer` (`id`);

--
-- Filtros para la tabla `project_user`
--
ALTER TABLE `project_user`
  ADD CONSTRAINT `FK_B4021E51166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B4021E51A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `FK_B6F7494EE9ED820C` FOREIGN KEY (`block_id`) REFERENCES `block` (`id`);

--
-- Filtros para la tabla `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `FK_D87F7E0C166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  ADD CONSTRAINT `FK_D87F7E0C9395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `FK_D87F7E0CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `user_project`
--
ALTER TABLE `user_project`
  ADD CONSTRAINT `FK_77BECEE4166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_77BECEE4A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
