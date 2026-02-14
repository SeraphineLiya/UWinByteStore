-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 14, 2026 at 04:01 PM
-- Server version: 10.4.34-MariaDB-log
-- PHP Version: 8.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `COMP3340_Products`
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
  `AccountStatus` varchar(155) NOT NULL DEFAULT 'Pending' COMMENT 'Current account permission level (acts as status too). Values are Pending, Blocked, or Admin.'
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
  `Price` decimal(10,2) NOT NULL COMMENT 'Item price.',
  `Picture` varchar(500) DEFAULT NULL COMMENT 'Path to a picture of the item.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='TTable for tracking individual items (options) in the database and their details.';

--
-- Dumping data for table `Items`
--

INSERT INTO `Items` (`ID`, `ProductName`, `ItemName`, `Description`, `Price`, `Picture`) VALUES
(1, 'Keyboard', 'Wired', 'USB Wired Keyboard with easy to use connection. Simply plug in and you are good to go.', 39.99, 'images/wiredkeyboard.jpg'),
(3, 'Keyboard', 'Wireless', 'Wireless keyboard that connects to your computer through Bluetooth and/or WiFi. No troublesome USB cable required.', 85.99, 'images/wirelesskeyboard.jpg'),
(4, 'USB Hub Adapter', '4 in 1', 'Expand the laptop ports available to you with a USB-C Hub Adapter. Provides extra ports for both USB and HDMI.', 45.99, 'images/USB-C4in1.jpg'),
(6, 'USB Hub Adapter', '6 in 1', 'Expand the number and types of laptop ports available to you with this multi-port adapter. Provides 6 new slots, including those for both USB-A and USB-C cables.', 65.99, 'images/USB-C6in1.jpg'),
(7, 'Smart LED Light', 'Adjustable White Light', 'A smart LED desk lamp with multiple colour temperatures that you set depending on the time of day and your mood. Choose from a warm 2700K up to a bright 5700K, or anything in between.', 50.99, 'images/smartLED1.jpg'),
(8, 'Smart LED Light', 'RGB+White', 'Go beyond normal home lighting with an RGB+White lightbulb, with remote control through an app. Set the lightbulb to emit white light normally, or change it to any other colour when it is time to party.', 60.99, 'smartlightbulb.jpg'),
(9, 'Portable SSD Drive', '500 GB', 'Expand your storage with a 500 GB portable SSD drive. Perfect for files that you need to keep but don\'t need to access often. Look for Read speeds in excess of 1000 MB/s if possible.', 110.99, 'images/ssd500.jpg'),
(10, 'Portable SSD Drive', '1 TB', 'If you need lots of extra storage, a 1 TB portable SSD may be what you are looking for. Perfect for storing large files or huge amounts of small ones.', 180.99, 'images/ssd1tb.jpg'),
(11, 'Computer Mouse', 'Wired', 'A mouse is a necessity for convenient and ergonomic computer work. A wired mouse is a cost-effective option that also eliminates the hassle of changing batteries. ', 35.99, 'images/wiredmouse.jpg'),
(12, 'Computer Mouse', 'Wireless', 'With a wireless mouse, you can comfortably use your computer without worrying about tangled cables. Options with adjustable DPI provide additional customizability.', 50.99, 'images/wirelessmouse.jpg'),
(13, 'Cooling Fan', 'Single Fan', 'Use a computer cooling fan to increase ventilation and heat dissipation. By increasing your computer\'s ability to vent waste heat, you can indirectly increase the computer\'s performance at high temperatures.', 39.99, 'images/singlefan.jpg'),
(14, 'Cooling Fan', 'Triple Fans', 'For larger computers, a triple cooling fan is perfect for high-performance ventilation. Increase your computer\'s performance at high temperatures by increasing heat dissipation.', 89.99, 'images/triplefan.jpg'),
(15, 'HD Webcam', '1080p at 60 FPS', 'Get crisp video with a 1080p HD webcam. More than sufficient for most video calls.', 79.99, 'images/webcam1080.jpg'),
(16, 'HD Webcam', '4K at 30 FPS', 'For crystal clear web conferencing, a 4K webcam may be what you want. Providing crisp UHD video at 30 frames per second, a 4K webcam is a high-end option for ultra-clear video recording.', 179.99, 'images/webcam4k.jpg'),
(17, 'Monitor Stand', 'Fixed', 'Sturdy metal monitor stand can improve your viewing position and limit the amount of time spent looking at an angle. ', 59.99, 'images/fixedstand.jpg'),
(18, 'Monitor Stand', 'Adjustable', 'Height adjustable ergonomic monitor.', 79.99, 'images/standAdjustable.jpg'),
(19, 'Portable Power Bank', '10,000 mAh', 'Portable fast charging battery with the capacity for at least 1 full charge on average.', 30.99, 'images/1charge.jpg'),
(20, 'Portable Power Bank', '20,000mAh', 'High-capacity multi-device charging power.', 50.99, 'images/3charges.jpg'),
(21, 'Smart Watch', 'Silicon Sports Band', 'Smart watch with a durable silicon sports band.', 50.99, 'images/silicon.jpg'),
(22, 'Smart Watch', 'Leather Band', 'Smart watch with a premium and professional looking leather wrist band.', 70.99, 'images/leather.jpg'),
(23, 'Wifi Router', 'Small-Medium Range', 'Stable Wi-Fi coverage for small spaces (1-2 rooms).', 70.99, 'images/wifismall.jpg'),
(24, 'Wifi Router', 'Medium-Large Range', 'Extended high- range wireless coverage (entire floor).', 90.99, 'images/wifilarge.jpg'),
(25, 'Drawing Tablet', 'Small', 'Compact pressure- sensitive digital drawing surface.', 70.99, 'images/smalltablet.jpg'),
(26, 'Drawing Tablet', 'Medium', 'Larger precision drawing workspace.', 120.99, 'images/mediumtablet.jpg'),
(28, 'Laptop Sleeve', '17\"', 'Extra-capacity padded laptop storage.', 25.99, 'images/sleeve17.jpg'),
(29, 'Sports Camera', 'Compact', 'Waterproof action recording with wide-angle lens.', 299.99, 'images/smallsportscam.jpg'),
(30, 'Sports Camera', '360 Degree', '360-degree immersive video capture.', 399.99, 'images/camera360.jpg'),
(31, 'Hard Disk', 'HDD', 'Portable high-capacity data backup.', 159.99, 'images/hdd.jpg'),
(32, 'Hard Disk', 'HDD Docking Station', 'Multi-drive connection and transfer support.', 100.99, 'images/hddDock.jpg'),
(33, 'Wireless Charging', 'Single device', 'Single device wireless charging 20W.', 39.99, 'images/wirelesscharge1.jpg'),
(34, 'Wireless Charging', 'Multi device', 'Multiple device simultaneous charging device 30W.', 59.99, 'images/wirelesschargemulti.jpg'),
(35, 'Ethernet Network Swtich', '10 Port', 'Connects multiple wired network devices.', 99.99, 'images/10port.jpg'),
(36, 'Ethernet Network Swtich', '5 Port', 'Compact wired network expansion.', 49.99, 'images/ethernet5port.jpg'),
(37, 'Speaker', 'Gold', 'Portable Bluetooth speaker with deep bass.', 229.99, 'images/speakerSilver.jpg'),
(38, 'Speaker', 'Silver', 'High-power speaker with enhanced sound output.', 35.99, 'images/speakerSilver.jpg'),
(39, 'Projector', 'Modern-Style', 'Battery- powered portable video projection.', 100.99, 'images/modernprojector.jpg'),
(40, 'Projector', 'Retro-Style', 'Stylish projector with HD display output.', 300.99, 'images/retroprojector.jpg'),
(41, 'Headphone', 'Wireless', 'Bluetooth audio with long battery life 20+ hours.', 89.99, 'images/wirelessheadphone.jpg'),
(42, 'Headphone', 'Wired with Microphone', 'Wired audio with built-in microphone.', 49.99, 'images/wiredheadphonewithmic.jpg'),
(43, 'Laptop Sleeve', '15\"', 'Protective storage for 15-inch laptops.\r\n', 20.99, 'images/sleeve15.jpg\r\n');

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary ID used to track each item in the database.', AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
