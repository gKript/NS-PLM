-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Gen 02, 2020 alle 01:10
-- Versione del server: 10.3.14-MariaDB
-- Versione PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nsid_plm_data`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `catgenerica`
--

DROP TABLE IF EXISTS `catgenerica`;
CREATE TABLE IF NOT EXISTS `catgenerica` (
  `ind` int(11) NOT NULL AUTO_INCREMENT,
  `idCatGen` varchar(3) NOT NULL,
  `CatGen` text NOT NULL,
  `CatGenDescr` varchar(64) NOT NULL,
  `dbCatGen` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ind`),
  UNIQUE KEY `idCatGen` (`idCatGen`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `catgenerica`
--

INSERT INTO `catgenerica` (`ind`, `idCatGen`, `CatGen`, `CatGenDescr`, `dbCatGen`) VALUES
(1, '0', 'Generica', 'Non attribuibile a categoria', 1),
(2, '1', 'Meccanica', 'Parte meccanica', 1),
(3, '2', 'Elettronica', 'Componete o scheda', 1),
(4, '3', 'Software', 'Compilato o interpretato, basato su OS', 0),
(5, '4', 'Firmware', 'SW per scheda specifica NON basato su OS', 0),
(6, '5', 'Software + Firmware', 'Elemento Sw/Fw per Apparato o Sistema', 0),
(7, '6', 'Apparato', 'Meccanica + Elettonica + Sw/Fw', 1),
(8, '7', 'Sistema', 'Più apparati anche con metodi', 1),
(9, '8', 'Simulazione', 'Simulazione di progetti, calcoli, circuiti analogici o digitali', 0),
(10, '9', 'Organizzazione', 'Regole e procedure', 0),
(11, 'A', 'Marketing', 'Brochure, presentazioni, richieste', 0),
(12, 'B', 'Metodo', 'Logica di utilizzo di un Progetto', 1),
(13, 'C', 'Prodotto', 'Codice padre per distinta di vendita', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `catspecifica`
--

DROP TABLE IF EXISTS `catspecifica`;
CREATE TABLE IF NOT EXISTS `catspecifica` (
  `ind` int(11) NOT NULL AUTO_INCREMENT,
  `idCatSpec` varchar(3) NOT NULL,
  `CatSpec` text NOT NULL,
  `CatSpecDesc` text DEFAULT NULL,
  `dbCatSpec` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ind`),
  UNIQUE KEY `idCatSpec` (`idCatSpec`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `catspecifica`
--

INSERT INTO `catspecifica` (`ind`, `idCatSpec`, `CatSpec`, `CatSpecDesc`, `dbCatSpec`) VALUES
(1, '0', 'Generica', 'Generica', 1),
(2, '1', 'Meccanica', 'Parti meccaniche di acquisto ( staffe, viti, bulloni, rondelle, grani ... )', 0),
(3, '2', 'Meccanica', 'Parti meccanica a progetto ( supporti particolari, case progettati )', 1),
(4, '3', 'Elettronica', 'Componenti elettronici ( chip, resistenze, diodi, condensatori, led ... )', 0),
(5, '4', 'Elettronica', 'Schede di acquisto ( ricetrasmettitori, converitori ... )', 0),
(6, '5', 'Elettronica', 'Schede a progetto ( Sblcd ... )', 1),
(7, '6', 'Software', 'Software ( Gim, PicGim, gKnoisePWL  ... )', 0),
(8, '7', 'Apparato', 'Apparato meccanico + pcb + firmware/software', 1),
(9, '8', 'Firmware', 'Firmaware per scheda', 0),
(10, '9', 'Simulazione', 'Simulazione di progetti con programmi tipo LTSpice o Cedar', 0),
(11, 'A', 'Sistema', 'Più apparati con anche metodi', 1),
(12, 'B', 'Libreria', 'SW, Eagle, ...', 1),
(13, 'C', 'Elettronica', 'Varia ( schede e parti assemblate di vario tipo )', 1),
(14, 'D', 'Organizzazione', 'Regole e procedure', 0),
(15, 'E', 'Gestione', 'Gestire informazioni aziendali e non', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `codattributes`
--

DROP TABLE IF EXISTS `codattributes`;
CREATE TABLE IF NOT EXISTS `codattributes` (
  `Codice` varchar(11) NOT NULL,
  `bom` tinyint(1) NOT NULL,
  `Provider` tinyint(1) NOT NULL,
  `Origins` varchar(11) NOT NULL,
  `Critical` tinyint(1) NOT NULL,
  `Important` tinyint(1) NOT NULL,
  `Testing` tinyint(1) NOT NULL,
  `Expiration` tinyint(1) NOT NULL,
  `Expiration_time` varchar(32) NOT NULL,
  `RoHS` tinyint(1) NOT NULL,
  `Dangerous` tinyint(1) NOT NULL,
  `Regulatory` tinyint(1) NOT NULL,
  `Warranty` varchar(32) NOT NULL,
  `Unit` varchar(16) NOT NULL,
  `Compliance` varchar(32) NOT NULL,
  `Tracebility` tinyint(1) NOT NULL,
  `Length` varchar(16) NOT NULL,
  `Width` varchar(16) NOT NULL,
  `Height` varchar(16) NOT NULL,
  `Weight` varchar(16) NOT NULL,
  `createTS` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifyTS` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  UNIQUE KEY `Codice` (`Codice`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `codattributes`
--

INSERT INTO `codattributes` (`Codice`, `bom`, `Provider`, `Origins`, `Critical`, `Important`, `Testing`, `Expiration`, `Expiration_time`, `RoHS`, `Dangerous`, `Regulatory`, `Warranty`, `Unit`, `Compliance`, `Tracebility`, `Length`, `Width`, `Height`, `Weight`, `createTS`, `modifyTS`) VALUES
('54B0000101 ', 1, 0, '0', 0, 1, 1, 0, 'NULL', 0, 0, 0, '0', 'NA', 'GPL V3', 0, '0', '0', '0', '0', '2019-12-25 00:20:55', '2020-01-01 17:27:19');

-- --------------------------------------------------------

--
-- Struttura della tabella `dbupdate`
--

DROP TABLE IF EXISTS `dbupdate`;
CREATE TABLE IF NOT EXISTS `dbupdate` (
  `last_write` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `distinta`
--

DROP TABLE IF EXISTS `distinta`;
CREATE TABLE IF NOT EXISTS `distinta` (
  `idDistinta` int(11) NOT NULL AUTO_INCREMENT,
  `dbCodice` text NOT NULL,
  `dbCodice_padre` text NOT NULL,
  `dbDescrizione` text NOT NULL,
  `dbQuantita` int(11) NOT NULL,
  PRIMARY KEY (`idDistinta`),
  UNIQUE KEY `idDistinta` (`idDistinta`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `distinta`
--

INSERT INTO `distinta` (`idDistinta`, `dbCodice`, `dbCodice_padre`, `dbDescrizione`, `dbQuantita`) VALUES
(2, '125000100', '557000100', 'SPA Control PCB', 1),
(3, '425000100', '557000100', 'SPA Prototipo 3ch Sense + 1ch Shot PCB', 1),
(4, '157000100', '557000100', 'Supporto vibrante sensori + PCB Sense e Shot', 1),
(5, '011000100', '112000100', 'Grano M2 brugola', 1),
(6, '011000200', '112000100', 'Vite M2x3 Testa piana a taglio', 2),
(7, '112000100', '157000200', 'SPA Sense supporto vibrante', 1),
(8, '125000200', '157000200', 'SPA Sense PCB', 1),
(9, '023000100', '157000200', 'Sensore piezoceramico bimorfo vibrazione Cod RS 285784', 1),
(10, '157000200', '157000100', 'SPA Sense modulo ( Supporto + PCB + Sensore )', 8),
(11, '157000300', '157000100', 'SPA Shot modulo ( Supporto + PCB + Sensore )', 1),
(12, '886000100', '136000300', 'Generic Information Manager Documentation', 1),
(13, '536000300', '136000300', 'Generic Information Manager 3', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `elenco_codici`
--

DROP TABLE IF EXISTS `elenco_codici`;
CREATE TABLE IF NOT EXISTS `elenco_codici` (
  `idCodice` int(11) NOT NULL AUTO_INCREMENT,
  `codice` varchar(10) NOT NULL,
  `T` int(1) NOT NULL,
  `CG` varchar(3) NOT NULL,
  `CS` varchar(3) NOT NULL,
  `abbreviazione` text NOT NULL,
  `descrizione` text NOT NULL,
  `dbCodici` int(11) NOT NULL DEFAULT 0,
  `createTS` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifyTS` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`idCodice`),
  UNIQUE KEY `codice` (`codice`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `elenco_codici`
--

INSERT INTO `elenco_codici` (`idCodice`, `codice`, `T`, `CG`, `CS`, `abbreviazione`, `descrizione`, `dbCodici`, `createTS`, `modifyTS`) VALUES
(1, '2110000100', 2, '1', '1', 'Grano', 'Grano M2 brugola', 0, '2013-07-13 01:52:20', '2019-12-24 01:24:11'),
(16, '54B0000101', 5, '4', 'B', 'PicGIM', 'Generic Information Manager for PIC', 1, '2013-07-09 19:42:14', '2019-12-23 22:28:12'),
(18, '89D0000102', 8, '9', 'D', 'gKCodeRules', 'Regole per la codifica', 0, '2013-07-09 23:29:52', '2019-12-23 22:28:12'),
(19, '2110000200', 2, '1', '1', 'Vite', 'Vite M2x3 Testa piana a taglio', 0, '2013-07-13 09:51:53', '2019-12-24 01:23:22'),
(20, '2230000100', 2, '2', '3', 'Piezo', 'Sensore piezoceramico bimorfo vibrazione Cod RS 285784', 1, '2013-07-15 23:36:42', '2019-12-24 00:57:23'),
(21, '2230000200', 2, '2', '3', '74lv138', 'Decoder/Demultiplexer Single 3-to-8 74lv138 Cod RS 663-2688', 0, '2013-07-15 23:47:47', '2019-12-24 00:57:33'),
(22, '89B0000103', 8, '9', 'B', 'Gim Documentation', 'Generic Information Manager Documentation', 1, '2013-07-16 19:03:40', '2019-12-27 01:15:24'),
(23, '53B0000103', 5, '3', 'B', 'Gim3', 'Generic Information Manager 3', 0, '2013-07-16 19:18:23', '2019-12-23 22:28:12'),
(28, '2240000100', 2, '2', '4', 'PreReg-lm2596', 'Modulo preregolatore buck step down LM2596', 0, '2013-08-24 22:26:52', '2019-12-24 01:23:45'),
(30, '57C0000100', 5, '7', 'C', 'Onesto', 'Varco a passaggio libero con rilevazione di passaggio e del titolo di viaggio. Prodotto specifico per il Trasporto pubblico.', 0, '2019-12-22 23:20:23', '2020-01-01 15:33:43'),
(31, '8C00000100', 8, 'C', '0', 'Onesto P.C.', 'Onesto Product Concept', 0, '2019-12-22 23:20:23', '2019-12-23 22:28:12'),
(32, '58A0000100', 5, '8', 'A', 'Onesto Modello', 'Onesto Modello Matematico del metodo', 0, '2019-12-22 23:22:22', '2019-12-23 22:28:12'),
(33, '4670000100', 4, '6', '7', 'TWD Master', 'Tag Walking Device Master', 1, '2019-12-22 23:22:22', '2020-01-01 15:29:15'),
(34, '16C0000100', 1, '6', 'C', 'Sensors Wide', 'Sensors Wide', 0, '2019-12-22 23:24:04', '2019-12-23 22:28:12'),
(35, '2240000200', 2, '2', '4', 'Arduino Due', 'Arduino Due', 0, '2019-12-22 23:24:04', '2019-12-24 01:23:32'),
(36, '53E0000100', 5, '3', 'E', 'NS-PLM', 'Next Step PLM by NSID', 0, '2019-12-26 21:17:14', '2019-12-26 21:18:05'),
(37, '43B0000100', 4, '3', 'B', 'Gim', 'Generic Information manager PROTO', 0, '2019-12-27 22:07:02', '2019-12-27 22:07:02'),
(38, '53B0000101', 5, '3', 'B', 'Gim 1', 'Generic information manager 1', 0, '2019-12-27 22:23:54', '2019-12-27 22:23:54'),
(39, '53B0000102', 5, '3', 'B', 'Gim 2', 'Generic information manager 2', 0, '2019-12-27 22:24:48', '2019-12-27 22:24:48'),
(40, '2240000300', 2, '2', '4', 'Raspberry PI 1', 'Model B+ 512MB RAM ', 0, '2019-12-27 22:46:18', '2019-12-27 22:46:18'),
(41, '2230000300', 2, '2', '3', 'MicroSD 64GB', 'MicroSCXC UHS-I Card Pro Plus Class 10 U3 I ', 0, '2019-12-27 22:51:17', '2019-12-27 22:51:17'),
(42, '22C0000100', 2, '2', 'C', 'Switch eth 8 ports PoE', 'UBIQUITI Networks UniFi Switch 8 Gigabit Ethernet (10/100/1000) PoE', 0, '2019-12-29 21:52:50', '2019-12-29 21:52:50'),
(43, '2230000400', 2, '2', '3', 'DC Stepdown 5V 5A', 'JZK 24V 12V a 5V 5A LM2596S step down', 0, '2019-12-29 22:06:42', '2019-12-29 22:06:42'),
(44, '2230000500', 2, '2', '3', 'DC Stepdown 48V->12V', '36V 48V a 12V 25A 300W di Tensione Riduttore DC Step-Down convertitore', 0, '2019-12-29 22:08:27', '2019-12-29 22:08:27'),
(46, '22C0000200', 2, '2', 'C', 'Power Supply 48V ', '48V 12.5A 600W 110/220VAC-DC48V Switching Power Supply 600 Watts', 0, '2019-12-29 22:10:36', '2019-12-29 22:10:36'),
(47, '2240000400', 2, '2', '4', 'Raspberry PI 4 Computer', 'Model B 2GB RAM ', 0, '2020-01-01 13:49:21', '2020-01-01 13:49:21'),
(49, '22C0000300', 2, '2', 'C', 'Cavo Ethernet ', 'Cat.7 Cavo di Rete 1m - Rosso', 0, '2020-01-01 13:58:58', '2020-01-01 13:58:58'),
(50, '1120000100', 1, '1', '2', 'Scatola TWD Master', 'Supporti elastici, pannello connessioni Master', 0, '2020-01-01 14:01:33', '2020-01-01 14:01:33'),
(51, '1120000200', 1, '1', '2', 'Scatola TWD Slave', 'Supporti elastici, pannello connessioni Slave', 0, '2020-01-01 14:02:00', '2020-01-01 14:02:00'),
(52, '22C0000400', 2, '2', 'C', 'PoE splitter cable', '12v-48v Cavetti Splitter Adattatori Poe', 0, '2020-01-01 14:15:31', '2020-01-01 14:15:31'),
(53, '3440000100', 3, '4', '4', 'Sensors wide firmware', 'FW (Arduino) per la gestione dei sensori (FIR, TOF, Environment, Accellerometer)', 0, '2020-01-01 15:22:14', '2020-01-01 15:22:14'),
(54, '3440000200', 3, '4', '4', 'Sensors small firmware', 'FW (Arduino) per la gestione dei sensori (FIR, TOF)', 0, '2020-01-01 15:23:27', '2020-01-01 15:23:27'),
(55, '4670000200', 4, '6', '7', 'TWD Slave', 'Tag Walking Device Slave', 0, '2020-01-01 15:29:45', '2020-01-01 15:29:45'),
(57, '26C0000100', 2, '6', 'C', 'Contapersone CPX3D', 'Comptipix 3d contapersone PoE con sensori HDR', 0, '2020-01-01 23:12:50', '2020-01-01 23:12:50');

-- --------------------------------------------------------

--
-- Struttura della tabella `lista_composizione`
--

DROP TABLE IF EXISTS `lista_composizione`;
CREATE TABLE IF NOT EXISTS `lista_composizione` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `father` varchar(11) NOT NULL,
  `son` varchar(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `revision` int(3) UNSIGNED NOT NULL,
  `creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `modify` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `lista_composizione`
--

INSERT INTO `lista_composizione` (`id`, `father`, `son`, `quantity`, `revision`, `creation`, `modify`) VALUES
(1, '57C0000100', '8C00000100', 0, 1, '2020-01-01 16:27:43', '2020-01-01 16:27:43'),
(2, '57C0000100', '58A0000100', 0, 1, '2020-01-01 16:28:23', '2020-01-01 16:28:23'),
(3, '57C0000100', '4670000100', 1, 1, '2020-01-01 16:29:41', '2020-01-01 16:29:41'),
(4, '57C0000100', '4670000200', 2, 1, '2020-01-01 16:29:41', '2020-01-01 16:29:41'),
(5, '4670000100', '16C0000100', 1, 1, '2020-01-01 20:00:43', '2020-01-01 20:00:43'),
(6, '16C0000100', '2240000100', 1, 1, '2020-01-01 20:03:48', '2020-01-01 20:03:48'),
(7, '16C0000100', '3440000100', 1, 1, '2020-01-01 20:03:48', '2020-01-01 20:03:48'),
(9, '4670000100', '26C0000100', 1, 1, '2020-01-02 00:35:14', '2020-01-02 00:35:14'),
(10, '4670000100', '1120000100', 1, 1, '2020-01-02 00:36:06', '2020-01-02 00:36:06'),
(11, '4670000200', '1120000200', 1, 1, '2020-01-02 01:03:39', '2020-01-02 01:03:39');

-- --------------------------------------------------------

--
-- Struttura della tabella `statistics`
--

DROP TABLE IF EXISTS `statistics`;
CREATE TABLE IF NOT EXISTS `statistics` (
  `statid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `value` varchar(32) NOT NULL,
  `timest` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `statid` (`statid`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `statistics`
--

INSERT INTO `statistics` (`statid`, `name`, `value`, `timest`) VALUES
(1, 'CodeCountDaily', '21', '2019-12-28 22:51:12'),
(2, 'CodeCountDaily', '18', '2019-12-26 23:32:45'),
(7, 'CodeCountDaily', '21', '2019-12-29 16:17:48'),
(8, 'AttribCountDaily', '1', '2019-12-29 16:18:44'),
(9, 'CodeCountDaily', '25', '2019-12-30 00:21:38'),
(10, 'AttribCountDaily', '1', '2019-12-30 00:21:38'),
(11, 'CodeCountDaily', '25', '2019-12-31 00:02:46'),
(12, 'AttribCountDaily', '1', '2019-12-31 00:02:46'),
(15, 'CodeCountDaily', '30', '2020-01-01 14:16:15'),
(14, 'AttribCountDaily', '1', '2020-01-01 11:16:05'),
(16, 'CodeCountDaily', '34', '2020-01-02 00:00:00'),
(17, 'AttribCountDaily', '1', '2020-01-02 00:00:00'),
(18, 'BomCountDaily', '3', '2020-01-02 00:55:21');

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologia`
--

DROP TABLE IF EXISTS `tipologia`;
CREATE TABLE IF NOT EXISTS `tipologia` (
  `ind` int(11) NOT NULL AUTO_INCREMENT,
  `idTip` int(11) NOT NULL,
  `Tip` text NOT NULL,
  `dbTip` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ind`),
  UNIQUE KEY `idTip` (`idTip`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `tipologia`
--

INSERT INTO `tipologia` (`ind`, `idTip`, `Tip`, `dbTip`) VALUES
(1, 0, 'Codice singolo', 0),
(2, 1, 'Codice di assieme', 1),
(3, 2, 'Codice di acquisto', 0),
(4, 3, 'Software', 0),
(5, 4, 'Prototipo', 1),
(6, 5, 'Progetto Sviluppo', 1),
(7, 6, 'Progetto Finito', 1),
(8, 8, 'Documentazione', 0),
(9, 9, 'Temporaneo', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `unità_di_misure`
--

DROP TABLE IF EXISTS `unità_di_misure`;
CREATE TABLE IF NOT EXISTS `unità_di_misure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(16) NOT NULL,
  `descrizione` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `unità_di_misure`
--

INSERT INTO `unità_di_misure` (`id`, `nome`, `descrizione`) VALUES
(1, 'N', 'Numero'),
(2, 'CM', 'Centimetri'),
(3, 'M', 'Metri'),
(4, 'L', 'Litri'),
(5, 'CL', 'Centilitri'),
(6, 'G', 'Grammo'),
(7, 'KG', 'Kilogrammo'),
(8, 'NA', 'Non applicabile');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
