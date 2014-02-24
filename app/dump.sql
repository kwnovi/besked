-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 04 Février 2014 à 09:52
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
-- Structure de la table `DISCUSSION`
--

DROP TABLE IF EXISTS `DISCUSSION`;
CREATE TABLE IF NOT EXISTS `DISCUSSION` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_datetime` date NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  CONSTRAINT PK_DISCUSSION PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


--
-- Structure de la table `MESSAGE`
--

DROP TABLE IF EXISTS `MESSAGE`;
CREATE TABLE IF NOT EXISTS `MESSAGE` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_unicode_ci,
  `created_datetime` date NOT NULL,
  `discussion_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  CONSTRAINT PK_MESSAGE PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `USER`
--

DROP TABLE IF EXISTS `USER`;
CREATE TABLE IF NOT EXISTS `USER` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_datetime` date NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  CONSTRAINT PK_USER PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `USER_DISCUSSION`
--

DROP TABLE IF EXISTS `USER_DISCUSSION`;
CREATE TABLE IF NOT EXISTS `USER_DISCUSSION` (
  `user_id` bigint(20) unsigned NOT NULL,
  `discussion_id` bigint(20) unsigned NOT NULL,
  CONSTRAINT PK_USER_DISCUSSION PRIMARY KEY (`user_id`,`discussion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `USER_MESSAGE`
--

DROP TABLE IF EXISTS `USER_MESSAGE`;
CREATE TABLE IF NOT EXISTS `USER_MESSAGE` (
  `user_id` bigint(20) unsigned NOT NULL,
  `message_id` bigint(20) unsigned NOT NULL,
  CONSTRAINT PK_USER_MESSAGE PRIMARY KEY (`user_id`,`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `DISCUSSION_MESSAGE`
--

DROP TABLE IF EXISTS `DISCUSSION_MESSAGE`;
CREATE TABLE IF NOT EXISTS `DISCUSSION_MESSAGE` (
  `discussion_id` bigint(20) unsigned NOT NULL,
  `message_id` bigint(20) unsigned NOT NULL,
  CONSTRAINT PK_DISCUSSION_MESSAGE PRIMARY KEY (`discussion_id`,`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `CONTACT`
--
DROP TABLE IF EXISTS `CONTACT`;
CREATE TABLE IF NOT EXISTS `CONTACT` (
  `user_id_1` bigint(20) unsigned NOT NULL,
  `user_id_2` bigint(20) unsigned NOT NULL,
  CONSTRAINT PK_CONTACT PRIMARY KEY (`user_id_1`, `user_id_2`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci  ;


-- --------------------------------------------------------

--
-- Contraintes de la table `MESSAGE`
--

alter table MESSAGE 
  add CONSTRAINT FK_MESSAGE_USER FOREIGN KEY (`user_id`) REFERENCES `USER`(`id`);

alter table MESSAGE
  add CONSTRAINT FK_MESSAGE_DISCUSSION FOREIGN KEY (`discussion_id`) REFERENCES `DISCUSSION`(`id`);

-- --------------------------------------------------------

--
-- Contraintes de la table `USER_DISCUSSION`
--

alter table USER_DISCUSSION 
    add CONSTRAINT FK_USER_DISCUSSION_U FOREIGN KEY (`user_id`) REFERENCES `USER`(`id`);

alter table USER_DISCUSSION 
    add CONSTRAINT FK_USER_DISCUSSION_D FOREIGN KEY (`discussion_id`) REFERENCES `DISCUSSION`(`id`);

-- --------------------------------------------------------

--
-- Contraintes de la table `USER_MESSAGE`
--

alter table USER_MESSAGE 
    add   CONSTRAINT FK_USER_MESSAGE_U FOREIGN KEY (`user_id`) REFERENCES `USER`(`id`);

alter table USER_MESSAGE 
  add   CONSTRAINT FK_USER_MESSAGE_M FOREIGN KEY (`message_id`) REFERENCES `MESSAGE`(`id`);

-- --------------------------------------------------------

--
-- Contraintes de la table `DISCUSSION_MESSAGE`
--

alter table DISCUSSION_MESSAGE 
    add CONSTRAINT FK_DISCUSSION_MESSAGE_D FOREIGN KEY (`discussion_id`) REFERENCES `DISCUSSION`(`id`);

alter table DISCUSSION_MESSAGE 
  add  CONSTRAINT FK_DISCUSSION_MESSAGE_M FOREIGN KEY (`message_id`) REFERENCES `MESSAGE`(`id`);


-- --------------------------------------------------------

--
-- Contraintes de la table `CONTACT`
--

alter table CONTACT 
    add CONSTRAINT FK_CONTACT_1 FOREIGN KEY (`user_id_1`) REFERENCES `USER`(`id`);

alter table CONTACT
  add  CONSTRAINT FK_CONTACT_2 FOREIGN KEY (`user_id_2`) REFERENCES `USER`(`id`);

-- --------------------------------------------------------



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
