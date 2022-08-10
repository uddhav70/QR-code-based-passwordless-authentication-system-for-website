-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2018 at 12:09 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qrlogin`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `userid` int(11) NOT NULL,
  `type` varchar(250) NOT NULL,
  `size` varchar(250) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `name`, `userid`, `type`, `size`, `content`) VALUES
(22, 'fastboot.txt', 25, 'text/plain', '139', 'HyhZJZUxtRJxxJu+WyxyMg==_JjjCPsMpV24YY1qTP4J3dwz+Y/H/YDrylHx1hSMhMaC5AX1YP3JFXyPlL/eFFb/jlbo36LSWCYsuYzqJ3z3ltrqLt8ELJMri5emiNTNbi+ehzn8rGQ723P4kY7BQ9QYyRpOXzti6RfNTS99jqYSQp31jp8qSrlel7pV+GHfOVtYNmQi6w90ZkpI7lC+KQnwB'),
(23, 'fastboot.txt', 26, 'text/plain', '139', 'YaObWqbLDAXsC0IaHejl4w==_rzUgYhCmDM3JasxyYR2oqcmXdZaem8fWOq9tWQmJMka4ekSKfaXfyI1VIOmyw7luOMFbIx1vGjHNPOOmAEglXBlbPing4pgklnZza2dC/sU6zwiQcV2DGrXoLTlS570AUEl3QDQOFIlsHJAHtAQEyU4nBKfruXDUGjM9SlFZ6ghOmNQaBbnShygBzhVZYxs9'),
(24, 'fastboot.txt', 27, 'text/plain', '139', 'W1rbF4de6tGK6CQ17KDRqg==_BiOleLCQoKB6eLlttMsld6OnvDtT3p1sD+zFSk8U2SULsI+L0VXnONmoTA8EhDhBurKKcq+xsHVDtw/H6TtnTDipXeAXhEV8sM3ZKx/0k1RwAYlk/fWOWh4AJ7g8EmP4lGCNJDqPl7TUr0CqYj/lpjZETrhb/P2YXIhmpa76OWmMV2q2TC/mYKUGEFZ7koCB');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `unique_key` varchar(250) NOT NULL,
  `mobile` bigint(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `unique_key`, `mobile`) VALUES
(30, 'sandeep', 'varma', 'sandeep', 'abcd', 0),
(31, 'sandeep', 'varma', 's@gmail.com', 'sfhsdfsdfsdf54654654', 8976263864);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
