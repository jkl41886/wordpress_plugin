-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 04, 2019 at 11:41 AM
-- Server version: 10.1.37-MariaDB-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `innsystc_wp649`
--

-- --------------------------------------------------------

--
-- Table structure for table `haccp_allergen`
--

CREATE TABLE `haccp_allergen` (
  `allergen_id` bigint(20) NOT NULL,
  `allergen_name` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `allergen_status` tinyint(4) NOT NULL DEFAULT '1',
  `allergen_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `haccp_allergen`
--

INSERT INTO `haccp_allergen` (`allergen_id`, `allergen_name`, `allergen_status`, `allergen_time`) VALUES
(1, 'Gluten', 1, '2019-01-22 16:07:12'),
(2, 'Crustaceans', 1, '2019-01-22 16:07:12'),
(3, 'Eggs', 1, '2019-01-22 16:07:12'),
(4, 'Fish', 1, '2019-01-22 16:07:12'),
(5, 'Peanuts', 1, '2019-01-22 16:07:12'),
(6, 'Soybeans', 1, '2019-01-22 16:07:12'),
(7, 'Lactose(milk etc)', 1, '2019-01-22 16:07:12'),
(8, 'Nuts', 1, '2019-01-22 16:07:12'),
(9, 'Celery', 1, '2019-01-22 16:07:12'),
(10, 'Mustard', 1, '2019-01-22 16:07:12'),
(11, 'Sesame', 1, '2019-01-22 16:07:12'),
(12, 'Sulphur', 1, '2019-01-22 16:07:12'),
(13, 'Lupin', 1, '2019-01-22 16:06:37'),
(14, 'Molluscs', 1, '2019-01-22 16:06:37');

-- --------------------------------------------------------

--
-- Table structure for table `haccp_allergen_sub`
--

CREATE TABLE `haccp_allergen_sub` (
  `allergen_sub_id` bigint(20) NOT NULL,
  `allergen_id` bigint(20) NOT NULL,
  `allergen_sub_name` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `allergen_sub_status` tinyint(4) NOT NULL,
  `allergen_sub_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `haccp_allergen_sub`
--

INSERT INTO `haccp_allergen_sub` (`allergen_sub_id`, `allergen_id`, `allergen_sub_name`, `allergen_sub_status`, `allergen_sub_time`) VALUES
(1, 1, 'Wheat', 0, '2019-02-04 14:04:03'),
(2, 1, 'Spelt', 1, '2019-02-04 13:59:08'),
(3, 1, 'Khorasan', 1, '2019-02-04 13:59:30'),
(4, 1, 'Wheat', 1, '2019-02-04 13:59:39'),
(5, 2, 'Prawns', 1, '2019-02-04 14:00:53'),
(6, 2, 'Crabs', 1, '2019-02-04 14:01:01'),
(7, 2, 'Lobster', 1, '2019-02-04 14:01:10'),
(8, 8, 'Hazelnuts', 1, '2019-02-04 14:01:29'),
(9, 8, 'Almonds', 1, '2019-02-04 14:01:40'),
(10, 1, 'Wheats', 0, '2019-02-04 14:04:30'),
(11, 1, 'Rye', 0, '2019-02-04 14:04:50'),
(12, 1, 'Ryes', 1, '2019-02-04 14:04:50'),
(13, 1, 'Ryes', 1, '2019-02-04 14:05:43'),
(14, 1, 'Ryes', 1, '2019-02-04 14:05:58'),
(15, 1, 'Ryes', 1, '2019-02-04 14:06:09');

-- --------------------------------------------------------

--
-- Table structure for table `haccp_daily`
--

CREATE TABLE `haccp_daily` (
  `daily_id` bigint(20) NOT NULL,
  `daily_type` tinyint(4) NOT NULL,
  `daily_name` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `daily_default_value` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `daily_status` tinyint(4) NOT NULL,
  `daily_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `haccp_daily`
--

INSERT INTO `haccp_daily` (`daily_id`, `daily_type`, `daily_name`, `daily_default_value`, `daily_status`, `daily_time`) VALUES
(1, 3, 'Pests', 'No', 1, '2019-02-04 13:45:45'),
(2, 1, 'Front serve over', '5', 1, '2019-02-04 13:46:02'),
(3, 1, 'Front', '6', 1, '2019-02-04 13:46:15'),
(4, 2, 'Back chest', '-20', 1, '2019-02-04 13:46:34'),
(5, 1, 'mistake 1', '3', 0, '2019-02-04 13:48:06'),
(6, 1, 'mistake 2', '3', 0, '2019-02-04 13:49:27'),
(7, 1, 'rename mistake 1', '3', 1, '2019-02-04 13:48:06'),
(8, 2, 'mistake 2 change to freezer', '-22', 0, '2019-02-04 13:50:02');

-- --------------------------------------------------------

--
-- Table structure for table `haccp_daily_checks`
--

CREATE TABLE `haccp_daily_checks` (
  `daily_checks_id` bigint(20) NOT NULL,
  `daily_checks_time` datetime NOT NULL,
  `equipment_id` bigint(20) NOT NULL,
  `daily_checks_name` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `daily_checks_actual_value` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `daily_checks_comments` char(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `haccp_daily_checks`
--

INSERT INTO `haccp_daily_checks` (`daily_checks_id`, `daily_checks_time`, `equipment_id`, `daily_checks_name`, `daily_checks_actual_value`, `daily_checks_comments`) VALUES
(1, '2019-02-04 14:13:18', 2, 'Front serve over', '5', ''),
(2, '2019-02-04 14:13:18', 3, 'Front', '6', ''),
(3, '2019-02-04 14:13:18', 7, 'rename mistake 1', '3', ''),
(4, '2019-02-04 14:13:18', 4, 'Back chest', '-20', ''),
(5, '2019-02-04 14:13:18', 1, 'Pests', 'No', '');

-- --------------------------------------------------------

--
-- Table structure for table `haccp_goods_in`
--

CREATE TABLE `haccp_goods_in` (
  `goods_in_id` bigint(20) NOT NULL,
  `goods_in_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `product_id` bigint(20) NOT NULL,
  `supplier_id` bigint(20) NOT NULL,
  `goods_in_use_by` date NOT NULL,
  `goods_in_batch` char(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `goods_in_description` char(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `goods_in_comments` char(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `haccp_goods_in`
--

INSERT INTO `haccp_goods_in` (`goods_in_id`, `goods_in_time`, `product_id`, `supplier_id`, `goods_in_use_by`, `goods_in_batch`, `goods_in_description`, `goods_in_comments`) VALUES
(1, '2019-02-04 14:26:24', 2, 2, '2019-02-13', ';SIUHP;A', '1 0 kg', 'NO COMMENT'),
(2, '2019-02-04 14:26:24', 6, 4, '2019-03-08', '765', '10kg', '');

-- --------------------------------------------------------

--
-- Table structure for table `haccp_item_allergens`
--

CREATE TABLE `haccp_item_allergens` (
  `item_allergens_id` bigint(20) NOT NULL,
  `item_allergens_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `item_allergens_item` char(32) NOT NULL,
  `allergen_name` char(32) NOT NULL,
  `allergen_type` varchar(40) NOT NULL,
  `allergen_id` bigint(20) NOT NULL,
  `allergen_sub_item_id` bigint(20) NOT NULL,
  `allergen_value` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `haccp_item_allergens`
--

INSERT INTO `haccp_item_allergens` (`item_allergens_id`, `item_allergens_time`, `item_allergens_item`, `allergen_name`, `allergen_type`, `allergen_id`, `allergen_sub_item_id`, `allergen_value`) VALUES
(1, '2019-02-04 14:29:41', 'ham', 'none', '0', -1, -1, -1),
(2, '2019-02-04 14:29:41', 'ham', 'Spelt', 'sub', 0, 2, 0),
(3, '2019-02-04 14:29:41', 'ham', 'Ryes', 'sub', 0, 14, 0),
(4, '2019-02-04 14:29:41', 'ham', 'Ryes', 'sub', 0, 13, 0),
(5, '2019-02-04 14:29:41', 'ham', 'Ryes', 'sub', 0, 12, 0),
(6, '2019-02-04 14:29:41', 'ham', 'Ryes', 'sub', 0, 15, 0),
(7, '2019-02-04 14:29:41', 'ham', 'Wheat', 'sub', 0, 4, 0),
(8, '2019-02-04 14:29:41', 'ham', 'Khorasan', 'sub', 0, 3, 0),
(9, '2019-02-04 14:29:41', 'ham', 'Lobster', 'sub', 0, 7, 0),
(10, '2019-02-04 14:29:41', 'ham', 'Crabs', 'sub', 0, 6, 0),
(11, '2019-02-04 14:29:41', 'ham', 'Prawns', 'sub', 0, 5, 0),
(12, '2019-02-04 14:29:41', 'ham', 'Eggs', 'parent', 3, 0, 0),
(13, '2019-02-04 14:29:41', 'ham', 'Fish', 'parent', 4, 0, 0),
(14, '2019-02-04 14:29:41', 'ham', 'Peanuts', 'parent', 5, 0, 0),
(15, '2019-02-04 14:29:41', 'ham', 'Soybeans', 'parent', 6, 0, 0),
(16, '2019-02-04 14:29:41', 'ham', 'Lactose(milk', 'parent', 7, 0, 0),
(17, '2019-02-04 14:29:41', 'ham', 'Almonds', 'sub', 0, 9, 0),
(18, '2019-02-04 14:29:41', 'ham', 'Hazelnuts', 'sub', 0, 8, 0),
(19, '2019-02-04 14:29:41', 'ham', 'Celery', 'parent', 9, 0, 0),
(20, '2019-02-04 14:29:41', 'ham', 'Mustard', 'parent', 10, 0, 0),
(21, '2019-02-04 14:29:41', 'ham', 'Sesame', 'parent', 11, 0, 0),
(22, '2019-02-04 14:29:41', 'ham', 'Sulphur', 'parent', 12, 0, 0),
(23, '2019-02-04 14:29:41', 'ham', 'Lupin', 'parent', 13, 0, 0),
(24, '2019-02-04 14:29:41', 'ham', 'Molluscs', 'parent', 14, 0, 0),
(25, '2019-02-04 14:30:38', 'ham', 'none', '0', -1, -1, -1),
(26, '2019-02-04 14:30:38', 'ham', 'Spelt', 'sub', 0, 2, 0),
(27, '2019-02-04 14:30:38', 'ham', 'Ryes', 'sub', 0, 14, 0),
(28, '2019-02-04 14:30:38', 'ham', 'Ryes', 'sub', 0, 13, 0),
(29, '2019-02-04 14:30:38', 'ham', 'Ryes', 'sub', 0, 12, 0),
(30, '2019-02-04 14:30:38', 'ham', 'Ryes', 'sub', 0, 15, 0),
(31, '2019-02-04 14:30:38', 'ham', 'Wheat', 'sub', 0, 4, 0),
(32, '2019-02-04 14:30:38', 'ham', 'Khorasan', 'sub', 0, 3, 0),
(33, '2019-02-04 14:30:38', 'ham', 'Lobster', 'sub', 0, 7, 0),
(34, '2019-02-04 14:30:38', 'ham', 'Crabs', 'sub', 0, 6, 0),
(35, '2019-02-04 14:30:38', 'ham', 'Prawns', 'sub', 0, 5, 0),
(36, '2019-02-04 14:30:38', 'ham', 'Eggs', 'parent', 3, 0, 0),
(37, '2019-02-04 14:30:38', 'ham', 'Fish', 'parent', 4, 0, 0),
(38, '2019-02-04 14:30:38', 'ham', 'Peanuts', 'parent', 5, 0, 0),
(39, '2019-02-04 14:30:38', 'ham', 'Soybeans', 'parent', 6, 0, 0),
(40, '2019-02-04 14:30:38', 'ham', 'Lactose(milk', 'parent', 7, 0, 0),
(41, '2019-02-04 14:30:38', 'ham', 'Almonds', 'sub', 0, 9, 0),
(42, '2019-02-04 14:30:38', 'ham', 'Hazelnuts', 'sub', 0, 8, 0),
(43, '2019-02-04 14:30:38', 'ham', 'Celery', 'parent', 9, 0, 0),
(44, '2019-02-04 14:30:38', 'ham', 'Mustard', 'parent', 10, 0, 0),
(45, '2019-02-04 14:30:38', 'ham', 'Sesame', 'parent', 11, 0, 0),
(46, '2019-02-04 14:30:38', 'ham', 'Sulphur', 'parent', 12, 0, 0),
(47, '2019-02-04 14:30:38', 'ham', 'Lupin', 'parent', 13, 0, 0),
(48, '2019-02-04 14:30:38', 'ham', 'Molluscs', 'parent', 14, 0, 0),
(49, '2019-02-04 14:31:10', 'bread', 'Spelt', 'sub', 0, 2, 1),
(50, '2019-02-04 14:31:10', 'bread', 'Ryes', 'sub', 0, 14, 0),
(51, '2019-02-04 14:31:10', 'bread', 'Ryes', 'sub', 0, 13, 0),
(52, '2019-02-04 14:31:10', 'bread', 'Ryes', 'sub', 0, 12, 0),
(53, '2019-02-04 14:31:10', 'bread', 'Ryes', 'sub', 0, 15, 0),
(54, '2019-02-04 14:31:10', 'bread', 'Wheat', 'sub', 0, 4, 1),
(55, '2019-02-04 14:31:10', 'bread', 'Khorasan', 'sub', 0, 3, 0),
(56, '2019-02-04 14:31:10', 'bread', 'Lobster', 'sub', 0, 7, 0),
(57, '2019-02-04 14:31:10', 'bread', 'Crabs', 'sub', 0, 6, 0),
(58, '2019-02-04 14:31:10', 'bread', 'Prawns', 'sub', 0, 5, 0),
(59, '2019-02-04 14:31:10', 'bread', 'Eggs', 'parent', 3, 0, 1),
(60, '2019-02-04 14:31:10', 'bread', 'Fish', 'parent', 4, 0, 0),
(61, '2019-02-04 14:31:10', 'bread', 'Peanuts', 'parent', 5, 0, 0),
(62, '2019-02-04 14:31:10', 'bread', 'Soybeans', 'parent', 6, 0, 0),
(63, '2019-02-04 14:31:10', 'bread', 'Lactose(milk', 'parent', 7, 0, 0),
(64, '2019-02-04 14:31:10', 'bread', 'Almonds', 'sub', 0, 9, 0),
(65, '2019-02-04 14:31:10', 'bread', 'Hazelnuts', 'sub', 0, 8, 0),
(66, '2019-02-04 14:31:10', 'bread', 'Celery', 'parent', 9, 0, 0),
(67, '2019-02-04 14:31:10', 'bread', 'Mustard', 'parent', 10, 0, 0),
(68, '2019-02-04 14:31:10', 'bread', 'Sesame', 'parent', 11, 0, 0),
(69, '2019-02-04 14:31:10', 'bread', 'Sulphur', 'parent', 12, 0, 0),
(70, '2019-02-04 14:31:10', 'bread', 'Lupin', 'parent', 13, 0, 0),
(71, '2019-02-04 14:31:10', 'bread', 'Molluscs', 'parent', 14, 0, 0),
(72, '2019-02-04 14:31:48', 'nut pie', 'Spelt', 'sub', 0, 2, 0),
(73, '2019-02-04 14:31:48', 'nut pie', 'Ryes', 'sub', 0, 14, 0),
(74, '2019-02-04 14:31:48', 'nut pie', 'Ryes', 'sub', 0, 13, 0),
(75, '2019-02-04 14:31:48', 'nut pie', 'Ryes', 'sub', 0, 12, 0),
(76, '2019-02-04 14:31:48', 'nut pie', 'Ryes', 'sub', 0, 15, 0),
(77, '2019-02-04 14:31:48', 'nut pie', 'Wheat', 'sub', 0, 4, 1),
(78, '2019-02-04 14:31:48', 'nut pie', 'Khorasan', 'sub', 0, 3, 0),
(79, '2019-02-04 14:31:48', 'nut pie', 'Lobster', 'sub', 0, 7, 0),
(80, '2019-02-04 14:31:48', 'nut pie', 'Crabs', 'sub', 0, 6, 0),
(81, '2019-02-04 14:31:48', 'nut pie', 'Prawns', 'sub', 0, 5, 0),
(82, '2019-02-04 14:31:48', 'nut pie', 'Eggs', 'parent', 3, 0, 0),
(83, '2019-02-04 14:31:48', 'nut pie', 'Fish', 'parent', 4, 0, 0),
(84, '2019-02-04 14:31:48', 'nut pie', 'Peanuts', 'parent', 5, 0, 1),
(85, '2019-02-04 14:31:48', 'nut pie', 'Soybeans', 'parent', 6, 0, 0),
(86, '2019-02-04 14:31:48', 'nut pie', 'Lactose(milk', 'parent', 7, 0, 1),
(87, '2019-02-04 14:31:48', 'nut pie', 'Almonds', 'sub', 0, 9, 1),
(88, '2019-02-04 14:31:48', 'nut pie', 'Hazelnuts', 'sub', 0, 8, 0),
(89, '2019-02-04 14:31:48', 'nut pie', 'Celery', 'parent', 9, 0, 0),
(90, '2019-02-04 14:31:48', 'nut pie', 'Mustard', 'parent', 10, 0, 0),
(91, '2019-02-04 14:31:48', 'nut pie', 'Sesame', 'parent', 11, 0, 0),
(92, '2019-02-04 14:31:48', 'nut pie', 'Sulphur', 'parent', 12, 0, 0),
(93, '2019-02-04 14:31:48', 'nut pie', 'Lupin', 'parent', 13, 0, 0),
(94, '2019-02-04 14:31:48', 'nut pie', 'Molluscs', 'parent', 14, 0, 0),
(95, '2019-02-04 14:32:23', 'nut pie', 'Spelt', 'sub', 0, 2, 0),
(96, '2019-02-04 14:32:23', 'nut pie', 'Ryes', 'sub', 0, 14, 0),
(97, '2019-02-04 14:32:23', 'nut pie', 'Ryes', 'sub', 0, 13, 0),
(98, '2019-02-04 14:32:23', 'nut pie', 'Ryes', 'sub', 0, 12, 0),
(99, '2019-02-04 14:32:23', 'nut pie', 'Ryes', 'sub', 0, 15, 0),
(100, '2019-02-04 14:32:23', 'nut pie', 'Wheat', 'sub', 0, 4, 1),
(101, '2019-02-04 14:32:23', 'nut pie', 'Khorasan', 'sub', 0, 3, 0),
(102, '2019-02-04 14:32:23', 'nut pie', 'Lobster', 'sub', 0, 7, 0),
(103, '2019-02-04 14:32:23', 'nut pie', 'Crabs', 'sub', 0, 6, 0),
(104, '2019-02-04 14:32:23', 'nut pie', 'Prawns', 'sub', 0, 5, 0),
(105, '2019-02-04 14:32:23', 'nut pie', 'Eggs', 'parent', 3, 0, 0),
(106, '2019-02-04 14:32:23', 'nut pie', 'Fish', 'parent', 4, 0, 0),
(107, '2019-02-04 14:32:23', 'nut pie', 'Peanuts', 'parent', 5, 0, 1),
(108, '2019-02-04 14:32:23', 'nut pie', 'Soybeans', 'parent', 6, 0, 0),
(109, '2019-02-04 14:32:23', 'nut pie', 'Lactose(milk', 'parent', 7, 0, 1),
(110, '2019-02-04 14:32:23', 'nut pie', 'Almonds', 'sub', 0, 9, 1),
(111, '2019-02-04 14:32:23', 'nut pie', 'Hazelnuts', 'sub', 0, 8, 0),
(112, '2019-02-04 14:32:23', 'nut pie', 'Celery', 'parent', 9, 0, 0),
(113, '2019-02-04 14:32:23', 'nut pie', 'Mustard', 'parent', 10, 0, 0),
(114, '2019-02-04 14:32:23', 'nut pie', 'Sesame', 'parent', 11, 0, 0),
(115, '2019-02-04 14:32:23', 'nut pie', 'Sulphur', 'parent', 12, 0, 0),
(116, '2019-02-04 14:32:23', 'nut pie', 'Lupin', 'parent', 13, 0, 0),
(117, '2019-02-04 14:32:23', 'nut pie', 'Molluscs', 'parent', 14, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `haccp_products`
--

CREATE TABLE `haccp_products` (
  `product_id` bigint(20) NOT NULL,
  `product_name` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_status` tinyint(4) NOT NULL,
  `product_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `haccp_products`
--

INSERT INTO `haccp_products` (`product_id`, `product_name`, `product_status`, `product_time`) VALUES
(1, 'Chicken breast', 0, '2019-02-04 14:08:55'),
(2, 'Grated cheese', 1, '2019-02-04 13:53:26'),
(3, 'Cheese block', 1, '2019-02-04 13:53:32'),
(4, 'Black pudding', 1, '2019-02-04 13:53:41'),
(5, '|Bacon', 0, '2019-02-04 13:53:59'),
(6, 'Bacon', 1, '2019-02-04 13:53:59'),
(7, 'Chicken breasts', 1, '2019-02-04 14:08:55');

-- --------------------------------------------------------

--
-- Table structure for table `haccp_suppliers`
--

CREATE TABLE `haccp_suppliers` (
  `supplier_id` bigint(20) NOT NULL,
  `supplier_name` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_status` tinyint(4) NOT NULL,
  `supplier_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `haccp_suppliers`
--

INSERT INTO `haccp_suppliers` (`supplier_id`, `supplier_name`, `supplier_status`, `supplier_time`) VALUES
(1, 'Coldchoice', 0, '2019-02-04 14:07:33'),
(2, 'Rayners', 1, '2019-02-04 13:52:18'),
(3, 'Swaffhams', 1, '2019-02-04 13:52:27'),
(4, 'Ahmed\\\'s', 1, '2019-02-04 13:52:37'),
(5, 'Wing Yip', 1, '2019-02-04 13:52:58'),
(6, 'Coldchoices', 1, '2019-02-04 14:07:33'),
(7, 'Coldchoices', 1, '2019-02-04 14:08:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `haccp_allergen`
--
ALTER TABLE `haccp_allergen`
  ADD PRIMARY KEY (`allergen_id`);

--
-- Indexes for table `haccp_allergen_sub`
--
ALTER TABLE `haccp_allergen_sub`
  ADD PRIMARY KEY (`allergen_sub_id`);

--
-- Indexes for table `haccp_daily`
--
ALTER TABLE `haccp_daily`
  ADD PRIMARY KEY (`daily_id`);

--
-- Indexes for table `haccp_daily_checks`
--
ALTER TABLE `haccp_daily_checks`
  ADD PRIMARY KEY (`daily_checks_id`);

--
-- Indexes for table `haccp_goods_in`
--
ALTER TABLE `haccp_goods_in`
  ADD PRIMARY KEY (`goods_in_id`);

--
-- Indexes for table `haccp_item_allergens`
--
ALTER TABLE `haccp_item_allergens`
  ADD PRIMARY KEY (`item_allergens_id`);

--
-- Indexes for table `haccp_products`
--
ALTER TABLE `haccp_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `haccp_suppliers`
--
ALTER TABLE `haccp_suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `haccp_allergen`
--
ALTER TABLE `haccp_allergen`
  MODIFY `allergen_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `haccp_allergen_sub`
--
ALTER TABLE `haccp_allergen_sub`
  MODIFY `allergen_sub_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `haccp_daily`
--
ALTER TABLE `haccp_daily`
  MODIFY `daily_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `haccp_daily_checks`
--
ALTER TABLE `haccp_daily_checks`
  MODIFY `daily_checks_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `haccp_goods_in`
--
ALTER TABLE `haccp_goods_in`
  MODIFY `goods_in_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `haccp_item_allergens`
--
ALTER TABLE `haccp_item_allergens`
  MODIFY `item_allergens_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `haccp_products`
--
ALTER TABLE `haccp_products`
  MODIFY `product_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `haccp_suppliers`
--
ALTER TABLE `haccp_suppliers`
  MODIFY `supplier_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
