-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 22, 2018 at 11:27 PM
-- Server version: 5.6.39-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esaplive`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `CAMPUS_ID` bigint(20) DEFAULT NULL,
  `DESIGNATION` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payroll_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `CAMPUS_ID`, `DESIGNATION`, `name`, `email`, `payroll_id`, `password`, `description`, `created_at`, `updated_at`) VALUES
(1, 38, 'DATA ANALYIST', 'kanna', 'kanna@gmail.com', 'HYD106702', 'e10adc3949ba59abbe56e057f20f883e', 'kanna', '2018-07-12 13:19:18', '2018-07-12 13:19:18'),
(2, 120, 'COMPUTER OPERATOR', 'nallakunta', 'nallakuta@gmail.com', 'HYD501549', 'e10adc3949ba59abbe56e057f20f883e', 'nallakunta', '2018-07-12 13:27:10', '2018-07-12 13:27:10'),
(3, 249, 'CAMPUS INCHARGE', 'raidurgam', 'rai@gmail.com', 'HYD401256', 'e10adc3949ba59abbe56e057f20f883e', 'raiduragam', '2018-07-12 13:28:22', '2018-07-12 13:28:22'),
(4, 3, 'COMPUTER OPERATOR', 'andhra', 'andhra@gmail.com', 'AMP237681', 'e10adc3949ba59abbe56e057f20f883e', 'mani', '2018-08-03 16:57:18', '2018-08-03 16:57:18'),
(5, 13, 'COMPUTER OPERATOR', 'telungana', 'telungana@gmail.com', 'HYD303946', 'e10adc3949ba59abbe56e057f20f883e', 'telungana', '2018-08-03 16:58:07', '2018-08-03 16:58:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
