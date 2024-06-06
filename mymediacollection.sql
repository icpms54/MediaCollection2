-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2024 at 08:02 AM
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
-- Database: `mymediacollection`
--

-- --------------------------------------------------------

--
-- Table structure for table `collection`
--

CREATE TABLE `collection` (
  `CollectionID` int(11) NOT NULL,
  `ProfileID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `MediaID` int(11) NOT NULL,
  `Title` text NOT NULL,
  `Format` text NOT NULL,
  `ReleaseYear` int(11) NOT NULL,
  `Author_Artist` text NOT NULL,
  `ISBN_UPC` int(11) NOT NULL,
  `Runtime_Duration` int(11) NOT NULL,
  `Genre` text NOT NULL,
  `Language` text NOT NULL,
  `Publisher_Label` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`MediaID`, `Title`, `Format`, `ReleaseYear`, `Author_Artist`, `ISBN_UPC`, `Runtime_Duration`, `Genre`, `Language`, `Publisher_Label`) VALUES
(2, 'Spider-man', 'Movie', 2000, 'Sony', 12345, 2, 'Action', 'English', 'Sony'),
(3, 'Mission impossible', 'Movie', 1999, 'Tom cruise', 123456, 2, 'Spy', 'English', 'Sony'),
(4, 'Movies', '', 0, '', 0, 0, '', '', ''),
(5, '8', '5', 5, '5', 5, 5, '5', '5', '5'),
(9, 'robot cool', 'mind', 0, 'f', 0, 1, '00', '0', '0'),
(13, 'fff', 'ffff', 2020, 'ff', 123, 20, 'ff', 'ff', 'ff'),
(14, 'sponge bob', 'DVD', 2001, 'Nick', 123456, 90, 'Comedy', 'English', 'Nick'),
(15, 'Sponge bob', 'DVD', 2000, 'Nick', 123456, 90, 'Comedy', 'English ', 'Nick'),
(19, 'Test', 'Test', 2000, 'Test', 123456, 90, 'Test', 'Test', 'Test'),
(21, 'Test', 'Test', 2000, 'Test', 123456, 90, 'Test', 'Test', 'Test'),
(22, 'Test 2.0', 'Test 2.0', 2005, 'Test 2.0', 123456, 50, 'Test 2.0', 'Test 2.0', 'Test 2.0'),
(23, 'Batman', 'DVD', 2012, 'IDK', 123456, 120, 'Action', 'English', 'Sony'),
(25, 'Mario', 'Video game', 1996, 'Nintendo', 123456, 800, 'Platformer', 'English', 'Nintendo'),
(26, 'Test', 'Test', 2008, 'Test', 123456, 85, 'Test', 'Test', 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `mediatocollection`
--

CREATE TABLE `mediatocollection` (
  `MediaCollectionID` int(11) NOT NULL,
  `MediaID` int(11) NOT NULL,
  `CollectionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ownership`
--

CREATE TABLE `ownership` (
  `UserMediaID` int(11) NOT NULL,
  `ProfileID` int(11) NOT NULL,
  `MediaID` int(11) NOT NULL,
  `PurchaseDate` date NOT NULL,
  `PurchasePrice` int(11) NOT NULL,
  `ItemCondition` text NOT NULL,
  `Notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `ProfileID` int(11) NOT NULL,
  `Username` text NOT NULL,
  `Password` text NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `DOB` date NOT NULL,
  `Email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`ProfileID`, `Username`, `Password`, `FirstName`, `LastName`, `DOB`, `Email`) VALUES
(3, 'Bjones', '$2y$10$svAtn7HTRDiKYdTnv/whe.UgRnxLRpAEg8Sj867SaXCPz5lIuRpe6', 'Bob', 'Jones', '2024-04-01', 'bjones@yahoo.com'),
(4, 'Sbrown', '$2y$10$VvO/VU.IqcAOETjJ1ihTT.1ufGXwzZCNp8QIqV1BJ07iKWdq4pFgG', 'Susie', 'Brown', '2024-04-08', 'sbrown@aol.com'),
(12, '54321', '$2y$10$lJSfyIGzVz5VDVZASj7eEOs70P183zrAFASPASR44vV5bsGV24fpC', 'berbyq', 'groool', '2024-04-03', 'ddddd@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `ratingreview`
--

CREATE TABLE `ratingreview` (
  `RatingID` int(11) NOT NULL,
  `ProfileID` int(11) NOT NULL,
  `MediaID` int(11) NOT NULL,
  `Rating` int(11) NOT NULL,
  `Review` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `collection`
--
ALTER TABLE `collection`
  ADD PRIMARY KEY (`CollectionID`),
  ADD KEY `ProfileID` (`ProfileID`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`MediaID`);

--
-- Indexes for table `mediatocollection`
--
ALTER TABLE `mediatocollection`
  ADD PRIMARY KEY (`MediaCollectionID`),
  ADD KEY `CollectionID` (`CollectionID`),
  ADD KEY `MediaID` (`MediaID`);

--
-- Indexes for table `ownership`
--
ALTER TABLE `ownership`
  ADD PRIMARY KEY (`UserMediaID`),
  ADD KEY `MediaID` (`MediaID`),
  ADD KEY `ProfileID` (`ProfileID`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`ProfileID`);

--
-- Indexes for table `ratingreview`
--
ALTER TABLE `ratingreview`
  ADD PRIMARY KEY (`RatingID`),
  ADD KEY `MediaID` (`MediaID`),
  ADD KEY `ProfileID` (`ProfileID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `collection`
--
ALTER TABLE `collection`
  MODIFY `CollectionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `MediaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `mediatocollection`
--
ALTER TABLE `mediatocollection`
  MODIFY `MediaCollectionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `ownership`
--
ALTER TABLE `ownership`
  MODIFY `UserMediaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `ProfileID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ratingreview`
--
ALTER TABLE `ratingreview`
  MODIFY `RatingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `collection`
--
ALTER TABLE `collection`
  ADD CONSTRAINT `collection_ibfk_1` FOREIGN KEY (`ProfileID`) REFERENCES `profile` (`ProfileID`);

--
-- Constraints for table `mediatocollection`
--
ALTER TABLE `mediatocollection`
  ADD CONSTRAINT `mediatocollection_ibfk_1` FOREIGN KEY (`CollectionID`) REFERENCES `collection` (`CollectionID`),
  ADD CONSTRAINT `mediatocollection_ibfk_2` FOREIGN KEY (`MediaID`) REFERENCES `media` (`MediaID`);

--
-- Constraints for table `ownership`
--
ALTER TABLE `ownership`
  ADD CONSTRAINT `ownership_ibfk_1` FOREIGN KEY (`MediaID`) REFERENCES `media` (`MediaID`),
  ADD CONSTRAINT `ownership_ibfk_2` FOREIGN KEY (`ProfileID`) REFERENCES `profile` (`ProfileID`);

--
-- Constraints for table `ratingreview`
--
ALTER TABLE `ratingreview`
  ADD CONSTRAINT `ratingreview_ibfk_1` FOREIGN KEY (`MediaID`) REFERENCES `media` (`MediaID`),
  ADD CONSTRAINT `ratingreview_ibfk_2` FOREIGN KEY (`ProfileID`) REFERENCES `profile` (`ProfileID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
