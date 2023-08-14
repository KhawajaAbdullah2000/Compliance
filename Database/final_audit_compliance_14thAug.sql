-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2023 at 09:27 AM
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
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 22),
(2, 'App\\Models\\User', 24),
(2, 'App\\Models\\User', 34),
(2, 'App\\Models\\User', 35),
(2, 'App\\Models\\User', 36),
(2, 'App\\Models\\User', 55),
(2, 'App\\Models\\User', 59),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 56),
(4, 'App\\Models\\User', 56),
(4, 'App\\Models\\User', 60),
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
(6, 'App\\Models\\User', 53);

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
(11, 'Guest2', 'guest', 'Trade', 'Pakistan', 'Sindh', 'karachi', 123, 'Iqbal town', 'shahmeer@gmail.com', '2023-08-14', '11:36:48', 'active', '2023-08-14 06:36:48', '2023-08-14 06:36:48');

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
-- Table structure for table `pci-dss v3.2.1 assessor company`
--

CREATE TABLE `pci-dss v3.2.1 assessor company` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_address` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_website` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 assessor company`
--

INSERT INTO `pci-dss v3.2.1 assessor company` (`id`, `assessment_id`, `company_name`, `company_address`, `company_website`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'Company A', 'Address A', 'www.companya.com', 1, '2023-07-31 12:34:56'),
(2, NULL, 'Company B', 'Address B', 'www.companyb.com', NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 assessors`
--

