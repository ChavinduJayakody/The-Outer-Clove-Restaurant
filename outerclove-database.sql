-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2024 at 09:24 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `outerclove-database`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contactNumber` varchar(20) NOT NULL,
  `contactNumber2` varchar(20) DEFAULT NULL,
  `specialNotes` text DEFAULT NULL,
  `deliveryType` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `item_image_path` varchar(255) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `item_image_path`, `item_name`, `price`) VALUES
(14, 'uploads/burger.png', 'Tropical Burger', '1800.00'),
(18, 'uploads/chicken tacos.png', 'Special Chicken Tacos', '1300.00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `placed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `no_of_persons` varchar(50) DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  `reservation_time` time DEFAULT NULL,
  `dietary_preferences` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `name`, `email`, `phone`, `no_of_persons`, `reservation_date`, `reservation_time`, `dietary_preferences`, `status`) VALUES
(1, 'Chavindu Jayakody', 'chavindujayakody2001@gmail.com', '0777969645', '5', '2023-12-26', '09:32:00', 'Non Vegetarian', 'accepted'),
(5, 'Chavindu Jayakody', 'chavindujayakody2001@gmail.com', '0777969645', '9', '2024-01-01', '05:41:00', 'Non Vegetarian', 'declined'),
(8, 'Chavindu Jayakody', 'chavindujayakody2001@gmail.com', '777969645', '4', '2024-01-04', '22:25:00', 'Vegetarian', 'accepted'),
(12, 'Chavindu Jayakody', 'chavindujayakody2001@gmail.com', '777969645', '4', '2024-02-13', '05:32:00', 'Vegetarian', 'accepted'),
(14, 'qw', 'qww@gmail.com', '2222222222222', '3', '2024-02-29', '16:41:00', 'Non Vegetarian', 'declined'),
(15, 'qqqqqq', 'qqqqq@qqq', '0', '6', '2024-02-06', '03:44:00', 'Vegetarian', 'pending'),
(16, 'Chavindu Jayakody', 'chavindujayakody2001@gmail.com', '777969645', '9', '2024-01-18', '16:37:00', 'Non Vegetarian', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`) VALUES
(1, 'Chavindu Jayakody', 'chavindujayakody2001@gmail.com', '$2y$10$KiTVhXD6e8WgZyxk7EyZzOVEp2Gs2UsMLYjyZQpiiQmAbQOmNlJDa'),
(2, 'admin', 'admin@outerclove', '$2y$10$MOy3lylzcZ0TzBv56A.BzeTA9gbk6qARBCzgWu8e7NXD5r8XADkW.'),
(3, 'staff', 'staff@outerclove', '$2y$10$pyvcbC/HHy2xgPTap6dkROQs9LPdCUGfms82fXJnzfc2VE/2kHTfe'),
(7, 'Chavi Jay', 'chavi@gmail.com', '$2y$10$X/lIOLqwqa2L0jV4lnpvF.YE8OycCk.RyqIu5aYB.z.ctofk1BuaK'),
(8, 'chavindu', 'qw@gmail.com', '$2y$10$L75Jm0qrUq.67UdjqfCvpOeCOTAdFAlLNniCc9Nx4etzIQL/ykx4y'),
(9, 'sa', 'sa@gmail.com', '$2y$10$RMARsS4vGFLthNBiCJWVGekBLrZXLTvFZH/dcHX6AHvYctsjXNmMG'),
(10, 'chavindu', 'chavin45kody2001@gmail.com', '$2y$10$eHh8IouzsnP220hioy621es60EUEQuPwHltCWJCU5ZIbqNwNRXmlq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
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
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
