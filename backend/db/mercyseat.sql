-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 30, 2018 at 11:45 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mercyseat`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `date_created`, `date_modified`) VALUES
(1, 'admin', '$2y$10$AQxF4/8yMywMDrPD5RL5s.wnJ/drvYDFL42YTPaUedApXXEp8MrD2', '2018-07-29 17:26:34', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(255) NOT NULL,
  `title` varchar(12) NOT NULL,
  `first_name` varchar(15) NOT NULL,
  `last_name` varchar(15) NOT NULL,
  `other_name` varchar(15) NOT NULL,
  `date_of_birth` date NOT NULL,
  `street_address` varchar(50) NOT NULL,
  `apt_no` int(10) NOT NULL,
  `city` varchar(10) NOT NULL,
  `zip` int(10) NOT NULL,
  `state` varchar(15) NOT NULL,
  `age_group` varchar(15) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `marital_status` varchar(15) NOT NULL,
  `email` varchar(25) NOT NULL,
  `isMember` tinyint(1) NOT NULL,
  `informative` varchar(25) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `title`, `first_name`, `last_name`, `other_name`, `date_of_birth`, `street_address`, `apt_no`, `city`, `zip`, `state`, `age_group`, `sex`, `phone_no`, `marital_status`, `email`, `isMember`, `informative`, `date_created`, `date_modified`) VALUES
(2, 'Mr', 'Joshua', 'Musa', 'Gideon Bashir', '2018-07-01', 'Prince bisi cresent, new yidi road.', 25, 'kw', 33, 'borno', '20-29', 'female', '0898983', 'married', 'musa.joshua@lmu.edu.ng', 0, 'google', '2018-07-30 20:35:17', '2018-07-30 21:27:43'),
(3, 'Mr', 'Joshua', 'Musa', 'Gideon Bashir', '2018-07-01', 'Prince bisi cresent, new yidi road.', 25, 'ilorin', 28222, 'kwara', '13-19', 'male', '09090512150', 'single', 'gidijosh@gmail.com', 1, 'google', '2018-07-30 20:36:16', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
