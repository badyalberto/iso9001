-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-10-2020 a las 17:36:38
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
-- Estructura de tabla para la tabla `answer`
--

CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `observaciones` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `answer`
--

INSERT INTO `answer` (`id`, `question_id`, `observaciones`, `imagen`, `estado`) VALUES
(1, 18, 'Pregunta 1111', 'f3a50a54a11b5cf3a5a3b0b2e1740536.jpeg', 'SI'),
(2, 43, 'Pregunta 2222', 'cfe425ad83fc63f2560c75338e5a59a9.jpeg', 'NO'),
(3, 44, 'Pregunta 3333', 'fc0b4b27a010006515ab2ba07a9bf449.jpeg', 'NO IMPLEMENTADA'),
(4, 48, 'Pregunta deshabilitada', 'be97a4a548787f99e1797a6a23e964f7.jpeg', 'DESACTIVADO'),
(5, 53, 'Pregunta 5555', '7497d8a1d2602307f4d5bf1447ab16cb.jpeg', 'NO'),
(6, 49, 'bbbb', '85a33938e2086f74ce366551b4ce4021.jpeg', 'SI'),
(7, 50, 'ccccc', '16515579293128ad686448602d8c9e9e.jpeg', 'DESACTIVADO'),
(30, 74, 'dsfadsaf', '', 'SI'),
(31, 75, 'dfsdsaf', '', 'SI'),
(32, 76, 'asdfdsaf', '', 'NO'),
(33, 77, 'fdgsfdgsdgf', '', 'SI'),
(34, 78, '', '', 'NO TESTEADO'),
(35, 79, '', '', 'NO IMPLEMENTADA'),
(36, 80, '', '', 'NO TESTEADO'),
(37, 81, 'fsgdgsdfgfd', '', 'SI'),
(38, 82, '', '', 'SI'),
(39, 83, '', '', 'NO'),
(40, 84, '', '', 'NO TESTEADO'),
(41, 85, 'fdsfsa', '', 'SI'),
(42, 86, 'dsfaasdf', '', 'SI'),
(43, 87, 'gsdf', '', 'NO'),
(44, 88, 'gsdfsdf', '', 'NO IMPLEMENTADA'),
(45, 89, '', '', 'NO TESTEADO'),
(46, 90, '', '', 'NO TESTEADO'),
(47, 91, '', '', 'NO TESTEADO'),
(48, 92, 'fsdgfd', '', 'SI'),
(49, 93, '', '', 'SI'),
(50, 94, '', '', 'SI'),
(51, 95, 'sdfgsd', '', 'SI'),
(52, 96, 'fdgsfd', '', 'SI'),
(53, 97, '', '', 'DESACTIVADO'),
(54, 98, 'fdghgfh', '', 'SI'),
(55, 99, '', '', 'SI'),
(56, 100, 'fdghhfd', '', 'NO IMPLEMENTADA'),
(57, 101, '', '', 'NO TESTEADO'),
(58, 102, '', '', 'NO IMPLEMENTADA'),
(59, 103, '', '', 'NO TESTEADO'),
(60, 104, 'sdfgdfs', '', 'SI'),
(61, 105, 'Editada 1', '7ba6a96b46968d5118f77f934b0dd468.png', 'SI'),
(62, 106, '', '', 'NO TESTEADO'),
(63, 107, '', '', 'NO TESTEADO'),
(64, 108, '', '', 'NO TESTEADO'),
(65, 109, '', '', 'NO TESTEADO'),
(66, 110, '', '', 'NO TESTEADO'),
(67, 111, '', '', 'NO TESTEADO'),
(68, 112, '', '', 'NO TESTEADO'),
(69, 113, '', '', 'NO TESTEADO'),
(70, 114, '', '', 'NO TESTEADO'),
(71, 115, '', '', 'NO TESTEADO'),
(72, 116, '', '', 'NO TESTEADO'),
(73, 117, '', '', 'NO TESTEADO'),
(74, 118, '', '', 'NO TESTEADO'),
(75, 119, '', '', 'NO TESTEADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `block`
--

CREATE TABLE `block` (
  `id` int(11) NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bloque_padre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `desactivar` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `block`
--

INSERT INTO `block` (`id`, `position`, `alias`, `estado`, `bloque_padre`, `test_id`, `desactivar`) VALUES
(26, '4', 'block', 'EN CURSO', 'No', 20, 0),
(46, '2', 'b2', 'NO INICIADO', 'No', 20, 0),
(66, '2', 'nnnn', 'EN CURSO', 'No', 42, 0),
(67, '1', 'Bloque 1', 'EN CURSO', 'No', 28, 0),
(74, '1', 'b1', 'EN CURSO', 'Diseño Avisos', 29, 0),
(75, '2', 'b2', 'REALIZADO', 'Diseño Alertas', 29, 0),
(76, '3', 'b3', 'NO INICIADO', 'No', 29, 0),
(77, '1', 'Bloque de prueba 1', 'EN CURSO', 'No', 48, 0),
(78, '2', 'Bloque de prueba 2', 'EN CURSO', 'Diseño Avisos', 48, 0),
(80, '4', 'Bloque de prueba 4', 'NO INICIADO', 'Diseño Avisos', 48, 0),
(82, '1', 'Bloque 82', 'EN CURSO', 'No', 54, 0),
(83, '1', 'CRUD', 'EN CURSO', 'No', 30, 0),
(90, '2', 'sdafs', 'NO INICIADO', 'No', 30, 0),
(91, '10', 'ADIOS', 'NO INICIADO', 'No', 30, 0),
(92, '1', 'fdsgfds', 'NO INICIADO', 'No', 30, 0),
(93, '1', 'QUE TAL', 'NO INICIADO', 'No', 30, 0),
(96, '2', 'COMO ESTAS', 'NO INICIADO', 'No', 30, 0),
(99, '1', 'kjhgkjhg', 'NO INICIADO', 'No', 30, 0),
(101, '1', 'bvxcvbc', 'NO INICIADO', 'No', 51, 0),
(102, '2', 'dsf', 'NO INICIADO', 'Diseño Avisos', 51, 0),
(103, '3', 'Prueba', 'NO INICIADO', 'No', 51, 0),
(105, '1', 'sdfa', 'NO INICIADO', 'No', 52, 0),
(106, '2', 'dsfdsa', 'NO INICIADO', 'Diseño Alertas', 52, 0),
(108, '1', 'Prueba 4', 'NO INICIADO', 'No', 52, 0),
(110, '2', 'Bloque 2', 'EN CURSO', 'Diseño Alertas', 28, 0),
(112, '3', 'Bloque 3', 'NO INICIADO', 'Diseño Avisos', 28, 0),
(114, '4', 'Prueba 2', 'NO INICIADO', 'No', 52, 0),
(126, '2', 'prueba 5', 'NO INICIADO', 'No', 52, 0),
(127, '1', 'Bloque 2', 'NO INICIADO', 'Diseño Avisos', NULL, 0),
(128, '1', 'Bloque 2', 'NO INICIADO', 'Diseño Avisos', 42, 0),
(129, '1', 'Bloque Login', 'NO INICIADO', 'No', 56, 0),
(130, '2', 'safdsa', 'NO INICIADO', 'No', NULL, 0),
(131, '2', 'safdsa', 'NO INICIADO', 'No', 56, 0),
(132, '2', 'dfsa', 'NO INICIADO', 'No', NULL, 0),
(133, '2', 'dfsa', 'NO INICIADO', 'No', 56, 0),
(134, '4', 'jhgfjhgf', 'NO INICIADO', 'No', NULL, 0),
(135, '4', 'jhgfjhgf', 'NO INICIADO', 'No', 56, 0),
(136, '2', 'Hola', 'EN CURSO', 'Diseño Alertas', 57, 0),
(137, '2', 'fasd', 'NO INICIADO', 'No', NULL, 0),
(138, '2', 'fasd', 'NO INICIADO', 'No', NULL, 0),
(139, '2', 'fasd', 'NO INICIADO', 'No', NULL, 0),
(140, '2', 'fasd', 'NO INICIADO', 'No', NULL, 0),
(141, '2', 'fasd', 'NO INICIADO', 'No', 57, 0),
(142, '3', 'fdsaf', 'NO INICIADO', '', 57, 0),
(143, '3', 'gfdssdfg', 'EN CURSO', 'No', 60, 0),
(144, '23', 'fdgsgfd', 'NO INICIADO', 'No', 60, 0),
(145, '1', 'Bloque 1', 'EN CURSO', 'No', 61, 0),
(146, '3', 'Bloque 3', 'NO INICIADO', 'Diseño Avisos', 61, 0),
(147, '2', 'Bloque 2', 'EN CURSO', 'Diseño Alertas', 61, 0),
(148, '1', 'Block 1', 'NO INICIADO', 'No', NULL, 0),
(149, '999', 'Block New', 'NO INICIADO', 'No', 62, 0),
(150, '2', 'Block 2', 'EN CURSO', 'Diseño Avisos', 62, 0),
(151, '3', 'Block 3', 'NO INICIADO', 'Diseño Alertas', 62, 0),
(152, '2', 'Block 4', 'NO INICIADO', 'No', NULL, 0),
(153, '2', 'Block 4444', 'EN CURSO', 'No', 62, 0),
(154, '1', 'Block 1', 'NO INICIADO', 'No', NULL, 0),
(155, '1', 'Block 1', 'NO INICIADO', 'No', 63, 0),
(156, '3', 'Block 3', 'NO INICIADO', 'Diseño Avisos', 63, 0),
(157, '2', 'Block 2', 'NO INICIADO', 'Diseño Alertas', 63, 0),
(158, '2', 'afsd', 'NO INICIADO', 'No', NULL, 0),
(159, '2', 'afsd', 'NO INICIADO', 'No', 64, 0),
(160, '1', 'fdsa', 'EN CURSO', 'No', 64, 0),
(161, '1', 'Block 1', 'NO INICIADO', 'No', NULL, 0),
(162, '1', 'Block 1', 'EN CURSO', 'No', 65, 0),
(163, '3', 'Block 3', 'NO INICIADO', 'Diseño Avisos', 65, 0),
(164, '2', 'Block 2', 'NO INICIADO', 'Diseño Alertas', 65, 0),
(165, '4', 'Block 4', 'NO INICIADO', 'Diseño Avisos', NULL, 0),
(166, '4', 'Block 4', 'NO INICIADO', 'Diseño Avisos', 65, 0);

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
(4, 'Customer 3', 'C3', 'Customer 3', 'customer3@customer3.com', 1),
(8, 'aaaa', 'aaaaa', 'aaaaaa', 'aaa@aaa.com', 0),
(13, 'bbbb', 'bbb', 'bbb', 'bbb@bb.com', 1),
(14, 'Pulso Ediciones SL', 'Pulso', 'Carles Jiménez', 'carles.jimenez@pulso.com', 1);

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
(1, 38),
(2, 27),
(2, 28),
(2, 29),
(2, 30),
(2, 35),
(4, 26),
(4, 27),
(4, 28),
(4, 29),
(4, 30),
(8, 27),
(8, 28),
(8, 29),
(8, 38),
(13, 28),
(13, 29),
(13, 30),
(14, 26);

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
('DoctrineMigrations\\Version20200916111811', '2020-09-16 13:18:21', 95),
('DoctrineMigrations\\Version20200921074611', '2020-09-21 09:46:21', 107),
('DoctrineMigrations\\Version20200921083307', '2020-09-21 10:33:15', 138),
('DoctrineMigrations\\Version20200921084457', '2020-09-21 10:45:03', 57),
('DoctrineMigrations\\Version20200921085026', '2020-09-21 10:50:33', 42),
('DoctrineMigrations\\Version20200921112117', '2020-09-21 13:21:27', 92),
('DoctrineMigrations\\Version20200922112923', '2020-09-22 13:29:32', 146),
('DoctrineMigrations\\Version20200923143933', '2020-09-23 16:39:46', 99),
('DoctrineMigrations\\Version20200925153119', '2020-09-25 17:31:28', 121),
('DoctrineMigrations\\Version20200925154626', '2020-09-25 17:46:33', 77),
('DoctrineMigrations\\Version20200928091317', '2020-09-28 11:14:57', 46);

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
(14, 4, '2015-01-01', 'Proyecto C3-2', 'fdgs', 'gfdsgfd', 'ALPHA', 'Wordpress', 0),
(15, 2, '2015-01-01', 'Proyecto 4', 'fdsgfdgsgfdsg', 'dsaf', 'PRODUCCION', 'SEO', 0),
(16, 1, '2021-05-06', 'dsafs', 'sdafdsa', 'fdsafdsa', 'ALPHA', 'Symfony', 0),
(17, 2, '2031-08-19', 'gfdsg', 'fdsgsfd', 'gfdsfg', 'PRODUCCION', 'Symfony', 0),
(18, 1, '2000-05-31', 'sadf', 'dsaf', 'dsfaf', 'PRODUCCION', 'Symfony', 0),
(19, 1, '2040-09-22', 'sgfds', 'gfdsg', 'fdgsdf', 'ALPHA', 'Symfony', 0),
(20, 14, '2020-09-30', 'Lepsia APP', 'lepsiapp.app', 'lepsiapp.app', 'BETA', 'Symfony', 0),
(24, 8, '2020-10-01', 'Nuevo', 'http://www.google.com', 'http://www.google.com', 'BETA', 'Prestashop', 0),
(25, 8, '2020-10-02', 'New Project', 'http://www.hola.com', 'http://www.hola.com', 'BETA', 'Symfony', 0),
(26, 4, '1900-10-02', '1111', 'http://www.ya.com', 'http://www.ya.com', 'PRODUCCION', 'Wordpress', 0);

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
(13, 26),
(13, 28),
(13, 29),
(13, 35),
(14, 28),
(14, 29),
(14, 35),
(15, 28),
(16, 29),
(17, 38),
(18, 35),
(19, 38),
(20, 26),
(24, 35),
(25, 41),
(26, 26);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observaciones` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `block_id` int(11) DEFAULT NULL,
  `desactivar` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `question`
--

INSERT INTO `question` (`id`, `description`, `observaciones`, `imagen`, `block_id`, `desactivar`) VALUES
(18, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, co', 'aaaaaaaaa', NULL, 26, 0),
(43, 'bbbbbbbbb', 'bbbbbbbbbb', NULL, 26, 0),
(44, 'cccccccc', 'ccccc', NULL, 26, 0),
(48, 'Pregunta deshabilitada', 'ytrutyruyt', NULL, 26, 1),
(49, 'dfsgf', '32red', NULL, 46, 0),
(50, 'vbcx', 'bvcbvcxb', NULL, 46, 1),
(53, 'Pregunta  nueva', 'pregunta nueva', NULL, 26, 0),
(74, 'Pregunta 1', 'fdsgfdsg', '6b8d93efa80e643861ceadc0c5091d0c.jpeg', 74, 0),
(75, 'Pregunta 2', 'fdgdfsgsd', '41cd59c602706a577b46826439baa1ff.png', 74, 0),
(76, 'Pregunta 3', 'dfgfds', 'c5aae832312f9132d8cb923692490fc2.jpeg', 74, 0),
(77, 'gdfs', 'gfdgfsd', 'd05d7daee861185d0ba22a598833fee1.jpeg', 67, 0),
(78, 'fdgfdgs', 'gsdfg', '6e19d285becfd5292f5ea9c3be0715ea.jpeg', 67, 0),
(79, 'Question 1', 'gfdsgfsd', 'bd21931bb892a383de8af9b5fdf8808b.png', 66, 0),
(80, 'Pregunta 2', 'fdsgfdsg', '92e775ff198cd9e177c08cc1d4485950.jpeg', 66, 0),
(81, 'Hola', 'gfdhgfdh', '4f1b8c07f5874761c4f92360cc953594.png', 78, 0),
(82, 'Pregunta 1', 'sdfgf', '51a5cb39a56129cf700d31cbe8061c16.png', 82, 0),
(83, 'Pregunta 2', 'dsgfdsg', '3bd00b20382548e5022081ed50cc40a5.jpeg', 82, 0),
(84, 'Pregunta 3', 'fdgsdfsg', 'eea1513fffd598c22e6c77564641b978.jpeg', 82, 0),
(85, 'gdsgdf', '432432', '5a13a1529522ea76c491a333cb8adce3.jpeg', 143, 0),
(86, 'fsdaf', '32423', '998e520ac725054d2fb5b5a072b8df8d.jpeg', 143, 0),
(87, 'Pregunta 1', 'fdgfds', 'fbfea57e5f4c1ff4a2a1d3b8fd1ae48f.jpeg', 145, 0),
(88, 'Pregunta 2', 'dsfgfdg', '506c45e1a21f6efd7d7d6f6e7b0ee72f.png', 145, 0),
(89, 'Pregunta 3', '', '53b726db82c2f7dd62f95aca5f3c3978.jpeg', 145, 0),
(90, 'P4', '', '792c921680491a90088fc4e611c93ad9.jpeg', 147, 1),
(91, 'P5', '', '0d25ba1689f98fcc330724b50aba70f9.jpeg', 147, 1),
(92, 'fdsggfds', '', '31a505db44278975847671cd9dab6b58.jpeg', 150, 0),
(93, 'dsfgds', '', '6081e7da1486e11e29817f794e6e7420.jpeg', 150, 0),
(94, 'aaa', '', 'f0911b218f70c4f4857298eb3981521a.jpeg', 150, 0),
(95, 'New Question', '', '0d08a21b831170471557b6dc7996a9a4.jpeg', 150, 0),
(96, 'bbb', '', '59aa2281fae0913f9eb0b3c801044fed.jpeg', 150, 0),
(97, 'ccc', 'cccccccccccccc', '8d1ca4333c9c7406cc4cf2178a50feae.png', 150, 1),
(98, 'Nueva 1', '', NULL, 150, 0),
(99, 'Nueva 2', '', NULL, 150, 0),
(100, 'Nueva 3', '', NULL, 150, 0),
(101, 'sadfasd', 'sdafasd', 'aaf061b818fb1130a86a4ebb024cdd3d.png', 160, 0),
(102, '111', '111', NULL, 153, 0),
(103, '222', '222', NULL, 153, 0),
(104, 'Editada 2', 'Editada 2', 'bd90eca8509b2c8820384d85d8dca603.png', 136, 0),
(105, 'Editada 1', 'Editada 1', '28dcd6f167bf6c5b08a7c8c71023476a.png', 136, 0),
(106, 'Pregunta 1', '1', '81c2fee1e8ba5429b679fafbd19e5c8a.jpeg', 162, 0),
(107, 'Pregunta 2', '2', '2f871571a4f61dcd8a1c570ef6387d1f.jpeg', 162, 0),
(108, 'Edit 1', 'Edit 1', '75f3970ead23da77a76007b7be50e053.png', 160, 0),
(109, 'Edit 2', 'Edit 2', '9dea4d7ba2d78245a38f81c0c8485c0e.png', 160, 0),
(110, 'Nueva', 'Nueva', 'e67c6e8fce22c58ecd3fa2f36f2850dd.png', 136, 0),
(111, '', '', NULL, 136, 0),
(112, 'Adios', 'Adios', 'a30687a7c636eabd8aab7091bd1e5495.jpeg', 136, 0),
(113, 'aaaa', 'aaaa', '37deab4412a9fd6410bc848a807e4a69.png', 136, 0),
(114, 'klhjklkjhgfdgsfd', 'gfdsgfdsg', '65714cdcc513a4b2a538bba0c8e7fb9f.png', 136, 0),
(115, 'Hola', '', NULL, 136, 0),
(116, 'Prueba 1', '1', 'afc8bc12d173e2f38fcafa004047c408.png', 136, 0),
(117, 'Prueba 2', '2', 'c488bf275b34d5754fce92aaae999df6.png', 136, 0),
(118, 'Hola 1', '', '3d79e6111cdeb54b2f3f1342ca3760d3.png', 160, 0),
(119, 'Adios', '', NULL, 160, 0);

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
(45, 35, 'kS9RvnBk6jJSnLqPdNTU', 'tCcUmXu0ZczFw17cH7sxKiM+1z7oMsFI5JcmkBUlNJ4=', '2020-10-07 17:02:33', '2020-10-07 18:02:33');

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
(6, 'Server 3', 'S3', '192.168.52.6', 'http://www.hola.com', 'User 3', '3333', 'Desarrollo', 1);

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
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `test`
--

INSERT INTO `test` (`id`, `customer_id`, `project_id`, `user_id`, `alias`, `tipo`, `desactivar`, `estado`, `fecha`) VALUES
(20, 1, 12, 27, 'Test 1', 'ALPHA', 0, 'No Iniciado', '2020-09-29'),
(28, 2, 10, 26, 'Comprobar Test', 'ALPHA', 0, 'En Curso', '2020-09-28'),
(29, 1, 11, 26, 'Test 5', 'ALPHA', 0, 'Realizado', '2020-09-01'),
(30, 2, 10, 26, 'sdafdsa', 'ALPHA', 0, 'No Iniciado', '2020-09-10'),
(42, 1, 12, 26, 'dfsgsdfg', 'ALPHA', 1, 'Desactivado', '2020-09-14'),
(48, 4, 14, 26, 'Test de prueba', 'BETA', 0, 'Realizado', '2020-09-17'),
(51, 1, 19, 26, 'bbbbbbbbb', 'ALPHA', 0, 'No Iniciado', '2020-09-17'),
(52, 1, 19, 26, 'bbbbbbbbb', 'BETA', 0, 'No Iniciado', '2020-10-06'),
(54, 1, 19, 26, 'Test 54', 'ALPHA', 0, 'En Curso', '2020-09-27'),
(56, 14, 20, 26, 'Lepsia APP WEB Test', 'BETA', 0, 'En Curso', '2020-09-30'),
(57, 1, 19, 26, 'Nuevo', 'ALPHA', 0, 'En Curso', '2020-10-06'),
(59, 1, 19, 26, 'fgdsgfds', 'ALPHA', 0, 'En Curso', '2020-09-30'),
(60, 1, 19, 26, 'Hola', 'ALPHA', 1, 'Desactivado', '2020-10-06'),
(61, 4, 14, 30, 'Nuevo', 'BETA', 0, 'En Curso', '2020-10-05'),
(62, 2, 15, 27, 'aaaaaaaaaa1111', 'ALPHA', 0, 'En Curso', '2020-10-05'),
(63, 8, 25, 29, 'Test de prueba', 'BETA', 0, 'En Curso', '2020-10-05'),
(64, 1, 19, 26, 'AAA', 'ALPHA', 0, 'En Curso', '2020-10-05'),
(65, 4, 26, 30, 'Test de prueba 2', 'BETA', 0, 'En Curso', '2020-10-06');

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
(26, 'wip-testing-user', 'wip@wip.com', 'WIIP', '$2y$13$WSidQwdLhinGbC4udV3j7eu6X7wMswXfeax5O/DAzY1EjlPeZJUcS', 1, '[\"ROLE_WIP\"]'),
(27, 'User 1', 'user1@user1.com', 'CLIENTE', '$2y$13$FWpg7moIa2ormuE5Bj152eREk0F8aS8GEIcIRe2bgp1gAoq8q67Rm', 1, '[\"ROLE_USER\"]'),
(28, 'wip2', 'wip2@wip2.com', 'WIIP', '$2y$13$ajaliYhrHRi0tBCYarK0huNPTqYpbDZWzw9xsph1ehKaebzFrXfPy', 1, '[\"ROLE_WIP\"]'),
(29, 'wip3', 'wip3@wip3.com', 'WIIP', '$2y$13$5jpAdbNm/A5Me0rQdnNoguW1B5WtVsAYaQcVbQvxfewfrrqVcNzVu', 1, '[\"ROLE_WIP\"]'),
(30, 'User 2', 'user2@user2.com', 'CLIENTE', '$2y$13$a7.dF15YkIII9luqi/QZ8OMYMGEsg.sz1gI58dQhn9Y5kFzmcg9jC', 1, '[\"ROLE_USER\"]'),
(35, 'Alberto', 'badyalberto@gmail.com', 'WIIP', '$2y$13$SAx.CK8IVJexO2WzLQXaeunbccgoijJsqONUABA3nwckafuIXl4vm', 1, '[\"ROLE_WIP\"]'),
(38, 'cccc', 'a@a.com', 'WIIP', '$2y$13$E8W9twI1YzbFYNJlB2icjeoXc2cqANT4oI24FOFPQL3Y8Xyh3xdvW', 0, '[\"ROLE_WIP\"]'),
(41, 'wip4', 'wip4@wip4.com', 'WIIP', '$2y$13$ZWsA3OQe/h18NIf.HhXH/u9TFEw8aYjinxCi2VZeS5JCZ8ygdjm2.', 1, '[\"ROLE_WIP\"]'),
(42, 'ivan', 'ivan@ivan.com', 'WIIP', '$2y$13$s77MBL3GO5PB2U35ysNLmepLMUu.6Ym6DN5h0qxfWA3/YfhBVdkEK', 1, '[\"ROLE_WIP\"]'),
(50, 'ddd', 'ddd@ddd.com', 'WIIP', '$2y$13$ozXcXUuqa8r2k1FOwTLJsuc89xwk6UFbkWtsiG.B9b/GVPK6zc0hK', 1, '[\"ROLE_WIP\"]');

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
(14, 30),
(15, 30),
(16, 30),
(17, 30),
(18, 30),
(19, 27),
(20, 27),
(24, 30),
(25, 30),
(26, 27);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_DADD4A251E27F6BF` (`question_id`);

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
-- AUTO_INCREMENT de la tabla `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de la tabla `block`
--
ALTER TABLE `block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT de la tabla `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT de la tabla `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `server`
--
ALTER TABLE `server`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `FK_DADD4A251E27F6BF` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`);

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
