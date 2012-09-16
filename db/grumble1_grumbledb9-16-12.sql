-- phpMyAdmin SQL Dump
-- version 3.4.10.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 16, 2012 at 04:06 PM
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
(1, 'General', 'general', 14),
(2, 'Social Media', 'social-media', 3),
(3, 'Internet', 'internet', 4),
(4, 'Health', 'health', 2),
(5, 'Sports', 'sports', 0),
(6, 'Government', 'government', 2),
(7, 'Education', 'education', 3),
(8, 'Economy', 'economy', 10),
(9, 'Companies', 'companies', 5),
(10, 'Random', 'random', 4),
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `coming_soon`
--

INSERT INTO `coming_soon` (`soon_id`, `soon_name`, `soon_email`) VALUES
(3, 'Becca', 'beccaschmidt@outlook.com'),
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
(19, 'Steve', 'stevenjmckinley@gmail.com'),
(20, 'Elise Ewers', 'elise.ewers@gmail.com'),
(21, 'Joe Tetzlaff', 'tetzlaff109@hotmail.com'),
(22, 'Fogo', 'andrew.fogo11@gmail.com'),
(23, 'Phil', 'turtcoinc@gmail.com'),
(24, 'Adam Neve', 'neveo8@hotmail.com'),
(25, 'joey', 'joeyweyenberg@yahoo.com'),
(26, 'Bonnie Tetzlaff', 'tetzjbka@yahoo.com');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `contact_grumble`
--

