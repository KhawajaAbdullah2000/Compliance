-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2024 at 04:28 PM
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
-- Database: `final_audit_compliance`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iso_risk_treatment`
--

CREATE TABLE `iso_risk_treatment` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `control_num` varchar(100) DEFAULT NULL,
  `applicability` varchar(16) NOT NULL,
  `asset_value` int(11) NOT NULL,
  `control_compliance` int(11) DEFAULT NULL,
  `vulnerability` int(11) DEFAULT NULL,
  `threat` int(11) DEFAULT NULL,
  `risk_level` decimal(11,5) DEFAULT NULL,
  `residual_risk_treatment` varchar(100) DEFAULT NULL,
  `treatment_action` varchar(1000) DEFAULT NULL,
  `treatment_target_date` date DEFAULT NULL,
  `treatment_comp_date` date DEFAULT NULL,
  `responsibility_for_treatment` bigint(20) UNSIGNED DEFAULT NULL,
  `acceptance_justification` varchar(300) DEFAULT NULL,
  `acceptance_target_date` date DEFAULT NULL,
  `acceptance_actual_date` date DEFAULT NULL,
  `acceptance_proposed_responsibility` bigint(20) UNSIGNED DEFAULT NULL,
  `accepted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `iso_risk_treatment`
--

INSERT INTO `iso_risk_treatment` (`assessment_id`, `project_id`, `asset_id`, `control_num`, `applicability`, `asset_value`, `control_compliance`, `vulnerability`, `threat`, `risk_level`, `residual_risk_treatment`, `treatment_action`, `treatment_target_date`, `treatment_comp_date`, `responsibility_for_treatment`, `acceptance_justification`, `acceptance_target_date`, `acceptance_actual_date`, `acceptance_proposed_responsibility`, `accepted_by`, `last_edited_by`, `last_edited_at`) VALUES
(1, 27, 69, '5.1', 'yes', 1, 90, 10, 33, '0.03300', 'retain and accept risk', NULL, NULL, NULL, NULL, 'justificaiton1', '2024-04-27', '2024-04-26', 94, 95, 94, '2024-04-25 18:41:12'),
(2, 27, 69, '5.2', 'yes', 1, 66, 34, 88, '0.29920', 'avoid risk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 94, '2024-04-25 18:44:36'),
(3, 27, 58, '5.3', 'yes', 10, 95, 5, 55, '0.27500', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 94, '2024-04-25 18:50:45'),
(4, 27, 58, '6.2', 'yes', 10, 55, 45, 66, '2.97000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 94, '2024-04-25 19:25:43');

-- --------------------------------------------------------

--
-- Table structure for table `iso_sec2_4_a5`
--

CREATE TABLE `iso_sec2_4_a5` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `asset_id` int(11) NOT NULL,
  `control_num` varchar(100) NOT NULL,
  `justification` varchar(3000) DEFAULT NULL,
  `ref_of_risk` varchar(3000) DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `iso_sec2_4_a5`
--

INSERT INTO `iso_sec2_4_a5` (`assessment_id`, `project_id`, `asset_id`, `control_num`, `justification`, `ref_of_risk`, `last_edited_by`, `last_edited_at`) VALUES
(43, 26, 41, '5.1', NULL, 'Referenc 1', 55, '2024-04-22 19:02:24');

-- --------------------------------------------------------

--
-- Table structure for table `iso_sec2_4_a6`
--

CREATE TABLE `iso_sec2_4_a6` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `asset_id` int(11) NOT NULL,
  `control_num` varchar(100) NOT NULL,
  `justification` varchar(3000) DEFAULT NULL,
  `ref_of_risk` varchar(3000) DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `iso_sec2_4_a7`
--

CREATE TABLE `iso_sec2_4_a7` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `asset_id` int(11) NOT NULL,
  `control_num` varchar(100) NOT NULL,
  `justification` varchar(3000) DEFAULT NULL,
  `ref_of_risk` varchar(3000) DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `iso_sec2_4_a8`
--

CREATE TABLE `iso_sec2_4_a8` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `asset_id` int(11) NOT NULL,
  `control_num` varchar(100) NOT NULL,
  `justification` varchar(3000) DEFAULT NULL,
  `ref_of_risk` varchar(3000) DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `iso_sec_2_1`
--

CREATE TABLE `iso_sec_2_1` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `g_name` varchar(300) DEFAULT NULL,
  `name` varchar(300) DEFAULT NULL,
  `c_name` varchar(300) DEFAULT NULL,
  `owner_dept` varchar(300) NOT NULL,
  `physical_loc` varchar(300) NOT NULL,
  `logical_loc` varchar(300) NOT NULL,
  `s_name` varchar(300) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `iso_sec_2_1`
--

INSERT INTO `iso_sec_2_1` (`assessment_id`, `project_id`, `g_name`, `name`, `c_name`, `owner_dept`, `physical_loc`, `logical_loc`, `s_name`, `last_edited_by`, `last_edited_at`) VALUES
(28, 20, 'Tapsys multinet dc', 'payment system-multinet dc', 'payment application-multinet dc', 'IT', 'Karachi', 'Multinet Karachi network', 'Tapsys PGW service-multinet karachi', 55, '2024-03-21 18:18:46'),
(29, 20, 'Tapsys multinet dc', 'payment system-multinet dc', 'Database Application-multinet dc', 'IT', 'Karachi', 'Multinet Karachi network', 'Tapsys PGW service-multinet karachi', 55, '2024-01-18 17:40:19'),
(30, 20, 'Tapsys jazz dc', 'payment system-jazz dc', 'payment application-jazz dc', 'IT', 'Ibd', 'jazz Ibd network', 'Tapsys PGW service-jazz Ibd', 55, '2024-01-18 17:40:19'),
(31, 20, 'Tapsys jazz dc', 'payment system-jazz dc', 'Database Application-jazz dc', 'IT', 'Ibd', 'jazz Ibd network', 'Tapsys PGW service-jazz Ibd', 55, '2024-01-18 17:40:19'),
(32, 19, 'grpq', NULL, 'asa', 'sdd', 'dssd', 'dssdd', 'dsd', 55, '2024-03-21 15:25:24'),
(35, 19, 'excel_g1', 'excel_name1', 'excel_c1', 'excel_owner1', 'excel_pl1', 'excel_ll1', 'excel_s1', 55, '2024-03-21 15:19:34'),
(36, 19, 'excel_g2', 'excel_name2', NULL, 'excel_owner2', 'excel_pl2', 'excel_ll2', 'excel_s2', 55, '2024-03-21 15:19:52'),
(37, 24, 'asset_g1', 'asset1', 'asset_c1', 'asset_owner1', 'asset_physical1', 'asset_logical1', 'asset_service1', 55, '2024-03-22 19:24:51'),
(39, 25, 'AssetG1', 'Asset1', 'AssetC1', 'AssetO1', 'AssetPhy1', 'AssetLog1', 'AssetSer1', 55, '2024-04-19 17:15:25'),
(41, 26, 'AssetG1', 'Asset1', 'Asset-C1', 'AssetO1', 'AssetPhy1', 'AssetLog1', 'AssetS1', 55, '2024-04-19 19:41:38'),
(58, 27, 'AssetG1', 'Asset1', 'AssetC1', 'Owner1', 'Physical1', 'Logical1', 'Service1', 94, '2024-04-25 18:48:56'),
(59, 27, 'AssetG1', 'Asset1', 'AssetC3', 'Owner3', 'Physical3', 'Logical3', 'Service3', 95, '2024-04-24 19:29:07'),
(60, 27, 'AssetG1', 'Asset1', 'AssetC2', 'Owner4', 'physical4', 'Logical4', 'Service4', 95, '2024-04-24 19:29:07'),
(65, 28, 'AssetG1', 'Asset1', 'AssetC1', 'Owner1', 'Physical', 'Logical1', 'Service1', 94, '2024-04-24 19:42:29'),
(66, 27, 'AssetG1', 'Asset1', 'AssetC4', 'Owner1', 'Physical', 'Logical1', 'Service1', 94, '2024-04-24 19:43:07'),
(67, 27, 'AssetG1', 'Asset 6', 'AssetC1', 'asset_owner1', 'AssetPhy1', 'AssetLog1', 'Service1', 94, '2024-04-24 20:08:07'),
(68, 27, 'AssetG1', 'Asset7', 'AssetC1', 'AssetO1', 'AssetPhy1', 'AssetLog1', 'Service1', 94, '2024-04-25 16:09:53'),
(69, 27, 'AssetG2', 'Asset1', 'AssetC1', 'AssetO1', 'AssetPhy1', 'AssetLog1', 'AssetS1', 94, '2024-04-25 16:54:17');

-- --------------------------------------------------------

--
-- Table structure for table `iso_sec_2_2`
--

CREATE TABLE `iso_sec_2_2` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `title_num` int(11) DEFAULT NULL,
  `sub_req` varchar(100) DEFAULT NULL,
  `comp_status` varchar(10) DEFAULT NULL,
  `comments` varchar(3000) DEFAULT NULL,
  `attachment` varchar(1000) DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `iso_sec_2_2`
--

INSERT INTO `iso_sec_2_2` (`assessment_id`, `project_id`, `title_num`, `sub_req`, `comp_status`, `comments`, `attachment`, `last_edited_by`, `last_edited_at`) VALUES
(12, 17, 4, '4.3-a', 'no', NULL, '1700656156.xlsx', 57, '2023-11-22 17:29:16'),
(13, 17, 5, '5.1-a', 'no', NULL, NULL, 57, '2023-11-22 17:36:14'),
(19, 17, 4, '4.2-c', 'no', 'hhg', '1700657794.jpg', 57, '2023-11-22 17:56:40'),
(20, 19, 4, '4.1-a', 'yes', NULL, NULL, 57, '2023-11-23 18:45:26'),
(21, 19, 6, '6.1.1-a', 'partial', 'hjjjhhj', NULL, 57, '2023-11-23 18:59:26'),
(22, 19, 10, '10.1', 'yes', NULL, NULL, 57, '2023-11-23 19:12:57'),
(23, 19, 4, '4.2-a', 'yes', NULL, NULL, 55, '2023-11-24 17:55:49'),
(24, 20, 4, '4.1-a', 'yes', 'dffd', NULL, 55, '2024-03-21 17:22:38'),
(25, 20, 5, '5.1-a', 'yes', 'fdfddfdd', NULL, 55, '2023-12-13 16:44:12'),
(26, 27, 5, '5.1-a', 'yes', NULL, NULL, 94, '2024-04-23 18:59:56'),
(27, 27, 8, '8.1-a', 'no', 'comment1', '1713882401.pdf', 94, '2024-04-23 19:26:41'),
(28, 27, 8, '8.1-c', 'yes', 'comment2', '1713882429.xlsx', 94, '2024-04-23 19:29:11'),
(29, 27, 4, '4.1-a', 'yes', 'comment3 comment 4', '1714040011.xlsx', 94, '2024-04-25 16:24:17');

-- --------------------------------------------------------

--
-- Table structure for table `iso_sec_2_3`
--

CREATE TABLE `iso_sec_2_3` (
  `sec2_3_key` int(11) NOT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `asset_value` int(11) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `iso_sec_2_3_1`
--

CREATE TABLE `iso_sec_2_3_1` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `control_num` varchar(100) DEFAULT NULL,
  `applicability` varchar(16) NOT NULL,
  `asset_value` int(11) NOT NULL,
  `control_compliance` int(11) DEFAULT NULL,
  `vulnerability` int(11) DEFAULT NULL,
  `threat` int(11) DEFAULT NULL,
  `risk_level` decimal(11,5) DEFAULT NULL,
  `residual_risk_treatment` varchar(100) DEFAULT NULL,
  `treatment_action` varchar(1000) DEFAULT NULL,
  `treatment_target_date` date DEFAULT NULL,
  `treatment_comp_date` date DEFAULT NULL,
  `responsibility_for_treatment` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `iso_sec_2_3_1`
--

INSERT INTO `iso_sec_2_3_1` (`assessment_id`, `project_id`, `asset_id`, `control_num`, `applicability`, `asset_value`, `control_compliance`, `vulnerability`, `threat`, `risk_level`, `residual_risk_treatment`, `treatment_action`, `treatment_target_date`, `treatment_comp_date`, `responsibility_for_treatment`, `last_edited_by`, `last_edited_at`) VALUES
(139, 20, 28, '5.2', 'yes', 10, 95, 5, 100, '0.50000', 'avoid risk', 'action dds', '2024-03-13', '2024-03-28', 57, 55, '2024-03-23 09:52:06'),
(140, 20, 28, '5.3', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:21:27'),
(141, 20, 28, '5.4', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:21:27'),
(142, 20, 28, '5.5', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:21:27'),
(143, 20, 28, '5.6', 'yes', 10, 50, 50, 100, '5.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:21:27'),
(144, 20, 28, '5.7', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:21:27'),
(145, 20, 28, '5.8', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:21:27'),
(146, 20, 28, '5.9', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:21:27'),
(147, 20, 28, '5.10', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:21:27'),
(148, 20, 28, '5.11', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:21:27'),
(149, 20, 28, '5.12', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:21:27'),
(150, 20, 28, '5.13', 'yes', 10, 95, 5, 100, '0.50000', 'share risk', 'treatment13', '2024-03-21', '2024-03-15', 57, 55, '2024-03-23 16:19:15'),
(151, 20, 28, '5.14', 'yes', 10, 50, 50, 100, '5.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:21:27'),
(152, 20, 28, '5.15', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:21:27'),
(153, 20, 28, '5.16', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:21:27'),
(154, 20, 28, '5.17', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:21:27'),
(155, 20, 28, '5.18', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:21:27'),
(156, 20, 28, '5.19', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:21:27'),
(157, 20, 28, '5.20', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:21:27'),
(158, 20, 28, '5.21', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:30:29'),
(159, 20, 28, '5.22', 'yes', 10, 50, 50, 100, '5.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:30:29'),
(160, 20, 28, '5.23', 'yes', 10, 50, 50, 100, '5.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:40:19'),
(161, 20, 28, '5.24', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:40:19'),
(162, 20, 28, '5.25', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:40:19'),
(164, 20, 28, '5.27', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:40:19'),
(165, 20, 28, '5.28', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:40:19'),
(166, 20, 28, '5.29', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:40:19'),
(167, 20, 28, '5.30', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:40:19'),
(168, 20, 28, '5.31', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:40:19'),
(169, 20, 28, '5.32', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:40:19'),
(170, 20, 28, '5.33', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:40:19'),
(171, 20, 28, '5.34', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:40:19'),
(172, 20, 28, '5.35', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:40:19'),
(173, 20, 28, '5.36', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:40:19'),
(174, 20, 28, '5.37', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:40:19'),
(175, 20, 28, '6.1', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(176, 20, 28, '6.2', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(177, 20, 28, '6.3', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(178, 20, 28, '6.4', 'yes', 10, 50, 50, 100, '5.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(179, 20, 28, '6.5', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(180, 20, 28, '6.6', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(181, 20, 28, '6.7', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(182, 20, 28, '6.8', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(183, 20, 28, '7.1', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(184, 20, 28, '7.2', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(185, 20, 28, '7.3', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(186, 20, 28, '7.4', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(187, 20, 28, '7.5', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(188, 20, 28, '7.6', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(189, 20, 28, '7.7', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(190, 20, 28, '7.8', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(191, 20, 28, '7.9', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(192, 20, 28, '7.10', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(193, 20, 28, '7.11', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(194, 20, 28, '7.12', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(195, 20, 28, '7.13', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(196, 20, 28, '7.14', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-01-19 18:43:06'),
(197, 20, 28, '8.1', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:25:28'),
(198, 20, 28, '5.26', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:26:27'),
(199, 20, 28, '8.2', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(200, 20, 28, '8.3', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(201, 20, 28, '8.4', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(202, 20, 28, '8.5', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(203, 20, 28, '8.6', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(204, 20, 28, '8.7', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(205, 20, 28, '8.8', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(206, 20, 28, '8.9', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(207, 20, 28, '8.10', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(208, 20, 28, '8.11', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(209, 20, 28, '8.12', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(210, 20, 28, '8.13', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(211, 20, 28, '8.14', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(212, 20, 28, '8.15', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(213, 20, 28, '8.16', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(214, 20, 28, '8.17', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(215, 20, 28, '8.18', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(216, 20, 28, '8.19', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(217, 20, 28, '8.20', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(218, 20, 28, '8.21', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(219, 20, 28, '8.22', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(220, 20, 28, '8.23', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(221, 20, 28, '8.24', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(222, 20, 28, '8.25', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(223, 20, 28, '8.26', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(224, 20, 28, '8.27', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:30:07'),
(225, 20, 28, '8.28', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:31:11'),
(226, 20, 28, '8.29', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:31:11'),
(229, 20, 28, '8.32', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:31:11'),
(230, 20, 28, '8.33', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:31:11'),
(231, 20, 28, '8.34', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 14:32:08'),
(237, 20, 28, '8.30', 'no', 10, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 15:21:24'),
(238, 20, 28, '8.31', 'yes', 10, 95, 5, 100, '0.50000', NULL, NULL, NULL, NULL, NULL, 55, '2024-02-07 15:21:24'),
(240, 20, 28, '5.1', 'yes', 10, 95, 5, 100, '0.50000', 'retain and accept risk', 'abcdes', '2024-03-22', '2024-03-15', 55, 55, '2024-03-23 09:51:46'),
(241, 19, 32, '5.1', 'yes', 5, 56, 44, 11, '0.24200', NULL, NULL, NULL, NULL, NULL, 55, '2024-03-21 15:30:04'),
(242, 24, 37, '5.1', 'yes', 5, 50, 50, 90, '2.25000', NULL, NULL, NULL, NULL, NULL, 55, '2024-03-22 19:25:26'),
(243, 24, 37, '5.10', 'yes', 5, 80, 20, 55, '0.55000', NULL, NULL, NULL, NULL, NULL, 55, '2024-03-22 19:25:52'),
(244, 20, 29, '5.1', 'yes', 10, 77, 23, 66, '1.51800', NULL, NULL, NULL, NULL, NULL, 55, '2024-03-23 10:03:55'),
(245, 25, 39, '5.1', 'yes', 5, 20, 80, 55, '2.20000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 17:28:03'),
(246, 25, 39, '5.2', 'no', 5, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 17:28:03'),
(247, 25, 39, '5.3', 'yes', 5, 79, 21, 77, '1.15500', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 17:28:45'),
(248, 25, 39, '5.4', 'yes', 5, 55, 45, 44, '0.63250', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 17:29:14'),
(249, 25, 39, '5.5', 'yes', 5, 77, 23, 66, '0.75900', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 17:51:35'),
(250, 25, 39, '5.6', 'no', 5, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 17:51:35'),
(251, 25, 39, '5.7', 'no', 1, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 17:52:13'),
(252, 25, 39, '5.8', 'no', 10, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 17:52:28'),
(253, 25, 39, '5.9', 'yes', 1, 77, 23, 66, '0.15180', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 17:54:05'),
(254, 25, 39, '5.10', 'no', 1, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 17:54:05'),
(255, 25, 39, '5.11', 'no', 5, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 17:54:22'),
(256, 25, 39, '5.12', 'no', 5, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 18:39:23'),
(257, 25, 39, '5.13', 'yes', 5, 77, 23, 66, '0.75900', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 18:40:09'),
(258, 25, 39, '5.14', 'no', 10, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 18:40:17'),
(259, 25, 39, '5.15', 'no', 5, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 19:05:36'),
(260, 25, 39, '5.16', 'no', 5, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 19:05:54'),
(261, 25, 39, '5.17', 'yes', 5, 88, 12, 99, '0.59400', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 19:05:54'),
(262, 25, 39, '5.18', 'no', 10, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 19:06:59'),
(263, 25, 39, '5.19', 'yes', 10, 88, 12, 77, '0.92400', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 19:06:59'),
(264, 25, 39, '5.20', 'yes', 10, 99, 1, 88, '0.08800', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 19:06:59'),
(265, 25, 39, '5.21', 'no', 10, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 19:06:59'),
(266, 25, 39, '5.22', 'no', 10, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 19:06:59'),
(267, 25, 39, '5.23', 'yes', 10, 77, 23, 66, '1.51800', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 19:06:59'),
(268, 25, 39, '5.24', 'no', 10, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 19:07:50'),
(269, 25, 39, '5.25', 'yes', 5, 88, 12, 2, '0.01200', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 19:08:16'),
(270, 25, 39, '5.27', 'no', 5, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-19 19:08:16'),
(271, 26, 41, '5.1', 'yes', 10, 98, 2, 77, '0.15400', 'modify risk', 'Treatment action 1', '2024-04-25', '2024-04-24', 55, 55, '2024-04-22 18:47:24'),
(272, 26, 41, '5.2', 'no', 5, 99, 1, 66, '0.03300', 'modify risk', NULL, NULL, NULL, NULL, 55, '2024-04-22 18:32:04'),
(273, 26, 41, '5.3', 'yes', 10, 66, 34, 66, '2.24400', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-20 14:49:40'),
(274, 26, 41, '5.4', 'yes', 10, 55, 45, 44, '1.98000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-20 14:50:06'),
(275, 26, 41, '5.5', 'yes', 5, 88, 12, 77, '0.46200', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-20 14:50:27'),
(276, 26, 41, '5.6', 'yes', 5, 79, 21, 66, '0.69300', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-20 15:07:19'),
(277, 26, 41, '5.7', 'yes', 10, 90, 10, 44, '0.44000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-20 15:12:16'),
(278, 26, 41, '6.1', 'yes', 10, 88, 12, 66, '0.79200', 'avoid risk', 'Treatment action2', '2024-04-19', '2024-04-26', 55, 55, '2024-04-22 18:49:40'),
(279, 26, 41, '5.8', 'no', 5, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-20 15:13:57'),
(280, 26, 41, '5.9', 'no', 5, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 55, '2024-04-20 15:18:34'),
(281, 26, 41, '6.8', 'no', 5, 0, 0, 0, '0.00000', 'retain and accept risk', NULL, NULL, NULL, NULL, 55, '2024-04-22 18:34:23'),
(299, 27, 59, '5.1', 'yes', 5, 66, 34, 77, '1.30900', NULL, NULL, NULL, NULL, NULL, 94, '2024-04-24 20:02:27'),
(300, 27, 59, '5.3', 'no', 5, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 94, '2024-04-24 20:02:27'),
(301, 27, 60, '5.1', 'yes', 1, 76, 24, 88, '0.21120', NULL, NULL, NULL, NULL, NULL, 94, '2024-04-24 20:05:40'),
(302, 27, 60, '5.2', 'yes', 1, 77, 23, 66, '0.15180', NULL, NULL, NULL, NULL, NULL, 94, '2024-04-24 20:05:59'),
(303, 27, 60, '5.3', 'yes', 1, 99, 1, 77, '0.00770', NULL, NULL, NULL, NULL, NULL, 94, '2024-04-24 20:06:37'),
(304, 27, 66, '5.1', 'no', 5, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 94, '2024-04-24 20:07:30'),
(305, 27, 67, '5.3', 'yes', 5, 66, 34, 66, '1.12200', NULL, NULL, NULL, NULL, NULL, 94, '2024-04-24 20:08:22'),
(306, 27, 67, '5.5', 'no', 5, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 94, '2024-04-24 20:08:42'),
(307, 27, 58, '5.1', 'no', 10, 0, 0, 0, '0.00000', 'share risk', NULL, NULL, NULL, NULL, 94, '2024-04-25 15:16:23'),
(308, 27, 58, '5.2', 'yes', 10, 95, 5, 55, '0.27500', 'modify risk', 'Action 1', '2024-04-11', '2024-04-04', 94, 94, '2024-04-25 16:35:22'),
(309, 27, 69, '5.1', 'yes', 1, 98, 2, 33, '0.00660', NULL, NULL, NULL, NULL, NULL, 94, '2024-04-25 16:54:36'),
(310, 27, 69, '5.2', 'no', 1, 0, 0, 0, '0.00000', NULL, NULL, NULL, NULL, NULL, 94, '2024-04-25 16:54:36'),
(311, 27, 58, '5.3', 'yes', 10, 95, 5, 55, '0.27500', NULL, NULL, NULL, NULL, NULL, 94, '2024-04-25 18:50:45'),
(312, 27, 58, '6.2', 'yes', 10, 55, 45, 66, '2.97000', NULL, NULL, NULL, NULL, NULL, 94, '2024-04-25 19:25:43');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2023_07_08_050419_create_organizations_table', 1),
(3, '2023_07_08_060634_create_privileges_table', 2),
(4, '2014_10_12_000000_create_users_table', 3),
(5, '2014_10_12_100000_create_password_reset_tokens_table', 4),
(6, '2019_08_19_000000_create_failed_jobs_table', 4),
(7, '2019_12_14_000001_create_personal_access_tokens_table', 4),
(8, '2023_07_08_050317_create_permission_tables', 4),
(11, '2023_07_08_064643_create_project_types_table', 5),
(12, '2023_07_08_064848_create_projects_table', 6),
(13, '2023_07_08_065623_create_project_details_table', 7),
(14, '2023_07_18_100555_ad_cnic_col_in_users', 8),
(15, '2023_07_20_131326_change_sub_org_name', 9),
(16, '2023_07_22_102015_chnage_colname_in_users', 10);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 10),
(1, 'App\\Models\\User', 12),
(1, 'App\\Models\\User', 23),
(1, 'App\\Models\\User', 25),
(1, 'App\\Models\\User', 26),
(1, 'App\\Models\\User', 34),
(1, 'App\\Models\\User', 41),
(1, 'App\\Models\\User', 45),
(1, 'App\\Models\\User', 54),
(1, 'App\\Models\\User', 57),
(1, 'App\\Models\\User', 62),
(1, 'App\\Models\\User', 65),
(1, 'App\\Models\\User', 67),
(1, 'App\\Models\\User', 69),
(1, 'App\\Models\\User', 72),
(1, 'App\\Models\\User', 74),
(1, 'App\\Models\\User', 77),
(1, 'App\\Models\\User', 78),
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 22),
(2, 'App\\Models\\User', 24),
(2, 'App\\Models\\User', 34),
(2, 'App\\Models\\User', 35),
(2, 'App\\Models\\User', 36),
(2, 'App\\Models\\User', 55),
(2, 'App\\Models\\User', 59),
(2, 'App\\Models\\User', 65),
(2, 'App\\Models\\User', 69),
(2, 'App\\Models\\User', 71),
(2, 'App\\Models\\User', 72),
(2, 'App\\Models\\User', 74),
(2, 'App\\Models\\User', 77),
(2, 'App\\Models\\User', 78),
(2, 'App\\Models\\User', 80),
(2, 'App\\Models\\User', 84),
(2, 'App\\Models\\User', 85),
(2, 'App\\Models\\User', 87),
(2, 'App\\Models\\User', 90),
(2, 'App\\Models\\User', 91),
(2, 'App\\Models\\User', 94),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 56),
(3, 'App\\Models\\User', 90),
(4, 'App\\Models\\User', 56),
(4, 'App\\Models\\User', 60),
(4, 'App\\Models\\User', 65),
(4, 'App\\Models\\User', 66),
(4, 'App\\Models\\User', 67),
(4, 'App\\Models\\User', 69),
(4, 'App\\Models\\User', 71),
(4, 'App\\Models\\User', 72),
(4, 'App\\Models\\User', 75),
(4, 'App\\Models\\User', 77),
(4, 'App\\Models\\User', 78),
(4, 'App\\Models\\User', 81),
(4, 'App\\Models\\User', 85),
(4, 'App\\Models\\User', 87),
(4, 'App\\Models\\User', 88),
(4, 'App\\Models\\User', 95),
(5, 'App\\Models\\User', 40),
(5, 'App\\Models\\User', 82),
(5, 'App\\Models\\User', 91),
(6, 'App\\Models\\User', 13),
(6, 'App\\Models\\User', 22),
(6, 'App\\Models\\User', 23),
(6, 'App\\Models\\User', 24),
(6, 'App\\Models\\User', 26),
(6, 'App\\Models\\User', 27),
(6, 'App\\Models\\User', 39),
(6, 'App\\Models\\User', 44),
(6, 'App\\Models\\User', 46),
(6, 'App\\Models\\User', 47),
(6, 'App\\Models\\User', 53),
(6, 'App\\Models\\User', 65),
(6, 'App\\Models\\User', 66),
(6, 'App\\Models\\User', 71),
(6, 'App\\Models\\User', 75),
(6, 'App\\Models\\User', 82);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 28),
(2, 'App\\Models\\User', 29),
(2, 'App\\Models\\User', 30),
(2, 'App\\Models\\User', 31),
(2, 'App\\Models\\User', 32),
(2, 'App\\Models\\User', 33),
(2, 'App\\Models\\User', 37),
(2, 'App\\Models\\User', 38),
(2, 'App\\Models\\User', 42),
(2, 'App\\Models\\User', 43),
(2, 'App\\Models\\User', 48),
(2, 'App\\Models\\User', 49),
(2, 'App\\Models\\User', 50),
(2, 'App\\Models\\User', 51),
(2, 'App\\Models\\User', 52),
(2, 'App\\Models\\User', 58),
(2, 'App\\Models\\User', 61),
(2, 'App\\Models\\User', 64),
(2, 'App\\Models\\User', 68),
(2, 'App\\Models\\User', 70),
(2, 'App\\Models\\User', 73),
(2, 'App\\Models\\User', 76),
(2, 'App\\Models\\User', 79),
(2, 'App\\Models\\User', 83),
(2, 'App\\Models\\User', 86),
(2, 'App\\Models\\User', 89),
(2, 'App\\Models\\User', 92),
(2, 'App\\Models\\User', 93),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 14),
(3, 'App\\Models\\User', 15),
(3, 'App\\Models\\User', 16),
(3, 'App\\Models\\User', 17),
(3, 'App\\Models\\User', 18),
(3, 'App\\Models\\User', 19),
(3, 'App\\Models\\User', 20),
(3, 'App\\Models\\User', 21),
(3, 'App\\Models\\User', 22),
(3, 'App\\Models\\User', 23),
(3, 'App\\Models\\User', 24),
(3, 'App\\Models\\User', 25),
(3, 'App\\Models\\User', 26),
(3, 'App\\Models\\User', 27),
(3, 'App\\Models\\User', 34),
(3, 'App\\Models\\User', 35),
(3, 'App\\Models\\User', 36),
(3, 'App\\Models\\User', 39),
(3, 'App\\Models\\User', 40),
(3, 'App\\Models\\User', 41),
(3, 'App\\Models\\User', 44),
(3, 'App\\Models\\User', 45),
(3, 'App\\Models\\User', 46),
(3, 'App\\Models\\User', 47),
(3, 'App\\Models\\User', 53),
(3, 'App\\Models\\User', 54),
(3, 'App\\Models\\User', 55),
(3, 'App\\Models\\User', 56),
(3, 'App\\Models\\User', 57),
(3, 'App\\Models\\User', 59),
(3, 'App\\Models\\User', 60),
(3, 'App\\Models\\User', 62),
(3, 'App\\Models\\User', 65),
(3, 'App\\Models\\User', 66),
(3, 'App\\Models\\User', 67),
(3, 'App\\Models\\User', 69),
(3, 'App\\Models\\User', 71),
(3, 'App\\Models\\User', 72),
(3, 'App\\Models\\User', 74),
(3, 'App\\Models\\User', 75),
(3, 'App\\Models\\User', 77),
(3, 'App\\Models\\User', 78),
(3, 'App\\Models\\User', 80),
(3, 'App\\Models\\User', 81),
(3, 'App\\Models\\User', 82),
(3, 'App\\Models\\User', 84),
(3, 'App\\Models\\User', 85),
(3, 'App\\Models\\User', 87),
(3, 'App\\Models\\User', 88),
(3, 'App\\Models\\User', 90),
(3, 'App\\Models\\User', 91),
(3, 'App\\Models\\User', 94),
(3, 'App\\Models\\User', 95),
(4, 'App\\Models\\User', 5),
(4, 'App\\Models\\User', 6),
(4, 'App\\Models\\User', 7),
(5, 'App\\Models\\User', 4);

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `org_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_org` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` int(11) NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `record_created_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `record_creation_date` date NOT NULL,
  `record_creation_time` time NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`org_id`, `name`, `type`, `sub_org`, `country`, `state`, `city`, `zip_code`, `address`, `record_created_by`, `record_creation_date`, `record_creation_time`, `status`, `created_at`, `updated_at`) VALUES
(9, 'Host1', 'host', 'finance', 'Pakistan', 'Sindh', 'karachi', 33, 'Azizabad', 'shahmeer@gmail.com', '2023-08-11', '12:31:13', 'active', '2023-08-11 07:31:13', '2023-08-11 07:31:13'),
(10, 'Guest1', 'guest', 'HR', 'Pakistan', 'Punjab', 'karachi', 33, 'National Highway', 'shahmeer@gmail.com', '2023-08-11', '12:36:03', 'active', '2023-08-11 07:36:03', '2023-08-11 07:36:03'),
(11, 'Guest2', 'guest', 'Trade', 'Pakistan', 'Sindh', 'karachi', 123, 'Iqbal town', 'shahmeer@gmail.com', '2023-08-14', '11:36:48', 'active', '2023-08-14 06:36:48', '2023-08-14 06:36:48'),
(12, 'Guest3', 'guest', 'HR', 'Pakistan', 'Punjab', 'karachi', 2, 'National Highway', 'shahmeer@gmail.com', '2023-08-29', '16:24:07', 'active', '2023-08-29 11:24:07', '2023-08-29 11:24:07'),
(13, 'Guest4', 'guest', 'HR', 'Pakistan', 'Punjab', 'karachi', 2, 'Azizabad', 'shahmeer@gmail.com', '2023-08-31', '12:12:05', 'active', '2023-08-31 07:12:05', '2023-08-31 07:12:05'),
(14, 'Guest5', 'guest', 'HR', 'Pakistan', 'Sindh', 'karachi', 123, 'Iqbal town', 'shahmeer@gmail.com', '2023-09-03', '16:38:18', 'active', '2023-09-03 11:38:18', '2023-09-03 11:38:18'),
(15, 'Guest6', 'guest', 'HR', 'Pakistan', 'Sindh', 'karachi', 123, 'National Highway', 'shahmeer@gmail.com', '2023-09-09', '16:26:30', 'active', '2023-09-09 11:26:30', '2023-09-09 11:26:30'),
(16, 'Guest7', 'guest', 'finance', 'USA', 'Punjab', 'lahore', 123, 'Iqbal town', 'shahmeer@gmail.com', '2023-09-09', '16:31:09', 'active', '2023-09-09 11:31:09', '2023-09-09 11:31:09'),
(17, 'Guest8', 'guest', 'finance', 'Pakisatn', 'Punjab', 'Karachi', 123, '12324 gg', 'shahmeer@gmail.com', '2023-09-15', '15:00:12', 'active', '2023-09-15 10:00:12', '2023-09-15 10:00:12'),
(18, 'g10', 'guest', 'HR', 'Pakistan', 'Punjab', 'karachi', 123, 'Iqbal town', 'shahmeer@gmail.com', '2023-09-15', '15:44:32', 'active', '2023-09-15 10:44:32', '2023-09-15 10:44:32'),
(19, 'Guest20', 'guest', 'Finance', 'Pakistan', 'Punjab', 'karachi', 123, 'National Highway', 'shahmeer@gmail.com', '2024-01-18', '11:07:50', 'active', '2024-01-18 06:07:50', '2024-01-18 06:07:50'),
(20, 'Host2', 'host', 'HR', 'Pakistan', 'Punjab', 'karachi', 123, 'Iqbal town', 'shahmeer@gmail.com', '2024-01-18', '11:22:50', 'active', '2024-01-18 06:22:50', '2024-01-18 06:22:50'),
(21, 'GRCT', 'guest', 'Audit', 'Pakistan', 'Sindh', 'Karachi', 75950, 'Fb Area Azizabad', 'shahmeer@gmail.com', '2024-04-23', '18:30:06', 'active', '2024-04-23 13:30:06', '2024-04-23 13:30:06');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('kabdullah098@gmail.com', '$2y$10$77s6taFtibexbxFsAm1EoOahTt4BtKSRJnglijqTWjz4Inwfewi82', '2024-04-19 10:27:55');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section1.3`
--

CREATE TABLE `pci-dss v3.2.1 section1.3` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `pci_standard_version` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PCI-DSS v3.2.1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section1.3`
--

INSERT INTO `pci-dss v3.2.1 section1.3` (`id`, `assessment_id`, `pci_standard_version`) VALUES
(1, NULL, 'PCI-DSS v3.2.1'),
(2, NULL, 'PCI-DSS v3.2.1');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section5.1_asv_quarterly`
--

CREATE TABLE `pci-dss v3.2.1 section5.1_asv_quarterly` (
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `id` int(11) NOT NULL,
  `requirement1` date NOT NULL,
  `requirement2` varchar(100) NOT NULL,
  `requirement3` varchar(5) NOT NULL,
  `requirement4` date NOT NULL,
  `requirement5` varchar(100) DEFAULT NULL,
  `requirement6` varchar(100) DEFAULT NULL,
  `requirement7` varchar(100) DEFAULT NULL,
  `requirement8` varchar(100) DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section5.1_quarterly_results`
--

CREATE TABLE `pci-dss v3.2.1 section5.1_quarterly_results` (
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `id` int(11) NOT NULL,
  `requirement1` varchar(5) NOT NULL,
  `requirement2` int(11) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section5.2`
--

CREATE TABLE `pci-dss v3.2.1 section5.2` (
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `id` int(11) NOT NULL,
  `requirement1` varchar(300) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 assessor company`
--

CREATE TABLE `pci-dss v3_2_1 assessor company` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `comp_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comp_address` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comp_website` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 assessor company`
--

INSERT INTO `pci-dss v3_2_1 assessor company` (`id`, `project_id`, `comp_name`, `comp_address`, `comp_website`, `last_edited_by`, `last_edited_at`) VALUES
(3, 1, 'Assessor company1', 'Gulshan', 'assessorcomp1@gmail.com', 57, '2023-08-20 16:06:04'),
(4, 4, 'Assessor company3', 'dssdd', 'www.asssero5.com', 57, '2023-08-22 11:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 assessors`
--

CREATE TABLE `pci-dss v3_2_1 assessors` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `assessor_name` varchar(100) NOT NULL,
  `assessor_pci_cred` varchar(200) NOT NULL,
  `assessor_phone` varchar(25) NOT NULL,
  `assessor_email` varchar(100) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pci-dss v3_2_1 assessors`
--

INSERT INTO `pci-dss v3_2_1 assessors` (`assessment_id`, `project_id`, `assessor_name`, `assessor_pci_cred`, `assessor_phone`, `assessor_email`, `last_edited_by`, `last_edited_at`) VALUES
(1, 1, 'Assessor1', 'Certified', '03984345076', 'assessor1@gmail.com', 57, '2023-08-20 16:00:15'),
(2, 1, 'Assessor2', 'Certified', '56777767', 'assessor2@gmail.com', 57, '2023-08-17 15:38:51'),
(4, 4, 'Assessor5', 'Certified', '03984345', 'assessor5@gmail.com', 57, '2023-08-22 11:20:01');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 associate_qsa`
--

CREATE TABLE `pci-dss v3_2_1 associate_qsa` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `qsa_name` varchar(100) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pci-dss v3_2_1 associate_qsa`
--

INSERT INTO `pci-dss v3_2_1 associate_qsa` (`assessment_id`, `project_id`, `qsa_name`, `last_edited_by`, `last_edited_at`) VALUES
(1, 1, 'Associate Qsa 1', 57, '2023-08-20 15:58:55'),
(2, 1, 'Associate Qsa2', 57, '2023-08-17 17:53:20'),
(5, 4, 'AssociateQA4', 57, '2023-08-22 11:18:44'),
(6, 7, 'Associate Qsa44', 66, '2023-08-29 16:29:26');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 client info`
--

CREATE TABLE `pci-dss v3_2_1 client info` (
  `assessment_id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_contact_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_contact_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 client info`
--

INSERT INTO `pci-dss v3_2_1 client info` (`assessment_id`, `project_id`, `company_name`, `company_address`, `company_url`, `company_contact_name`, `company_contact_number`, `company_email`, `last_edited_by`, `last_edited_at`) VALUES
(1006, 1, 'Guest Organization 1', 'Fb area block2', 'www.g1org.com', 'Shahmeer', '03332227364', 'g1org@gmail.com', 57, '2023-08-20 16:06:09'),
(1007, 4, 'Keelctric', 'Fb area block2', 'www.kelectric.com', 'khawaja', '75654555545', 'kelectric@gmail.com', 57, '2023-08-17 17:38:05'),
(1008, 7, 'Guest Organization 3', 'Fb area block2', 'www.g3org.com', 'khawaja', '03332227364', 'g3org@gmail.com', 66, '2023-08-29 16:29:48'),
(1009, 15, 'companyX', 'Fb area block2', 'www.g8org.com', 'Shahmeer', '75654555545', 'g8org@gmail.com', 81, '2023-09-15 15:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 sec4_2_dataflows`
--

CREATE TABLE `pci-dss v3_2_1 sec4_2_dataflows` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `dataflows` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `types_of_chd` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 sec4_2_dataflows`
--

INSERT INTO `pci-dss v3_2_1 sec4_2_dataflows` (`assessment_id`, `project_id`, `dataflows`, `types_of_chd`, `description`, `last_edited_by`, `last_edited_at`) VALUES
(6, 1, 'capture', 'PAN', 'Description 1', 57, '2023-09-06 11:59:22'),
(7, 1, 'authorization', 'full track', 'Descriptio 2 edited', 57, '2023-09-10 11:44:00');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 sec4_2_diagrams`
--

CREATE TABLE `pci-dss v3_2_1 sec4_2_diagrams` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `data_flow_diagram` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 sec4_2_diagrams`
--

INSERT INTO `pci-dss v3_2_1 sec4_2_diagrams` (`assessment_id`, `project_id`, `data_flow_diagram`, `last_edited_by`, `last_edited_at`) VALUES
(4, 1, '1693986913.jpg', 57, '2023-09-06 12:55:13'),
(5, 1, '1693987310.png', 57, '2023-09-06 13:01:50');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 sec4_4`
--

CREATE TABLE `pci-dss v3_2_1 sec4_4` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(300) NOT NULL,
  `requirement2` varchar(300) NOT NULL,
  `requirement3` varchar(300) NOT NULL,
  `requirement4` varchar(300) NOT NULL,
  `requirement5` varchar(300) NOT NULL,
  `requirement6` varchar(1000) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pci-dss v3_2_1 sec4_4`
--

INSERT INTO `pci-dss v3_2_1 sec4_4` (`assessment_id`, `project_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `requirement5`, `requirement6`, `last_edited_by`, `last_edited_at`) VALUES
(2, 1, 'Device', 'Vendor', 'model', 'Software name', '1.22', 'Rle is to make', 57, '2023-09-09 10:17:50');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 sec4_5`
--

CREATE TABLE `pci-dss v3_2_1 sec4_5` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `selection` varchar(5) NOT NULL,
  `if_no` varchar(300) DEFAULT NULL,
  `requirement2` varchar(300) DEFAULT NULL,
  `requirement3` varchar(1000) DEFAULT NULL,
  `requirement4` varchar(1000) DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pci-dss v3_2_1 sec4_5`
--

INSERT INTO `pci-dss v3_2_1 sec4_5` (`assessment_id`, `project_id`, `selection`, `if_no`, `requirement2`, `requirement3`, `requirement4`, `last_edited_by`, `last_edited_at`) VALUES
(3, 1, 'yes', NULL, 'Ahmed ali', 'Smaplig odne', 'pci dss', 57, '2023-09-09 11:24:33');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 sec4_6`
--

CREATE TABLE `pci-dss v3_2_1 sec4_6` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(300) NOT NULL,
  `requirement2` varchar(500) NOT NULL,
  `requirement3` varchar(300) NOT NULL,
  `requirement4` varchar(300) NOT NULL,
  `requirement5` varchar(300) NOT NULL,
  `requirement6` varchar(300) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pci-dss v3_2_1 sec4_6`
--

INSERT INTO `pci-dss v3_2_1 sec4_6` (`assessment_id`, `project_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `requirement5`, `requirement6`, `last_edited_by`, `last_edited_at`) VALUES
(2, 1, 'Set1', 'sample edited', 'fiwewall.,dk', '12', '120', '200', 57, '2023-09-09 13:35:57');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 sec4_7`
--

CREATE TABLE `pci-dss v3_2_1 sec4_7` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(300) NOT NULL,
  `requirement2` varchar(300) NOT NULL,
  `requirement3` varchar(1000) NOT NULL,
  `requirement4` varchar(300) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pci-dss v3_2_1 sec4_7`
--

INSERT INTO `pci-dss v3_2_1 sec4_7` (`assessment_id`, `project_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `last_edited_by`, `last_edited_at`) VALUES
(2, 1, 'ComapnyB edited', 'Vendor', 'transaction', '4.2.1', 57, '2023-09-11 09:51:45');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 sec4_8_assessor`
--

CREATE TABLE `pci-dss v3_2_1 sec4_8_assessor` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(200) NOT NULL,
  `requirement2` varbinary(200) NOT NULL,
  `requirement3` varchar(500) NOT NULL,
  `requirement4` varchar(1000) DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pci-dss v3_2_1 sec4_8_assessor`
--

INSERT INTO `pci-dss v3_2_1 sec4_8_assessor` (`assessment_id`, `project_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `last_edited_by`, `last_edited_at`) VALUES
(2, 1, 'Shayan khan', 0x6b686177616a61, 'fdfgdg', 'extra', 57, '2023-09-11 13:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 sec4_8_party`
--

CREATE TABLE `pci-dss v3_2_1 sec4_8_party` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(100) NOT NULL,
  `requirement2` varchar(100) NOT NULL,
  `requirement3` varchar(5) NOT NULL,
  `requirement4` varchar(5) NOT NULL,
  `requirement5` varchar(100) NOT NULL,
  `requirement6` date DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pci-dss v3_2_1 sec4_8_party`
--

INSERT INTO `pci-dss v3_2_1 sec4_8_party` (`assessment_id`, `project_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `requirement5`, `requirement6`, `last_edited_by`, `last_edited_at`) VALUES
(2, 1, 'PartyA edited', 'Table', 'no', 'yes', '122', '2023-09-02', 57, '2023-09-11 10:45:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 sec4_9`
--

CREATE TABLE `pci-dss v3_2_1 sec4_9` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(300) DEFAULT NULL,
  `requirement2` varchar(300) NOT NULL,
  `requirement3` varchar(1000) NOT NULL,
  `requirement4` date NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pci-dss v3_2_1 sec4_9`
--

INSERT INTO `pci-dss v3_2_1 sec4_9` (`assessment_id`, `project_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `last_edited_by`, `last_edited_at`) VALUES
(3, 1, 'ref1 edited', 'Doc1 edited', 'Description', '2023-09-01', 57, '2023-09-13 14:24:39'),
(5, 1, 'ref2 new', 'Doc2 new', 'Desc2 new', '2023-09-15', 57, '2023-09-13 14:27:13');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 sec4_10`
--

CREATE TABLE `pci-dss v3_2_1 sec4_10` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(300) DEFAULT NULL,
  `requirement2` varchar(300) NOT NULL,
  `requirement3` varchar(300) NOT NULL,
  `requirement4` varchar(300) NOT NULL,
  `requirement5` varchar(5) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pci-dss v3_2_1 sec4_10`
--

INSERT INTO `pci-dss v3_2_1 sec4_10` (`assessment_id`, `project_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `requirement5`, `last_edited_by`, `last_edited_at`) VALUES
(1, 1, 'referece1', 'SOhaib', 'HR', 'Fast', 'yes', 57, '2023-09-13 15:05:15');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 sec4_11`
--

CREATE TABLE `pci-dss v3_2_1 sec4_11` (
  `project_id` int(11) DEFAULT NULL,
  `assessment_id` int(11) NOT NULL,
  `requirement1` varchar(5) NOT NULL,
  `requirement2` varchar(1000) DEFAULT NULL,
  `requirement3` varchar(1000) DEFAULT NULL,
  `requirement4` varchar(1000) DEFAULT NULL,
  `requirement5` varchar(1000) DEFAULT NULL,
  `requirement6` varchar(1000) DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pci-dss v3_2_1 sec4_11`
--

INSERT INTO `pci-dss v3_2_1 sec4_11` (`project_id`, `assessment_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `requirement5`, `requirement6`, `last_edited_by`, `last_edited_at`) VALUES
(1, 1, 'no', NULL, NULL, NULL, NULL, NULL, 57, '2023-09-13 16:37:44');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 sec4_12_table`
--

CREATE TABLE `pci-dss v3_2_1 sec4_12_table` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement2` varchar(500) NOT NULL,
  `requirement3` varchar(1000) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 sec4_12_yes_or_no`
--

CREATE TABLE `pci-dss v3_2_1 sec4_12_yes_or_no` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(5) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pci-dss v3_2_1 sec4_12_yes_or_no`
--

INSERT INTO `pci-dss v3_2_1 sec4_12_yes_or_no` (`assessment_id`, `project_id`, `requirement1`, `last_edited_by`, `last_edited_at`) VALUES
(18, 1, 'no', 57, '2023-09-14 12:07:36');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 sec4_13_table`
--

CREATE TABLE `pci-dss v3_2_1 sec4_13_table` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement2` varchar(500) DEFAULT NULL,
  `requirement3` varchar(1000) DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 sec4_13_yes_or_no`
--

CREATE TABLE `pci-dss v3_2_1 sec4_13_yes_or_no` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(5) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pci-dss v3_2_1 sec4_13_yes_or_no`
--

INSERT INTO `pci-dss v3_2_1 sec4_13_yes_or_no` (`assessment_id`, `project_id`, `requirement1`, `last_edited_by`, `last_edited_at`) VALUES
(6, 1, 'no', 57, '2023-09-15 14:54:57');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section1_2`
--

CREATE TABLE `pci-dss v3_2_1 section1_2` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `date_of_report` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `time_onsite` int(11) NOT NULL,
  `time_remote` int(11) NOT NULL,
  `time_remediation` int(11) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section1_2`
--

INSERT INTO `pci-dss v3_2_1 section1_2` (`id`, `project_id`, `date_of_report`, `start_date`, `end_date`, `time_onsite`, `time_remote`, `time_remediation`, `last_edited_by`, `last_edited_at`) VALUES
(3, 1, '2023-08-01', '2023-08-05', '2023-09-01', 1000, 300, 450, 57, '2023-08-20 11:22:45'),
(4, 8, '2023-08-04', '2023-08-11', '2023-09-02', 66, 30, 45, 66, '2023-08-29 16:38:07');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section1_2_dates_spent_onsite`
--

CREATE TABLE `pci-dss v3_2_1 section1_2_dates_spent_onsite` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `date_spent_onsite` date NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section1_2_dates_spent_onsite`
--

INSERT INTO `pci-dss v3_2_1 section1_2_dates_spent_onsite` (`assessment_id`, `project_id`, `date_spent_onsite`, `last_edited_by`, `last_edited_at`) VALUES
(9, 1, '2023-08-05', 57, '2023-08-20 15:47:34');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section1_4`
--

CREATE TABLE `pci-dss v3_2_1 section1_4` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement2` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section1_4`
--

INSERT INTO `pci-dss v3_2_1 section1_4` (`assessment_id`, `project_id`, `requirement1`, `requirement2`, `last_edited_by`, `last_edited_at`) VALUES
(4, 1, 'Services ofered were ranmdomcd fofff', 'Efforts are made very well kdkfjfmdffffffffffff', 57, '2023-08-21 11:58:42');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section1_5`
--

CREATE TABLE `pci-dss v3_2_1 section1_5` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement2` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement3` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement4` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement5` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement6` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement7` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement8` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement9` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement10` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement11` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement12` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appendix_A1` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appendix_A2` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appendix_A3` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section1_5`
--

INSERT INTO `pci-dss v3_2_1 section1_5` (`assessment_id`, `project_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `requirement5`, `requirement6`, `requirement7`, `requirement8`, `requirement9`, `requirement10`, `requirement11`, `requirement12`, `appendix_A1`, `appendix_A2`, `appendix_A3`, `last_edited_by`, `last_edited_at`) VALUES
(4, 1, 'compliant', 'not tested', 'non compliant', 'non compliant', 'non compliant', 'not tested', 'not applicable', 'not applicable', 'not applicable', 'not tested', 'not tested', 'not tested', 'not tested', 'not tested', 'not tested', 57, '2023-08-21 17:49:11');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section2_1`
--

CREATE TABLE `pci-dss v3_2_1 section2_1` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement2` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement3` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement4` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_details` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section2_1`
--

INSERT INTO `pci-dss v3_2_1 section2_1` (`assessment_id`, `project_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `other_details`, `last_edited_by`, `last_edited_at`) VALUES
(4, 1, 'Nature dsae edited', 'ddddddddvff f ghjjj edited', 'fhthh yyj', 'types of paymenr edited', 'fedfff ff', 57, '2023-08-23 11:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section2_2`
--

CREATE TABLE `pci-dss v3_2_1 section2_2` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `diagram` varchar(600) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section2_2`
--

INSERT INTO `pci-dss v3_2_1 section2_2` (`assessment_id`, `project_id`, `diagram`, `last_edited_by`, `last_edited_at`) VALUES
(4, 1, '1692777297.jpg', 57, '2023-08-23 12:54:57'),
(9, 1, '1692794309.png', 57, '2023-08-23 17:38:29');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section3_1`
--

CREATE TABLE `pci-dss v3_2_1 section3_1` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement2` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement3` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement4` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement5` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement6` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_details` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section3_1`
--

INSERT INTO `pci-dss v3_2_1 section3_1` (`assessment_id`, `project_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `requirement5`, `requirement6`, `other_details`, `last_edited_by`, `last_edited_at`) VALUES
(4, 1, 'requirement1', 'requirement2', 'requirement3', 'requirement4', 'requirement5', 'requirement6', 'oyher', 57, '2023-09-10 11:12:41');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section3_2`
--

CREATE TABLE `pci-dss v3_2_1 section3_2` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement2` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement3` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement4` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_details` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section3_2`
--

INSERT INTO `pci-dss v3_2_1 section3_2` (`assessment_id`, `project_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `other_details`, `last_edited_by`, `last_edited_at`) VALUES
(3, 1, 'req1', 'req2', 'req3', 'req4', 'other details edited', 57, '2023-09-10 11:16:53');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section3_3`
--

CREATE TABLE `pci-dss v3_2_1 section3_3` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segmentation_not_used` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segmentation_used` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segmentation_used_req1` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segmentation_used_req2` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segmentation_used_req3` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segmentation_used_req4` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segmentation_used_req5` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requirement6` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section3_3`
--

INSERT INTO `pci-dss v3_2_1 section3_3` (`assessment_id`, `project_id`, `requirement1`, `segmentation_not_used`, `segmentation_used`, `segmentation_used_req1`, `segmentation_used_req2`, `segmentation_used_req3`, `segmentation_used_req4`, `segmentation_used_req5`, `requirement6`, `last_edited_by`, `last_edited_at`) VALUES
(9, 1, 'yes', NULL, 'ddvf', 'ff fff', 'ff f ff  gg', 'fgffff fff  f df f', 'f ff fef gg gg', 'ggggggg g dv dv v', 'BAsil ali', 57, '2023-08-27 11:30:33');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section3_4`
--

CREATE TABLE `pci-dss v3_2_1 section3_4` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `network_type` int(11) NOT NULL,
  `network_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose_of_network` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section3_4`
--

INSERT INTO `pci-dss v3_2_1 section3_4` (`assessment_id`, `project_id`, `network_type`, `network_name`, `purpose_of_network`, `last_edited_by`, `last_edited_at`) VALUES
(3, 1, 1, 'Network1', 'to store transmit or process CHD edited', 57, '2023-08-28 10:49:04'),
(4, 1, 2, 'Network 2 edited', 'Describe all networks that do not store, process and/or transmit CHD, but are still in scope (e.g., connected to the CDE or provide management functions to the CDE) edited vvg', 57, '2023-09-10 11:50:17'),
(6, 1, 3, 'Network 3', 'Out of scope', 57, '2023-08-28 10:50:53'),
(11, 1, 3, 'Network 3gg', 'fhhh', 57, '2023-09-10 11:52:23');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section3_5`
--

CREATE TABLE `pci-dss v3_2_1 section3_5` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement2` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement3` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`requirement3`)),
  `requirement4` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section3_5`
--

INSERT INTO `pci-dss v3_2_1 section3_5` (`assessment_id`, `project_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `last_edited_by`, `last_edited_at`) VALUES
(5, 1, 'Entity2', 'no', '[\"transmission\"]', 'ffsdf  mhj', 57, '2023-08-28 18:19:42'),
(6, 1, 'Entity1', 'yes', '[\"processing\"]', 'ffdf f', 57, '2023-08-28 18:23:13');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section3_6 international`
--

CREATE TABLE `pci-dss v3_2_1 section3_6 international` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `entity_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement1` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement2` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section3_6 international`
--

INSERT INTO `pci-dss v3_2_1 section3_6 international` (`assessment_id`, `project_id`, `entity_name`, `entity_country`, `requirement1`, `requirement2`, `last_edited_by`, `last_edited_at`) VALUES
(6, 1, 'International entity 2', 'South africa', 'ds  ggg', 'f gg  g', 57, '2023-08-31 15:54:40');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section3_6 wholly_owned`
--

CREATE TABLE `pci-dss v3_2_1 section3_6 wholly_owned` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `wholly_owned_entity` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement1` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requirement2` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section3_6 wholly_owned`
--

INSERT INTO `pci-dss v3_2_1 section3_6 wholly_owned` (`assessment_id`, `project_id`, `wholly_owned_entity`, `requirement1`, `requirement2`, `last_edited_by`, `last_edited_at`) VALUES
(5, 1, 'wholly entity1', 'dsdf edited', 'f ggg g', 57, '2023-08-31 15:44:30');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section3_7`
--

CREATE TABLE `pci-dss v3_2_1 section3_7` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `if_no` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requirement2` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL,
  `requirement3` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requirement4` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section3_7`
--

INSERT INTO `pci-dss v3_2_1 section3_7` (`assessment_id`, `project_id`, `requirement1`, `if_no`, `requirement2`, `last_edited_by`, `last_edited_at`, `requirement3`, `requirement4`) VALUES
(5, 1, 'no', 'Hello nono edited', NULL, 57, '2023-09-03 12:03:49', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section3_8 in_scope`
--

CREATE TABLE `pci-dss v3_2_1 section3_8 in_scope` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `wireless_technology` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement1` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement2` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement3` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section3_8 in_scope`
--

INSERT INTO `pci-dss v3_2_1 section3_8 in_scope` (`assessment_id`, `project_id`, `wireless_technology`, `requirement1`, `requirement2`, `requirement3`, `last_edited_by`, `last_edited_at`) VALUES
(4, 1, 'Wireless 1 edited', 'yes', 'no', 'no', 57, '2023-09-03 15:16:58');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section3_8 out_scope`
--

CREATE TABLE `pci-dss v3_2_1 section3_8 out_scope` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `wireless_out_scope` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section3_8 out_scope`
--

INSERT INTO `pci-dss v3_2_1 section3_8 out_scope` (`assessment_id`, `project_id`, `wireless_out_scope`, `description`, `last_edited_by`, `last_edited_at`) VALUES
(4, 1, 'wireless out of scope2 edited', 'out out out', 57, '2023-09-03 16:05:05');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section4_1`
--

CREATE TABLE `pci-dss v3_2_1 section4_1` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `network_diagrams` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section4_1`
--

INSERT INTO `pci-dss v3_2_1 section4_1` (`assessment_id`, `project_id`, `network_diagrams`, `last_edited_by`, `last_edited_at`) VALUES
(5, 1, '1693976685.png', 57, '2023-09-06 10:04:45'),
(7, 16, '1694775242.jpg', 84, '2023-09-15 15:54:02');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3_2_1 section4_3`
--

CREATE TABLE `pci-dss v3_2_1 section4_3` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `requirement1` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement2` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement3` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement4` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement5` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3_2_1 section4_3`
--

INSERT INTO `pci-dss v3_2_1 section4_3` (`assessment_id`, `project_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `requirement5`, `last_edited_by`, `last_edited_at`) VALUES
(3, 1, 'Datastore2 edited', 'Table', 'SAD edited', 'DEs AES', 'Logged in', 57, '2023-09-07 16:32:15'),
(4, 1, 'Datastore3', 'files', 'SAD', 'Encryption DES', 'OS logging', 57, '2023-09-07 16:35:44');

-- --------------------------------------------------------

--
-- Table structure for table `pci_dss v3_2_1 qa`
--

CREATE TABLE `pci_dss v3_2_1 qa` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `reviewer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reviewer_phone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reviewer_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci_dss v3_2_1 qa`
--

INSERT INTO `pci_dss v3_2_1 qa` (`assessment_id`, `project_id`, `reviewer_name`, `reviewer_phone`, `reviewer_email`, `last_edited_by`, `last_edited_at`) VALUES
(4, 1, 'Qa 1', '44343', 'qa1@gmail.com', 57, '2023-08-20 16:06:17'),
(5, 1, 'Qa2', '1223', 'qa2@gmail.com', 57, '2023-08-18 14:51:51'),
(6, 4, 'Qa1_forproject2', '1233', 'qa1forproj2@gmail.com', 57, '2023-08-22 11:18:34');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Project Owner', 'web', '2023-08-10 02:16:50', '2023-08-10 02:45:00'),
(2, 'Project Creator', 'web', '2023-08-10 02:23:02', '2023-08-10 02:23:02'),
(3, 'Project Approver', 'web', '2023-08-10 02:45:21', '2023-08-10 02:45:21'),
(4, 'Data Inputter', 'web', '2023-08-10 02:45:46', '2023-08-10 02:45:46'),
(5, 'Data Approver', 'web', '2023-08-10 02:45:56', '2023-08-10 02:45:56'),
(6, 'Data Viewer', 'web', '2023-08-10 02:46:17', '2023-08-10 02:46:17');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE `privileges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `privilege_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`id`, `privilege_name`, `created_at`, `updated_at`) VALUES
(1, 'Super User', '2023-07-08 08:01:23', '2023-07-08 08:01:23'),
(2, 'Primary Contact', '2023-07-08 08:01:39', '2023-07-08 08:01:39'),
(3, 'Secondary Contact', '2023-07-08 08:01:40', '2023-07-08 08:01:40'),
(4, 'Root Admin', NULL, NULL),
(5, 'End User', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `org_id` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `project_creation_date` date NOT NULL,
  `project_creation_time` time NOT NULL,
  `project_type` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Not submitted for approval',
  `status_last_changed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_name`, `org_id`, `created_by`, `project_creation_date`, `project_creation_time`, `project_type`, `status`, `status_last_changed_by`, `created_at`, `updated_at`) VALUES
(1, 'Audit 1 made by h1enduser1', 9, 55, '2023-08-12', '14:47:06', 2, 'Not submitted for approval', 55, '2023-08-12 09:47:06', '2023-08-12 11:00:53'),
(4, 'Audit 2 made by h1enduser1', 9, 55, '2023-08-12', '16:20:06', 2, 'Not submitted for approval', 55, '2023-08-12 11:20:06', '2023-08-14 05:58:32'),
(6, 'Audit by g2enduser1', 11, 59, '2023-08-14', '11:40:10', 2, 'Not submitted for approval', 59, '2023-08-14 06:40:10', '2023-08-14 06:40:10'),
(7, 'Project for guest3', 12, 65, '2023-08-29', '16:28:24', 2, 'Not submitted for approval', 65, '2023-08-29 11:28:24', '2023-08-29 11:28:24'),
(8, 'Test project 23', 9, 55, '2023-08-29', '16:36:59', 4, 'Pending Approval', 55, '2023-08-29 11:36:59', '2024-04-17 08:48:28'),
(9, 'projectbyg4', 13, 69, '2023-08-31', '12:20:10', 2, 'Not submitted for approval', 69, '2023-08-31 07:20:10', '2023-08-31 07:20:10'),
(10, 'Project by G5enduser1', 14, 71, '2023-09-03', '16:43:22', 2, 'Not submitted for approval', 71, '2023-09-03 11:43:22', '2023-09-03 11:43:22'),
(11, 'prohect by g5enduser2', 14, 72, '2023-09-03', '16:44:10', 2, 'Not submitted for approval', 72, '2023-09-03 11:44:10', '2023-09-03 11:44:10'),
(12, 'Guest6 Project (own)', 15, 74, '2023-09-09', '16:29:53', 2, 'Not submitted for approval', 74, '2023-09-09 11:29:53', '2023-09-09 11:29:53'),
(13, 'project for g7 by host', 9, 55, '2023-09-09', '16:35:17', 2, 'Not submitted for approval', 55, '2023-09-09 11:35:17', '2023-09-09 11:35:17'),
(14, 'project for g7 by g7enduser', 16, 77, '2023-09-09', '16:36:06', 2, 'Not submitted for approval', 77, '2023-09-09 11:36:06', '2023-09-09 11:36:06'),
(15, 'project for guest8', 17, 80, '2023-09-15', '15:03:26', 2, 'Not submitted for approval', 80, '2023-09-15 10:03:26', '2023-09-15 10:03:39'),
(16, 'project for G10', 18, 84, '2023-09-15', '15:47:00', 2, 'Not submitted for approval', 84, '2023-09-15 10:47:00', '2023-09-15 10:47:00'),
(17, 'ISO Test', 9, 55, '2023-11-07', '19:25:12', 4, 'Not submitted for approval', 55, '2023-11-07 14:25:12', '2023-11-07 14:25:12'),
(18, 'ISO test2', 9, 55, '2023-11-09', '19:04:24', 4, 'Not submitted for approval', 55, '2023-11-09 14:04:24', '2023-11-09 14:04:24'),
(19, 'ISO Project Testing', 9, 55, '2023-11-23', '18:43:33', 4, 'Not submitted for approval', 55, '2023-11-23 13:43:33', '2023-11-23 13:43:33'),
(20, 'Iso New Project', 9, 55, '2023-11-24', '18:29:00', 4, 'Not submitted for approval', 55, '2023-11-24 13:29:00', '2023-11-24 13:29:00'),
(21, 'ProjUmer', 10, 85, '2024-01-17', '19:33:01', 4, 'Not submitted for approval', 85, '2024-01-17 14:33:01', '2024-01-17 14:33:01'),
(22, 'G20 New project for only G20 users', 19, 87, '2024-01-18', '11:21:35', 4, 'Not submitted for approval', 87, '2024-01-18 06:21:35', '2024-01-18 06:21:35'),
(23, 'H2project', 20, 90, '2024-01-18', '11:26:21', 4, 'Not submitted for approval', 90, '2024-01-18 06:26:21', '2024-01-18 06:26:21'),
(24, 'Test final', 9, 55, '2024-03-21', '19:51:49', 4, 'Not submitted for approval', 55, '2024-03-21 14:51:49', '2024-03-21 14:51:49'),
(25, 'New Project For Files', 9, 55, '2024-04-19', '17:01:18', 4, 'Not submitted for approval', 55, '2024-04-19 12:01:18', '2024-04-19 12:01:18'),
(26, 'TestRisk Treatment', 9, 55, '2024-04-19', '19:40:29', 4, 'Not submitted for approval', 55, '2024-04-19 14:40:29', '2024-04-19 14:40:29'),
(27, 'GRC Project1', 21, 94, '2024-04-23', '18:33:42', 4, 'Not submitted for approval', 94, '2024-04-23 13:33:42', '2024-04-23 13:33:42'),
(28, 'Grc Project2', 21, 94, '2024-04-24', '19:41:56', 4, 'Not submitted for approval', 94, '2024-04-24 14:41:56', '2024-04-24 14:41:56');

-- --------------------------------------------------------

--
-- Table structure for table `project_details`
--

CREATE TABLE `project_details` (
  `project_code` int(11) DEFAULT NULL,
  `assigned_enduser` bigint(20) UNSIGNED DEFAULT NULL,
  `project_permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`project_permissions`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_details`
--

INSERT INTO `project_details` (`project_code`, `assigned_enduser`, `project_permissions`, `created_at`, `updated_at`) VALUES
(1, 57, '[\"Data Inputter\",\"Data Approver\"]', '2023-08-14 06:22:32', '2023-08-14 07:23:14'),
(1, 53, '[\"Project Approver\"]', '2023-08-14 06:33:40', '2023-08-14 06:33:40'),
(1, 54, '[\"Project Creator\",\"Project Approver\",\"Data Inputter\",\"Data Approver\"]', '2023-08-14 06:33:49', '2023-08-14 10:57:10'),
(1, 56, '[\"Project Owner\",\"Data Inputter\"]', '2023-08-14 10:57:00', '2023-08-31 06:59:42'),
(1, 55, '[\"Project Approver\"]', '2023-08-14 11:02:17', '2023-08-14 11:02:17'),
(4, 57, '[\"Data Inputter\",\"Data Viewer\"]', '2023-08-17 12:36:24', '2024-03-23 05:15:47'),
(7, 66, '[\"Data Inputter\"]', '2023-08-29 11:28:42', '2023-08-29 11:28:42'),
(9, 55, '[\"Data Inputter\"]', '2023-08-31 07:31:26', '2023-08-31 07:31:26'),
(9, 57, '[\"Data Inputter\",\"Data Viewer\"]', '2023-08-31 07:31:47', '2023-08-31 07:31:47'),
(10, 55, '[\"Project Owner\"]', '2023-09-03 11:43:36', '2023-09-03 11:43:36'),
(11, 72, '[\"Project Creator\",\"Data Inputter\"]', '2023-09-03 11:44:19', '2023-09-03 11:44:59'),
(12, 75, '[\"Data Inputter\",\"Data Approver\",\"Data Viewer\"]', '2023-09-09 11:30:07', '2023-09-09 11:30:07'),
(14, 57, '[\"Data Inputter\"]', '2023-09-09 11:36:22', '2023-09-09 11:36:22'),
(15, 81, '[\"Data Inputter\"]', '2023-09-15 10:06:16', '2023-09-15 10:06:16'),
(16, 84, '[\"Project Approver\",\"Data Inputter\"]', '2023-09-15 10:47:40', '2023-09-15 10:47:40'),
(17, 57, '[\"Project Approver\",\"Data Inputter\",\"Data Approver\",\"Data Viewer\"]', '2023-11-07 14:25:39', '2023-11-07 14:25:39'),
(18, 57, '[\"Data Inputter\",\"Data Viewer\"]', '2023-11-09 14:04:40', '2023-11-09 14:04:40'),
(17, 55, '[\"Project Owner\",\"Project Creator\"]', '2023-11-11 08:12:09', '2023-11-11 08:12:09'),
(19, 57, '[\"Project Creator\",\"Project Approver\",\"Data Inputter\",\"Data Viewer\"]', '2023-11-23 13:43:51', '2023-11-23 13:43:51'),
(19, 55, '[\"Data Inputter\",\"Data Approver\"]', '2023-11-23 13:44:05', '2023-11-24 12:54:57'),
(20, 55, '[\"Project Owner\",\"Project Creator\",\"Project Approver\",\"Data Inputter\"]', '2023-11-24 13:29:28', '2023-11-24 13:29:28'),
(21, 54, '[\"Data Inputter\"]', '2024-01-17 14:33:36', '2024-01-17 14:33:36'),
(21, 85, '[\"Data Inputter\"]', '2024-01-17 14:33:55', '2024-01-17 14:33:55'),
(22, 87, '[\"Data Inputter\"]', '2024-01-18 06:25:46', '2024-01-18 06:25:46'),
(22, 90, '[\"Data Inputter\"]', '2024-01-18 06:41:43', '2024-01-18 06:41:43'),
(24, 55, '[\"Data Inputter\"]', '2024-03-21 14:52:10', '2024-03-21 14:52:23'),
(4, 55, '[\"Project Owner\",\"Project Creator\",\"Project Approver\",\"Data Inputter\",\"Data Approver\",\"Data Viewer\"]', '2024-03-23 05:15:14', '2024-03-23 05:15:43'),
(8, 55, '[\"Project Owner\",\"Project Creator\",\"Project Approver\"]', '2024-04-17 08:52:44', '2024-04-17 10:49:57'),
(8, 57, '[\"Project Creator\",\"Project Approver\",\"Data Inputter\",\"Data Approver\"]', '2024-04-17 10:51:24', '2024-04-17 10:51:56'),
(25, 55, '[\"Project Creator\",\"Project Approver\",\"Data Inputter\",\"Data Approver\",\"Data Viewer\"]', '2024-04-19 12:01:42', '2024-04-19 12:01:42'),
(26, 55, '[\"Data Inputter\",\"Data Approver\"]', '2024-04-19 14:40:43', '2024-04-19 14:40:43'),
(27, 95, '[\"Data Inputter\",\"Data Viewer\"]', '2024-04-23 13:34:12', '2024-04-23 13:34:31'),
(27, 94, '[\"Project Creator\",\"Project Approver\",\"Data Inputter\"]', '2024-04-23 13:34:22', '2024-04-23 13:34:22'),
(28, 94, '[\"Data Inputter\",\"Data Approver\",\"Data Viewer\"]', '2024-04-24 14:42:19', '2024-04-24 14:42:19');

-- --------------------------------------------------------

--
-- Table structure for table `project_types`
--

CREATE TABLE `project_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_types`
--

INSERT INTO `project_types` (`id`, `type`, `created_at`, `updated_at`) VALUES
(2, 'Pci dss 3.2.1', NULL, NULL),
(3, 'Pci dss v4.0', NULL, NULL),
(4, 'ISO', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'root admin', 'web', '2023-07-18 05:18:59', '2023-07-18 05:18:59'),
(2, 'super user', 'web', '2023-07-18 05:18:59', '2023-07-18 05:18:59'),
(3, 'end user', 'web', '2023-07-18 05:18:59', '2023-07-18 05:18:59'),
(4, 'primary contact', 'web', '2023-07-23 00:45:59', '2023-07-23 00:45:59'),
(5, 'secondary contact', 'web', '2023-07-23 00:45:59', '2023-07-23 00:45:59');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `superusers`
--

CREATE TABLE `superusers` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `org_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `superusers`
--

INSERT INTO `superusers` (`id`, `user_id`, `org_id`) VALUES
(5, 51, 9),
(7, 51, 10),
(14, 51, 12),
(16, 51, 13),
(18, 51, 14),
(21, 51, 16),
(23, 51, 17),
(9, 52, 10),
(10, 58, 11),
(11, 61, 11),
(13, 64, 12),
(15, 68, 13),
(17, 70, 14),
(19, 73, 15),
(20, 76, 16),
(22, 79, 17),
(24, 83, 18),
(25, 86, 19),
(27, 89, 19),
(26, 89, 20),
(28, 92, 18),
(29, 93, 21);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `org_id` int(11) DEFAULT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `national_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` int(11) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `2FA` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `privilege_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `org_id`, `first_name`, `last_name`, `national_id`, `email`, `telephone`, `address`, `city`, `state`, `country`, `zip_code`, `password`, `2FA`, `privilege_id`, `status`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Shahmeer', 'Sheraz', NULL, 'shahmeer@gmail.com', '03332227456', 'hussainabad', 'Karachi', 'Sindh', 'Pakistan', 77, '$2y$10$vi4.BBlVe173XB8Y6y/.zehiWOrXzOwpJE8QSGoKTm8/dWsFin2iO', 'N', 4, 'active', NULL, NULL, '2023-07-08 08:03:14', '2023-07-08 03:14:31'),
(51, 9, 'Host1', 'Superuser1', '132233', 'h1superuser1@gmail.com', '1234455', 'Fb area block2', 'karachi', 'Sindh', 'Pakistan', 2, '$2y$10$GDj4Ev368FavPPdzZdYX7.802VDp8W1BW57xTKm1jBRJNAKY78eKq', 'N', 1, 'active', NULL, NULL, '2023-08-11 07:46:38', '2023-08-11 07:46:38'),
(52, 10, 'Guest1', 'Super User1', '33444', 'g1superuser1@gmail.com', '12444', 'Fb area', 'isamabad', 'Pujab', 'Pakistan', 3, '$2y$10$xyq4g6FrWJ2byguKcSEdFu/22vzNt8vEQZxyQU9E6YSQJATdDsh5K', 'N', 1, 'active', NULL, NULL, '2023-08-11 07:47:35', '2023-08-11 08:23:20'),
(53, 10, 'Guest1', 'enduser1', '133', 'g1enduser1@gmail.com', '123444', 'Gulshan', 'karachi', 'Sindh', 'Pakistan', 12, '$2y$10$XuEx7mzhrHvE1HVgfxUBJe2yLP1AazqR5m.KxkKT1V8ngqbtaibue', 'N', 5, 'active', NULL, NULL, '2023-08-11 07:48:48', '2023-08-11 07:48:48'),
(54, 10, 'Guest1', 'enduser2', '4210198765422', 'g1enduser2@gmail.com', '033344476787', 'Fb area block2', 'karachi', 'Sindh', 'Pakistan', 123, '$2y$10$FTRIzXMRK/ghw5XycapC2eURzaVviYitneANu/krvTgazXgOHHSVm', 'N', 5, 'active', NULL, NULL, '2023-08-11 07:50:39', '2023-08-11 07:50:39'),
(55, 9, 'Host1', 'Enduser1', '12333', 'h1enduser1@gmail.com', '03334447653', 'Fb area block2', 'karachi', 'Sindh', 'Pakistan', 12, '$2y$10$eEk81XNr9EnMywfB5LewMumU49/QtbzvHZsc88E5GlfCbM9XkJVqa', 'N', 5, 'active', NULL, NULL, '2023-08-11 07:52:08', '2023-08-11 07:52:08'),
(56, 10, 'Guest1', 'Enduser 3', '344', 'g1enduser3@gmail.com', '03334447653', 'Fb area block2', 'karachi', 'Punjab', 'Pakistan', 1, '$2y$10$SIj3aRSngCc0VLTTM88HE.6NzUU51.8m1rNcH8/1wjhsr5gRVh3Pu', 'N', 5, 'active', NULL, NULL, '2023-08-11 07:56:56', '2023-08-11 07:56:56'),
(57, 9, 'Host 1', 'enduser2', '421019876544', 'h1enduser2@gmail.com', '033344476787', 'Fb area block2', 'karachi', 'Pujab', 'Pakistan', 123, '$2y$10$uXD54n3UXkr0ZEMtsovjFux1WxCQsiNtz1ryCfF7peg/5h5njC/zS', 'N', 5, 'active', NULL, NULL, '2023-08-12 11:08:13', '2023-08-12 11:08:13'),
(58, 11, 'G2', 'superuser1', '33323', 'g2superuser1@gmail.com', '033344476787', 'Fb area block2', 'karachi', 'Punjab', 'Pakistan', 1, '$2y$10$LLHyueucTBO5pjAI9GnHNe09vRA7yxMLf90.h7TXjN8Dj/ue6xEqq', 'N', 1, 'active', NULL, NULL, '2023-08-14 06:37:54', '2023-08-14 06:37:54'),
(59, 11, 'G2', 'enduser1', '33323', 'g2enduser1@gmail.com', '033344476787', 'Fb area block2', 'karachi', 'Punjab', 'Pakistan', 23, '$2y$10$BVbTF7OYKa1NF75cpmyqcuTDAR57KXMfz3JIBFNF1QsBz9jRuW4j6', 'N', 5, 'active', NULL, NULL, '2023-08-14 06:38:57', '2023-08-14 06:38:57'),
(60, 11, 'G2', 'enduser2', '3443', 'g2enduser2@gmail.com', '34324', 'Azizabad', 'London', 'Sindh', 'Pakistan', 123, '$2y$10$eQDQX1arLN2RxLuHq3QTMeRs.K64ytjaAqDp3yPNjaEhOqf5vj6Jy', 'N', 5, 'active', NULL, NULL, '2023-08-14 06:39:41', '2023-08-14 06:39:41'),
(61, 11, 'G2', 'Superuser2', '444', 'g2superuser2@gmail.com', '44344', 'Fb area block2', 'Lahore', 'Punjab', 'Pakistan', 44, '$2y$10$RrMyfjxt5gsQMHimC9V3qOYn5GyO7IJ6bRiTfBIy29zbnrD8kQoCK', 'N', 1, 'active', NULL, NULL, '2023-08-14 10:51:04', '2023-08-14 10:51:04'),
(62, 11, 'guest2', 'enduser3', '444', 'g2enduser3@gmail.com', '32333', 'Fb area block2', 'lahore', 'Punjab', 'Pakistan', 33, '$2y$10$3TQvelKrKPV60ibmU1vW6OVbjk4rwwCTjkSTmJsbUbDdnNz2uGbsO', 'N', 5, 'active', NULL, NULL, '2023-08-14 10:59:40', '2023-08-14 10:59:40'),
(64, 12, 'Muhammad', 'Shahzaib', '4210198765466', 'shahzaib@gmail.com', '033344476787', 'Fb area block2', 'London', 'Punjab', 'Pakistan', 3, '$2y$10$opROkJZc6xaH35EG0v1ulOprC1TMqgar6BDRWechksp4WvaVT/aeq', 'N', 1, 'active', NULL, NULL, '2023-08-29 11:24:42', '2023-08-29 11:24:42'),
(65, 12, 'Sohaib', 'Ashraf', '4210198765455', 'sohaib@gmail.com', '03334447653', 'Fb area block2', 'lahore', 'Punjab', 'Pakistan', 33, '$2y$10$M3h/k.VTweySzwgndfHiYeHqRdeZfv5qSGXIOucLfe50lzdx9iQfK', 'N', 5, 'active', NULL, NULL, '2023-08-29 11:26:21', '2023-08-29 11:26:21'),
(66, 12, 'Muhammad', 'Abdullah', '4210198765422', 'abdullah@gmail.com', '03334447653', 'Fb area block2', 'karachi', 'Sindh', 'Pakistan', 44, '$2y$10$hqTxqwwYKojR/CC1gzykeOdetIaEvFWmi1awMirIXhpbjflytUPvG', 'N', 5, 'active', NULL, NULL, '2023-08-29 11:27:24', '2023-08-29 11:27:24'),
(67, 12, 'Guest3', 'enduser4', '3333323', 'h1enduser4@gmail.com', '033344476787', 'Fb area block2', 'karachi', 'Pujab', 'Pakist', 123, '$2y$10$Fe43kYV6Of3pk6S1KfVz9eKGaaBkkVxhqB/2taOD0tZunkBw7ivv6', 'N', 5, 'active', NULL, NULL, '2023-08-29 11:32:00', '2023-08-29 11:32:00'),
(68, 13, 'g4', 'superuser1', '4434555b', 'g4superuser1@gmail.com', '03334447653', 'Fb area block2', 'isamabad', 'Sind', 'USA', 12, '$2y$10$dHxKEIbb4OzTgp7yd3ARYO2qFgPhloxFQQ1PXHt5Eb0qzqwx8RJ2W', 'N', 1, 'active', NULL, NULL, '2023-08-31 07:12:49', '2023-08-31 07:12:49'),
(69, 13, 'g4enduser1', 'madeby h1enduser1', '4210198765422', 'g4enduser1@gmail.com', '3324', 'Fb area block2', 'karachi', 'Punjab', 'Indonesia', 55, '$2y$10$XIidxW4.y00..7oC2giC0OvbaR0Bqs7cvQqjTSGJiay3iFqyrCz/y', 'N', 5, 'active', NULL, NULL, '2023-08-31 07:14:52', '2023-08-31 07:14:52'),
(70, 14, 'g5', 'superuser1', '4210198765422', 'g5superuser1@gmail.com', '033344476787', 'Fb area block2', 'Lahore', 'Sindh', 'Pakistan', 12, '$2y$10$DttMyOQwLz6rmgYDCKCsEO3AEJYNVLMDOYvqXSeYZKTm3.Jzitr7C', 'N', 1, 'active', NULL, NULL, '2023-09-03 11:39:23', '2023-09-03 11:39:23'),
(71, 14, 'g5', 'enduser1', '4210198765422', 'g5enduser1@gmail.com', '033344476787', 'Fb area block2', 'London', 'Sindh', 'Pakistan', 44, '$2y$10$7afedKMUrZb14IhyfEJDGusw8PPeD/cLLz0Ax00ORk2mNLjWD9Xa6', 'N', 5, 'active', NULL, NULL, '2023-09-03 11:40:37', '2023-09-03 11:40:37'),
(72, 14, 'g5', 'enduser2', '4210198765432', 'g5enduser2@gmail.com', '033344476787', 'Fb area block2', 'karachi', 'Punjab', 'Indonesia', 3, '$2y$10$kEzVCBOI7teN5w/cBk0Qn.EGharA0RfhVyrBzTPDmU3kuOxrWi1Kq', 'N', 5, 'active', NULL, NULL, '2023-09-03 11:42:04', '2023-09-03 11:42:04'),
(73, 15, 'g6', 'superuser1', '4210198765422', 'g6superuser1@gmail.com', '033344476787', 'Fb area block2', 'karachi', 'Punjab', 'Indonesia', 2, '$2y$10$sgJ.89Yxw99r7W8YdfVyN.py8HpItl6w9ww9WyYd4VTUvojVH1/Da', 'N', 1, 'active', NULL, NULL, '2023-09-09 11:27:24', '2023-09-09 11:27:24'),
(74, 15, 'g6', 'enduser1', '4210198765432', 'g6enduser1@gmail.com', '033344476787', 'Fb area block2', 'karachi', 'Punjab', 'USA', 123, '$2y$10$1yUye4wIRMo4fTyWhi0DvuyRaKWMvGf.vj9ug0Iyv4S65zjq/ceJe', 'N', 5, 'active', NULL, NULL, '2023-09-09 11:28:33', '2023-09-09 11:28:33'),
(75, 15, 'g6', 'enduser2', '4210198765422', 'g6enduser2@gmail.com', '033344476787', 'National Highway', 'isamabad', 'Punjab', 'Indonesia', 44, '$2y$10$OaxfPR0vdx3AjOblWchpX.J4p5jgfr9AvKia1nJTQFzBb8INx2is.', 'N', 5, 'active', NULL, NULL, '2023-09-09 11:29:08', '2023-09-09 11:29:08'),
(76, 16, 'g7', 'superuser1', '4210198765432', 'g7superuser1@gmail.com', '03337776543', 'Fb area block2', 'isamabad', 'Pujab', 'Pakistan', 123, '$2y$10$zeMFs1SHkaTiJxE2DUbPzOn6tEqG9swpzcBXiNrHzOcLfKNbodviO', 'N', 1, 'active', NULL, NULL, '2023-09-09 11:31:55', '2023-09-09 11:31:55'),
(77, 16, 'g7', 'enduser1', '4210198765422', 'g7enduser1@gmail.com', '033344476787', 'National Highway', 'karachi', 'Punjab', 'Indonesia', 123, '$2y$10$Mea4wkA6vvPuNT4lbeL8oemzPHUdRyg.YMRmo0Fpn1.H6wnqvUKnO', 'N', 5, 'active', NULL, NULL, '2023-09-09 11:33:17', '2023-09-09 11:33:17'),
(78, 16, 'g7', 'enduser2', '4210198765432', 'g7enduser2@gmail.com', '033344476787', 'Iqbal town', 'Lahore', 'Sindh', 'Pakistan', 123, '$2y$10$agRP/y9HI6q3/2yqaYNtZOjGe9aH31l82MwE8exvPAZRDTIsr38HO', 'N', 5, 'active', NULL, NULL, '2023-09-09 11:34:14', '2023-09-09 11:34:14'),
(79, 17, 'g8', 'superuser1', '94958455', 'g8superuser1@gmail.com', '033344476787', 'Fb area block2', 'karachi', 'Punjab', 'Pakistan', 123, '$2y$10$zSlEvr0NbPCwChexKwuzKegne546fAr0kN2GbP0MKbD9DnQ3d5lt2', 'N', 1, 'active', NULL, NULL, '2023-09-15 10:00:54', '2023-09-15 10:00:54'),
(80, 17, 'g8', 'enduser1', '44556445', 'g8enduser1@gmail.com', '555', 'Fb area block2', 'karachi', 'Punjab', 'Pakistan', 123, '$2y$10$h9mEN7I38HBxFzWSwo.AUeMV7nNvbG.ax7k49l5w.6c.mIUBiNMR6', 'N', 5, 'active', NULL, NULL, '2023-09-15 10:01:43', '2023-09-15 10:01:43'),
(81, 17, 'g8', 'enduser2', '54546', 'g8enduser2@gmail.com', '43343', 'National Highway', 'karachi', 'Punjab', 'Pakistan', 44, '$2y$10$.WfQNI.Y2q.Cjp7JsquHiO7Q/ZqYrTf2Iyd2GpFcn4FOBtnYCiPji', 'N', 5, 'active', NULL, NULL, '2023-09-15 10:02:26', '2023-09-15 10:02:26'),
(82, 17, 'g8', 'enduser3', '435455', 'g8enduser3@gmail.com', '323333244', 'Fb area block2', 'karachi', 'Punjab', 'Pakist', 4, '$2y$10$jYc7ZMVLyyeE8s8KYKD5DOQ2uvzhYdwpaU4AwwelLfjMWsd65Tbgm', 'N', 5, 'active', NULL, NULL, '2023-09-15 10:04:41', '2023-09-15 10:04:41'),
(83, 18, 'g10', 'superuser1', '444', 'g10superuser1@gmail.com', '43545', 'Azizabad', 'isamabad', 'Punjab', 'Pakistan', 123, '$2y$10$V7eFc81zREcqA94mFT0ksebhxd7n9Xi1ZNJCqOD1JSROoqTOxWjQe', 'N', 1, 'active', NULL, NULL, '2023-09-15 10:45:19', '2023-09-15 10:45:19'),
(84, 18, 'g10', 'enduser1', '55545', 'g10enduser1@gmail.com', '03334447653', 'Fb area block2', 'karachi', 'Punjab', 'Pakistan', 4, '$2y$10$MF6xK1UZAQjE01Un5vvY2e5JEj6xeP5QmWYfYkGoduMLsekRbSkT2', 'N', 5, 'active', NULL, NULL, '2023-09-15 10:46:17', '2023-09-15 10:46:17'),
(85, 10, 'Umar', 'Bilal', '42101986764445', 'umer@gmail.com', '033344476787', 'ggffg', 'karachi', 'sindh', 'Pakistan', 44, '$2y$10$DSwWJpRHZd4wk3dZjeBx5uqDYYMXSFLKMcjq1/ZPcHH6Pgbw17Qda', 'N', 5, 'active', NULL, NULL, '2024-01-17 14:32:06', '2024-01-17 14:32:06'),
(86, 19, 'g20super', 'user1', '4210198765422', 'g20superuser1@gmail.com', '033344476787', 'Fb area', 'karachi', 'Punjab', 'Pakistan', 12, '$2y$10$HTbR/fWg2V85P8QOCPpcy.noXNoVhICYFbuQ5JfQ2EGq32S7p1T4y', 'N', 1, 'active', NULL, NULL, '2024-01-18 06:08:46', '2024-01-18 06:08:46'),
(87, 19, 'g20end', 'user1', '4210198765422', 'g20enduser1@gmail.com', '033344476787', 'Gulshan', 'karachi', 'Punjab', 'Pakistan', 44, '$2y$10$xor4iPgJ8g.bq40/uFMwU.lfRE74dJJ/arulZceVOOPSeJ3PMND2y', 'N', 5, 'active', NULL, NULL, '2024-01-18 06:10:07', '2024-01-18 06:10:07'),
(88, 19, 'g20end', 'user2', '4210198765422', 'g20enduser2@gmail.com', '03334447653', 'Gulshan', 'karachi', 'Punjab', 'Pakistan', 123, '$2y$10$Y7fjVyVsln/fHPzkZLQgQ.sy0a2tsejBiQHTJVxmK3pnCgjkMInte', 'N', 5, 'active', NULL, NULL, '2024-01-18 06:11:23', '2024-01-18 06:11:23'),
(89, 20, 'host2super', 'user1', '4210198765422', 'h2superuser1@gmail.com', '03337776543', 'Azizabad', 'karachi', 'Punjab', 'Pakistan', 44, '$2y$10$7osU8aS0U1iD5/VY0iQ0uegrW47zVNo5BDgrp/CENMaCENHj.JcmK', 'N', 1, 'active', NULL, NULL, '2024-01-18 06:23:29', '2024-01-18 06:23:29'),
(90, 20, 'h2end', 'user1', '4210198765422', 'h2enduser1@gmail.com', '03337776523', 'Fb area block2', 'karachi', 'Sindh', 'Pakistan', 3, '$2y$10$LF9fNivKJkGbnJ3uGpKhA.MocggJLxqbMElZOBuPoApiavLMKtZBi', 'N', 5, 'active', NULL, NULL, '2024-01-18 06:24:51', '2024-01-18 06:24:51'),
(91, 19, 'g20end', 'user3', '4210198765422', 'g20enduser3@gmail.com', '03337776543', 'Iqbal town', 'karachi', 'Punjab', 'Pakistan', 3, '$2y$10$XHv1aWhRiBSnykkL55VK/eZK.PelZr72N/M6VyaCtPMBcq0EgiS..', 'N', 5, 'active', NULL, NULL, '2024-01-18 06:28:05', '2024-01-18 06:28:05'),
(92, 18, 'khawaja', 'Abdullah', '4210198765422', 'kabdullah098@gmail.com', '03334447653', 'Iqbal town', 'karachi', 'jjkk', 'Pakistan', 123, '$2y$10$pEQ1tyRMqQzrVvyUz/D20OsY2srnrsuOnHQPVaQNkAlhq8kvVqrDm', 'N', 1, 'active', NULL, NULL, '2024-04-19 10:18:00', '2024-04-19 10:18:00'),
(93, 21, 'grctsuper', 'user1', '4210198754343', 'grcsuser1@gmail.com', '03344334', '1647/2 Fb Area Azizabad', 'Karachi', 'Sindh', 'Pakistan', 75950, '$2y$10$UJaAV.ibHG/LXEEBawC7OuPMyBpa53Wx4YMZz0SuVE5co7HA9YK22', 'N', 1, 'active', NULL, NULL, '2024-04-23 13:31:11', '2024-04-23 13:31:11'),
(94, 21, 'grcend', 'user1', '1275567', 'grcenduser1@gmail.com', '033443344', '1647/2 Fb Area Azizabad', 'Karachi', 'Sindh', 'Pakistan', 75950, '$2y$10$Y7sXKRmsMNAdWCR5ry8Vz.CvPCgkMUYLb3kzZUli3tzfkKDGXbmni', 'N', 5, 'active', NULL, NULL, '2024-04-23 13:32:37', '2024-04-23 13:32:37'),
(95, 21, 'grcend', 'user2', '344443', 'grcenduser2@gmail.com', '033443348', '1647/2 Fb Area Azizabad', 'Karachi', 'Sindh', 'Pakistan', 75950, '$2y$10$aSOJxvO5XA/PbKU9VTpKou6ae99EeKMgpjPlhsMfQbsv81.pim3Yu', 'N', 5, 'active', NULL, NULL, '2024-04-23 13:33:13', '2024-04-23 13:33:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `iso_risk_treatment`
--
ALTER TABLE `iso_risk_treatment`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `asset_id_2` (`asset_id`,`control_num`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `projid_sec2_3_1` (`project_id`),
  ADD KEY `accepted_by` (`accepted_by`),
  ADD KEY `acceptance_proposed_responsibility` (`acceptance_proposed_responsibility`);

--
-- Indexes for table `iso_sec2_4_a5`
--
ALTER TABLE `iso_sec2_4_a5`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `asset_id_2` (`asset_id`,`control_num`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `iso_sec2_4_a6`
--
ALTER TABLE `iso_sec2_4_a6`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `project_id` (`project_id`,`control_num`),
  ADD KEY `project_id_2` (`project_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `iso_sec2_4_a7`
--
ALTER TABLE `iso_sec2_4_a7`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `project_id_2` (`project_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `iso_sec2_4_a8`
--
ALTER TABLE `iso_sec2_4_a8`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `project_id_2` (`project_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `iso_sec_2_1`
--
ALTER TABLE `iso_sec_2_1`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `project_id_2` (`project_id`,`g_name`,`name`,`c_name`) USING HASH,
  ADD KEY `project_id` (`project_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `iso_sec_2_2`
--
ALTER TABLE `iso_sec_2_2`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `project_id` (`project_id`,`sub_req`),
  ADD KEY `project_id_2` (`project_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `iso_sec_2_3`
--
ALTER TABLE `iso_sec_2_3`
  ADD PRIMARY KEY (`sec2_3_key`),
  ADD UNIQUE KEY `asset_id` (`asset_id`,`project_id`),
  ADD KEY `asset_id_2` (`asset_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `iso_sec_2_3_1`
--
ALTER TABLE `iso_sec_2_3_1`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `asset_id_2` (`asset_id`,`control_num`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `projid_sec2_3_1` (`project_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`org_id`),
  ADD UNIQUE KEY `name` (`name`,`sub_org`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pci-dss v3.2.1 section1.3`
--
ALTER TABLE `pci-dss v3.2.1 section1.3`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`);

--
-- Indexes for table `pci-dss v3.2.1 section5.1_asv_quarterly`
--
ALTER TABLE `pci-dss v3.2.1 section5.1_asv_quarterly`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`,`last_edited_by`),
  ADD KEY `edit5.1_asv` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section5.1_quarterly_results`
--
ALTER TABLE `pci-dss v3.2.1 section5.1_quarterly_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`,`last_edited_by`),
  ADD KEY `editby5.1_quarter` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section5.2`
--
ALTER TABLE `pci-dss v3.2.1 section5.2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`,`last_edited_by`),
  ADD KEY `editby5.2` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3_2_1 assessor company`
--
ALTER TABLE `pci-dss v3_2_1 assessor company`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_id_2` (`project_id`),
  ADD KEY `editsecassescompanyfk` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 assessors`
--
ALTER TABLE `pci-dss v3_2_1 assessors`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3_2_1 associate_qsa`
--
ALTER TABLE `pci-dss v3_2_1 associate_qsa`
  ADD PRIMARY KEY (`assessment_id`);

--
-- Indexes for table `pci-dss v3_2_1 client info`
--
ALTER TABLE `pci-dss v3_2_1 client info`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `project_id_2` (`project_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 sec4_2_dataflows`
--
ALTER TABLE `pci-dss v3_2_1 sec4_2_dataflows`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 sec4_2_diagrams`
--
ALTER TABLE `pci-dss v3_2_1 sec4_2_diagrams`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 sec4_4`
--
ALTER TABLE `pci-dss v3_2_1 sec4_4`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 sec4_5`
--
ALTER TABLE `pci-dss v3_2_1 sec4_5`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `project_id_2` (`project_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 sec4_6`
--
ALTER TABLE `pci-dss v3_2_1 sec4_6`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 sec4_7`
--
ALTER TABLE `pci-dss v3_2_1 sec4_7`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 sec4_8_assessor`
--
ALTER TABLE `pci-dss v3_2_1 sec4_8_assessor`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3_2_1 sec4_8_party`
--
ALTER TABLE `pci-dss v3_2_1 sec4_8_party`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 sec4_9`
--
ALTER TABLE `pci-dss v3_2_1 sec4_9`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `ass_4.9_editby` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 sec4_10`
--
ALTER TABLE `pci-dss v3_2_1 sec4_10`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `editby_4.10` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 sec4_11`
--
ALTER TABLE `pci-dss v3_2_1 sec4_11`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `project_id_2` (`project_id`),
  ADD KEY `editby_4.11` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 sec4_12_table`
--
ALTER TABLE `pci-dss v3_2_1 sec4_12_table`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3_2_1 sec4_12_yes_or_no`
--
ALTER TABLE `pci-dss v3_2_1 sec4_12_yes_or_no`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `project_id_2` (`project_id`),
  ADD KEY `editby_4.12` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 sec4_13_table`
--
ALTER TABLE `pci-dss v3_2_1 sec4_13_table`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `editby_4.13` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 sec4_13_yes_or_no`
--
ALTER TABLE `pci-dss v3_2_1 sec4_13_yes_or_no`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3_2_1 section1_2`
--
ALTER TABLE `pci-dss v3_2_1 section1_2`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_id_2` (`project_id`),
  ADD KEY `editsec1.2fk` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 section1_2_dates_spent_onsite`
--
ALTER TABLE `pci-dss v3_2_1 section1_2_dates_spent_onsite`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `editsec1.2datesfk` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 section1_4`
--
ALTER TABLE `pci-dss v3_2_1 section1_4`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `project_id_2` (`project_id`),
  ADD KEY `editsec1.4fk` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 section1_5`
--
ALTER TABLE `pci-dss v3_2_1 section1_5`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `project_id_2` (`project_id`),
  ADD KEY `editsec1.5fk` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 section2_1`
--
ALTER TABLE `pci-dss v3_2_1 section2_1`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `project_id_2` (`project_id`),
  ADD KEY `editsec2.1fk` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 section2_2`
--
ALTER TABLE `pci-dss v3_2_1 section2_2`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `editsec2.2fk` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 section3_1`
--
ALTER TABLE `pci-dss v3_2_1 section3_1`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `project_id_2` (`project_id`),
  ADD KEY `editsec3.1fk` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 section3_2`
--
ALTER TABLE `pci-dss v3_2_1 section3_2`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `project_id_2` (`project_id`),
  ADD KEY `editsec3.2fk` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 section3_3`
--
ALTER TABLE `pci-dss v3_2_1 section3_3`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `project_id_2` (`project_id`),
  ADD KEY `editsec3.3fk` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 section3_4`
--
ALTER TABLE `pci-dss v3_2_1 section3_4`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 section3_5`
--
ALTER TABLE `pci-dss v3_2_1 section3_5`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 section3_6 international`
--
ALTER TABLE `pci-dss v3_2_1 section3_6 international`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 section3_6 wholly_owned`
--
ALTER TABLE `pci-dss v3_2_1 section3_6 wholly_owned`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 section3_7`
--
ALTER TABLE `pci-dss v3_2_1 section3_7`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `project_id` (`project_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3_2_1 section3_8 in_scope`
--
ALTER TABLE `pci-dss v3_2_1 section3_8 in_scope`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 section3_8 out_scope`
--
ALTER TABLE `pci-dss v3_2_1 section3_8 out_scope`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 section4_1`
--
ALTER TABLE `pci-dss v3_2_1 section4_1`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3_2_1 section4_3`
--
ALTER TABLE `pci-dss v3_2_1 section4_3`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci_dss v3_2_1 qa`
--
ALTER TABLE `pci_dss v3_2_1 qa`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `project_type` (`project_type`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `org_id` (`org_id`);

--
-- Indexes for table `project_details`
--
ALTER TABLE `project_details`
  ADD UNIQUE KEY `project_code_3` (`project_code`,`assigned_enduser`),
  ADD KEY `project_code` (`project_code`),
  ADD KEY `assigned_enduser` (`assigned_enduser`),
  ADD KEY `project_code_2` (`project_code`);

--
-- Indexes for table `project_types`
--
ALTER TABLE `project_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `superusers`
--
ALTER TABLE `superusers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`org_id`),
  ADD KEY `orgidfk` (`org_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `org_id` (`org_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `iso_risk_treatment`
--
ALTER TABLE `iso_risk_treatment`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `iso_sec2_4_a5`
--
ALTER TABLE `iso_sec2_4_a5`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `iso_sec2_4_a6`
--
ALTER TABLE `iso_sec2_4_a6`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `iso_sec2_4_a7`
--
ALTER TABLE `iso_sec2_4_a7`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `iso_sec2_4_a8`
--
ALTER TABLE `iso_sec2_4_a8`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `iso_sec_2_1`
--
ALTER TABLE `iso_sec_2_1`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `iso_sec_2_2`
--
ALTER TABLE `iso_sec_2_2`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `iso_sec_2_3`
--
ALTER TABLE `iso_sec_2_3`
  MODIFY `sec2_3_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `iso_sec_2_3_1`
--
ALTER TABLE `iso_sec_2_3_1`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=313;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `org_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section1.3`
--
ALTER TABLE `pci-dss v3.2.1 section1.3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section5.1_asv_quarterly`
--
ALTER TABLE `pci-dss v3.2.1 section5.1_asv_quarterly`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section5.1_quarterly_results`
--
ALTER TABLE `pci-dss v3.2.1 section5.1_quarterly_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section5.2`
--
ALTER TABLE `pci-dss v3.2.1 section5.2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 assessor company`
--
ALTER TABLE `pci-dss v3_2_1 assessor company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 assessors`
--
ALTER TABLE `pci-dss v3_2_1 assessors`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 associate_qsa`
--
ALTER TABLE `pci-dss v3_2_1 associate_qsa`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 client info`
--
ALTER TABLE `pci-dss v3_2_1 client info`
  MODIFY `assessment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1010;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 sec4_2_dataflows`
--
ALTER TABLE `pci-dss v3_2_1 sec4_2_dataflows`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 sec4_2_diagrams`
--
ALTER TABLE `pci-dss v3_2_1 sec4_2_diagrams`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 sec4_4`
--
ALTER TABLE `pci-dss v3_2_1 sec4_4`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 sec4_5`
--
ALTER TABLE `pci-dss v3_2_1 sec4_5`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 sec4_6`
--
ALTER TABLE `pci-dss v3_2_1 sec4_6`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 sec4_7`
--
ALTER TABLE `pci-dss v3_2_1 sec4_7`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 sec4_8_assessor`
--
ALTER TABLE `pci-dss v3_2_1 sec4_8_assessor`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 sec4_8_party`
--
ALTER TABLE `pci-dss v3_2_1 sec4_8_party`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 sec4_9`
--
ALTER TABLE `pci-dss v3_2_1 sec4_9`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 sec4_10`
--
ALTER TABLE `pci-dss v3_2_1 sec4_10`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 sec4_11`
--
ALTER TABLE `pci-dss v3_2_1 sec4_11`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 sec4_12_table`
--
ALTER TABLE `pci-dss v3_2_1 sec4_12_table`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 sec4_12_yes_or_no`
--
ALTER TABLE `pci-dss v3_2_1 sec4_12_yes_or_no`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 sec4_13_table`
--
ALTER TABLE `pci-dss v3_2_1 sec4_13_table`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 sec4_13_yes_or_no`
--
ALTER TABLE `pci-dss v3_2_1 sec4_13_yes_or_no`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section1_2`
--
ALTER TABLE `pci-dss v3_2_1 section1_2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section1_2_dates_spent_onsite`
--
ALTER TABLE `pci-dss v3_2_1 section1_2_dates_spent_onsite`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section1_4`
--
ALTER TABLE `pci-dss v3_2_1 section1_4`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section1_5`
--
ALTER TABLE `pci-dss v3_2_1 section1_5`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section2_1`
--
ALTER TABLE `pci-dss v3_2_1 section2_1`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section2_2`
--
ALTER TABLE `pci-dss v3_2_1 section2_2`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section3_1`
--
ALTER TABLE `pci-dss v3_2_1 section3_1`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section3_2`
--
ALTER TABLE `pci-dss v3_2_1 section3_2`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section3_3`
--
ALTER TABLE `pci-dss v3_2_1 section3_3`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section3_4`
--
ALTER TABLE `pci-dss v3_2_1 section3_4`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section3_5`
--
ALTER TABLE `pci-dss v3_2_1 section3_5`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section3_6 international`
--
ALTER TABLE `pci-dss v3_2_1 section3_6 international`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section3_6 wholly_owned`
--
ALTER TABLE `pci-dss v3_2_1 section3_6 wholly_owned`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section3_7`
--
ALTER TABLE `pci-dss v3_2_1 section3_7`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section3_8 in_scope`
--
ALTER TABLE `pci-dss v3_2_1 section3_8 in_scope`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section3_8 out_scope`
--
ALTER TABLE `pci-dss v3_2_1 section3_8 out_scope`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section4_1`
--
ALTER TABLE `pci-dss v3_2_1 section4_1`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pci-dss v3_2_1 section4_3`
--
ALTER TABLE `pci-dss v3_2_1 section4_3`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pci_dss v3_2_1 qa`
--
ALTER TABLE `pci_dss v3_2_1 qa`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `project_types`
--
ALTER TABLE `project_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `superusers`
--
ALTER TABLE `superusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `iso_risk_treatment`
--
ALTER TABLE `iso_risk_treatment`
  ADD CONSTRAINT `acceptace_flk1` FOREIGN KEY (`acceptance_proposed_responsibility`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `acceptace_flk2` FOREIGN KEY (`accepted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `acceptace_flk3` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `iso_sec2_4_a5`
--
ALTER TABLE `iso_sec2_4_a5`
  ADD CONSTRAINT `asseid_isofk` FOREIGN KEY (`asset_id`) REFERENCES `iso_sec_2_1` (`assessment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `editby-iso_2_4_a5` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `isosec2_4_a5_projid` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `iso_sec2_4_a6`
--
ALTER TABLE `iso_sec2_4_a6`
  ADD CONSTRAINT `assrtidfkfor16` FOREIGN KEY (`asset_id`) REFERENCES `iso_sec_2_1` (`assessment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `edit_sec2_4_16` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `proj_iso_2.4_a6` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `iso_sec2_4_a7`
--
ALTER TABLE `iso_sec2_4_a7`
  ADD CONSTRAINT `assetid17fk` FOREIGN KEY (`asset_id`) REFERENCES `iso_sec_2_1` (`assessment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `iso_a72_4_edit` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `iso_a72_4_proj` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `iso_sec2_4_a8`
--
ALTER TABLE `iso_sec2_4_a8`
  ADD CONSTRAINT `assetid_a8fk` FOREIGN KEY (`asset_id`) REFERENCES `iso_sec_2_1` (`assessment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `iso_sec2_4a8_edit` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `iso_sec2_4a8_proj` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `iso_sec_2_1`
--
ALTER TABLE `iso_sec_2_1`
  ADD CONSTRAINT `iso_sec2_1_edit` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `iso_sec2_1_proj` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `iso_sec_2_2`
--
ALTER TABLE `iso_sec_2_2`
  ADD CONSTRAINT `iso_sec2_2edit` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `iso_sec2_2projid` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `iso_sec_2_3`
--
ALTER TABLE `iso_sec_2_3`
  ADD CONSTRAINT `iso_sec_2_3_assetid` FOREIGN KEY (`asset_id`) REFERENCES `iso_sec_2_1` (`assessment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `iso_sec_2_3_lastedit` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `iso_sec_2_3_proj_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `iso_sec_2_3_1`
--
ALTER TABLE `iso_sec_2_3_1`
  ADD CONSTRAINT `assetid_sec2_3_1FK` FOREIGN KEY (`asset_id`) REFERENCES `iso_sec_2_1` (`assessment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lastEdit_fk_2_3_1` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projid_2.3.1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section1.3`
--
ALTER TABLE `pci-dss v3.2.1 section1.3`
  ADD CONSTRAINT `section1.3fk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3_2_1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section5.1_asv_quarterly`
--
ALTER TABLE `pci-dss v3.2.1 section5.1_asv_quarterly`
  ADD CONSTRAINT `ass_5.1_asv` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3_2_1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `edit5.1_asv` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section5.1_quarterly_results`
--
ALTER TABLE `pci-dss v3.2.1 section5.1_quarterly_results`
  ADD CONSTRAINT `asses_5.1_quarterly` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3_2_1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editby5.1_quarter` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section5.2`
--
ALTER TABLE `pci-dss v3.2.1 section5.2`
  ADD CONSTRAINT `asses5.2_fk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3_2_1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editby5.2` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3_2_1 assessor company`
--
ALTER TABLE `pci-dss v3_2_1 assessor company`
  ADD CONSTRAINT `editsecassescompanyfk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `proj_id_assesorcompany` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 assessors`
--
ALTER TABLE `pci-dss v3_2_1 assessors`
  ADD CONSTRAINT `last_edit_assessor_fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `proj_asse_fk` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 client info`
--
ALTER TABLE `pci-dss v3_2_1 client info`
  ADD CONSTRAINT `editsec1fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `project id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 sec4_2_dataflows`
--
ALTER TABLE `pci-dss v3_2_1 sec4_2_dataflows`
  ADD CONSTRAINT `editsec4.2_dataflowfk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projid_fk_4.2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 sec4_2_diagrams`
--
ALTER TABLE `pci-dss v3_2_1 sec4_2_diagrams`
  ADD CONSTRAINT `editsec4.2_diagramfk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec4.2diag_fkproj` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 sec4_4`
--
ALTER TABLE `pci-dss v3_2_1 sec4_4`
  ADD CONSTRAINT `4.4_projid_fk` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `lastedit_4.4` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3_2_1 sec4_5`
--
ALTER TABLE `pci-dss v3_2_1 sec4_5`
  ADD CONSTRAINT `4.5projisFK` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `last_edit4.5` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3_2_1 sec4_6`
--
ALTER TABLE `pci-dss v3_2_1 sec4_6`
  ADD CONSTRAINT `editbyz_4.6` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projid_sec4.6` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 sec4_7`
--
ALTER TABLE `pci-dss v3_2_1 sec4_7`
  ADD CONSTRAINT `4.7Fk_projid` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `editby_4.7` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3_2_1 sec4_8_assessor`
--
ALTER TABLE `pci-dss v3_2_1 sec4_8_assessor`
  ADD CONSTRAINT `editby_fk_4.8_ass` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `projid_4.8_assfk` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3_2_1 sec4_8_party`
--
ALTER TABLE `pci-dss v3_2_1 sec4_8_party`
  ADD CONSTRAINT `4.8fk_projid` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editby_4.8` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3_2_1 sec4_9`
--
ALTER TABLE `pci-dss v3_2_1 sec4_9`
  ADD CONSTRAINT `ass_4.9_editby` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec4.9fk_proj` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3_2_1 sec4_10`
--
ALTER TABLE `pci-dss v3_2_1 sec4_10`
  ADD CONSTRAINT `editby_4.10` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projidfk_4.10` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 sec4_11`
--
ALTER TABLE `pci-dss v3_2_1 sec4_11`
  ADD CONSTRAINT `editby_4.11` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projid_fk_4.11` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3_2_1 sec4_12_table`
--
ALTER TABLE `pci-dss v3_2_1 sec4_12_table`
  ADD CONSTRAINT `editby fk_4.12` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projid_4.12_table` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3_2_1 sec4_12_yes_or_no`
--
ALTER TABLE `pci-dss v3_2_1 sec4_12_yes_or_no`
  ADD CONSTRAINT `editby_4.12` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projid_4.12_decision` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3_2_1 sec4_13_table`
--
ALTER TABLE `pci-dss v3_2_1 sec4_13_table`
  ADD CONSTRAINT `editby_4.13` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projid_4.13_fk_table` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3_2_1 sec4_13_yes_or_no`
--
ALTER TABLE `pci-dss v3_2_1 sec4_13_yes_or_no`
  ADD CONSTRAINT `editby_4.13fk_yesn` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `prohih_fk_4.13yes` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3_2_1 section1_2`
--
ALTER TABLE `pci-dss v3_2_1 section1_2`
  ADD CONSTRAINT `editsec1.2fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `proj_id_1.2dates` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 section1_2_dates_spent_onsite`
--
ALTER TABLE `pci-dss v3_2_1 section1_2_dates_spent_onsite`
  ADD CONSTRAINT `editsec1.2datesfk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `proj_id_1.2datesonsite` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 section1_4`
--
ALTER TABLE `pci-dss v3_2_1 section1_4`
  ADD CONSTRAINT `editsec1.4fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec1.4 PRojidfk` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 section1_5`
--
ALTER TABLE `pci-dss v3_2_1 section1_5`
  ADD CONSTRAINT `editsec1.5fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec1.5 fk projid` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 section2_1`
--
ALTER TABLE `pci-dss v3_2_1 section2_1`
  ADD CONSTRAINT `editsec2.1fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec2.1_projfk` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 section2_2`
--
ALTER TABLE `pci-dss v3_2_1 section2_2`
  ADD CONSTRAINT `editsec2.2fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec2.2_projidFK` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 section3_1`
--
ALTER TABLE `pci-dss v3_2_1 section3_1`
  ADD CONSTRAINT `editsec3.1fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projid_3.1_fk` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 section3_2`
--
ALTER TABLE `pci-dss v3_2_1 section3_2`
  ADD CONSTRAINT `editsec3.2fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projid_fk_3.2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 section3_3`
--
ALTER TABLE `pci-dss v3_2_1 section3_3`
  ADD CONSTRAINT `editsec3.3fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec3.4_fk_projid` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 section3_4`
--
ALTER TABLE `pci-dss v3_2_1 section3_4`
  ADD CONSTRAINT `editsec3.4fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projid_3.4_fk` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 section3_5`
--
ALTER TABLE `pci-dss v3_2_1 section3_5`
  ADD CONSTRAINT `editsec3.5fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec3.5_projidFk` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 section3_6 international`
--
ALTER TABLE `pci-dss v3_2_1 section3_6 international`
  ADD CONSTRAINT `editsec3.6part2fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projid_fk_3.6` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 section3_6 wholly_owned`
--
ALTER TABLE `pci-dss v3_2_1 section3_6 wholly_owned`
  ADD CONSTRAINT `editsec3.6part1fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projid_3.6_wholly` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3_2_1 section3_7`
--
ALTER TABLE `pci-dss v3_2_1 section3_7`
  ADD CONSTRAINT `3.7_prjidfk` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editsec3.7fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3_2_1 section3_8 in_scope`
--
ALTER TABLE `pci-dss v3_2_1 section3_8 in_scope`
  ADD CONSTRAINT `3.8_inscopefk` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `editsec3.8scopefk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3_2_1 section3_8 out_scope`
--
ALTER TABLE `pci-dss v3_2_1 section3_8 out_scope`
  ADD CONSTRAINT `3.8outscope_projfk` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `editsec3.8putfk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3_2_1 section4_1`
--
ALTER TABLE `pci-dss v3_2_1 section4_1`
  ADD CONSTRAINT `editsec4.1fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projidfk_4.1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3_2_1 section4_3`
--
ALTER TABLE `pci-dss v3_2_1 section4_3`
  ADD CONSTRAINT `editsec4.3fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec4.3_fk_projid` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci_dss v3_2_1 qa`
--
ALTER TABLE `pci_dss v3_2_1 qa`
  ADD CONSTRAINT `editedby_qa_FK` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `project_qa_fk` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `createdbyfk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `organfkss` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`org_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `projtype` FOREIGN KEY (`project_type`) REFERENCES `project_types` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `project_details`
--
ALTER TABLE `project_details`
  ADD CONSTRAINT `endfk` FOREIGN KEY (`assigned_enduser`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `proj_code` FOREIGN KEY (`project_code`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `superusers`
--
ALTER TABLE `superusers`
  ADD CONSTRAINT `orgidfk` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`org_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `useridfk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `org_id` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`org_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
