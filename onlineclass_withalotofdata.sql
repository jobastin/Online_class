-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2020 at 04:15 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
(34, 13, 5),
(35, 15, 1),
(36, 16, 1),
(37, 17, 1),
(38, 18, 1),
(39, 19, 1),
(40, 15, 3),
(41, 16, 3),
(42, 17, 3),
(43, 18, 3),
(44, 19, 3),
(45, 15, 2),
(46, 16, 2),
(47, 17, 2),
(48, 18, 2),
(49, 19, 2),
(50, 15, 4),
(51, 16, 4),
(52, 17, 4),
(53, 18, 4),
(54, 19, 4),
(55, 15, 7),
(56, 16, 7),
(57, 17, 7),
(58, 18, 7),
(59, 19, 7),
(60, 15, 8),
(61, 16, 8),
(62, 17, 8),
(63, 18, 8),
(64, 19, 8),
(65, 15, 9),
(66, 16, 9),
(67, 17, 9),
(68, 18, 9),
(69, 19, 9),
(70, 15, 10),
(71, 16, 10),
(72, 17, 10),
(73, 18, 10),
(74, 19, 10);

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
(6, 'Rhymes'),
(7, 'Physical Science'),
(8, 'Natural Science'),
(9, 'Social Science'),
(10, 'Computer Science');

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
(14, 'classlkg', 'classlkg', 0, 0),
(15, 'class06', 'class06', 0, 0),
(16, 'class07', 'class07', 0, 0),
(17, 'class08', 'class08', 0, 0),
(18, 'class09', 'class09', 0, 0),
(19, 'class10', 'class10', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vids`
--

CREATE TABLE `vids` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `link` varchar(100) NOT NULL,
  `chapter` smallint(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vids`
--

INSERT INTO `vids` (`id`, `staff_id`, `class_id`, `title`, `link`, `chapter`) VALUES
(1, 6, 5, 'asdf', 'asdfasdf', 1),
(2, 6, 6, 'asdfa', 'sdfasdf', 1),
(3, 6, 6, 'asdfasdf', 'asdfasdf', 1),
(4, 6, 39, 'asdfa', 'asdfasdfasdf', 1),
(5, 6, 39, 'asdf', 'ffdasf', 2),
(6, 6, 49, 'asdff', 'ffdasdfasdf', 1),
(7, 6, 49, 'ffdfdf', 'dfsfffdfsdfsf', 3),
(8, 6, 44, 'aaaaaaa', 'aaaaaaaaaa', 1),
(9, 6, 44, 'fsdf', 'sfdsfasf', 3),
(10, 6, 54, 'fffdsf', 'asdfasdff', 3),
(11, 6, 54, 'fasdfaa', 'asdfasdfasdfasf', 3),
(12, 6, 54, 'fffdsawewefasdf', 'asdf', 3),
(13, 6, 54, 'asdfasdfasdfasdf', 'asdfasaaaasdf', 2),
(14, 6, 59, 'asdf', 'sdffasdfsdff', 4),
(16, 6, 74, 'test upload', ';laksdfl;kj', 10),
(18, 6, 33, 'evs basics', 'holahlsdkfklja', 1),
(19, 6, 16, 'ashante kozhi', 'kokkarakko', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `subj`
--
ALTER TABLE `subj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `vids`
--
ALTER TABLE `vids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
