-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2016 at 07:20 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agentbanking`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch_tbl`
--

CREATE TABLE `branch_tbl` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bra_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bra_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bra_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `bra_division_id` int(10) UNSIGNED NOT NULL,
  `bra_district_id` int(10) UNSIGNED NOT NULL,
  `bra_upazila_id` int(10) UNSIGNED NOT NULL,
  `bra_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bra_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bra_fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bra_latlon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bra_openingdate` date NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch_tbl`
--
ALTER TABLE `branch_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_tbl_bra_division_id_foreign` (`bra_division_id`),
  ADD KEY `branch_tbl_bra_district_id_foreign` (`bra_district_id`),
  ADD KEY `branch_tbl_bra_upazila_id_foreign` (`bra_upazila_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch_tbl`
--
ALTER TABLE `branch_tbl`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
