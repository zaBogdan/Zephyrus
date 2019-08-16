-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 16, 2019 at 01:11 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zaEngine`
--

-- --------------------------------------------------------

--
-- Table structure for table `token_auth`
--

CREATE TABLE IF NOT EXISTS  `token_auth` (
  `id` int(11) NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `token` varchar(50) NOT NULL,
  `is_expired` tinyint(1) NOT NULL DEFAULT '0',
  `expiry_date` varchar(50) NOT NULL,
  `used_for` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `registration_date` varchar(20) NOT NULL,
  `confirmedStatus` tinyint(1) NOT NULL DEFAULT '0',
  `notifications` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `username`, `email`, `password`, `firstname`, `lastname`, `registration_date`, `confirmedStatus`, `notifications`) VALUES
(1, '4e83b3d8-536d-4180-8c6f-7f7752182fea', 'zaBogdan', 'bogdanzavadovschi17@gmail.com', '$2y$10$hy5X6kajk9yk8HDPlYmvruA94c0f4DybJInYS5vs/QHqeaoPUgqs.', 'Zavadovschi', 'Bogdan', '09-08-2019', 1, ''),
(2, 'b1e2be6b-bb07-4beb-a18a-45241baa4046', 'Tumojitekato', 'tumojitekato17@yahoo.ro', '$2y$10$3EnTJ/UJlpC7M1PHs//eGeB.VZfD4trWZj/UNFlIgTBacShV4n1QS', 'George', 'George', '09-08-2019', 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `token_auth`
--
ALTER TABLE `token_auth`
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
-- AUTO_INCREMENT for table `token_auth`
--
ALTER TABLE `token_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
