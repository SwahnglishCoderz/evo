-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2022 at 04:30 PM
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
-- Database: `evo`
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
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `link` varchar(100) NOT NULL,
  `title_tag` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `position` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `description`, `link`, `title_tag`, `icon`, `position`, `parent`, `section_id`) VALUES
(1, 'role', 'All roles available, to which users are assigned', '/role/index', 'Roles', 'fas fa-tasks', 1, NULL, 2),
(2, 'permissions', 'All available permissions, that can be assigned to specific roles.', '/permission/index', 'Permissions', 'fas fa-lock', 2, NULL, 2),
(4, 'all users', 'This the users index page', '/user/index', 'Users', 'fas fa-users', 1, NULL, 1),
(5, 'section management', 'All sections will be managed here', '/section/index', 'Sections', 'fas fa-chart-pie', 1, NULL, 3),
(6, 'menu management', 'All menus will be managed here', '/menu/index', 'Menus', 'fas fa-bars', 2, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `section_id` int(11) NOT NULL,
  `display_name` varchar(200) NOT NULL
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
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `added_by`) VALUES
(1, 'developer', 0),
(2, 'subscriber', 0);

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL DEFAULT 'Section description',
  `position` int(11) NOT NULL,
  `icon` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`id`, `name`, `description`, `position`, `icon`) VALUES
(1, 'users', 'Section description', 1, ''),
(2, 'utility', 'Section description', 99, ''),
(3, 'system', 'All the system configuration, including database setup, themes, emails, sms and so on. ', 98, ''),
(5, 'dfgg', 'srdttfg@ex.gg', 45, NULL),
(6, 'dfgg', 'srdttfg@ex.gg', 45, NULL),
(7, 'dfgg', 'srdttfg@ex.gg', 45, NULL),
(8, 'ddddddddd', 'sssssssssssssss', 4444, NULL),
(9, 'sample sec', 'lalalalaalalalalalalaaaaaaa', 435, NULL),
(10, 'dfjfj', 'hjghjgjghjgh', 5664, NULL);

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
(20, 'Jean Kyle', 'john@example.com', '$2y$10$MOb5mkUXsJ8DsRBJQwlPluMKk47/4LRvSQIkDmS/EZPF1zxW91OAO', '2022-01-17 14:46:31', '0000-00-00 00:00:00', NULL, 2, 1, NULL, NULL),
(21, 'Sarah John', 'sarah@example.com', '$2y$10$PwTaIneiKpKisoC.rl83L.uy4LlL2xh3DyQ64mIxJh6zPRNaZZ1gK', '2022-01-17 14:50:45', '0000-00-00 00:00:00', NULL, 2, 1, NULL, NULL),
(41, 'Sige Boy', 'sige@example.com', '$2y$10$Y15F6YiTnoIEsPN1cHqPNeZ4ix.zpgI88K7M/a9uJDSccSIYtJlDu', '2022-01-26 09:44:01', '0000-00-00 00:00:00', 'a7498c04a97d73d51c62f4e0c9a1728d3276a5ec12bf4f8a44afb9be96e97508', 2, 0, NULL, NULL),
(42, 'jsjsj hdask', 'jadf@drfjk.df', '$2y$10$91EJsYM8S5KqVe0nGqQgAuYCVRO/7KFgvxAq3noJzyOX2ZSQWayoW', '2022-01-27 15:02:16', '0000-00-00 00:00:00', '1d1c77a24ab23b044fba7bc2ebdd704866939a1a6cc6d9ab3b1b215e44f76d1e', 2, 0, NULL, NULL),
(43, 'JAhs Kdhja', 'dhj@ewj.sldk', '$2y$10$A.UPDImNDzULuGBVhQTAZ.Bzjc.WfG2TN2UVonpWCCMIiD/eZ9IAa', '2022-01-28 16:57:02', '0000-00-00 00:00:00', 'ffbc29b9145d2301e4219fa87024ffbecdd39a93ad2b4619eacbd14567322096', 2, 0, NULL, NULL),
(44, 'Jodhhn OSIH', 'osih@example.com', '$2y$10$e0EutoX9HcpY0ntmrU3tgO2WQxMhPEPMR6vZeNDr0wLsLZMsszvay', '2022-01-28 18:06:15', '0000-00-00 00:00:00', 'e237d9925e90c30f6b3f9f3497cb30f8477cd1addaa91ed0451f041149d28006', 2, 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `remembered_logins`
--
ALTER TABLE `remembered_logins`
  ADD PRIMARY KEY (`token_hash`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `section_id` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`);

--
-- Constraints for table `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `permission_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`);

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
