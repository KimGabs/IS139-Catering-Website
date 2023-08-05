-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 05, 2023 at 05:57 AM
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

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_name`, `quantity`, `price`) VALUES
(1, 'Fork', 128, '7.40'),
(3, 'tissue', 90, '14.00'),
(4, 'Serving Trays', 10, '300.00'),
(5, 'Buffet Tables', 2, '5000.00'),
(6, 'Beverage Dispensers', 3, '1200.00'),
(7, 'Tablecloths', 24, '500.00'),
(8, 'Ice Buckets', 5, '300.00'),
(9, 'Serving Spoons', 50, '800.00');

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

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `orderDate`, `cxName`, `contactNo`, `eventDate`, `eventTime`, `eventLocation`, `request`, `totalPrice`, `orderStatus`) VALUES
(1, '2023-08-05 03:40:56', 'Pepito Manaloto', '09521231234', '2023-08-09', '15:40', '1234 Batista st, Sampaloc, Manila', 'could you please ensure all dishes are prepared gluten-free, as several of our guests have gluten intolerances?', '37444.16', 'ongoing'),
(2, '2023-08-05 03:42:51', 'John Doe', '09192151111', '2023-08-25', '17:45', '1234 Constantine Ext., Greenville Subdivision, Valenzuela City', 'No need for utensils', '20604.52', 'pending'),
(3, '2023-08-05 03:48:45', 'Juan Cruz', '04818210101', '2023-08-23', '07:50', 'Unit G, West Tower, Shangri-la Place', 'I kindly request a delectable vegan-friendly menu with a diverse selection of plant-based delights to cater to our guests\' dietary preferences and make our event a memorable experience.', '23416.00', 'cancelled');

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

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`orderItemId`, `pkgId`, `orderId`, `prodId`, `pax`, `rice`, `total`, `pkgTotal`) VALUES
(1, 1, 1, 1, 38, 'on', '6840.00', '16720.00'),
(2, 1, 1, 2, 38, 'on', '9500.00', '16720.00'),
(3, 2, 1, 8, 48, 'off', '7424.16', '21104.16'),
(4, 2, 1, 9, 48, 'off', '13680.00', '21104.16'),
(5, 1, 2, 11, 38, 'on', '4390.52', '16949.52'),
(6, 1, 2, 3, 38, 'on', '5339.00', '16949.52'),
(7, 1, 2, 1, 38, 'on', '6840.00', '16949.52'),
(8, 2, 2, 7, 30, 'off', '4035.00', '4035.00'),
(9, 1, 3, 2, 30, 'off', '7500.00', '15181.20'),
(10, 1, 3, 11, 30, 'off', '3466.20', '15181.20'),
(11, 1, 3, 3, 30, 'off', '4215.00', '15181.20'),
(12, 2, 3, 13, 34, 'on', '2645.20', '8574.80'),
(13, 2, 3, 4, 34, 'on', '5589.60', '8574.80');

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

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prodId`, `prodName`, `prodDesc`, `prodCat`, `prodPrice`, `prodImage`, `prodStatus`, `prodCreated_at`, `prodUpdated_at`) VALUES
(1, 'Beef Sinigang', 'Indulge in the savory delight of Beef Sinigang, a Filipino classic soup featuring tender beef, tangy tamarind broth, and a medley of fresh vegetables, creating a comforting and flavorful experience in every spoonful.', 'beef viands', '180.00', '../../img/products/64cd3f02d9f9f-Beef-Sinigang.jpeg', 'active', '2023-08-04 18:10:10', '2023-08-04 18:11:42'),
(2, 'Beef Salpicao', 'Savor the rich and savory flavors of tender Beef Salpicao, a delectable fusion of succulent beef, garlic, and spices.', 'beef viands', '250.00', '../../img/products/64cd3f3aa065d-beef-salpicao.jpeg', 'active', '2023-08-04 18:11:06', '2023-08-04 18:11:43'),
(3, 'Beef Stew', 'Savor the rich and comforting flavors of our slow-cooked Beef Stew, tender beef simmered with hearty vegetables and aromatic spices, a true comfort food indulgence.', 'beef viands', '140.50', '../../img/products/64cd3fadaae06-Beef-Stew.jpeg', 'active', '2023-08-04 18:13:01', '2023-08-04 18:13:10'),
(4, 'Buttered Chicken', 'Indulge in the rich and aromatic delight of Buttered Chicken, tender pieces of chicken cooked to perfection in a luscious buttery sauce.', 'chicken viands', '164.40', '../../img/products/64cd400471326-butter-chicken.jpeg', 'active', '2023-08-04 18:14:28', '2023-08-04 18:36:39'),
(5, 'Bangus steak', 'Savor the delectable flavors of our succulent Bangus Steak, expertly marinated and grilled to perfection, offering a delightful seafood indulgence.', 'fish & seafood viands ', '220.45', '../../img/products/64cd404f4c806-bangusSteak.jpeg', 'active', '2023-08-04 18:15:43', '2023-08-04 18:36:42'),
(6, 'Sweet & Sour Fish Fillet', 'Indulge in the tantalizing flavors of our Sweet & Sour Fish Fillet, perfectly fried to a crispy golden brown and generously coated with our signature tangy sauce – a delightful seafood delight.', 'fish & seafood viands ', '178.24', '../../img/products/64cd41c230c4a-Sweet-Sour-fish.jpg', 'active', '2023-08-04 18:21:54', '2023-08-04 18:36:59'),
(7, 'Grilled Bangus', 'Indulge in the mouthwatering delight of our perfectly grilled bangus, seasoned to perfection and served with a side of steamed vegetables.', 'fish & seafood viands ', '134.50', '../../img/products/64cd4212aa786-grilled-fish.jpeg', 'active', '2023-08-04 18:23:14', '2023-08-04 18:37:02'),
(8, 'Grilled Pusit', 'Savor the tantalizing flavors of perfectly grilled Pusit (squid), a delightful seafood delicacy that brings the taste of the ocean to your plate.', 'fish & seafood viands ', '154.67', '../../img/products/64cd429f65fbc-Grilled-Pusit.jpeg', 'active', '2023-08-04 18:25:35', '2023-08-04 18:36:57'),
(9, 'Paksiw na Bangus', 'Milkfish In Vinegar Stew is delicious, especially with hot and newly cooked rice with fish sauce as the balancer. Thus, the perfect time of the day to eat it is morning for breakfast as it can awaken you with its sour taste and smell.', 'fish & seafood viands ', '285.00', '../../img/products/64cd434c6278d-Paksiw-Bangus.jpg', 'active', '2023-08-04 18:28:28', '2023-08-04 18:36:50'),
(10, 'Chicken Curry', 'Chicken Curry is a spicy and flavorful chicken curry from the South Indian state of Andra Pradesh in India. This curry gets its unique flavor from the freshly roasted spice mix. Here is how to make it in the traditional style (gluten-free).', 'chicken viands', '120.40', '../../img/products/64cd441c44f0e-Chicken-Curry.jpeg', 'active', '2023-08-04 18:31:56', '2023-08-04 18:36:53'),
(11, 'Chicken Teriyaki', 'Teriyaki is a mix of soy sauce, sake and the rice wine mirin, which imparts a subtle sweetness. The teriyaki found throughout Seattle, of which this is an adaptation, is a bit more showy. Cooks sweeten with white sugar and pineapple juice.', 'chicken viands', '115.54', '../../img/products/64cd44af03a18-Chicken-Teriyaki.jpeg', 'active', '2023-08-04 18:34:23', '2023-08-04 18:36:47'),
(12, 'Chicken Sisig', 'Sisig is a Kapampangan specialty made of diced pork seasoned with soy sauce, liquid seasoning, calamansi juice, chili, and served on a sizzling hot plate topped with an egg.', 'chicken viands', '155.89', '../../img/products/64cd45161d12c-Chicken-Sisig.jpg', 'active', '2023-08-04 18:36:06', '2023-08-04 18:36:45'),
(13, 'Vegetable stir fry', 'Masarap', 'vegetable viands', '77.80', '../../img/products/64cdb0cc47e21-Vegetable-Stir-Fry.jpeg', 'active', '2023-08-05 02:15:40', '2023-08-05 02:16:02');

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
(10, 'Dustin', 'admin01@croms.com', 'admin', '$2y$10$qBovuIgTIR1dpsoAmWmn5OQ0.7sidFxn66MF2Z/TDFIxXKR3HcekK', 'admin');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `orderItemId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prodId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
