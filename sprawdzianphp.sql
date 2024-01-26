-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 26, 2024 at 11:43 AM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sprawdzianphp`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sprawdzian`
--

CREATE TABLE `sprawdzian` (
  `ID` int(11) NOT NULL,
  `Liczba` int(11) NOT NULL,
  `Nazwa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sprawdzian`
--

INSERT INTO `sprawdzian` (`ID`, `Liczba`, `Nazwa`) VALUES
(1, 1, 'Monday'),
(2, 24, 'Tuesday'),
(3, 7, 'Wednesday'),
(4, 1, 'Thursday'),
(5, 22, 'Friday'),
(6, 15, 'Saturday'),
(8, 14, 'Sunday');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `sprawdzian`
--
ALTER TABLE `sprawdzian`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sprawdzian`
--
ALTER TABLE `sprawdzian`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
