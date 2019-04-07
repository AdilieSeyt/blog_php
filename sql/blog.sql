-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  mer. 27 mars 2019 à 11:29
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `published_at` date NOT NULL,
  `summary` text,
  `content` longtext,
  `is_published` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `category_id`, `title`, `published_at`, `summary`, `content`, `is_published`, `image`) VALUES
(2, 9, 'Critique « Star Wars 8 – Les derniers Jedi » de Rian Johnson : le renouveau de la saga ?', '2017-01-07', 'Résumé de l\'article Star Wars 8', '<p>Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue.</p>', 0, NULL),
(3, 47, 'Revue - The Ramones', '2017-01-01', 'Résumé de l\'article The Ramones', '<p>Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh.</p>', 0, NULL),
(4, 108, 'De “Skyrim” à “L.A. Noire” ou “Doom” : pourquoi les vieux jeux sont meilleurs sur la Switch', '2017-01-03', 'Résumé de l\'article Switch', '<p>Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.</p>', 0, NULL),
(5, 108, 'Comment “Assassin’s Creed” trouve un nouveau souffle en Egypte', '2017-01-04', 'Résumé de l\'article Assassin’s Creed', '<p>Ut velit mauris, egestas sed, gravida nec, ornare ut, mi. Aenean ut orci vel massa suscipit pulvinar.</p>', 0, NULL),
(6, 47, 'BO de « Les seigneurs de Dogtown » : l’époque bénie du rock.', '2017-01-05', 'Résumé de l\'article Les seigneurs de Dogtown', '<p>Nulla sollicitudin. Fusce varius, ligula non tempus aliquam, nunc turpis ullamcorper nibh, in tempus sapien eros vitae ligula.</p>', 0, NULL),
(7, 108, 'Pourquoi \"Destiny 2\" est un remède à l’ultra-moderne solitude', '2017-01-09', 'Résumé de l\'article Destiny 2', '<p>Pellentesque rhoncus nunc et augue. Integer id felis. Curabitur aliquet pellentesque diam.</p>', 0, NULL),
(8, 108, 'Pourquoi \"Mario + Lapins Crétins : Kingdom Battle\" est le jeu de la rentrée', '2017-01-08', 'Résumé de l\'article Mario + Lapins Crétins', '<p>Integer quis metus vitae elit lobortis egestas. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>', 0, NULL),
(9, 9, '« Le Crime de l’Orient Express » : rencontre avec Kenneth Branagh', '2017-01-02', 'Résumé de l\'article Le Crime de l’Orient Express', '<p>Morbi vel erat non mauris convallis vehicula. Nulla et sapien. Integer tortor tellus, aliquam faucibus, convallis id, congue eu, quam. Mauris ullamcorper felis vitae erat.</p>', 1, NULL),
(10, 9, 'MOJSFRM', '2019-03-26', 'EE', 'EE', 1, '1553605406');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `image`) VALUES
(5, 'Théâtre', 'Dates, représentations, avis...', ''),
(9, 'Cinéma', 'Trailers, infos, sorties...', ''),
(47, 'Musique', 'Concerts, sorties d\'albums, festivals...', ''),
(108, 'Jeux vidéos', 'Videos, tests...', ''),
(109, 'fghjkl', 'lekajm', ''),
(110, 'dfghjkl', 'fghjkl', ''),
(111, 'adilie', 'adilie', ''),
(116, '&lt;script&gt;alert(&quot;fgcfhgc&quot;)&lt;/script&gt;', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `is_admin` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `password`, `bio`, `is_admin`) VALUES
(1, 'adilieS', 'seit', 'adiieseyt@gmlail.com', '0cc175b9c0f1b6a831c399e269772661', 'azertyuiosdfghjkl', 1),
(3, 'dfghj', 'sdfghjk', 'adilieseyt@gmail.com', '0cc175b9c0f1b6a831c399e269772661', 'sdfghj', 1),
(4, '', '', '', '', '', 0),
(5, 'fghj', 'dcfvgbn', 'cvbn@ohkuj.gig', 'dfghj', 'sdfgh', 0),
(6, 'dfghj', 'ghjk', 'jnfdkjhlfd@ijij.oihoi', 'fghj', '', 0),
(7, 'Adilie', 'seyt', 'adilieseyt@gmail.com', 'fghjk', '', 0),
(8, 'dfghjk', 'sdfghjk', 'eeeee@gmail.com', 'ghjk', 'bn,', 0),
(9, 'bhjkl', 'bjk', 'IHOIHIJ@JKD.IZJPI', 'hj', '', 0),
(10, 'azize', 'jklm', 'jnkln@lknel.dei', 'hjkl', '', 0),
(11, 'Adilie', 'seyt', 'jnfdkjhlfd@ijij.oihf', 'fe', 'f', 0),
(12, 'ffff', 'ffff', 'fhfh@jhf.yfjff', 'fff', '', 0),
(13, 'mejfpiehpi', 'hedleijf', 'aziseyt@gmail.dcedf', 'melf', 'emlk', 0),
(14, 'ùmekfùk', 'kndem,', 'IHOIHIJ@JKD.IZJPef', 'lf,', '', 0),
(15, 'ramazan', 'seyt', 'romanseyt@gmail.com', '§\'(çà\'à', 'dfghjkl', 1),
(16, 'fghjk', 'bn,;:', 'jnfdkjhlfd@ijij.oihlk', 'bn,;:', 'n,;:', 0),
(17, 'azize', 'seyt', 'aziseyt@gmail.dcom', '22', 'FGHJK', 1),
(18, 'ROMAN', 'OLEHF', 'ROMAN@lknjlf.kjr', '77963b7a931377ad4ab5ad6a9cd718aa', 'ghjkl', 0),
(19, 'ruslan', 'ablayrs', 'ruslan@gmail.com', '698d51a19d8a121ce581499d7b701668', '', 1),
(20, 'liza', 'gladkaya', 'liza@gmail.com', '757b3fc0f965530c5ba9f67d25eb64a8', '', 0),
(21, 'ml,ùl,', 'ù;ùm', 'rrr@kff.ok', '44f437ced647ec3f40fa0841041871cd', '', 0),
(22, 'pomjmorj', 'mljme', 'fhfh@jhf.yfd', '9990775155c3518a0d7917f7780b24aa', '', 0),
(23, '=mkùfjm', 'mnmf', 'lhlihli@ld', '77963b7a931377ad4ab5ad6a9cd718aa', '', 0),
(24, 'hgkhgk', 'hjgkhgk', 'hjjh@hgjh.diu', '77963b7a931377ad4ab5ad6a9cd718aa', '', 0),
(25, 'h,fkjhf', 'hfgkh', 'aziseyt@gmail.dss', '9f6e6800cfae7749eb6c486619254b9c', '', 0),
(26, 'hj', 'dfghj', 'gg@gg.ff', '4124bc0a9335c27f086f24ba207a4912', '', 0),
(27, 'Adilie', 'Seitmemetova', 'adilie@gmail.com', '698d51a19d8a121ce581499d7b701668', '', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
