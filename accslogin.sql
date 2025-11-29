-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2025 at 06:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accslogin`
--

-- --------------------------------------------------------

--
-- Table structure for table `educators`
--

CREATE TABLE `educators` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `educators`
--

INSERT INTO `educators` (`id`, `name`) VALUES
(1, 'Dr. Jane Doe'),
(2, 'Prof. Alex Smith'),
(3, 'Ms. Maya Khan');

-- --------------------------------------------------------

--
-- Table structure for table `educator_ratings`
--

CREATE TABLE `educator_ratings` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `educator_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `educator_ratings`
--

INSERT INTO `educator_ratings` (`id`, `user_id`, `educator_id`, `rating`, `created_at`, `updated_at`) VALUES
(1, 'S941067', 1, 2, '2025-11-28 03:30:42', '2025-11-28 03:30:44'),
(3, 'S941067', 3, 3, '2025-11-28 03:30:46', '2025-11-28 03:30:46'),
(4, 'S941067', 2, 4, '2025-11-28 03:30:48', '2025-11-28 03:30:48'),
(5, 'S147386', 1, 4, '2025-11-28 03:32:24', '2025-11-28 18:52:53'),
(9, 'S147386', 3, 3, '2025-11-28 03:36:41', '2025-11-29 05:48:23'),
(10, 'S147386', 2, 3, '2025-11-28 03:36:43', '2025-11-29 05:48:25');

-- --------------------------------------------------------

--
-- Table structure for table `record_requests`
--

CREATE TABLE `record_requests` (
  `request_id` char(36) NOT NULL DEFAULT uuid(),
  `user_id` varchar(50) NOT NULL,
  `record_type_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `date_requested` timestamp NOT NULL DEFAULT current_timestamp(),
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `record_requests`
--

INSERT INTO `record_requests` (`request_id`, `user_id`, `record_type_id`, `status`, `date_requested`, `remarks`) VALUES
('5a003b80-cabb-11f0-a98f-089798a9decd', 'S106358', 1, 'Pending', '2025-11-26 11:30:46', NULL),
('6e6f6fd6-caba-11f0-a98f-089798a9decd', 'S125469', 4, 'Pending', '2025-11-26 11:24:11', NULL),
('b39915ad-cb7c-11f0-9667-089798a9decd', 'S106358', 4, 'Pending', '2025-11-27 10:34:39', NULL),
('e6eea662-cab9-11f0-a98f-089798a9decd', 'S360247', 1, 'Pending', '2025-11-26 11:20:24', NULL),
('f65ae4b3-cab9-11f0-a98f-089798a9decd', 'S360247', 3, 'Pending', '2025-11-26 11:20:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `record_types`
--

CREATE TABLE `record_types` (
  `id` int(11) NOT NULL,
  `record_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `record_types`
--

INSERT INTO `record_types` (`id`, `record_name`) VALUES
(1, 'Change of Program/Major'),
(2, 'Dropping of Subjects'),
(3, 'Re-admission of Returning Student'),
(4, 'Simultaneous/Overload'),
(5, 'Requesting of Certificate of Enrollment');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `id`, `first_name`, `last_name`, `email`, `password`, `created_at`) VALUES
('jdoe', 1, 'john', 'doe', 'jdoe@email.com', 'password', '2025-11-25 16:13:39'),
('S941067', 2, 'jane', 'doe', 'jane_doe@email.com', '$2y$10$BENJnPoEWmDiVu9giEPrieDeVxpxdl7hpqA5VGJ6vgGAfJLXWSoY6', '2025-11-25 16:34:25'),
('S147386', 3, 'Juan', 'Dela Cruz', 'j_delacruz@email.com', '$2y$10$6iTjSMfocE4nHzsuDXCGNOyEbS9Liidu1OQqEfMKZ2/zGVzGAx3NW', '2025-11-26 03:17:07'),
('S346250', 4, 'jane', 'doe', 'jane_doe@email.com', '$2y$10$oey.8IUfvcKO5BgT7YeHeedNV6ekuzW8kIpDgDH33CHAEigeOKkga', '2025-11-26 03:20:43'),
('S358206', 5, 'Juan', 'Luna', 'jluna@email.com', '$2y$10$SB/00gidYSDiPLLCqWsp1uvV/yLFUb5Hf9Sy.a36CDh4Stuh9V/y.', '2025-11-26 09:03:41'),
('S360247', 6, 'John Red', 'Cortez', 'john.red.cortez@adamson.edu.ph', '$2y$10$mzNbLRw4Z5P6UZaGKrFX6egbL72JKN5hOf1uHyuH/lwRtX5JALcTm', '2025-11-26 09:58:52'),
('S860924', 7, '1111', '111', '111@1', '$2y$10$t.uZedpWyTXlgMuAeh3bZ.PMCRfb7o2YMYEFzhI4ExA.bgBORQDXm', '2025-11-26 10:37:53'),
('S125469', 8, 'jane', 'doe', 'jd@gmail.com', '$2y$10$PuJ8r3NrOtF0Wh3kpzYTo.F1uOCtkPvIxFz5I7kW3w0zPnpRpEpJe', '2025-11-26 11:23:11'),
('S106358', 9, 'john', 'c', 'jc@gmail.com', '$2y$10$4dYgbNM0DEhYb0JdIzlYUO7jx75SUSRzwZGRNMkl1oyVwJ8K8EWp2', '2025-11-26 11:30:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `educators`
--
ALTER TABLE `educators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `educator_ratings`
--
ALTER TABLE `educator_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_educator_unique` (`user_id`,`educator_id`);

--
-- Indexes for table `record_requests`
--
ALTER TABLE `record_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `record_type_id` (`record_type_id`);

--
-- Indexes for table `record_types`
--
ALTER TABLE `record_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `educators`
--
ALTER TABLE `educators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `educator_ratings`
--
ALTER TABLE `educator_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `record_types`
--
ALTER TABLE `record_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `record_requests`
--
ALTER TABLE `record_requests`
  ADD CONSTRAINT `record_requests_ibfk_2` FOREIGN KEY (`record_type_id`) REFERENCES `record_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
