-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 07 Oca 2024, 22:04:12
-- Sunucu sürümü: 8.0.31
-- PHP Sürümü: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `project_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci,
  `avatar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci,
  `last_login` int NOT NULL DEFAULT '-1',
  `session_id` text COLLATE utf8mb4_turkish_ci,
  `theme_mode` int NOT NULL DEFAULT '0',
  `total_input` int NOT NULL DEFAULT '0',
  `total_output` int NOT NULL DEFAULT '0',
  `admin_level` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo için tablo yapısı `garage`
--

DROP TABLE IF EXISTS `garage`;
CREATE TABLE IF NOT EXISTS `garage` (
  `id` int NOT NULL AUTO_INCREMENT,
  `brand` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `model` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `plate` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `owner` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `end_time` int NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo için tablo yapısı `management`
--

DROP TABLE IF EXISTS `management`;
CREATE TABLE IF NOT EXISTS `management` (
  `add_vehicle` int NOT NULL DEFAULT '1',
  `create_account` int NOT NULL DEFAULT '1',
  `total_cash` int NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `management`
--

INSERT INTO `management` (`add_vehicle`, `create_account`, `total_cash`) VALUES
(1, 1, 200);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
