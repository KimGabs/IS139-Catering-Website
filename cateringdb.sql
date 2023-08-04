-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 04, 2023 at 04:06 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cateringdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `inquiryId` int(11) NOT NULL,
  `senderName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`inquiryId`, `senderName`, `email`, `subject`, `message`, `submission_date`) VALUES
(1, 'Ryo Sumiyoshi', 'Kawasaki24@gmail.com', 'Mitsubishi', 'Honda, Mitsubishi, Fujitsu, Sushimi, Kawasaki, Canon, Samurai', '2023-08-03 10:59:17'),
(2, 'Mark Jonas', 'Jonas@mymail.com', 'Request for new flavor', 'Please add a new flavor to your dessert category. I&#039;m tired of eating the same dessert everyday. Thanks', '2023-08-03 11:00:54');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` int(11) UNSIGNED NOT NULL,
  `orderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `cxName` varchar(255) DEFAULT NULL,
  `contactNo` varchar(20) DEFAULT NULL,
  `eventDate` date DEFAULT NULL,
  `eventTime` varchar(64) DEFAULT NULL,
  `eventLocation` varchar(255) DEFAULT NULL,
  `request` text DEFAULT NULL,
  `totalPrice` decimal(10,2) DEFAULT NULL,
  `orderStatus` varchar(50) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `orderItemId` int(11) UNSIGNED NOT NULL,
  `pkgId` int(11) NOT NULL,
  `orderId` int(11) UNSIGNED NOT NULL,
  `prodId` int(11) NOT NULL,
  `pax` int(11) DEFAULT NULL,
  `rice` varchar(32) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `pkgTotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prodId` int(11) NOT NULL,
  `prodName` varchar(255) NOT NULL,
  `prodDesc` text DEFAULT NULL,
  `prodCat` varchar(128) DEFAULT NULL,
  `prodPrice` decimal(10,2) NOT NULL,
  `prodImage` varchar(512) DEFAULT NULL,
  `prodStatus` varchar(128) DEFAULT 'draft',
  `prodCreated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `prodUpdated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usersID` int(11) NOT NULL,
  `usersName` varchar(128) NOT NULL,
  `usersEmail` varchar(128) NOT NULL,
  `usersUid` varchar(128) NOT NULL,
  `usersPwd` varchar(128) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usersID`, `usersName`, `usersEmail`, `usersUid`, `usersPwd`, `user_type`) VALUES
(9, 'John Doe', 'johndoe@aol.com', 'jdoe12', '$2y$10$APbT1w6lUskEM7zyyhG1w.MdwV.Ea6g4g0S/Q7vWGBuqd/8/gpyc6', 'admin'),
(10, 'Snoop Dogg', 'admin01@croms.com', 'admin', '$2y$10$qBovuIgTIR1dpsoAmWmn5OQ0.7sidFxn66MF2Z/TDFIxXKR3HcekK', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`inquiryId`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`orderItemId`),
  ADD KEY `orderId` (`orderId`),
  ADD KEY `prodId` (`prodId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prodId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usersID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `inquiryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `orderItemId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prodId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `usersID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`prodId`) REFERENCES `products` (`prodId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
