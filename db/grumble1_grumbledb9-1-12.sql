-- phpMyAdmin SQL Dump
-- version 3.4.10.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 01, 2012 at 02:47 PM
-- Server version: 5.1.65
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `grumble1_grumbledb`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories_grumble`
--

DROP TABLE IF EXISTS `categories_grumble`;
CREATE TABLE IF NOT EXISTS `categories_grumble` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  `category_url` varchar(50) NOT NULL,
  `thread_number` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `categories_grumble`
--

INSERT INTO `categories_grumble` (`category_id`, `category_name`, `category_url`, `thread_number`) VALUES
(1, 'General', 'general', 10),
(2, 'Social Media', 'social-media', 3),
(3, 'Internet', 'internet', 3),
(4, 'Health', 'health', 2),
(5, 'Sports', 'sports', 0),
(6, 'Government', 'government', 1),
(7, 'Education', 'education', 1),
(8, 'Economy', 'economy', 0),
(9, 'Companies', 'companies', 3),
(10, 'Random', 'random', 0),
(11, 'Humor', 'humor', 0);

-- --------------------------------------------------------

--
-- Table structure for table `coming_soon`
--

DROP TABLE IF EXISTS `coming_soon`;
CREATE TABLE IF NOT EXISTS `coming_soon` (
  `soon_id` int(11) NOT NULL AUTO_INCREMENT,
  `soon_name` varchar(50) NOT NULL,
  `soon_email` varchar(100) NOT NULL,
  PRIMARY KEY (`soon_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `coming_soon`
--

