-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 04 Gru 2019, 19:01
-- Wersja serwera: 10.1.36-MariaDB
-- Wersja PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `kadry`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `daneosobowe`
--

CREATE TABLE `daneosobowe` (
  `ID` int(3) NOT NULL,
  `UID` int(11) NOT NULL,
  `imie` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `data_ur` date NOT NULL,
  `plec` varchar(1) COLLATE utf8_polish_ci NOT NULL,
  `tel` varchar(9) COLLATE utf8_polish_ci NOT NULL,
  `miasto` varchar(80) COLLATE utf8_polish_ci NOT NULL,
  `adres` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `poczta` varchar(80) COLLATE utf8_polish_ci NOT NULL,
  `kod_pocztowy` varchar(6) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `daneosobowe`
--

INSERT INTO `daneosobowe` (`ID`, `UID`, `imie`, `nazwisko`, `data_ur`, `plec`, `tel`, `miasto`, `adres`, `poczta`, `kod_pocztowy`) VALUES
(1, 1, 'Mateusz', 'Wróblewski', '1998-06-03', 'm', '486295714', 'Wrocław', 'Chodnikowa 12', 'Wrocław', '32-123'),
(2, 2, 'Jan', 'Kowalski', '1999-11-08', 'm', '617498221', 'Poznań', 'Kotłowska 12/5', 'Poznań', '42-989'),
(3, 3, 'Joanna', 'Gruszka', '1994-12-12', 'k', '514826355', 'Wrocław', 'Płowiecka 17', 'Wrocław', '21-300'),
(4, 4, 'Wojciech', 'Zagórski', '1999-05-05', 'm', '598847231', 'Kraków', 'Lwowska 23/5', 'Kraków', '40-550'),
(5, 5, 'Zygmunt', 'Walec', '1994-02-14', 'm', '741158423', 'Warszawa', 'Spokojna 7', 'Warszawa', '12-625'),
(6, 6, 'Zofia', 'Król', '1992-01-09', 'k', '725698454', 'Bydgoszcz', '1000-Lecia 3/7', 'Bydgoszcz', '35-200'),
(7, 7, 'Izabela', 'Kisiel', '1989-09-08', 'k', '551278848', 'Rzeszów', 'Mickiewicza 2', 'Rzeszów', '38-612'),
(8, 8, 'Bartosz', 'Matuszewski', '1999-07-29', 'm', '459712244', 'Gdańsk', 'Śniegowa 32', 'Gdańsk', '56-555'),
(9, 9, 'Jakub', 'Kowalski', '2000-04-12', 'm', '546448135', 'Warszawa', 'Wesoła 12/4', 'Warszawa', '12-767'),
(10, 10, 'Martyna', 'Pietrzak', '1991-11-17', 'm', '824598743', 'Kraków', 'Kochanowskiego 14', 'Kraków', '25-112'),
(11, 11, 'Zuzanna', 'Świder', '2001-01-03', 'm', '695518427', 'Wrocław', 'Zielona 5/13', 'Wrocław', '23-332'),
(12, 12, 'Hubert', 'Wawrzyniak', '1997-09-15', 'm', '684215687', 'Wrocław', 'Malinowa 26', 'Wrocław', '23-423'),
(13, 13, 'Igor', 'Kamiński', '1999-03-16', 'm', '654872159', 'Radom', 'Jana Pawła 12', 'Radom', '32-543'),
(14, 14, 'Oliwia', 'Nowak', '2000-08-12', 'k', '584692174', 'Wrocław', 'Stróżowska 18', 'Wrocław', '41-291');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dzialy`
--

CREATE TABLE `dzialy` (
  `ID` int(3) NOT NULL,
  `nazwa` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `dzialy`
--

INSERT INTO `dzialy` (`ID`, `nazwa`) VALUES
(1, 'Administracja'),
(2, 'Marketing'),
(3, 'Informatycy');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenia`
--

CREATE TABLE `ogloszenia` (
  `ID` int(3) NOT NULL,
  `ID_stanowiska` int(3) NOT NULL,
  `opis` longtext COLLATE utf8_polish_ci NOT NULL,
  `wymagania` mediumtext COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `ogloszenia`
--

INSERT INTO `ogloszenia` (`ID`, `ID_stanowiska`, `opis`, `wymagania`) VALUES
(1, 2, 'Poszukujemy osób chętnych do pracy na stanowisku twórcy reklam.\r\nOferujemy posadę w prężnie rozwijającej się firmie. Twoim zadaniem będzie przygotowanie i opracowywanie kampanii reklamowych. Jeżeli uważasz się za osobę kreatywną - z pewnością jesteś kandydatem/kandydatką na to stanowisko!', 'Ukończony odpowiedni kierunek na studiach; Minimum 2-letnie doświadczenie w zawodzie; Umiejętność pracy w grupie; Duża kreatywność'),
(2, 8, 'Znasz się na sprzęcie komputerowym? Potrafisz naprawić drobną usterkę lub przeinstalować system operacyjny? W takim razie jest to oferta dla ciebie!\r\nPoszukujemy technika komputerowego do naszej firmy. Jeżeli nie boisz się wyzwań zgłoś się do nas.', 'Ukończenie kursu / szkolenia zawodowego / studiów na kierunku związanym z urządzeniami techniki komputerowej; Doświadczenie serwisowe');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `podania`
--

CREATE TABLE `podania` (
  `ID` int(3) NOT NULL,
  `UID` int(3) NOT NULL,
  `oferta` int(3) NOT NULL,
  `zaakceptowane` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `podania`
--

INSERT INTO `podania` (`ID`, `UID`, `oferta`, `zaakceptowane`) VALUES
(1, 13, 1, 1),
(2, 14, 2, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `ID` int(3) NOT NULL,
  `UID` int(3) NOT NULL,
  `ID_stanowiska` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `pracownicy`
--

INSERT INTO `pracownicy` (`ID`, `UID`, `ID_stanowiska`) VALUES
(1, 2, 3),
(2, 8, 5),
(3, 6, 1),
(4, 7, 10),
(5, 3, 1),
(6, 9, 5),
(7, 4, 4),
(8, 10, 4),
(9, 5, 6),
(10, 11, 7),
(11, 12, 9),
(12, 13, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stanowiska`
--

CREATE TABLE `stanowiska` (
  `ID` int(3) NOT NULL,
  `ID_dzial` int(3) NOT NULL,
  `nazwa` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `stawka` float NOT NULL,
  `miejsca` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `stanowiska`
--

INSERT INTO `stanowiska` (`ID`, `ID_dzial`, `nazwa`, `stawka`, `miejsca`) VALUES
(1, 1, 'Księgowość', 2300.5, 2),
(2, 2, 'Twórcy reklam', 2000, 2),
(3, 3, 'Menedżer strony firmowej', 3200, 1),
(4, 1, 'Kadry', 2300, 2),
(5, 1, 'Dyrekcja', 4500, 2),
(6, 2, 'Analityk rynku', 2100, 1),
(7, 2, 'Socialmedia Manager', 2000, 1),
(8, 3, 'Technik firmowy', 2900, 1),
(9, 3, 'Grafik', 2000, 1),
(10, 2, 'PR Manager', 2300, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `UID` int(3) NOT NULL,
  `email` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`UID`, `email`, `haslo`, `admin`) VALUES
(1, 'mateusz@firma.pl', '$2y$10$nDSLBJXSqrpdsFgPkoRMuui/j7sENvNNABv6LAQuUaQkBJsEvH476', 1),
(2, 'jankow@wp.pl', NULL, 0),
(3, 'asiagruszka@interia.pl', NULL, 0),
(4, 'wojzag@gmail.com', NULL, 0),
(5, 'zygmuntw@onet.pl', NULL, 0),
(6, 'zofia.krol92@gmail.com', NULL, 0),
(7, 'izakis@poczta.orange.pl', NULL, 0),
(8, 'bartek1999@onet.pl', NULL, 0),
(9, 'kubuskowalski@wp.pl', NULL, 0),
(10, 'martyna.pietrzak@o2.pl', NULL, 0),
(11, 'zuzka2121@onet.pl', NULL, 0),
(12, 'hubwaw@gmail.com', NULL, 0),
(13, 'igorek@gmail.com', '$2y$10$fA1t1ssI1RbJooOw1BKj0e//0iaW.wxgNrEr60KKcZA6QhENDrKwi', 0),
(14, 'oliwia.nowak@wp.pl', '$2y$10$1oXemDlzCBJ2dQGbjynJzeX6UCE3c1e.HYM9X9pzQsHpX29heCgX.', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `daneosobowe`
--
ALTER TABLE `daneosobowe`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UID` (`UID`);

--
-- Indeksy dla tabeli `dzialy`
--
ALTER TABLE `dzialy`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `ogloszenia`
--
ALTER TABLE `ogloszenia`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_stanowiska` (`ID_stanowiska`);

--
-- Indeksy dla tabeli `podania`
--
ALTER TABLE `podania`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UID` (`UID`),
  ADD KEY `oferta` (`oferta`);

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UID` (`UID`),
  ADD KEY `ID_stanowiska` (`ID_stanowiska`);

--
-- Indeksy dla tabeli `stanowiska`
--
ALTER TABLE `stanowiska`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID-dzial` (`ID_dzial`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`UID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `daneosobowe`
--
ALTER TABLE `daneosobowe`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `dzialy`
--
ALTER TABLE `dzialy`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `ogloszenia`
--
ALTER TABLE `ogloszenia`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `podania`
--
ALTER TABLE `podania`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `stanowiska`
--
ALTER TABLE `stanowiska`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `UID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
