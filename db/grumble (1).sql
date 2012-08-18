-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 10, 2012 at 01:22 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `grumble`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories_grumble`
--

CREATE TABLE IF NOT EXISTS `categories_grumble` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`),
  KEY `category_name` (`category_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `categories_grumble`
--

INSERT INTO `categories_grumble` (`category_id`, `category_name`) VALUES
(8, 'Economy'),
(7, 'Education'),
(1, 'General'),
(6, 'Government'),
(4, 'Health'),
(3, 'Internet'),
(5, 'Politics'),
(2, 'Social Media');

-- --------------------------------------------------------

--
-- Table structure for table `coming_soon`
--

CREATE TABLE IF NOT EXISTS `coming_soon` (
  `soon_id` int(11) NOT NULL AUTO_INCREMENT,
  `soon_name` varchar(50) NOT NULL,
  `soon_email` varchar(100) NOT NULL,
  PRIMARY KEY (`soon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments_grumble`
--

CREATE TABLE IF NOT EXISTS `comments_grumble` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_id` int(11) NOT NULL,
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_user` int(11) NOT NULL,
  `comment_text` varchar(161) NOT NULL,
  `comment_spam` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `status_id` (`status_id`,`comment_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `comments_grumble`
--

INSERT INTO `comments_grumble` (`comment_id`, `status_id`, `comment_date`, `comment_user`, `comment_text`, `comment_spam`) VALUES
(1, 2, '2012-08-06 19:12:36', 3, 'comment', 0),
(2, 2, '2012-08-06 19:13:46', 3, 'another', 0),
(3, 2, '2012-08-06 19:15:59', 3, 'one more', 0),
(4, 2, '2012-08-06 19:16:17', 3, 'last one', 0),
(5, 1, '2012-08-06 19:18:46', 3, 'comment', 0),
(6, 2, '2012-08-06 19:23:56', 3, 'comment', 0),
(7, 2, '2012-08-06 19:25:10', 3, 'comment 4', 0),
(8, 2, '2012-08-06 19:25:54', 3, 'last one', 0),
(9, 9, '2012-08-06 20:37:24', 3, 'Comment', 0),
(10, 10, '2012-08-07 21:13:41', 3, 'asdf', 0),
(11, 8, '2012-08-07 21:13:46', 3, 'asdf', 0),
(12, 16, '2012-08-07 21:14:00', 3, 'asdf', 0),
(13, 30, '2012-08-08 18:44:45', 3, 'comment', 0),
(14, 30, '2012-08-08 18:46:42', 3, 'Send new comment', 0),
(15, 30, '2012-08-08 18:46:48', 3, 'Another!', 0),
(16, 16, '2012-08-08 18:58:01', 3, 'one more', 0),
(17, 16, '2012-08-08 18:58:06', 3, 'another one', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact_grumble`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `contact_grumble`
--

INSERT INTO `contact_grumble` (`contact_id`, `contact_user_id`, `contact_email`, `contact_message_type`, `contact_message`, `contact_name`, `contact_create`) VALUES
(3, 0, 'tetz24@hotmail.com', 'Request Feature', 'asdf', 'j', '2012-07-29 13:26:45'),
(4, 3, 'tetz24@hotmail.com', 'Request Feature', 'asdfasdf', 'Jon', '2012-07-29 13:34:22'),
(5, 0, 'tetz24@hotmail.com', 'Request Feature', 'asdf', 'Jon', '2012-07-29 13:48:31'),
(6, 0, 'tetz24@hotmail.com', 'Request Feature', 'asdfasdf', 'Jon Tetzlaff', '2012-07-29 13:50:38'),
(7, 0, 'tetz24@hotmail.com', 'Request Feature', 'Hello', 'Jon Tetzlaff', '2012-07-29 13:51:38'),
(8, 3, 'tetz24@hotmail.com', 'Request Feature', 'Hello', 'Jon', '2012-07-29 13:51:57'),
(9, 3, 'tetz24@hotmail.com', 'Request Feature', 'asdfasdf', 'Jon', '2012-08-08 18:20:11'),
(10, 3, 'tetz24@hotmail.com', 'Request Feature', 'asdfasdf', 'Jon', '2012-08-08 18:20:12'),
(11, 3, 'tetz24@hotmail.com', 'Request Feature', 'asdfasdf', 'Jon', '2012-08-08 18:20:59'),
(12, 3, 'tetz24@hotmail.com', 'Request Feature', 'dafgasdg', 'Jon', '2012-08-08 18:22:11'),
(13, 3, 'tetz24@hotmail.com', 'Request Feature', 'asdfasd', 'Jon', '2012-08-08 18:25:22');

-- --------------------------------------------------------

--
-- Table structure for table `images_grumble`
--

CREATE TABLE IF NOT EXISTS `images_grumble` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_image` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`image_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `images_grumble`
--

INSERT INTO `images_grumble` (`image_id`, `profile_image`, `thumbnail`, `user_id`) VALUES
(18, 'user-images/profile/18.jpg', 'user-images/thumbnail/18.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `settings_user_grumble`
--

CREATE TABLE IF NOT EXISTS `settings_user_grumble` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`settings_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `status_grumble`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sub_category_grumble`
--

CREATE TABLE IF NOT EXISTS `sub_category_grumble` (
  `sub_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `sub_category_name` varchar(40) NOT NULL,
  `sub_category_description` varchar(255) NOT NULL,
  `sub_category_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(11) NOT NULL,
  `sub_category_url` varchar(60) NOT NULL,
  `grumble_number` int(11) NOT NULL DEFAULT '0',
  `sub_category_spam` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sub_category_id`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `temp_password_grumble`
--

CREATE TABLE IF NOT EXISTS `temp_password_grumble` (
  `temp_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) NOT NULL,
  `temp_password` varchar(50) NOT NULL DEFAULT '',
  `temp_create` datetime NOT NULL,
  PRIMARY KEY (`temp_id`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_grumble`
--

CREATE TABLE IF NOT EXISTS `users_grumble` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `access_lvl` int(1) NOT NULL DEFAULT '1',
  `user_image_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `user_lastname` varchar(50) NOT NULL,
  `user_about` text NOT NULL,
  `user_create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_password` varchar(50) NOT NULL,
  `user_salt` char(21) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `temp_password` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`),
  UNIQUE KEY `username` (`username`),
  KEY `user_image_id` (`user_image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users_grumble`
--

INSERT INTO `users_grumble` (`user_id`, `access_lvl`, `user_image_id`, `username`, `user_firstname`, `user_lastname`, `user_about`, `user_create_date`, `user_password`, `user_salt`, `user_email`, `temp_password`) VALUES
(3, 1, 18, 'tetz2442', 'Jon', 'Tetzlaff', '', '0000-00-00 00:00:00', 'iRB8L.qIbPi0oiROYeoEQmqSyjrC5rRo87', 'iROYeoEQmqSyjrC5rRo87', 'tetz24@hotmail.com', 'uuSTdZeyNmtPmbrL7NlyujbXyt66EBVSaw.g2DHkFCmY4uEDc'),
(4, 1, 0, 'beccaschmidt', 'Becca', 'Schmidt', '', '0000-00-00 00:00:00', 'ps2JTx5qahv5ApsKqgzClhwK4sN/veIYe9', 'psKqgzClhwK4sN/veIYe9', 'bayka@gmail.com', ''),
(5, 1, 0, 'asdfasdf', 'Steve', 'Tetzlaff', '', '0000-00-00 00:00:00', 'AAnU5MMnyHM/AAAIhZAyjO5bchrxAry1m9', 'AAIhZAyjO5bchrxAry1m9', 'stevey@steve.com', ''),
(6, 1, 0, 'asdf', 'asdf', 'asdf', '', '2012-08-01 23:48:22', 'YqjEe8/BlHszQYqyWb9LFlNUEL2Y4P5Rx3', 'YqyWb9LFlNUEL2Y4P5Rx3', 'asdf@asdfa.com', ''),
(7, 1, 0, 'thisuser', 'Jon', 'Test', '', '2012-08-07 22:27:43', '/ryQ/WQhM5J4o/rQuzwe8oidAu/fHeb4SW', '/rQuzwe8oidAu/fHeb4SW', 'testemail@email.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_likes_grumble`
--

CREATE TABLE IF NOT EXISTS `user_likes_grumble` (
  `user_like_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`user_like_id`),
  KEY `user_id` (`user_id`,`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `votes_up_grumble`
--

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