INSERT INTO `coming_soon` (`soon_id`, `soon_name`, `soon_email`) VALUES
(3, 'Becca', 'snoops713@hotmail.com'),
(2, 'Jon Tetzlaff', 'tetz2442@gmail.com'),
(7, 'glenn tetzlaff', 'jaci.tetzlaff@gmail.com'),
(9, 'Lance Aeby', 'lanceaeby@gmail.com'),
(10, 'Jaci Tetzlaff', 'jtetzlaff@tds.net'),
(11, 'Paul Macek', 'paulmacek@gmail.com'),
(12, 'Cameron', 'cameron.heikkinen@gmail.com'),
(13, 'Spencer', 'soberstadt@gmail.com'),
(15, '~!Donovan', 'UltimateDonovan@gmail.com'),
(16, 'Samantha Tetzlaff', 'tetz0045@gmail.com'),
(17, 'Stephanie', 'smtetzlaff@gmail.com'),
(18, 'Debra', 'djocurry@gmail.com'),
(19, 'Steve', 'stevenjmckinley@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `contact_grumble`
--

DROP TABLE IF EXISTS `contact_grumble`;
CREATE TABLE IF NOT EXISTS `contact_grumble` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_user_id` int(11) NOT NULL DEFAULT '0',
  `contact_email` varchar(255) NOT NULL,
  `contact_message_type` varchar(25) NOT NULL,
  `contact_message` varchar(255) NOT NULL,
  `contact_name` varchar(50) NOT NULL,
  `contact_create` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `contact_resolved` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`contact_id`),
  KEY `contact_user_id` (`contact_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cookies_grumble`
--

DROP TABLE IF EXISTS `cookies_grumble`;
CREATE TABLE IF NOT EXISTS `cookies_grumble` (
  `cookie_id` int(11) NOT NULL AUTO_INCREMENT,
  `cookie_text` varchar(150) NOT NULL,
  `cookie_expire` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`cookie_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `cookies_grumble`
--

INSERT INTO `cookies_grumble` (`cookie_id`, `cookie_text`, `cookie_expire`, `user_id`) VALUES
(2, '$1$IvSMcq4V$HdJAbTles73PwhpdPQS1b/', '2012-09-08 14:44:12', 3),
(3, '$1$QhBIqMTj$h7arQ0vyMSHK2uesdQQ.g.', '2012-09-02 21:07:45', 12),
(4, '$1$7sCQUq0X$ebVBVvuwAy/ZZ74BKksT21', '2012-09-02 23:49:34', 7);

-- --------------------------------------------------------

--
-- Table structure for table `help_callout_text`
--

DROP TABLE IF EXISTS `help_callout_text`;
CREATE TABLE IF NOT EXISTS `help_callout_text` (
  `help_callout_id` int(11) NOT NULL AUTO_INCREMENT,
  `help_callout_title` varchar(35) NOT NULL,
  `help_callout_text` varchar(255) NOT NULL,
  PRIMARY KEY (`help_callout_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `help_callout_text`
--

INSERT INTO `help_callout_text` (`help_callout_id`, `help_callout_title`, `help_callout_text`) VALUES
(1, 'Creating Meaningful Grumble Names', 'To create a Grumble that will be found by the people of Grumble and the internet, you should have a descriptive title.<br/><br/>\nFor example: Instead of "Charter", you could put "Charter Service is Poor".'),
(2, 'Creating Thorough Descriptions', 'Having a thorough decsription for a Grumble is very important. When people search the internet, they will be able to see the description you have provided for this thread. Be as descriptive as possible to achieve better results.'),
(3, 'Choosing a Unique Username', 'Usernames on Grumble work just like they do most other places, such as Twitter. You just have to make sure your username is unique.\n<br/><br/>Ex. johnDoe, johnDoe13');

-- --------------------------------------------------------

--
-- Table structure for table `replies_grumble`
--

DROP TABLE IF EXISTS `replies_grumble`;
CREATE TABLE IF NOT EXISTS `replies_grumble` (
  `reply_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_id` int(11) NOT NULL,
  `reply_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reply_user` int(11) NOT NULL,
  `reply_text` varchar(180) NOT NULL,
  `reply_spam` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`reply_id`),
  KEY `status_id` (`status_id`,`reply_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `replies_grumble`
--

INSERT INTO `replies_grumble` (`reply_id`, `status_id`, `reply_date`, `reply_user`, `reply_text`, `reply_spam`) VALUES
(4, 19, '2012-08-31 16:18:15', 3, 'new reply', 0),
(5, 19, '2012-08-31 16:26:19', 3, 'new reply', 0),
(6, 19, '2012-08-31 16:26:27', 3, 'one more', 0),
(7, 19, '2012-08-31 16:27:46', 3, 'one more', 0),
(8, 17, '2012-09-01 12:49:12', 7, 'nope.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings_user_grumble`
--

DROP TABLE IF EXISTS `settings_user_grumble`;
CREATE TABLE IF NOT EXISTS `settings_user_grumble` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `settings_email_thread` int(1) NOT NULL DEFAULT '1',
  `settings_email_comment` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`settings_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `settings_user_grumble`
--

INSERT INTO `settings_user_grumble` (`settings_id`, `user_id`, `settings_email_thread`, `settings_email_comment`) VALUES
(1, 8, 1, 1),
(2, 9, 1, 1),
(3, 10, 1, 1),
(4, 11, 1, 1),
(5, 3, 1, 1),
(6, 6, 1, 1),
(7, 12, 1, 1),
(8, 13, 1, 1),
(9, 14, 0, 1),
(10, 15, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `status_grumble`
--

DROP TABLE IF EXISTS `status_grumble`;
CREATE TABLE IF NOT EXISTS `status_grumble` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_category_id` int(11) NOT NULL DEFAULT '1',
  `status_text` varchar(400) NOT NULL,
  `date_submitted` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_spam` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`status_id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`sub_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `status_grumble`
--

INSERT INTO `status_grumble` (`status_id`, `sub_category_id`, `status_text`, `date_submitted`, `user_id`, `status_spam`) VALUES
(7, 2, 'more', '2012-08-30 11:49:07', 12, 0),
(12, 4, 'new comment', '2012-08-31 09:56:58', 3, 0),
(13, 4, 'Another', '2012-08-31 09:57:18', 3, 0),
(17, 4, 'New comment from firefox', '2012-08-31 10:11:28', 3, 0),
(19, 4, 'Here we go', '2012-08-31 10:16:32', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sub_category_grumble`
--

DROP TABLE IF EXISTS `sub_category_grumble`;
CREATE TABLE IF NOT EXISTS `sub_category_grumble` (
  `sub_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `sub_category_name` varchar(40) NOT NULL,
  `sub_category_description` varchar(400) NOT NULL,
  `sub_category_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(11) NOT NULL,
  `sub_category_url` varchar(60) NOT NULL,
  `grumble_number` int(11) NOT NULL DEFAULT '0',
  `sub_category_spam` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sub_category_id`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sub_category_grumble`
--

INSERT INTO `sub_category_grumble` (`sub_category_id`, `category_id`, `sub_category_name`, `sub_category_description`, `sub_category_created`, `user_id`, `sub_category_url`, `grumble_number`, `sub_category_spam`) VALUES
(1, 7, 'New thread', 'new thread description', '2012-08-30 08:45:23', 3, 'new-thread', 0, 0),
(2, 9, 'Another one', 'here is another', '2012-08-30 08:51:34', 3, 'another-one', 1, 0),
(3, 4, 'One more', 'another one', '2012-08-30 10:56:09', 3, 'one-more', 0, 0),
(4, 9, 'New one', 'dfgadgdg', '2012-08-31 09:44:30', 3, 'new-one', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `temp_password_grumble`
--

DROP TABLE IF EXISTS `temp_password_grumble`;
CREATE TABLE IF NOT EXISTS `temp_password_grumble` (
  `temp_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) NOT NULL,
  `temp_password` varchar(50) NOT NULL,
  `temp_create` datetime NOT NULL,
  PRIMARY KEY (`temp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_grumble`
--

DROP TABLE IF EXISTS `users_grumble`;
CREATE TABLE IF NOT EXISTS `users_grumble` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `access_lvl` int(1) NOT NULL DEFAULT '1',
  `username` varchar(50) NOT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `user_lastname` varchar(50) NOT NULL,
  `user_create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_password` varchar(50) NOT NULL,
  `user_salt` char(21) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_timezone` varchar(50) NOT NULL DEFAULT 'America/Chicago',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `users_grumble`
--

INSERT INTO `users_grumble` (`user_id`, `access_lvl`, `username`, `user_firstname`, `user_lastname`, `user_create_date`, `user_password`, `user_salt`, `user_email`, `user_timezone`) VALUES
(3, 3, 'tetz2442', 'Jon', 'Tetzlaff', '2012-08-01 21:52:02', 'soedZRZIqWrGsso9qv7cKU.jVRkwiIHpD', 'so9qv7cKU.jVRkwiIHpD', 'tetz24@hotmail.com', 'Europe/Amsterdam'''),
(6, 1, 'beccaschmidt', 'Becca', 'Schmidt', '2012-08-01 21:52:02', 'HgDkrdITbjw7AHgmpGJqgCsy477ge1Atvp', 'HgmpGJqgCsy477ge1Atvp', 'beccaschmidt@outlook.com', 'America/Chicago'),
(7, 1, 'soberstadt', 'Spencer', 'Oberstadt', '2012-08-08 11:50:49', 'T7qeAicvSmbZkT77PaVrMWzK1ZSf/uQ/EJ', 'T77PaVrMWzK1ZSf/uQ/EJ', 'soberstadt@gmail.com', 'America/Chicago'),
(8, 1, 'BoobTube', 'Boob', 'Tube', '2012-08-12 18:12:21', 'lDGpzgqtO4FyYlDhckDo74iBUhg58dGTSW', 'lDhckDo74iBUhg58dGTSW', 'boobtube@gmail.com', 'America/Chicago'),
(9, 1, 'DenzelWashington', 'WILL MOFUKIN\\''', 'RAY', '2012-08-22 09:52:34', '6n5YwgmgG32Lo6nTrrLSWC2YEJGj71cYwY', '6nTrrLSWC2YEJGj71cYwY', 'wray167@uwsp.edu', 'America/Chicago'),
(10, 1, 'papajoe', 'Joseph', 'Weyenberg', '2012-08-23 09:20:57', 'WygYM7uFuG0z6Wy.On3P4s4y58sz.Ub6Mb', 'Wy.On3P4s4y58sz.Ub6Mb', 'joeyweyenberg@yahoo.com', 'America/Chicago'),
(11, 1, 'SliceOfLife', 'Dexter', 'Morgan', '2012-08-23 21:01:21', 'WvzG.hN4DpiLoWvCqYToCxm8if5RteXysW', 'WvCqYToCxm8if5RteXysW', 'laeby559@uwsp.edu', 'America/Chicago'),
(12, 1, 'steveysteverson', 'Stevey', 'Steverson', '2012-08-26 21:07:08', 'soedZRZIqWrGsso9qv7cKU.jVRkwiIHpD', 'so9qv7cKU.jVRkwiIHpD', 'tetz2442@gmail.com', 'America/Chicago'),
(13, 1, 'macek', 'Paul', 'Macek', '2012-08-28 10:18:06', '84ZvJ8aNj7tqI84W5ZdAmvNr3v6zANZmNP', '84W5ZdAmvNr3v6zANZmNP', 'paulmacek@gmail.com', 'America/Chicago'),
(14, 1, 'jonnyboy', 'jonny', 'boy', '2012-08-28 16:05:12', 'Vqv4z0hf3aiCgVqIzvEUUzTcqjSeATTdsU', 'VqIzvEUUzTcqjSeATTdsU', 'tetz32@hotmail.com', 'America/Chicago'),
(15, 1, 'userguy', 'user', 'guy', '2012-08-28 16:08:12', 'JFasfikhOsAzcJFhmFr/aGqHV/DQv.48I9', 'JFhmFr/aGqHV/DQv.48I9', 'hola@hola.com', 'America/Chicago');

-- --------------------------------------------------------

--
-- Table structure for table `user_likes_grumble`
--

DROP TABLE IF EXISTS `user_likes_grumble`;
CREATE TABLE IF NOT EXISTS `user_likes_grumble` (
  `user_like_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`user_like_id`),
  KEY `user_id` (`user_id`,`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_likes_grumble`
--

INSERT INTO `user_likes_grumble` (`user_like_id`, `user_id`, `status_id`) VALUES
(4, 3, 19),
(3, 7, 17);

-- --------------------------------------------------------

--
-- Table structure for table `votes_up_grumble`
--

DROP TABLE IF EXISTS `votes_up_grumble`;
CREATE TABLE IF NOT EXISTS `votes_up_grumble` (
  `votes_up_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_id` int(11) NOT NULL,
  `votes_up_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`votes_up_id`),
  KEY `user_id` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
