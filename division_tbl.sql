-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2016 at 10:07 AM
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
-- Table structure for table `division_tbl`
--

CREATE TABLE `division_tbl` (
  `id` int(10) UNSIGNED NOT NULL,
  `div_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `div_bn_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `division_tbl`
--

INSERT INTO `division_tbl` (`id`, `div_name`, `div_bn_name`, `created_at`, `updated_at`) VALUES
(1, 'Barisal', 'বরিশাল', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Chittagong', 'চট্টগ্রাম', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Dhaka', 'ঢাকা', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Khulna', 'খুলনা', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Rajshahi', 'রাজশাহী', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Rangpur', 'রংপুর', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Sylhet', 'সিলেট', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `division_tbl`
--
ALTER TABLE `division_tbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `division_tbl`
--
ALTER TABLE `division_tbl`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
