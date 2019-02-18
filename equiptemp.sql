-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2018 at 02:28 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `equiptemp`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `cartid` mediumint(9) NOT NULL AUTO_INCREMENT,
  `pid` mediumint(6) NOT NULL,
  `items_id` mediumint(9) NOT NULL,
  `qty` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cartid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartid`, `pid`, `items_id`, `qty`) VALUES
(4, 142028, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `donate`
--

CREATE TABLE IF NOT EXISTS `donate` (
  `p_key` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `qty` int(5) NOT NULL,
  `item` varchar(100) NOT NULL,
  PRIMARY KEY (`p_key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `p_key` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(30) NOT NULL,
  `cost` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `mode` text NOT NULL,
  `gen_name` varchar(100) NOT NULL,
  PRIMARY KEY (`p_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`p_key`, `item`, `cost`, `quantity`, `mode`, `gen_name`) VALUES
(1, 'Raspberry Pi', 3000, 10, 'Purchase', 'MicroProcessor'),
(2, 'arduino', 450, 30, 'donate', 'microcontroller');

-- --------------------------------------------------------

--
-- Table structure for table `loss`
--

CREATE TABLE IF NOT EXISTS `loss` (
  `p_key` int(11) NOT NULL AUTO_INCREMENT,
  `pid` varchar(15) NOT NULL,
  `name` text NOT NULL,
  `reason` varchar(50) NOT NULL,
  `cost` int(10) NOT NULL,
  `qty` tinyint(4) NOT NULL,
  `item` varchar(100) NOT NULL,
  PRIMARY KEY (`p_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `p_key` int(11) NOT NULL AUTO_INCREMENT,
  `pid` mediumint(6) NOT NULL,
  `date_taken` date NOT NULL,
  `date_return` date DEFAULT NULL,
  `status` varchar(15) NOT NULL,
  `name` text NOT NULL,
  `class` varchar(50) NOT NULL,
  `contact` bigint(11) NOT NULL,
  `flag` varchar(300) DEFAULT NULL,
  `reason` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `prof_email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`p_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`p_key`, `pid`, `date_taken`, `date_return`, `status`, `name`, `class`, `contact`, `flag`, `reason`, `email`, `prof_email`) VALUES
(2, 142025, '2017-03-03', '2017-03-08', 'returned', 'steven', 'te cmpn a', 8455723458, '', 'personal', 'steven@mail.com', 'abc2'),
(1, 142028, '2017-03-01', NULL, 'requested', 'varun', 'te cmpn b', 8655964365, NULL, 'pragati', 'varunmaniark@gmail.com', 'abc'),
(3, 142001, '2017-04-05', NULL, 'returned', 'name1', 'class1', 9650967392, 'flag1', 'reason1', 'email1', NULL),
(4, 142002, '2017-04-05', NULL, 'returned', 'name2', 'class1', 9876543210, 'flag2', 'reason2', 'email2', NULL),
(5, 142003, '2017-04-06', NULL, 'returned', 'name3', 'class3', 9876543210, 'flasg3', 'reason3', 'email3', NULL),
(7, 142005, '2017-04-04', NULL, 'returned', 'name5', 'class5', 9876543210, 'flag5', 'reason5', 'email5', NULL),
(8, 142006, '2017-04-06', NULL, 'returned', 'name6', 'class6', 9876543210, 'flag6', 'reason6', 'email6', NULL),
(9, 142007, '2017-04-07', NULL, 'returned', 'name7', 'class7', 9876543210, 'flag7', 'reason7', 'email7', NULL),
(10, 142008, '2017-04-06', NULL, 'returned', 'name8', 'class8', 9876543210, 'flag8', 'reason8', 'email8', NULL),
(11, 142009, '2017-04-06', NULL, 'returned', 'name9', 'class9', 9876543210, 'flag9', 'reason9', 'email9', NULL),
(12, 142010, '2017-04-07', NULL, 'returned', 'name10', 'class10', 9876543120, 'flag10', 'reason10', 'email10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE IF NOT EXISTS `orderdetails` (
  `p_key` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(100) NOT NULL,
  `qty` mediumint(5) NOT NULL,
  `order_id` mediumint(9) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`p_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` mediumint(9) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `password` varchar(30) NOT NULL,
  `username` varchar(100) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `pid`, `password`, `username`) VALUES
(1, 142028, 'equip', 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
