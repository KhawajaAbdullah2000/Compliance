-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2024 at 07:33 PM
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
-- Database: `audit_code_migrations`
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
  `control_num` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applicability` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `applicability_all` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `asset_value` int(11) NOT NULL,
  `control_compliance` int(11) DEFAULT NULL,
  `vulnerability` int(11) DEFAULT NULL,
  `threat` int(11) DEFAULT NULL,
  `risk_level` decimal(11,5) DEFAULT NULL,
  `residual_risk_treatment` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `treatment_action` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `treatment_target_date` date DEFAULT NULL,
  `treatment_comp_date` date DEFAULT NULL,
  `responsibility_for_treatment` bigint(20) UNSIGNED DEFAULT NULL,
  `acceptance_justification` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acceptance_target_date` date DEFAULT NULL,
  `acceptance_actual_date` date DEFAULT NULL,
  `acceptance_proposed_responsibility` bigint(20) UNSIGNED DEFAULT NULL,
  `accepted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `iso_risk_treatment`
--

INSERT INTO `iso_risk_treatment` (`assessment_id`, `project_id`, `asset_id`, `control_num`, `applicability`, `applicability_all`, `asset_value`, `control_compliance`, `vulnerability`, `threat`, `risk_level`, `residual_risk_treatment`, `treatment_action`, `treatment_target_date`, `treatment_comp_date`, `responsibility_for_treatment`, `acceptance_justification`, `acceptance_target_date`, `acceptance_actual_date`, `acceptance_proposed_responsibility`, `accepted_by`, `last_edited_by`, `last_edited_at`) VALUES
(466, 4, 15, '5.1', 'yes', 'no', 10, 10, 90, 100, '9.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(467, 4, 15, '5.2', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(468, 4, 15, '5.3', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(469, 4, 15, '5.4', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(470, 4, 15, '5.5', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(471, 4, 15, '5.6', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(472, 4, 15, '5.7', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(473, 4, 15, '5.8', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(474, 4, 15, '5.9', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(475, 4, 15, '5.10', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(476, 4, 15, '5.11', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(477, 4, 15, '5.12', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(478, 4, 15, '5.13', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(479, 4, 15, '5.14', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(480, 4, 15, '5.15', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(481, 4, 15, '5.16', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(482, 4, 15, '5.17', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(483, 4, 15, '5.18', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(484, 4, 15, '5.19', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(485, 4, 15, '5.20', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(486, 4, 15, '5.21', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(487, 4, 15, '5.22', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(488, 4, 15, '5.23', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(489, 4, 15, '5.24', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(490, 4, 15, '5.25', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(491, 4, 15, '5.26', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(492, 4, 15, '5.27', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(493, 4, 15, '5.28', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(494, 4, 15, '5.29', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(495, 4, 15, '5.30', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(496, 4, 15, '5.31', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(497, 4, 15, '5.32', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(498, 4, 15, '5.33', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(499, 4, 15, '5.34', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(500, 4, 15, '5.35', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(501, 4, 15, '5.36', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(502, 4, 15, '5.37', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(503, 4, 15, '6.1', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(504, 4, 15, '6.2', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(505, 4, 15, '6.3', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(506, 4, 15, '6.4', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(507, 4, 15, '6.5', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(508, 4, 15, '6.6', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(509, 4, 15, '6.7', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(510, 4, 15, '6.8', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(511, 4, 15, '7.1', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(512, 4, 15, '7.2', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(513, 4, 15, '7.3', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(514, 4, 15, '7.4', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(515, 4, 15, '7.5', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(516, 4, 15, '7.6', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(517, 4, 15, '7.7', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(518, 4, 15, '7.8', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(519, 4, 15, '7.9', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(520, 4, 15, '7.10', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(521, 4, 15, '7.11', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(522, 4, 15, '7.12', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(523, 4, 15, '7.13', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(524, 4, 15, '7.14', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(525, 4, 15, '8.1', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(526, 4, 15, '8.2', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(527, 4, 15, '8.3', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(528, 4, 15, '8.4', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(529, 4, 15, '8.5', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(530, 4, 15, '8.6', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(531, 4, 15, '8.7', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(532, 4, 15, '8.8', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(533, 4, 15, '8.9', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(534, 4, 15, '8.10', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(535, 4, 15, '8.11', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(536, 4, 15, '8.12', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(537, 4, 15, '8.13', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(538, 4, 15, '8.14', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(539, 4, 15, '8.15', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(540, 4, 15, '8.16', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(541, 4, 15, '8.17', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(542, 4, 15, '8.18', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(543, 4, 15, '8.19', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(544, 4, 15, '8.20', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(545, 4, 15, '8.21', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(546, 4, 15, '8.22', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(547, 4, 15, '8.23', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(548, 4, 15, '8.24', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(549, 4, 15, '8.25', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(550, 4, 15, '8.26', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(551, 4, 15, '8.27', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(552, 4, 15, '8.28', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(553, 4, 15, '8.29', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(554, 4, 15, '8.30', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(555, 4, 15, '8.31', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(556, 4, 15, '8.32', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(557, 4, 15, '8.33', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(558, 4, 15, '8.34', 'yes', 'no', 10, 100, 0, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13');

-- --------------------------------------------------------

--
-- Table structure for table `iso_sec2_4_a5`
--

CREATE TABLE `iso_sec2_4_a5` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `asset_id` int(11) NOT NULL,
  `control_num` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `justification` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_of_risk` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iso_sec2_4_a6`
--

CREATE TABLE `iso_sec2_4_a6` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `asset_id` int(11) NOT NULL,
  `control_num` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `justification` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_of_risk` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iso_sec2_4_a7`
--

CREATE TABLE `iso_sec2_4_a7` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `asset_id` int(11) NOT NULL,
  `control_num` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `justification` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_of_risk` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iso_sec2_4_a8`
--

CREATE TABLE `iso_sec2_4_a8` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `asset_id` int(11) NOT NULL,
  `control_num` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `justification` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_of_risk` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iso_sec_2_1`
--

CREATE TABLE `iso_sec_2_1` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `g_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_dept` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `physical_loc` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logical_loc` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `iso_sec_2_1`
--

