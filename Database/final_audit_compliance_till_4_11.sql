-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2023 at 01:39 PM
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
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 56),
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
(5, 'App\\Models\\User', 40),
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
(6, 'App\\Models\\User', 75);

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
(16, 'Guest7', 'guest', 'finance', 'USA', 'Punjab', 'lahore', 123, 'Iqbal town', 'shahmeer@gmail.com', '2023-09-09', '16:31:09', 'active', '2023-09-09 11:31:09', '2023-09-09 11:31:09');

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
-- Table structure for table `pci-dss v3.2.1 section4.12`
--

CREATE TABLE `pci-dss v3.2.1 section4.12` (
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `id` int(11) NOT NULL,
  `requirement1` varchar(5) NOT NULL,
  `requirement2` varchar(100) DEFAULT NULL,
  `requirement3` varchar(100) DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section4.13`
--

CREATE TABLE `pci-dss v3.2.1 section4.13` (
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `id` int(11) NOT NULL,
  `requirement1` varchar(5) NOT NULL,
  `requirement2` varchar(100) DEFAULT NULL,
  `requirement3` varchar(100) DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1008, 7, 'Guest Organization 3', 'Fb area block2', 'www.g3org.com', 'khawaja', '03332227364', 'g3org@gmail.com', 66, '2023-08-29 16:29:48');

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
(5, 1, '1693976685.png', 57, '2023-09-06 10:04:45');

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
(8, 'Test project', 9, 55, '2023-08-29', '16:36:59', 2, 'Not submitted for approval', 55, '2023-08-29 11:36:59', '2023-08-29 11:36:59'),
(9, 'projectbyg4', 13, 69, '2023-08-31', '12:20:10', 2, 'Not submitted for approval', 69, '2023-08-31 07:20:10', '2023-08-31 07:20:10'),
(10, 'Project by G5enduser1', 14, 71, '2023-09-03', '16:43:22', 2, 'Not submitted for approval', 71, '2023-09-03 11:43:22', '2023-09-03 11:43:22'),
(11, 'prohect by g5enduser2', 14, 72, '2023-09-03', '16:44:10', 2, 'Not submitted for approval', 72, '2023-09-03 11:44:10', '2023-09-03 11:44:10'),
(12, 'Guest6 Project (own)', 15, 74, '2023-09-09', '16:29:53', 2, 'Not submitted for approval', 74, '2023-09-09 11:29:53', '2023-09-09 11:29:53'),
(13, 'project for g7 by host', 9, 55, '2023-09-09', '16:35:17', 2, 'Not submitted for approval', 55, '2023-09-09 11:35:17', '2023-09-09 11:35:17'),
(14, 'project for g7 by g7enduser', 16, 77, '2023-09-09', '16:36:06', 2, 'Not submitted for approval', 77, '2023-09-09 11:36:06', '2023-09-09 11:36:06');

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
(4, 57, '[\"Project Approver\",\"Data Inputter\",\"Data Viewer\"]', '2023-08-17 12:36:24', '2023-08-17 12:37:08'),
(7, 66, '[\"Data Inputter\"]', '2023-08-29 11:28:42', '2023-08-29 11:28:42'),
(8, 66, '[\"Project Approver\",\"Data Inputter\",\"Data Approver\"]', '2023-08-29 11:37:18', '2023-08-29 11:37:18'),
(9, 55, '[\"Data Inputter\"]', '2023-08-31 07:31:26', '2023-08-31 07:31:26'),
(9, 57, '[\"Data Inputter\",\"Data Viewer\"]', '2023-08-31 07:31:47', '2023-08-31 07:31:47'),
(10, 55, '[\"Project Owner\"]', '2023-09-03 11:43:36', '2023-09-03 11:43:36'),
(11, 72, '[\"Project Creator\",\"Data Inputter\"]', '2023-09-03 11:44:19', '2023-09-03 11:44:59'),
(12, 75, '[\"Data Inputter\",\"Data Approver\",\"Data Viewer\"]', '2023-09-09 11:30:07', '2023-09-09 11:30:07'),
(14, 57, '[\"Data Inputter\"]', '2023-09-09 11:36:22', '2023-09-09 11:36:22');

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
(3, 'Pci dss v4.0', NULL, NULL);

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
(9, 52, 10),
(10, 58, 11),
(11, 61, 11),
(13, 64, 12),
(15, 68, 13),
(17, 70, 14),
(19, 73, 15),
(20, 76, 16);

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
(78, 16, 'g7', 'enduser2', '4210198765432', 'g7enduser2@gmail.com', '033344476787', 'Iqbal town', 'Lahore', 'Sindh', 'Pakistan', 123, '$2y$10$agRP/y9HI6q3/2yqaYNtZOjGe9aH31l82MwE8exvPAZRDTIsr38HO', 'N', 5, 'active', NULL, NULL, '2023-09-09 11:34:14', '2023-09-09 11:34:14');

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
-- Indexes for table `pci-dss v3.2.1 section4.12`
--
ALTER TABLE `pci-dss v3.2.1 section4.12`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`,`last_edited_by`),
  ADD KEY `editby_4.12` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section4.13`
--
ALTER TABLE `pci-dss v3.2.1 section4.13`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`,`last_edited_by`),
  ADD KEY `editby_4.13` (`last_edited_by`);

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `org_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section1.3`
--
ALTER TABLE `pci-dss v3.2.1 section1.3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section4.12`
--
ALTER TABLE `pci-dss v3.2.1 section4.12`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section4.13`
--
ALTER TABLE `pci-dss v3.2.1 section4.13`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `assessment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1009;

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
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- Constraints for dumped tables
--

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
-- Constraints for table `pci-dss v3.2.1 section4.12`
--
ALTER TABLE `pci-dss v3.2.1 section4.12`
  ADD CONSTRAINT `ass_4.12` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3_2_1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editby_4.12` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section4.13`
--
ALTER TABLE `pci-dss v3.2.1 section4.13`
  ADD CONSTRAINT `asses_4.13` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3_2_1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editby_4.13` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
