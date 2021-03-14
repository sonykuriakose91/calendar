-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2021 at 09:23 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vonnue_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` int(11) NOT NULL,
  `start_time` int(11) NOT NULL,
  `start_date` int(11) NOT NULL,
  `end_date` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `title`, `date`, `start_time`, `start_date`, `end_date`, `duration`, `created_by`, `created_at`) VALUES
(1, 'Lunch with Charles', 1615573800, 1615271400, 1615617000, 1615620600, 60, 1, 1615294579),
(2, 'Dinner with Prince', 1615660200, 1615300200, 1615732200, 1615735800, 60, 1, 1615294628),
(3, 'Dinner with Hyby', 1615660200, 1615302000, 1615734000, 1615737600, 60, 1, 1615294684),
(4, 'Meeting with Manu', 1616437800, 1615523400, 1616473800, 1616475600, 30, 1, 1615545258),
(15, 'Meeting with Hyby', 1616265000, 1615527000, 1616304600, 1616306400, 30, 1, 1615546338);

-- --------------------------------------------------------

--
-- Table structure for table `meeting_attendees`
--

CREATE TABLE `meeting_attendees` (
  `id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `attendee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meeting_attendees`
--

INSERT INTO `meeting_attendees` (`id`, `meeting_id`, `attendee_id`) VALUES
(1, 1, 4),
(2, 2, 2),
(3, 3, 3),
(4, 4, 3),
(16, 15, 3);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1615175234),
('m130524_201442_init', 1615175421),
('m190124_110200_add_verification_token_column_to_user_table', 1615175421);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `isloggedin` tinyint(4) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `name`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `isloggedin`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'sony.kuriakose', 'Sony Kuriakose', 'x3-a1orSW9Tugr1RQhiZQY_fCToaETbe', '$2y$13$/3l5W3Y8OwwHvVHnaeGe8ugW8HJhe55KFXE9OLXsMpylxQPzic7li', NULL, 'sonymangottil@gmail.com', 1, 0, 1615175430, 1615709691, 'Un8ORiqZNLQ-amfElaOtdGHTrFyWIsOl_1615175430'),
(2, 'prince.mathew', 'Prince Mathew', 'lnhGZF-GYlt2rvk6Rq11YfhEDyx3rbcH', '$2y$13$.oFPAJ9p4nd8233nfoTcMOF0zpnHJucw8mClRsEZetffVXKyoXFWC', NULL, 'princemathewn007@gmail.com', 1, 0, 1615176281, 1615274197, 'ioODB_XWLcEPBvAcmV3x31cfcrI1jNHv_1615176281'),
(3, 'hyby.kurian', 'Hyby Kurian', 'f5q7zyA7JgBulv7sCIpPXxOCeBUKB721', '$2y$13$CVpkCNbCilU50qFIxwhgFOSGqvU5GMlJHb2ZEMx.aRvHz4GlIXKcS', NULL, 'hybykurian@gmail.com', 1, 0, 1615176325, 1615176325, 'mDb4hcw5nMD-O0n7JwjiGDC5FKNedULr_1615176325'),
(4, 'charles.skariah', 'Charles Skariah', 'LJMHf-sghS_ut-qGKz6cHBLLzVfvlnVz', '$2y$13$mjNLjkJItHLGwZAzkT/PJezbUtBkeWP8iAwNwU2YoPCXqCCR0N/D2', NULL, 'charlesskariah@gmail.com', 1, 0, 1615206075, 1615206075, 'KaEmtoQM4USeqX-5kbkhQynLwCR9vara_1615206075'),
(6, 'vijo.thomas', 'Vijo Thomas', 'RMYtXGVG4aD2WP8r1IUeGKF-fBXDUApx', '$2y$13$7z9xOBuvEmdpZbdQ7M2eAu6w7LGRAe94baXUp2m9TuKponw3ONS8O', NULL, 'vijothomas@gmail.com', 1, 0, 1615709757, 1615709757, '6Y4a5o7irgmUWO6OLbOF1WD76Yy8qGnK_1615709757');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `meeting_attendees`
--
ALTER TABLE `meeting_attendees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `meeting_attendees`
--
ALTER TABLE `meeting_attendees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
