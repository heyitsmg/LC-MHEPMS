-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2023 at 11:16 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lc_mhepms`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `blog_id` int(11) NOT NULL,
  `blog_category` varchar(255) NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_by` varchar(255) NOT NULL,
  `blog_date` datetime NOT NULL,
  `blog_content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`blog_id`, `blog_category`, `blog_title`, `blog_by`, `blog_date`, `blog_content`) VALUES
(2, 'FREEDOM WALL', 'CSDHJFGDJH', 'jlaman', '2023-11-12 10:36:03', 'dscsdgffbmcnx dhfbjsdhbc,sfhjsbdv sdc'),
(4, 'FREEDOM WALL', 'erfdvgbv', 'jlaman', '2023-11-13 21:08:57', 'regredgfv'),
(5, 'FREEDOM WALL', 'dfwefef', 'marygrace', '2023-11-13 21:10:40', 'ewffgwegwe'),
(6, 'QUESTIONS', 'WHAAAAAT', 'dalisayd', '2023-11-13 21:11:46', 'WHAAAAAAAAAAT'),
(7, 'QUESTIONS', 'jhgdyetsgdwye', 'marygrace', '2023-11-14 15:09:41', 'fewegrrge'),
(9, 'ANNOUNCEMENT', 'SHUKINERS', 'guidance', '2023-11-15 20:06:52', 'SHDGFVEYWTFVEDFKWEFF'),
(10, 'FREEDOM WALL', 'CAPSTONE', 'marygrace', '2023-11-19 13:34:29', 'MANIFESTING CAPSTONE DEFENDED!!!!');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryId` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `blog_category` varchar(255) NOT NULL,
  `blog_description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryId`, `date_created`, `blog_category`, `blog_description`) VALUES
(1, '2023-11-11 06:00:32', 'QUESTIONS', 'You can post under this category.'),
(2, '2023-11-11 06:03:42', 'ANNOUNCEMENT', 'Under this are the announcement from the Guidance Office'),
(19, '2023-11-12 14:02:46', 'FREEDOM WALL', 'Where your thoughts soar, because we care and you\'re free to share!');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `blog_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `comment_date` datetime DEFAULT NULL,
  `comment_content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `blog_id`, `user_id`, `username`, `comment_date`, `comment_content`) VALUES
(1, 6, NULL, 'marygrace', '2023-11-14 17:11:40', 'erfrrrrrrrr'),
(2, 6, NULL, 'marygrace', '2023-11-14 17:11:54', 'dfrgertge'),
(3, 6, NULL, 'marygrace', '2023-11-14 17:15:37', 'dvgferdf'),
(5, 6, NULL, 'marygrace', '2023-11-14 18:45:16', 'ewffedwef'),
(6, 6, NULL, 'marygrace', '2023-11-14 18:49:44', 'efgregrg'),
(8, 7, NULL, 'jlaman', '2023-11-15 15:16:20', 'hi hi'),
(9, 6, NULL, 'jlaman', '2023-11-15 15:16:42', 'ano'),
(11, 5, NULL, 'jlaman', '2023-11-15 15:33:17', 'hello'),
(12, 9, NULL, 'marygrace', '2023-11-15 20:25:39', 'hala'),
(13, 9, NULL, 'marygrace', '2023-11-15 20:42:23', 'ffff'),
(14, 4, NULL, 'marygrace', '2023-11-18 10:27:54', 'hala'),
(15, 4, NULL, 'marygrace', '2023-11-18 10:28:53', 'Magfsdfgve hagduywgdc bvfdgyeg bsgsh hwvc hjgduygf'),
(16, 4, NULL, 'marygrace', '2023-11-18 10:29:44', 'rtgg'),
(17, 10, NULL, 'marygrace', '2023-11-19 14:13:34', 'lesgoooo'),
(18, 2, NULL, 'marygrace', '2023-11-19 16:48:28', 'hi hi'),
(19, 2, NULL, 'marygrace', '2023-11-19 16:51:41', 'ge'),
(20, 2, NULL, 'marygrace', '2023-11-19 17:00:50', 'h'),
(21, 2, NULL, 'marygrace', '2023-11-19 17:01:14', 'gggggggggg'),
(22, 10, NULL, 'marygrace', '2023-11-19 17:42:54', 'tgh');

