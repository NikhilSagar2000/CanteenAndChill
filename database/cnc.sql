-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2021 at 02:40 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cnc`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `username` varchar(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` text NOT NULL,
  `customer_phone` text NOT NULL,
  `total_items` int(255) NOT NULL,
  `total` int(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`username`, `customer_id`, `customer_name`, `customer_phone`, `total_items`, `total`, `date`) VALUES
('gouravbajaj', 23182, 'Shubham', '9989768566', 1, 100, '2021-06-08'),
('nikhilsagar', 20093, 'Satyam Baghla', '9879879879', 3, 270, '2021-06-08'),
('nikhilsagar ', 24004, 'Shubham', '9453223677', 1, 360, '2021-06-08'),
('nikhilsagar', 58830, 'Utsav Chugh', '9876543212', 3, 480, '2021-06-08'),
('nikhilsagar', 71394, 'Pankaj', '9988976757', 1, 140, '2021-06-09'),
('nikhilsagar', 77164, 'Satyam ', '9878987898', 2, 280, '2021-06-08');

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

CREATE TABLE `customer_order` (
  `username` varchar(20) NOT NULL,
  `id` int(10) NOT NULL,
  `itemname` varchar(25) NOT NULL,
  `itemtype` varchar(255) NOT NULL,
  `price` int(10) NOT NULL,
  `itemquantity` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_order`
--

INSERT INTO `customer_order` (`username`, `id`, `itemname`, `itemtype`, `price`, `itemquantity`, `total`, `date`) VALUES
('gouravbajaj', 23182, 'patties', 'fastfood', 20, 5, 100, '2021-06-08'),
('nikhilsagar', 20093, 'burger', 'fastfood', 20, 3, 60, '2021-06-08'),
('nikhilsagar', 20093, 'cheese sandwich', 'fastfood', 50, 3, 150, '2021-06-08'),
('nikhilsagar', 20093, 'mango shake', 'shake', 20, 3, 60, '2021-06-08'),
('nikhilsagar ', 24004, 'momos 9pcs', 'fastfood', 60, 6, 360, '2021-06-08'),
('nikhilsagar', 58830, 'cheese burger', 'fastfood', 30, 4, 120, '2021-06-08'),
('nikhilsagar', 58830, 'chocolate pastry', 'pastry', 40, 4, 160, '2021-06-08'),
('nikhilsagar', 58830, 'oreo shake', 'shake', 50, 4, 200, '2021-06-08'),
('nikhilsagar', 71394, 'burger', 'fastfood', 20, 7, 140, '2021-06-09'),
('nikhilsagar', 77164, 'cheese burger', 'fastfood', 30, 4, 120, '2021-06-08'),
('nikhilsagar', 77164, 'chocolate pastry', 'pastry', 40, 4, 160, '2021-06-08');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`) VALUES
('gouravbajaj', 'gouravbajaj'),
('nikhilsagar', 'nikhil5-9-2000');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `username` varchar(20) NOT NULL,
  `itemname` varchar(25) NOT NULL,
  `type` varchar(20) NOT NULL,
  `price` int(5) NOT NULL,
  `quantity` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`username`, `itemname`, `type`, `price`, `quantity`) VALUES
('gouravbajaj', 'patties', 'fastfood', 20, 95),
('nikhilsagar', 'burger', 'fastfood', 20, 70),
('nikhilsagar', 'cheese burger', 'fastfood', 30, 92),
('nikhilsagar', 'cheese sandwich', 'fastfood', 50, 97),
('nikhilsagar', 'chocolate pastry', 'pastry', 40, 92),
('nikhilsagar', 'mango shake', 'shake', 20, 97),
('nikhilsagar', 'oreo shake', 'shake', 50, 96),
('nikhilsagar', 'patties', 'fastfood', 15, 90),
('nikhilsagar', 'pineapple pastry', 'pastry', 40, 90);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`username`,`customer_id`);

--
-- Indexes for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD PRIMARY KEY (`username`,`id`,`itemname`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`username`,`itemname`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
