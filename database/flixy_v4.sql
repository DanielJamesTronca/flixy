-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 26, 2020 alle 02:33
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
-- Struttura della tabella `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `comment`
--

INSERT INTO `comment` (`id`, `content`, `created_at`, `updated_at`, `user_id`, `media_id`) VALUES
(3, 'Serie molto bella, forse sottovalutata!', '2019-10-20 12:27:11', '2020-01-26 00:24:09', 12, 59),
(20, 'Mi piace 💪🏻', '2020-01-23 18:06:09', '2020-01-26 00:21:08', 20, 49),
(23, 'Il titolo &egrave; tutto un programma', '2020-01-26 00:30:04', '2020-01-26 00:30:04', 23, 54),
(24, 'Con un cast del genere...', '2020-01-26 00:35:48', '2020-01-26 00:35:48', 23, 48),
(25, 'Oddio Brad sei tu??', '2020-01-26 00:39:01', '2020-01-26 00:39:01', 24, 48),
(26, 'Davvero intramontabile!', '2020-01-26 00:40:45', '2020-01-26 00:40:45', 24, 52),
(27, 'Se amate il genere, assolutamente da non perdere!', '2020-01-26 00:51:18', '2020-01-26 00:51:18', 24, 47);

--
-- Trigger `comment`
--
DELIMITER $$
CREATE TRIGGER `updater` BEFORE UPDATE ON `comment` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `episode`
--

CREATE TABLE `episode` (
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
-- Dump dei dati per la tabella `episode`
--

INSERT INTO `episode` (`id`, `media_id`, `title`, `description`, `promo_url`, `season`, `number`, `created_at`, `updated_at`, `air_date`) VALUES
(45, 53, 'Che il caos abbia inizio', 'Il professore e la banda mettono in atto un nuovo piano.', '', 4, 1, '2020-01-25 21:49:10', '2020-01-25 21:49:10', '2020-03-02 23:00:00'),
(47, 58, 'Discesa', 'Mentre il traffico di droga di Pablo Escobar estende sempre pi&ugrave; i suoi orizzonti, l&#039;agente della Dea Steve Murphy si unisce alla guerra alla droga a Bogot&agrave; dopo essersi occupato da tempo di piccoli spacciatori.', '', 1, 1, '2020-01-25 22:07:40', '2020-01-25 22:07:40', '2015-10-21 22:00:00'),
(48, 58, 'Finalmente libero', 'Dopo una massiccia operazione militare volta a catturare Pablo, la sua famiglia si riunisce e i suoi nemici si preoccupano. Steve e Connie discutono di sicurezza.', '', 2, 1, '2020-01-25 22:10:05', '2020-01-25 22:10:05', '2016-09-01 22:00:00'),
(49, 59, 'Il gioco si fa duro', 'Si vedr&agrave;!', '', 3, 1, '2020-01-25 22:43:18', '2020-01-25 22:43:18', '2020-03-26 23:00:00'),
(50, 49, 'Una prova per non morire', 'Nel primo episodio viene presentato il dottor Gregory House (specializzato in nefrologia e infettivologia), un brillante medico e la sua &eacute;quipe di specialisti: Allison Cameron (immunologa), Eric Foreman (neurologo), Robert Chase (rianimazione, terapia intensiva, anestesia).', '', 1, 1, '2020-01-25 22:49:38', '2020-01-25 22:49:38', '2004-11-15 23:00:00'),
(51, 56, 'Superpoteri', 'In un liceo privato esclusivo, la studentessa modello Chiara lega inaspettatamente con la compagna ribelle Ludovica e con un nuovo arrivato, il misterioso Damiano.', '', 1, 1, '2020-01-25 23:04:33', '2020-01-25 23:04:33', '2018-11-29 23:00:00'),
(52, 59, 'Il mio bon bon', 'Dopo che il suo socio ha truffato un pericoloso cliente, il consulente finanziario Marty deve escogitare un piano estremo per salvare se stesso e la sua famiglia.', '', 1, 1, '2020-01-25 23:20:10', '2020-01-25 23:20:10', '2017-07-20 22:00:00');

--
-- Trigger `episode`
--
DELIMITER $$
CREATE TRIGGER `updater_ep` BEFORE UPDATE ON `episode` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `favourite`
--

CREATE TABLE `favourite` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `favourite`
--

INSERT INTO `favourite` (`id`, `user_id`, `media_id`, `created_at`, `updated_at`) VALUES
(17, 20, 2, '2020-01-23 18:00:38', '2020-01-23 18:00:38'),
(18, 20, 1, '2020-01-23 18:00:40', '2020-01-23 18:00:40'),
(30, 12, 1, '2020-01-24 10:48:53', '2020-01-24 10:48:53'),
(31, 12, 2, '2020-01-24 10:49:07', '2020-01-24 10:49:07'),
(36, 22, 53, '2020-01-25 19:00:41', '2020-01-25 19:00:41'),
(51, 22, 52, '2020-01-26 00:03:21', '2020-01-26 00:03:21'),
(52, 22, 59, '2020-01-26 00:03:28', '2020-01-26 00:03:28'),
(56, 10, 49, '2020-01-26 00:07:20', '2020-01-26 00:07:20'),
(57, 10, 53, '2020-01-26 00:07:40', '2020-01-26 00:07:40');

--
-- Trigger `favourite`
--
DELIMITER $$
CREATE TRIGGER `updater_fav` BEFORE UPDATE ON `favourite` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `feed`
--

CREATE TABLE `feed` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `subtitle` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `event_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `video_url` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `feed`
--

