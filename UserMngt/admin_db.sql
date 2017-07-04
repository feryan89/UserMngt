-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 17, 2017 at 02:01 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `admin_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatz`
--

CREATE TABLE IF NOT EXISTS `chatz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` varchar(10) NOT NULL,
  `text` text NOT NULL,
  `time` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `chatz`
--

INSERT INTO `chatz` (`id`, `userID`, `text`, `time`) VALUES
(1, '1', 'hi all ..', '1:06 PM'),
(2, '2', 'hi too :)', '1:06 PM');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `hiredate` date NOT NULL,
  `birthdate` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `status`, `picture`, `department`, `hiredate`, `birthdate`, `gender`, `address`, `email`, `phone`) VALUES
(1, 'admin', 'admin', 'Agha', 'nathan', 'Actived', 'gaby.png', 'Programming', '2017-06-23', '1988-01-24', 'male', 'Depok, Indonesia', 'aghanata@yahoo.com', '555-666-777'),
(2, 'demo', 'demo', 'Sheena', 'Shrestha', 'Actived', 'avatar-300x300.png', 'Programming', '2017-06-23', '1988-01-24', 'male', 'Depok, Indonesia', 'info@support.com', '555-666-777'),
(4, 'author', 'author', 'John', 'Doe', 'Inactive', 'no-image.png', 'Programming', '2017-05-17', '1986-05-08', 'male', '', 'info@support.com', '555-4567-890');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
