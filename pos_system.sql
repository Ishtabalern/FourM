-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 04, 2024 at 09:06 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stock`, `image_url`) VALUES
(1, 'Tapsilog', '90.00', 10, 'img/products/tapsilog.jpg'),
(2, 'Porksilog', '80.00', 7, 'img/products/porksilog'),
(3, 'Tocilog', '80.00', 7, 'img/products/tocilog.jpg'),
(4, 'Fried Chicken', '80.00', 8, 'img/products/siken.jpg'),
(5, 'Chixsilog (Fillet)', '80.00', 8, 'img/products/chixsilog.jpg'),
(6, 'Bangsilog', '80.00', 9, 'img/products/bangsilog.jpg'),
(7, 'Beef Steak Silog', '80.00', 5, 'img/products/beef-steak.jpg'),
(8, 'Sisiglog', '80.00', 6, 'img/products/sisiglog.jpg'),
(9, 'Liempo Silog', '80.00', 10, 'img/products/leimpo.jpg'),
(10, 'Lechon Kawali Silog', '80.00', 5, 'img/products/lechon.jpg'),
(11, 'Longsilog', '70.00', 9, 'img/products/longsilog.jpg'),
(12, 'Hotsilog', '70.00', 7, 'img/products/hotsilog.jpg'),
(13, 'Cornedsilog', '70.00', 8, 'img/products/cornedsilog.jpg'),
(14, 'Hamsilog', '70.00', 10, 'img/products/hamsilog.jpg'),
(15, 'Chicken Sisig', '80.00', 7, 'img/products/chickensisig.jpg'),
(16, 'Rice', '12.00', 47, 'img/products/rice.jpg'),
(17, 'Softdrinks', '15.00', 45, 'img/products/softdrinks.png'),
(18, 'Coffee', '15.00', 18, 'img/products/coffee.jpg'),
(19, 'Extra Egg', '15.00', 97, 'img/products/egg.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total` decimal(10,2) NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `queue_number` int(11) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`),
  UNIQUE KEY `queue_number` (`queue_number`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `total`, `date`, `queue_number`, `status`) VALUES
(17, '70.00', '2024-06-09 15:17:37', 2, 'pending'),
(16, '80.00', '2024-06-09 15:10:27', 1, 'pending'),
(18, '80.00', '2024-06-15 02:47:02', NULL, 'paid'),
(19, '80.00', '2024-06-15 02:53:21', 3, 'Pending'),
(20, '80.00', '2024-06-15 02:55:06', 4, 'Paid'),
(21, '80.00', '2024-06-15 02:57:05', 5, 'Paid'),
(22, '80.00', '2024-06-15 03:02:03', 6, 'Paid'),
(23, '80.00', '2024-06-15 03:04:03', 7, 'Paid'),
(24, '125.00', '2024-06-15 04:16:45', 8, 'Paid'),
(25, '160.00', '2024-06-15 04:21:34', 9, 'Paid'),
(26, '80.00', '2024-06-15 04:34:56', 10, 'Paid'),
(27, '12.00', '2024-06-15 04:47:40', 11, 'Paid'),
(28, '204.00', '2024-06-15 04:51:04', 12, 'Paid'),
(29, '275.00', '2024-06-15 04:52:06', 13, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `sales_items`
--

DROP TABLE IF EXISTS `sales_items`;
CREATE TABLE IF NOT EXISTS `sales_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_id` (`sale_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_items`
--

INSERT INTO `sales_items` (`id`, `sale_id`, `product_id`, `quantity`, `price`) VALUES
(1, 2, 1, 1, '80.00'),
(2, 2, 7, 1, '80.00'),
(3, 3, 1, 1, '80.00'),
(4, 3, 7, 1, '80.00'),
(5, 4, 2, 1, '80.00'),
(6, 4, 4, 1, '80.00'),
(7, 4, 5, 1, '80.00'),
(8, 5, 7, 1, '80.00'),
(9, 5, 8, 1, '80.00'),
(10, 5, 13, 1, '70.00'),
(11, 5, 15, 1, '80.00'),
(12, 6, 1, 2, '80.00'),
(13, 6, 4, 1, '80.00'),
(14, 6, 10, 1, '80.00'),
(15, 7, 2, 1, '80.00'),
(16, 8, 2, 1, '80.00'),
(17, 9, 2, 2, '80.00'),
(18, 10, 2, 2, '80.00'),
(19, 11, 3, 2, '80.00'),
(20, 12, 19, 2, '15.00'),
(21, 13, 2, 2, '80.00'),
(22, 14, 1, 2, '80.00'),
(23, 14, 6, 1, '80.00'),
(24, 14, 8, 1, '80.00'),
(25, 14, 11, 1, '70.00'),
(26, 14, 12, 1, '70.00'),
(27, 15, 5, 1, '80.00'),
(28, 16, 1, 1, '80.00'),
(29, 17, 12, 1, '70.00'),
(30, 18, 1, 1, '80.00'),
(31, 19, 2, 1, '80.00'),
(32, 20, 3, 1, '80.00'),
(33, 21, 8, 1, '80.00'),
(34, 22, 15, 1, '80.00'),
(35, 23, 10, 1, '80.00'),
(36, 24, 15, 1, '80.00'),
(37, 24, 17, 1, '15.00'),
(38, 24, 18, 2, '15.00'),
(39, 25, 7, 1, '80.00'),
(40, 25, 10, 1, '80.00'),
(41, 26, 10, 1, '80.00'),
(42, 27, 16, 1, '12.00'),
(43, 28, 8, 1, '80.00'),
(44, 28, 12, 1, '70.00'),
(45, 28, 16, 2, '12.00'),
(46, 28, 17, 1, '15.00'),
(47, 28, 19, 1, '15.00'),
(48, 29, 7, 1, '80.00'),
(49, 29, 10, 1, '80.00'),
(50, 29, 13, 1, '70.00'),
(51, 29, 17, 3, '15.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$ge1xBRAv3QXpDNDfyK5TauyVGqkfd.BErKZYKcdeplrXwKE18zZi2', 'admin'),
(4, 'user', '$2y$10$m742VCWcpRBkfQQ1Xa6u2u9QZ61Wq.mnWiRJ28I0yteJouTIhpEG6', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
