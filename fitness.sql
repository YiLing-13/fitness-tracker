-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-12-31 14:51:48
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `fitness`
--

-- --------------------------------------------------------

--
-- 資料表結構 `food_records`
--

CREATE TABLE `food_records` (
  `id` bigint(20) NOT NULL,
  `account` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `fooditem` varchar(255) DEFAULT NULL,
  `hour` int(11) DEFAULT NULL,
  `min` int(11) DEFAULT NULL,
  `sugar` float DEFAULT NULL,
  `na` float DEFAULT NULL,
  `kal` int(11) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `food_records`
--

INSERT INTO `food_records` (`id`, `account`, `date`, `fooditem`, `hour`, `min`, `sugar`, `na`, `kal`, `img`) VALUES
(1766476978354, '123', '2025-12-23', '珍奶', 10, 0, 50, 0, 500, 'uploads/1766476978_bubbletea-color.png'),
(1766726292207, '12345678', '2025-12-26', '1', 1, 10, 1, 1, 1, 'uploads/1766726292_bubbletea-02.png'),
(1766726537339, '123', '2025-12-26', '珍奶', 10, 0, 50, 0, 500, 'uploads/1766726537_珍奶.jpg'),
(1766726554154, '123', '2025-12-26', '蔬菜', 10, 0, 0, 10, 100, 'uploads/1766726554_青菜.jpg'),
(1767077372772, '123', '2025-12-30', '珍奶', 12, 0, 20, 0, 500, 'uploads/1767077372_珍奶.jpg'),
(1767078464511, '123', '2025-12-30', '蔬菜', 12, 0, 0, 100, 100, 'uploads/1767078464_青菜.jpg'),
(1767078543680, '123', '2025-12-30', '餅乾', 13, 0, 0, 500, 300, 'uploads/1767078543_洋芋片.jpg');

-- --------------------------------------------------------

--
-- 資料表結構 `sport_records`
--

CREATE TABLE `sport_records` (
  `id` bigint(20) NOT NULL,
  `account` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `sport_type` enum('weight','cardio') NOT NULL,
  `total_hour` int(11) DEFAULT 0,
  `total_min` int(11) DEFAULT 0,
  `total_kcal` int(11) DEFAULT 0,
  `sport_items` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `sport_records`
--

INSERT INTO `sport_records` (`id`, `account`, `date`, `sport_type`, `total_hour`, `total_min`, `total_kcal`, `sport_items`, `created_at`) VALUES
(1766477033883, '123', '2025-12-23', 'weight', 1, 0, 200, '[{\"item\":\"二頭\",\"set\":\"10下一組\"},{\"item\":\"腿推\",\"set\":\"10下一組\"},{\"item\":\"三頭\",\"set\":\"10下一組\"},{\"item\":\"小腿\",\"set\":\"10下一組\"},{\"item\":\"引體向上\",\"set\":\"10下一組\"},{\"item\":\"蝴蝶機\",\"set\":\"10下一組\"}]', '2025-12-23 08:03:53'),
(1766477045707, '123', '2025-12-23', 'cardio', 1, 0, 200, '[{\"item\":\"跑步\",\"set\":\"\"}]', '2025-12-23 08:04:05'),
(1766726305222, '12345678', '2025-12-26', 'weight', 1, 0, 100, '[{\"item\":\"1\",\"set\":\"1\"},{\"item\":\"1\",\"set\":\"1\"},{\"item\":\"1\",\"set\":\"1\"}]', '2025-12-26 05:18:25'),
(1766726642950, '123', '2025-12-26', 'weight', 1, 0, 200, '[{\"item\":\"二頭\",\"set\":\"10下\\/1組\"},{\"item\":\"腿推\",\"set\":\"10下\\/1組\"},{\"item\":\"三頭\",\"set\":\"10下\\/1組\"},{\"item\":\"蝴蝶機\",\"set\":\"10下\\/1組\"},{\"item\":\"引體向上\",\"set\":\"10下\\/1組\"}]', '2025-12-26 05:24:02'),
(1766726655093, '123', '2025-12-26', 'cardio', 1, 0, 100, '[{\"item\":\"跑步\",\"set\":\"\"}]', '2025-12-26 05:24:15'),
(1766996212189, '123', '2025-12-29', 'weight', 1, 0, 100, '[{\"item\":\"二頭\",\"set\":\"10下\"},{\"item\":\"腿推\",\"set\":\"10下\"},{\"item\":\"三頭\",\"set\":\"10下\"}]', '2025-12-29 08:16:52'),
(1766996231277, '123', '2025-12-29', 'cardio', 1, 0, 100, '[{\"item\":\"跑步\",\"set\":\"\"}]', '2025-12-29 08:17:11'),
(1767079646053, '123', '2025-12-30', 'weight', 1, 0, 300, '[{\"item\":\"二頭肌\",\"set\":\"10下\\/1組\"},{\"item\":\"腿推\",\"set\":\"10下\\/1組\"},{\"item\":\"三頭肌\",\"set\":\"10下\\/1組\"},{\"item\":\"蝴蝶機\",\"set\":\"10下\\/1組\"},{\"item\":\"引體向上\",\"set\":\"10下\\/1組\"}]', '2025-12-30 07:27:26'),
(1767079689486, '123', '2025-12-30', 'cardio', 1, 0, 200, '[{\"item\":\"跑步\",\"set\":\"30分鐘\"},{\"item\":\"腳踏車\",\"set\":\"30分鐘\"}]', '2025-12-30 07:28:09');

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `account` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `gender` enum('male','female') NOT NULL,
  `age` int(11) NOT NULL,
  `height` float NOT NULL,
  `weight` float NOT NULL,
  `activity_level` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `account`, `password`, `nickname`, `gender`, `age`, `height`, `weight`, `activity_level`, `created_at`) VALUES
(1, '123', '$2y$10$iTYqPxP0KcAylN4Rx7vVvOrncJQGd5RN39TNEiNqhH3k3ny42jOzK', 'Ken', 'male', 20, 188, 62, '1.55', '2025-12-23 11:09:26'),
(2, '456', '$2y$10$xUEh6NVDPL2Fp1llJ9VGnuE68uYCvqAysPVLOq7mowkDBVUEfRpMS', '456', 'male', 50, 160, 55, '1.375', '2025-12-26 13:12:38'),
(3, '12345678', '$2y$10$a/2BUWGlrZDorp6h7gCoyu2iFsoqZyX1dIxnH2vn913PHAXLGnQfW', 'test', 'male', 30, 170, 70, '1.375', '2025-12-26 13:17:48'),
(4, '11111', '$2y$10$9qyAKIgDSAGJQwSAZ.Je.Olaftf2qCUidF8HY4G.2sHv8phozCopO', '11', 'male', 20, 180, 70, '1.55', '2025-12-29 16:14:53');

-- --------------------------------------------------------

--
-- 資料表結構 `water_records`
--

CREATE TABLE `water_records` (
  `id` bigint(20) NOT NULL,
  `account` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `water` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `water_records`
--

INSERT INTO `water_records` (`id`, `account`, `date`, `water`) VALUES
(1766476961988, '123', '2025-12-23', 500),
(1766726295318, '12345678', '2025-12-26', 100),
(1766726525557, '123', '2025-12-26', 500),
(1767077333238, '123', '2025-12-30', 400),
(1767077337198, '123', '2025-12-30', 200),
(1767077342638, '123', '2025-12-30', 300);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `food_records`
--
ALTER TABLE `food_records`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `sport_records`
--
ALTER TABLE `sport_records`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account` (`account`);

--
-- 資料表索引 `water_records`
--
ALTER TABLE `water_records`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
