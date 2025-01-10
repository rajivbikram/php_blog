-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2025 at 03:00 AM
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
-- Database: `php_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `details`) VALUES
(12, 'Technology', '1736471263_chess-board.png', 't');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `details` longtext NOT NULL,
  `status` tinyint(1) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `details`, `status`, `image`, `category_id`, `created_at`) VALUES
(3, 'test post', 'post', 1, '1736471319_Single Post.png', 12, '2025-01-10 01:08:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(8) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `image` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `address` varchar(256) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `image`, `status`, `address`, `created_at`) VALUES
(1, 'Rajiv Bikram Shah', 'rajivshah@gmail.com', '$2y$10$Cpfh6/H9Pk0KEVgqWN.Kpu1QaA/B0YZOFDRlIvwcdiwvJrMsBeewK', '', 0, NULL, '2024-12-11 04:44:12'),
(2, 'Rajiv Bikram Shah', 'rajivb.shah@apexcollege.edu.np', '$2y$10$/NuSoO.7d7kPYTbgD7VHFuWMSvH3uPBHelaT6F9bkffOBzwubK.cm', '', 0, NULL, '2024-12-11 05:04:07'),
(3, 'Rajiv Bikram Shah', 'programmingpot@gmail.com', '$2y$10$yftM6X45IKNd15Y7JWRsf.DCzyZndMgsiYKqyks1QEN9rv//k1IVC', '', 0, NULL, '2024-12-11 07:16:21'),
(4, 'Rajiv', 'abc@gmail.com', '$2y$10$uFAhHHsE3ELG9L7dDMW3yuVznZTJygSQ6lX5ocKD.jLlA6eclWL/C', '', 0, NULL, '2024-12-12 03:22:43'),
(5, 'zxasds', 'programmingpot@gmail.comca', '$2y$10$FajcsFtYIWZ0YfQNnpvlR.nRg/t0zJIHX0DXGfHAQ.q2EOucILLQC', '', 0, NULL, '2024-12-18 02:56:58'),
(6, 'kljhfsdhjsd', 'programmingpot@gmail.comigfdsi', '$2y$10$uZlAyO1iJNLEJLlxFUxJXu9ccDOI0Tsrn4k7cneyNneAa7UFIC7fK', '', 0, NULL, '2024-12-18 03:08:40'),
(7, 'test', 'programmissngpot@gmail.com', '$2y$10$MEOLKGoYPGl0D9eflr/WOuDhnRKya.8N87zVzS1uTcj3ndsChYTI.', '', 0, NULL, '2024-12-18 03:16:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