INSERT INTO `feed` (`id`, `created_at`, `updated_at`, `subtitle`, `content`, `author_id`, `media_id`, `event_date`, `video_url`) VALUES
(10, '2020-01-25 21:37:46', '2020-01-25 21:37:46', 'La quarta stagione &egrave; ufficiale!', 'La casa di carta 4 ha finalmente una data di uscita: il 3 aprile 2020 &egrave; il giorno in cui tutti i fan dell&#039;apprezzata serie spagnola dovranno collegarsi a Netflix per scoprire cosa accadr&agrave; al Professore e agli altri protagonisti.\r\nIl video condiviso online mostra solo i volti di alcuni dei personaggi e annuncia poi: &quot;Che il caos abbia inizio&quot;.', 10, 53, '2019-12-07 23:00:00', 'https://www.youtube.com/embed/46XIhclFr0U'),
(12, '2020-01-25 21:55:54', '2020-01-25 21:57:25', 'Il primo film compie 35 anni', 'Correva l&#039;anno 1985 quando usc&igrave; il primo capitolo, ma tutta la trilogia di Robert Zemeckis sembra immune all&#039;usura del tempo. E i fan si preparano ai festeggiamenti, anche senza un remake all&#039;orizzonte: stasera su Italia 1 tutta la trilogia.', 10, 52, '2020-01-03 23:00:00', ''),
(13, '2020-01-25 23:24:44', '2020-01-25 23:24:44', 'Ogni stagione &egrave; pi&ugrave; amata della precedente', 'Sin dal 2016, anno del suo esordio, la serie TV &#039;The Crown&#039; &egrave; stata guardata da 73 milioni di abbonamenti: per la prima volta Netflix ha rivelato i numeri del dramma dedicato alla regina Elisabetta II e alla famiglia reale britannica e i dati sono notevoli. Anche perch&eacute; emerge un fatto tutt&#039;altro che secondario: la popolarit&agrave; dello show cresce di stagione in stagione e per esempio la terza, cio&egrave; la pi&ugrave; recente, &egrave; stata vista da 21 milioni di abbonati nelle prime quattro settimane dall&#039;esordio, il 40% in pi&ugrave; rispetto alla precedente nel medesimo arco di tempo.', 10, 50, '2020-01-21 23:00:00', '');

--
-- Trigger `feed`
--
DELIMITER $$
CREATE TRIGGER `updater_feed` BEFORE UPDATE ON `feed` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `genre`
--

