-- phpMyAdmin SQL Dump
-- version 3.4.10.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 18, 2012 at 07:48 AM
-- Server version: 5.1.63
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
  `thread_number` int(11) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `categories_grumble`
--

INSERT INTO `categories_grumble` (`category_id`, `category_name`, `category_url`, `thread_number`) VALUES
(1, 'General', 'general', 4),
(2, 'Social Media', 'social-media', 1),
(3, 'Internet', 'internet', 2),
(4, 'Health', 'health', 1),
(5, 'Politics', 'politics', 0),
(6, 'Government', 'government', 1),
(7, 'Education', 'education', 0),
(8, 'Economy', 'economy', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

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
(17, 'Stephanie', 'smtetzlaff@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `comments_grumble`
--

DROP TABLE IF EXISTS `comments_grumble`;
CREATE TABLE IF NOT EXISTS `comments_grumble` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_id` int(11) NOT NULL,
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_user` int(11) NOT NULL,
  `comment_text` varchar(180) NOT NULL,
  `comment_spam` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `status_id` (`status_id`,`comment_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `comments_grumble`
--

INSERT INTO `comments_grumble` (`comment_id`, `status_id`, `comment_date`, `comment_user`, `comment_text`, `comment_spam`) VALUES
(2, 2, '2012-08-13 19:29:02', 3, 'New comment', 0),
(3, 3, '2012-08-14 07:36:45', 7, 'Grumble...', 0),
(4, 3, '2012-08-14 07:39:42', 8, 'that\\''s not how you grumble... THIS IS HOW YOU GRUMBLE.', 0),
(5, 3, '2012-08-14 17:25:26', 6, 'y\\''all are bad at grumbling!', 0),
(6, 3, '2012-08-14 17:25:55', 6, 'Jon fix that error! it won\\''t let me write y\\''all normal', 0),
(7, 2, '2012-08-14 17:41:34', 3, 'ya\\''ll', 0),
(8, 2, '2012-08-14 17:56:39', 3, 'ya\\''ll', 0),
(9, 2, '2012-08-14 17:59:03', 3, 'ya\\''ll', 0),
(10, 2, '2012-08-14 17:59:31', 3, 'you\\''ve', 0),
(11, 2, '2012-08-14 18:06:44', 3, 'new comment', 0),
(12, 2, '2012-08-14 18:07:58', 3, 'another new one', 0),
(13, 2, '2012-08-14 18:08:59', 3, 'hello', 0),
(14, 2, '2012-08-14 18:10:31', 3, 'lol', 0),
(15, 2, '2012-08-14 18:11:57', 3, 'poop', 0),
(16, 2, '2012-08-14 18:13:15', 3, 'another!', 0),
(17, 4, '2012-08-14 18:13:36', 3, 'new one', 0),
(18, 2, '2012-08-16 16:06:54', 3, 'last one', 0),
(19, 8, '2012-08-17 10:21:02', 8, 'TRELLOLOLOLOLOL', 0),
(20, 3, '2012-08-17 10:22:52', 8, 'y\\''all y\\''all y\\''all y\\''all y\\''all', 0);

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
  PRIMARY KEY (`contact_id`),
  KEY `contact_user_id` (`contact_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `contact_grumble`
--

INSERT INTO `contact_grumble` (`contact_id`, `contact_user_id`, `contact_email`, `contact_message_type`, `contact_message`, `contact_name`, `contact_create`) VALUES
(1, 7, 'soberstadt@gmail.com', 'Report Bug', 'Hi John!!!!', 'Spencer', '2012-08-14 07:34:58');

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
(1, 'Creating Meaningful Thread Names', 'To create a thread that will be found by the people of Grumble and the internet, you should have a descriptive title.<br/><br/>\nFor example: Instead of "Charter", you could put "Charter Service is Poor".'),
(2, 'Creating Thorough Descriptions', 'Having a thorough decsription for a thread is very important. When people search the internet, they will be able to see the description you have provided for this thread. Be as descriptive as possible to achieve better results.'),
(3, 'Choosing a Unique Username', 'Usernames on Grumble work just like they do most other places, such as Twitter. You just have to make sure your username is unique.\n<br/><br/>Ex. johnDoe, johnDoe13');

-- --------------------------------------------------------

--
-- Table structure for table `settings_user_grumble`
--

DROP TABLE IF EXISTS `settings_user_grumble`;
CREATE TABLE IF NOT EXISTS `settings_user_grumble` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`settings_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings_user_grumble`
--

INSERT INTO `settings_user_grumble` (`settings_id`, `user_id`) VALUES
(1, 8);

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
  `votes_up_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_spam` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`status_id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`sub_category_id`),
  KEY `votes_up_id` (`votes_up_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `status_grumble`
--

INSERT INTO `status_grumble` (`status_id`, `sub_category_id`, `status_text`, `date_submitted`, `votes_up_id`, `user_id`, `status_spam`) VALUES
(2, 1, 'New thread', '2012-08-13 16:09:36', 2, 3, 0),
(3, 3, 'Grumble, grumble, grumble...', '2012-08-14 07:36:30', 3, 7, 0),
(4, 4, 'Rock that boddayyy', '2012-08-14 16:32:33', 4, 3, 0),
(5, 1, 'http://www.jontetzlaff.com', '2012-08-14 21:34:54', 5, 3, 0),
(6, 1, 'URL in text http://www.jontetzlaff.com here', '2012-08-14 21:44:54', 6, 3, 0),
(7, 1, 'Long URL http://stackoverflow.com/questions/1199352/smart-way-to-shorten-long-strings-with-javascript', '2012-08-15 15:56:18', 7, 3, 0),
(8, 1, 'https://trello.com/board/grumble/50296c465c2096c21d0a550a dfsdfsdfsdf dfsdfa sdaf', '2012-08-15 17:06:30', 8, 3, 0),
(9, 1, 'Another', '2012-08-16 16:04:41', 9, 3, 0),
(10, 1, 'Doing some tests', '2012-08-16 16:04:48', 10, 3, 0),
(11, 1, 'More tests', '2012-08-16 16:05:06', 11, 3, 0),
(12, 1, '2 more', '2012-08-16 16:05:18', 12, 3, 0),
(13, 1, '1 more', '2012-08-16 16:05:24', 13, 3, 0),
(14, 1, 'Last one', '2012-08-16 16:05:34', 14, 3, 0),
(15, 1, 'jhkjgjkjkhj', '2012-08-17 11:28:56', 15, 3, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `sub_category_grumble`
--

INSERT INTO `sub_category_grumble` (`sub_category_id`, `category_id`, `sub_category_name`, `sub_category_description`, `sub_category_created`, `user_id`, `sub_category_url`, `grumble_number`, `sub_category_spam`) VALUES
(1, 1, 'Thread in General', 'asadf', '2012-08-10 13:35:58', 3, 'thread-in-general', 13, 0),
(2, 2, 'Grumble grumble grumble...', 'Anger.  So much anger.', '2012-08-12 18:13:02', 8, 'grumble', 0, 0),
(3, 4, 'Grumble Sucks!', 'No description needed.', '2012-08-14 07:35:43', 7, 'grumble-sucks', 1, 0),
(4, 6, 'EVERYBODY', 'ROCK YOUR BODY RIGHT.  BACKSTREET\\''S BACK; ALRIGHT. ^_^', '2012-08-14 07:42:31', 8, 'everybody', 1, 0),
(5, 3, 'Sharing this beast', 'New one', '2012-08-14 15:50:28', 3, 'sharing-this-beast', 0, 0),
(6, 3, 'Sharing this beast', 'New one', '2012-08-14 16:00:10', 3, 'sharing-this-beast', 0, 0),
(7, 1, 'Thread testing URLs', 'http://jontetzlaff.com/cats/another/another/another testing out this URL', '2012-08-15 17:10:37', 3, 'thread-testing-urls', 0, 0),
(8, 1, 'Here is test', 'https://www.facebook.com/groups/Intervestor/459685614051925/?notif_t=group_comment_reply here is another sadfsadfasdfasdff dasfasdfasd asdf asd  asdf asdf sdfasd fasdf asdf asdf asdf asdf sadf sdaf sdaf sdf sdaf sdf sdf sdf sdfsdf asdf asdf sadf sdf sdf sadf asdf sdfsdfasdf asdf sdf asdf asdfsdfsdfsdafsd df ds d s', '2012-08-15 20:01:09', 3, 'here-test', 0, 0),
(9, 1, 'Thread test', 'https://www.facebook.com/groups/Intervestor/459685614051925/?notif_t=group_comment_reply here is another sadfsadfasdfasdff dasfasdfasd asdf asd asdf asdf sdfasd fasdf asdf asdf asdf asdf sadf sdaf sdaf sdf sdaf sdf sdf sdf sdfsdf asdf asdf sadf sdf sdf sadf asdf sdfsdfasdf asdf sdf asdf asdfsdfsdfsdafsd df ds d s ', '2012-08-15 20:03:41', 3, 'thread-test', 0, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `temp_password_grumble`
--

INSERT INTO `temp_password_grumble` (`temp_id`, `user_email`, `temp_password`, `temp_create`) VALUES
(1, 'tetz24@hotmail.com', '.Qx3QtJ0ZhORTSybffKFvVwqgKMidiQS0CkpbguJdjrMiGdSp', '2012-08-09 17:33:49'),
(2, 'beccaschmidt@outlook.com', 'uDMEJY92I2pTxzgVrUS9hvVWha3EnwyEQZwa8q0zKpXVpYrv', '2012-08-12 09:15:18');

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
  `user_about` text NOT NULL,
  `user_create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_password` varchar(50) NOT NULL,
  `user_salt` char(21) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users_grumble`
--

INSERT INTO `users_grumble` (`user_id`, `access_lvl`, `username`, `user_firstname`, `user_lastname`, `user_about`, `user_create_date`, `user_password`, `user_salt`, `user_email`) VALUES
(3, 1, 'tetz2442', 'Jon', 'Tetzlaff', '', '0000-00-00 00:00:00', 'iRB8L.qIbPi0oiROYeoEQmqSyjrC5rRo87', 'iROYeoEQmqSyjrC5rRo87', 'tetz24@hotmail.com'),
(6, 1, 'beccaschmidt', 'Becca', 'Schmidt', '', '2012-08-01 21:52:02', 'pMxhR9dCzjrjApMPYGvRJsTE.GPjMRzmVI', 'pMPYGvRJsTE.GPjMRzmVI', 'beccaschmidt@outlook.com'),
(7, 1, 'soberstadt', 'Spencer', 'Oberstadt', '', '2012-08-08 11:50:49', 'T7qeAicvSmbZkT77PaVrMWzK1ZSf/uQ/EJ', 'T77PaVrMWzK1ZSf/uQ/EJ', 'soberstadt@gmail.com'),
(8, 1, 'BoobTube', 'Boob', 'Tube', '', '2012-08-12 18:12:21', 'lDGpzgqtO4FyYlDhckDo74iBUhg58dGTSW', 'lDhckDo74iBUhg58dGTSW', 'boobtube@gmail.com');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `user_likes_grumble`
--

INSERT INTO `user_likes_grumble` (`user_like_id`, `user_id`, `status_id`) VALUES
(6, 3, 2),
(4, 3, 3),
(7, 3, 4),
(1, 6, 1),
(5, 6, 4),
(2, 7, 3),
(3, 8, 3),
(9, 8, 10),
(8, 8, 14);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `votes_up_grumble`
--

INSERT INTO `votes_up_grumble` (`votes_up_id`, `status_id`, `votes_up_count`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 3),
(4, 4, 2),
(5, 5, 0),
(6, 6, 0),
(7, 7, 0),
(8, 8, 0),
(9, 9, 0),
(10, 10, 1),
(11, 11, 0),
(12, 12, 0),
(13, 13, 0),
(14, 14, 1),
(15, 15, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
