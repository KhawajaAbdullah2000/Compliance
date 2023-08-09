-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2023 at 12:39 PM
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
(3, 'App\\Models\\User', 8),
(4, 'App\\Models\\User', 5),
(4, 'App\\Models\\User', 6),
(4, 'App\\Models\\User', 7),
(5, 'App\\Models\\User', 4);

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
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

INSERT INTO `organizations` (`name`, `type`, `sub_org`, `country`, `state`, `city`, `zip_code`, `address`, `record_created_by`, `record_creation_date`, `record_creation_time`, `status`, `created_at`, `updated_at`) VALUES
('Fast', 'guest', 'CS', 'Pakistan', 'Sindh', 'karachi', 123, 'National Highway', 'shahmeer@gmail.com', '2023-07-21', '12:05:36', 'active', '2023-07-21 07:05:36', '2023-07-21 07:05:36'),
('HostA', 'host', 'finance', 'Pakistan', 'Sindh', 'Karachi', 67, 'FB area', 'Abdullah', '2023-07-08', '12:58:30', 'active', '2023-07-08 07:58:30', '2023-07-08 07:58:30'),
('Kelectric', 'guest', 'finance', 'Pakistan', 'Sindh', 'karachi', 55, 'Fb area', 'shahmeer@gmail.com', '2023-07-22', '08:52:32', 'active', '2023-07-22 03:52:32', '2023-07-22 03:52:32'),
('Kelectric', 'guest', 'IT', 'Pakistan', 'Punjab', 'Lahore', 99, 'Iqbal town', 'shahmeer@gmail.com', '2023-07-21', '12:36:37', 'active', '2023-07-21 07:36:37', '2023-07-21 07:36:37');

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
(1, 1001, 'Company A', 'Address A', 'www.companya.com', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Company B', 'Address B', 'www.companyb.com', 2, '2023-07-31 12:34:56');

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
-- Dumping data for table `pci-dss v3.2.1 client info`
--

INSERT INTO `pci-dss v3.2.1 client info` (`assessment_id`, `company_name`, `company_address`, `company_url`, `company_contact_name`, `company_contact_number`, `company_email`, `last_edited_by`, `last_edited_at`) VALUES
(1001, 'Client Company X', 'Client Address X', 'www.clientx.com', 'John Doe', '555-123-4567', 'john.doe@example.com', 1, '2023-07-31 12:34:56'),
(1002, 'Client Company Y', 'Client Address Y', 'www.clienty.com', 'Jane Smith', '888-987-6543', 'jane.smith@example.com', 2, '2023-07-31 12:34:56');

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
(1, 1001, '2023-07-15', '2023-07-01', '2023-07-10', 'Time spent onsite...', 1, '2023-07-31 12:34:56'),
(2, 1002, '2023-07-25', '2023-07-20', '2023-07-24', 'Time spent onsite...', 2, '2023-07-31 12:34:56');

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
(3, 1002, '2023-07-21', 2, '2023-07-31 12:34:56');

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
(1, 1001, 'PCI-DSS v3.2.1'),
(2, 1002, 'PCI-DSS v3.2.1');

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
(1, 1001, 'Service 1', 'Efforts made...', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Service 2', 'Efforts made...', 2, '2023-07-31 12:34:56');

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
(1, 1001, 'Req 1', 'Req 2', 'Req 3', 'Req 4', 'Req 5', 'Req 6', 'Req 7', 'Req 8', 'Req 9', 'Req 10', 'Req 11', 'Req 12', 'Req 13', 'Appendix A1', 'Appendix A2', 'Appendix A3', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Req 1', 'Req 2', 'Req 3', 'Req 4', 'Req 5', 'Req 6', 'Req 7', 'Req 8', 'Req 9', 'Req 10', 'Req 11', 'Req 12', 'Req 13', 'Appendix A1', 'Appendix A2', 'Appendix A3', 2, '2023-07-31 12:34:56');

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
(1, 1001, 'Nature of Entity 1', 'Store Method 1', 'Reason for Storage 1', 'Payment Types 1', 'Other Details 1', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Nature of Entity 2', 'Store Method 2', 'Reason for Storage 2', 'Payment Types 2', 'Other Details 2', 2, '2023-07-31 12:34:56');

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
(1, 1001, 'Diagram 1', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Diagram 2', 2, '2023-07-31 12:34:56');

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
(1, 1001, 'Req 1', 'Req 2', 'Req 3', 'Req 4', 'Req 5', 'Req 6', 'Other Details 1', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Req 1', 'Req 2', 'Req 3', 'Req 4', 'Req 5', 'Req 6', 'Other Details 2', 2, '2023-07-31 12:34:56');

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
(1, 1001, 'Req 1', 'Req 2', 'Req 3', 'Req 4', 'Other Details 1', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Req 1', 'Req 2', 'Req 3', 'Req 4', 'Other Details 2', 2, '2023-07-31 12:34:56');

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
(1, 1001, 'Req 1', 'Not Used', 'Used', 'Seg Req 1', 'Seg Req 2', 'Seg Req 3', 'Seg Req 4', 'Seg Req 5', 'Req 5', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Req 1', 'Not Used', 'Used', 'Seg Req 1', 'Seg Req 2', 'Seg Req 3', 'Seg Req 4', 'Seg Req 5', 'Req 5', 2, '2023-07-31 12:34:56');

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
(1, 1001, 'Network Type 1', 'Purpose 1', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Network Type 2', 'Purpose 2', 2, '2023-07-31 12:34:56');

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
(1, 1001, 'Req 1', 'Req 2', 'Req 3', 'Req 4', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Req 1', 'Req 2', 'Req 3', 'Req 4', 2, '2023-07-31 12:34:56');

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
(1, 1001, 'Entity Name 1', 'Country 1', 'Req 1', 'Req 2', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Entity Name 2', 'Country 2', 'Req 1', 'Req 2', 2, '2023-07-31 12:34:00');

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
(1, 1001, 'Entity 1', 'Req 1', 'Req 2', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Entity 2', 'Req 1', 'Req 2', 2, '2023-07-31 12:34:56');

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
(1, 1001, 'No', NULL, NULL, 1, '2023-07-31 12:34:56'),
(2, 1002, 'Yes', 'Details if Yes', NULL, 2, '2023-07-31 12:34:56');

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
(1, 1001, 'Tech 1', 'Yes', 'No', 'Yes', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Tech 2', 'Yes', 'Yes', 'No', 2, '2023-07-31 12:34:56');

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
(1, 1001, 'Tech 1', 'Description 1', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Tech 2', 'Description 2', 2, '2023-07-31 12:34:56');

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
(1, 1001, 'Diagram 1', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Diagram 2', 2, '2023-07-31 12:34:56');

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
(1, 1001, 'Dataflows 1', 'Types of CHD 1', 'Description 1', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Dataflows 2', 'Types of CHD 2', 'Description 2', 2, '2023-07-31 12:34:56');

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
(1, 1001, 'Data Flow Diagram 1', 1, '2023-07-31 12:34:56'),
(2, 1002, 'Data Flow Diagram 2', 2, '2023-07-31 12:34:56');

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
  `project_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_creation_date` date NOT NULL,
  `project_creation_time` time NOT NULL,
  `project_type` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_owner` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_details`
--

CREATE TABLE `project_details` (
  `project_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assigned_enduser` bigint(20) UNSIGNED DEFAULT NULL,
  `last_changed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status_last_changed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'PCI-DSS v3.2.1', NULL, NULL);

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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organizations_sub_org` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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

INSERT INTO `users` (`id`, `organization_name`, `organizations_sub_org`, `first_name`, `last_name`, `national_id`, `email`, `telephone`, `address`, `city`, `state`, `country`, `zip_code`, `password`, `2FA`, `privilege_id`, `status`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'HostA', 'finance', 'Shahmeer', 'Sheraz', NULL, 'shahmeer@gmail.com', '03332227456', 'hussainabad', 'Karachi', 'Sindh', 'Pakistan', 77, '$2y$10$vi4.BBlVe173XB8Y6y/.zehiWOrXzOwpJE8QSGoKTm8/dWsFin2iO', 'N', 4, 'active', NULL, NULL, '2023-07-08 08:03:14', '2023-07-08 03:14:31'),
(2, 'HostA', 'finance', 'Khawaja', 'Abdullah', NULL, 'kabdullah098@gmail.com', '04384834', 'Hussainabad', 'Karachi', 'Sindh', 'Pakistan', 66, '$2y$10$znHSFOfOFFghAQGz1924ieg9xmKPaDDGYqqm8lxe0CXCW/jKI0jiO', 'N', 1, 'active', NULL, '37Z4VvCU9WBMhtXbtTv7dOgqAfq2dxDVmMjcsmsiM4Q18T663Dp7qyQYRpJA', '2023-07-08 10:31:23', '2023-07-22 05:40:56'),
(3, 'Fast', 'CS', 'Sohaib', 'Ashraf', '4210198765432', 'sohaib@gmail.com', '03334447653', '1647/2 Fb area', 'Karachi', 'Sindh', 'USA', 99, '$2y$10$MDvqEhAeuPMdPHOjGHMMaeyvA7H4KxZ8JYGRtXlUYPDmaSh6CYVj6', 'N', 1, 'active', NULL, NULL, '2023-07-23 02:54:01', '2023-07-23 02:54:01'),
(4, 'Kelectric', 'IT', 'Muhammad', 'Shahzaib Ali', '42101987654376', 'shahzaib@gmail.com', '03334447653', 'Fb area', 'karachi', 'Punjab', 'Pakistan', 88, '$2y$10$GPFmjNfecXW0N0AMyR6qH.cz4nNM0.lczfjJluzFNxykIqwof77Y2', 'N', 3, 'active', NULL, NULL, '2023-07-23 02:57:17', '2023-07-24 07:58:06'),
(5, 'Fast', 'CS', 'umer', 'khan', '4210198765432', 'umer@gmail.com', '03334447653', 'Iqbal town', 'lahore', 'Punjab', 'Pakistan', 123, '$2y$10$zEdph.iXdJuh3OnEbvLTlOb5OEiJO3bgoU7gVQNXAY5I2hWoLI9qW', 'N', 2, 'active', NULL, NULL, '2023-07-23 02:58:22', '2023-07-23 02:58:22'),
(6, 'HostA', 'finance', 'Shoaib', 'Ali', '4210198765432', 'shoaib@gmail.com', '03337776523', 'Fb area', 'Karachi', 'Sindh', 'Pakistan', 33, '$2y$10$3NkJlL1DArQwkxKPzKFwZeL2tlnOHdLnZP7wto5EVAIhzWOulkdei', 'N', 2, 'active', NULL, NULL, '2023-07-24 06:51:54', '2023-07-24 06:51:54'),
(7, 'Kelectric', 'IT', 'Muhammad', 'Abdullah Nasir', '4210198765432', 'abdullah@gmail.com', '12345678965', 'Iqbal town', 'lahore', 'Punjab', 'Pakistan', 55, '$2y$10$etrMeWyNoQxnTM6DwWtDNezNJaa/IvO3ojP4LiMx3nS5eP4Ge2yHm', 'N', 2, 'active', NULL, NULL, '2023-07-24 06:52:36', '2023-07-24 07:49:28'),
(8, 'HostA', 'finance', 'Aliuddin', 'Khan', '4210198763423', 'aliuddin@gmail.com', '03337776523', 'Fb area block2', 'isamabad', 'Punjab', 'Pakistan', 66, '$2y$10$WSBPJhpKIDlvFElVqeqNgebGvTaP4f82Ohg/Os.4cFNZx3vPaszHq', 'N', 5, 'active', NULL, NULL, '2023-07-25 00:04:27', '2023-07-25 00:04:27');

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
  ADD PRIMARY KEY (`name`,`sub_org`);

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
  ADD KEY `last_edited_by` (`last_edited_by`);

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
  ADD PRIMARY KEY (`project_code`),
  ADD KEY `user_email` (`user_email`),
  ADD KEY `project_type` (`project_type`);

--
-- Indexes for table `project_details`
--
ALTER TABLE `project_details`
  ADD KEY `project_code` (`project_code`),
  ADD KEY `assigned_enduser` (`assigned_enduser`),
  ADD KEY `last_changed_by` (`last_changed_by`),
  ADD KEY `status_last_changed_by` (`status_last_changed_by`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `project_types`
--
ALTER TABLE `project_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  ADD CONSTRAINT `editsec1fk` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
  ADD CONSTRAINT `projemail` FOREIGN KEY (`user_email`) REFERENCES `users` (`email`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `projtype` FOREIGN KEY (`project_type`) REFERENCES `project_types` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `project_details`
--
ALTER TABLE `project_details`
  ADD CONSTRAINT `endfk` FOREIGN KEY (`assigned_enduser`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `lastchanged` FOREIGN KEY (`last_changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `proj_code` FOREIGN KEY (`project_code`) REFERENCES `projects` (`project_code`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `statusfk` FOREIGN KEY (`status_last_changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
