-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 07 juil. 2025 à 14:19
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_inscription`
--

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `filiere` varchar(100) NOT NULL,
  `niveau` varchar(50) NOT NULL,
  `responsable` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `classes`
--

INSERT INTO `classes` (`id`, `filiere`, `niveau`, `responsable`) VALUES
(1, 'IDA', 'Licence 3', 'FATOU DIOP'),
(2, 'MIC', 'Licence 3', 'MATY SY'),
(3, 'SIMAC', 'Master 1', 'Ndéye Maréme Sy');

-- --------------------------------------------------------

--
-- Structure de la table `emplois_temps`
--

CREATE TABLE `emplois_temps` (
  `id` int(11) NOT NULL,
  `jour` varchar(20) DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  `matiere` varchar(100) DEFAULT NULL,
  `salle` varchar(50) DEFAULT NULL,
  `enseignant` varchar(100) DEFAULT NULL,
  `filiere` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `emplois_temps`
--

INSERT INTO `emplois_temps` (`id`, `jour`, `heure_debut`, `heure_fin`, `matiere`, `salle`, `enseignant`, `filiere`) VALUES
(1, 'Lundi', '08:00:00', '10:00:00', 'Programmation web', 'Salle 1', 'M. Ndiaye', 'IDA'),
(2, 'Lundi', '10:00:00', '12:00:00', 'Base de donnée', 'Salle 2', 'Mme Sow', 'IDA'),
(3, 'Mardi', '14:00:00', '16:00:00', 'Réseaux', 'Salle 3', 'M. Fall', 'IDA'),
(4, 'Mercredi', '08:00:00', '10:00:00', 'Mathématiques', 'Salle 2', 'Mme Diop', 'IDA'),
(5, 'Jeudi', '10:00:00', '12:00:00', 'Anglais technique', 'Salle 3', 'Mr Gaye', 'IDA'),
(6, 'Vendredi', '14:00:00', '16:00:00', 'Sécurité informatique', 'Salle 1', 'Mr Ba', 'IDA');

-- --------------------------------------------------------

--
-- Structure de la table `enseignants`
--

CREATE TABLE `enseignants` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `specialite` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `enseignants`
--

INSERT INTO `enseignants` (`id`, `nom`, `prenom`, `email`, `specialite`) VALUES
(1, 'Mamadou', 'Diop', 'mamadoudiop@gmail.com', 'Developpeur'),
(3, 'Fall', 'Demba', 'admin1@gmail.com', 'Developpeur');

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `nom`, `prenom`, `email`, `date_naissance`) VALUES
(3, 'Sy', 'Maty', 'matysy@gmail.com', '2002-06-06'),
(4, 'fall', 'Moussa', 'moussa@gmail.com', '2007-05-02'),
(5, 'Diop', 'Coumba', 'coumba@gmail.com', '2004-05-08'),
(7, 'Top', 'Awa', 'awa@gmail.com', '2003-07-05');

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

CREATE TABLE `matieres` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `coefficient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `matieres`
--

INSERT INTO `matieres` (`id`, `nom`, `coefficient`) VALUES
(2, 'Initiation à l\'aglorithme', 3);

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id` int(11) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  `id_matiere` int(11) NOT NULL,
  `id_enseignant` int(11) NOT NULL,
  `note` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `etudiant_id` int(11) DEFAULT NULL,
  `matiere` varchar(100) DEFAULT NULL,
  `note` float DEFAULT NULL,
  `semestre` varchar(50) DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT current_timestamp(),
  `coefficient` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `notes`
--

INSERT INTO `notes` (`id`, `etudiant_id`, `matiere`, `note`, `semestre`, `date_enregistrement`, `coefficient`) VALUES
(1, 0, 'initiation à l\'informatique', 15, '1', '2025-06-22 11:55:26', 1),
(2, 1, 'Algorithmique', 15, '1', '2025-06-25 16:04:10', 3),
(3, 1, 'Programmation web', 18, '1', '2025-06-25 16:04:10', 4),
(4, 1, 'Base de donnée', 16, '1', '2025-06-25 16:04:10', 3),
(5, 1, 'Mathématiques', 12, '1', '2025-06-25 16:04:10', 2),
(6, 1, 'Réseaux', 10, '1', '2025-06-25 16:04:10', 2),
(7, 1, 'Structure de données', 14, '1', '2025-06-25 16:04:10', 3),
(8, 1, 'Système d\'exploitation', 13, '1', '2025-06-25 16:04:10', 2),
(9, 1, 'Sécurité informatique', 11, '1', '2025-06-25 16:04:10', 2),
(10, 1, 'Anglais technique', 17, '1', '2025-06-25 16:04:10', 1);

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

CREATE TABLE `personnel` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `fonction` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `personnel`
--

INSERT INTO `personnel` (`id`, `nom`, `fonction`, `email`) VALUES
(1, 'FALLOU DIOP', 'TUTEUR', 'fallou@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `genre` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `email`, `telephone`, `genre`, `password`) VALUES
(1, 'AWA NDIAYE', 'awa@gmail.com', '781537479', 'femme', NULL),
(2, 'Awa Ndiaye', 'awandiaye@gmail.com', '781537479', 'Femme', '$2a$12$FLJoBwNFhwQPLwFSVJQBUuoSQkP.eodf3gg/PiSYkRrsmEv4oEFv6'),
(3, 'admin', 'admin@unchk.sn', '781537479', 'Femme', '1234'),
(4, 'AWA NDIAYE', 'awa@gmail.com', '781537479', 'femme', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `emplois_temps`
--
ALTER TABLE `emplois_temps`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `enseignants`
--
ALTER TABLE `enseignants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `matieres`
--
ALTER TABLE `matieres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_etudiant` (`id_etudiant`),
  ADD KEY `id_matiere` (`id_matiere`),
  ADD KEY `id_enseignant` (`id_enseignant`);

--
-- Index pour la table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `emplois_temps`
--
ALTER TABLE `emplois_temps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `enseignants`
--
ALTER TABLE `enseignants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `matieres`
--
ALTER TABLE `matieres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `note_ibfk_2` FOREIGN KEY (`id_matiere`) REFERENCES `matieres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `note_ibfk_3` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignants` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
