-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2020 at 01:25 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlineclass`
--

-- --------------------------------------------------------

--
-- Table structure for table `clas`
--

CREATE TABLE `clas` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subj_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clas`
--

INSERT INTO `clas` (`id`, `user_id`, `subj_id`) VALUES
(1, 14, 3),
(2, 14, 4),
(3, 14, 5),
(4, 14, 6),
(5, 8, 1),
(6, 9, 1),
(7, 10, 1),
(8, 11, 1),
(9, 12, 1),
(10, 13, 1),
(11, 8, 2),
(12, 9, 2),
(13, 10, 2),
(14, 11, 2),
(15, 12, 2),
(16, 13, 2),
(17, 8, 3),
(18, 9, 3),
(19, 10, 3),
(20, 11, 3),
(21, 12, 3),
(22, 13, 3),
(23, 8, 4),
(24, 9, 4),
(25, 10, 4),
(26, 11, 4),
(27, 12, 4),
(28, 13, 4),
(29, 8, 5),
(30, 9, 5),
(31, 10, 5),
(32, 11, 5),
(33, 12, 5),
(34, 13, 5);

-- --------------------------------------------------------

--
-- Table structure for table `subj`
--

CREATE TABLE `subj` (
  `id` int(11) NOT NULL,
  `subjectname` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subj`
--

INSERT INTO `subj` (`id`, `subjectname`) VALUES
(1, 'Telegu'),
(2, 'Hindi'),
(3, 'English'),
(4, 'Maths'),
(5, 'EVS'),
(6, 'Rhymes');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `isstaff` tinyint(1) NOT NULL DEFAULT 0,
  `isadmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `isstaff`, `isadmin`) VALUES
(6, 'staff', 'staff', 1, 1),
(7, 'student', 'student', 0, 0),
(8, 'classukg', 'classukg', 0, 0),
(9, 'class01', 'class01', 0, 0),
(10, 'class02', 'class02', 0, 0),
(11, 'class03', 'class03', 0, 0),
(12, 'class04', 'class04', 0, 0),
(13, 'class05', 'class05', 0, 0),
(14, 'classlkg', 'classlkg', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vids`
--

CREATE TABLE `vids` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `clas_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `link` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clas`
--
ALTER TABLE `clas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subj`
--
ALTER TABLE `subj`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vids`
--
ALTER TABLE `vids`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clas`
--
ALTER TABLE `clas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `subj`
--
ALTER TABLE `subj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `vids`
--
ALTER TABLE `vids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
