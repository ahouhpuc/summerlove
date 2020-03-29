-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Dim 29 Mars 2020 à 12:34
-- Version du serveur :  10.3.22-MariaDB-0+deb10u1
-- Version de PHP :  7.3.11-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `alexis_summerlove`
--

-- --------------------------------------------------------

--
-- Structure de la table `match`
--

CREATE TABLE `match` (
  `id` int(10) UNSIGNED NOT NULL,
  `field` int(10) UNSIGNED NOT NULL COMMENT 'Field number',
  `tid1` int(10) UNSIGNED NOT NULL COMMENT 'Team 1 identifier',
  `tid2` int(10) UNSIGNED NOT NULL COMMENT 'Team 2 identifier',
  `s1` int(10) UNSIGNED NOT NULL COMMENT 'Score team 1',
  `s2` int(10) UNSIGNED NOT NULL COMMENT 'Score team 2',
  `start` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `player`
--

CREATE TABLE `player` (
  `id` int(11) NOT NULL,
  `nickname` varchar(42) DEFAULT NULL,
  `firstname` varchar(42) NOT NULL,
  `name` varchar(30) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `team` varchar(50) NOT NULL,
  `level` int(11) NOT NULL,
  `gender` enum('M','F') NOT NULL,
  `post` set('handler','middle','long') NOT NULL,
  `d1` tinyint(1) NOT NULL COMMENT '03/07',
  `d2` tinyint(1) NOT NULL COMMENT '10/07',
  `d3` tinyint(1) NOT NULL COMMENT '17/07',
  `d4` tinyint(1) NOT NULL COMMENT '24/07',
  `d5` tinyint(1) NOT NULL COMMENT '31/07',
  `d6` tinyint(1) NOT NULL COMMENT '07/08',
  `d7` tinyint(1) NOT NULL COMMENT '14/08',
  `d8` tinyint(1) NOT NULL COMMENT '21/08',
  `d9` tinyint(1) NOT NULL COMMENT '28/08',
  `waiting` tinyint(1) DEFAULT 0,
  `paid` tinyint(1) NOT NULL DEFAULT 0,
  `color` tinyint(4) NOT NULL COMMENT 'Team color',
  `comment` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `pid` int(11) UNSIGNED NOT NULL COMMENT 'puck up id',
  `subscribe_date` datetime NOT NULL,
  `ip` varchar(39) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `puckup`
--

CREATE TABLE `puckup` (
  `id` int(11) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `open` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `team`
--

CREATE TABLE `team` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `pid` tinyint(3) UNSIGNED NOT NULL COMMENT 'pickup identifier',
  `color` varchar(20) NOT NULL,
  `html_color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(30) COLLATE utf8_bin NOT NULL,
  `password` varchar(32) COLLATE utf8_bin NOT NULL,
  `permission` enum('read','write','all') COLLATE utf8_bin DEFAULT NULL,
  `last_login_date` datetime DEFAULT NULL,
  `last_login_ip` varchar(39) COLLATE utf8_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `match`
--
ALTER TABLE `match`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tid1` (`tid1`,`tid2`);

--
-- Index pour la table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `puckup`
--
ALTER TABLE `puckup`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `player`
--
ALTER TABLE `player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `puckup`
--
ALTER TABLE `puckup`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
