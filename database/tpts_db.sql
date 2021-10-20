-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2020 at 06:06 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tpts_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `pricing`
--

CREATE TABLE `pricing` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `ride_id` varchar(5) NOT NULL,
  `adult_price` float NOT NULL,
  `child_price` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pricing`
--

INSERT INTO `pricing` (`id`, `name`, `ride_id`, `adult_price`, `child_price`, `date_created`) VALUES
(1, 'Entrance', '0', 100, 80, '2020-11-30 09:27:45'),
(2, 'Ride All U Can', 'all', 500, 400, '2020-11-30 09:29:14'),
(3, 'Ride Ticket', '1', 150, 130, '2020-11-30 09:30:44'),
(4, 'Ride Ticket', '2', 150, 130, '2020-11-30 09:31:03');

-- --------------------------------------------------------

--
-- Table structure for table `rides`
--

CREATE TABLE `rides` (
  `id` int(30) NOT NULL,
  `ride` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rides`
--

INSERT INTO `rides` (`id`, `ride`, `description`, `date_created`) VALUES
(1, 'Ride 1', 'Sample Ride 1', '2020-11-30 09:03:47'),
(2, 'Ride 2', 'Sample Ride 2', '2020-11-30 09:04:16');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`) VALUES
(1, 'Theme Park Ticketing System', 'info@sample.comm', '+6948 8542 623', '2102  Caldwell Road, Rochester, New York, 14608', '');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_items`
--

CREATE TABLE `ticket_items` (
  `id` int(30) NOT NULL,
  `ticket_no` varchar(50) NOT NULL,
  `ride_id` varchar(5) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1=Adult,2=Child',
  `ticket_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket_items`
--

INSERT INTO `ticket_items` (`id`, `ticket_no`, `ride_id`, `type`, `ticket_id`, `date_created`) VALUES
(24, '464281140265', 'all', 2, 1, '2020-11-30 11:13:40'),
(25, '923853725245', 'all', 2, 1, '2020-11-30 11:13:40'),
(26, '745910660254', 'all', 2, 1, '2020-11-30 11:13:40'),
(27, '112398007983', '0', 2, 2, '2020-11-30 11:14:57'),
(28, '694424283587', '0', 2, 2, '2020-11-30 11:14:57'),
(29, '881923647970', '0', 2, 2, '2020-11-30 11:14:57'),
(30, '295200337001', '0', 2, 2, '2020-11-30 11:14:57'),
(31, '634386703173', '0', 2, 2, '2020-11-30 11:14:57'),
(32, '288052419703', '0', 2, 2, '2020-11-30 11:14:57'),
(33, '717927139551', '0', 2, 2, '2020-11-30 11:14:57'),
(34, '338361442836', '0', 2, 2, '2020-11-30 11:14:57'),
(35, '118710645494', '0', 2, 2, '2020-11-30 11:14:57'),
(36, '764495422944', '0', 2, 2, '2020-11-30 11:14:57'),
(37, '189977891424', '0', 2, 2, '2020-11-30 11:14:57'),
(38, '409072780821', '0', 2, 2, '2020-11-30 11:14:57'),
(39, '311889863954', '0', 2, 2, '2020-11-30 11:14:57'),
(40, '107156954800', '0', 2, 2, '2020-11-30 11:14:57'),
(41, '484347209065', '0', 2, 2, '2020-11-30 11:14:57'),
(42, '638469245972', '0', 2, 2, '2020-11-30 11:14:57'),
(43, '884095884722', '0', 2, 2, '2020-11-30 11:14:57'),
(44, '305644172130', '0', 2, 2, '2020-11-30 11:14:57'),
(45, '122929510520', '0', 2, 2, '2020-11-30 11:14:57'),
(46, '553555894924', '0', 2, 2, '2020-11-30 11:14:57'),
(49, '855647843645', 'all', 1, 3, '2020-11-30 13:03:55'),
(50, '524460479419', 'all', 1, 3, '2020-11-30 13:03:55'),
(51, '275259836175', 'all', 2, 3, '2020-11-30 13:03:55');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_list`
--

CREATE TABLE `ticket_list` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `no_adult` int(11) NOT NULL,
  `no_child` int(11) NOT NULL,
  `adult_price` float NOT NULL,
  `child_price` float NOT NULL,
  `pricing_id` int(30) NOT NULL,
  `amount` float NOT NULL,
  `tendered` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket_list`
--

INSERT INTO `ticket_list` (`id`, `name`, `no_adult`, `no_child`, `adult_price`, `child_price`, `pricing_id`, `amount`, `tendered`, `date_created`) VALUES
(1, 'John Smith', 5, 3, 500, 400, 2, 3700, 4000, '2020-11-30 11:03:27'),
(2, 'George Wilson', 10, 20, 100, 80, 1, 2600, 3000, '2020-11-30 11:03:56'),
(3, 'Claire Blake', 2, 1, 500, 400, 2, 1400, 2000, '2020-11-30 13:02:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1 = admin, 2 = staff',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `type`, `date_created`) VALUES
(1, 'Administrator', '', 'admin@admin.com', '0192023a7bbd73250516f069df18b500', 1, '2020-11-26 10:57:04'),
(2, 'John', 'Smith', 'jsmith@sample.com', '1254737c076cf867dc53d60a0364f38e', 2, '2020-11-30 12:00:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pricing`
--
ALTER TABLE `pricing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rides`
--
ALTER TABLE `rides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_items`
--
ALTER TABLE `ticket_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_list`
--
ALTER TABLE `ticket_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pricing`
--
ALTER TABLE `pricing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rides`
--
ALTER TABLE `rides`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ticket_items`
--
ALTER TABLE `ticket_items`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `ticket_list`
--
ALTER TABLE `ticket_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