INSERT INTO `contact_grumble` (`contact_id`, `contact_user_id`, `contact_email`, `contact_message_type`, `contact_message`, `contact_name`, `contact_create`, `contact_resolved`) VALUES
(1, 18, 'tetzlaff109@hotmail.com', 'Send Message', 'Jon your site sucks. \nJoe', 'Joe ', '2012-09-08 10:13:44', 0),
(2, 20, 'lanceaeby@gmail.com', 'Send Message', 'OM NOM NOOOBZ', 'Lance', '2012-09-14 13:45:40', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cookies_grumble`
--

INSERT INTO `cookies_grumble` (`cookie_id`, `cookie_text`, `cookie_expire`, `user_id`) VALUES
(1, '$1$9WHWadn8$VSu4JJoqA2uqqBadM73mo.', '2012-09-22 11:09:44', 6),
(2, '$1$1Druext9$2zfP2KyWGzOUcSEWWKqoJ.', '2012-09-21 13:36:16', 7);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `help_callout_text`
--

INSERT INTO `help_callout_text` (`help_callout_id`, `help_callout_title`, `help_callout_text`) VALUES
(1, 'Creating Meaningful Grumble Names', 'To create a Grumble that will be found by the people of Grumble and the internet, you should have a descriptive title.<br/><br/>\nFor example: Instead of "Charter", you could put "Charter Service is Poor".'),
(2, 'Creating Thorough Descriptions', 'Having a thorough decsription for a Grumble is very important. When people search the internet, they will be able to see the description you have provided for this thread. Be as descriptive as possible to achieve better results.'),
(3, 'Choosing a Unique Username', 'Usernames on Grumble work just like they do most other places, such as Twitter. You just have to make sure your username is unique.\n<br/><br/>Ex. johnDoe, johnDoe13'),
(4, 'Creating Secure Passwords', 'Secure passwords are an important part of the internet, as they protect your valuable information. <br/><br/>On Grumble your password needs to contain letters and numbers. We also recommend special characters.');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `replies_grumble`
--

INSERT INTO `replies_grumble` (`reply_id`, `status_id`, `reply_date`, `reply_user`, `reply_text`, `reply_spam`) VALUES
(1, 5, '2012-09-08 11:18:25', 3, 'New reply', 0),
(2, 6, '2012-09-08 12:15:56', 3, 'new reply', 0),
(3, 6, '2012-09-08 12:17:57', 3, 'more!', 0),
(4, 6, '2012-09-08 12:19:19', 3, 'one more', 0),
(5, 6, '2012-09-08 12:33:38', 3, 'http://test.grumbleonline.com/internet/terrible-wordpress-theme-guide/5', 0),
(6, 6, '2012-09-08 12:41:31', 3, 'http://test.grumbleonline.com/internet/terrible-wordpress-theme-guide/5', 0),
(7, 6, '2012-09-08 12:42:48', 3, 'http://test.grumbleonline.com/internet/terrible-wordpress-theme-guide/5', 0),
(8, 6, '2012-09-08 12:52:05', 3, 'new reply', 0),
(9, 1, '2012-09-08 13:27:51', 6, 'https://www.google.com/ link link link', 0),
(10, 1, '2012-09-09 17:14:10', 3, 'reply', 0),
(11, 6, '2012-09-09 20:03:41', 3, 'fghsfh', 0),
(12, 1, '2012-09-12 17:04:37', 3, 'reply', 0),
(13, 1, '2012-09-12 17:04:42', 3, 'another', 0),
(14, 5, '2012-09-14 13:36:48', 7, 'Double click...', 0),
(15, 5, '2012-09-14 13:37:01', 7, 'Boom!!!!', 0),
(16, 7, '2012-09-14 13:38:04', 7, 'meh...', 0),
(17, 21, '2012-09-14 13:47:38', 20, 'Huh???!!?? YOU DID?!?!?! IS YOUR NAME STEVE JOBS?!?!?!?', 0),
(18, 21, '2012-09-14 13:47:58', 20, 'YES MY NAME IS STEVE... IM SPEAKING THROUGH THIS COMPUTER SCREEN FROM THE AFTERLIFE', 0),
(19, 25, '2012-09-14 14:00:33', 3, 'hello lance', 0),
(20, 22, '2012-09-14 14:01:07', 3, 'poopy mouth', 0),
(21, 31, '2012-09-14 14:02:44', 20, 'You spelled Default wrong you noob.  Real Lance knows how to spell.', 0),
(22, 31, '2012-09-14 14:04:21', 21, 'This doesnt work either...', 0),
(23, 31, '2012-09-14 14:04:49', 3, 'here is a reply', 0),
(24, 30, '2012-09-14 14:10:35', 7, 'leave him alone!', 0),
(25, 35, '2012-09-15 11:21:10', 6, 'Word!', 0),
(26, 32, '2012-09-15 19:36:35', 3, 'New reply', 0),
(27, 32, '2012-09-15 19:38:30', 3, 'Another?', 0),
(28, 32, '2012-09-15 19:39:36', 3, 'Hola', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `settings_user_grumble`
--

INSERT INTO `settings_user_grumble` (`settings_id`, `user_id`, `settings_email_thread`, `settings_email_comment`) VALUES
(1, 8, 1, 1),
(2, 9, 1, 1),
(3, 10, 1, 1),
(4, 11, 1, 1),
(5, 3, 1, 0),
(6, 6, 1, 1),
(7, 12, 1, 1),
(8, 13, 1, 1),
(9, 14, 0, 1),
(10, 15, 1, 0),
(11, 16, 1, 1),
(12, 17, 1, 1),
(13, 18, 1, 1),
(14, 19, 1, 1),
(15, 20, 1, 1),
(16, 21, 0, 0),
(17, 22, 1, 1),
(18, 23, 1, 1),
(19, 24, 1, 1),
(20, 25, 1, 1),
(21, 26, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `spam_grumble`
--

DROP TABLE IF EXISTS `spam_grumble`;
CREATE TABLE IF NOT EXISTS `spam_grumble` (
  `spam_id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_category_id` int(11) NOT NULL DEFAULT '0',
  `status_id` int(11) NOT NULL DEFAULT '0',
  `reply_id` int(11) NOT NULL DEFAULT '0',
  `spam_report_number` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`spam_id`),
  KEY `sub_category_id` (`sub_category_id`,`status_id`,`reply_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `spam_grumble`
--

INSERT INTO `spam_grumble` (`spam_id`, `sub_category_id`, `status_id`, `reply_id`, `spam_report_number`) VALUES
(1, 0, 2, 0, 2),
(2, 0, 8, 0, 1),
(3, 0, 28, 0, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `status_grumble`
--

INSERT INTO `status_grumble` (`status_id`, `sub_category_id`, `status_text`, `date_submitted`, `user_id`, `status_spam`) VALUES
(1, 1, 'another', '2012-09-05 19:19:21', 3, 0),
(4, 3, 'How did such a worthless human become our president!', '2012-09-08 10:11:22', 18, 0),
(5, 5, 'I would have to agree with myself', '2012-09-08 11:17:26', 3, 0),
(6, 5, 'One more', '2012-09-08 11:38:45', 3, 0),
(7, 6, 'Great site, great job!', '2012-09-08 13:09:38', 19, 0),
(8, 6, 'sdagfasdf asdf sadf sadf http://test.grumbleonline.com/general/we-need-more-rain/6 asdf sdf sdf sadf sdfsdfsad asdfsdsadfsdsdfsdf sadfsd sdf sdf sad sd fsdf asdfsdsdf asd fasd fasdd sdfsd', '2012-09-08 14:30:11', 3, 0),
(9, 5, 'Hit me with a timezone', '2012-09-09 17:19:15', 3, 0),
(10, 5, 'another!', '2012-09-09 23:20:10', 3, 0),
(12, 5, 'One more', '2012-09-10 13:35:53', 3, 0),
(13, 5, 'New one', '2012-09-10 13:48:05', 3, 0),
(14, 5, 'One more', '2012-09-10 14:21:55', 3, 0),
(16, 5, 'Hola', '2012-09-11 01:26:55', 3, 0),
(17, 5, 'Writing a comment. A new one.', '2012-09-13 03:35:36', 3, 0),
(18, 5, 'A few more chaps', '2012-09-13 03:36:55', 3, 0),
(19, 5, 'Another one', '2012-09-13 03:37:03', 3, 0),
(20, 5, 'Maybe one more', '2012-09-13 03:37:08', 3, 0),
(21, 7, 'You think you\\''re a monster?  Did you make this: www.monster.com ?????', '2012-09-14 19:46:54', 20, 0),
(22, 12, 'I think he\\''s just helping everyone!!!', '2012-09-14 19:57:28', 21, 0),
(24, 12, 'the guy below is an IMPOSTER', '2012-09-14 19:57:56', 20, 0),
(25, 12, 'Will the real Lance Aeby, please stand up?  Will the real Lance Aeby, please stand up?', '2012-09-14 19:58:55', 20, 0),
(26, 12, 'Poop poop poop', '2012-09-14 19:59:12', 3, 0),
(28, 12, 'NO>>> WRONG LANCE >>>', '2012-09-14 20:00:33', 20, 0),
(29, 12, '\\\\StandUp', '2012-09-14 20:00:42', 21, 0),
(30, 12, '*whisper* -> lancea \\"Get out you fake\\"', '2012-09-14 20:01:28', 20, 0),
(31, 12, 'event.preventDefualt()', '2012-09-14 20:01:51', 21, 0),
(32, 12, 'dsvsvsdv', '2012-09-14 20:05:47', 3, 0),
(33, 5, 'New comment', '2012-09-15 01:20:15', 3, 0),
(34, 5, 'I win with this enter button', '2012-09-15 01:21:22', 3, 0),
(35, 13, 'The only reason I can think of is to make them look elegant and higher quality, but you shouldn\\''t need to throw French on your label to accomplish that!', '2012-09-15 17:20:26', 3, 0),
(37, 14, 'new comment', '2012-09-16 16:06:18', 3, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `sub_category_grumble`
--

INSERT INTO `sub_category_grumble` (`sub_category_id`, `category_id`, `sub_category_name`, `sub_category_description`, `sub_category_created`, `user_id`, `sub_category_url`, `grumble_number`, `sub_category_spam`) VALUES
(1, 7, 'New one', 'blah blah', '2012-09-05 18:57:47', 3, 'new-one', 1, 0),
(2, 10, 'Brand Spankin\\'' New', 'Here is a new Grumble you beast', '2012-09-06 19:42:48', 12, 'brand-spankin-new', 0, 0),
(3, 6, 'Obama sucks...', 'Our country is going into the shitter and he\\''s not even a US citizen..', '2012-09-08 10:02:52', 18, 'obama-sucks', 1, 0),
(4, 7, 'sadf asdf sad fas df asdfasd fasd fasdfd', 'asdf sadf asdf sad fas df asdfasd fasd fasdfsdfsadf asdf sad fas df asdfasd fasd fasdfsdfsadf asdf sad fas df asdfasd fasd fasdfsdfsadf asdf sad fas df asdfasd fasd fasdfsdfsadf asdf sad fas df asdfasd fasd fasdfsdfsadf asdf sad fas df ', '2012-09-08 10:56:14', 3, 'sadf-asdf-sad-fas-df-asdfasd-fasd-fasdfd', 0, 0),
(5, 3, 'Terrible wordpress theme guide', 'Check this out! http://webdesignerwall.com/tutorials/building-custom-wordpress-theme', '2012-09-08 11:16:18', 3, 'terrible-wordpress-theme-guide', 15, 0),
(6, 1, 'We need more rain.', 'Weather', '2012-09-08 13:08:08', 19, 'we-need-more-rain', 2, 0),
(7, 8, 'I\\''m a monster', 'Hear me roar.', '2012-09-14 19:46:00', 20, 'im-a-monster', 1, 0),
(8, 8, 'I\\''m a monster', 'Poop', '2012-09-14 19:49:17', 7, 'im-a-monster', 0, 0),
(9, 8, 'I\\''m a monster', 'Poopdsf', '2012-09-14 19:49:38', 7, 'im-a-monster', 0, 0),
(10, 8, 'I\\''m a monster', 'Poopds', '2012-09-14 19:49:47', 7, 'im-a-monster', 0, 0),
(11, 8, 'I\\''m a monster', 'Poopdssdddd', '2012-09-14 19:50:00', 7, 'im-a-monster', 0, 0),
(12, 1, 'Spencer keeps messing up the site', 'He won\\''t stop freaking breaking things.  Let\\''s hit him with a wiffle bat or something', '2012-09-14 19:52:39', 20, 'spencer-keeps-messing-up-the-site', 9, 0),
(13, 1, 'French on product labels', 'Why do products have French on their labels? They should be in Spanish since so many people in the U.S. understand that next to English. Sure, French looks fancy on a label, but not many people understand it.', '2012-09-15 17:04:51', 6, 'french-on-product-labels', 1, 0),
(14, 10, 'New grumble', 'hola new grumble', '2012-09-16 15:36:48', 3, 'new-grumble', 2, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `temp_password_grumble`
--

INSERT INTO `temp_password_grumble` (`temp_id`, `user_email`, `temp_password`, `temp_create`) VALUES
(14, 'tetz@hotmail.com', 'luVH.hoCE5Ou2WVUk2mC5WasRu7EcPQwRwrtgryGt2aA2zVfE1', '2012-09-14 16:37:57'),
(15, 'tet@gmail.com', 'i2kstxQJD7CwDrDBOCw7TRzY8Adv2GQX1DR1sJcR4ozCLiRnQN', '2012-09-14 16:48:12'),
(16, 'asdf@adsaf.com', 'AhogqGVlmG3BhzO2gCH5oqVIgzWb7iw8htUYfAhRundcuejaO/', '2012-09-14 16:49:52'),
(17, 'asdf@asdf.com', 'pwjRgPQ4VqjemJKWPwytpfsPpgusqK7toBawSAXB//ngVNVuV5', '2012-09-14 16:54:46'),
(18, 'sdf@asdf.com', '/7ANjT0JrUl2kW2Siu.L2ilK3Gi7TrrOZTooNU33yCIGbAx.Kk', '2012-09-14 17:11:19');

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
  `user_password` varchar(255) NOT NULL,
  `user_salt` char(21) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_timezone` varchar(50) NOT NULL DEFAULT 'America/Chicago',
  `user_verified` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `users_grumble`
--

INSERT INTO `users_grumble` (`user_id`, `access_lvl`, `username`, `user_firstname`, `user_lastname`, `user_create_date`, `user_password`, `user_salt`, `user_email`, `user_timezone`, `user_verified`) VALUES
(3, 3, 'tetz2442', 'Jon', 'Tetzlaff', '2012-08-01 21:52:02', 's/S.nhba/1Ghos/2sMFqNY1.g1CJamFCF6', 's/2sMFqNY1.g1CJamFCF6', 'tetz24@hotmail.com', 'America/Chicago', 1),
(6, 1, 'becca', 'Becca', 'Schmidt', '2012-08-01 21:52:02', 'HgDkrdITbjw7AHgmpGJqgCsy477ge1Atvp', 'HgmpGJqgCsy477ge1Atvp', 'beccaschmidt@outlook.com', 'America/Chicago', 1),
(7, 1, 'soberstadt', 'Spencer', 'Oberstadt', '2012-08-08 11:50:49', 'T7qeAicvSmbZkT77PaVrMWzK1ZSf/uQ/EJ', 'T77PaVrMWzK1ZSf/uQ/EJ', 'soberstadt@gmail.com', 'America/Chicago', 1),
(8, 1, 'BoobTube', 'Boob', 'Tube', '2012-08-12 18:12:21', 'lDGpzgqtO4FyYlDhckDo74iBUhg58dGTSW', 'lDhckDo74iBUhg58dGTSW', 'boobtube@gmail.com', 'America/Chicago', 0),
(9, 1, 'DenzelWashington', 'WILL MOFUKIN\\''', 'RAY', '2012-08-22 09:52:34', '6n5YwgmgG32Lo6nTrrLSWC2YEJGj71cYwY', '6nTrrLSWC2YEJGj71cYwY', 'wray167@uwsp.edu', 'America/Chicago', 1),
(10, 1, 'papajoe', 'Joseph', 'Weyenberg', '2012-08-23 09:20:57', 'WygYM7uFuG0z6Wy.On3P4s4y58sz.Ub6Mb', 'Wy.On3P4s4y58sz.Ub6Mb', 'joeyweyenberg@yahoo.com', 'America/Chicago', 0),
(11, 1, 'SliceOfLife', 'Dexter', 'Morgan', '2012-08-23 21:01:21', 'WvzG.hN4DpiLoWvCqYToCxm8if5RteXysW', 'WvCqYToCxm8if5RteXysW', 'laeby559@uwsp.edu', 'America/Chicago', 0),
(13, 1, 'macek', 'Paul', 'Macek', '2012-08-28 10:18:06', '4vsPUpwELg3eU4vNlO7HwPQxcFPuG2n1r8', '4vNlO7HwPQxcFPuG2n1r8', 'paulmacek@gmail.com', 'America/Chicago', 1),
(17, 1, 'tetz24', 'Jon', 'Tetzlaff', '2012-09-07 19:26:56', '1lsjLpXTkUaYM1lquxVD07GSTrMH.t0KRc', '1lquxVD07GSTrMH.t0KRc', 'tetz2442@gmail.com', 'America/Chicago', 1),
(18, 1, 'clay23', 'Joe ', 'Tetzlaff', '2012-09-08 09:56:48', 'i9eQSL4W/TTtIi9LK4sPRRgxWfEH6BsPN5', 'i9LK4sPRRgxWfEH6BsPN5', 'tetzlaff109@hotmail.com', 'America/Chicago', 1),
(19, 1, 'Wacky', 'Jaci', 'Tetzlaff', '2012-09-08 13:05:12', '.gRDOAQTfoTTM.gLIQmbicJR2YnVWBnWWu', '.gLIQmbicJR2YnVWBnWWu', 'jtetzlaff@tds.net', 'America/Chicago', 1),
(20, 1, 'lanceaeby', 'Lance', 'Aeby', '2012-09-14 19:44:50', 'x.dNHohRn7icox.N2lbH1we7J1djPLEE1H', 'x.N2lbH1we7J1djPLEE1H', 'lanceaeby@gmail.com', 'America/Chicago', 1),
(21, 1, 'lancea', 'Spencer', 'Oberstadt', '2012-09-14 19:56:30', '6HPZcWYJ3Uw926HzEJ1ELYBNohKYZ9nBDF', '6HzEJ1ELYBNohKYZ9nBDF', 'sober320@uwsp.edu', 'America/Chicago', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `user_likes_grumble`
--

INSERT INTO `user_likes_grumble` (`user_like_id`, `user_id`, `status_id`) VALUES
(2, 3, 1),
(1, 3, 2),
(4, 3, 4),
(5, 3, 5),
(7, 3, 9),
(6, 3, 10),
(3, 3, 12),
(14, 3, 22),
(9, 3, 30),
(10, 3, 31),
(12, 6, 25),
(13, 6, 35),
(11, 7, 22),
(8, 7, 23);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
