-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2021 at 06:59 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hyperstream`
--

-- --------------------------------------------------------

--
-- Table structure for table `connections`
--

CREATE TABLE `connections` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `connections`
--

INSERT INTO `connections` (`id`, `user_id`, `store_id`, `status`) VALUES
(1, 1, 1, 'not_connected'),
(2, 1, 2, 'connected');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `password`, `status`) VALUES
(20, 'name', 'jstseguru@gmail.com', '9811798112', '$2y$10$/IQlpnBJog6SKaVTly5znu9FVGoror/OhIHTCHM1rktaSQhMkzC22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` varchar(255) NOT NULL,
  `quantity` int(2) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `user_id`, `item_id`, `quantity`, `status`) VALUES
(2, 1, '1', 1, 'in_cart'),
(3, 1, '2', 1, 'in_cart');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `associated_store_id` int(6) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` longtext NOT NULL,
  `product_description` varchar(77) NOT NULL,
  `product_price` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_id`, `associated_store_id`, `product_name`, `product_image`, `product_description`, `product_price`) VALUES
(1, '8904145912025', 2, 'Pediasure', '71rOJ6S3DVL._SL1500_.jpg', 'To maximize your child\'s growth potential, he needs a reliable growth supplem', '200'),
(2, '8901063025363', 2, 'Milk Bikis Biscuits', '71crSyhXb6L._SL1500_.jpg', 'Milk Bikis is the perfect nurturing partner, and with the exciting waffle des', '20'),
(3, '8901719110993', 1, 'Monaco Biscuits', 'parle-monaco-salted-biscuits-200-g-0-20201118.jpg', 'Our childhood favorite biscuit: Monaco biscuits are considered healthy as the', '75');

-- --------------------------------------------------------

--
-- Table structure for table `signup_token`
--

CREATE TABLE `signup_token` (
  `id` int(11) NOT NULL,
  `user_id` varchar(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `id` int(11) NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `store_address` varchar(255) NOT NULL,
  `store_image` varchar(400) NOT NULL,
  `auth_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`id`, `store_name`, `store_address`, `store_image`, `auth_id`) VALUES
(1, 'Evergreen Supermart', 'Shop No. 1, Plot No. 2, Golf Avenue, Noida Sector 75, Noida - 201304, Near Metro Station', 'download.jpeg', '9xSr8BhYOfgRATS3Y46B'),
(2, 'Walmart', 'Somdatt Towers, K-2, Noida Sector 18, Noida - 201301, Near Citi Bank', '5676.jpeg', 'N2GxEUHE1VvdYM2mQ4gf'),
(3, 'All In One Supermarket', 'Lower Ground Floor, Great India Place Mall, Noida Sector 38, Near Atta Market, Entertainment City, Noida - 201301', 'all-in-one-supermarket-karangalpady-mangalore-supermarkets-xg4b70aaq7.webp', '834xA5qmkX2EFtgcsSvNA');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `connections`
--
ALTER TABLE `connections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signup_token`
--
ALTER TABLE `signup_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `connections`
--
ALTER TABLE `connections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `signup_token`
--
ALTER TABLE `signup_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
