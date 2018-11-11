-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 09 nov. 2018 à 17:57
-- Version du serveur :  10.1.36-MariaDB
-- Version de PHP :  7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `annonce`
--

-- --------------------------------------------------------

--
-- Structure de la table `advert`
--

CREATE TABLE `advert` (
  `id_advert` int(11) NOT NULL,
  `title` varchar(80) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `addr` varchar(120) NOT NULL,
  `city` varchar(120) NOT NULL,
  `pc` varchar(5) NOT NULL,
  `likes` int(255) NOT NULL DEFAULT '0',
  `category` int(11) NOT NULL,
  `user` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `label` varchar(80) NOT NULL DEFAULT 'aucune'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id_category`, `label`) VALUES
(1, 'vêtements'),
(2, 'électronique');

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id_photo` int(11) NOT NULL,
  `src` varchar(255) NOT NULL DEFAULT 'no_image.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `photo_advert`
--

CREATE TABLE `photo_advert` (
  `id_advert` int(11) NOT NULL,
  `id_photo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `email` varchar(150) NOT NULL,
  `pswd` varchar(60) NOT NULL,
  `first_name` varchar(80) NOT NULL DEFAULT 'The girl has no name',
  `last_name` varchar(80) NOT NULL DEFAULT 'The girl has no name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`email`, `pswd`, `first_name`, `last_name`) VALUES
('glodie.tshimini@gmail.com', 'helloworld', 'The girl has no name', 'The girl has no name');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `advert`
--
ALTER TABLE `advert`
  ADD PRIMARY KEY (`id_advert`),
  ADD KEY `fk_category` (`category`),
  ADD KEY `fk_user` (`user`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id_photo`);

--
-- Index pour la table `photo_advert`
--
ALTER TABLE `photo_advert`
  ADD PRIMARY KEY (`id_advert`,`id_photo`),
  ADD KEY `fk_photo` (`id_photo`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `advert`
--
ALTER TABLE `advert`
  MODIFY `id_advert` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id_photo` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `advert`
--
ALTER TABLE `advert`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category`) REFERENCES `category` (`id_category`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user`) REFERENCES `user` (`email`);

--
-- Contraintes pour la table `photo_advert`
--
ALTER TABLE `photo_advert`
  ADD CONSTRAINT `fk_advert` FOREIGN KEY (`id_advert`) REFERENCES `advert` (`id_advert`),
  ADD CONSTRAINT `fk_photo` FOREIGN KEY (`id_photo`) REFERENCES `photo` (`id_photo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
