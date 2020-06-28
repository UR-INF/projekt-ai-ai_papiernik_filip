-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 31 Maj 2020, 23:53
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `projekt`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ceny`
--

CREATE TABLE `ceny` (
  `id_ceny` int(11) NOT NULL,
  `waga` float NOT NULL,
  `typ` float NOT NULL,
  `ubezpieczenie` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `ceny`
--

INSERT INTO `ceny` (`id_ceny`, `waga`, `typ`, `ubezpieczenie`) VALUES
(1, 3, 100, 50);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `funkcja`
--

CREATE TABLE `funkcja` (
  `id_funkcja` int(11) NOT NULL,
  `funkcja` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `funkcja`
--

INSERT INTO `funkcja` (`id_funkcja`, `funkcja`) VALUES
(1, 'Pracownik'),
(2, 'Admin'),
(3, 'Klient'),
(4, 'Kurier');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `odbiorca`
--

CREATE TABLE `odbiorca` (
  `id_odbiorca` int(11) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `telefon` bigint(30) NOT NULL,
  `kraj` varchar(50) NOT NULL,
  `miasto` varchar(50) NOT NULL,
  `adres` varchar(50) NOT NULL,
  `pesel` bigint(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `odbiorca`
--

INSERT INTO `odbiorca` (`id_odbiorca`, `imie`, `nazwisko`, `telefon`, `kraj`, `miasto`, `adres`, `pesel`) VALUES
(8, 'Kacper', 'Kowalski', 604058911, 'Niemcy', 'Berlin', 'ul. Ber', 12345678910);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pojazdy`
--

CREATE TABLE `pojazdy` (
  `id_pojazd` int(11) NOT NULL,
  `marka` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `pojazdy`
--

INSERT INTO `pojazdy` (`id_pojazd`, `marka`, `model`) VALUES
(6, 'Tesla', 'Semi-truck'),
(12, 'Mercedes', '5X');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przesylka`
--

CREATE TABLE `przesylka` (
  `id_przesylka` int(11) NOT NULL,
  `id_odbiorca` int(11) NOT NULL,
  `id_klient` int(11) NOT NULL,
  `id_pojazd` int(11) NOT NULL,
  `nazwa_przesylki` varchar(50) NOT NULL,
  `waga` float NOT NULL,
  `typ_przesylki` varchar(50) NOT NULL,
  `ubezpieczenie` varchar(50) NOT NULL,
  `koszt` float NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `przesylka`
--

INSERT INTO `przesylka` (`id_przesylka`, `id_odbiorca`, `id_klient`, `id_pojazd`, `nazwa_przesylki`, `waga`, `typ_przesylki`, `ubezpieczenie`, `koszt`, `status`) VALUES
(59, 8, 48, 6, 'Kanapa', 15, 'Międzynarodowy', 'Tak', 195, 'Dostarczona');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownikinfo`
--

CREATE TABLE `uzytkownikinfo` (
  `id_uzytkownikinfo` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `haslo` varchar(30) NOT NULL,
  `imie` varchar(30) NOT NULL,
  `nazwisko` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `kraj` varchar(30) NOT NULL,
  `miasto` varchar(30) NOT NULL,
  `adres` varchar(30) NOT NULL,
  `id_funkcja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `uzytkownikinfo`
--

INSERT INTO `uzytkownikinfo` (`id_uzytkownikinfo`, `login`, `haslo`, `imie`, `nazwisko`, `email`, `kraj`, `miasto`, `adres`, `id_funkcja`) VALUES
(35, 'pracownik', 'pracownik', 'Filip', 'Papiernik', 'pracownik@pracownik.com', 'Polska', 'Rzeszów', 'ul. Pigonia', 1),
(36, 'admin', 'admin', 'Filip', 'Papiernik', 'admin@admin.com', 'Polska', 'Rzeszów', 'ul. Pigonia 1', 2),
(37, 'kurierr', 'kurierr', 'Filip', 'Papiernik', 'kurier@kurier.com', 'Polska', 'Rzeszów', 'ul. Pigonia 4', 4),
(48, 'klientt', 'klientt', 'Filip', 'Papiernik', 'filippapiernik1999@gmail.com', 'Polska', 'Rzeszow', 'ul. Pigonia 1', 3);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `ceny`
--
ALTER TABLE `ceny`
  ADD PRIMARY KEY (`id_ceny`);

--
-- Indeksy dla tabeli `funkcja`
--
ALTER TABLE `funkcja`
  ADD PRIMARY KEY (`id_funkcja`);

--
-- Indeksy dla tabeli `odbiorca`
--
ALTER TABLE `odbiorca`
  ADD PRIMARY KEY (`id_odbiorca`);

--
-- Indeksy dla tabeli `pojazdy`
--
ALTER TABLE `pojazdy`
  ADD PRIMARY KEY (`id_pojazd`);

--
-- Indeksy dla tabeli `przesylka`
--
ALTER TABLE `przesylka`
  ADD PRIMARY KEY (`id_przesylka`),
  ADD KEY `id` (`id_pojazd`,`id_odbiorca`,`id_klient`),
  ADD KEY `id_odbiorca` (`id_odbiorca`),
  ADD KEY `id_klient` (`id_klient`);

--
-- Indeksy dla tabeli `uzytkownikinfo`
--
ALTER TABLE `uzytkownikinfo`
  ADD PRIMARY KEY (`id_uzytkownikinfo`),
  ADD KEY `id_funkcja` (`id_funkcja`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `ceny`
--
ALTER TABLE `ceny`
  MODIFY `id_ceny` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `funkcja`
--
ALTER TABLE `funkcja`
  MODIFY `id_funkcja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `odbiorca`
--
ALTER TABLE `odbiorca`
  MODIFY `id_odbiorca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `pojazdy`
--
ALTER TABLE `pojazdy`
  MODIFY `id_pojazd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `przesylka`
--
ALTER TABLE `przesylka`
  MODIFY `id_przesylka` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT dla tabeli `uzytkownikinfo`
--
ALTER TABLE `uzytkownikinfo`
  MODIFY `id_uzytkownikinfo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `przesylka`
--
ALTER TABLE `przesylka`
  ADD CONSTRAINT `przesylka_ibfk_1` FOREIGN KEY (`id_pojazd`) REFERENCES `pojazdy` (`id_pojazd`),
  ADD CONSTRAINT `przesylka_ibfk_2` FOREIGN KEY (`id_odbiorca`) REFERENCES `odbiorca` (`id_odbiorca`),
  ADD CONSTRAINT `przesylka_ibfk_3` FOREIGN KEY (`id_klient`) REFERENCES `uzytkownikinfo` (`id_uzytkownikinfo`);

--
-- Ograniczenia dla tabeli `uzytkownikinfo`
--
ALTER TABLE `uzytkownikinfo`
  ADD CONSTRAINT `uzytkownikinfo_ibfk_1` FOREIGN KEY (`id_funkcja`) REFERENCES `funkcja` (`id_funkcja`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
