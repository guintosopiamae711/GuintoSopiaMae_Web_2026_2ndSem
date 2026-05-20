-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2026 at 06:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `farmers_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(9, 'maemae', 'juan@gmail.com', '12345', '2026-05-13 02:21:19'),
(10, 'admin123', 'admin123@gmail.com', '123456789', '2026-05-13 02:26:16');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approval_status` varchar(50) NOT NULL DEFAULT 'Pending Approval',
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `payment_method` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `fullname`, `contact`, `address`, `total`, `created_at`, `approval_status`, `status`, `payment_method`) VALUES
(9, 5, 'Mariel Sazon', '09123245346', 'porac', 80.00, '2026-05-14 06:01:33', 'Rejected', 'Cancelled', 'GCASH'),
(10, 5, 'Mariel Sazon', '09123245346', 'porac', 80.00, '2026-05-14 06:04:21', 'Rejected', 'Cancelled', 'GCASH'),
(11, 5, 'mame', '09612545781', 'porac', 80.00, '2026-05-14 06:05:57', 'Rejected', 'Cancelled', 'GCASH'),
(12, 5, 'mame', '09612545781', 'sdfds', 80.00, '2026-05-14 06:08:57', 'Rejected', 'Cancelled', 'GCASH'),
(13, 5, 'Rhealle', '09612545781', 'SanJuan', 80.00, '2026-05-14 06:15:53', 'Approved', 'Out for Delivery', 'GCASH'),
(14, 5, 'Niño Anjelo', '09612545781', 'Pias Porac Pampanga', 430.00, '2026-05-19 03:07:53', 'Approved', 'Delivered', 'GCASH');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `price`, `qty`, `subtotal`) VALUES
(1, 1, 'Bigas', 50.00, 1, 50.00),
(2, 1, 'Mais', 30.00, 1, 30.00),
(3, 2, 'Bigas', 50.00, 1, 50.00),
(4, 2, 'Mais', 30.00, 3, 90.00),
(5, 2, 'Gulay - Talong', 20.00, 1, 20.00),
(6, 3, 'Vegetables', 120.00, 1, 120.00),
(7, 4, 'Vegetables - Talong', 120.00, 1, 120.00),
(8, 4, 'Vegetables - Kangkong', 120.00, 2, 240.00),
(9, 5, 'Cucumber', 70.00, 1, 70.00),
(10, 5, 'Vegetables - Sitaw', 120.00, 1, 120.00),
(11, 5, 'Pork', 330.00, 2, 660.00),
(12, 5, 'Tomato', 90.00, 1, 90.00),
(13, 6, 'Pork', 330.00, 1, 330.00),
(14, 7, 'EggPlant', 80.00, 1, 80.00),
(15, 8, 'EggPlant', 80.00, 5, 400.00),
(16, 9, 'EggPlant', 80.00, 1, 80.00),
(17, 10, 'EggPlant', 80.00, 1, 80.00),
(18, 11, 'EggPlant', 80.00, 1, 80.00),
(19, 12, 'EggPlant', 80.00, 1, 80.00),
(20, 13, 'EggPlant', 80.00, 1, 80.00),
(21, 14, 'Sweet Corn', 150.00, 1, 150.00),
(22, 14, 'Mango', 65.00, 1, 65.00),
(23, 14, 'Stawberry', 120.00, 1, 120.00),
(24, 14, 'Watermelon', 95.00, 1, 95.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(150) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `stock`, `image`, `created_at`) VALUES
(1, 'EggPlant', 80.00, 100, 'talong.jpg.jpg', '2026-05-14 04:47:32'),
(2, 'String Bean', 25.00, NULL, 'sitaw.jpg.jpg', '2026-05-14 06:24:36'),
(3, 'Bitter Gourd', 20.00, NULL, 'images (5).jpg', '2026-05-14 06:25:07'),
(4, 'Bok Choy', 25.00, NULL, 'petchay.jpg.jpg', '2026-05-14 06:25:46'),
(5, 'Chayote', 30.00, NULL, 'sayote.jpg', '2026-05-14 06:26:17'),
(6, 'Brocolli', 120.00, NULL, 'download.jpg', '2026-05-14 06:26:38'),
(7, 'Radish', 50.00, NULL, 'images (6).jpg', '2026-05-14 06:27:17'),
(8, 'Water Spinach', 15.00, NULL, 'kangkong.jpg.jpg', '2026-05-14 06:27:58'),
(9, 'Banana', 100.00, NULL, '1.jpg', '2026-05-14 06:28:25'),
(10, 'Dragon Fruit', 85.00, NULL, 'images.jpg', '2026-05-14 06:29:11'),
(11, 'Apple', 35.00, NULL, 'images (1).jpg', '2026-05-14 06:29:23'),
(12, 'Orange', 25.00, NULL, 'images (2).jpg', '2026-05-14 06:29:41'),
(13, 'Watermelon', 95.00, NULL, 'images (4).jpg', '2026-05-14 06:30:13'),
(14, 'Stawberry', 120.00, NULL, 'images (3).jpg', '2026-05-14 06:30:30'),
(15, 'Mango', 65.00, NULL, 'mango._TTW_._CR0,0,720,720_._SR580,580_._QL100_.jpg', '2026-05-14 06:30:48'),
(16, 'Sweet Corn', 150.00, NULL, 'mais.jpg.jpg', '2026-05-14 06:31:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `FullName` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Contact` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `reset_code` varchar(10) DEFAULT NULL,
  `reset_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `FullName`, `Address`, `Contact`, `email`, `password`, `reset_code`, `reset_expiry`) VALUES
(1, NULL, '', '', '0', NULL, NULL, NULL, NULL),
(2, 'Sopia Mae Guinto', '', '', '0', 'guintosopiamae@gmail.com', '123123', NULL, '2026-05-19 05:11:50'),
(4, '10@gmail.com', '', '', '0', '1@gmail.com', '12345', NULL, NULL),
(5, 'Mae Guinto', '', '', '0', 'nio@gmail.com', '123456', NULL, NULL),
(6, 'jaze', '', '', '', 'jaze74893@gmail.com', '123', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
