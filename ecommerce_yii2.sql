-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 06:17 PM
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
  `session_id` varchar(255) DEFAULT NULL,
  `status` enum('active','ordered') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `session_id`, `status`, `created_at`) VALUES
(1, 1, NULL, '', '2025-04-16 20:23:38'),
(2, 2, NULL, '', '2025-04-24 02:26:56'),
(3, 2, NULL, 'ordered', '2025-04-23 05:54:30'),
(6, NULL, '1g567slpcv9n0bseglhrnhg6p4', 'active', '2025-05-10 15:05:24'),
(7, 1, NULL, '', '2025-05-14 12:29:43'),
(8, 1, NULL, '', '2025-05-14 12:57:04'),
(9, 1, NULL, '', '2025-05-14 13:00:52'),
(10, 1, NULL, '', '2025-05-14 13:03:17'),
(11, 1, NULL, '', '2025-05-14 13:24:16'),
(12, 1, NULL, '', '2025-05-14 13:27:27'),
(13, 1, NULL, '', '2025-05-14 13:28:49'),
(14, 1, NULL, '', '2025-05-14 13:34:14'),
(15, 1, NULL, '', '2025-05-14 13:35:15'),
(16, 1, NULL, '', '2025-05-14 13:37:41'),
(17, 1, NULL, '', '2025-05-14 13:42:32'),
(18, 1, NULL, '', '2025-05-14 13:49:49'),
(19, 1, NULL, '', '2025-05-14 14:06:15'),
(20, 1, NULL, '', '2025-05-14 14:07:15'),
(21, 1, NULL, '', '2025-05-14 14:24:58'),
(22, 1, NULL, '', '2025-05-14 14:26:14'),
(23, 1, NULL, '', '2025-05-14 16:12:16'),
(24, 1, NULL, '', '2025-05-14 18:04:32'),
(25, 1, NULL, '', '2025-05-14 20:04:21'),
(26, 1, NULL, '', '2025-05-14 20:34:37'),
(27, 1, NULL, '', '2025-05-14 22:49:36'),
(28, 2, NULL, '', '2025-05-15 02:17:50'),
(29, 2, NULL, '', '2025-05-15 02:33:51'),
(30, 2, NULL, '', '2025-05-15 02:58:11'),
(31, 2, NULL, '', '2025-05-15 03:00:27'),
(32, 2, NULL, '', '2025-05-15 03:03:32'),
(33, 2, NULL, '', '2025-05-15 03:08:04'),
(34, 1, NULL, 'active', '2025-05-15 03:22:19');

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
(5, 3, 3, 3),
(6, 3, 1, 1),
(25, 6, 33, 1),
(61, 28, 27, 1),
(62, 28, 28, 1),
(63, 29, 33, 1),
(64, 30, 39, 1),
(65, 31, 32, 1),
(66, 32, 39, 1),
(67, 33, 31, 1),
(68, 27, 27, 1),
(69, 34, 39, 1);

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
(1, 'Keyboards', 'keyboards.jpg'),
(2, 'Keycaps', 'keycaps.jpg'),
(3, 'Switches', 'switches.jpg'),
(4, 'Accessories', 'accessories.jpg'),
(5, 'Deskmats', 'deskmats.jpg'),
(6, 'Cables', 'cables.jpg');

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
  `created_at` datetime DEFAULT current_timestamp(),
  `dispatch_status` enum('pending','shipped') NOT NULL DEFAULT 'pending',
  `stripe_session_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `cart_id`, `total`, `status`, `created_at`, `dispatch_status`, `stripe_session_id`) VALUES
(1, 2, 1, 219.97, 'cancelled', '2025-04-16 20:23:39', 'pending', NULL),
(2, 2, 2, 189.00, 'paid', '2025-04-20 12:32:54', 'shipped', NULL),
(3, 2, 3, 349.98, 'pending', '2025-04-25 19:34:35', 'pending', NULL),
(4, 1, 23, 793.81, 'pending', '2025-05-14 23:59:07', 'pending', 'cs_test_b1XucRaqDqqIhtTOZMGTjCCxZJzgQ6ua5xRafDKeba5f9qh58ZkvhbXprq'),
(5, 1, 24, 32.99, 'paid', '2025-05-15 00:04:35', 'shipped', 'cs_test_a1aUI57zqAA3LiycA3kvgy5awcyL6uUwLbbDRUPR1iwVEbzBLu6wTBZsuh'),
(6, 1, 25, 32.99, 'pending', '2025-05-15 02:25:30', 'pending', 'cs_test_a15rjbpkoi1J0i7AOfXjjVJBjvPw7KS0QKpveo5KJBMRCYJpq4JaMQ85aw'),
(7, 1, 26, 29.99, 'paid', '2025-05-15 02:34:43', 'shipped', 'cs_test_a1DqxzjQto1O7SD3noPTbBWW7wCa8Wm5iwVTvodyTjekoGKdYhtwS2clGI'),
(8, 2, 28, 29.98, 'pending', '2025-05-15 08:18:00', 'pending', 'cs_test_b1PQQG7039U2Drbg2wwS94fr3Q6V63OgEd0xf7Q5E5Ole1BAvYZTNA6jGz'),
(10, 2, 29, 31.99, 'pending', '2025-05-15 08:33:54', 'pending', 'cs_test_a1LGC3PE4hjdSexqtBqQNUFV86TtO6IlsQBIFaTJyae7nx3scqgKfINi6q'),
(14, 2, 32, 557.61, 'paid', '2025-05-15 09:04:06', 'pending', 'cs_test_a12DVxKPnhwRpPoVGYWkuCtMmFDTjZob7ejuV0fg8AbQ0j3B4VdDWUUiSe'),
(15, 2, 33, 26.99, 'pending', '2025-05-15 09:08:07', 'pending', 'cs_test_a1neHsgIvj8KP80BIg0XU282oVX1FySBFfgpvCIrKnuBtiR7Zpirkv5eJI'),
(16, 2, 33, 26.99, 'paid', '2025-05-15 09:12:54', 'pending', 'cs_test_a13vrol8BWRFNjCJyiZ1EuwHAwa6tlW0C4fHQRaZL2MsSgiivsYXhWSSgq'),
(17, 1, 27, 19.98, 'paid', '2025-05-15 09:14:41', 'pending', 'cs_test_a13c7in7uqKGSWi7mMwEOO99EhQmSJ57hUUT1nUlFHNYsn2wl8VNHtLxXC'),
(18, 1, 34, 557.61, 'pending', '2025-05-15 09:22:22', 'pending', 'cs_test_a1dwQAFZ8i7W7ha0gVGX700qB8i21m7i0YVRjBeIJBqfRPsXXvzKA2x9AA'),
(19, 1, 34, 557.61, 'paid', '2025-05-15 09:30:44', 'shipped', 'cs_test_a1WgEIPYMerSwSFXCwKUVakx5fd5DsZ2mw6QeLTGuAFo9zqd2qJubwRuoU'),
(20, 1, 34, 557.61, 'pending', '2025-05-15 10:35:31', 'pending', 'cs_test_a1AdTlQZvUJxuNwVDwes58prwakHzprfAJnewENk7vt4gwfecZGjUaGwok');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(5, 14, 39, 1, 557.61),
(6, 14, 39, 1, 557.61),
(7, 16, 31, 1, 26.99),
(8, 16, 31, 1, 26.99),
(9, 17, 27, 1, 19.99),
(10, 17, 27, 1, 19.99);

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
(1, 'Glorious Gaming', 'GMMK Pro', 'Barebones 75% keyboard with aluminum case', 169.99, 21, 1, 'gmmk_pro.jpg'),
(2, 'Keychron', 'Keychron Q1', 'Prebuilt keyboard with VIA support', 189.00, 15, 1, 'keychron_q1.jpg'),
(3, 'Akko', 'Akko V3 Creaming Black Pro Switch', '45 pieces of 5-pin linear switch with 55gf operating force.', 674.81, 51, 3, 'akko_creamy_black_pro.jpg'),
(4, 'GMK', 'GMK Bento Keycap Set', 'High-quality keycap set with a Bento theme', 119.00, 9, 2, 'gmk_bento.jpg'),
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
(26, 'Akko', 'Switch Lubing Station', 'Tray and tools for lubing switches', 24.99, 38, 4, 'lubing_station.jpg'),
(27, 'GMK', 'Stabilizer Set', 'PCB screw-in stabilizers', 19.99, 39, 4, 'gmk_stabilizers.jpg'),
(28, 'KBDfans', 'Switch Films', 'Switch films to reduce wobble', 9.99, 68, 4, 'switch_films.jpg'),
(29, 'Akko', 'Akko Tokyo Deskmat', 'Deskmat with Tokyo night design', 29.99, 18, 5, 'akko_tokyo.jpg'),
(30, 'Glorious', 'Stealth Deskmat', 'Minimal black-on-black deskmat', 19.99, 27, 5, 'stealth_deskmat.jpg'),
(31, 'Divinikey', 'Rainforest Deskmat', 'Green nature-themed deskmat', 26.99, 13, 5, 'rainforest_deskmat.jpg'),
(32, 'SpaceCables', 'Laser Cable', 'Bright violet and cyan themed cable', 32.99, 10, 6, 'laser_cable.jpg'),
(33, 'Zap Cables', 'Neon Green A-to-C Cable', 'Turquoise Paracord with Neon Green Techflex', 31.99, 14, 6, 'neongreen_cable.jpg'),
(39, 'Akko', 'Akko CS Lavender Purple Switch (45 pcs)', '3 pin and fits keycaps with standard MX structure;', 557.61, 47, 3, 'akko_cs_lavender.jpg');

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
(2, 'demo', '$2y$10$Oy1loEBhaqyGhbvsLpPU4OxflMuVdNggU20FC9rjjzLuJGeXSpPbW', 'Keihle', 'L.', 'Pascual', 'user@example.com', 'user', 'Angeles City, Pampanga');

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
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

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
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

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
