-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 30, 2026 at 02:28 PM
-- Server version: 10.4.34-MariaDB-log
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `howeyt_Products`
--

/*
This database contains two independent tables, one for tracking products and the other for tracking user
accounts. See SQL comments below for details of each table and field. 
*/

-- --------------------------------------------------------

--
-- Table structure for table `Accounts`
--

CREATE TABLE `Accounts` (
  `ID` int(11) NOT NULL COMMENT 'Account ID Primary Key.',
  `Username` char(255) NOT NULL COMMENT 'Account''s username. Maximum length of 255 char. Must be unique.',
  `EncryptedPassword` varchar(255) NOT NULL COMMENT 'Stores encrypted password hash for authentication.',
  `PermissionLevel` char(255) NOT NULL COMMENT 'Specifies the type of account for tracking permissions. Current values are ''User'' or ''Admin'', but more can be added in future as needed.',
  `Enabled` tinyint(1) NOT NULL COMMENT 'Boolean value for tracking whether the account is currently disabled/enabled.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table of user accounts, logins, their permission level, and current status.';

-- --------------------------------------------------------

--
-- Table structure for table `Items`
--

/*Note: The items table treats each option (item) as its own record. Options can then be grouped under a single product name.
  For example, a wireless keyboard and wired keyboard could both be their own row in the database with their own price and picture and so on, 
  but assigning the ProductName 'Keyboard' to both would indicate to the website that they are multiple options of a single product. 
  This allows for greater flexibility when presenting different options.*/

CREATE TABLE `Items` (
  `ID` int(11) NOT NULL COMMENT 'Primary ID used to track each item in the database.',
  `ProductName` varchar(255) NOT NULL COMMENT 'Product name. Used to group options/items (individual records) as a single product with multiple options.',
  `ItemName` char(255) NOT NULL COMMENT 'Name of individual items, which together can constitute the various options for a product.',
  `Description` varchar(10000) NOT NULL COMMENT 'Item description.',
  `Price` decimal(10,0) NOT NULL COMMENT 'Item price.',
  `Picture` varchar(500) DEFAULT NULL COMMENT 'Path to a picture of the item.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table for tracking individual items (options) in the database and their details.';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Accounts`
--
ALTER TABLE `Accounts`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `Items`
--
ALTER TABLE `Items`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Items`
--
ALTER TABLE `Items`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary ID used to track each item in the database.';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
