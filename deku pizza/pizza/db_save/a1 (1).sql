-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2018 at 01:41 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 5.6.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `a1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `email` varchar(128) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`email`, `password`) VALUES
('admin@pizzaasap.it', 'adminadmin');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notification`
--

CREATE TABLE `admin_notification` (
  `ID` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `type` int(11) NOT NULL,
  `description` varchar(512) NOT NULL,
  `time_stamp` datetime NOT NULL,
  `new` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_notification`
--

INSERT INTO `admin_notification` (`ID`, `email`, `type`, `description`, `time_stamp`, `new`) VALUES
(3, 'admin@pizzaasap.it', 1, 'The user asdf@gmail.com has just finished an order.', '2018-10-14 01:30:49', 0),
(4, 'admin@pizzaasap.it', 1, 'The user asdf@gmail.com has just finished an order.', '2018-10-14 01:39:19', 0),
(5, 'admin@pizzaasap.it', 1, 'The user asdf@gmail.com has just finished an order.', '2018-10-14 05:10:39', 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `calzone`
-- (See below for the actual view)
--
CREATE TABLE `calzone` (
`ID` int(11)
,`name` varchar(32)
,`price` decimal(10,2)
,`id_category` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `email` varchar(128) NOT NULL,
  `id_object` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `ID` int(11) NOT NULL,
  `name` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`ID`, `name`) VALUES
(1, 'classic'),
(2, 'special'),
(3, 'calzone'),
(4, 'sodas');

-- --------------------------------------------------------

--
-- Stand-in structure for view `classic`
-- (See below for the actual view)
--
CREATE TABLE `classic` (
`ID` int(11)
,`name` varchar(32)
,`price` decimal(10,2)
,`id_category` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `ID` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`ID`, `name`, `description`, `price`, `id_category`) VALUES
(1, 'Spianata', 'Oil, Rosemary', '3.00', 1),
(2, 'Marinara', 'Tomato, Garlic, Oregano, Oil', '4.00', 1),
(3, 'Red', 'Tomato, Basil', '4.00', 1),
(4, 'Margherita', 'Tomato, Fior Di Latte, Basil', '4.50', 1),
(5, 'Americana', 'Tomato, Fior Di Latte, Fries, Wurstel', '5.50', 1),
(6, 'Sausage', 'Tomato, Fior Di Latte, Salsiccia', '5.50', 1),
(7, 'Diavola', 'Tomato, Fior Di Latte, Spicy Salami, Black Olives', '6.50', 1),
(8, '4 Seasons', 'Tomato, Fior Di Latte, Cooked Ham, Mushrooms, Artichokes, Sausage', '7.00', 1),
(9, 'Calzone Fungaiolo', 'Tomato, Fior Di Latte, Funghi', '8.00', 3),
(10, 'Calzone Napoletano', 'Tomato, Fior Di Latte, Cooked Ham', '8.00', 3),
(11, 'Calzone \"Lightweight\"', 'Outdoor Margherita, Stuffed With Tomato, Fior Di Latte, Spicy Salami, Cooked Ham, Mushrooms', '10.00', 3),
(12, 'Explosion', 'Tomato, Fior Di Latte, Spicy Salami, Sausage, Mushrooms, Onion, Truffle Oil', '7.50', 2),
(13, 'Contadina', 'Tomato, Fior Di Latte, Sausage, Mushrooms, Onion', '6.80', 2),
(14, 'Gustosa', 'Tomato, Fior Di Latte, Bresaola, Rocket, Parmesan', '7.00', 2),
(15, 'Vivace', 'Tomato, Fior Di Latte, Raw Ham, Flakes Of Parmesan, Rocket', '7.00', 2),
(16, 'Natural Water 1L', NULL, '2.00', 4),
(18, 'Coca Cola Can 250ml', NULL, '2.50', 4),
(62, 'Sparkling Water 1L', NULL, '2.00', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ID` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ID`, `email`, `firstname`, `lastname`, `time`) VALUES
(1, 'asdf@gmail.com', 'asdf', 'asdf', '2018-10-14'),
(4, 'kavya@gmail.com', 'Kavya', 'Hathwar', '2018-10-14');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `email` varchar(128) NOT NULL,
  `card_number` char(16) DEFAULT NULL,
  `expiry_date` char(5) DEFAULT NULL,
  `cvv` char(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`email`, `card_number`, `expiry_date`, `cvv`) VALUES
('asdf@gmail.com', '0123012301230122', '06/20', '987'),
('example@example.com', NULL, NULL, NULL),
('kavya@gmail.com', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `sodas`
-- (See below for the actual view)
--
CREATE TABLE `sodas` (
`ID` int(11)
,`name` varchar(32)
,`price` decimal(10,2)
,`id_category` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `special`
-- (See below for the actual view)
--
CREATE TABLE `special` (
`ID` int(11)
,`name` varchar(32)
,`price` decimal(10,2)
,`id_category` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(128) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `address` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `firstname`, `lastname`, `password`, `address`) VALUES
('asdf@gmail.com', 'asdf', 'asdf', 'Password@1', ''),
('example@example.com', 'example', 'example', 'Example@1', ''),
('kavya@gmail.com', 'Kavya', 'Hathwar', 'Kavya@11', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_notification`
--

CREATE TABLE `user_notification` (
  `ID` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `type` int(11) NOT NULL,
  `description` varchar(512) NOT NULL,
  `time_stamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `new` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `calzone`
--
DROP TABLE IF EXISTS `calzone`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `calzone`  AS  select `menu`.`ID` AS `ID`,`menu`.`name` AS `name`,`menu`.`price` AS `price`,`menu`.`id_category` AS `id_category` from `menu` where (`menu`.`id_category` = 3) ;

-- --------------------------------------------------------

--
-- Structure for view `classic`
--
DROP TABLE IF EXISTS `classic`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `classic`  AS  select `menu`.`ID` AS `ID`,`menu`.`name` AS `name`,`menu`.`price` AS `price`,`menu`.`id_category` AS `id_category` from `menu` where (`menu`.`id_category` = 1) ;

-- --------------------------------------------------------

--
-- Structure for view `sodas`
--
DROP TABLE IF EXISTS `sodas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sodas`  AS  select `menu`.`ID` AS `ID`,`menu`.`name` AS `name`,`menu`.`price` AS `price`,`menu`.`id_category` AS `id_category` from `menu` where (`menu`.`id_category` = 4) ;

-- --------------------------------------------------------

--
-- Structure for view `special`
--
DROP TABLE IF EXISTS `special`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `special`  AS  select `menu`.`ID` AS `ID`,`menu`.`name` AS `name`,`menu`.`price` AS `price`,`menu`.`id_category` AS `id_category` from `menu` where (`menu`.`id_category` = 2) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `admin_notification`
--
ALTER TABLE `admin_notification`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD KEY `FK_email_cart` (`email`),
  ADD KEY `FK_id_item_menu` (`id_object`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `id_category` (`id_category`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`,`time`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `user_notification`
--
ALTER TABLE `user_notification`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_notification`
--
ALTER TABLE `admin_notification`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_notification`
--
ALTER TABLE `user_notification`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_notification`
--
ALTER TABLE `admin_notification`
  ADD CONSTRAINT `notifiche_admin_ibfk_1` FOREIGN KEY (`email`) REFERENCES `admin` (`email`);

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `FK_email_cart` FOREIGN KEY (`email`) REFERENCES `users` (`email`),
  ADD CONSTRAINT `FK_id_item_menu` FOREIGN KEY (`id_object`) REFERENCES `menu` (`ID`);

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`ID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `ordini_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `pagamento_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`);

--
-- Constraints for table `user_notification`
--
ALTER TABLE `user_notification`
  ADD CONSTRAINT `notifiche_utente_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
