-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 05, 2025 at 11:04 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capagiic`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

DROP TABLE IF EXISTS `answer`;
CREATE TABLE IF NOT EXISTS `answer` (
  `id_q` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `q_form` int NOT NULL,
  `q_question` int NOT NULL,
  `q_answer` int NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `id_q` (`id_q`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cited`
--

DROP TABLE IF EXISTS `cited`;
CREATE TABLE IF NOT EXISTS `cited` (
  `id_ct` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ct_cited` text NOT NULL,
  `ct_link` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `id_ct` (`id_ct`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cited`
--

INSERT INTO `cited` (`id_ct`, `ct_cited`, `ct_link`, `created`) VALUES
(1, 'Acesso gratuito a todas as normas de acessibilidade da ABNT', 'https://www.abntcolecao.com.br/mpf/grid.aspx', '2025-09-05 10:13:24'),
(2, 'Acesso gratuito a todas as normas de acessibilidade da ABNT', 'https://www.mpf.mp.br/sp/sala-de-imprensa/prdc/sala-de-imprensa/noticias_prdc/consulta-a-normas-de-acessibilidade-da-abnt', '2025-09-05 10:13:46');

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

DROP TABLE IF EXISTS `form`;
CREATE TABLE IF NOT EXISTS `form` (
  `id_f` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `f_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `f_user` int NOT NULL,
  `f_thema` int NOT NULL,
  `f_status` int NOT NULL DEFAULT '0',
  UNIQUE KEY `id_f` (`id_f`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `id_q` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `q_question_id` char(10) NOT NULL,
  `q_thema` int NOT NULL,
  `q_ordem` int NOT NULL,
  `q_question` text NOT NULL,
  `q_description` longtext,
  `q_answer_01` text NOT NULL,
  `q_answer_02` text NOT NULL,
  `q_answer_03` text NOT NULL,
  `q_answer_04` text NOT NULL,
  `q_answer_05` text NOT NULL,
  `q_answer_06` text NOT NULL,
  `q_answer_07` text NOT NULL,
  `q_answer_08` text NOT NULL,
  `q_answer_09` text NOT NULL,
  `q_pt_answer_01` int NOT NULL DEFAULT '0',
  `q_pt_answer_02` int NOT NULL DEFAULT '0',
  `q_pt_answer_03` int NOT NULL DEFAULT '0',
  `q_pt_answer_04` int NOT NULL DEFAULT '0',
  `q_pt_answer_05` int NOT NULL DEFAULT '0',
  `q_pt_answer_06` int NOT NULL DEFAULT '0',
  `q_pt_answer_07` int NOT NULL DEFAULT '0',
  `q_pt_answer_08` int NOT NULL DEFAULT '0',
  `q_pt_answer_09` int NOT NULL DEFAULT '0',
  `q_multiple` int NOT NULL DEFAULT '0',
  UNIQUE KEY `id_q` (`id_q`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id_q`, `q_question_id`, `q_thema`, `q_ordem`, `q_question`, `q_description`, `q_answer_01`, `q_answer_02`, `q_answer_03`, `q_answer_04`, `q_answer_05`, `q_answer_06`, `q_answer_07`, `q_answer_08`, `q_answer_09`, `q_pt_answer_01`, `q_pt_answer_02`, `q_pt_answer_03`, `q_pt_answer_04`, `q_pt_answer_05`, `q_pt_answer_06`, `q_pt_answer_07`, `q_pt_answer_08`, `q_pt_answer_09`, `q_multiple`) VALUES
(1, '1.1.1', 1, 1, 'Há linha de transporte urbano coletivo adaptado para o transporte de pessoas com deficiência ou mobilidade reduzida que permita o acesso ao entorno do prédio. (Conforme NBR 14022:2011)', NULL, 'Sim', 'Não', 'Parcialmente', 'Em implantação', 'Não se aplica', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, '1.1.2', 1, 2, ' O percurso entre o ponto mais próximo de embarque e desembarque do transporte coletivo até a entrada do prédio é livre de obstáculos. (ex.: degraus, blocos de concreto, grelhas ou barras de ferro sobressalentes no piso).', NULL, 'Sim', 'Não', 'Parcialmente', 'Em implantação', 'Não se aplica', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, '1.1.3', 1, 3, 'As calçadas, passeios e vias exclusivas de pedestres que dão acesso ao prédio estão livres, completamente desobstruídas e isentas de interferências.', NULL, 'Sim', 'Não', 'Parcialmente', 'Em implantação', 'Não se aplica', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, '1.1.5', 1, 5, 'O piso no entorno do prédio (parte externa, calçada, estacionamento...) apresenta sinalização tátil do tipo direcional e  de alerta, compondo uma rota acessível ao pedestre. (A instalação do piso tátil deve estar em conformidade com a NBR 16537:2024).', NULL, 'Sim', 'Não', 'Parcialmente', 'Em implantação', 'Não se aplica', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, '1.1.6', 1, 6, 'As calçadas no entorno do prédio apresentam rebaixamentos devidamente sinalizados com piso tátil de alerta.', NULL, 'Sim', 'Não', 'Parcialmente', 'Em implantação', 'Não se aplica', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, '1.1.7', 1, 7, 'As calçadas no entorno do prédio apresentam rebaixamentos devidamente sinalizados com no aspecto visual, com contraste visual entre o piso tátil de alerta e o piso adjacente.', NULL, 'Sim', 'Não', 'Parcialmente', 'Em implantação', 'Não se aplica', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, '1.1.8', 1, 8, 'Nos rebaixamentos de calçadas, quando houver sinalização tátil direcional, há o encontro desta com a sinalização tátil de alerta.', NULL, 'Sim', 'Não', 'Parcialmente', 'Em implantação', 'Não se aplica', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, '1.1.9', 1, 9, 'As calçadas, passeios e vias exclusivas de pedestres que dão acesso ao prédio apresentam largura mínima de 1,20m e altura livre mínima de 2,10m.', NULL, 'Sim', 'Não', 'Parcialmente', 'Em implantação', 'Não se aplica', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, '1.1.10', 1, 10, 'Em caso de obras sobre a calçada, estas estão convenientemente sinalizadas e isoladas, assegurando-se a largura mínima de 1,20m para circulação de pessoas. (Na impossibilidade de acesso pela calçada, deve ser feito desvio pelo leito carroçável (1)da via, providenciando-se uma rampa provisória com inclinação máxima de 10%)', NULL, 'Sim', 'Não', 'Parcialmente', 'Em implantação', 'Não se aplica', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, '1.1.11', 1, 11, 'A inclinação transversal do piso no exterior do prédio é de no máximo 3% e a inclinação longitudinal máxima é de 5%. (Inclinações iguais ou superiores a 5 % são consideradas rampas e, portanto, devem atender ao item 6.6 da NBR 9050:2020).', NULL, 'Sim', 'Não', 'Parcialmente', 'Em implantação', 'Não se aplica', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, '1.1.12', 1, 12, 'Próximo à entrada principal do prédio há faixa de travessia de pedestres com sinalização visual e sonora.', NULL, 'Sim', 'Não', 'Parcialmente', 'Em implantação', 'Não se aplica', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, '1.1.13', 1, 13, 'Nas faixas de travessia, é instalada a sinalização tátil de alerta posicionada paralelamente à faixa de travessia ou perpendicularmente ao deslocamento, à distância de 0,50m do meio-fio.', NULL, 'Sim', 'Não', 'Parcialmente', 'Em implantação', 'Não se aplica', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, '1.1.14', 1, 14, 'São disponibilizados, em espaços físicos com grande extensão, equipamentos de auxílio à mobilidade para pessoas com dificuldades de locomoção.', NULL, 'Sim', 'Não', 'Parcialmente', 'Em implantação', 'Não se aplica', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, '1.1.4', 1, 4, ' As calçadas no entorno do prédio apresentam bom estado de conservação (sem buracos ou pedras soltas no pavimento).', NULL, 'Sim', 'Não', 'Parcialmente', 'Em implantação', 'Não se aplica', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `themas`
--

DROP TABLE IF EXISTS `themas`;
CREATE TABLE IF NOT EXISTS `themas` (
  `id_th` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `th_name` char(150) NOT NULL,
  `th_description` longtext NOT NULL,
  `th_icone` int NOT NULL,
  `th_user` int NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `id_th` (`id_th`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `themas`
--

INSERT INTO `themas` (`id_th`, `th_name`, `th_description`, `th_icone`, `th_user`, `created`) VALUES
(1, 'Checklist completo', '', 0, 0, '2025-09-05 10:08:07'),
(2, 'Acessibilidade do mobiliário e equipamentos', '', 0, 0, '2025-09-05 10:08:07'),
(3, 'Acessibilidade arquitetônica', '', 0, 0, '2025-09-05 10:08:27'),
(4, 'Checklist completo', '', 0, 0, '2025-09-05 10:08:45'),
(5, 'Acessibilidade comunicacional', '', 0, 0, '2025-09-05 10:08:45'),
(6, 'Checklist completo', '', 0, 0, '2025-09-05 10:09:01'),
(7, 'Acessibilidade à informação', '', 0, 0, '2025-09-05 10:09:01'),
(8, 'Checklist completo', '', 0, 0, '2025-09-05 10:09:13'),
(9, 'Acessibilidade instrumental', '', 0, 0, '2025-09-05 10:09:13'),
(10, 'Checklist completo', '', 0, 0, '2025-09-05 10:09:27'),
(11, 'Acessibilidade metodológica', '', 0, 0, '2025-09-05 10:09:27'),
(12, 'Checklist completo', '', 0, 0, '2025-09-05 10:09:40'),
(13, 'Acessibilidade programática', '', 0, 0, '2025-09-05 10:09:40'),
(14, 'Acessibilidade atitudinal', '', 0, 0, '2025-09-05 10:10:09'),
(15, 'Referências', 'Acesso gratuito a todas as normas de acessibilidade da ABNT:  https://www.abntcolecao.com.br/mpf/grid.aspx\r\n\r\nAcesso gratuito a todas as normas de acessibilidade da ABNT:\r\nhttps://www.mpf.mp.br/sp/sala-de-imprensa/prdc/sala-de-imprensa/noticias_prdc/consulta-a-normas-de-acessibilidade-da-abnt', 0, 0, '2025-09-05 10:11:16');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_us` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `us_nome` char(100) NOT NULL,
  `us_email` char(100) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `us_instituicao` int NOT NULL,
  UNIQUE KEY `id_us` (`id_us`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_us`, `us_nome`, `us_email`, `created`, `us_instituicao`) VALUES
(1, 'Rene Faustino Gabriel Junior', 'renefgj@gmail.com', '2025-09-05 10:56:25', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
