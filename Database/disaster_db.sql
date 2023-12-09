-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2023 at 07:54 PM
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
-- Database: `disaster_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `AdminUsername` varchar(255) NOT NULL,
  `AdminPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `AdminUsername`, `AdminPassword`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `disasterinformation`
--

CREATE TABLE `disasterinformation` (
  `DisasterID` int(11) NOT NULL,
  `DisasterType` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `DateOccurred` date DEFAULT NULL,
  `Location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disasterinformation`
--

INSERT INTO `disasterinformation` (`DisasterID`, `DisasterType`, `Description`, `DateOccurred`, `Location`) VALUES
(1, 'High Level ', 'This was very High Disaster', '2023-12-13', 'Near Multan Road');

-- --------------------------------------------------------

--
-- Table structure for table `publicmessage`
--

CREATE TABLE `publicmessage` (
  `MessageID` int(11) NOT NULL,
  `InstituteID` int(11) DEFAULT NULL,
  `Title` varchar(255) NOT NULL,
  `Message` text NOT NULL,
  `DatePosted` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publicmessage`
--

INSERT INTO `publicmessage` (`MessageID`, `InstituteID`, `Title`, `Message`, `DatePosted`) VALUES
(1, 1, 'This is Message For Multan Public', 'Disaster is Coming', '2023-12-09');

-- --------------------------------------------------------

--
-- Table structure for table `reliefinformation`
--

CREATE TABLE `reliefinformation` (
  `ReliefID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `DateGranted` date DEFAULT NULL,
  `Amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reliefinformation`
--

INSERT INTO `reliefinformation` (`ReliefID`, `Title`, `Description`, `DateGranted`, `Amount`) VALUES
(1, 'NGO Camp Relief infor', 'Lahore', '2023-12-09', 30000.00);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ContactInfo` varchar(255) NOT NULL,
  `UserType` enum('General User','Rehabilitation Institutes') NOT NULL,
  `Address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Email`, `Password`, `ContactInfo`, `UserType`, `Address`) VALUES
(1, 'Nasir12', 'nasiryt.827@gmail.com', '123', '6852316845', 'Rehabilitation Institutes', 'Multan'),
(2, 'Nasir123', 'nasiryt@gmail.com', '123', '685231684566', 'General User', 'Lahore'),
(3, 'VUBWN', 'VUBWN@gmail.com', '123', '23332132', 'General User', 'dfg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `disasterinformation`
--
ALTER TABLE `disasterinformation`
  ADD PRIMARY KEY (`DisasterID`);

--
-- Indexes for table `publicmessage`
--
ALTER TABLE `publicmessage`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `InstituteID` (`InstituteID`);

--
-- Indexes for table `reliefinformation`
--
ALTER TABLE `reliefinformation`
  ADD PRIMARY KEY (`ReliefID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `disasterinformation`
--
ALTER TABLE `disasterinformation`
  MODIFY `DisasterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `publicmessage`
--
ALTER TABLE `publicmessage`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reliefinformation`
--
ALTER TABLE `reliefinformation`
  MODIFY `ReliefID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `publicmessage`
--
ALTER TABLE `publicmessage`
  ADD CONSTRAINT `publicmessage_ibfk_1` FOREIGN KEY (`InstituteID`) REFERENCES `user` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
