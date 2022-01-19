-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2022 at 06:44 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nnaire`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

CREATE TABLE `access` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `remembered_logins`
--

CREATE TABLE `remembered_logins` (
  `token_hash` varchar(64) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `color`) VALUES
(1, 'active', 'green'),
(2, 'inactive', 'red');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password_hash` varchar(256) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL,
  `activation_hash` varchar(256) DEFAULT NULL,
  `status_id` int(11) DEFAULT 2,
  `is_active` int(1) NOT NULL,
  `password_reset_hash` varchar(64) DEFAULT NULL,
  `password_reset_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `created_at`, `updated_at`, `activation_hash`, `status_id`, `is_active`, `password_reset_hash`, `password_reset_expires_at`) VALUES
(20, 'John Andrew', 'john@example.com', '$2y$10$MOb5mkUXsJ8DsRBJQwlPluMKk47/4LRvSQIkDmS/EZPF1zxW91OAO', '2022-01-17 14:46:31', '0000-00-00 00:00:00', NULL, 2, 1, NULL, NULL),
(21, 'Sarah Kishindo', 'sarah@example.com', '$2y$10$PwTaIneiKpKisoC.rl83L.uy4LlL2xh3DyQ64mIxJh6zPRNaZZ1gK', '2022-01-17 14:50:45', '0000-00-00 00:00:00', NULL, 2, 1, NULL, NULL),
(27, 'Michael Peter', 'mikey@example.com', '$2y$10$zbE/h8kn/AXj88DS7rZrX.XTy5UBM0peblTen5afkezy294bEHpoC', '2022-01-17 18:09:27', '0000-00-00 00:00:00', '97e8a40188afb5c324ab0669e3c3b2095aaf70df1c9234f04dd5f6ebbed162a1', 2, 0, NULL, NULL),
(28, 'Umrat Khator', 'umrat@example.com', '$2y$10$n6a9EZx.nLuTKznxJ4M4luGr0YQmb4EfeZC8TnUPCS6cMM9NB6EhW', '2022-01-17 18:10:45', '0000-00-00 00:00:00', 'b58eff88aecf79ab6e33326c5dc50d935b1ea3e8052e0c850e105c1feb1385a7', 2, 0, NULL, NULL),
(29, 'User Mpya', 'usermpya@example.com', '$2y$10$MWAMTDDY47fPXzM8ExB6Iu8wlnLb5YelF3k8QlkIN7/IeViOn3OeO', '2022-01-18 08:50:21', '0000-00-00 00:00:00', '41793f86c1c5b6f115ca636ae0d8450b5411ae94d8ec2d41dd9c7783587e12f0', 2, 0, NULL, NULL),
(30, 'User Mwingine', 'mwingine@example.com', '$2y$10$i3yveaBuRkJqqhT66mb/kuHoKSdAbMaK1GDYBTKJVSaHOvOR88O1m', '2022-01-18 13:08:01', '0000-00-00 00:00:00', '0a4b34c31f72c585ef2fbfc97457b0cf9511389dde5caf9b9c16a5f02970ad17', 2, 0, NULL, NULL),
(31, 'Hamisi Mauma', 'hamisi@example.com', '$2y$10$Cqi4rWCpa9UgcsRdig7CJuTB2DCrFDQFig60giBehG1l399Ic6zlC', '2022-01-18 13:12:29', '0000-00-00 00:00:00', '7811bd2462e6f84ffc0fccbd12515616c4d0544a9c46b97f455287c677b96b4a', 2, 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `remembered_logins`
--
ALTER TABLE `remembered_logins`
  ADD PRIMARY KEY (`token_hash`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `status_id` (`status_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access`
--
ALTER TABLE `access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `remembered_logins`
--
ALTER TABLE `remembered_logins`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `status_id` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
