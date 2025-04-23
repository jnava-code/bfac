-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2025 at 04:06 AM
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
-- Database: `bfac`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_accounts`
--

CREATE TABLE `admin_accounts` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('Admin','Treasurer') NOT NULL,
  `profile_image` varchar(255) DEFAULT 'profile_images/default_profile.jpg',
  `is_archived` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_accounts`
--

INSERT INTO `admin_accounts` (`user_id`, `full_name`, `username`, `password`, `email`, `role`, `profile_image`, `is_archived`, `created_by`) VALUES
(1, 'Administrator', 'admin', '$2y$10$g5ArkrZmU72GNXwBecq5R..9qE1Egz6R56880UU.ZOnfr3klV7A1K', '', 'Admin', 'profile_images/default_profile.jpg', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_dividends`
--

CREATE TABLE `admin_dividends` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `dividend_amount` decimal(10,2) NOT NULL,
  `receipt` varchar(150) NOT NULL,
  `calculation_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_dividends`
--

INSERT INTO `admin_dividends` (`id`, `member_id`, `dividend_amount`, `receipt`, `calculation_date`) VALUES
(1, 1, 30.00, '3616516189', '2023-04-22 20:16:39'),
(2, 1, 50.00, '651616381', '2023-04-22 20:16:56'),
(3, 1, 80.00, '646816', '2025-04-22 21:01:58');

-- --------------------------------------------------------

--
-- Table structure for table `admin_expenses`
--

CREATE TABLE `admin_expenses` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `expense_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_expenses`
--

INSERT INTO `admin_expenses` (`id`, `category`, `amount`, `expense_date`, `description`, `year`) VALUES
(1, 'Others', 200.00, '2024-04-22', 'Payment', 2024);

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_sales`
--

CREATE TABLE `admin_sales` (
  `id` int(11) NOT NULL,
  `sales_no` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unitprice` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `receipt_no` varchar(50) NOT NULL,
  `purchase_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_sales`
--

INSERT INTO `admin_sales` (`id`, `sales_no`, `description`, `quantity`, `unitprice`, `amount`, `receipt_no`, `purchase_date`) VALUES
(1, '1000', 'Product Name', 2, '200', 400.00, '616813205385', '2024-04-22'),
(2, '1001', 'Example', 2, '100', 200.00, '6516516', '2025-04-23');

-- --------------------------------------------------------

--
-- Table structure for table `admin_shares`
--

CREATE TABLE `admin_shares` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `update_at` timestamp NULL DEFAULT NULL,
  `is_archived` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_shares`
--

INSERT INTO `admin_shares` (`id`, `member_id`, `update_at`, `is_archived`) VALUES
(1, 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin_shares_list`
--

CREATE TABLE `admin_shares_list` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `paid_up_share_capital` decimal(10,2) NOT NULL,
  `share_capital` decimal(10,2) NOT NULL,
  `receipt_number` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_shares_list`
--

INSERT INTO `admin_shares_list` (`id`, `member_id`, `paid_up_share_capital`, `share_capital`, `receipt_number`, `created_at`) VALUES
(1, 1, 200.00, 2.00, '15643515', '2024-04-22 10:38:56'),
(2, 1, 200.00, 2.00, '6162626', '2024-04-22 13:37:58'),
(3, 1, 200.00, 2.00, '61616', '2025-04-22 14:56:07');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `status` enum('pending','active','inactive') DEFAULT 'pending',
  `position_on_board` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dividends_transaction`
--

CREATE TABLE `dividends_transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL COMMENT 'Withdraw or Send to Shares',
  `amount_withdrawn` decimal(12,2) NOT NULL,
  `receipt_control_number` varchar(50) NOT NULL,
  `transaction_datetime` datetime NOT NULL,
  `action_taken` varchar(50) DEFAULT 'Archive' COMMENT 'Action like Archive for transaction',
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shares_transaction`
--

CREATE TABLE `shares_transaction` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `shares_added` int(11) NOT NULL,
  `purchase_amount` decimal(10,2) NOT NULL,
  `receipt_control_number` int(255) NOT NULL,
  `transaction_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_financial_summary`
--

CREATE TABLE `user_financial_summary` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `share_capital` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_shares` int(11) NOT NULL DEFAULT 0,
  `dividend_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `projected_dividend` decimal(12,2) DEFAULT NULL,
  `date_generated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_members`
--

CREATE TABLE `user_members` (
  `member_id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `username` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `rsbsa_number` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `farm_location` text DEFAULT NULL,
  `role` enum('User') DEFAULT NULL,
  `profile_image` varchar(255) NOT NULL DEFAULT 'profile_images/default_profile.jpg',
  `status` enum('Pending','Approved','Rejected') NOT NULL,
  `is_archived` int(11) NOT NULL,
  `is_verified` int(11) NOT NULL,
  `token` varchar(250) DEFAULT NULL,
  `token_expiry` varchar(150) DEFAULT NULL,
  `date_registered` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_members`
--

INSERT INTO `user_members` (`member_id`, `first_name`, `middle_name`, `last_name`, `username`, `email`, `password`, `phone`, `rsbsa_number`, `address`, `farm_location`, `role`, `profile_image`, `status`, `is_archived`, `is_verified`, `token`, `token_expiry`, `date_registered`) VALUES
(1, 'Jeremiah', '', 'Nava', 'jnava', 'aiahnava5@gmail.com', '$2y$10$ZRBfSIMnuxDxuLp9o1Q6xOwiZKbM51NgaFISB6RX8w0rJdBX6t0lS', '09155434721', '', 'taga dito', 'Secret', 'User', 'profile_images/default_profile.jpg', 'Approved', 0, 1, NULL, '2025-04-22 13:29:16', '2025-04-22 10:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `rsbsa_number` varchar(30) DEFAULT NULL,
  `home_address` text DEFAULT NULL,
  `farm_location` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `admin_dividends`
--
ALTER TABLE `admin_dividends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_members` (`member_id`);

--
-- Indexes for table `admin_expenses`
--
ALTER TABLE `admin_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `admin_sales`
--
ALTER TABLE `admin_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_shares`
--
ALTER TABLE `admin_shares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_members` (`member_id`);

--
-- Indexes for table `admin_shares_list`
--
ALTER TABLE `admin_shares_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_shares` (`member_id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `dividends_transaction`
--
ALTER TABLE `dividends_transaction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`transaction_datetime`);

--
-- Indexes for table `shares_transaction`
--
ALTER TABLE `shares_transaction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `receipt_control_number` (`receipt_control_number`);

--
-- Indexes for table `user_financial_summary`
--
ALTER TABLE `user_financial_summary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_members`
--
ALTER TABLE `user_members`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_dividends`
--
ALTER TABLE `admin_dividends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin_expenses`
--
ALTER TABLE `admin_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_sales`
--
ALTER TABLE `admin_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_shares`
--
ALTER TABLE `admin_shares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_shares_list`
--
ALTER TABLE `admin_shares_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_financial_summary`
--
ALTER TABLE `user_financial_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_members`
--
ALTER TABLE `user_members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD CONSTRAINT `admin_accounts_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `admin_users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `user_financial_summary`
--
ALTER TABLE `user_financial_summary`
  ADD CONSTRAINT `user_financial_summary_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `admin_users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `admin_users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
