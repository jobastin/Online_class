-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2020 at 07:36 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `st. aloysius`
--

-- --------------------------------------------------------

--
-- Table structure for table `info_class`
--

CREATE TABLE `info_class` (
  `class_id` int(10) NOT NULL,
  `class_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `info_class`
--

INSERT INTO `info_class` (`class_id`, `class_name`) VALUES
(1, 'first'),
(2, 'second'),
(3, 'third'),
(4, 'fourth'),
(5, 'fifth'),
(6, 'sixth'),
(7, 'seventh'),
(8, 'eighth'),
(9, 'ninth'),
(10, 'tenth'),
(11, 'lkg'),
(12, 'ukg');

-- --------------------------------------------------------

--
-- Table structure for table `info_subject`
--

CREATE TABLE `info_subject` (
  `sub_code` varchar(10) NOT NULL,
  `class_id` int(10) NOT NULL,
  `sub_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `info_subject`
--

INSERT INTO `info_subject` (`sub_code`, `class_id`, `sub_name`) VALUES
('C6', 6, 'COMPUTER'),
('C7', 7, 'COMPUTER'),
('C8', 8, 'COMPUTER'),
('C9', 9, 'COMPUTER'),
('E10', 10, 'ENGLISH'),
('E6', 6, 'ENGLISH'),
('E7', 7, 'ENGLISH'),
('E8', 8, 'ENGLISH'),
('E9', 9, 'ENGLISH'),
('H10', 10, 'HINDI'),
('H6', 6, 'HINDI'),
('H7', 7, 'HINDI'),
('H8', 8, 'HINDI'),
('H9', 9, 'HINDI'),
('M10', 10, 'MATHS'),
('M6', 6, 'MATHS'),
('M7', 7, 'MATHS'),
('M8', 8, 'MATHS'),
('M9', 9, 'MATHS'),
('NS10', 10, 'NATURAL SCIENCE'),
('NS6', 6, 'NATURAL SCIENCE'),
('NS7', 7, 'NATURAL SCIENCE'),
('NS8', 8, 'NATURAL SCIENCE'),
('NS9', 9, 'NATURAL SCIENCE'),
('PS10', 10, 'PHYSICAL SCIENCE'),
('PS6', 6, 'PHYSICAL SCIENCE'),
('PS7', 7, 'PHYSICAL SCIENCE'),
('PS8', 8, 'PHYSICAL SCIENCE'),
('PS9', 9, 'PHYSICAL SCIENCE'),
('S10', 10, 'SOCIAL'),
('S6', 6, 'SOCIAL'),
('S7', 7, 'SOCIAL'),
('S8', 8, 'SOCIAL'),
('S9', 9, 'SOCIAL'),
('T10', 10, 'TELUGU'),
('T6', 6, 'TELUGU'),
('T7', 7, 'TELUGU'),
('T8', 8, 'TELUGU'),
('T9', 9, 'TELUGU');

-- --------------------------------------------------------

--
-- Table structure for table `info_youtube`
--

CREATE TABLE `info_youtube` (
  `y_sino` int(10) NOT NULL,
  `staff_id` varchar(20) NOT NULL,
  `class_id` int(10) NOT NULL,
  `sub_code` varchar(10) NOT NULL,
  `ch_no` int(10) NOT NULL,
  `y_desc` varchar(100) NOT NULL,
  `y_link` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `info_youtube`
--

INSERT INTO `info_youtube` (`y_sino`, `staff_id`, `class_id`, `sub_code`, `ch_no`, `y_desc`, `y_link`) VALUES
(1, 'STAFF01', 10, 'E10', 1, 'leson 1', 'https://youtu.be/FLz9hCjELWk');

-- --------------------------------------------------------

--
-- Table structure for table `login_staff`
--

CREATE TABLE `login_staff` (
  `staff_id` varchar(20) NOT NULL,
  `staff_password` varchar(20) NOT NULL,
  `staff_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login_staff`
--

INSERT INTO `login_staff` (`staff_id`, `staff_password`, `staff_name`) VALUES
('STAFF01', '12345678', 'Sr. Daisy'),
('STAFF02', '12345678', 'Sr.');

-- --------------------------------------------------------

--
-- Table structure for table `login_student`
--

CREATE TABLE `login_student` (
  `stu_id` varchar(20) NOT NULL,
  `stu_password` varchar(20) NOT NULL,
  `class_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login_student`
--

INSERT INTO `login_student` (`stu_id`, `stu_password`, `class_id`) VALUES
('STD10', '12345678', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `info_class`
--
ALTER TABLE `info_class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `info_subject`
--
ALTER TABLE `info_subject`
  ADD PRIMARY KEY (`sub_code`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `info_youtube`
--
ALTER TABLE `info_youtube`
  ADD PRIMARY KEY (`y_sino`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `sub_code` (`sub_code`);

--
-- Indexes for table `login_staff`
--
ALTER TABLE `login_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `login_student`
--
ALTER TABLE `login_student`
  ADD PRIMARY KEY (`stu_id`),
  ADD KEY `class_id` (`class_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `info_youtube`
--
ALTER TABLE `info_youtube`
  MODIFY `y_sino` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `info_subject`
--
ALTER TABLE `info_subject`
  ADD CONSTRAINT `info_subject_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `info_class` (`class_id`);

--
-- Constraints for table `info_youtube`
--
ALTER TABLE `info_youtube`
  ADD CONSTRAINT `info_youtube_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `login_staff` (`staff_id`),
  ADD CONSTRAINT `info_youtube_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `info_class` (`class_id`),
  ADD CONSTRAINT `info_youtube_ibfk_3` FOREIGN KEY (`sub_code`) REFERENCES `info_subject` (`sub_code`);

--
-- Constraints for table `login_student`
--
ALTER TABLE `login_student`
  ADD CONSTRAINT `login_student_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `info_class` (`class_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