INSERT INTO `iso_sec_2_1` (`assessment_id`, `project_id`, `g_name`, `name`, `c_name`, `s_name`, `owner_dept`, `physical_loc`, `logical_loc`, `last_edited_by`, `last_edited_at`) VALUES
(6, NULL, 'Group1', 'Name1', 'Comp1', 'Service1', 'Owner1', 'Physical1', 'Logical1', 3, '2024-07-09 15:03:55'),
(7, NULL, 'Group1', 'Name1', 'Comp2', 'Service1', 'Owner1', 'Physical1', 'Logical1', 3, '2024-07-09 15:03:55'),
(13, NULL, 'Group1', 'Name1', 'Comp1', 'Service1', 'Owner1', 'Physical1', 'Logical1', 3, '2024-07-11 18:50:13'),
(14, NULL, 'Group1', 'Name1', 'Comp2', 'Service1', 'Owner1', 'Physical1', 'Logical1', 3, '2024-07-11 18:50:13'),
(15, 4, 'Group1', 'Asset1', 'Component1', 'Service1', 'Owner1', 'Physical1', 'Logical1', 3, '2024-08-09 20:29:31'),
(16, 4, 'Group1', 'Asset1', 'Component2', 'Service1', 'Owner1', 'Physical1', 'Logical1', 3, '2024-08-09 20:29:52');

-- --------------------------------------------------------

--
-- Table structure for table `iso_sec_2_2`
--

