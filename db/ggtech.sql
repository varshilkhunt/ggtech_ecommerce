-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2026 at 11:18 AM
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
-- Database: `ggtech`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'varshilkhunt77@gmail.com', '123'),
(2, 'harshm50300@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cid`, `pid`, `uid`) VALUES
(72, 23, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `c_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `c_name`) VALUES
(21, 'Laptop'),
(31, 'Tablet'),
(32, 'Smart Watch'),
(33, 'Shoes'),
(34, 'Earphone'),
(35, 'Computer'),
(36, 'PC Component'),
(37, 'Mobile');

-- --------------------------------------------------------

--
-- Table structure for table `inquiry`
--

CREATE TABLE `inquiry` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiry`
--

INSERT INTO `inquiry` (`id`, `name`, `email`, `phone`, `message`) VALUES
(3, 'Varshil', 'varshilkhunt77@gmail.com', '9974976602', 'Site is looking great');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shipping_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `shipping_name`, `address`, `contact`, `payment_method`, `total_amount`, `status`) VALUES
(5, 26, 'Varshil Khunt', 'Opp. Phc Govindnagar, Moviya', '9974976602', 'COD', '419000', 'Delivered'),
(7, 26, 'Harsh Makwana', 'Moviya', '7016873608', 'Card', '210000', 'Delivered'),
(8, 28, 'Yash Kathiriya', 'Near Taluka Shala', '8140126027', 'Card', '2215000', 'Processing'),
(9, 28, 'Harsh Makwana', 'Rajkot', '8490050300', 'Online', '101000', 'Shipped'),
(10, 26, 'Varshil', 'moviya', '9974976602', 'COD', '65000', 'Shipped'),
(11, 30, 'Varshil ', 'Moviya', '9974976602', 'Online', '2365000', 'Delivered'),
(14, 30, 'qweqwdq', 'dWrw', 'wq', 'COD', '65000', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`id`, `order_id`, `pid`, `product_name`, `price`) VALUES
(1, 5, 23, 'iPhone 15 pro', 65000),
(2, 5, 22, 'Asus ROG Duo', 354000),
(3, 7, 34, 'Xiomi 15', 75000),
(4, 7, 23, 'iPhone 15 pro', 65000),
(5, 7, 29, 'Galaxy S24 Ultra', 70000),
(6, 8, 22, 'Asus ROG Duo', 354000),
(7, 8, 27, 'Galaxy Tab S11 Ultra', 110000),
(8, 8, 26, 'Galaxy Watch', 36000),
(9, 8, 34, 'Xiomi 15', 75000),
(10, 8, 35, 'NVD RTX 6000 Pro Blackwell Edition', 1500000),
(11, 8, 29, 'Galaxy S24 Ultra', 70000),
(12, 8, 29, 'Galaxy S24 Ultra', 70000),
(13, 9, 23, 'iPhone 15 pro', 65000),
(14, 9, 26, 'Galaxy Watch', 36000),
(15, 10, 23, 'iPhone 15 pro', 65000),
(16, 11, 23, 'iPhone 15 pro', 65000),
(17, 11, 34, 'Xiomi 15', 75000),
(18, 11, 27, 'Galaxy Tab S11 Ultra', 110000),
(19, 11, 29, 'Galaxy S24 Ultra', 70000),
(20, 11, 26, 'Galaxy Watch', 36000),
(21, 11, 22, 'Asus ROG Duo', 354000),
(22, 11, 32, 'MSI Gaming PC', 150000),
(23, 11, 35, 'NVD RTX 6000 Pro Blackwell Edition', 1500000),
(24, 11, 30, 'boAt earbuds', 5000),
(25, 12, 26, 'Galaxy Watch', 36000),
(26, 13, 23, 'iPhone 15 pro', 65000),
(27, 14, 23, 'iPhone 15 pro', 65000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `p_name` varchar(150) NOT NULL,
  `mrp` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `p_name`, `mrp`, `price`, `category_id`, `image`, `description`) VALUES
(22, 'Asus ROG Duo', 360000, 354000, 21, 'image/628771054asus rog.png', 'Dual Screen Gaming'),
(23, 'iPhone 15 pro', 70000, 65000, 37, 'image/1274131662ip 15 pro.webp', '48MP Main Camera\r\n'),
(26, 'Galaxy Watch', 40000, 36000, 32, 'image/1405570310galaxy watch.webp', 'With 4.4 Inches Display'),
(27, 'Galaxy Tab S11 Ultra', 120000, 110000, 31, 'image/1151606743galaxy tab s11 ultra.webp', 'With 5G Network'),
(28, 'Adidas Campus ', 12000, 10000, 33, 'image/441405658adidas campus.jfif', 'Adidas Campus OOF Sneakers'),
(29, 'Galaxy S24 Ultra', 85000, 70000, 37, 'image/205482675galaxy s24 ultra.avif', '200MP AI Camera'),
(30, 'boAt earbuds', 7000, 5000, 34, 'image/1930348913boat earbuds.avif', '40 ms low latency gaming buds\r\n'),
(31, 'Go Boult Nackband', 5000, 4000, 34, 'image/185047061nackband.webp', '58Hr Playback Time'),
(32, 'MSI Gaming PC', 165000, 150000, 35, 'image/1249690773msi pc.jpg', 'Intel core i9 14th Gen, 8GB NVIDIA RTX 5090Ti Graphics '),
(34, 'Xiomi 15', 85000, 75000, 37, 'image/1556629728mi 15.jpg', 'Snapdragon 8 Elite'),
(35, 'NVD RTX 6000 Pro Blackwell Edition', 1600000, 1500000, 36, 'image/64874997graphic card.jpg', '1.8 TB RAM GPU Clock Speed is 2617 MHz'),
(38, 'MacBook Pro', 115000, 105000, 21, 'image/1438897795mcbook.jfif', 'M5 chip\r\nNext-generation speed and powerful on-device AI');

-- --------------------------------------------------------

--
-- Table structure for table `users_registration`
--

CREATE TABLE `users_registration` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_registration`
--

INSERT INTO `users_registration` (`id`, `name`, `email`, `mobile`, `password`) VALUES
(30, 'Varshil', 'varshilkhunt77@gmail.com', '9974976602', '$2y$10$NH0V1WiWmddK4j5802HAGOXyfznWMjEllM9bPgeGENfONZHSvcJkS');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiry`
--
ALTER TABLE `inquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_registration`
--
ALTER TABLE `users_registration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `inquiry`
--
ALTER TABLE `inquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users_registration`
--
ALTER TABLE `users_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
