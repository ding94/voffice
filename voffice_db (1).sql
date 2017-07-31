-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2017 at 03:55 AM
-- Server version: 5.7.11
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voffice_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `userid` int(10) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `phone` int(32) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`userid`, `username`, `email`, `phone`, `message`) VALUES
(21, 'lin', 'lin@gmail.com', 123, '123'),
(23, 'aaa', 'aaa@gmail.com', 111, '111'),
(24, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(25, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(26, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(27, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(28, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(29, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(30, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(31, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(32, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(33, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(34, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(35, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(36, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(37, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(38, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(39, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(40, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(41, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(42, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(43, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(44, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(45, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(46, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(47, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(48, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(49, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(50, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(51, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(52, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(53, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(54, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(55, 'ssadw', 'soonws97@gmail.com', 16899999, 'dawda'),
(56, 'soon', 'soonws97@gmail.com', 163899762, 'dwadada'),
(57, 'soon', 'soonws97@gmail.com', 163899762, 'dwadada'),
(58, 'soon', 'byebye_1997@hotmail.com', 163899762, 'dwadada'),
(59, 'soon', 'byebye_1997@hotmail.com', 163899762, 'dwadada');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1500950095),
('m140506_102106_rbac_init', 1500950104);

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `price(RM)` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`id`, `type`, `price(RM)`) VALUES
(1, 'platinum', '100'),
(2, 'silver', '200'),
(3, 'gold', '300');

-- --------------------------------------------------------

--
-- Table structure for table `parcel_detail`
--

CREATE TABLE `parcel_detail` (
  `parid` int(20) NOT NULL,
  `sender` text NOT NULL,
  `signer` text NOT NULL,
  `signer_ic` text NOT NULL,
  `address1` text,
  `address2` text,
  `address3` text,
  `postcode` int(20) DEFAULT NULL,
  `city` text,
  `state` text,
  `country` text,
  `weight` decimal(10,3) NOT NULL,
  `size` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parcel_detail`
--

INSERT INTO `parcel_detail` (`parid`, `sender`, `signer`, `signer_ic`, `address1`, `address2`, `address3`, `postcode`, `city`, `state`, `country`, `weight`, `size`) VALUES
(0, 'Goh Ding Wei', 'Soon Wei Sheng', '970906019999', 'G17, Jalan Bukit Batu,', 'Bukit Batu, 81020 Kulai,', 'Johor, Malaysia', 81020, 'Kulai', 'Johor', 'Malaysia', '20.000', 'XXL');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `username` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `password_hash` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `password_reset_token` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(8, 'aaa', 'koKSJ59GhrrbBZbxFLlaTrGHXpiaIxxQ', '$2y$13$S82OoQ5VX5xIJ5WZKP2Vr.3Rquvpao0xzgn7k/AaUO3FGYL6l3lOi', NULL, 'aaa@hotmail.com', 10, 1497942758, 1497942758),
(9, 'bbb', 'xbgjoKQf0dPN7PMj6sp2MWwqKkcz4mlB', '$2y$13$f5ydgkHTJyGdVJeklSlTm.6Gc3JIxnw7gTGvd6/6Uy9lRjhhzPoVu', NULL, 'bbb@hotmail.com', 10, 1498035547, 1498035547),
(10, 'ccc', 'sGvYHcJTGSkG0Z2yksI3uWbEjsy6Osc4', '$2y$13$8K/vfUXwPehyptgqhhAo0OQ5zxhRYlAqgvlLmLcIR4B64is/.e7z.', NULL, 'ccc@hotmail.com', 10, 1498035577, 1498035577),
(25, 'soon', 'M6oZoe23v--IlgVRpD4TfhxrEETGK_Pw', '$2y$13$0wmRKGRIXCqh3lxoEndyNOlcFPd44rH/DY214XBU0RioCKo4HXGH6', NULL, 'soonws97@gmail.com', 10, 1499915809, 1500624707);

-- --------------------------------------------------------

--
-- Table structure for table `user_balance`
--

CREATE TABLE `user_balance` (
  `uid` int(11) NOT NULL,
  `balance` int(20) NOT NULL,
  `positive` int(20) NOT NULL,
  `negative` int(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_contact`
--

CREATE TABLE `user_contact` (
  `uid` int(11) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `address3` text NOT NULL,
  `postcode` int(20) NOT NULL,
  `state` text NOT NULL,
  `city` text NOT NULL,
  `country` text NOT NULL,
  `phonenumber` int(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `uid` int(11) NOT NULL,
  `Fname` varchar(50) NOT NULL,
  `Lname` varchar(50) NOT NULL,
  `gender` text NOT NULL,
  `DOB` date NOT NULL,
  `cmpyname` text NOT NULL,
  `cmpycategory` text NOT NULL,
  `IC_passport` varchar(30) NOT NULL,
  `phonenumber` int(20) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `address3` text NOT NULL,
  `postcode` int(20) NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `country` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`uid`, `Fname`, `Lname`, `gender`, `DOB`, `cmpyname`, `cmpycategory`, `IC_passport`, `phonenumber`, `address1`, `address2`, `address3`, `postcode`, `city`, `state`, `country`) VALUES
(8, 'Soon', 'Wei Sheng', 'Male', '1997-09-06', 'Soon', 'IT', '909090909090', 144444444, 'G17', 'Bukit Batu', '', 81020, 'Kulai', 'Johor', 'Malaysia'),
(10, 'Chow', 'Fei', 'MAle', '2017-07-23', 'Chow Jay Lun', 'Multimedia', '128902148902', 17777777, 'd21dew', 'dwadw', 'dwq421', 80100, 'SomeWhere', 'SomeState', 'Malaysia'),
(9, 'Goh', 'Ding Wei', 'Male', '2017-07-24', 'God Goh', 'Marketing', '214213214215', 166666666, 'wadwaf', 'ewq', '21rwaa', 81000, 'Johor Bahru', 'Johor', 'Malaysia');

-- --------------------------------------------------------

--
-- Table structure for table `user_package`
--

CREATE TABLE `user_package` (
  `uid` int(11) NOT NULL,
  `packid` int(11) NOT NULL,
  `code` text NOT NULL,
  `create_time` int(11) NOT NULL,
  `end_period` datetime NOT NULL,
  `sub_period` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_parcel`
--

CREATE TABLE `user_parcel` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `arrived_time` date DEFAULT NULL,
  `user_notice` int(11) NOT NULL DEFAULT '0',
  `parcel_sent` int(11) DEFAULT '0',
  `sent_time` date DEFAULT NULL,
  `received_time` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_parcel`
--

INSERT INTO `user_parcel` (`id`, `uid`, `arrived_time`, `user_notice`, `parcel_sent`, `sent_time`, `received_time`) VALUES
(1, 8, '2017-07-24', 0, 0, '2017-07-26', '2017-07-29 04:15:55'),
(2, 9, '2017-07-24', 0, 0, '2017-07-26', '2017-07-28 05:44:03'),
(3, 8, '2017-07-24', 0, 0, '2017-07-26', '2017-07-27 05:48:15'),
(12, 8, '2017-07-31', 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vcompany_address`
--

CREATE TABLE `vcompany_address` (
  `id` int(11) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `address3` text NOT NULL,
  `postcode` int(20) NOT NULL,
  `state` text NOT NULL,
  `city` text NOT NULL,
  `country` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `auth_key` (`auth_key`),
  ADD UNIQUE KEY `password_hash` (`password_hash`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_parcel`
--
ALTER TABLE `user_parcel`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `userid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `user_parcel`
--
ALTER TABLE `user_parcel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
