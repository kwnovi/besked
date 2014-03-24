-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 24 Mars 2014 à 05:48
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `besked`
--
CREATE DATABASE IF NOT EXISTS `besked` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `besked`;

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `user_id_1` bigint(20) unsigned NOT NULL,
  `user_id_2` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`user_id_1`,`user_id_2`),
  KEY `FK_CONTACT_2` (`user_id_2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `contact`
--

TRUNCATE TABLE `contact`;
--
-- Contenu de la table `contact`
--

INSERT INTO `contact` (`user_id_1`, `user_id_2`) VALUES
(16, 8),
(16, 17),
(22, 17),
(16, 22),
(16, 29);

-- --------------------------------------------------------

--
-- Structure de la table `discussion`
--

DROP TABLE IF EXISTS `discussion`;
CREATE TABLE IF NOT EXISTS `discussion` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Vider la table avant d'insérer `discussion`
--

TRUNCATE TABLE `discussion`;
--
-- Contenu de la table `discussion`
--

INSERT INTO `discussion` (`id`, `created_datetime`, `title`) VALUES
(11, '2014-03-24 04:36:33', 'RÃ©union prÃ©paration projet'),
(12, '2014-03-24 04:43:23', 'RÃ©union BDE'),
(13, '2014-03-24 04:50:48', 'PrÃ©paration soutenance'),
(14, '2014-03-24 04:58:18', 'SoirÃ©e BDE'),
(15, '2014-03-24 05:01:20', 'Concert samedi');

-- --------------------------------------------------------

--
-- Structure de la table `discussion_message`
--

DROP TABLE IF EXISTS `discussion_message`;
CREATE TABLE IF NOT EXISTS `discussion_message` (
  `discussion_id` bigint(20) unsigned NOT NULL,
  `message_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`discussion_id`,`message_id`),
  KEY `FK_DISCUSSION_MESSAGE_M` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `discussion_message`
--

TRUNCATE TABLE `discussion_message`;
--
-- Contenu de la table `discussion_message`
--

INSERT INTO `discussion_message` (`discussion_id`, `message_id`) VALUES
(13, 64),
(13, 65),
(14, 66),
(15, 67);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_unicode_ci,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `discussion_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_MESSAGE_USER` (`user_id`),
  KEY `FK_MESSAGE_DISCUSSION` (`discussion_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=68 ;

--
-- Vider la table avant d'insérer `message`
--

TRUNCATE TABLE `message`;
--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id`, `content`, `created`, `discussion_id`, `user_id`) VALUES
(64, 'T''as bien le diapo en tÃªte pour demain ?', '2014-03-24 04:50:48', 13, 17),
(65, 'Pas de soucis !', '2014-03-24 04:51:19', 13, 16),
(66, 'PrÃªts Ã  faire la fÃªte ?', '2014-03-24 04:58:18', 14, 16),
(67, 'Il y a Henri DÃ©s qui passe au BT, Ã§a vous dis ?', '2014-03-24 05:01:20', 15, 22);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_datetime` date NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;

--
-- Vider la table avant d'insérer `user`
--

TRUNCATE TABLE `user`;
--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `created_datetime`, `email`, `nickname`, `password`, `picture_path`) VALUES
(1, '2014-02-05', 't@t.fr', 'Fabio Papace', 'tata', NULL),
(2, '2014-02-26', 'a@a.fr', 'Mathilde Marlier', 'bon', NULL),
(8, '2014-05-01', 'jam@bon.fr', 'Clara Fayez', 'le', NULL),
(9, '2014-05-01', 'jam@bon.fr', 'Sacha Coulot', 'le', NULL),
(10, '2014-05-01', 'jam@bon.fr', 'Camille Mougin', 'le', NULL),
(11, '2014-05-01', 'jam@bon.fr', 'Aliénor Beaumanoir', 'le', NULL),
(12, '2014-05-01', 'jam@bon.fr', 'Juliette Bessette', 'le', NULL),
(13, '2014-05-01', 'jam@bon.fr', 'Prune Varey', 'le', NULL),
(14, '2014-05-01', 'jam@bon.fr', 'Eva Mouquin', 'le', NULL),
(15, '2014-02-16', 'toto@tata.fr', 'Marie Jounin', 'tom7WQsLPxP5U', NULL),
(16, '2014-02-16', 'n@n.fr', 'Quentin Le Bour', 'toA7xpmJRmmtc', NULL),
(17, '2014-02-24', 'g@g.fr', 'Lucien Varacca', 'toA7xpmJRmmtc', NULL),
(18, '2014-03-22', 'h@h.fr', 'Paul Guyot', 'toA7xpmJRmmtc', NULL),
(19, '2014-03-22', 'k@k.fr', 'Simon Vanson', 'toA7xpmJRmmtc', NULL),
(20, '2014-03-23', 'e@e.fr', 'Alexia Bing', 'toHX2WZaju5NE', NULL),
(21, '2014-03-23', 'r@r.fr', 'Clara Fayez', 'toA7xpmJRmmtc', NULL),
(22, '2014-03-23', 'y@y.fr', 'Marine Deya', 'toA7xpmJRmmtc', NULL),
(23, '2014-03-23', 'u@u.fr', 'Amélie Templin', 'toA7xpmJRmmtc', NULL),
(24, '2014-03-23', 'i@i.fr', 'Fabio Papace', 'toA7xpmJRmmtc', NULL),
(25, '2014-03-23', 'q@q.fr', 'Noé Tourneux ', 'toA7xpmJRmmtc', NULL),
(26, '2014-03-23', 'qq@q.fr', 'Lucas Bertin', 'toA7xpmJRmmtc', NULL),
(27, '2014-03-23', 'qqq@q.fr', 'Hugo Mathieu', 'toA7xpmJRmmtc', NULL),
(28, '2014-03-23', 'a@q.fr', 'Mathilde Marlier', 'toA7xpmJRmmtc', NULL),
(29, '2014-03-23', 'z@q.fr', 'Alice Nicolas', 'toA7xpmJRmmtc', NULL),
(30, '2014-03-23', 'ab@b.fr', 'Melissa Gourlin', 'toA7xpmJRmmtc', NULL),
(31, '2014-03-24', 'aa@aa.fr', 'Bernard Bertrand', 'toA7xpmJRmmtc', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users_status`
--

