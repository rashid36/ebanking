-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 25, 2014 at 05:30 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ebank`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_type`
--

CREATE TABLE IF NOT EXISTS `account_type` (
  `account_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(111) NOT NULL,
  PRIMARY KEY (`account_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `account_type`
--

INSERT INTO `account_type` (`account_type_id`, `account_name`) VALUES
(1, 'currentAccount'),
(2, 'saveAccount');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE IF NOT EXISTS `bank` (
  `bank_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(111) NOT NULL,
  `branch_code` varchar(111) NOT NULL,
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`bank_id`, `bank_name`, `branch_code`) VALUES
(1, 'UBL', '1226'),
(2, 'HBL', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `bank_status`
--

CREATE TABLE IF NOT EXISTS `bank_status` (
  `bank_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `login_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `debit` int(11) NOT NULL,
  `credit` int(11) NOT NULL,
  `outstanding_balance` int(11) NOT NULL,
  PRIMARY KEY (`bank_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `bank_status`
--

INSERT INTO `bank_status` (`bank_status_id`, `login_id`, `date`, `debit`, `credit`, `outstanding_balance`) VALUES
(64, 1, '2014-03-06 05:04:04', 100, 0, 700),
(65, 1, '2014-03-07 09:05:03', 100, 0, 600),
(66, 1, '0000-00-00 00:00:00', 100, 0, 500),
(67, 1, '2014-03-10 00:00:00', 200, 0, 300),
(68, 1, '2014-03-09 14:07:26', 50, 0, 250),
(69, 1, '2014-03-09 14:11:36', 50, 0, 200);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `country_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `country_name` varchar(128) COLLATE latin1_general_ci DEFAULT NULL,
  `iso2` char(2) COLLATE latin1_general_ci DEFAULT NULL,
  `iso3` char(3) COLLATE latin1_general_ci DEFAULT NULL,
  `num_code` int(6) unsigned DEFAULT NULL,
  `calling_code` varchar(6) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `country_name`, `iso2`, `iso3`, `num_code`, `calling_code`) VALUES
(1, 'pakistan', 'Pa', 'Pak', 122, '0969');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(111) NOT NULL,
  PRIMARY KEY (`currency_id`),
  UNIQUE KEY `currency_name` (`currency_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`currency_id`, `currency_name`) VALUES
(2, 'dollar'),
(1, 'rupees');

-- --------------------------------------------------------

--
-- Table structure for table `current_account`
--

CREATE TABLE IF NOT EXISTS `current_account` (
  `login_id` int(11) NOT NULL,
  `account_type_id` int(11) NOT NULL,
  `current_balance` double NOT NULL,
  `account_no` varchar(111) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `account_status` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  UNIQUE KEY `login_id_2` (`login_id`),
  KEY `account_type_id` (`account_type_id`),
  KEY `login_id` (`login_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `current_account`
--

INSERT INTO `current_account` (`login_id`, `account_type_id`, `current_balance`, `account_no`, `bank_id`, `account_status`, `currency_id`, `country_id`) VALUES
(1, 1, 20000, '1001', 1, 1, 1, 1),
(2, 1, 6500, '1002', 1, 1, 1, 1),
(3, 1, 4800, '1003', 1, 1, 1, 1),
(4, 1, 50000, '1004', 2, 1, 1, 1),
(5, 1, 50000, '1005', 2, 1, 1, 1),
(6, 1, 50000, '1006', 2, 1, 1, 1),
(7, 1, 50000, '1007', 1, 1, 1, 1),
(8, 1, 2e+017, '1008', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_login`
--

CREATE TABLE IF NOT EXISTS `customer_login` (
  `login_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(111) NOT NULL,
  `username` varchar(111) NOT NULL,
  `password` varchar(111) NOT NULL,
  `account_status` int(11) NOT NULL,
  `status_msg` varchar(313) NOT NULL,
  PRIMARY KEY (`login_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `customer_login`
--

INSERT INTO `customer_login` (`login_id`, `name`, `username`, `password`, `account_status`, `status_msg`) VALUES
(1, 'Dr. Kamran', 'hod', '17d84f171d54c301fabae1391a125c4e', 1, 'Successful login'),
(2, 'Sir. Omer Ali', 'omerali', '916468a2b614352a9b444bd0fbba39f8', 1, 'Successful login'),
(3, 'Sir Omer Mushtaq', 'omer', '916468a2b614352a9b444bd0fbba39f8', 1, 'Successful login'),
(4, 'Sir. Aon Ali', 'aon', '86318e52f5ed4801abe1d13d509443de', 1, 'Successful login'),
(5, 'Sir. Fiaz', 'fiaz', 'bc823f955f70d6ea8662c37bb817f8b4', 1, 'Successful login'),
(6, 'Sir. Rauf', 'rauf', '8b26a2baacc2118afc1860c842cd2a9c', 1, 'Successful login'),
(7, 'Sir. Abid', 'abid', 'fbc2097d2d2310090e007162a34ff628', 1, 'Successful login'),
(8, 'Ansar', 'ansar', '3fb3c4253fbc96c1f6c9647e9c5d0bd3', 1, 'Successful login');

-- --------------------------------------------------------

--
-- Table structure for table `financial_key`
--

CREATE TABLE IF NOT EXISTS `financial_key` (
  `financial_key_id` int(11) NOT NULL AUTO_INCREMENT,
  `login_id` int(11) NOT NULL,
  `random_number` int(11) NOT NULL,
  `c_date` datetime NOT NULL,
  PRIMARY KEY (`financial_key_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `financial_key`
--

INSERT INTO `financial_key` (`financial_key_id`, `login_id`, `random_number`, `c_date`) VALUES
(2, 1, 77326, '2014-03-25 23:12:19'),
(6, 2, 75475, '2014-03-04 18:03:01'),
(7, 3, 4923, '2014-04-30 17:07:27');

-- --------------------------------------------------------

--
-- Table structure for table `load_draw_inbox`
--

CREATE TABLE IF NOT EXISTS `load_draw_inbox` (
  `load_draw_inbox_id` int(11) NOT NULL AUTO_INCREMENT,
  `login_id` int(11) NOT NULL,
  `networId` int(11) NOT NULL,
  `mobileNo` varchar(111) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`load_draw_inbox_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `load_draw_inbox`
--

INSERT INTO `load_draw_inbox` (`load_draw_inbox_id`, `login_id`, `networId`, `mobileNo`, `amount`, `date`) VALUES
(47, 1, 2, '03447550749', 100, '2014-03-09 00:00:00'),
(48, 1, 2, '03447550749', 100, '2014-03-10 00:00:00'),
(49, 1, 2, '03447550749', 100, '2014-03-12 00:00:00'),
(51, 1, 2, '03028131147', 50, '2014-03-09 00:00:00'),
(52, 1, 2, '03028131147', 50, '2014-03-09 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `networks`
--

CREATE TABLE IF NOT EXISTS `networks` (
  `id` int(11) NOT NULL,
  `networkId` int(11) NOT NULL,
  `networkName` varchar(111) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `networks`
--

INSERT INTO `networks` (`id`, `networkId`, `networkName`) VALUES
(1, 1, 'Mobilink'),
(2, 3, 'Telenor'),
(3, 2, 'Ufone'),
(4, 4, 'Zong'),
(5, 5, 'Warid');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `current_account`
--
ALTER TABLE `current_account`
  ADD CONSTRAINT `current_account_ibfk_1` FOREIGN KEY (`login_id`) REFERENCES `customer_login` (`login_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
