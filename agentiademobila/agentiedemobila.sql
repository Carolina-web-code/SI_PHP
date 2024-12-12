-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 05 2024 г., 10:43
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `agentiedemobila`
--

-- --------------------------------------------------------

--
-- Структура таблицы `clienti`
--

CREATE TABLE `clienti` (
  `Id_client` int(11) NOT NULL,
  `Nume` varchar(50) NOT NULL,
  `Prenume` varchar(50) NOT NULL,
  `Telefon` varchar(20) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Adresa` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `clienti`
--

INSERT INTO `clienti` (`Id_client`, `Nume`, `Prenume`, `Telefon`, `Email`, `Adresa`) VALUES
(1, 'Popescu', 'Ion', '0745123456', 'ion.popescu@email.com', 'Strada Principala, Nr. 10, București'),
(2, 'Ionescu', 'Maria', '0745987654', 'maria.ionescu@email.com', 'Bd. Libertatii, Nr. 5, Timișoara'),
(3, 'Georgescu', 'Andrei', '0745001234', 'andrei.georgescu@email.com', 'Calea Victoriei, Nr. 100, București'),
(4, 'Dumitrescu', 'Elena', '0745123000', 'elena.dumitrescu@email.com', 'Str. Unirii, Nr. 7, Cluj-Napoca'),
(5, 'Radu', 'Mihai', '0745123499', 'mihai.radu@email.com', 'Bd. Eroilor, Nr. 12, Brașov'),
(6, 'Marin', 'Ana', '0745987000', 'ana.marin@email.com', 'Str. Mihai Viteazu, Nr. 8, Constanța'),
(7, 'Stoica', 'Cristina', '0745896321', 'cristina.stoica@email.com', 'Str. Trandafirilor, Nr. 15, Iași'),
(8, 'Vasilescu', 'Paul', '0745123876', 'paul.vasilescu@email.com', 'Str. Libertății, Nr. 20, Craiova'),
(9, 'Enache', 'Laura', '0745123344', 'laura.enache@email.com', 'Str. Independenței, Nr. 9, Ploiești'),
(10, 'Nistor', 'Roxana', '0745333222', 'roxana.nistor@email.com', 'Str. Avram Iancu, Nr. 11, Sibiu');

-- --------------------------------------------------------

--
-- Структура таблицы `comenzi`
--

CREATE TABLE `comenzi` (
  `Id_comanda` int(11) NOT NULL,
  `Data_comanda` date NOT NULL,
  `Id_client` int(11) NOT NULL,
  `Id_mobila` int(11) NOT NULL,
  `Cantitate` int(11) NOT NULL,
  `Pret_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `comenzi`
--

INSERT INTO `comenzi` (`Id_comanda`, `Data_comanda`, `Id_client`, `Id_mobila`, `Cantitate`, `Pret_total`) VALUES
(1, '2024-11-01', 1, 2, 1, 1500.00),
(2, '2024-11-02', 3, 4, 2, 3000.00),
(3, '2024-11-03', 2, 5, 1, 750.00),
(4, '2024-11-04', 5, 6, 3, 4500.00),
(5, '2024-11-05', 6, 3, 2, 2500.00),
(6, '2024-11-06', 4, 7, 1, 1800.00),
(7, '2024-11-07', 7, 8, 4, 6000.00),
(8, '2024-11-08', 8, 1, 1, 1500.00),
(9, '2024-11-09', 9, 2, 2, 3000.00),
(10, '2024-11-10', 10, 5, 1, 1000.00);

-- --------------------------------------------------------

--
-- Структура таблицы `furnizori`
--

CREATE TABLE `furnizori` (
  `Id_furnizor` int(11) NOT NULL,
  `Nume_furnizor` varchar(50) NOT NULL,
  `Telefon` varchar(20) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Adresa` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `furnizori`
--

INSERT INTO `furnizori` (`Id_furnizor`, `Nume_furnizor`, `Telefon`, `Email`, `Adresa`) VALUES
(1, 'MobilaLux', '0740123456', 'contact@mobilalux.com', 'Strada Muncii 23, Chișinău'),
(2, 'CasaDecor', '0740987654', 'info@casadecor.md', 'Bulevardul Independenței 45, Chișinău'),
(3, 'MobilierSRL', '0740567890', 'office@mobilier.com', 'Strada Florilor 10, Chișinău'),
(4, 'StyleHome', '0740654321', 'sales@stylehome.md', 'Strada Primăverii 15, Bălți'),
(5, 'LuxuryInteriors', '0740765432', 'luxury@interiors.com', 'Bulevardul Victoriei 78, Cahul'),
(6, 'EcoFurnish', '0740345678', 'eco@furnish.md', 'Strada Verde 5, Orhei'),
(7, 'ModernLine', '0740432109', 'support@modernline.md', 'Strada Constructorilor 12, Soroca'),
(8, 'WoodDesign', '0740234567', 'contact@wooddesign.com', 'Strada Pădurii 88, Edineț'),
(9, 'ClassicTouch', '0740789123', 'classic@touch.md', 'Strada Unirii 66, Hâncești'),
(10, 'UrbanSpaces', '0740876543', 'urban@spaces.com', 'Bulevardul Industrial 33, Comrat');

-- --------------------------------------------------------

--
-- Структура таблицы `mobila`
--

CREATE TABLE `mobila` (
  `Id_mobila` int(11) NOT NULL,
  `Material` varchar(20) NOT NULL,
  `Culoare` varchar(15) NOT NULL,
  `Dimensiuni` varchar(15) NOT NULL,
  `Pret` decimal(10,2) NOT NULL,
  `furnizor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `mobila`
--

INSERT INTO `mobila` (`Id_mobila`, `Material`, `Culoare`, `Dimensiuni`, `Pret`, `furnizor_id`) VALUES
(1, 'Piele', 'Negru', '200x100x90', 1500.00, 1),
(2, 'Lemn', 'Maro', '180x80x75', 850.00, 2),
(3, 'Metal', 'Gri', '150x60x90', 1200.00, 3),
(4, 'Plastic', 'Alb', '120x60x40', 300.00, 4),
(5, 'Sticlă', 'Transparent', '100x100x50', 700.00, 5),
(6, 'Textil', 'Bej', '220x90x80', 1100.00, 6),
(7, 'Lemn masiv', 'Wenge', '240x100x75', 1700.00, 7),
(8, 'Compozit', 'Albastru', '80x80x40', 450.00, 8),
(9, 'Lemn și metal', 'Verde', '180x90x90', 1300.00, 9),
(10, 'Ratan', 'Natural', '200x80x70', 600.00, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `recenzii`
--

CREATE TABLE `recenzii` (
  `Id_recenzie` int(11) NOT NULL,
  `Id_mobila` int(11) NOT NULL,
  `Id_client` int(11) NOT NULL,
  `Rating` tinyint(4) DEFAULT NULL CHECK (`Rating` between 1 and 5),
  `Comentariu` varchar(255) DEFAULT NULL,
  `Data_recenzie` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `recenzii`
--

INSERT INTO `recenzii` (`Id_recenzie`, `Id_mobila`, `Id_client`, `Rating`, `Comentariu`, `Data_recenzie`) VALUES
(1, 1, 1, 5, 'Foarte confortabil și de calitate superioară!', '2024-01-15'),
(2, 2, 3, 4, 'Design modern, dar culoarea nu este exact ce am așteptat.', '2024-02-20'),
(3, 3, 5, 5, 'Material durabil și bine construit.', '2024-03-10'),
(4, 4, 2, 3, 'Livrare întârziată, dar produsul este bun.', '2024-04-18'),
(5, 5, 4, 4, 'Foarte mulțumit de achiziție!', '2024-05-22'),
(6, 1, 6, 5, 'Servicii excelente și mobilier foarte confortabil.', '2024-06-14'),
(7, 2, 7, 2, 'Produsul nu a corespuns descrierii din catalog.', '2024-07-01'),
(8, 3, 8, 4, 'Frumos, dar montajul a fost dificil.', '2024-07-25'),
(9, 4, 9, 5, 'Calitate excelentă și preț rezonabil.', '2024-08-30'),
(10, 5, 10, 3, 'Designul este minunat, dar cam scump.', '2024-09-12');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `clienti`
--
ALTER TABLE `clienti`
  ADD PRIMARY KEY (`Id_client`),
  ADD UNIQUE KEY `Telefon` (`Telefon`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Индексы таблицы `comenzi`
--
ALTER TABLE `comenzi`
  ADD PRIMARY KEY (`Id_comanda`),
  ADD KEY `Id_client` (`Id_client`),
  ADD KEY `Id_mobila` (`Id_mobila`);

--
-- Индексы таблицы `furnizori`
--
ALTER TABLE `furnizori`
  ADD PRIMARY KEY (`Id_furnizor`);

--
-- Индексы таблицы `mobila`
--
ALTER TABLE `mobila`
  ADD PRIMARY KEY (`Id_mobila`),
  ADD KEY `fk_furnizor` (`furnizor_id`);

--
-- Индексы таблицы `recenzii`
--
ALTER TABLE `recenzii`
  ADD PRIMARY KEY (`Id_recenzie`),
  ADD KEY `Id_mobila` (`Id_mobila`),
  ADD KEY `Id_client` (`Id_client`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `clienti`
--
ALTER TABLE `clienti`
  MODIFY `Id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `comenzi`
--
ALTER TABLE `comenzi`
  MODIFY `Id_comanda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `furnizori`
--
ALTER TABLE `furnizori`
  MODIFY `Id_furnizor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `mobila`
--
ALTER TABLE `mobila`
  MODIFY `Id_mobila` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `recenzii`
--
ALTER TABLE `recenzii`
  MODIFY `Id_recenzie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comenzi`
--
ALTER TABLE `comenzi`
  ADD CONSTRAINT `comenzi_ibfk_1` FOREIGN KEY (`Id_client`) REFERENCES `clienti` (`Id_client`),
  ADD CONSTRAINT `comenzi_ibfk_2` FOREIGN KEY (`Id_mobila`) REFERENCES `mobila` (`Id_mobila`);

--
-- Ограничения внешнего ключа таблицы `mobila`
--
ALTER TABLE `mobila`
  ADD CONSTRAINT `fk_furnizor` FOREIGN KEY (`furnizor_id`) REFERENCES `furnizori` (`Id_furnizor`);

--
-- Ограничения внешнего ключа таблицы `recenzii`
--
ALTER TABLE `recenzii`
  ADD CONSTRAINT `recenzii_ibfk_1` FOREIGN KEY (`Id_mobila`) REFERENCES `mobila` (`Id_mobila`),
  ADD CONSTRAINT `recenzii_ibfk_2` FOREIGN KEY (`Id_client`) REFERENCES `clienti` (`Id_client`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
