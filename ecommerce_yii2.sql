CREATE DATABASE IF NOT EXISTS `ecommerce_yii` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ecommerce_yii`;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 06:57 PM
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
-- Database: `ecommerce_yii`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('active','ordered') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `status`, `created_at`) VALUES
(1, 2, 'active', '2025-04-16 20:23:38'),
(2, 2, 'active', '2025-04-24 02:26:56'),
(3, 2, 'ordered', '2025-04-23 05:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 1),
(2, 1, 3, 2),
(3, 2, 2, 1),
(4, 2, 4, 1),
(5, 3, 3, 3),
(6, 3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`) VALUES
(1, 'Keyboards', ''),
(2, 'Keycaps', ''),
(3, 'Switches', ''),
(4, 'Accessories', ''),
(5, 'Deskmats', ''),
(6, 'Cables', '');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','paid','cancelled') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `cart_id`, `total`, `status`, `created_at`) VALUES
(1, 2, 1, 219.97, 'paid', '2025-04-16 20:23:39'),
(2, 2, 2, 189.00, 'paid', '2025-04-20 12:32:54'),
(3, 2, 3, 349.98, 'pending', '2025-04-25 19:34:35');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('successful','failed') DEFAULT 'successful',
  `payment_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `method`, `amount`, `payment_status`, `payment_date`) VALUES
(1, 1, 'Credit Card', 219.97, 'successful', '2025-04-16 20:23:40'),
(2, 2, 'Credit Card', 189.00, 'successful', '2025-04-20 05:30:15');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `brand`, `name`, `description`, `price`, `stock`, `category_id`, `image`) VALUES
(1, 'Glorious Gaming', 'GMMK Pro', 'Barebones 75% keyboard with aluminum case', 169.99, 20, 1, 'gmmk_pro.jpg'),
(2, 'Keychron', 'Keychron Q1', 'Prebuilt keyboard with VIA support', 189.00, 15, 1, 'keychron_q1.jpg'),
(3, 'Akko', 'Akko V3 Creaming Black Pro Switch', '45 pieces of 5-pin linear switch with 55gf operating force.', 674.81, 50, 3, 'akko_creamy_black_pro.jpg'),
(4, 'GMK', 'GMK Bento Keycap Set', 'High-quality keycap set with a Bento theme', 119.00, 10, 2, 'gmk_bento.jpg'),
(5, 'Ducky', 'One 3 Mini', '60% keyboard with hot-swappable switches', 119.99, 25, 1, 'ducky_one3.jpg'),
(6, 'Epomaker', 'Epomaker TH66', 'Compact keyboard with knob and wireless mode', 139.99, 18, 1, 'th66.jpg'),
(7, 'Glorious Gaming', 'Glorious Panda Switches', 'Tactile switches, 36 pcs', 39.99, 40, 3, 'glorious_panda.jpg'),
(8, 'CableMod', 'Custom Coiled Cable', 'USB-C aviator cable, black', 29.99, 30, 6, 'coiled_cable.jpg'),
(9, 'Keychron', 'Keychron K6', 'Compact wireless mechanical keyboard', 89.99, 22, 1, 'keychron_k6.jpg'),
(10, 'Royal Kludge', 'RK61', '61-key RGB Bluetooth keyboard', 49.99, 35, 1, 'rk61.jpg'),
(11, 'Durgod', 'Durgod Taurus K320', 'Tenkeyless keyboard with PBT keycaps', 99.99, 15, 1, 'taurus_k320.jpg'),
(12, 'Varmilo', 'VA87M', 'Custom mechanical keyboard with dye-sub PBT keycaps', 129.99, 12, 1, 'va87m.jpg'),
(13, 'Akko', 'Akko 3068B', 'Compact mechanical keyboard with multi-mode support', 79.99, 28, 1, 'akko_3068b.jpg'),
(14, 'GMK', 'GMK Olivia', 'Premium keycap set with rose gold accents', 139.00, 8, 2, 'gmk_olivia.jpg'),
(15, 'Tai-Hao', 'Tai-Hao Miami', 'ABS keycap set with Miami color scheme', 39.99, 25, 2, 'taihao_miami.jpg'),
(16, 'Domikey', 'Domikey SA Dracula', 'SA profile keycap set in Dracula theme', 109.00, 10, 2, 'domikey_dracula.jpg'),
(17, 'EnjoyPBT', 'EnjoyPBT Greyscale', 'PBT keycaps in neutral colors', 89.99, 18, 2, 'epbt_greyscale.jpg'),
(18, 'Akko', 'Akko Neon Keycap Set', 'Vibrant PBT keycap set with neon colors', 49.99, 20, 2, 'akko_neon.jpg'),
(19, 'Gateron', 'Gateron Yellow', 'Smooth linear switch ideal for gaming', 29.99, 50, 3, 'gateron_yellow.jpg'),
(20, 'Kailh', 'Kailh Box White', 'Clicky switches with tactile feedback', 32.99, 45, 3, 'kailh_box_white.jpg'),
(21, 'TTC', 'TTC Gold Pink', 'Silent linear switches', 34.99, 35, 3, 'ttc_gold_pink.jpg'),
(22, 'Durock', 'Durock T1', 'Tactile switch with early bump', 36.99, 40, 3, 'durock_t1.jpg'),
(23, 'NovelKeys', 'NK_ Silk Black', 'Linear switches pre-lubed from factory', 31.99, 30, 3, 'nk_silk_black.jpg'),
(24, 'Glorious', 'Switch Opener', 'Tool to open MX-style switches', 14.99, 60, 4, 'switch_opener.jpg'),
(25, 'Ducky', 'Keycap Puller', 'Stainless steel keycap puller', 7.99, 100, 4, 'keycap_puller.jpg'),
(26, 'Akko', 'Switch Lubing Station', 'Tray and tools for lubing switches', 24.99, 40, 4, 'lubing_station.jpg'),
(27, 'GMK', 'Stabilizer Set', 'PCB screw-in stabilizers', 19.99, 45, 4, 'gmk_stabilizers.jpg'),
(28, 'KBDfans', 'Switch Films', 'Switch films to reduce wobble', 9.99, 70, 4, 'switch_films.jpg'),
(29, 'NovelKeys', 'Peach Deskmat', 'Large deskmat with pastel peach design', 24.99, 25, 5, 'peach_deskmat.jpg'),
(30, 'KBDfans', 'Galaxy Deskmat', 'Cosmic-themed deskmat', 27.99, 20, 5, 'galaxy_deskmat.jpg'),
(31, 'Akko', 'Akko Tokyo Deskmat', 'Deskmat with Tokyo night design', 29.99, 22, 5, 'akko_tokyo.jpg'),
(32, 'Glorious', 'Stealth Deskmat', 'Minimal black-on-black deskmat', 19.99, 30, 5, 'stealth_deskmat.jpg'),
(33, 'Divinikey', 'Rainforest Deskmat', 'Green nature-themed deskmat', 26.99, 18, 5, 'rainforest_deskmat.jpg'),
(34, 'CableMod', 'Purple Coiled Cable', 'Premium coiled cable with aviator', 34.99, 25, 6, 'purple_coiled.jpg'),
(35, 'Mechcables', 'Carbon Cable', 'Custom USB cable in carbon theme', 29.99, 22, 6, 'carbon_cable.jpg'),
(36, 'SpaceCables', 'Laser Cable', 'Bright violet and cyan themed cable', 32.99, 18, 6, 'laser_cable.jpg'),
(37, 'Zap Cables', 'Blackout Cable', 'Matte black coiled cable', 31.99, 20, 6, 'blackout_cable.jpg'),
(38, 'Kono', 'Kono Aviator Cable', 'Color-matched detachable cable', 33.99, 15, 6, 'kono_aviator.jpg');


-- --------------------------------------------------------

--
-- Table structure for table `product_tags`
--

CREATE TABLE `product_tags` (
  `product_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_tags`
--

INSERT INTO `product_tags` (`product_id`, `tag_id`) VALUES
(1, 1),
(1, 2),
(1, 5),
(2, 1),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(2, 'Barebones'),
(5, 'DIY Kit'),
(1, 'Hot-swappable'),
(3, 'Pre-built'),
(4, 'Wireless');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `middlename`, `lastname`, `email`, `role`, `address`) VALUES
(1, 'admin', '$2y$10$mTuOYYcmweU/AWLOKh/iC.5.AzUHCzlWtDT76NTS4rIszzAYZmc5i', 'admin', NULL, 'NULL', 'admin@example.com', 'admin', 'MacArthur Hwy, Angeles, 2009 Pampanga, Philippines'),
(2, 'user', '$2y$10$fUZ881.pbVvFRby1qOidZeMPeVBspfIl1v9j.vKmO0CiB2IuN3IeS', 'Keihle', 'L.', 'Pascual', 'user@example.com', 'user', 'Angeles City, Pampanga');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cart_id` (`cart_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD PRIMARY KEY (`product_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD CONSTRAINT `product_tags_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
