-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: database
-- Generation Time: Dec 01, 2020 at 06:01 PM
-- Server version: 10.5.8-MariaDB-1:10.5.8+maria~focal
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `description` longtext DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `real_estate`
--

INSERT INTO `real_estate` (`id`, `address_street`, `address_housenumber`, `address_zip_code`, `address_city`, `living_space`, `room_count`, `free_from`, `description`, `creation_date`, `type`) VALUES
(1, 'Test', '20', '2992', 'Hamburg', '727.00', 2, NULL, NULL, '2020-11-26 10:53:35', 'appartment');

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
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `password`) VALUES
(1, 'Test', 'Test', 'test@test.com', '$2y$10$AqVRrigmSdnop8iQu/YzQu1JQ64xecCxd6ZlwqBt/b2OHwkMKUjLq');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
