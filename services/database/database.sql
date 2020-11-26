-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 25, 2020 at 08:36 PM
-- Server version: 10.3.25-MariaDB-0+deb10u1
-- PHP Version: 7.3.19-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `immoinc`
--

-- --------------------------------------------------------

--
-- Table structure for table `appartment`
--

CREATE TABLE `appartment` (
  `real_estate_id` int(11) NOT NULL,
  `floor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `house`
--

CREATE TABLE `house` (
  `real_estate_id` int(11) NOT NULL,
  `construction_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `real_estate`
--

CREATE TABLE `real_estate` (
  `id` int(11) NOT NULL,
  `address_street` varchar(64) NOT NULL,
  `address_housenumber` varchar(10) NOT NULL,
  `address_zip_code` varchar(10) NOT NULL,
  `address_city` varchar(45) NOT NULL,
  `living_space` decimal(13,2) NOT NULL,
  `room_count` int(11) NOT NULL,
  `free_from` date DEFAULT NULL,
  `description` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `real_estate_announcement`
--

CREATE TABLE `real_estate_announcement` (
  `id` int(11) NOT NULL,
  `ownership_level` int(11) NOT NULL,
  `price` decimal(13,4) NOT NULL,
  `real_estate_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `real_estate_image`
--

CREATE TABLE `real_estate_image` (
  `id` int(11) NOT NULL,
  `path` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `real_estate_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(64) DEFAULT NULL,
  `lastname` varchar(64) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appartment`
--
ALTER TABLE `appartment`
  ADD PRIMARY KEY (`real_estate_id`),
  ADD KEY `fk_appartment_real_estate1_idx` (`real_estate_id`);

--
-- Indexes for table `house`
--
ALTER TABLE `house`
  ADD PRIMARY KEY (`real_estate_id`),
  ADD KEY `fk_house_real_estate1_idx` (`real_estate_id`);

--
-- Indexes for table `real_estate`
--
ALTER TABLE `real_estate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `real_estate_announcement`
--
ALTER TABLE `real_estate_announcement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_real_estate_announcement_real_estate1_idx` (`real_estate_id`);

--
-- Indexes for table `real_estate_image`
--
ALTER TABLE `real_estate_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_real_estate_image_real_estate1_idx` (`real_estate_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `real_estate`
--
ALTER TABLE `real_estate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `real_estate_announcement`
--
ALTER TABLE `real_estate_announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `real_estate_image`
--
ALTER TABLE `real_estate_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appartment`
--
ALTER TABLE `appartment`
  ADD CONSTRAINT `fk_appartment_real_estate1` FOREIGN KEY (`real_estate_id`) REFERENCES `real_estate` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `house`
--
ALTER TABLE `house`
  ADD CONSTRAINT `fk_house_real_estate1` FOREIGN KEY (`real_estate_id`) REFERENCES `real_estate` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `real_estate_announcement`
--
ALTER TABLE `real_estate_announcement`
  ADD CONSTRAINT `fk_real_estate_announcement_real_estate1` FOREIGN KEY (`real_estate_id`) REFERENCES `real_estate` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `real_estate_image`
--
ALTER TABLE `real_estate_image`
  ADD CONSTRAINT `fk_real_estate_image_real_estate1` FOREIGN KEY (`real_estate_id`) REFERENCES `real_estate` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