DROP TABLE IF EXISTS `users_status`;
CREATE TABLE IF NOT EXISTS `users_status` (
  `user_id` bigint(20) unsigned NOT NULL,
  `session_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_connection` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `users_status`
--

TRUNCATE TABLE `users_status`;
--
-- Contenu de la table `users_status`
--

INSERT INTO `users_status` (`user_id`, `session_id`, `last_connection`, `status`) VALUES
(31, NULL, '2014-03-24 05:31:19', 0);

-- --------------------------------------------------------

--
-- Structure de la table `user_discussion`
--

DROP TABLE IF EXISTS `user_discussion`;
CREATE TABLE IF NOT EXISTS `user_discussion` (
  `user_id` bigint(20) unsigned NOT NULL,
  `discussion_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`discussion_id`),
  KEY `FK_USER_DISCUSSION_D` (`discussion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `user_discussion`
--

TRUNCATE TABLE `user_discussion`;
--
-- Contenu de la table `user_discussion`
--

INSERT INTO `user_discussion` (`user_id`, `discussion_id`) VALUES
(16, 13),
(17, 13),
(8, 14),
(16, 14),
(17, 14),
(22, 14),
(29, 14),
(16, 15),
(17, 15),
(22, 15);

-- --------------------------------------------------------

--
-- Structure de la table `user_message`
--

DROP TABLE IF EXISTS `user_message`;
CREATE TABLE IF NOT EXISTS `user_message` (
  `user_id` bigint(20) unsigned NOT NULL,
  `message_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`message_id`),
  KEY `FK_USER_MESSAGE_M` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `user_message`
--

TRUNCATE TABLE `user_message`;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `FK_CONTACT_1` FOREIGN KEY (`user_id_1`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_CONTACT_2` FOREIGN KEY (`user_id_2`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `discussion_message`
--
ALTER TABLE `discussion_message`
  ADD CONSTRAINT `FK_DISCUSSION_MESSAGE_D` FOREIGN KEY (`discussion_id`) REFERENCES `discussion` (`id`),
  ADD CONSTRAINT `FK_DISCUSSION_MESSAGE_M` FOREIGN KEY (`message_id`) REFERENCES `message` (`id`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_MESSAGE_DISCUSSION` FOREIGN KEY (`discussion_id`) REFERENCES `discussion` (`id`),
  ADD CONSTRAINT `FK_MESSAGE_USER` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `users_status`
--
ALTER TABLE `users_status`
  ADD CONSTRAINT `users_status_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `user_discussion`
--
ALTER TABLE `user_discussion`
  ADD CONSTRAINT `FK_USER_DISCUSSION_D` FOREIGN KEY (`discussion_id`) REFERENCES `discussion` (`id`),
  ADD CONSTRAINT `FK_USER_DISCUSSION_U` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `user_message`
--
ALTER TABLE `user_message`
  ADD CONSTRAINT `FK_USER_MESSAGE_M` FOREIGN KEY (`message_id`) REFERENCES `message` (`id`),
  ADD CONSTRAINT `FK_USER_MESSAGE_U` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
