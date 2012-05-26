-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 25, 2012 at 11:00 PM
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
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `directions`
--

CREATE TABLE IF NOT EXISTS `directions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recipe_id` int(10) unsigned NOT NULL,
  `direction` text NOT NULL,
  `parent_id` int(10) unsigned NOT NULL,
  `sort` mediumint(9) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `recipe_id` (`recipe_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `directions`
--

INSERT INTO `directions` (`id`, `recipe_id`, `direction`, `parent_id`, `sort`, `created`) VALUES
(1, 2, 'slice the pork chops down the center, and stuff with pesto.', 0, 0, '0000-00-00 00:00:00'),
(2, 2, 'bake on a cookie sheet at 425 for 25-30 min.', 0, 1, '0000-00-00 00:00:00'),
(3, 2, 'slice 4-5 tblsp butter in a flat bottomed glass or ceramic bakeware dish. sprinkle with garlic powder and other dried italian herb mixtures to your liking. bake for 5 minutes. Pull dish out of the oven and on a safe surface. dip each piece of bread in, face down and evenly. shred fresh parmesan on top. place on a baking dish and bake during the last 5 minutes of pork chops cooking.', 0, 2, '0000-00-00 00:00:00'),
(4, 2, 'sauté onions, chives and garlic in 2 tbsp butter until onions start to turn clear. Add spinach. Cook all the way down before adding halved tomatoes and artichokes. Stir as you cook until tomatoes seem soft, but still a little film (not falling apart). Face the tomatoes down after turning the stove off so they continue browning just a little.', 0, 3, '0000-00-00 00:00:00'),
(5, 2, 'When ready, pull pork chops and bread out of the oven. Garnish chops with added pesto and balsamic vinegar.', 0, 4, '0000-00-00 00:00:00'),
(6, 0, 'Do this', 0, 0, '0000-00-00 00:00:00'),
(7, 0, 'Then do this', 0, 0, '0000-00-00 00:00:00'),
(8, 0, 'Do this', 0, 0, '0000-00-00 00:00:00'),
(9, 0, 'Then do this', 0, 0, '0000-00-00 00:00:00'),
(10, 0, 'Do this', 0, 0, '0000-00-00 00:00:00'),
(11, 0, 'Then do this', 0, 0, '0000-00-00 00:00:00'),
(12, 0, 'Do this', 0, 0, '0000-00-00 00:00:00'),
(13, 0, 'Then do this', 0, 0, '0000-00-00 00:00:00'),
(14, 0, 'Do this', 0, 0, '0000-00-00 00:00:00'),
(15, 0, 'Then do this', 0, 0, '0000-00-00 00:00:00'),
(16, 6, 'sdfsd', 0, 0, '2012-05-10 23:26:45'),
(17, 7, 'cube beef into 3" pieces.', 0, 0, '2012-05-10 23:28:31'),
(18, 7, 'quarter cabbage and slice each section into 4 parts. Add as much as will fit into your crock pot.', 0, 0, '2012-05-10 23:28:31'),
(19, 7, 'pour beer over beef and cabbage.', 0, 0, '2012-05-10 23:28:32'),
(20, 7, 'cook in crock pot for 6 hours. every two hours, stir and add more cabbage as it cooks down.\n', 0, 0, '2012-05-10 23:28:32'),
(21, 7, 'serves 4', 0, 0, '2012-05-10 23:28:32');

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE IF NOT EXISTS `ingredients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recipe_id` int(10) unsigned NOT NULL,
  `amount` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `parent_id` int(10) unsigned NOT NULL,
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `recipe_id` (`recipe_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `recipe_id`, `amount`, `unit`, `item`, `note`, `parent_id`, `sort`, `created`) VALUES
(1, 2, '', '', 'jarred pesto', '', 0, 0, '2012-05-10 20:49:30'),
(2, 2, '2', '', 'boneless pork chops', '', 0, 0, '2012-05-10 20:49:30'),
(3, 2, '3', 'pieces', 'bread', '', 0, 0, '2012-05-10 20:49:30'),
(4, 2, '', '', 'fresh parmesan cheese, grated', '', 0, 0, '2012-05-10 20:49:30'),
(5, 2, '1/2', 'bag', 'frozen artichokes', '', 0, 0, '2012-05-10 20:49:30'),
(6, 2, '2', 'tsp', 'fresh garlic', '', 0, 0, '2012-05-10 21:00:16'),
(7, 2, '1/3', 'cup', 'chopped onions', '', 0, 0, '2012-05-10 21:00:16'),
(8, 2, '1', '', 'chopped chive ', '(the green part only)', 0, 0, '2012-05-10 21:00:16'),
(9, 2, '4', 'halved', 'cocktail tomatoes', '(smaller than clementines, bigger than cherry tomatoes)', 0, 0, '2012-05-10 21:00:16'),
(10, 2, '5-6', 'handfuls', 'baby spinach', '', 0, 0, '2012-05-10 21:00:16'),
(11, 2, '', '', 'butter', '', 0, 0, '2012-05-10 21:00:16'),
(12, 2, '', '', 'balsamic vinegar', '', 0, 0, '2012-05-10 21:00:16'),
(13, 2, '', '', 'powdered garlic', '', 0, 0, '2012-05-10 21:00:16'),
(14, 2, '', '', 'dried italian herbs', '(optional)', 0, 0, '2012-05-10 21:00:16'),
(15, 3, '1', 'c', 'ASASF', '', 0, 0, '0000-00-00 00:00:00'),
(16, 3, '2', 'd', 'FDFSDFSDF', '', 0, 0, '0000-00-00 00:00:00'),
(17, 3, '1/3', 'me', 'SDFSDFSDF', '', 0, 0, '0000-00-00 00:00:00'),
(18, 4, '1', 'c', 'ASASF', '', 0, 0, '0000-00-00 00:00:00'),
(19, 4, '2', 'd', 'FDFSDFSDF', '', 0, 0, '0000-00-00 00:00:00'),
(20, 4, '1/3', 'me', 'SDFSDFSDF', '', 0, 0, '0000-00-00 00:00:00'),
(21, 4, '1', 'c', 'ASASF', '', 0, 0, '0000-00-00 00:00:00'),
(22, 4, '2', 'd', 'FDFSDFSDF', '', 0, 0, '0000-00-00 00:00:00'),
(23, 4, '1/3', 'me', 'SDFSDFSDF', '', 0, 0, '0000-00-00 00:00:00'),
(24, 5, '1', 'c', 'ASASF', '', 0, 0, '0000-00-00 00:00:00'),
(25, 5, '2', 'd', 'FDFSDFSDF', '', 0, 0, '0000-00-00 00:00:00'),
(26, 5, '1/3', 'me', 'SDFSDFSDF', '', 0, 0, '0000-00-00 00:00:00'),
(27, 5, '1', 'c', 'ASASF', '', 0, 0, '0000-00-00 00:00:00'),
(28, 5, '2', 'd', 'FDFSDFSDF', '', 0, 0, '0000-00-00 00:00:00'),
(29, 5, '1/3', 'me', 'SDFSDFSDF', '', 0, 0, '0000-00-00 00:00:00'),
(30, 5, '1', 'c', 'ASASF', '', 0, 0, '0000-00-00 00:00:00'),
(31, 5, '2', 'd', 'FDFSDFSDF', '', 0, 0, '0000-00-00 00:00:00'),
(32, 5, '1/3', 'me', 'SDFSDFSDF', '', 0, 0, '0000-00-00 00:00:00'),
(33, 6, '2', '34234', '234234', '', 0, 0, '2012-05-10 23:26:45'),
(34, 6, '1', 'ts', 'tsts', '', 0, 0, '2012-05-10 23:26:45'),
(35, 7, '1 1/2', 'cans', 'murphy''s stout', '', 0, 0, '2012-05-10 23:28:31'),
(36, 7, '1.3 ', 'lbs', 'corned beef', '', 0, 0, '2012-05-10 23:28:31'),
(37, 7, '1', 'head', 'cabbage', '', 0, 0, '2012-05-10 23:28:31'),
(38, 9, '1', 'jar', 'pesto', '', 1, 0, '2012-05-13 18:38:14'),
(39, 10, '1', 'stick', 'butter', '', 11, 0, '2012-05-13 19:33:41'),
(40, 11, '1', 'stick', 'butter', '', 11, 0, '2012-05-19 19:49:07'),
(41, 12, '1', '', 'jarred pesto', '', 1, 0, '2012-05-20 13:06:00'),
(42, 13, '2', 'cans', 'murphy''s stout', '', 35, 0, '2012-05-20 14:05:51'),
(43, 14, '3', 'cans', 'murphy''s stout', '', 42, 0, '2012-05-20 16:53:39');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recipe_id` int(10) unsigned NOT NULL,
  `image` text NOT NULL,
  `created` datetime NOT NULL,
  `sort` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `recipe_id` (`recipe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `recipe_id` int(10) unsigned NOT NULL,
  `rating` varchar(5) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`recipe_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `recipe_id`, `rating`, `created`) VALUES
(1, 0, 10, '3', '2012-05-25 20:48:22'),
(2, 0, 10, '4', '2012-05-25 20:51:01'),
(3, 0, 10, '2.5', '2012-05-25 20:51:03'),
(4, 0, 10, '4.5', '2012-05-25 20:51:05'),
(5, 0, 10, '2', '2012-05-25 20:55:13'),
(6, 0, 9, '4', '2012-05-25 21:01:25'),
(7, 0, 9, '5', '2012-05-25 21:01:30'),
(8, 0, 9, '0.5', '2012-05-25 21:01:34'),
(9, 0, 9, '1', '2012-05-25 21:01:35'),
(10, 0, 9, '0.5', '2012-05-25 21:01:36'),
(11, 0, 9, '1', '2012-05-25 21:01:37'),
(12, 0, 9, '1', '2012-05-25 21:01:37'),
(13, 0, 9, '0.5', '2012-05-25 21:01:38'),
(14, 0, 10, '5', '2012-05-25 21:30:24'),
(15, 0, 14, '3', '2012-05-25 21:34:40'),
(16, 0, 14, '5', '2012-05-25 21:36:36'),
(17, 0, 14, '2', '2012-05-25 21:36:46'),
(18, 0, 14, '2', '2012-05-25 21:37:38'),
(19, 0, 14, '1', '2012-05-25 21:39:30'),
(20, 0, 14, '1', '2012-05-25 21:40:05'),
(21, 0, 14, '0.5', '2012-05-25 21:40:30'),
(22, 0, 14, '3.5', '2012-05-25 21:41:23'),
(23, 0, 13, '4.5', '2012-05-25 21:41:41'),
(24, 0, 11, '0.5', '2012-05-25 21:51:44'),
(25, 0, 11, '5', '2012-05-25 21:52:25'),
(26, 0, 11, '5', '2012-05-25 21:53:04'),
(27, 0, 10, '1.5', '2012-05-25 21:57:23');

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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first` varchar(255) NOT NULL,
  `last` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_autologin`
--

CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