INSERT INTO `genre` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Animazione', '2019-10-20 12:17:18', '2020-01-25 20:53:06'),
(2, 'Avventura', '2019-10-20 12:21:02', '2020-01-25 20:52:59'),
(3, 'Biografico', '2020-01-25 20:49:14', '2020-01-25 20:53:19'),
(4, 'Commedia', '2020-01-25 20:49:14', '2020-01-25 20:53:32'),
(5, 'Drammatico', '2020-01-25 20:49:18', '2020-01-25 20:49:46'),
(7, 'Fantascienza', '2020-01-25 20:51:00', '2020-01-25 20:55:00'),
(8, 'Fantastico', '2020-01-25 20:55:27', '2020-01-25 20:56:54'),
(9, 'Guerra', '2020-01-25 20:55:27', '2020-01-25 20:57:08'),
(10, 'Horror', '2020-01-25 20:55:55', '2020-01-25 20:58:36'),
(11, 'Musical', '2020-01-25 20:55:55', '2020-01-25 20:58:47'),
(12, 'Storico', '2020-01-25 20:59:06', '2020-01-25 20:59:06'),
(13, 'Thriller', '2020-01-25 20:59:06', '2020-01-25 20:59:06'),
(14, 'Western', '2020-01-25 20:59:16', '2020-01-25 20:59:16');

--
-- Trigger `genre`
--
DELIMITER $$
CREATE TRIGGER `updater_gen` BEFORE UPDATE ON `genre` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `keychain`
--

