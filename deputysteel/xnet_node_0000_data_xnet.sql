-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 26, 2015 at 05:55 AM
-- Server version: 5.5.44
-- PHP Version: 5.5.29-1~dotdeb+7.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xnet_node_0000_data_xnet`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE IF NOT EXISTS `about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postingProfile` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `following`
--

CREATE TABLE IF NOT EXISTS `following` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postingProfile` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postingProfile` int(11) NOT NULL,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `firstSeen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastSeen` datetime DEFAULT NULL,
  `tag` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `nodeUsers`
--

CREATE TABLE IF NOT EXISTS `nodeUsers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node` int(11) NOT NULL,
  `postingProfile` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `gang` text NOT NULL,
  `operator` text NOT NULL,
  `person` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

--
-- Dumping data for table `nodeUsers`
--

INSERT INTO `nodeUsers` (`id`, `node`, `postingProfile`, `username`, `password`, `gang`, `operator`, `person`) VALUES
(1, 0, 'Nik', 'nikupton10@gmail.com', 'kbH@prv()29', 'nerds', 'nik', 0),
(2, 1, 'Dexter Boys', 'Beyoncaphillips@gmx.com', 'beyoncafacebook313', 'Dexter Boys', '', 1),
(3, 1, 'Redwing', 'dominimoss313@gmail.com', 'dominifacebook48205', 'Redwing', '', 2),
(4, 1, 'Maxxout', 'floressacarter@gmx.com', 'floressafacebook313', 'Maxxout', '', 3),
(5, 1, 'Zone 8', 'octaviashort@lycos.com', 'octaviafacebook313', 'Zone 8', '', 4),
(6, 1, 'True Savage Niggas (TSN)', 'shardaydodson@gmx.com', 'shardayfacebook313', 'True Savage Niggas (TSN)', '', 5),
(7, 1, 'RTM', 'chamique.smith@yahoo.com', 'chamiquefacebook48205', 'RTM', '', 6),
(8, 1, 'EveryBody Eatin (EBE)', 'erykahwhite313@yahoo.com', 'erykahfacebook313', 'EveryBody Eatin (EBE)', '', 7),
(9, 1, 'MVHN', 'Patience.Whitehead@gmx.com', 'PWfacebook313!', 'MVHN', '', 8),
(10, 1, 'Northend Boyz', 'Lewis.adelle@yahoo.com', 'ALfacebook313', 'Northend Boyz', '', 9),
(11, 1, 'Major League', 'Foster.Mystique313@gmail.com', 'mystiquefacebook313', 'Major League', '', 10),
(12, 2, 'PNF', 'Eboni.hill@gmx.com', 'ebonifacebook313', 'PNF', '', 1),
(13, 2, 'East Warren Posse', 'Haileypoole@lycos.com', 'haileyfacebook313', 'East Warren Posse', '', 2),
(14, 2, '11 Deep', 'venitabarry@gmx.com', 'venitafacebook313', '11 Deep', '', 3),
(15, 2, 'OES 187', 'akaylacampbell@lycos.com', 'akaylafacebook313', 'OES 187', '', 4),
(16, 2, 'Winona Boys', 'naimapatterson313@yahoo.com', 'naimafacebook313', 'Winona Boys', '', 5),
(17, 2, 'Fenkell Boys', 'brieshaedwards@gmx.com', 'brieshafacebook313', 'Fenkell Boys', '', 6),
(18, 2, '8 Mile Sconies', 'francelle.clark@yahoo.com', 'francellefacebook313', '8 Mile Sconies', '', 7),
(19, 2, 'Puritan Aves', 'halle.graham313@gmail.com', 'hallefacebook313', 'Puritan Aves', '', 8),
(20, 2, 'Warren Kings', 'ceeceebryant@yahoo.com', 'CCBfacebook313', 'Warren Kings', '', 9),
(21, 2, 'BOB', 'naomi.gaines@gmx.com', 'naomifacebook313', 'BOB', '', 10),
(22, 3, 'Get Money Boys (GMB)', 'aiesha.g313@gmail.com', 'aieshafacebook313', 'Get Money Boys (GMB)', '', 1),
(23, 3, 'Real Hood Niggaz (RHN)', 'Grecia.Harris313@yahoo.com', 'greciafacebook313', 'Real Hood Niggaz (RHN)', '', 2),
(24, 3, '50 Zone', 'jamekareese@gmx.com', 'jamekafacebook313', '50 Zone', '', 3),
(25, 3, 'Number Gang', 'cierabrewer@aol.com', 'cierafacebook313', 'Number Gang', '', 4),
(26, 3, 'BHB', 'nikeesha.anthony@gmx.com', 'nikeeshafacebook313', 'BHB', '', 5),
(27, 3, 'Goodfella Mafia', 'benitayoung@gmx.com', 'benitafacebook313', 'Goodfella Mafia', '', 6),
(28, 3, 'Stunthard', 'Harmony.wallace313@gmail.com', 'harmonyfacebook313', 'Stunthard', '', 7),
(29, 3, 'AG', 'iieshafowler@gmx.com', 'ileshafacebook313', 'AG', '', 8),
(30, 3, 'Hellzone and Helly Helly Boys', 'giedrewalker@gmx.com', 'GWfacebook313', 'Hellzone and Helly Helly Boys', '', 9),
(31, 3, 'ATM', 'nyla.oneal@gmx.xom', 'nylafacebook313', 'ATM', '', 10),
(32, 4, 'SYN', 'daishaun.benson@yahoo.com', 'daishaunfacebook313', 'SYN', '', 1),
(33, 4, 'ASBH', 'ikia.woods@lycos.com', 'ikiafacebook48205', 'ASBH', '', 2),
(34, 4, 'Hobsquad / Seven Mile Bloods', 'yalissa.avery@yahoo.com', 'yalissafacebook313', 'Hobsquad / Seven Mile Bloods', '', 3),
(35, 4, 'Clownsquad', 'giselle.king@gmx.com', 'gisellefacebook313', 'Clownsquad', '', 4),
(36, 4, 'State Fair', 'Gilmore.Omeika313@gmail.com', 'omeikafacebook313', 'State Fair', '', 5),
(37, 4, 'Hustle the Ball (HTB)', 'markesha.lee@aol.com', 'MLfacebook313', 'Hustle the Ball (HTB)', '', 6),
(38, 4, 'ATB', 'Monique.griffin313@gmx.com', 'moniquefacebook313', 'ATB', '', 7),
(39, 4, 'TMC', 'Vaniquameadows@gmail.com', 'Vmfacebook', 'TMC', '', 8),
(40, 4, 'RBM', 'indiaburgess@lycos.com', 'indiafacebook313', 'RBM', '', 9),
(41, 4, 'Self Made Niggas (SMN)', 'ona.charles@gmx.com', 'OCfacebook313', 'Self Made Niggas (SMN)', '', 10),
(42, 5, 'Hustleboys', 'bailleymorris@gmail.com', 'bailleyfacebook313', 'Hustleboys', '', 1),
(43, 5, 'Bandcrew', 'felicia.evans205@yahoo.com', 'feliciafacebook313', 'Bandcrew', '', 2),
(44, 5, 'Trust No One (TNO)', 'Imaanstevenson@gmx.com', 'imaanfacebook313', 'Trust No One (TNO)', '', 3),
(45, 5, 'Rwk', 'jaelyncobb@gmx.com', 'JCfacebook313', 'Rwk', '', 4),
(46, 5, 'Plymouth Road (PROCK)', 'promise.beasley@yahoo.com', 'PBfacebook313!', 'Plymouth Road (PROCK)', '', 5),
(47, 5, 'The Take Over (TTO)', 'Finesse4@yahoo.com', 'finessefacebook313', 'The Take Over (TTO)', '', 6),
(48, 5, 'BBH', 'jailysa.patton@lycos.com', 'jailysafacebook313', 'BBH', '', 7),
(49, 5, 'Joy Road Boys', 'vanessamays@gmx.com', 'vanessafacebook313', 'Joy Road Boys', '', 8),
(50, 5, 'YFM', 'kadejah.marsh@gmx.com', 'kadejahfacebook313', 'YFM', '', 9),
(51, 5, 'Real Nigga Shit (RNS)', 'qiannap@gmx.com', 'qiannafacebook313', 'Real Nigga Shit (RNS)', '', 10),
(52, 6, 'Killers Mean Business (KMB)', 'Destinee.bowen313@gmail.com', 'destineefacebook313', 'Killers Mean Business (KMB)', '', 1),
(53, 6, 'Vinewood boys', 'Jaamise.Ball@gmail.com', 'JBfacebook313', 'Vinewood boys', '', 2),
(54, 6, 'CMH', 'lataesha.atkins@gmx.com', 'lataeshafacebook313', 'CMH', '', 3),
(55, 6, 'Young Paper Chasers', 'Kanisha.jefferson@lycos.com', 'kanishafacebook313', 'Young Paper Chasers', '', 4),
(56, 6, 'YFN', 'quandashields@gmx.com', 'QuandaFacebook313', 'YFN', '', 5),
(57, 6, 'YNC', 'chardonnay.byrd@gmx.com', 'chardonnayfacebook313', 'YNC', '', 6),
(58, 6, 'Loyalty Come First (LCF)', 'elysiaallen@gmx.com', 'elysiafacebook313', 'Loyalty Come First (LCF)', '', 7),
(59, 6, 'CNE', 'essenceturner@gmx.com', 'essencefacebook313', 'CNE', '', 8),
(60, 6, 'Insane Vice Lords', 'LaChellepark@gmx.com', 'lachellefacebook313', 'Insane Vice Lords', '', 9),
(61, 6, 'Savage Hood Niggas', 'quanshay.bullock@gmx.com', 'quanshayfacebook313', 'Savage Hood Niggas', '', 10),
(62, 7, 'Linwood Boys', 'akeema.williams@gmx.com', 'akeemafacebook313', 'Linwood Boys', '', 1),
(63, 7, 'Crispy N Paid (CNP)', 'danellsharp735@yahoo.com', 'DSharpfb313', 'Crispy N Paid (CNP)', '', 2),
(64, 7, 'YNF', 'kaisha.buchanan@yahoo.com', 'KBfacebook313', 'YNF', '', 3),
(65, 7, 'Latin Counts', 'melanie.ayers313@gmail.com', 'MAfacebook313', 'Latin Counts', '', 4),
(66, 7, 'YPB', 'raechelljohnson@gmx.com', 'raechellfacebook313', 'YPB', '', 5),
(67, 7, 'Mack Bois', 'gabriellejones@gmx.com', 'gabriellefacebook313', 'Mack Bois', '', 6),
(68, 7, 'Young Niggas with Money (YN w/ M)', 'hiarireid@yahoo.com', 'hiarifacebook313!', 'Young Niggas with Money (YN w/ M)', '', 7),
(69, 7, 'CTD', 'lekeisha.wilkins@lycos.com', 'lekeishafacebook313', 'CTD', '', 8),
(70, 7, 'Gutta Boys', 'Moesha.wright313@yahoo.com', 'moeshafacebook313', 'Gutta Boys', '', 9),
(71, 7, 'BSM', 'Remyleach@lycos.com', 'RLfacebook313', 'BSM', '', 10),
(72, 8, 'Seven Mile Boys', 'rheanna.ayers@lycos.com', 'rheannafacebook313', 'Seven Mile Boys', '', 1),
(73, 8, 'Warren Up', 'rochelle.sheppard@yahoo.com', 'RSfacebook313', 'Warren Up', '', 2),
(74, 8, 'ABM', 'Sabrena.barron@lycos.com', 'sabrenafacebook313', 'ABM', '', 3),
(75, 8, 'Family Come First (FCF)', 'sweeks.313@gmx.com', 'shantellfacebook313', 'Family Come First (FCF)', '', 4),
(76, 8, '220 Boys', 'Bradshaw.sierra313@gmail.com', 'sierrafacebook313', '220 Boys', '', 5),
(77, 8, 'BCB', 'tpace.313@gmx.com', 'tameekafacebook48205', 'BCB', '', 6),
(78, 8, 'Boss Boy Goonz(BBG)', 'tanay.browning@gmx.com', 'tanayfacebook313', 'Boss Boy Goonz(BBG)', '', 7),
(79, 8, 'Six Mile Boys', 'tekeshia.livingston@gmail.com', 'tekeshiafacebook313', 'Six Mile Boys', '', 8),
(80, 8, 'West Warren', 'tiwanah.herman@yahoo.com', 'THfacebook313', 'West Warren', '', 9),
(81, 8, 'Tru Trap Gang', 'umikobranch@gmx.com', 'umikofacebook313', 'Tru Trap Gang', '', 10),
(82, 9, 'Schoolcraft Boys', 'uniquefinley@gmx.com', 'UFfacebook313', 'Schoolcraft Boys', '', 1),
(83, 9, 'True Warren Queens and EWK', 'unity.solomon@gmx.com', 'USfacebook313', 'True Warren Queens and EWK', '', 2),
(84, 9, 'BBC', 'uharding@gmx.com', 'ursulafacebook313', 'BBC', '', 3),
(85, 9, 'Knock Out Artists', 'valeria.woodward@gmx.com', 'valeriafacebook313', 'Knock Out Artists', '', 4),
(86, 9, 'So Icey Kings', 'waneesagay@gmx.com', 'WGfacebook313', 'So Icey Kings', '', 5),
(87, 9, 'EWK', 'wanetta.tillman@yahoo.com', 'WTfacebook313', 'EWK', '', 6),
(88, 9, 'Number Street Hustlers', 'wendihendricks@yahoo.com', 'WHfacebook313', 'Number Street Hustlers', '', 7),
(89, 9, 'BMG / YNS', 'yasmine.spence@gmx.com', 'yasminefacebook48205', 'BMG / YNS', '', 8),
(90, 9, 'West Warren Boys', 'yvonnedickson205@yahoo.com', 'YDfacebook313', 'West Warren Boys', '', 9),
(91, 9, 'Young Paid Niggas', 'zamani.rollins@gmx.com', 'zamanifacebook313', 'Young Paid Niggas', '', 10),
(92, 10, 'Young Blood Family', 'Zaneta.Galloway@gmail.com', 'Zgfacebook323', 'Young Blood Family', '', 1),
(93, 10, 'Young Fresh Misses', 'ZemoraF072989@gmail.com', 'ZFfacebook94', 'Young Fresh Misses', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `timeline`
--

CREATE TABLE IF NOT EXISTS `timeline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postingProfile` int(11) NOT NULL,
  `friend` int(11) DEFAULT NULL,
  `poster` text,
  `posterLink` text,
  `action` text,
  `message` text,
  `postTime_fb` text,
  `postTime` datetime DEFAULT NULL,
  `privacy` text,
  `likes` int(11) DEFAULT NULL,
  `likers` text,
  `postLink` text NOT NULL,
  `comments` int(11) DEFAULT NULL,
  `pictureLink` text,
  `picture` blob,
  `firstSeen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastSeen` datetime DEFAULT NULL,
  `tag` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `timeline_comments`
--

CREATE TABLE IF NOT EXISTS `timeline_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postingProfile` int(11) NOT NULL,
  `timelineID` int(11) NOT NULL,
  `name` text,
  `link` text,
  `message` text,
  `postTime_fb` text,
  `postTime` datetime DEFAULT NULL,
  `firstSeen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastSeen` datetime DEFAULT NULL,
  `tag` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `timeline_likes`
--

CREATE TABLE IF NOT EXISTS `timeline_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postingProfile` int(11) NOT NULL,
  `timelineID` int(11) NOT NULL,
  `name` text,
  `link` text,
  `firstSeen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastSeen` datetime DEFAULT NULL,
  `tag` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