CREATE TABLE `pci-dss v3.2.1 assessors` (
  `assessor_id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `assessor_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Assessor_PCI_credentials` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 assessors`
--

INSERT INTO `pci-dss v3.2.1 assessors` (`assessor_id`, `assessment_id`, `assessor_name`, `Assessor_PCI_credentials`, `phone_number`, `email`, `last_edited_by`, `last_edited_at`) VALUES
(1, 1001, 'Assessor 1', 'PCI-1', '123-456-7890', 'assessor1@example.com', 101, '2023-07-31 12:34:56'),
(2, 1001, 'Assessor 2', 'PCI-2', '987-654-3210', 'assessor2@example.com', 102, '2023-07-31 12:34:56'),
(1, 1001, 'Assessor 1', 'PCI-1', '123-456-7890', 'assessor1@example.com', 101, '2023-07-31 12:34:56'),
(2, 1001, 'Assessor 2', 'PCI-2', '987-654-3210', 'assessor2@example.com', 102, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 client info`
--

CREATE TABLE `pci-dss v3.2.1 client info` (
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

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 qa`
--

CREATE TABLE `pci-dss v3.2.1 qa` (
  `qa_id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `reviewer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reviewer_phone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reviewer_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 qa`
--

INSERT INTO `pci-dss v3.2.1 qa` (`qa_id`, `assessment_id`, `reviewer_name`, `reviewer_phone`, `reviewer_email`, `last_edited_by`, `last_edited_at`) VALUES
(1, 1001, 'Reviewer 1', '111-222-3333', 'reviewer1@example.com', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Reviewer 2', '444-555-6666', 'reviewer2@example.com', 2, '2023-07-31 12:34:56'),
(1, 1001, 'Reviewer 1', '111-222-3333', 'reviewer1@example.com', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Reviewer 2', '444-555-6666', 'reviewer2@example.com', 2, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section1.2`
--

CREATE TABLE `pci-dss v3.2.1 section1.2` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `date_of_report` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `describe_time_spent_onsite` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section1.2`
--

INSERT INTO `pci-dss v3.2.1 section1.2` (`id`, `assessment_id`, `date_of_report`, `start_date`, `end_date`, `describe_time_spent_onsite`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, '2023-07-15', '2023-07-01', '2023-07-10', 'Time spent onsite...', 1, '2023-07-31 12:34:56'),
(2, NULL, '2023-07-25', '2023-07-20', '2023-07-24', 'Time spent onsite...', NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section1.2_dates_spent_onsite`
--

CREATE TABLE `pci-dss v3.2.1 section1.2_dates_spent_onsite` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `date_spent_onsite` date NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section1.2_dates_spent_onsite`
--

INSERT INTO `pci-dss v3.2.1 section1.2_dates_spent_onsite` (`id`, `assessment_id`, `date_spent_onsite`, `last_edited_by`, `last_edited_at`) VALUES
(1, 1001, '2023-07-02', 1, '2023-07-31 12:34:56'),
(2, 1001, '2023-07-03', 1, '2023-07-31 12:34:56'),
(3, 1002, '2023-07-21', NULL, '2023-07-31 12:34:56');

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
-- Table structure for table `pci-dss v3.2.1 section1.4`
--

CREATE TABLE `pci-dss v3.2.1 section1.4` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `services_offered` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `efforts_made_to_ensure_no_conflict` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section1.4`
--

INSERT INTO `pci-dss v3.2.1 section1.4` (`id`, `assessment_id`, `services_offered`, `efforts_made_to_ensure_no_conflict`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'Service 1', 'Efforts made...', 1, '2023-07-31 12:34:56'),
(2, NULL, 'Service 2', 'Efforts made...', NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section1.5`
--

CREATE TABLE `pci-dss v3.2.1 section1.5` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
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
  `requirement13` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appendix_A1` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appendix_A2` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appendix_A3` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section1.5`
--

INSERT INTO `pci-dss v3.2.1 section1.5` (`id`, `assessment_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `requirement5`, `requirement6`, `requirement7`, `requirement8`, `requirement9`, `requirement10`, `requirement11`, `requirement12`, `requirement13`, `appendix_A1`, `appendix_A2`, `appendix_A3`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'Req 1', 'Req 2', 'Req 3', 'Req 4', 'Req 5', 'Req 6', 'Req 7', 'Req 8', 'Req 9', 'Req 10', 'Req 11', 'Req 12', 'Req 13', 'Appendix A1', 'Appendix A2', 'Appendix A3', 1, '2023-07-31 12:34:56'),
(2, NULL, 'Req 1', 'Req 2', 'Req 3', 'Req 4', 'Req 5', 'Req 6', 'Req 7', 'Req 8', 'Req 9', 'Req 10', 'Req 11', 'Req 12', 'Req 13', 'Appendix A1', 'Appendix A2', 'Appendix A3', NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section2.1`
--

CREATE TABLE `pci-dss v3.2.1 section2.1` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `nature_entity_business` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `how_entity_store_cardholder_data` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `why_entity_store_cardholder_data` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_channel_types` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_details` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section2.1`
--

INSERT INTO `pci-dss v3.2.1 section2.1` (`id`, `assessment_id`, `nature_entity_business`, `how_entity_store_cardholder_data`, `why_entity_store_cardholder_data`, `payment_channel_types`, `other_details`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'Nature of Entity 1', 'Store Method 1', 'Reason for Storage 1', 'Payment Types 1', 'Other Details 1', 1, '2023-07-31 12:34:56'),
(2, NULL, 'Nature of Entity 2', 'Store Method 2', 'Reason for Storage 2', 'Payment Types 2', 'Other Details 2', NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section2.2`
--

CREATE TABLE `pci-dss v3.2.1 section2.2` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `diagram` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section2.2`
--

INSERT INTO `pci-dss v3.2.1 section2.2` (`id`, `assessment_id`, `diagram`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'Diagram 1', 1, '2023-07-31 12:34:56'),
(2, NULL, 'Diagram 2', NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section3.1`
--

CREATE TABLE `pci-dss v3.2.1 section3.1` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `requirement1` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement2` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement3` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement4` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement5` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement6` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_details` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section3.1`
--

INSERT INTO `pci-dss v3.2.1 section3.1` (`id`, `assessment_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `requirement5`, `requirement6`, `other_details`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'Req 1', 'Req 2', 'Req 3', 'Req 4', 'Req 5', 'Req 6', 'Other Details 1', 1, '2023-07-31 12:34:56'),
(2, NULL, 'Req 1', 'Req 2', 'Req 3', 'Req 4', 'Req 5', 'Req 6', 'Other Details 2', NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section3.2`
--

CREATE TABLE `pci-dss v3.2.1 section3.2` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `requirement1` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement2` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement3` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement4` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_details` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section3.2`
--

INSERT INTO `pci-dss v3.2.1 section3.2` (`id`, `assessment_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `other_details`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'Req 1', 'Req 2', 'Req 3', 'Req 4', 'Other Details 1', 1, '2023-07-31 12:34:56'),
(2, NULL, 'Req 1', 'Req 2', 'Req 3', 'Req 4', 'Other Details 2', NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section3.3`
--

CREATE TABLE `pci-dss v3.2.1 section3.3` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `requirement1` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segmentation_not_used` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segmentation_used` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segmentation_used_req1` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segmentation_used_req2` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segmentation_used_req3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segmentation_used_req4` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segmentation_used_req5` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requirement5` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section3.3`
--

INSERT INTO `pci-dss v3.2.1 section3.3` (`id`, `assessment_id`, `requirement1`, `segmentation_not_used`, `segmentation_used`, `segmentation_used_req1`, `segmentation_used_req2`, `segmentation_used_req3`, `segmentation_used_req4`, `segmentation_used_req5`, `requirement5`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'Req 1', 'Not Used', 'Used', 'Seg Req 1', 'Seg Req 2', 'Seg Req 3', 'Seg Req 4', 'Seg Req 5', 'Req 5', 1, '2023-07-31 12:34:56'),
(2, NULL, 'Req 1', 'Not Used', 'Used', 'Seg Req 1', 'Seg Req 2', 'Seg Req 3', 'Seg Req 4', 'Seg Req 5', 'Req 5', NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section3.4`
--

CREATE TABLE `pci-dss v3.2.1 section3.4` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `network_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose_of_network` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section3.4`
--

INSERT INTO `pci-dss v3.2.1 section3.4` (`id`, `assessment_id`, `network_type`, `purpose_of_network`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'Network Type 1', 'Purpose 1', 1, '2023-07-31 12:34:56'),
(2, NULL, 'Network Type 2', 'Purpose 2', NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section3.5`
--

CREATE TABLE `pci-dss v3.2.1 section3.5` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `requirement1` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement2` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement3` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement4` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section3.5`
--

INSERT INTO `pci-dss v3.2.1 section3.5` (`id`, `assessment_id`, `requirement1`, `requirement2`, `requirement3`, `requirement4`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'Req 1', 'Req 2', 'Req 3', 'Req 4', 1, '2023-07-31 12:34:56'),
(2, NULL, 'Req 1', 'Req 2', 'Req 3', 'Req 4', NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section3.6 international_entity`
--

CREATE TABLE `pci-dss v3.2.1 section3.6 international_entity` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `entity_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement1` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement2` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section3.6 international_entity`
--

INSERT INTO `pci-dss v3.2.1 section3.6 international_entity` (`id`, `assessment_id`, `entity_name`, `country`, `requirement1`, `requirement2`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'Entity Name 1', 'Country 1', 'Req 1', 'Req 2', 1, '2023-07-31 12:34:56'),
(2, NULL, 'Entity Name 2', 'Country 2', 'Req 1', 'Req 2', NULL, '2023-07-31 12:34:00');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section3.6 wholly_owned_entity`
--

CREATE TABLE `pci-dss v3.2.1 section3.6 wholly_owned_entity` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `wholly_owned_entity` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requirement2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section3.6 wholly_owned_entity`
--

INSERT INTO `pci-dss v3.2.1 section3.6 wholly_owned_entity` (`id`, `assessment_id`, `wholly_owned_entity`, `requirement1`, `requirement2`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'Entity 1', 'Req 1', 'Req 2', 1, '2023-07-31 12:34:56'),
(2, NULL, 'Entity 2', 'Req 1', 'Req 2', NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section3.7`
--

CREATE TABLE `pci-dss v3.2.1 section3.7` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `wireless_used_or_not` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `if_no` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `if_yes` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section3.7`
--

INSERT INTO `pci-dss v3.2.1 section3.7` (`id`, `assessment_id`, `wireless_used_or_not`, `if_no`, `if_yes`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'No', NULL, NULL, 1, '2023-07-31 12:34:56'),
(2, NULL, 'Yes', 'Details if Yes', NULL, NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section3.8 in_scope`
--

CREATE TABLE `pci-dss v3.2.1 section3.8 in_scope` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `wireless_technology` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement1` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement2` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement3` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section3.8 in_scope`
--

INSERT INTO `pci-dss v3.2.1 section3.8 in_scope` (`id`, `assessment_id`, `wireless_technology`, `requirement1`, `requirement2`, `requirement3`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'Tech 1', 'Yes', 'No', 'Yes', 1, '2023-07-31 12:34:56'),
(2, NULL, 'Tech 2', 'Yes', 'Yes', 'No', NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section3.8 out_scope`
--

CREATE TABLE `pci-dss v3.2.1 section3.8 out_scope` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `wireless_technology` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section3.8 out_scope`
--

INSERT INTO `pci-dss v3.2.1 section3.8 out_scope` (`id`, `assessment_id`, `wireless_technology`, `description`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'Tech 1', 'Description 1', 1, '2023-07-31 12:34:56'),
(2, NULL, 'Tech 2', 'Description 2', NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section4.1`
--

CREATE TABLE `pci-dss v3.2.1 section4.1` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `network_diagrams` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section4.1`
--

INSERT INTO `pci-dss v3.2.1 section4.1` (`id`, `assessment_id`, `network_diagrams`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'Diagram 1', 1, '2023-07-31 12:34:56'),
(2, NULL, 'Diagram 2', NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section4.2_dataflows`
--

CREATE TABLE `pci-dss v3.2.1 section4.2_dataflows` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `dataflows` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `types_of_chd` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section4.2_dataflows`
--

INSERT INTO `pci-dss v3.2.1 section4.2_dataflows` (`id`, `assessment_id`, `dataflows`, `types_of_chd`, `description`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'Dataflows 1', 'Types of CHD 1', 'Description 1', 1, '2023-07-31 12:34:56'),
(2, NULL, 'Dataflows 2', 'Types of CHD 2', 'Description 2', NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section4.2_diagrams`
--

CREATE TABLE `pci-dss v3.2.1 section4.2_diagrams` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `data_flow_diagram` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pci-dss v3.2.1 section4.2_diagrams`
--

INSERT INTO `pci-dss v3.2.1 section4.2_diagrams` (`id`, `assessment_id`, `data_flow_diagram`, `last_edited_by`, `last_edited_at`) VALUES
(1, NULL, 'Data Flow Diagram 1', 1, '2023-07-31 12:34:56'),
(2, NULL, 'Data Flow Diagram 2', NULL, '2023-07-31 12:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section4.3`
--

CREATE TABLE `pci-dss v3.2.1 section4.3` (
  `id` int(11) NOT NULL,
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `requirement1` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement2` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement3` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement4` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement5` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section4.4`
--

CREATE TABLE `pci-dss v3.2.1 section4.4` (
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `id` int(11) NOT NULL,
  `requirement1` varchar(300) NOT NULL,
  `requirement2` varchar(300) NOT NULL,
  `requirement3` varchar(300) NOT NULL,
  `requirement4` varchar(300) NOT NULL,
  `requirement5` varchar(300) NOT NULL,
  `requirement6` varchar(300) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section4.5`
--

CREATE TABLE `pci-dss v3.2.1 section4.5` (
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `id` int(11) NOT NULL,
  `requirement1` varchar(300) NOT NULL,
  `requirement2` varchar(300) NOT NULL,
  `requirement3` varchar(300) NOT NULL,
  `requirement4` varchar(300) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section4.6`
--

CREATE TABLE `pci-dss v3.2.1 section4.6` (
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `id` int(11) NOT NULL,
  `requirement1` varchar(300) NOT NULL,
  `requirement2` varchar(300) NOT NULL,
  `requirement3` varchar(300) NOT NULL,
  `requirement4` varchar(300) NOT NULL,
  `requirement5` varchar(300) NOT NULL,
  `requirement6` varchar(300) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section4.7`
--

CREATE TABLE `pci-dss v3.2.1 section4.7` (
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `id` int(11) NOT NULL,
  `requirement1` varchar(300) NOT NULL,
  `requirement2` varchar(300) NOT NULL,
  `requirement3` varchar(300) NOT NULL,
  `requirement4` varchar(300) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section4.8`
--

CREATE TABLE `pci-dss v3.2.1 section4.8` (
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `id` int(11) NOT NULL,
  `requirement1` varchar(100) NOT NULL,
  `requirement2` varchar(100) NOT NULL,
  `requirement3` varchar(5) NOT NULL,
  `requirement4` varchar(5) NOT NULL,
  `requirement5` varchar(100) NOT NULL,
  `requirement6` date DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section4.9`
--

CREATE TABLE `pci-dss v3.2.1 section4.9` (
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `id` int(11) NOT NULL,
  `requirement1` varchar(300) NOT NULL,
  `requirement2` varchar(300) NOT NULL,
  `requirement3` varchar(300) NOT NULL,
  `requirement4` date NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section4.10`
--

CREATE TABLE `pci-dss v3.2.1 section4.10` (
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `id` int(11) NOT NULL,
  `requirement1` varchar(300) NOT NULL,
  `requirement2` varchar(300) NOT NULL,
  `requirement3` varchar(300) NOT NULL,
  `requirement4` varchar(300) NOT NULL,
  `requirement5` varchar(5) NOT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pci-dss v3.2.1 section4.11`
--

CREATE TABLE `pci-dss v3.2.1 section4.11` (
  `assessment_id` int(10) UNSIGNED DEFAULT NULL,
  `id` int(11) NOT NULL,
  `requirement1` varchar(5) NOT NULL,
  `requirement2` varchar(100) DEFAULT NULL,
  `requirement3` varchar(100) DEFAULT NULL,
  `requirement4` varchar(100) DEFAULT NULL,
  `requirement5` int(100) DEFAULT NULL,
  `requirement6` varchar(100) DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(6, 'Audit by g2enduser1', 11, 59, '2023-08-14', '11:40:10', 2, 'Not submitted for approval', 59, '2023-08-14 06:40:10', '2023-08-14 06:40:10');

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
(1, 54, '[\"Project Owner\",\"Data Inputter\",\"Data Approver\"]', '2023-08-14 06:33:49', '2023-08-14 07:24:40');

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
(9, 52, 10),
(10, 58, 11);

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
(60, 11, 'G2', 'enduser2', '3443', 'g2enduser2@gmail.com', '34324', 'Azizabad', 'London', 'Sindh', 'Pakistan', 123, '$2y$10$eQDQX1arLN2RxLuHq3QTMeRs.K64ytjaAqDp3yPNjaEhOqf5vj6Jy', 'N', 5, 'active', NULL, NULL, '2023-08-14 06:39:41', '2023-08-14 06:39:41');

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
-- Indexes for table `pci-dss v3.2.1 assessor company`
--
ALTER TABLE `pci-dss v3.2.1 assessor company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `editsecassescompanyfk` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 client info`
--
ALTER TABLE `pci-dss v3.2.1 client info`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `pci-dss v3.2.1 section1.2`
--
ALTER TABLE `pci-dss v3.2.1 section1.2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `editsec1.2fk` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section1.2_dates_spent_onsite`
--
ALTER TABLE `pci-dss v3.2.1 section1.2_dates_spent_onsite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `editsec1.2datesfk` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section1.3`
--
ALTER TABLE `pci-dss v3.2.1 section1.3`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`);

--
-- Indexes for table `pci-dss v3.2.1 section1.4`
--
ALTER TABLE `pci-dss v3.2.1 section1.4`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `editsec1.4fk` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section1.5`
--
ALTER TABLE `pci-dss v3.2.1 section1.5`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `assessment_id_2` (`assessment_id`),
  ADD KEY `editsec1.5fk` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section2.1`
--
ALTER TABLE `pci-dss v3.2.1 section2.1`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `editsec2.1fk` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section2.2`
--
ALTER TABLE `pci-dss v3.2.1 section2.2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `editsec2.2fk` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section3.1`
--
ALTER TABLE `pci-dss v3.2.1 section3.1`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `editsec3.1fk` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section3.2`
--
ALTER TABLE `pci-dss v3.2.1 section3.2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `editsec3.2fk` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section3.3`
--
ALTER TABLE `pci-dss v3.2.1 section3.3`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `editsec3.3fk` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section3.4`
--
ALTER TABLE `pci-dss v3.2.1 section3.4`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section3.5`
--
ALTER TABLE `pci-dss v3.2.1 section3.5`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section3.6 international_entity`
--
ALTER TABLE `pci-dss v3.2.1 section3.6 international_entity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section3.6 wholly_owned_entity`
--
ALTER TABLE `pci-dss v3.2.1 section3.6 wholly_owned_entity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section3.7`
--
ALTER TABLE `pci-dss v3.2.1 section3.7`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section3.8 in_scope`
--
ALTER TABLE `pci-dss v3.2.1 section3.8 in_scope`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section3.8 out_scope`
--
ALTER TABLE `pci-dss v3.2.1 section3.8 out_scope`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section4.1`
--
ALTER TABLE `pci-dss v3.2.1 section4.1`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section4.2_dataflows`
--
ALTER TABLE `pci-dss v3.2.1 section4.2_dataflows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section4.2_diagrams`
--
ALTER TABLE `pci-dss v3.2.1 section4.2_diagrams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section4.3`
--
ALTER TABLE `pci-dss v3.2.1 section4.3`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section4.4`
--
ALTER TABLE `pci-dss v3.2.1 section4.4`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section4.5`
--
ALTER TABLE `pci-dss v3.2.1 section4.5`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section4.6`
--
ALTER TABLE `pci-dss v3.2.1 section4.6`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section4.7`
--
ALTER TABLE `pci-dss v3.2.1 section4.7`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section4.8`
--
ALTER TABLE `pci-dss v3.2.1 section4.8`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `last_edited_by` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section4.9`
--
ALTER TABLE `pci-dss v3.2.1 section4.9`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`,`last_edited_by`),
  ADD KEY `ass_4.9_editby` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section4.10`
--
ALTER TABLE `pci-dss v3.2.1 section4.10`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`,`last_edited_by`),
  ADD KEY `editby_4.10` (`last_edited_by`);

--
-- Indexes for table `pci-dss v3.2.1 section4.11`
--
ALTER TABLE `pci-dss v3.2.1 section4.11`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_id` (`assessment_id`,`last_edited_by`),
  ADD KEY `editby_4.11` (`last_edited_by`);

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
  MODIFY `org_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 assessor company`
--
ALTER TABLE `pci-dss v3.2.1 assessor company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 client info`
--
ALTER TABLE `pci-dss v3.2.1 client info`
  MODIFY `assessment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1003;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section1.2`
--
ALTER TABLE `pci-dss v3.2.1 section1.2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section1.2_dates_spent_onsite`
--
ALTER TABLE `pci-dss v3.2.1 section1.2_dates_spent_onsite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section1.3`
--
ALTER TABLE `pci-dss v3.2.1 section1.3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section1.4`
--
ALTER TABLE `pci-dss v3.2.1 section1.4`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section1.5`
--
ALTER TABLE `pci-dss v3.2.1 section1.5`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section2.1`
--
ALTER TABLE `pci-dss v3.2.1 section2.1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section2.2`
--
ALTER TABLE `pci-dss v3.2.1 section2.2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section3.1`
--
ALTER TABLE `pci-dss v3.2.1 section3.1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section3.2`
--
ALTER TABLE `pci-dss v3.2.1 section3.2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section3.3`
--
ALTER TABLE `pci-dss v3.2.1 section3.3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section3.4`
--
ALTER TABLE `pci-dss v3.2.1 section3.4`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section3.5`
--
ALTER TABLE `pci-dss v3.2.1 section3.5`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section3.6 international_entity`
--
ALTER TABLE `pci-dss v3.2.1 section3.6 international_entity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section3.6 wholly_owned_entity`
--
ALTER TABLE `pci-dss v3.2.1 section3.6 wholly_owned_entity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section3.7`
--
ALTER TABLE `pci-dss v3.2.1 section3.7`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section3.8 in_scope`
--
ALTER TABLE `pci-dss v3.2.1 section3.8 in_scope`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section3.8 out_scope`
--
ALTER TABLE `pci-dss v3.2.1 section3.8 out_scope`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section4.1`
--
ALTER TABLE `pci-dss v3.2.1 section4.1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section4.2_dataflows`
--
ALTER TABLE `pci-dss v3.2.1 section4.2_dataflows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section4.2_diagrams`
--
ALTER TABLE `pci-dss v3.2.1 section4.2_diagrams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section4.3`
--
ALTER TABLE `pci-dss v3.2.1 section4.3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section4.4`
--
ALTER TABLE `pci-dss v3.2.1 section4.4`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section4.5`
--
ALTER TABLE `pci-dss v3.2.1 section4.5`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section4.6`
--
ALTER TABLE `pci-dss v3.2.1 section4.6`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section4.7`
--
ALTER TABLE `pci-dss v3.2.1 section4.7`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section4.8`
--
ALTER TABLE `pci-dss v3.2.1 section4.8`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section4.9`
--
ALTER TABLE `pci-dss v3.2.1 section4.9`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section4.10`
--
ALTER TABLE `pci-dss v3.2.1 section4.10`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pci-dss v3.2.1 section4.11`
--
ALTER TABLE `pci-dss v3.2.1 section4.11`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project_types`
--
ALTER TABLE `project_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `superusers`
--
ALTER TABLE `superusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

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
-- Constraints for table `pci-dss v3.2.1 assessor company`
--
ALTER TABLE `pci-dss v3.2.1 assessor company`
  ADD CONSTRAINT `assesro_fk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editsecassescompanyfk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 client info`
--
ALTER TABLE `pci-dss v3.2.1 client info`
  ADD CONSTRAINT `editsec1fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `project id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pci-dss v3.2.1 section1.2`
--
ALTER TABLE `pci-dss v3.2.1 section1.2`
  ADD CONSTRAINT `date_fk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editsec1.2fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section1.2_dates_spent_onsite`
--
ALTER TABLE `pci-dss v3.2.1 section1.2_dates_spent_onsite`
  ADD CONSTRAINT `editsec1.2datesfk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section1.3`
--
ALTER TABLE `pci-dss v3.2.1 section1.3`
  ADD CONSTRAINT `section1.3fk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section1.4`
--
ALTER TABLE `pci-dss v3.2.1 section1.4`
  ADD CONSTRAINT `editsec1.4fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec1.4fk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section1.5`
--
ALTER TABLE `pci-dss v3.2.1 section1.5`
  ADD CONSTRAINT `1.5secfk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editsec1.5fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section2.1`
--
ALTER TABLE `pci-dss v3.2.1 section2.1`
  ADD CONSTRAINT `editsec2.1fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec2.1_fk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section2.2`
--
ALTER TABLE `pci-dss v3.2.1 section2.2`
  ADD CONSTRAINT `editsec2.2fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec2.2fk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section3.1`
--
ALTER TABLE `pci-dss v3.2.1 section3.1`
  ADD CONSTRAINT `editsec3.1fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec3.1fk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section3.2`
--
ALTER TABLE `pci-dss v3.2.1 section3.2`
  ADD CONSTRAINT `editsec3.2fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `section3.2fk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section3.3`
--
ALTER TABLE `pci-dss v3.2.1 section3.3`
  ADD CONSTRAINT `ass_id3.3fk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editsec3.3fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section3.4`
--
ALTER TABLE `pci-dss v3.2.1 section3.4`
  ADD CONSTRAINT `editsec3.4fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec3.4fk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section3.5`
--
ALTER TABLE `pci-dss v3.2.1 section3.5`
  ADD CONSTRAINT `editsec3.5fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec3.5assfk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section3.6 international_entity`
--
ALTER TABLE `pci-dss v3.2.1 section3.6 international_entity`
  ADD CONSTRAINT `editsec3.6part2fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec3.6part2fk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section3.6 wholly_owned_entity`
--
ALTER TABLE `pci-dss v3.2.1 section3.6 wholly_owned_entity`
  ADD CONSTRAINT `editsec3.6part1fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec3.6part1fk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section3.7`
--
ALTER TABLE `pci-dss v3.2.1 section3.7`
  ADD CONSTRAINT `editsec3.7fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec3.7fk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section3.8 in_scope`
--
ALTER TABLE `pci-dss v3.2.1 section3.8 in_scope`
  ADD CONSTRAINT `editsec3.8scopefk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec3.8in_scope` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section3.8 out_scope`
--
ALTER TABLE `pci-dss v3.2.1 section3.8 out_scope`
  ADD CONSTRAINT `editsec3.8putfk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec3.8out_scope` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section4.1`
--
ALTER TABLE `pci-dss v3.2.1 section4.1`
  ADD CONSTRAINT `4.1assfk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editsec4.1fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section4.2_dataflows`
--
ALTER TABLE `pci-dss v3.2.1 section4.2_dataflows`
  ADD CONSTRAINT `4.2_dataflows_fkass` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editsec4.2_dataflowfk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section4.2_diagrams`
--
ALTER TABLE `pci-dss v3.2.1 section4.2_diagrams`
  ADD CONSTRAINT `4.2_diagassfk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editsec4.2_diagramfk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section4.3`
--
ALTER TABLE `pci-dss v3.2.1 section4.3`
  ADD CONSTRAINT `editsec4.3fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec4.3fkass` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section4.4`
--
ALTER TABLE `pci-dss v3.2.1 section4.4`
  ADD CONSTRAINT `lastedit_4.4` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sec4.4idass` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section4.5`
--
ALTER TABLE `pci-dss v3.2.1 section4.5`
  ADD CONSTRAINT `asses_sec4.5` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `last_edit4.5` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section4.6`
--
ALTER TABLE `pci-dss v3.2.1 section4.6`
  ADD CONSTRAINT `asses_4.6` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editbyz_4.6` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section4.7`
--
ALTER TABLE `pci-dss v3.2.1 section4.7`
  ADD CONSTRAINT `as_4.7` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editby_4.7` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section4.8`
--
ALTER TABLE `pci-dss v3.2.1 section4.8`
  ADD CONSTRAINT `as_4.8` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editby_4.8` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section4.9`
--
ALTER TABLE `pci-dss v3.2.1 section4.9`
  ADD CONSTRAINT `ass_4.9_editby` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `asses_4.9` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section4.10`
--
ALTER TABLE `pci-dss v3.2.1 section4.10`
  ADD CONSTRAINT `ass_4.10` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editby_4.10` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section4.11`
--
ALTER TABLE `pci-dss v3.2.1 section4.11`
  ADD CONSTRAINT `ases_4.11` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editby_4.11` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section4.12`
--
ALTER TABLE `pci-dss v3.2.1 section4.12`
  ADD CONSTRAINT `ass_4.12` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editby_4.12` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section4.13`
--
ALTER TABLE `pci-dss v3.2.1 section4.13`
  ADD CONSTRAINT `asses_4.13` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editby_4.13` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section5.1_asv_quarterly`
--
ALTER TABLE `pci-dss v3.2.1 section5.1_asv_quarterly`
  ADD CONSTRAINT `ass_5.1_asv` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `edit5.1_asv` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section5.1_quarterly_results`
--
ALTER TABLE `pci-dss v3.2.1 section5.1_quarterly_results`
  ADD CONSTRAINT `asses_5.1_quarterly` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editby5.1_quarter` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pci-dss v3.2.1 section5.2`
--
ALTER TABLE `pci-dss v3.2.1 section5.2`
  ADD CONSTRAINT `asses5.2_fk` FOREIGN KEY (`assessment_id`) REFERENCES `pci-dss v3.2.1 client info` (`assessment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `editby5.2` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
