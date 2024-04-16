-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Apr 12, 2024 at 01:12 AM
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
(1, 'Cake', 1, 1000.00, '6606868cda2ff4.05116255.webp'),
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
