-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: database:3306
-- Generation Time: Aug 03, 2020 at 11:50 AM
-- Server version: 5.7.31
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `serial` varchar(25) NOT NULL,
  `content` text NOT NULL,
  `posted_on` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `format` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`) VALUES
(1, 'accessAdmin', 'Allow access to the Administrative Dashboard.'),
(3, 'assignRole', 'You can give new roles to user (except Administrative ones).'),
(4, 'assignAdministrativeRole', 'You can give Administrative roles.'),
(5, 'revokeForeignToken', 'You can revoke other users tokens.'),
(6, 'warnUser', 'Give users a warning'),
(7, 'restrictUser', 'Restrict user access to the platform'),
(8, 'modifyForeignUser', 'Edit some criterias for an user or generate a new password.'),
(9, 'modifyForeignContent', 'Edit other users content'),
(10, 'modifyForeignProfile', 'Edit another user public profile page'),
(11, 'modifyForeignComments', 'Edit another user comment'),
(12, 'hidePosts', 'Hide public posts for moderation purpose'),
(13, 'hideProfile', 'Hide a public profile for moderation purpose'),
(14, 'editPosts', 'Edit another user post'),
(15, 'uploadFiles', 'Ability to upload Files on the platform'),
(16, 'uploadSize', 'Ability to upload bigger files'),
(17, 'readPosts', 'Ability to read posts'),
(18, 'createPosts', 'Ability to publish articles'),
(19, 'createGroups', 'Ability to create groups'),
(20, 'addComments', 'Ability to add comments on a post'),
(21, 'removeComments', 'Ability to remove comments from a post'),
(22, 'noValidationNeeded', 'Skip the moderation Queue, posts go public instantly');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `permissions_list` text NOT NULL,
  `decorations` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `permissions_list`, `decorations`) VALUES
(2, 'Guest', '[17]', '{\"colour\":\"#000\"}'),
(3, 'User', '[15,17,18,19,20,21]', '{\"colour\":\"#000\"}'),
(4, 'TrustedUser', '[22,15,17,18,19,20,21]', '{\"colour\":\"#000\"}'),
(5, 'Moderator', '[1,6,7,8,9,10,11,12,13,14,22,15,17,18,19,20,21]', '{\"colour\":\"#000\"}'),
(6, 'Administrator', '[3,5,6,1,7,8,9,10,11,12,13,14,22,15,17,18,19,20,21]', '{\"colour\":\"#000\"}'),
(7, 'Founder', '[4,3,5,6,1,7,8,9,10,11,12,13,14,22,15,17,18,19,20,21]', '{\"colour\":\"#000\"}');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

DROP TABLE IF EXISTS `tokens`;
CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `selector` varchar(255) NOT NULL,
  `validator` varchar(255) NOT NULL,
  `bounder` varchar(33) NOT NULL,
  `initialtime` varchar(50) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
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
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
