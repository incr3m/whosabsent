-- phpMyAdmin SQL Dump
-- version 4.0.10.12
-- http://www.phpmyadmin.net
--
-- Host: 127.1.247.130:3306
-- Generation Time: Apr 19, 2016 at 04:45 PM
-- Server version: 5.5.45
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `amafras`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `idno` mediumint(9) NOT NULL AUTO_INCREMENT,
  `username` char(30) NOT NULL,
  `password` char(30) NOT NULL,
  `firstname` varchar(20) CHARACTER SET utf8 NOT NULL,
  `middlename` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `lastname` varchar(20) CHARACTER SET utf8 NOT NULL,
  `contact` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `displaypic` varchar(1000) DEFAULT NULL,
  `piclist` text,
  `adminright` enum('Yes','No') NOT NULL DEFAULT 'No',
  `usn` varchar(100) NOT NULL,
  `dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `roles` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `username` (`username`),
  KEY `username_2` (`username`),
  KEY `username_3` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`idno`, `username`, `password`, `firstname`, `middlename`, `lastname`, `contact`, `address`, `email`, `birthday`, `displaypic`, `piclist`, `adminright`, `usn`, `dateadded`, `roles`) VALUES
(25, 'admin', 'admin', 'admin', 'admin', 'admin', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'Yes', 'admin', '0000-00-00 00:00:00', 'ADMIN'),
(28, '13001482800', 'ama123', 'Ma. Marcella Elizza', 'D.', 'Famorca', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13001482800', '2016-04-19 09:07:01', 'STUDENT'),
(29, '13000420400', 'NetAd69', 'Carlos', 'Limboy', 'Salanguste', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000420400', '2016-04-19 09:56:50', 'ADMIN'),
(30, '13000346700', '12345', 'Jeffrey', 'R.', 'Dela Cerna', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000346700', '2016-04-19 10:23:10', 'STUDENT'),
(31, '13000330700', 'ama123', 'Jhon Reymond', 'T.', 'Khu', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000330700', '2016-04-19 15:09:51', 'STUDENT'),
(32, '13000354900', 'ama123', 'Christopher', 'H.', 'So', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000354900', '2016-04-19 15:13:50', 'STUDENT'),
(33, '13000349400', 'ama123', 'Jesus Ronn', 'G.', 'Olar', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000349400', '2016-04-19 15:16:50', 'STUDENT'),
(34, '13000418900', 'ama123', 'Francis Dave', 'D.', 'Espinosa', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000418900', '2016-04-19 15:18:18', 'STUDENT'),
(35, '13000793900', 'ama123', 'Ghester', 'S.', 'Palma', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000793900', '2016-04-19 15:19:18', 'STUDENT'),
(36, '13000379900', 'ama123', 'Arvin Nicolas', 'A.', 'Mayapis', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000379900', '2016-04-19 15:20:27', 'STUDENT'),
(37, '13001214100', 'ama123', 'Kristian', 'J.', 'Clemente', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13001214100', '2016-04-19 15:21:43', 'STUDENT'),
(38, '13000355700', 'ama123', 'Renz Aldrin', 'M.', 'Sumaculub', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000355700', '2016-04-19 15:23:12', 'STUDENT'),
(39, '13000355100', 'ama123', 'Ramiel', 'P.', 'Lumanlan', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000355100', '2016-04-19 15:24:45', 'STUDENT'),
(40, '13003004900', 'ama123', 'Ferdinand Carlos', 'B.', 'Racho', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13003004900', '2016-04-19 15:25:53', 'STUDENT'),
(41, '13000503600', 'ama123', 'Warren', 'C.', 'Rojas', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000503600', '2016-04-19 15:26:42', 'STUDENT'),
(42, '13000312000', 'ama123', 'Mark Timothy', 'B.', 'De Vera', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000312000', '2016-04-19 15:28:41', 'STUDENT'),
(43, '13000380300', 'ama123', 'Adrian', 'B.', 'Gabales', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000380300', '2016-04-19 15:29:31', 'STUDENT'),
(44, '13000378300', 'ama123', 'Earron Brylle', 'T.', 'Mercado', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000378300', '2016-04-19 15:31:16', 'STUDENT'),
(45, '13000348900', 'ama123', 'Jaypee', 'S.', 'Tan', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000348900', '2016-04-19 15:33:43', 'STUDENT'),
(46, '13000456499', 'ama123', 'Darwin', 'D.', 'Velano', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000456499', '2016-04-19 15:34:32', 'STUDENT'),
(47, '13000310800', 'ama123', 'Ricardo Luigi', 'L.', 'Alina', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000310800', '2016-04-19 15:35:35', 'STUDENT'),
(48, '13000356100', 'ama123', 'Jeanette', 'C.', 'Barte', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000356100', '2016-04-19 15:36:51', 'STUDENT'),
(49, '13000345900', 'ama123', 'Julius Patrick', 'E.', 'Libaton', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000345900', '2016-04-19 15:37:47', 'STUDENT'),
(50, '13000377600', 'ama123', 'Angelo', 'I.', 'Abalarao', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000377600', '2016-04-19 15:38:31', 'STUDENT'),
(51, '13000355400', 'ama123', 'Altaire Ray', 'V.', 'Bobis', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 'No', '13000355400', '2016-04-19 15:40:44', 'STUDENT');

-- --------------------------------------------------------

--
-- Table structure for table `accountphoto`
--

CREATE TABLE IF NOT EXISTS `accountphoto` (
  `idno` mediumint(9) NOT NULL AUTO_INCREMENT,
  `accountidno` mediumint(9) NOT NULL,
  `fileindex` mediumint(9) NOT NULL,
  `filename` varchar(1000) NOT NULL,
  `description` varchar(100) NOT NULL,
  `isprimary` varchar(30) NOT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `accountphoto`
--

INSERT INTO `accountphoto` (`idno`, `accountidno`, `fileindex`, `filename`, `description`, `isprimary`) VALUES
(3, 26, 2, '26_1.PNG', '', 'NO'),
(4, 26, 3, '26_2.PNG', '', 'YES'),
(5, 27, 1, '27_0.jpg', '', 'YES'),
(6, 27, 2, '27_1.jpg', '', 'NO'),
(7, 0, 1, '0_0.png', '', 'YES'),
(8, 28, 1, '28_0.png', '', 'NO'),
(9, 29, 1, '29_0.jpg', '', 'YES'),
(10, 28, 2, '28_1.jpg', '', 'YES'),
(11, 0, 2, '0_1.jpg', '', ''),
(12, 30, 1, '30_0.jpg', '', 'NO'),
(13, 30, 2, '30_1.jpg', '', 'YES'),
(14, 45, 1, '45_0.jpg', '', 'YES'),
(15, 25, 1, '25_0.jpg', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `enrolledstudent`
--

CREATE TABLE IF NOT EXISTS `enrolledstudent` (
  `idno` mediumint(9) NOT NULL AUTO_INCREMENT,
  `accountidno` mediumint(9) NOT NULL,
  `dateenrolled` datetime NOT NULL,
  `status` varchar(30) NOT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `enrolledstudent`
--

INSERT INTO `enrolledstudent` (`idno`, `accountidno`, `dateenrolled`, `status`) VALUES
(1, 26, '2016-04-21 00:00:00', 'ACTIVE'),
(2, 30, '2016-04-19 00:00:00', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE IF NOT EXISTS `section` (
  `idno` mediumint(9) NOT NULL AUTO_INCREMENT,
  `code` varchar(15) NOT NULL,
  `description` varchar(100) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`idno`, `code`, `description`, `level`) VALUES
(1, 'IT 1-1', 'IT 1-1', 1),
(2, 'IT 1-2', 'IT 1-2', 1),
(3, 'IT 1-3', 'IT 1-3', 1),
(4, 'IT 1-4', 'IT 1-4', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sectionsubject`
--

