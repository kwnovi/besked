-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Sam 22 Mars 2014 à 01:40
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

-- --------------------------------------------------------

--
-- Structure de la table `discussion`
--

DROP TABLE IF EXISTS `discussion`;
CREATE TABLE IF NOT EXISTS `discussion` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

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