CREATE TABLE `keychain` (
  `user_id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `can_publish` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `keychain`
--

INSERT INTO `keychain` (`user_id`, `username`, `password`, `created_at`, `updated_at`, `can_publish`) VALUES
(10, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '2020-01-03 12:02:25', '2020-01-25 12:41:29', 1),
(12, 'apolo', 'e42c35b51184ac48511329deee50ed2233c4cfe1cc83b6e84b76fadeef6383ac', '2020-01-03 23:56:57', '2020-01-03 23:56:57', 0),
(23, 'bradpitt', 'df35a4702b8e0d9d01dcdaec5be691ce0f45e5afe62842c8e47872cb04dafb9e', '2020-01-26 00:26:31', '2020-01-26 00:26:31', 0),
(24, 'giufalchi', '72e892473e1a9523fb471b0c6aea8bfb37fb653688a9b5e5df756b85a9d34b71', '2020-01-26 00:38:06', '2020-01-26 00:38:06', 0),
(20, 'lupo98', '1aed0f76467349815c8ff1907e0bf19720897a889f1b6fc6668d15e0636fcb6a', '2020-01-23 17:55:55', '2020-01-25 12:34:58', 0),
(22, 'user', '04f8996da763b7a969b1028ee3007569eaf3a635486ddab211d512c85b9df8fb', '2020-01-25 13:16:07', '2020-01-25 13:17:51', 0);

--
-- Trigger `keychain`
--
DELIMITER $$
CREATE TRIGGER `updater_key` BEFORE UPDATE ON `keychain` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `media`
--

CREATE TABLE `media` (
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
  `air_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `media`
--

INSERT INTO `media` (`id`, `name`, `description`, `cover_url`, `genre`, `stars`, `duration`, `hasEpisodes`, `episodes`, `seasons`, `trailer_url`, `created_at`, `updated_at`, `air_date`) VALUES
(46, 'Lalaland', 'Il film racconta la storia d&#039;amore tra un musicista jazz e un&#039;aspirante attrice, interpretati rispettivamente da Ryan Gosling ed Emma Stone, realizzato come un musical contemporaneo che omaggia i classici film musicali prodotti a cavallo fra gli anni &#039;50 e &#039;60. Il titolo del film &egrave; sia un riferimento alla citt&agrave; di Los Angeles sia al significato di essere nel &quot;mondo dei sogni&quot; o &quot;fuori dalla realt&agrave;&quot;. Chazelle ha scritto la sceneggiatura nel 2010, ma non ha trovato uno studio disposto a finanziare il progetto. Solo dopo il successo del suo Whiplash del 2014, il progetto ha ottenuto l&#039;interesse delle case di produzione.', 'assets/images/covers/bWLNyeNfjy.jpg', 4, 3, 128, 0, 0, 0, 'https://www.youtube.com/embed/0pdqf4P9MB8', '2020-01-25 16:54:05', '2020-01-25 21:23:50', '2016-08-30 22:00:00'),
(47, 'Stranger Things', 'Ambientata negli anni Ottanta nella citt&agrave; fittizia di Hawkins, nell&#039;Indiana, e in parte nel mondo del &quot;Sottosopra&quot; (Upside Down in lingua originale), &egrave; incentrata sulla misteriosa sparizione di un bambino e sulla comparsa di una bambina dai capelli rasati dotata di poteri psichici fuggita da un laboratorio segreto, l&#039;Hawkins National Laboratory.\r\nQuasi tutti gli eventi che accadono nel corso della vicenda sono strettamente connessi al Sottosopra, un&#039;oscura dimensione parallela al nostro mondo, popolata da creature mostruose.', 'assets/images/covers/OORFXVQpfV.jpg', 7, 4, 50, 1, 8, 3, 'https://www.youtube.com/embed/b9EkMc79ZSU', '2020-01-25 17:03:35', '2020-01-25 21:30:20', '2016-07-14 22:00:00'),
(48, 'C&#039;era una volta ad Hollywood', 'C&#039;era una volta a... Hollywood (Once Upon a Time... in Hollywood) &egrave; un film del 2019 scritto e diretto da Quentin Tarantino.\r\nIl film, con protagonisti Leonardo DiCaprio, Brad Pitt e Margot Robbie, &egrave; ambientato nella Los Angeles del 1969 e segue le vicende di un attore televisivo in declino e della sua controfigura che, intenti a farsi strada nell&#039;industria cinematografica hollywoodiana, si ritrovano ad essere vicini di casa di Sharon Tate, appena qualche mese prima del massacro di Cielo Drive.', 'assets/images/covers/XdsbatGyRT.jpeg', 5, 4, 161, 0, 0, 0, 'https://www.youtube.com/embed/ELeMaP8EPAA', '2020-01-25 17:18:15', '2020-01-25 21:03:01', '2019-09-17 22:00:00'),
(49, 'Dr. House', 'La serie &egrave; incentrata attorno al ruolo del dottor Gregory House, un medico poco convenzionale ma dotato di grandi capacit&agrave; ed esperienza, a capo di una squadra di medicina diagnostica presso il fittizio ospedale universitario Princeton-Plainsboro Teaching Hospital, nel New Jersey.\r\nLa serie trae ispirazione dai gialli del celebre detective Sherlock Holmes: in ogni episodio ha luogo un giallo diverso che il protagonista, attraverso le proprie capacit&agrave; mediche e deduttive, deve districare basandosi su vari indizi, spesso poco evidenti; infine, egli riesce quasi sempre a risolvere il puzzle medico e a salvare il paziente. I misteri medici sono invece stati ispirati da una rubrica del New York Times dedicata ai casi clinici particolarmente problematici.', 'assets/images/covers/FbpSdmWbIG.jpg', 4, 4, 45, 1, 22, 8, 'https://www.youtube.com/embed/g7AfxO1i8B4', '2020-01-25 17:20:29', '2020-01-25 23:58:33', '2004-11-15 23:00:00'),
(50, 'The Crown', 'La serie &egrave; incentrata sulla vita di Elisabetta II del Regno Unito e sulla famiglia reale britannica.\r\nLa serie &egrave; stata acclamata dalla critica e sono state apprezzate in particolare le interpretazioni di Claire Foy nel ruolo della protagonista e di John Lithgow nel ruolo di Winston Churchill; entrambi gli attori hanno vinto diversi premi, tra cui lo Screen Actors Guild Award per la migliore attrice in una serie drammatica e quello per il miglior attore in una serie drammatica.', 'assets/images/covers/baspqutlbR.jpg', 12, 3, 55, 1, 10, 3, 'https://www.youtube.com/embed/JWtnJjn6ng0', '2020-01-25 17:23:09', '2020-01-25 21:08:35', '2016-11-03 23:00:00'),
(51, 'Joker', 'La pellicola, basata sull&#039;omonimo personaggio dei fumetti DC Comics ma scollegata dai film del DC Extended Universe, vede Joaquin Phoenix interpretare il protagonista affiancato nel cast da Robert De Niro, Zazie Beetz, Frances Conroy e Brett Cullen. Il film ha ricevuto ben 11 candidature ai Premi Oscar 2020, risultando quindi il film con pi&ugrave; candidature in tale edizione.[1] Inoltre &egrave; il primo film basato su un personaggio della DC Comics ad essere stato candidato all&#039;ambito premio per la categoria miglior film.', 'assets/images/covers/weJIgZfZcp.jpg', 13, 4, 123, 0, 0, 0, 'https://www.youtube.com/embed/o7nkJDjuSp4', '2020-01-25 17:24:46', '2020-01-25 23:50:19', '2019-10-03 22:00:00'),
(52, 'Ritorno al futuro', 'Hill Valley, California, 25 ottobre 1985. Marty McFly &egrave; un diciassettenne studente di liceo, poco disciplinato e spesso ritardatario ma coraggioso, gentile e di buon cuore, fidanzato con Jennifer Parker, sua coetanea e compagna di scuola. Marty sogna di diventare una rockstar e suona la chitarra in un gruppo rock, pur senza molta fortuna: il gruppo viene infatti bocciato al provino per suonare al ballo della scuola, perch&eacute; i docenti ritengono Marty e i suoi compagni &quot;troppo rumorosi&quot;.', 'assets/images/covers/IfpBzCRpIC.jpg', 8, 4, 120, 0, 0, 0, 'https://www.youtube.com/embed/qvsgGtivCgs', '2020-01-25 17:35:36', '2020-01-25 23:30:02', '1985-10-17 22:00:00'),
(53, 'La casa di carta', 'La casa di carta (La casa de papel) &egrave; una serie televisiva spagnola ideata da &Aacute;lex Pina e Joe W.televisiva &egrave; stata trasmessa da Antena 3 dal 2 maggio al 23 novembre 2017. In Italia la serie &egrave; stata pubblicata il 20 dicembre 2017 (prima parte), il 6 aprile 2018 (seconda parte), il 19 luglio 2019 (terza parte) e il 3 aprile 2020 (quarta parte) da Netflix.', 'assets/images/covers/UmSzfWfJdN.jpg', 5, 5, 45, 1, 10, 4, 'https://www.youtube.com/embed/ebPRR4CVNLU', '2020-01-25 17:46:35', '2020-01-25 21:43:25', '2017-05-01 22:00:00'),
(54, 'Maleficent - Signora del male', 'Maleficent - Signora del male (Maleficent: Mistress of Evil) &egrave; un film fantasy del 2019 diretto da Joachim Ronning.\r\nProdotto dalla Walt Disney Pictures, &egrave; il sequel di Maleficent, remake/spin-off del Classico Disney La bella addormentata nel bosco (1959). &Egrave; interpretato da Angelina Jolie, di nuovo nella parte di Malefica, la fata cattiva creata dalla Disney. Anche Elle Fanning, Sam Riley, Imelda Staunton, Juno Temple e Lesley Manville ritornano ai loro ruoli precedenti, con Harris Dickinson che sostituisce Brenton Thwaites del primo film, e Michelle Pfeiffer, Ed Skrein e Chiwetel Ejiofor che si uniscono al cast come nuovi personaggi.', 'assets/images/covers/iaZFeDbEow.jpg', 8, 3, 118, 0, 0, 0, 'https://www.youtube.com/embed/G3VMtpK8jjo', '2020-01-25 18:10:54', '2020-01-25 21:23:09', '2019-10-16 22:00:00'),
(55, 'The Irishman', 'The Irishman &egrave; un film del 2019 diretto da Martin Scorsese.\r\nLa pellicola, con protagonisti Robert De Niro, Al Pacino e Joe Pesci, &egrave; l&#039;adattamento cinematografico del saggio del 2004 L&#039;irlandese. Ho ucciso Jimmy Hoffa (I Heard You Paint Houses) scritto da Charles Brandt, basato sulla vita di Frank Sheeran, riedito in Italia da Fazi Editore nel 2019 col titolo The Irishman.\r\nIn una casa di cura, seduto su una sedia a rotelle, Frank Sheeran, veterano della seconda guerra mondiale, racconta la sua vita da sicario della mafia.\r\nNella Pennsylvania degli anni cinquanta, Sheeran, detto l&#039;irlandese, guida il camion per la consegna di imballaggi di carne e inizia a rivendere parte del contenuto delle sue spedizioni allo strozzino Skinny Razor, offrendogli un prezzo vantaggioso. In un&#039;occasione per&ograve; Sheeran giunge a una consegna con il carico completamente vuoto. Non potendo giustificare la cosa, &egrave; portato in tribunale dalla sua compagnia con l&#039;accusa di furto o complicit&agrave;.', 'assets/images/covers/gnFIkCoMka.jpg', 3, 4, 209, 0, 0, 0, 'https://www.youtube.com/embed/RS3aHkkfuEI', '2020-01-25 18:27:53', '2020-01-25 21:03:38', '2019-11-03 23:00:00'),
(56, 'Baby', 'Chiara e Ludovica sono due ragazze adolescenti della cosiddetta Roma Bene, risiedono nel quartiere dei Parioli e frequentano il liceo privato Collodi. La loro vita, apparentemente perfetta, cela in realt&agrave; un&#039;oscura esistenza fatta di insicurezze, paure, pressioni da amici e familiari, che porteranno le due problematiche ragazze ad entrare in contatto con persone sbagliate, finendo nel giro della prostituzione.', 'assets/images/covers/ratPrgwDyH.jpg', 5, 3, 45, 1, 13, 2, 'https://www.youtube.com/embed/2O5ZyTqFbe8', '2020-01-25 18:30:59', '2020-01-25 21:32:24', '2018-11-29 23:00:00'),
(57, 'La ricerca della felicit&agrave;', 'La ricerca della felicit&agrave; (The Pursuit of Happyness) &egrave; un film del 2006 diretto da Gabriele Muccino. Gli interpreti principali sono Will Smith, Jaden Smith e Thandie Newton.\r\n&Egrave; ispirato alla vita di Chris Gardner, imprenditore milionario, che durante i primi anni ottanta visse giorni di intensa povert&agrave;, con un figlio a carico e senza una casa dove poterlo crescere. Egli appare nella scena finale del film, in un cameo, mentre attraversa la strada in giacca e cravatta, incrociando lo sguardo con Will Smith.\r\nIl titolo fa riferimento alla dichiarazione di indipendenza degli Stati Uniti d&#039;America, come scritta da Thomas Jefferson (1743&ndash;1826), dove sono elencati i diritti inalienabili dell&#039;uomo: la tutela della vita, della libert&agrave; e la ricerca della felicit&agrave;.', 'assets/images/covers/jjgNyXKccP.jpeg', 5, 4, 117, 0, 0, 0, 'https://www.youtube.com/embed/KX_-rtjlOoA', '2020-01-25 18:33:24', '2020-01-25 21:04:39', '2007-01-11 23:00:00'),
(58, 'Narcos', 'Narcos &egrave; una serie televisiva statunitense-colombiana creata da Chris Brancato, Carlo Bernard e Doug Miro per Netflix.\r\nTutti i dieci episodi che compongono la prima stagione sono stati resi disponibili sulla piattaforma di streaming Netflix dal 28 agosto 2015.[1] Poco dopo la serie &egrave; stata rinnovata per una seconda stagione, pubblicata il 2 settembre 2016.[2] La serie &egrave; stata rinnovata per una terza stagione, resa disponibile il 1&ordm; settembre 2017.\r\n&Egrave; seguita dalla serie Narcos: Messico, incentrata sull&#039;origine del cartello di Guadalajara[4][5] pubblicata il 16 novembre 2018.', 'assets/images/covers/zhbkDUySoM.jpg', 5, 3, 45, 1, 10, 3, 'https://www.youtube.com/embed/RNWAKZzgbp4', '2020-01-25 18:35:53', '2020-01-25 21:31:09', '2015-08-27 22:00:00'),
(59, 'Ozark', 'La famiglia Byrde conduce una vita molto tranquilla fino a quando Marty, il capofamiglia, si ritrova coinvolto nel mondo del riciclaggio di denaro sporco per conto di un cartello della droga messicano.', 'assets/images/covers/TzBBGNZrgk.jpg', 13, 5, 60, 1, 10, 3, 'https://www.youtube.com/embed/RDuSZMhXUSM', '2020-01-25 22:32:55', '2020-01-25 22:34:11', '2017-07-20 22:00:00');

--
-- Trigger `media`
--
DELIMITER $$
CREATE TRIGGER `updater_med` BEFORE UPDATE ON `media` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE `user` (
  `name` varchar(250) NOT NULL,
  `surname` varchar(250) NOT NULL,
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(150) NOT NULL,
  `avatar_url` varchar(1000) NOT NULL DEFAULT '/assets/images/avatars/default.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`name`, `surname`, `id`, `email`, `avatar_url`, `created_at`, `updated_at`) VALUES
('Admin', '', 10, 'admin@flixy.com', '/assets/images/avatars/WEsxrZkeJR.png', '2020-01-03 12:02:25', '2020-01-25 12:52:46'),
('Andrea', 'Polo', 12, 'andreapolo98@gmail.com', '/assets/images/avatars/rytsmFvEkp.jpg', '2020-01-03 23:56:57', '2020-01-05 17:26:46'),
('Matteo', 'Pillon', 20, 'lupopippo@gmail.com', '/assets/images/avatars/default.png', '2020-01-23 17:55:55', '2020-01-25 12:34:16'),
('User', '', 22, 'user@gmail.com', '/assets/images/avatars/KixJBKxGnX.png', '2020-01-25 13:16:07', '2020-01-25 13:18:57'),
('Brad', 'Pitt', 23, 'brad@gmail.com', '/assets/images/avatars/bsiNrQNxcX.jpg', '2020-01-26 00:26:31', '2020-01-26 00:28:44'),
('Giuseppe', 'Falchi', 24, 'giufalchi@gmail.com', '/assets/images/avatars/RjarSKtLUD.png', '2020-01-26 00:38:06', '2020-01-26 00:54:31');

--
-- Trigger `user`
--
DELIMITER $$
CREATE TRIGGER `updater_usr` BEFORE UPDATE ON `user` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `vote`
--

CREATE TABLE `vote` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `positive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `vote`
--

INSERT INTO `vote` (`id`, `user_id`, `media_id`, `created_at`, `updated_at`, `positive`) VALUES
(4, 12, 2, '2020-01-05 17:02:02', '2020-01-24 10:38:07', 1),
(6, 10, 29, '2020-01-05 21:49:23', '2020-01-05 21:49:23', 1),
(7, 10, 27, '2020-01-10 17:03:21', '2020-01-10 17:03:21', 0),
(8, 10, 1, '2020-01-23 17:42:31', '2020-01-23 17:42:31', 1),
(9, 20, 1, '2020-01-23 18:01:37', '2020-01-23 18:01:45', 0),
(10, 20, 2, '2020-01-23 18:01:50', '2020-01-23 18:01:52', 0),
(11, 20, 23, '2020-01-23 18:01:57', '2020-01-23 18:01:57', 1),
(12, 20, 24, '2020-01-23 18:02:01', '2020-01-23 18:02:01', 0),
(13, 20, 25, '2020-01-23 18:02:14', '2020-01-23 18:02:14', 0),
(14, 20, 30, '2020-01-23 18:06:23', '2020-01-23 18:11:53', 1),
(16, 22, 47, '2020-01-25 18:38:31', '2020-01-25 18:38:31', 1),
(20, 22, 53, '2020-01-25 18:39:09', '2020-01-25 18:39:09', 1),
(21, 22, 51, '2020-01-25 18:39:18', '2020-01-25 18:39:18', 1),
(24, 22, 49, '2020-01-26 00:03:39', '2020-01-26 00:03:39', 1),
(25, 22, 50, '2020-01-26 00:03:43', '2020-01-26 00:03:43', 0),
(26, 22, 59, '2020-01-26 00:04:02', '2020-01-26 00:04:02', 1),
(27, 24, 52, '2020-01-26 00:46:29', '2020-01-26 00:46:29', 1),
(28, 24, 47, '2020-01-26 00:46:43', '2020-01-26 00:46:43', 1),
(29, 24, 56, '2020-01-26 00:46:51', '2020-01-26 00:46:51', 0),
(30, 24, 53, '2020-01-26 00:47:02', '2020-01-26 00:47:02', 1),
(31, 24, 48, '2020-01-26 00:55:35', '2020-01-26 00:55:35', 1);

--
-- Trigger `vote`
--
DELIMITER $$
CREATE TRIGGER `updater_vot` BEFORE UPDATE ON `vote` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indici per le tabelle `episode`
--
ALTER TABLE `episode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indici per le tabelle `favourite`
--
ALTER TABLE `favourite`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `FavIndex` (`user_id`,`media_id`);

--
-- Indici per le tabelle `feed`
--
ALTER TABLE `feed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indici per le tabelle `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `keychain`
--
ALTER TABLE `keychain`
  ADD PRIMARY KEY (`username`),
  ADD KEY `user_id` (`user_id`);
ALTER TABLE `keychain` ADD FULLTEXT KEY `username` (`username`);

--
-- Indici per le tabelle `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indici per le tabelle `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`media_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT per la tabella `episode`
--
ALTER TABLE `episode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT per la tabella `favourite`
--
ALTER TABLE `favourite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT per la tabella `feed`
--
ALTER TABLE `feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT per la tabella `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT per la tabella `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT per la tabella `vote`
--
ALTER TABLE `vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
