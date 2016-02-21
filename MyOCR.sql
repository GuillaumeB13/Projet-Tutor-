-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 21 Février 2016 à 13:42
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
  `type_Champs` enum('Identifiant_National','Nom','Prenom','Sexe','Ville','Taille','Date_Naissance','Signature','PhotoID') DEFAULT NULL,
  `x1` int(11) DEFAULT NULL,
  `y1` int(11) DEFAULT NULL,
  `x2` int(11) DEFAULT NULL,
  `y2` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_Champs`),
  UNIQUE KEY `id_Champs` (`id_Champs`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `Champs`
--

INSERT INTO `Champs` (`id_Champs`, `id_Masks`, `type_Champs`, `x1`, `y1`, `x2`, `y2`) VALUES
(1, '1', 'Identifiant_National', 550, 100, 251, 40),
(2, '1', 'Nom', 478, 152, 220, 45),
(3, '1', 'Sexe', 476, 340, 40, 31),
(4, '1', 'Ville', 438, 377, 149, 39),
(5, '1', 'Taille', 502, 422, 38, 49),
(6, '1', 'Date_Naissance', 832, 329, 203, 45),
(7, '1', 'Signature', 565, 470, 625, 140),
(8, '1', 'PhotoID', 30, 150, 300, 460);

-- --------------------------------------------------------

--
-- Structure de la table `CNI`
--

CREATE TABLE IF NOT EXISTS `CNI` (
  `id_CNI` char(1) NOT NULL,
  PRIMARY KEY (`id_CNI`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `CNI`
--

INSERT INTO `CNI` (`id_CNI`) VALUES
('1');

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
-- Structure de la table `Feuille_Impo`
--

CREATE TABLE IF NOT EXISTS `Feuille_Impo` (
  `id_Impot` char(1) NOT NULL,
  PRIMARY KEY (`id_Impot`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Feuille_Soin`
--

CREATE TABLE IF NOT EXISTS `Feuille_Soin` (
  `id_Soin` char(1) NOT NULL,
  PRIMARY KEY (`id_Soin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Livret_Famille`
--

CREATE TABLE IF NOT EXISTS `Livret_Famille` (
  `id_Livret` char(1) NOT NULL,
  PRIMARY KEY (`id_Livret`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
