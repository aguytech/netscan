-- phpMyAdmin SQL Dump
-- Server version: 5.6.46-log
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


-- --------------------------------------------------------

--
-- Table structure for table `netscan_presence`
--

CREATE TABLE `netscan_presence` (
  `id` int(10) UNSIGNED NOT NULL,
  `ts` timestamp NOT NULL COMMENT 'timestamp to identify  group of insertion',
  `ipv4` char(15) COLLATE utf8_bin DEFAULT NULL,
  `ipv6` char(45) COLLATE utf8_bin DEFAULT NULL,
  `mac` char(18) COLLATE utf8_bin DEFAULT NULL COMMENT 'mac address',
  `interface` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'network interface manufacturer',
  `hostname` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'computer hostname'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `netscan_computer`
--

CREATE TABLE `netscan_computer` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_member` int(10) UNSIGNED NOT NULL,
  `mac` varchar(18) COLLATE utf8_bin NOT NULL,
  `hostname` varchar(100) CHARACTER SET utf8 NOT NULL,
  `type` set('desktop','laptop','mobile') CHARACTER SET utf8 NOT NULL DEFAULT 'laptop',
  `network` set('wired','wireless') CHARACTER SET utf8 NOT NULL DEFAULT 'wireless'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `netscan_member`
--

CREATE TABLE `netscan_member` (
  `id` int(10) UNSIGNED NOT NULL,
  `registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `firstname` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `publicname` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `login` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `url` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `netscan_presence`
--
ALTER TABLE `netscan_presence`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ts` (`ts`,`mac`,`hostname`) USING BTREE;

--
-- Indexes for table `netscan_computer`
--
ALTER TABLE `netscan_computer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_member` (`id_member`,`mac`);

--
-- Indexes for table `netscan_member`
--
ALTER TABLE `netscan_member`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `netscan_presence`
--
ALTER TABLE `netscan_presence`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `netscan_computer`
--
ALTER TABLE `netscan_computer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `netscan_member`
--
ALTER TABLE `netscan_member`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `netscan_computer`
--
ALTER TABLE `netscan_computer`
  ADD CONSTRAINT `id_member_ID` FOREIGN KEY (`id_member`) REFERENCES `netscan_member` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
