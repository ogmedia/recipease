-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 25, 2012 at 10:19 PM
-- Server version: 5.5.22-0ubuntu1
-- PHP Version: 5.3.10-1ubuntu3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `recipes`
--

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE IF NOT EXISTS `recipes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumb` text NOT NULL,
  `origin` varchar(255) NOT NULL,
  `serves` varchar(255) NOT NULL,
  `tags` text NOT NULL,
  `parent_id` int(10) unsigned NOT NULL,
  `time` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `user_id`, `title`, `thumb`, `origin`, `serves`, `tags`, `parent_id`, `time`, `created`) VALUES
(2, 0, 'pesto pork chops with garlic bread and mixed veg', '', 'http://www.pinkpistachio.com/spinach-pesto-pork-chops/', '', '', 0, '', '2012-05-10 20:44:32'),
(7, 0, 'corned beef and cabbage', '', '', '', '', 0, '', '2012-05-10 23:28:31'),
(9, 0, '', '', '', '', '', 2, '', '2012-05-13 18:38:14'),
(10, 0, '', '', '', '', '', 9, '', '2012-05-13 19:33:41'),
(11, 0, '', '', '', '', '', 9, '', '2012-05-19 19:49:07'),
(12, 0, '', '', '', '', '', 2, '', '2012-05-20 13:05:59'),
(13, 0, '', '', '', '', '', 7, '', '2012-05-20 14:05:51'),
(14, 0, '', '', '', '', '', 13, '', '2012-05-20 16:53:39');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