CREATE TABLE IF NOT EXISTS `sectionsubject` (
  `idno` mediumint(9) NOT NULL AUTO_INCREMENT,
  `sectionidno` mediumint(9) NOT NULL,
  `subjectidno` mediumint(9) NOT NULL,
  `dayofweek` smallint(6) NOT NULL,
  `starttime` datetime NOT NULL,
  `endtime` datetime NOT NULL,
  `active` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `sectionsubject`
--

INSERT INTO `sectionsubject` (`idno`, `sectionidno`, `subjectidno`, `dayofweek`, `starttime`, `endtime`, `active`) VALUES
(1, 1, 1, 1, '2016-04-10 02:00:00', '2016-04-10 03:00:00', b'1'),
(2, 1, 2, 1, '2016-04-10 03:00:00', '2016-04-10 04:00:00', b'1'),
(3, 2, 1, 3, '2016-04-12 00:11:00', '2016-04-13 02:11:00', b'1'),
(4, 2, 2, 4, '2016-04-12 02:12:00', '2016-04-12 04:14:00', b'1'),
(5, 2, 3, 2, '2016-04-12 05:23:00', '2016-04-12 12:38:00', b'1'),
(6, 2, 4, 3, '2016-04-12 05:18:00', '2016-04-12 08:25:00', b'1'),
(7, 2, 5, 4, '2016-04-12 09:25:00', '2016-04-12 10:40:00', b'1'),
(8, 2, 1, 3, '2016-04-12 00:11:00', '2016-04-13 02:11:00', b'1'),
(9, 2, 2, 4, '2016-04-12 02:12:00', '2016-04-12 04:14:00', b'1'),
(10, 2, 3, 2, '2016-04-12 05:23:00', '2016-04-12 12:38:00', b'1'),
(11, 2, 4, 3, '2016-04-12 05:18:00', '2016-04-12 08:25:00', b'1'),
(12, 2, 5, 4, '2016-04-12 09:25:00', '2016-04-12 10:40:00', b'1'),
(13, 3, 7, 4, '2016-04-12 00:11:00', '2016-04-13 02:11:00', b'1'),
(14, 3, 6, 6, '2016-04-12 02:12:00', '2016-04-12 04:14:00', b'1'),
(15, 4, 6, 2, '2016-04-12 05:23:00', '2016-04-12 12:38:00', b'1'),
(16, 3, 4, 3, '2016-04-12 05:18:00', '2016-04-12 08:25:00', b'1'),
(17, 3, 5, 4, '2016-04-12 09:25:00', '2016-04-12 10:40:00', b'1'),
(18, 4, 2, 4, '2016-04-12 00:11:00', '2016-04-13 02:11:00', b'1'),
(19, 2, 6, 6, '2016-04-12 02:12:00', '2016-04-12 04:14:00', b'1'),
(20, 4, 6, 2, '2016-04-12 05:23:00', '2016-04-12 12:38:00', b'1'),
(21, 4, 6, 3, '2016-04-12 05:18:00', '2016-04-12 08:25:00', b'1'),
(22, 4, 1, 4, '2016-04-12 09:25:00', '2016-04-12 10:40:00', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `studentschedule`
--

CREATE TABLE IF NOT EXISTS `studentschedule` (
  `idno` mediumint(9) NOT NULL AUTO_INCREMENT,
  `studentidno` mediumint(9) NOT NULL,
  `sectionsubjectidno` mediumint(9) NOT NULL,
  `status` varchar(30) DEFAULT NULL,
  `dateassigned` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `studentschedule`
--

INSERT INTO `studentschedule` (`idno`, `studentidno`, `sectionsubjectidno`, `status`, `dateassigned`) VALUES
(1, 1, 9, NULL, '2016-04-18 20:41:27');

-- --------------------------------------------------------

--
-- Table structure for table `subjectunit`
--

CREATE TABLE IF NOT EXISTS `subjectunit` (
  `idno` mediumint(9) NOT NULL AUTO_INCREMENT,
  `code` varchar(15) NOT NULL,
  `description` varchar(100) NOT NULL,
  `unit` int(11) NOT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `subjectunit`
--

INSERT INTO `subjectunit` (`idno`, `code`, `description`, `unit`) VALUES
(1, 'MATH 101', 'MATH 101', 3),
(2, 'ENG 101', 'ENG 101', 3),
(3, 'FIL 101', 'FIL 101', 3),
(4, 'COMP 101', 'COMP 101', 4),
(5, 'HIST 101', 'HIST 101', 3),
(6, 'ECON 101', 'ECON 101', 3),
(7, 'DOTE 101', 'DOTE 101', 3);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `idno` mediumint(9) NOT NULL AUTO_INCREMENT,
  `accountidno` mediumint(9) NOT NULL,
  `dateemployed` datetime NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `teacherschedule`
--

CREATE TABLE IF NOT EXISTS `teacherschedule` (
  `idno` mediumint(9) NOT NULL AUTO_INCREMENT,
  `teacheridno` mediumint(9) NOT NULL,
  `sectionsubjectidno` mediumint(9) NOT NULL,
  `status` varchar(30) DEFAULT NULL,
  `dateassigned` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `text_params`
--

CREATE TABLE IF NOT EXISTS `text_params` (
  `code` varchar(30) NOT NULL,
  `value` text,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `text_params`
--

INSERT INTO `text_params` (`code`, `value`) VALUES
('departments', 'MATH//ENGLISH//IT//ECONOMICS//HISTORY'),
('stdstatus', 'ACTIVE//INACTIVE');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
