-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2023 at 08:47 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `Id` int(100) NOT NULL,
  `ProjectName` varchar(100) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `StartDate` datetime(6) NOT NULL,
  `EndDate` datetime(6) NOT NULL,
  `Manager_Id` int(30) NOT NULL,
  `Developer_Ids` text NOT NULL,
  `Status` int(10) NOT NULL,
  `DateCreated` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `Id` int(30) NOT NULL,
  `Project_Id` int(30) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `Status` int(20) NOT NULL,
  `EstimatedHour` int(6) NOT NULL,
  `StartDate` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `EndDate` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `DateCreated` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(30) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` text NOT NULL,
  `type` tinyint(11) NOT NULL DEFAULT 2,
  `Status` int(20) NOT NULL,
  `Avatar` text NOT NULL,
  `DateCreated` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Name`, `Address`, `Email`, `Password`, `type`, `Status`, `Avatar`, `DateCreated`) VALUES
(6, 'Md. Shamim ', '85/1E,Kakrail,Dhaka-1000,Flat-2A', 'shamimrahman920@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, '', '2023-05-21 04:34:44.566742'),
(11, 'Raisa Maliha', '85/1E, Thomas Tower, Flat-2A, kakrail, Dhaka-1000', 'maliha@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 1, '', '2023-05-21 19:49:47.782477'),
(19, 'Leo Messi', 'Argentina', 'messi@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 1, '', '2023-05-26 03:30:46.370148'),
(20, 'Alvarez', 'Argentina', 'alvarez@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, '', '2023-05-26 03:36:47.596235'),
(21, 'Emi Martinez', 'Argentina', 'emi@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 2, '', '2023-05-26 03:49:18.915520'),
(22, 'Enzo', 'Argentina', 'enzo@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 1, 'Enzo', '2023-05-27 15:30:38.153748');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `Id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `Id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
