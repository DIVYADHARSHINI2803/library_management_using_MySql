-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2025 at 09:23 AM
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
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `AdminEmail` varchar(120) DEFAULT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `FullName`, `AdminEmail`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'Anuj', 'phpgurukulofficial@gmail.com', 'admin', 'f925916e2754e5e03f75dd58a5733251', '2025-10-29 13:18:10');

-- --------------------------------------------------------

--
-- Table structure for table `overdue`
--

CREATE TABLE `overdue` (
  `StudentID` varchar(11) NOT NULL,
  `StudentName` varchar(40) NOT NULL,
  `MobNumber` varchar(11) NOT NULL,
  `Fine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblauthors`
--

CREATE TABLE `tblauthors` (
  `id` int(11) NOT NULL,
  `AuthorName` varchar(159) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblauthors`
--

INSERT INTO `tblauthors` (`id`, `AuthorName`, `creationDate`, `UpdationDate`) VALUES
(5, 'Tamilan publication', '2025-10-29 06:45:04', NULL),
(6, 'Kalki publication', '2025-11-18 03:46:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblbookreservations`
--

CREATE TABLE `tblbookreservations` (
  `id` int(11) NOT NULL,
  `StudentID` varchar(100) DEFAULT NULL,
  `BookID` int(11) DEFAULT NULL,
  `RequestDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblbookreservations`
--

INSERT INTO `tblbookreservations` (`id`, `StudentID`, `BookID`, `RequestDate`, `Status`) VALUES
(0, '18', 17, '2025-11-08 04:02:38', 'Pending'),
(0, '25', 17, '2025-11-08 04:15:05', 'Pending'),
(0, '25', 17, '2025-11-08 04:31:12', 'Pending'),
(0, '25', 17, '2025-11-08 04:34:55', 'Pending'),
(0, '25', 17, '2025-11-08 04:43:07', 'Pending'),
(0, '18', 17, '2025-11-08 04:48:08', 'Pending'),
(0, '18', 17, '2025-11-08 05:08:05', 'Pending'),
(0, '18', 17, '2025-11-08 05:13:02', 'Pending'),
(0, '18', 17, '2025-11-08 05:19:02', 'Pending'),
(0, '5', 17, '2025-11-08 05:42:01', 'Pending'),
(0, '5', 17, '2025-11-08 05:50:53', 'Pending'),
(0, '5', 17, '2025-11-08 05:50:54', 'Pending'),
(0, '5', 17, '2025-11-08 05:57:42', 'Pending'),
(0, '6', 17, '2025-11-08 06:02:22', 'Pending'),
(0, '5', 17, '2025-11-08 16:07:06', 'Pending'),
(0, '33', 28, '2025-11-18 03:44:43', 'Pending'),
(0, '33', 28, '2025-11-18 03:44:45', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `tblbooks`
--

CREATE TABLE `tblbooks` (
  `id` int(11) NOT NULL,
  `BookName` varchar(255) DEFAULT NULL,
  `Copies` int(3) NOT NULL,
  `IssuedCopies` int(3) NOT NULL,
  `CatId` int(11) DEFAULT NULL,
  `AuthorId` int(11) DEFAULT NULL,
  `ISBNNumber` int(11) DEFAULT NULL,
  `BookPrice` int(11) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblbooks`
--

INSERT INTO `tblbooks` (`id`, `BookName`, `Copies`, `IssuedCopies`, `CatId`, `AuthorId`, `ISBNNumber`, `BookPrice`, `RegDate`, `UpdationDate`) VALUES
(10, 'Art of not overthinking', 5, 2, 16, 5, 5, 100, '2025-10-29 13:11:17', '2025-11-03 08:53:58'),
(11, 'kalki', 5, 2, 15, 5, 4, 100, '2025-10-29 13:11:55', '2025-10-30 05:44:29'),
(12, 'The power of now', 5, 1, 16, 5, 1, 100, '2025-10-29 13:15:05', '2025-10-29 23:56:49'),
(13, 'The 7 habitas of highly effective people', 3, 0, 16, 5, 6, 128, '2025-11-01 04:09:59', NULL),
(14, 'Ponniyin Selvan', 5, 2, 15, 5, 7, 300, '2025-11-01 04:11:20', '2025-11-11 23:47:20'),
(15, 'yavana Rani', 4, 0, 15, 5, 8, 200, '2025-11-01 04:11:57', NULL),
(16, 'Kadal pura ', 3, 2, 15, 5, 9, 210, '2025-11-01 04:13:15', '2025-11-11 23:47:03'),
(17, 'Think and Grow rich', 0, 1, 16, 5, 10, 121, '2025-11-01 04:13:44', '2025-11-03 09:27:31'),
(18, 'you can with', 4, 0, 16, 5, 11, 120, '2025-11-01 04:17:01', NULL),
(19, 'Algoritshm', 2, 0, 17, 5, 12, 212, '2025-11-01 04:17:46', NULL),
(20, 'clean code', 5, 0, 17, 5, 13, 430, '2025-11-01 04:18:21', NULL),
(21, 'python crash course', 10, 0, 17, 5, 14, 300, '2025-11-01 04:19:20', NULL),
(22, 'Java', 10, 0, 17, 5, 15, 432, '2025-11-01 04:19:46', NULL),
(23, 'Thinking,fast and slow', 3, 1, 18, 5, 16, 129, '2025-11-01 04:20:38', '2025-11-03 14:21:16'),
(24, 'How to win ', 4, 0, 18, 5, 17, 300, '2025-11-01 04:21:21', NULL),
(25, 'how ot influence people', 6, 0, 18, 5, 18, 183, '2025-11-01 04:21:52', NULL),
(26, 'To kill a mocking bird', 0, 0, 18, 5, 19, 632, '2025-11-01 04:22:31', '2025-11-01 04:22:49'),
(27, 'Flourish', 6, 0, 18, 5, 20, 312, '2025-11-01 04:23:25', NULL),
(28, 'Snow white', 0, 1, 20, 5, 21, 60, '2025-11-03 09:22:34', '2025-11-03 09:24:19'),
(29, 'Atomic habits', 5, 0, 16, 5, 2, 100, '2025-11-05 06:19:32', NULL),
(30, 'art of being alone', 10, 1, 16, 5, 3, 134, '2025-11-05 08:26:41', '2025-11-17 15:13:12'),
(31, 'finding nemo', 0, 1, 20, 6, 33, 230, '2025-11-18 03:49:08', '2025-11-18 03:49:59');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL,
  `CategoryName` varchar(150) DEFAULT NULL,
  `Status` int(1) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `CategoryName`, `Status`, `CreationDate`, `UpdationDate`) VALUES
(15, 'Tamil novel', 1, '2025-10-29 06:44:38', '0000-00-00 00:00:00'),
(16, 'Motivational', 1, '2025-10-29 06:44:48', '0000-00-00 00:00:00'),
(17, 'Technology', 1, '2025-11-01 04:10:16', '0000-00-00 00:00:00'),
(18, 'pyschology', 1, '2025-11-01 04:20:03', '0000-00-00 00:00:00'),
(20, 'Nighttime-story', 1, '2025-11-03 09:21:45', '0000-00-00 00:00:00'),
(21, 'Science', 1, '2025-11-18 03:45:30', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblfine`
--

CREATE TABLE `tblfine` (
  `fine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblfine`
--

INSERT INTO `tblfine` (`fine`) VALUES
(100);

-- --------------------------------------------------------

--
-- Table structure for table `tblissuedbookdetails`
--

CREATE TABLE `tblissuedbookdetails` (
  `id` int(11) NOT NULL,
  `BookId` int(11) DEFAULT NULL,
  `StudentID` varchar(150) DEFAULT NULL,
  `IssuesDate` timestamp NULL DEFAULT current_timestamp(),
  `ReturnDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `ReturnStatus` int(1) NOT NULL,
  `fine` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblissuedbookdetails`
--

INSERT INTO `tblissuedbookdetails` (`id`, `BookId`, `StudentID`, `IssuesDate`, `ReturnDate`, `ReturnStatus`, `fine`) VALUES
(16, 7, '28', '2025-10-29 07:00:07', NULL, 0, NULL),
(17, 7, '5', '2025-10-29 08:41:07', NULL, 0, NULL),
(18, 11, '22', '2025-10-29 23:56:20', NULL, 0, NULL),
(19, NULL, '5', '2025-10-29 23:56:49', NULL, 0, NULL),
(20, 10, '28', '2025-10-30 05:42:22', '2025-11-08 16:06:18', 1, NULL),
(21, 9, '5', '2025-10-30 05:43:54', NULL, 0, NULL),
(22, 11, '6', '2025-10-30 05:44:29', '2025-11-08 10:33:59', 0, 600),
(23, 10, '43', '2025-10-30 09:17:16', '2025-11-01 04:08:20', 1, NULL),
(24, NULL, '8', '2025-11-03 08:52:18', NULL, 0, NULL),
(25, 16, '9', '2025-11-03 08:52:33', NULL, 0, NULL),
(26, 10, '8', '2025-11-03 08:53:58', NULL, 0, NULL),
(27, 28, '25', '2025-11-03 09:24:19', '2025-11-08 04:14:50', 0, 100),
(28, NULL, '18', '2025-11-03 09:24:45', NULL, 0, NULL),
(29, 17, '18', '2025-11-03 09:27:31', '2025-11-08 03:57:36', 0, 100),
(30, 23, '25', '2025-11-03 14:21:16', '2025-11-08 04:14:50', 0, 100),
(31, NULL, '23', '2025-11-03 14:22:12', NULL, 0, NULL),
(32, 9, '23', '2025-11-03 14:22:38', NULL, 0, NULL),
(33, 9, '20', '2025-11-05 06:23:14', NULL, 0, NULL),
(34, 9, '21', '2025-11-05 06:23:28', NULL, 0, NULL),
(35, 9, '17', '2025-11-05 06:23:57', NULL, 0, NULL),
(36, 9, '22', '2025-11-05 06:24:14', NULL, 0, NULL),
(37, 9, '12', '2025-11-05 08:21:06', NULL, 0, NULL),
(38, 16, '7', '2025-11-11 23:47:03', '2025-11-17 15:14:39', 0, 200),
(39, 14, '9', '2025-11-11 23:47:20', NULL, 0, NULL),
(40, 30, '5', '2025-11-17 15:13:12', NULL, 0, NULL),
(41, 31, '33', '2025-11-18 03:49:59', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblmessage`
--

CREATE TABLE `tblmessage` (
  `id` int(11) NOT NULL,
  `StudentID` varchar(100) NOT NULL,
  `Message` text NOT NULL,
  `SentDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` enum('Unread','Read') DEFAULT 'Unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblmessage`
--

INSERT INTO `tblmessage` (`id`, `StudentID`, `Message`, `SentDate`, `Status`) VALUES
(1, '25', 'Dear student, your book return date has exceeded. Please return the book as soon as possible.', '2025-11-08 04:10:41', 'Unread'),
(2, '8', 'Dear student, your book return date has exceeded. Please return the book as soon as possible.', '2025-11-08 04:17:18', 'Unread'),
(3, '7', 'Dear student, your book return date has exceeded. Please return the book as soon as possible.', '2025-11-17 15:13:36', 'Unread'),
(4, '8', 'Dear student, your book return date has exceeded. Please return the book as soon as possible.', '2025-11-18 03:50:58', 'Unread');

-- --------------------------------------------------------

--
-- Table structure for table `tblrequestedbookdetails`
--

CREATE TABLE `tblrequestedbookdetails` (
  `StudentID` varchar(20) NOT NULL,
  `StudName` varchar(40) NOT NULL,
  `BookName` varchar(50) NOT NULL,
  `CategoryName` varchar(20) NOT NULL,
  `AuthorName` varchar(50) NOT NULL,
  `ISBNNumber` int(11) NOT NULL,
  `BookPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblrequestedbookdetails`
--

INSERT INTO `tblrequestedbookdetails` (`StudentID`, `StudName`, `BookName`, `CategoryName`, `AuthorName`, `ISBNNumber`, `BookPrice`) VALUES
('5', 'divya@gmail.com', 'Kadal pura ', 'Tamil novel', 'Tamilan publication', 9, 210),
('5', 'divya@gmail.com', 'Art of not overthinking', 'Motivational', 'Tamilan publication', 5, 100),
('33', 'mowil@gmail.com', 'kalki', 'Tamil novel', 'Tamilan publication', 4, 100);

-- --------------------------------------------------------

--
-- Table structure for table `tblstudents`
--

CREATE TABLE `tblstudents` (
  `id` int(11) NOT NULL,
  `StudentId` varchar(100) DEFAULT NULL,
  `FullName` varchar(120) DEFAULT NULL,
  `EmailId` varchar(120) DEFAULT NULL,
  `MobileNumber` char(11) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `Status` int(1) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblstudents`
--

INSERT INTO `tblstudents` (`id`, `StudentId`, `FullName`, `EmailId`, `MobileNumber`, `Password`, `Status`, `RegDate`, `UpdationDate`) VALUES
(1, '22', 'Divya', 'divya@gmail.com', '8569710025', '12345', 1, '2025-10-29 06:54:31', '2025-10-29 06:57:46'),
(12, '5', 'Divya', 'divya@gmail.com', '7927930808', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-10-29 06:48:22', NULL),
(13, '6', 'Hari', 'hari@gmail.com', '8928849293', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-10-29 06:48:49', NULL),
(14, '7', 'sivapriya', 'sivapriya@gmail.com', '8783289409', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-10-29 06:50:01', NULL),
(20, '1', 'Harshini', 'harshini@gmail.com', '6309838843', '12345', 1, '2025-10-30 06:36:31', '2025-10-30 06:37:17'),
(100, '28', 'lakshmi', 'lakshmi@gmail.com', '8879710025', '12345', 1, '2025-10-29 06:55:50', '2025-10-29 06:57:52'),
(200, '43', 'Harshini', 'harshini@gmail.com', '6309838843', '12345', 1, '2025-10-30 06:37:02', '2025-10-30 06:37:24'),
(201, '8', 'Ravi', 'ravi@gmail.com', '8498580330', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-10-31 14:41:46', NULL),
(202, '9', 'karthi', 'karthi@gmail.com', '8438209848', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-10-31 14:42:43', NULL),
(203, '10', 'meera', 'meera@gmail.com', '9298428932', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-10-31 14:43:44', NULL),
(204, '11', 'usha', 'usha@gmail.com', '9984892123', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-10-31 14:45:01', NULL),
(205, '12', 'keerthi', 'keerthi@gmail.com', '8377283729', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-10-31 14:47:31', NULL),
(206, '13', 'ramya', 'ramya@gmail.com', '8300239012', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-10-31 14:49:17', NULL),
(207, '14', 'ashmitha', 'ashmitha@gmail.com', '6398192891', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-10-31 14:50:49', NULL),
(208, '15', 'Vidhula', 'vidhula@gmail.com', '9030382123', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-10-31 14:51:28', NULL),
(209, '16', 'kaviya', 'kaviya@gmail.com', '7892112312', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-10-31 14:52:12', NULL),
(210, '17', 'preethi', 'preethi@gmail.com', '6329100001', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-10-31 14:53:08', NULL),
(211, '18', 'parthibaa', 'parthibaa@gmail.com', '9001235768', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-10-31 14:53:46', '2025-11-03 09:31:00'),
(212, '19', 'sangavi', 'sangavi@gmail.com', '9712345678', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-10-31 14:54:38', NULL),
(213, '20', 'sahana', 'sahana@gmail.com', '9876543212', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-10-31 14:55:06', NULL),
(214, '21', 'Nivetha ', 'nivetha@gmail.com', '7831209378', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-11-01 03:50:23', NULL),
(216, '23', 'Vijay', 'vijay@gmail.com', '8979123539', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-11-01 03:50:57', NULL),
(217, '24', 'Surya', 'surya@gmail.com', '9012345321', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-11-01 03:52:08', NULL),
(218, '25', 'kirtna', 'kirtna@gmail.com', '7900122123', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-11-01 03:53:20', NULL),
(219, '26', 'pavithra', 'pavithra@gmail.com', '9126781289', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-11-01 03:53:50', NULL),
(220, '27', 'lathika', 'lathika@gmail.com', '7938920012', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-11-01 03:54:20', NULL),
(222, '29', 'Ajith', 'ajith@gmail.com', '7912038484', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-11-01 04:04:11', NULL),
(223, '30', 'vikram', 'vikram@gmail.com', '9389132131', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-11-01 04:05:00', NULL),
(224, '31', 'kathir', 'kathir@gmail.com', '7023750302', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-11-01 04:07:49', NULL),
(225, '32', 'sowmiya', 'sowmiya@gmail.com', '7927991913', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-11-03 09:19:48', NULL),
(226, '33', 'mowil', 'mowil@gmail.com', '7929012893', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2025-11-18 03:43:26', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblauthors`
--
ALTER TABLE `tblauthors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbooks`
--
ALTER TABLE `tblbooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblissuedbookdetails`
--
ALTER TABLE `tblissuedbookdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmessage`
--
ALTER TABLE `tblmessage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblstudents`
--
ALTER TABLE `tblstudents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `StudentId` (`StudentId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblauthors`
--
ALTER TABLE `tblauthors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblbooks`
--
ALTER TABLE `tblbooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblissuedbookdetails`
--
ALTER TABLE `tblissuedbookdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tblmessage`
--
ALTER TABLE `tblmessage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblstudents`
--
ALTER TABLE `tblstudents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
