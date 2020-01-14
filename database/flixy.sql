-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 192.168.64.3
-- Creato il: Ott 20, 2019 alle 14:33
-- Versione del server: 10.4.8-MariaDB
-- Versione PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flixy`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Comment`
--

CREATE TABLE `Comment` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `Comment`
--

INSERT INTO `Comment` (`id`, `content`, `created_at`, `updated_at`, `user_id`, `media_id`) VALUES
(1, 'Commento di prova', '2019-10-20 12:26:46', '2019-10-20 12:26:46', 1, 2),
(2, 'Commento di prova', '2019-10-20 12:26:46', '2019-10-20 12:26:46', 1, 1),
(3, 'Film per bambini', '2019-10-20 12:27:11', '2019-10-20 12:27:11', 2, 2),
(4, 'Commento di prova', '2019-10-20 12:27:11', '2019-10-20 12:27:11', 2, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `Episode`
--

CREATE TABLE `Episode` (
  `id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text DEFAULT NULL,
  `promo_url` varchar(1000) DEFAULT NULL,
  `season` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `air_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `Episode`
--

INSERT INTO `Episode` (`id`, `media_id`, `title`, `description`, `promo_url`, `season`, `number`, `created_at`, `updated_at`, `air_date`) VALUES
(1, 2, 'Efectuar lo acordado', 'The Professor recruits a young female robber and seven other criminals for a grand heist, targeting the Royal Mint of Spain.', NULL, 1, 1, '2019-10-20 12:23:57', '2019-10-20 12:23:57', '2017-12-20 00:00:00'),
(2, 2, 'Imprudencias letales', 'Hostage negotiator Raquel makes initial contact with the Professor. One of the hostages is a crucial part of the thieves\' plans.', 'https://www.youtube.com/embed/3qtyan-W-Wk', 1, 2, '2019-10-20 12:25:14', '2019-10-20 12:25:14', '2017-12-20 00:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `Favourite`
--

CREATE TABLE `Favourite` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `Favourite`
--

INSERT INTO `Favourite` (`id`, `user_id`, `media_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2019-10-20 12:25:44', '2019-10-20 12:25:44'),
(2, 2, 2, '2019-10-20 12:25:49', '2019-10-20 12:25:49'),
(3, 2, 1, '2019-10-20 12:25:56', '2019-10-20 12:25:56');

-- --------------------------------------------------------

--
-- Struttura della tabella `Feed`
--

CREATE TABLE `Feed` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `subtitle` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `event_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `Feed`
--

INSERT INTO `Feed` (`id`, `created_at`, `updated_at`, `subtitle`, `content`, `author_id`, `media_id`, `event_date`) VALUES
(1, '2019-10-20 12:29:02', '2019-10-20 12:29:02', 'Nuova stagione annunciata', 'A settembre del 2020 comincerà la produzione della nuova stagione di questa fantastica serie televisiva!', 1, 2, '2020-01-09 00:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `Genre`
--

CREATE TABLE `Genre` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `Genre`
--

INSERT INTO `Genre` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Avventura', '2019-10-20 12:17:18', '2019-10-20 12:17:18'),
(2, 'Crimine', '2019-10-20 12:21:02', '2019-10-20 12:21:02');

-- --------------------------------------------------------

--
-- Struttura della tabella `Keychain`
--

CREATE TABLE `Keychain` (
  `user_id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `Keychain`
--

INSERT INTO `Keychain` (`user_id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'gabrielciulei', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', '2019-10-20 12:12:56', '2019-10-20 12:12:56'),
(2, 'test', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', '2019-10-20 12:14:03', '2019-10-20 12:14:03');

-- --------------------------------------------------------

--
-- Struttura della tabella `Media`
--

CREATE TABLE `Media` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text DEFAULT NULL,
  `cover_url` varchar(1000) NOT NULL,
  `genre` int(11) DEFAULT NULL,
  `stars` int(1) NOT NULL,
  `duration` int(11) DEFAULT NULL,
  `hasEpisodes` tinyint(1) NOT NULL DEFAULT 0,
  `episodes` int(11) DEFAULT NULL,
  `seasons` int(11) DEFAULT NULL,
  `trailer_url` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `air_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `Media`
--

INSERT INTO `Media` (`id`, `name`, `description`, `cover_url`, `genre`, `stars`, `duration`, `hasEpisodes`, `episodes`, `seasons`, `trailer_url`, `created_at`, `updated_at`, `air_date`) VALUES
(1, 'Maleficent - Signora del male', 'Maleficent and her goddaughter Aurora begin to question the complex family ties that bind them as they are pulled in different directions by impending nuptials, unexpected allies, and dark new forces at play.', '/assets/images/covers/malef.jpg', 1, 3, 118, 0, NULL, NULL, 'https://www.youtube.com/embed/yL1f8yNxGBk', '2019-10-20 12:19:01', '2019-10-20 12:19:01', '2019-10-17 00:00:00'),
(2, 'La casa di carta', 'A group of unique robbers assault the Factory of Moneda and Timbre to carry out the most perfect robbery in the history of Spain and take home 2.4 billion euros.', '/assets/images/covers/casa.jpg', 2, 5, 40, 1, 27, 3, 'https://www.youtube.com/embed/Tp5Y4vob7xM', '2019-10-20 12:21:58', '2019-10-20 12:21:58', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `User`
--

CREATE TABLE `User` (
  `name` varchar(250) NOT NULL,
  `surname` varchar(250) NOT NULL,
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(150) NOT NULL,
  `avatar_url` varchar(1000) NOT NULL DEFAULT '/assets/images/avatars/default.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `User`
--

INSERT INTO `User` (`name`, `surname`, `id`, `email`, `avatar_url`, `created_at`, `updated_at`) VALUES
('Gabriel', 'Ciulei', 1, 'ciulei.gabriel@gmail.com', '/assets/images/avatars/default.png', '2019-10-20 12:12:08', '2019-10-20 12:12:08'),
('Test', 'Test', 2, 'test@flixy.com', '/assets/images/avatars/default.png', '2019-10-20 12:13:39', '2019-10-20 12:13:39');

-- --------------------------------------------------------

--
-- Struttura della tabella `Vote`
--

CREATE TABLE `Vote` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `positive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `Vote`
--

INSERT INTO `Vote` (`id`, `user_id`, `media_id`, `created_at`, `updated_at`, `positive`) VALUES
(1, 1, 2, '2019-10-20 12:27:53', '2019-10-20 12:27:53', 1),
(2, 2, 1, '2019-10-20 12:27:53', '2019-10-20 12:27:53', 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Comment`
--
ALTER TABLE `Comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indici per le tabelle `Episode`
--
ALTER TABLE `Episode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indici per le tabelle `Favourite`
--
ALTER TABLE `Favourite`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `FavIndex` (`user_id`,`media_id`);

--
-- Indici per le tabelle `Feed`
--
ALTER TABLE `Feed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indici per le tabelle `Genre`
--
ALTER TABLE `Genre`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `Keychain`
--
ALTER TABLE `Keychain`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD KEY `user_id` (`user_id`);
ALTER TABLE `Keychain` ADD FULLTEXT KEY `username` (`username`);

--
-- Indici per le tabelle `Media`
--
ALTER TABLE `Media`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indici per le tabelle `Vote`
--
ALTER TABLE `Vote`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`media_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `Comment`
--
ALTER TABLE `Comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `Episode`
--
ALTER TABLE `Episode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `Favourite`
--
ALTER TABLE `Favourite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `Feed`
--
ALTER TABLE `Feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `Genre`
--
ALTER TABLE `Genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `Media`
--
ALTER TABLE `Media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `User`
--
ALTER TABLE `User`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `Vote`
--
ALTER TABLE `Vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
