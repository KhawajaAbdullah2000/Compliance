-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2023 at 02:51 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `compliance`
--

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `name` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `sub-org` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zip_code` int(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `record_created_by` varchar(100) NOT NULL,
  `record_creation_date` date NOT NULL,
  `record_creation_time` time NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`name`, `type`, `sub-org`, `country`, `state`, `city`, `zip_code`, `address`, `record_created_by`, `record_creation_date`, `record_creation_time`, `status`, `created_at`, `updated_at`) VALUES
('gcrt', 'host', 'finance', 'Pakistan', 'Sindh', 'Karachi', 66, 'Fb area Karachi', 'Abdullah@gmail.com', '2023-07-05', '11:00:17', 'active', '2023-07-07 14:00:16', '2023-07-07 14:00:16');

-- --------------------------------------------------------

--
-- Table structure for table `privilege`
--

CREATE TABLE `privilege` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `privilege`
--

INSERT INTO `privilege` (`id`, `name`) VALUES
(1, 'Super User'),
(2, 'Primary Contact'),
(3, 'Secondary Contact'),
(4, 'Custom Role'),
(5, 'Root Admin');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_code` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `project_creation_date` date NOT NULL,
  `project_creation_time` time NOT NULL,
  `project_type` int(11) DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `project_owner` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `project_details`
--

CREATE TABLE `project_details` (
  `project_code` varchar(100) NOT NULL,
  `end-users_assigned` int(11) DEFAULT NULL,
  `project_last_changed_by` int(11) DEFAULT NULL,
  `status_last_changed_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `project_type`
--

CREATE TABLE `project_type` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `organizations_name` varchar(100) DEFAULT NULL,
  `organizations_sub-org` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zip_code` int(10) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `2FA` varchar(3) NOT NULL DEFAULT 'N',
  `privilege_id` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`name`,`sub-org`);

--
-- Indexes for table `privilege`
--
ALTER TABLE `privilege`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_code`),
  ADD KEY `user_email` (`user_email`),
  ADD KEY `project_type` (`project_type`);

--
-- Indexes for table `project_details`
--
ALTER TABLE `project_details`
  ADD UNIQUE KEY `project_code_2` (`project_code`),
  ADD KEY `project_code` (`project_code`),
  ADD KEY `project_code_3` (`project_code`),
  ADD KEY `end-users_assigned` (`end-users_assigned`),
  ADD KEY `project_last_changed_by` (`project_last_changed_by`,`status_last_changed_by`),
  ADD KEY `status_last_changed_by` (`status_last_changed_by`);

--
-- Indexes for table `project_type`
--
ALTER TABLE `project_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `organizations_sub-org` (`organizations_sub-org`),
  ADD KEY `organizations_name` (`organizations_name`),
  ADD KEY `organization_fk` (`organizations_name`,`organizations_sub-org`),
  ADD KEY `privilege_id` (`privilege_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `privilege`
--
ALTER TABLE `privilege`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `project_type`
--
ALTER TABLE `project_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `proj_type` FOREIGN KEY (`project_type`) REFERENCES `project_type` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `proj_user` FOREIGN KEY (`user_email`) REFERENCES `users` (`email`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `project_details`
--
ALTER TABLE `project_details`
  ADD CONSTRAINT `end_user` FOREIGN KEY (`end-users_assigned`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `proj_code` FOREIGN KEY (`project_code`) REFERENCES `projects` (`project_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proj_last_changed_fk` FOREIGN KEY (`project_last_changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `status_last_changed_by` FOREIGN KEY (`status_last_changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `Privilege_fk` FOREIGN KEY (`privilege_id`) REFERENCES `privilege` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `organization_fk` FOREIGN KEY (`organizations_name`,`organizations_sub-org`) REFERENCES `organizations` (`name`, `sub-org`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
