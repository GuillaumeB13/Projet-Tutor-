-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 23 Février 2016 à 13:55
-- Version du serveur: 5.5.47-0ubuntu0.14.04.1
-- Version de PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `MyOCR`
--

-- --------------------------------------------------------

--
-- Structure de la table `Champs`
--

CREATE TABLE IF NOT EXISTS `Champs` (
  `id_Champs` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_Masks` char(5) DEFAULT NULL,
  `nom_Champs` enum('Identifiant_National','Nom','Prenom','Sexe','Ville','Taille','Date_Naissance','Signature','PhotoID') DEFAULT NULL,
  `x1` int(11) DEFAULT NULL,
  `y1` int(11) DEFAULT NULL,
  `x2` int(11) DEFAULT NULL,
  `y2` int(11) DEFAULT NULL,
  `Type` varchar(10) NOT NULL,
  PRIMARY KEY (`id_Champs`),
  UNIQUE KEY `id_Champs` (`id_Champs`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `Champs`
--

INSERT INTO `Champs` (`id_Champs`, `id_Masks`, `nom_Champs`, `x1`, `y1`, `x2`, `y2`, `Type`) VALUES
(1, '1', 'Identifiant_National', 550, 100, 251, 40, 'texte'),
(2, '1', 'Nom', 478, 152, 220, 45, 'texte'),
(3, '1', 'Sexe', 476, 340, 40, 31, 'texte'),
(4, '1', 'Ville', 438, 377, 149, 39, 'texte'),
(5, '1', 'Taille', 502, 422, 38, 49, 'texte'),
(6, '1', 'Date_Naissance', 832, 329, 203, 45, 'texte'),
(7, '1', 'Signature', 565, 470, 625, 140, 'image'),
(8, '1', 'PhotoID', 30, 150, 300, 460, 'image'),
(9, '1', 'Prenom', 545, 245, 625, 40, 'texte');

-- --------------------------------------------------------

--
-- Structure de la table `Documents`
--

CREATE TABLE IF NOT EXISTS `Documents` (
  `id_Doc` char(1) NOT NULL,
  `nom_Doc` varchar(25) DEFAULT NULL,
  `id_Masks` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_Doc`),
  UNIQUE KEY `id_Masks` (`id_Masks`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `Documents`
--

INSERT INTO `Documents` (`id_Doc`, `nom_Doc`, `id_Masks`) VALUES
('1', 'Carte Identité', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Masks`
--

CREATE TABLE IF NOT EXISTS `Masks` (
  `id_Masks` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom_Masks` varchar(25) DEFAULT NULL,
  `id_Docs` char(5) DEFAULT NULL,
  PRIMARY KEY (`id_Masks`),
  UNIQUE KEY `id_Masks` (`id_Masks`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `Masks`
--

INSERT INTO `Masks` (`id_Masks`, `nom_Masks`, `id_Docs`) VALUES
(1, 'Masque Carte Identité', '1');

-- --------------------------------------------------------

--
-- Structure de la table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `id_Users` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `nom` varchar(25) DEFAULT NULL,
  `prenom` varchar(25) DEFAULT NULL,
  `tel` char(15) DEFAULT NULL,
  `super_User` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_Users`),
  UNIQUE KEY `id_Users` (`id_Users`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `Users`
--

INSERT INTO `Users` (`id_Users`, `login`, `pwd`, `mail`, `nom`, `prenom`, `tel`, `super_User`) VALUES
(1, 'Guillaume', '123456', 'test@yopmail.fr', 'Barthelemy', 'Guillaume', '0658484392', 0),
(2, 'root', 'root', 'root@yopmail.fr', 'Lacondeguy', 'Andreu', '0548974875', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
