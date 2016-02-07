-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2014 at 11:41 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `technqga_registration_13_old`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `eventid` int(11) NOT NULL AUTO_INCREMENT,
  `ename` varchar(64) NOT NULL,
  `min` int(2) NOT NULL DEFAULT '1',
  `max` int(2) NOT NULL DEFAULT '1',
  `confirmation` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`eventid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eventid`, `ename`, `min`, `max`, `confirmation`) VALUES
(1, 'jahaaz', 2, 5, 1),
(2, 'wreckage', 2, 5, 1),
(3, 'NRC', 2, 5, 1),
(4, 'Hovermania', 2, 5, 1),
(5, 'Avion E', 2, 5, 1),
(6, 'Circuitrix', 2, 3, 1),
(7, 'Electronic Debugging', 1, 2, 1),
(8, 'Micromania', 1, 2, 0),
(9, 'coderuino', 1, 3, 0),
(10, 'Test your Wits', 1, 1, 1),
(11, 'kode-Kraft', 2, 3, 1),
(12, 'Algolympics', 1, 1, 1),
(13, 'formula-E', 2, 3, 1),
(14, 'Arm Rover', 2, 5, 1),
(15, 'Hydraulic rage', 1, 4, 0),
(16, 'rover', 1, 4, 1),
(17, 'mouse trap Racer', 1, 3, 1),
(18, 'robo Cricket', 2, 5, 1),
(19, 'robo Golf', 2, 4, 1),
(20, 'Thrust', 2, 3, 1),
(21, 'M-cad', 1, 2, 1),
(22, 'concreting concrete', 2, 4, 1),
(23, 'chemstorm', 1, 3, 1),
(24, 'Biomazes', 1, 1, 1),
(25, 'dark perception', 2, 3, 1),
(26, 'junkyard wars', 2, 5, 1),
(27, 'paper presentation', 1, 3, 1),
(28, 'I Engineer', 3, 5, 1),
(29, 'coil gun', 2, 3, 1),
(30, 'cryptex', 1, 1, 1),
(31, 'lumos', 1, 3, 1),
(32, 'witricity', 2, 3, 1),
(33, 'Aerial tramline', 2, 4, 1),
(34, 'ferro struct', 1, 3, 0),
(35, 'lost number', 2, 3, 1),
(36, 'Backyard science', 2, 3, 0),
(37, 'biomimicry', 1, 3, 1),
(38, 'Track the past', 2, 3, 1),
(39, 'Robo shooter', 2, 4, 1),
(40, 'Enterprise and expertise', 1, 1, 0),
(41, 'Hassle free city', 3, 4, 1),
(42, 'metal tracking', 2, 3, 1),
(43, 'Exergy', 2, 4, 1),
(44, 'Ignite', 2, 3, 0),
(45, 'testing', 1, 3, 0),
(46, 'Aakanksha', 1, 3, 1),
(47, 'Technozion Impact', 1, 1, 0),
(48, 'Zodiac', 1, 3, 1),
(49, 'TechFresh', 2, 2, 1),
(50, 'chemtransit', 2, 3, 1),
(51, 'Maglev', 2, 4, 1),
(52, 'smart eee livingblocks', 1, 3, 0),
(53, 'eureka', 1, 4, 0),
(54, 'fox hunt', 2, 4, 1),
(55, 'product launch', 1, 4, 0),
(56, 'Idea to impact', 1, 1, 0),
(57, 'Gamedome', 1, 1, 0),
(59, 'aquafrost', 2, 3, 1),
(60, 'chemswitch', 1, 4, 1),
(61, 'Illuminate', 1, 3, 1),
(62, 'electrocution', 2, 4, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