-- --------------------------------------------------------

--
-- Table structure for table `comment_replies`
--

CREATE TABLE `comment_replies` (
  `reply_id` int(11) NOT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `reply_content` text DEFAULT NULL,
  `reply_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment_replies`
--

INSERT INTO `comment_replies` (`reply_id`, `comment_id`, `username`, `reply_content`, `reply_date`) VALUES
(1, 18, 'marygrace', 'ho', '2023-11-19 08:58:05'),
(2, 17, 'marygrace', 'rgtregger', '2023-11-19 09:33:49'),
(3, 17, 'marygrace', 'fretgredfg', '2023-11-19 09:35:08'),
(4, 17, 'marygrace', 'fghtrh', '2023-11-19 09:43:53'),
(5, 17, 'marygrace', 'fdgvrgfdg', '2023-11-19 09:48:35');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `date_created` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `role`, `date_created`, `first_name`, `last_name`, `username`, `email`, `password`, `reset_token`, `reset_timestamp`, `profile_photo`) VALUES
(1, 'user', '2023-11-03 16:55:52', 'Mary Grace', 'Balmores', 'marygrace', 'mgbalmores@gmail.com', '$2y$10$WlTZm/d.SfCBUbMNwuWOu.icDFRHvA3BzxzPok3IsMaqTenzSqT0G', 'a65a386884cd26659dac811f98006121e26f5f27bbc3c463a5e56a93378bb196', '2023-11-15 09:25:05', NULL),
(2, 'user', '2023-11-03 16:57:21', 'Jaysse', 'Jaysse', 'jlaman', 'jaysselaman99@gmail.com', '$2y$10$PHWPWPCS4qJW5CDdOwD2BuHxxdpFbwpT8h1HuGScv30XIRZeEcllC', NULL, '2023-11-15 09:18:07', NULL),
(3, 'user', '2023-11-03 16:58:42', 'Dustin', 'Dalisay', 'dalisayd', 'dustindalisay@gmail.com', '$2y$10$2o88NyOCVPYj2LumvirqY.KMyxeFC28RqQKQ6ngKnKQPC18JMRTWi', NULL, '2023-11-15 09:18:07', NULL),
(5, 'admin', '2023-11-06 18:06:42', 'Guidance', 'Counselor', 'guidance', 'guidance@gmail.com', '$2y$10$s6XbZMluhDB/PYp1ejT.Gu8WeVM6cYFKte7qEulIKP4XqpdQbVC3G', NULL, '2023-11-15 09:18:07', NULL),
(6, 'admin', '2023-11-15 18:48:22', 'Admin', 'Guidance', 'admin_guidance', 'admin@gmail.com', '$2y$10$gmaxV.L59M2V0tDiXLMDiOHOy1EAxXE9J6FJBTi666brtPtI9Ci5q', NULL, '2023-11-15 10:48:22', NULL),
(11, 'user', '2023-11-19 16:38:59', 'Caden', 'Blake', 'caden', 'cadenblake@gmail.com', '$2y$10$a9Fr/9FoyVyncQkbLm7mwu3VHkFD.zeqsqRtbe3UI0.6V6mL0ixw2', NULL, '2023-11-19 08:38:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_scores`
--

CREATE TABLE `user_scores` (
  `score_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `recommendation` varchar(1000) NOT NULL,
  `routine` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `comment_replies`
--
ALTER TABLE `comment_replies`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indexes for table `user_scores`
--
ALTER TABLE `user_scores`
  ADD PRIMARY KEY (`score_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `comment_replies`
--
ALTER TABLE `comment_replies`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_scores`
--
ALTER TABLE `user_scores`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `comment_replies`
--
ALTER TABLE `comment_replies`
  ADD CONSTRAINT `comment_replies_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`comment_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
