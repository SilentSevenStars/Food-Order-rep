-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Apr 23, 2024 at 02:13 AM
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
-- Database: `db_food`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$AU5KV/4BTMFgMDKEMpol1eyUHmAXpAareQhNKsDefV.twBvEoO47i');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `customer_id`) VALUES
(2, 5),
(3, 5),
(4, 5),
(5, 5),
(6, 5),
(7, 5),
(8, 5),
(9, 5),
(10, 5),
(11, 5),
(12, 5),
(13, 5),
(14, 5),
(15, 5),
(16, 5),
(17, 5),
(18, 5),
(19, 5),
(20, 5),
(21, 5),
(22, 5),
(23, 5),
(24, 5),
(26, 5),
(25, 32);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Desserts'),
(2, 'Beverages'),
(3, 'Main Dish'),
(6, 'Mix and Match'),
(7, 'Kiddie Meal');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `email`, `phone_number`, `address`, `password`) VALUES
(5, 'Joseph Matthew Ringor', 'josephmatthewringor@gmail.com', '09369245085', 'Lupao, Nueva Ecija', '$2y$10$3xzHv2K3Gz8LPJeS/t2e1O6KK7GQkyv93HZZcioHjrYIDBGZ6Jsqa'),
(6, 'John Doe', 'john@gmail.com', '09121231234', 'lupao', '$2y$10$gfYtipg3.UFLSRPQEAG.wO9P5'),
(7, 'kentjustine', 'kent@gmail.com', '09121231234', 'munoz', '$2y$10$ET/xMpn2qFOw.tbzhGhTQOi8t'),
(8, 'Alex Mae', 'alex@gmail.com', '09123456789', 'Lupao, Nueva Ecija', '$2y$10$PE2owysz.FqDGa/I6Gn0R.72X'),
(10, 'Jane Foster', 'jane@gmail.com', '09369245085', 'Lupao, Nueva Ecija', '$2y$10$muVFAM0GXPSyQmH1h3cjoOQxY'),
(16, 'Irish John', 'irish@gmail.com', '09121231234', 'Munoz, Nueva Ecija', '$2y$10$mAWfEh5O1fTrJr..BcMDOOMyZA.jgfbkfsKhMDjgnksXLEJGZl9Gm'),
(17, 'Jewel Mae', 'jewel@gmail.com', '09266251816', 'Lupao, Nueva Ecija', '$2y$10$Ovo5tfIoNS9axJjhA9cfaOhDFLFwODIUQ/VMtADqcynlxa8iQKl5e'),
(18, 'Jan Marie', 'janmarieringor@gmail.com', '09565547624', 'Lupao, Nueva Ecija', '$2y$10$fOY08eJUys/BpdvOlyUsluHgai3nC060PXzj/icykWfWuNzOm3A5a'),
(19, 'Owl', 'owl@gmail.com', '09121231234', 'Munoz, Nueva Ecija', '$2y$10$ephkkXMdZxCOOMLc/p3yoO2r3u88BLh6OK/KzLR6Z0Hv82qeSDBOy'),
(20, 'Anne', 'anne@gmail.com', '09266251816', 'Lupao, Nueva Ecija', '$2y$10$eZk6xU5HjkFpN/a8YxYXBeH2lhsCnxnaP/UQaGuhz6s31IoWxwPue'),
(21, 'Yasuo', 'yasuo@gmail.com', '09123456789', 'Riot Games', '$2y$10$5LEE.ylTMPaIAoCgD0RivOmDoh2fLDNmvGbOTKQEBqw6T.Y8AGyYq'),
(22, 'Ashe', 'ash@gmail.com', '09876543210', 'Pokemon', '$2y$10$FgecK3YHWGAuPbKPJ2Lkde.v4Zm2g/usKHUPNVLpUtG5GxFFIesB2'),
(23, 'Annie', 'annie@gmail.com', '09121231234', 'lupoa, nueva ecija', '$2y$10$cSKwRv2qQHANEqJ38FiJku1xVeF5afPGakZFdJhr9ed1s3Bc8ty2a'),
(24, 'Annie', 'annie@gmail.com', '09121231234', 'lupoa, nueva ecija', '$2y$10$umW4c7.kcvDZZcIioE2vwe4dNNFjaTBfXZd2tYMJ/cDpznT8o3WB.'),
(25, 'YasuMeow', 'yasumeow@gmail.com', '09121231234', 'lupoa, nueva ecija', '$2y$10$7aauzmuCmutDNTwFUkhMgO41LDCxM1z1x28vunmefwBum.5PfdhEe'),
(32, 'Juan Dela Cruz', 'juan@gmail.com', '09111231234', 'Munoz, Nueva Ecija', '$2y$10$h5Urj1EOfS4JaLhmIItlRuIyq6mRGq6OVr.P81DIHT/n4WxUOVZMu');

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE `lists` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(255) NOT NULL,
  `sub_price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lists`
--

INSERT INTO `lists` (`cart_id`, `product_id`, `quantity`, `sub_price`) VALUES
(22, 13, 3, 300),
(23, 12, 2, 40),
(25, 3, 1, 50),
(24, 3, 1, 50),
(26, 3, 1, 50);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `place_on` date NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `service` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `cart_id`, `payment_method`, `total_price`, `place_on`, `payment_status`, `service`) VALUES
(13, 22, 'Cashier', 300.00, '2024-04-21', 'Complete', 'Ready'),
(14, 23, 'GCASH', 40.00, '2024-04-21', 'Ongoing', 'Ongoing'),
(15, 24, 'GCASH', 50.00, '2024-04-23', 'Ongoing', 'Ongoing');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `category_id`, `price`, `image`) VALUES
(3, 'Drink 1', 2, 50.00, '66074c3aa8fb23.29868649.png'),
(11, 'Coffee', 2, 50.00, '66074c99631118.87616005.png'),
(12, 'Orange Juice', 2, 20.00, '66074cd06f6797.41169120.png'),
(13, 'hawaian Pizza', 3, 100.00, '66074d451260d0.02106214.png'),
(14, '4 in 1 pizza', 3, 120.00, '66074d6a3991e9.23861049.png'),
(15, 'Spaghetti', 3, 35.00, '66074d8c81abf0.29838403.png'),
(16, 'Brownie', 1, 20.00, '66074da1d21677.75362636.png'),
(18, 'Chocolate Sundae', 2, 35.00, '660aa8ba2e5185.74892423.png'),
(19, 'Hungarian Burger', 3, 40.00, '6614e6dc53c0f8.56262133.png'),
(20, 'Lechon Manok', 3, 250.00, '6614ececb3eab1.54703378.png');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `rating` varchar(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `rating`, `title`, `description`, `customer_id`, `product_id`) VALUES
(1, '5', 'Hello', 'Hwllo World', 5, 3),
(2, '3', 'Delicious', 'Best Drink ever', 32, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lists`
--
ALTER TABLE `lists`
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
