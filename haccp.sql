-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 04, 2019 at 05:58 AM
-- Server version: 10.1.34-MariaDB
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
-- Database: `russel`
--

-- --------------------------------------------------------

--
-- Table structure for table `haccp_allergen`
--

DROP TABLE IF EXISTS `haccp_allergen`;
CREATE TABLE `haccp_allergen` (
  `allergen_id` bigint(20) NOT NULL,
  `allergen_name` char(32) NOT NULL,
  `allergen_status` tinyint(4) NOT NULL DEFAULT '1',
  `allergen_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `haccp_allergen`
--

INSERT INTO `haccp_allergen` (`allergen_id`, `allergen_name`, `allergen_status`, `allergen_time`) VALUES
(1, 'Gluten', 1, '2019-01-22 11:07:12'),
(2, 'Crustaceans', 1, '2019-01-22 11:07:12'),
(3, 'Eggs', 1, '2019-01-22 11:07:12'),
(4, 'Fish', 1, '2019-01-22 11:07:12'),
(5, 'Peanuts', 1, '2019-01-22 11:07:12'),
(6, 'Soybeans', 1, '2019-01-22 11:07:12'),
(7, 'Lactose(milk etc)', 1, '2019-01-22 11:07:12'),
(8, 'Nuts', 1, '2019-01-22 11:07:12'),
(9, 'Celery', 1, '2019-01-22 11:07:12'),
(10, 'Mustard', 1, '2019-01-22 11:07:12'),
(11, 'Sesame', 1, '2019-01-22 11:07:12'),
(12, 'Sulphur', 1, '2019-01-22 11:07:12'),
(13, 'Lupin', 1, '2019-01-22 11:06:37'),
(14, 'Molluscs', 1, '2019-01-22 11:06:37');

-- --------------------------------------------------------

--
-- Table structure for table `haccp_allergen_sub`
--

DROP TABLE IF EXISTS `haccp_allergen_sub`;
CREATE TABLE `haccp_allergen_sub` (
  `allergen_sub_id` bigint(20) NOT NULL,
  `allergen_id` bigint(20) NOT NULL,
  `allergen_sub_name` char(32) NOT NULL,
  `allergen_sub_status` tinyint(4) NOT NULL,
  `allergen_sub_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `haccp_daily`
--

DROP TABLE IF EXISTS `haccp_daily`;
CREATE TABLE `haccp_daily` (
  `daily_id` bigint(20) NOT NULL,
  `daily_type` tinyint(4) NOT NULL,
  `daily_name` char(32) NOT NULL,
  `daily_default_value` char(32) NOT NULL,
  `daily_status` tinyint(4) NOT NULL,
  `daily_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `haccp_daily_checks`
--

DROP TABLE IF EXISTS `haccp_daily_checks`;
CREATE TABLE `haccp_daily_checks` (
  `daily_checks_id` bigint(20) NOT NULL,
  `daily_checks_time` datetime NOT NULL,
  `equipment_id` bigint(20) NOT NULL,
  `daily_checks_name` char(32) NOT NULL,
  `daily_checks_actual_value` char(32) NOT NULL,
  `daily_checks_comments` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `haccp_goods_in`
--

DROP TABLE IF EXISTS `haccp_goods_in`;
CREATE TABLE `haccp_goods_in` (
  `goods_in_id` bigint(20) NOT NULL,
  `goods_in_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `product_id` bigint(20) NOT NULL,
  `supplier_id` bigint(20) NOT NULL,
  `goods_in_use_by` date NOT NULL,
  `goods_in_batch` char(128) NOT NULL,
  `goods_in_description` char(128) NOT NULL,
  `goods_in_comments` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `haccp_item_allergens`
--

DROP TABLE IF EXISTS `haccp_item_allergens`;
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

-- --------------------------------------------------------

--
-- Table structure for table `haccp_products`
--

DROP TABLE IF EXISTS `haccp_products`;
CREATE TABLE `haccp_products` (
  `product_id` bigint(20) NOT NULL,
  `product_name` char(32) NOT NULL,
  `product_status` tinyint(4) NOT NULL,
  `product_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `haccp_suppliers`
--

DROP TABLE IF EXISTS `haccp_suppliers`;
CREATE TABLE `haccp_suppliers` (
  `supplier_id` bigint(20) NOT NULL,
  `supplier_name` char(32) NOT NULL,
  `supplier_status` tinyint(4) NOT NULL,
  `supplier_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  MODIFY `allergen_sub_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `haccp_daily`
--
ALTER TABLE `haccp_daily`
  MODIFY `daily_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `haccp_daily_checks`
--
ALTER TABLE `haccp_daily_checks`
  MODIFY `daily_checks_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `haccp_goods_in`
--
ALTER TABLE `haccp_goods_in`
  MODIFY `goods_in_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `haccp_item_allergens`
--
ALTER TABLE `haccp_item_allergens`
  MODIFY `item_allergens_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `haccp_products`
--
ALTER TABLE `haccp_products`
  MODIFY `product_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `haccp_suppliers`
--
ALTER TABLE `haccp_suppliers`
  MODIFY `supplier_id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