CREATE TABLE `iso_sec_2_2` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `title_num` int(11) DEFAULT NULL,
  `sub_req` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comp_status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comments` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `iso_sec_2_2`
--

INSERT INTO `iso_sec_2_2` (`assessment_id`, `project_id`, `title_num`, `sub_req`, `comp_status`, `comments`, `attachment`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 4, '4.1-a', 'yes', NULL, NULL, 3, '2024-07-06 16:39:18');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iso_sec_2_3_1`
--

CREATE TABLE `iso_sec_2_3_1` (
  `assessment_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `control_num` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applicability` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `applicability_all` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `asset_value` int(11) NOT NULL,
  `control_compliance` int(11) DEFAULT NULL,
  `desc_vulnerability` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Description of control is fully met',
  `desc_vulnerability_other` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vulnerability` int(11) DEFAULT NULL,
  `desc_threat` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Asset component is directly publicly exposed',
  `desc_threat_other` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `threat` int(11) DEFAULT NULL,
  `risk_level` decimal(11,5) DEFAULT NULL,
  `desc_risk` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`desc_risk`)),
  `desc_risk_other` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `residual_risk_treatment` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `treatment_action` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `treatment_target_date` date DEFAULT NULL,
  `treatment_comp_date` date DEFAULT NULL,
  `responsibility_for_treatment` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `iso_sec_2_3_1`
--

INSERT INTO `iso_sec_2_3_1` (`assessment_id`, `project_id`, `asset_id`, `control_num`, `applicability`, `applicability_all`, `asset_value`, `control_compliance`, `desc_vulnerability`, `desc_vulnerability_other`, `vulnerability`, `desc_threat`, `desc_threat_other`, `threat`, `risk_level`, `desc_risk`, `desc_risk_other`, `residual_risk_treatment`, `treatment_action`, `treatment_target_date`, `treatment_comp_date`, `responsibility_for_treatment`, `last_edited_by`, `last_edited_at`) VALUES
(466, 4, 15, '5.1', 'yes', 'no', 10, 10, 'Description of control is fully met', NULL, 90, 'Asset component is directly publicly exposed', NULL, 100, '9.00000', '[\"Breach of data confidentiality\"]', NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(467, 4, 15, '5.2', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(468, 4, 15, '5.3', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(469, 4, 15, '5.4', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(470, 4, 15, '5.5', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(471, 4, 15, '5.6', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(472, 4, 15, '5.7', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(473, 4, 15, '5.8', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(474, 4, 15, '5.9', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(475, 4, 15, '5.10', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(476, 4, 15, '5.11', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(477, 4, 15, '5.12', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(478, 4, 15, '5.13', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(479, 4, 15, '5.14', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(480, 4, 15, '5.15', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(481, 4, 15, '5.16', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(482, 4, 15, '5.17', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(483, 4, 15, '5.18', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(484, 4, 15, '5.19', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(485, 4, 15, '5.20', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(486, 4, 15, '5.21', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(487, 4, 15, '5.22', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(488, 4, 15, '5.23', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(489, 4, 15, '5.24', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(490, 4, 15, '5.25', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(491, 4, 15, '5.26', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(492, 4, 15, '5.27', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(493, 4, 15, '5.28', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(494, 4, 15, '5.29', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(495, 4, 15, '5.30', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(496, 4, 15, '5.31', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(497, 4, 15, '5.32', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(498, 4, 15, '5.33', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(499, 4, 15, '5.34', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(500, 4, 15, '5.35', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(501, 4, 15, '5.36', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(502, 4, 15, '5.37', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(503, 4, 15, '6.1', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(504, 4, 15, '6.2', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(505, 4, 15, '6.3', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(506, 4, 15, '6.4', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(507, 4, 15, '6.5', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(508, 4, 15, '6.6', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(509, 4, 15, '6.7', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(510, 4, 15, '6.8', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(511, 4, 15, '7.1', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(512, 4, 15, '7.2', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(513, 4, 15, '7.3', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(514, 4, 15, '7.4', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(515, 4, 15, '7.5', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(516, 4, 15, '7.6', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(517, 4, 15, '7.7', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(518, 4, 15, '7.8', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(519, 4, 15, '7.9', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(520, 4, 15, '7.10', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(521, 4, 15, '7.11', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(522, 4, 15, '7.12', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(523, 4, 15, '7.13', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(524, 4, 15, '7.14', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(525, 4, 15, '8.1', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(526, 4, 15, '8.2', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(527, 4, 15, '8.3', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(528, 4, 15, '8.4', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(529, 4, 15, '8.5', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(530, 4, 15, '8.6', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(531, 4, 15, '8.7', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(532, 4, 15, '8.8', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(533, 4, 15, '8.9', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(534, 4, 15, '8.10', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(535, 4, 15, '8.11', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(536, 4, 15, '8.12', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(537, 4, 15, '8.13', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(538, 4, 15, '8.14', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(539, 4, 15, '8.15', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(540, 4, 15, '8.16', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(541, 4, 15, '8.17', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(542, 4, 15, '8.18', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(543, 4, 15, '8.19', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(544, 4, 15, '8.20', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(545, 4, 15, '8.21', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(546, 4, 15, '8.22', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(547, 4, 15, '8.23', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(548, 4, 15, '8.24', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(549, 4, 15, '8.25', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(550, 4, 15, '8.26', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(551, 4, 15, '8.27', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(552, 4, 15, '8.28', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(553, 4, 15, '8.29', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(554, 4, 15, '8.30', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(555, 4, 15, '8.31', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(556, 4, 15, '8.32', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(557, 4, 15, '8.33', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13'),
(558, 4, 15, '8.34', 'yes', 'no', 10, 100, 'Description of control is fully met', NULL, 0, 'Asset component is directly publicly exposed', NULL, 100, '0.00000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-08-09 22:28:13');

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
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_06_28_093700_create_failed_jobs_table', 1),
(3, '2024_06_28_093700_create_iso_risk_treatment_table', 1),
(4, '2024_06_28_093700_create_iso_sec2_4_a5_table', 1),
(5, '2024_06_28_093700_create_iso_sec2_4_a6_table', 1),
(6, '2024_06_28_093700_create_iso_sec2_4_a7_table', 1),
(7, '2024_06_28_093700_create_iso_sec2_4_a8_table', 1),
(8, '2024_06_28_093700_create_iso_sec_2_1_table', 1),
(9, '2024_06_28_093700_create_iso_sec_2_2_table', 1),
(10, '2024_06_28_093700_create_iso_sec_2_3_1_table', 1),
(11, '2024_06_28_093700_create_iso_sec_2_3_table', 1),
(12, '2024_06_28_093700_create_model_has_permissions_table', 1),
(13, '2024_06_28_093700_create_model_has_roles_table', 1),
(14, '2024_06_28_093700_create_organizations_table', 1),
(15, '2024_06_28_093700_create_password_reset_tokens_table', 1),
(16, '2024_06_28_093700_create_permissions_table', 1),
(17, '2024_06_28_093700_create_privileges_table', 1),
(18, '2024_06_28_093700_create_project_details_table', 1),
(19, '2024_06_28_093700_create_project_types_table', 1),
(20, '2024_06_28_093700_create_projects_table', 1),
(21, '2024_06_28_093700_create_role_has_permissions_table', 1),
(22, '2024_06_28_093700_create_roles_table', 1),
(23, '2024_06_28_093700_create_superusers_table', 1),
(24, '2024_06_28_093700_create_users_table', 1),
(25, '2024_06_28_093703_add_foreign_keys_to_iso_risk_treatment_table', 1),
(26, '2024_06_28_093703_add_foreign_keys_to_iso_sec2_4_a5_table', 1),
(27, '2024_06_28_093703_add_foreign_keys_to_iso_sec2_4_a6_table', 1),
(28, '2024_06_28_093703_add_foreign_keys_to_iso_sec2_4_a7_table', 1),
(29, '2024_06_28_093703_add_foreign_keys_to_iso_sec2_4_a8_table', 1),
(30, '2024_06_28_093703_add_foreign_keys_to_iso_sec_2_1_table', 1),
(31, '2024_06_28_093703_add_foreign_keys_to_iso_sec_2_2_table', 1),
(32, '2024_06_28_093703_add_foreign_keys_to_iso_sec_2_3_1_table', 1),
(33, '2024_06_28_093703_add_foreign_keys_to_iso_sec_2_3_table', 1),
(34, '2024_06_28_093703_add_foreign_keys_to_model_has_permissions_table', 1),
(35, '2024_06_28_093703_add_foreign_keys_to_model_has_roles_table', 1),
(36, '2024_06_28_093703_add_foreign_keys_to_project_details_table', 1),
(37, '2024_06_28_093703_add_foreign_keys_to_projects_table', 1),
(38, '2024_06_28_093703_add_foreign_keys_to_role_has_permissions_table', 1),
(39, '2024_06_28_093703_add_foreign_keys_to_superusers_table', 1),
(40, '2024_06_28_093703_add_foreign_keys_to_users_table', 1);

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
(1, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 3);

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
(3, 'App\\Models\\User', 3);

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
(1, 'Bank Islami', 'guest', 'IT', 'Pakistan', 'Sindh', 'Karachi', 75950, 'Clifton', 'shahmeer@gmail.com', '2024-07-06', '16:31:24', 'active', '2024-07-06 11:31:24', '2024-07-06 11:31:24');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'Project Creator', 'web', '2024-07-06 11:32:29', '2024-07-06 11:32:29'),
(2, 'Data Inputter', 'web', '2024-07-06 11:32:59', '2024-07-06 11:32:59'),
(3, 'Data Viewer', 'web', '2024-07-06 11:33:07', '2024-07-06 11:33:07'),
(4, 'Data Approver', 'web', '2024-07-06 11:33:19', '2024-07-06 11:33:19');

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
(4, 'ISO Project', 1, 3, '2024-08-09', '20:28:36', 4, 'Not submitted for approval', 3, '2024-08-09 15:28:36', '2024-08-09 15:28:36');

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
(NULL, 3, '[\"Data Inputter\"]', '2024-07-06 11:35:05', '2024-07-06 11:35:05'),
(NULL, 3, '[\"Data Inputter\",\"Data Viewer\"]', '2024-07-11 13:49:19', '2024-07-11 13:49:19'),
(4, 3, '[\"Data Inputter\",\"Data Viewer\",\"Data Approver\"]', '2024-08-09 15:28:49', '2024-08-09 15:28:49');

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
(1, 'PCI-DSS v4-Single-Tenant Service Provider (stSP', NULL, NULL),
(2, 'PCI-DSS v4-Multi-Tenant Service Provider (mtSP)', NULL, NULL),
(3, 'PCI-DSS v4-Merchant', NULL, NULL),
(4, 'ISO 27001:2022', NULL, NULL);

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
(1, 'root admin', 'web', '2024-07-06 11:29:31', '2024-07-06 11:29:31'),
(2, 'super user', 'web', '2024-07-06 11:29:31', '2024-07-06 11:29:31'),
(3, 'end user', 'web', '2024-07-06 11:29:31', '2024-07-06 11:29:31'),
(4, 'primary contact ', 'web', '2024-07-06 11:29:31', '2024-07-06 11:29:31'),
(5, 'secondary contact', 'web', '2024-07-06 11:29:31', '2024-07-06 11:29:31');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `superusers`
--

INSERT INTO `superusers` (`id`, `user_id`, `org_id`) VALUES
(1, 2, 1);

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
(1, NULL, 'shahmeer', 'sheraz', NULL, 'shahmeer@gmail.com', '04448887643', 'Gulshan', 'karachi', 'Sindh', 'country', 12, '$2y$10$YhC9pohrNjrsJ5MTUBZGOe6UFzOGbqMcuf4s/WAeHUHUpEyK.fMzq', 'N', 4, 'active', NULL, NULL, NULL, NULL),
(2, 1, 'bank', 'Super 1', '43443', 'banks1@gmail.com', '554545', 'Clifton', 'Karachi', 'Sindh', 'Pakistan', 75950, '$2y$10$FyShQSFGMzuDCiENrElr/.O.yICaxYJlLoeOwVlL6RuQaDf3Q05HC', 'N', 1, 'active', NULL, NULL, '2024-07-06 11:31:59', '2024-07-06 11:31:59'),
(3, 1, 'Bank', 'End 1', '33444', 'banke1@gmail.com', '34554', 'Clifton', 'Karachi', 'Sindh', 'Pakistan', 75950, '$2y$10$pc1QQuwU2jUiNOiPB77DEe7G7uSCByjoDgRgzJUvjxXyAq1si.c0S', 'N', 5, 'active', NULL, NULL, '2024-07-06 11:34:03', '2024-07-06 11:34:03');

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
  ADD KEY `projid_sec2_3_1` (`project_id`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `acceptance_proposed_responsibility` (`acceptance_proposed_responsibility`),
  ADD KEY `accepted_by` (`accepted_by`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `iso_sec2_4_a5`
--
ALTER TABLE `iso_sec2_4_a5`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `asset_id_2` (`asset_id`,`control_num`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `iso_sec2_4_a6`
--
ALTER TABLE `iso_sec2_4_a6`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `project_id` (`project_id`,`control_num`),
  ADD KEY `project_id_2` (`project_id`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `iso_sec2_4_a7`
--
ALTER TABLE `iso_sec2_4_a7`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `project_id_2` (`project_id`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `iso_sec2_4_a8`
--
ALTER TABLE `iso_sec2_4_a8`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `project_id_2` (`project_id`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `iso_sec_2_1`
--
ALTER TABLE `iso_sec_2_1`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `project_id_2` (`project_id`,`g_name`,`name`,`c_name`,`s_name`),
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
  ADD KEY `projid_sec2_3_1` (`project_id`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

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
  ADD KEY `org_id` (`org_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `project_type` (`project_type`);

--
-- Indexes for table `project_details`
--
ALTER TABLE `project_details`
  ADD UNIQUE KEY `project_code_3` (`project_code`,`assigned_enduser`),
  ADD KEY `project_code` (`project_code`),
  ADD KEY `project_code_2` (`project_code`),
  ADD KEY `assigned_enduser` (`assigned_enduser`);

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
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=559;

--
-- AUTO_INCREMENT for table `iso_sec2_4_a5`
--
ALTER TABLE `iso_sec2_4_a5`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `iso_sec2_4_a6`
--
ALTER TABLE `iso_sec2_4_a6`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `iso_sec2_4_a7`
--
ALTER TABLE `iso_sec2_4_a7`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `iso_sec2_4_a8`
--
ALTER TABLE `iso_sec2_4_a8`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `iso_sec_2_1`
--
ALTER TABLE `iso_sec_2_1`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `iso_sec_2_2`
--
ALTER TABLE `iso_sec_2_2`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `iso_sec_2_3`
--
ALTER TABLE `iso_sec_2_3`
  MODIFY `sec2_3_key` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `iso_sec_2_3_1`
--
ALTER TABLE `iso_sec_2_3_1`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=559;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `org_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project_types`
--
ALTER TABLE `project_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `superusers`
--
ALTER TABLE `superusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `iso_risk_treatment`
--
ALTER TABLE `iso_risk_treatment`
  ADD CONSTRAINT `acceptace_flk1` FOREIGN KEY (`acceptance_proposed_responsibility`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `acceptace_flk2` FOREIGN KEY (`accepted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `acceptace_flk3` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `assetid` FOREIGN KEY (`asset_id`) REFERENCES `iso_sec_2_1` (`assessment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `proj_iso_2_4_a6` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
  ADD CONSTRAINT `projid_2_3` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
