-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 15 juil. 2024 à 21:12
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `title`, `description`) VALUES
(1, 'Food', 'Description nourrissante'),
(2, 'Wild Life', 'On est sauvage'),
(3, 'Art', 'C&#039;est une description artistique'),
(7, 'Technologie', 'Le Turfu'),
(5, 'Non cat&eacute;goris&eacute;', 'pas de yoyo');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `body` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int UNSIGNED DEFAULT NULL,
  `author_id` int UNSIGNED NOT NULL,
  `is_featured` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_blog_category` (`category_id`),
  KEY `FK_blog_author` (`author_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `thumbnail`, `date_time`, `category_id`, `author_id`, `is_featured`) VALUES
(12, 'un post animal', 'graou graou', '1721053176blog68.jpg', '2024-07-15 14:19:07', 2, 13, 0),
(5, 'yrryry', 'zforjkg', '1720782789blog32.jpg', '2024-07-12 11:13:09', 3, 18, 0),
(6, 'Un post artistique', 'Une description artistique', '1720985577blog37.jpg', '2024-07-13 09:54:31', 3, 13, 0),
(7, 'Un article all&eacute;chant', 'Contrairement &agrave; une opinion r&eacute;pandue, le Lorem Ipsum n&#039;est pas simplement du texte al&eacute;atoire. Il trouve ses racines dans une oeuvre de la litt&eacute;rature latine classique datant de 45 av. J.-C., le rendant vieux de 2000 ans. Un professeur du Hampden-Sydney College, en Virginie, s&#039;est int&eacute;ress&eacute; &agrave; un des mots latins les plus obscurs, consectetur, extrait d&#039;un passage du Lorem Ipsum, et en &eacute;tudiant tous les usages de ce mot dans la litt&eacute;rature classique, d&eacute;couvrit la source incontestable du Lorem Ipsum. Il provient en fait des sections 1.10.32 et 1.10.33 du &quot;De Finibus Bonorum et Malorum&quot; (Des Supr&ecirc;mes Biens et des Supr&ecirc;mes Maux) de Cic&eacute;ron. Cet ouvrage, tr&egrave;s populaire pendant la Renaissance, est un trait&eacute; sur la th&eacute;orie de l&#039;&eacute;thique. Les premi&egrave;res lignes du Lorem Ipsum, &quot;Lorem ipsum dolor sit amet...&quot;, proviennent de la section 1.10.32.\r\n\r\nL&#039;extrait standard de Lorem Ipsum utilis&eacute; depuis le XVI&egrave; si&egrave;cle est reproduit ci-dessous pour les curieux. Les sections 1.10.32 et 1.10.33 du &quot;De Finibus Bonorum et Malorum&quot; de Cic&eacute;ron sont aussi reproduites dans leur version originale, accompagn&eacute;e de la traduction anglaise de H. Rackham (1914).', '1721053191blog13.jpg', '2024-07-13 18:39:18', 1, 13, 0),
(11, 'Un titre trop alléchant', 'une description trop alléchante', '1721031345blog97.jpg', '2024-07-15 08:15:45', 1, 20, 0),
(13, 'un truc artiste', 'yoyoyo', '1721057263blog96.jpg', '2024-07-15 15:27:43', 3, 13, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `avatar`, `is_admin`) VALUES
(20, 'dave', 'dove', 'dadou', 'du@du.io', '$2y$10$1FywqYHrHwtz65fkG/J0.OfKfKvd8Hk00mwN.UdSPSu4HAm6gTufm', '1721031061avatar15.jpg', 0),
(18, 'Jackeline', 'Nicholson', 'yayaya', 'ya@ya.io', '$2y$10$UMY0udOnQzO5La2J4fiLM.E6lczgisi9i/5IFbDJg1Yir3hG/Y7ZC', '1720782735avatar4.jpg', 0),
(13, 'Elias', 'Cardon', 'Jobba', 'elias.cardon@laplateforme.io', '$2y$10$yq1GhB1Rz2wmstwLkD8njeq3SrIyB73lGZPveeZVLOLd5fgP2RSSG', 'avatar3.jpg', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
