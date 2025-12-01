-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 01, 2025 at 08:22 PM
-- Server version: 10.11.6-MariaDB
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `serbian_language`
--

-- --------------------------------------------------------

--
-- Table structure for table `sentences`
--

CREATE TABLE `sentences` (
  `id` int(11) NOT NULL,
  `cyrillic` text NOT NULL,
  `latin` text NOT NULL,
  `russian` text NOT NULL,
  `audio_path` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `sentences`
--

INSERT INTO `sentences` (`id`, `cyrillic`, `latin`, `russian`, `audio_path`) VALUES
(52, 'Ја сам студент', 'Ja sam student', 'Я студент', '/uploads/audio/sentences/Ja_sam_student.mp3'),
(53, 'Зовем се Тамара', 'Zovem se Tamara', 'Меня зовут Тамара', '/uploads/audio/sentences/Zovem_se_Tamara.mp3'),
(54, 'Ја се зовем Марија', 'Ja se zovem Marija', 'Меня зовут Мария', '/uploads/audio/sentences/Ja_se_zovem_Marija.mp3'),
(55, 'Ја сам професор', 'Ja sam profesor', 'Я профессор', '/uploads/audio/sentences/Ja_sam_profesor.mp3'),
(56, 'Ти си Милан', 'Ti si Milan', 'Ты Милан', '/uploads/audio/sentences/Ti_si_Milan.mp3'),
(57, 'Зовеш се Ђорђе', 'Zoveš se Đorđe', 'Тебя зовут Георгий', '/uploads/audio/sentences/Zoves_se_Djordje.mp3'),
(58, 'Ви сте професори', 'Vi ste profesori', 'Вы профессора', '/uploads/audio/sentences/Vi_ste_profesori.mp3'),
(59, 'Ми смо студенти', 'Mi smo studenti', 'Мы студенты', '/uploads/audio/sentences/Mi_smo_studenti.mp3'),
(60, 'Они су добро', 'Oni su dobro', 'Они хорошо', '/uploads/audio/sentences/Oni_su_dobro.mp3'),
(61, 'Добро су', 'Dobro su', 'Они хорошо', '/uploads/audio/sentences/Dobro_su.mp3'),
(62, 'Добро је', 'Dobro je', 'Он / она хорошо', '/uploads/audio/sentences/Dobro_je.mp3');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `words`
--

CREATE TABLE `words` (
  `id` int(11) NOT NULL,
  `latin` varchar(255) NOT NULL,
  `cyrillic` varchar(255) NOT NULL,
  `russian` varchar(255) NOT NULL,
  `audio_path` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `words`
--

INSERT INTO `words` (`id`, `latin`, `cyrillic`, `russian`, `audio_path`) VALUES
(110, 'bicikl', 'бицикл', 'велосипед', '/uploads/audio/words/bicikl.mp3'),
(111, 'bunar', 'бунар', 'колодец', '/uploads/audio/words/bunar.mp3'),
(112, 'bubica', 'бубица', 'букашка', '/uploads/audio/words/bubica.mp3'),
(113, 'barica', 'барица', 'лужа', '/uploads/audio/words/barica.mp3'),
(114, 'časkanje', 'часкање', 'болтовня', '/uploads/audio/words/c_askanje.mp3'),
(115, 'čarlijati', 'чарлијати', 'летний ветерок', '/uploads/audio/words/c_arlijati.mp3'),
(116, 'čelav', 'челав', 'лысый', '/uploads/audio/words/c_elav.mp3'),
(117, 'čevap', 'чевап', 'чевап', '/uploads/audio/words/c_evap.mp3'),
(118, 'đurđevak', 'ђурђевак', 'ландыш', '/uploads/audio/words/djurdjevak.mp3'),
(119, 'đakon', 'ђакон', 'дьякон', '/uploads/audio/words/djakon.mp3'),
(120, 'đevrek', 'ђеврек', 'бублик', '/uploads/audio/words/djevrek_1.mp3'),
(121, 'đačić', 'ђачић', 'ученичок', '/uploads/audio/words/djac_ic.mp3'),
(122, 'halucinacija', 'халуцинација', 'галлюцинация', '/uploads/audio/words/halucinacija.mp3'),
(123, 'halapljivica', 'халапљивица', 'обжориха', '/uploads/audio/words/halapljivica.mp3'),
(124, 'hirurški', 'хируршки', 'хирургический', '/uploads/audio/words/hirurs_ki.mp3'),
(125, 'hrkati', 'хркати', 'храпит', '/uploads/audio/words/hrkati.mp3'),
(126, 'ljuljuškati', 'љуљушкати', 'укачивать', '/uploads/audio/words/ljuljus_kati.mp3'),
(127, 'ljigav', 'љигав', 'слизистый', '/uploads/audio/words/ljigav.mp3'),
(128, 'ljiljan', 'љиљан', 'лилия', '/uploads/audio/words/ljiljan.mp3'),
(129, 'ljubomora', 'љубомора', 'ревность', '/uploads/audio/words/ljubomora.mp3'),
(130, 'njakanje', 'њакање', 'ревение осла', '/uploads/audio/words/njakanje.mp3'),
(131, 'njuška', 'њушка', 'морда', '/uploads/audio/words/njus_ka.mp3'),
(132, 'njištati', 'њиштати', 'ржание лошади', '/uploads/audio/words/njis_tati.mp3'),
(133, 'njunjoriti', 'њуњорити', 'нюхать', '/uploads/audio/words/njunjoriti.mp3'),
(161, 'baš', 'баш', 'весьма', NULL),
(162, 'zgrada', 'зграда', 'дом', NULL),
(163, 'trg', 'трг', 'площадь', NULL),
(164, 'pozorište', 'позориште', 'театр', NULL),
(165, 'stari', 'стари', 'старый', NULL),
(166, 'običan', 'обичан', 'простой', NULL),
(167, 'naravno', 'наравно', 'конечно', NULL),
(168, 'mladići', 'младићи', 'юноши (молодые люди)', NULL),
(169, 'odelo', 'одело', 'костюм', NULL),
(170, 'kruška', 'крушка', 'груша', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `word_cases`
--

CREATE TABLE `word_cases` (
  `id` int(11) NOT NULL,
  `base_word` varchar(100) NOT NULL,
  `word_latin` varchar(100) NOT NULL,
  `word_cyrillic` varchar(100) NOT NULL,
  `case_name` varchar(50) NOT NULL,
  `case_name_cyrillic` varchar(50) NOT NULL,
  `gender` enum('m','f','n') NOT NULL,
  `russian_translation` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `word_cases`
--

INSERT INTO `word_cases` (`id`, `base_word`, `word_latin`, `word_cyrillic`, `case_name`, `case_name_cyrillic`, `gender`, `russian_translation`, `created_at`) VALUES
(1, 'student', 'student', 'студент', 'nominativ', 'Именительный', 'm', 'студент', '2025-11-18 00:07:27'),
(2, 'student', 'studenta', 'студента', 'genitiv', 'Родительный', 'm', 'студент', '2025-11-18 00:07:27'),
(3, 'student', 'studentu', 'студенту', 'dativ', 'Дательный', 'm', 'студент', '2025-11-18 00:07:27'),
(4, 'student', 'studenta', 'студента', 'akuzativ', 'Винительный', 'm', 'студент', '2025-11-18 00:07:27'),
(5, 'student', 'studentom', 'студентом', 'instrumental', 'Творительный', 'm', 'студент', '2025-11-18 00:07:27'),
(6, 'student', 'studentu', 'студенту', 'lokativ', 'Предложный', 'm', 'студент', '2025-11-18 00:07:27'),
(7, 'student', 'studente', 'студенте', 'vokativ', 'Звательный', 'm', 'студент', '2025-11-18 00:07:27'),
(8, 'profesor', 'profesor', 'професор', 'nominativ', 'Именительный', 'm', 'профессор', '2025-11-18 00:07:27'),
(9, 'profesor', 'profesora', 'професора', 'genitiv', 'Родительный', 'm', 'профессор', '2025-11-18 00:07:27'),
(10, 'profesor', 'profesoru', 'професору', 'dativ', 'Дательный', 'm', 'профессор', '2025-11-18 00:07:27'),
(11, 'profesor', 'profesora', 'професора', 'akuzativ', 'Винительный', 'm', 'профессор', '2025-11-18 00:07:27'),
(12, 'profesor', 'profesorom', 'професором', 'instrumental', 'Творительный', 'm', 'профессор', '2025-11-18 00:07:27'),
(13, 'profesor', 'profesoru', 'професору', 'lokativ', 'Предложный', 'm', 'профессор', '2025-11-18 00:07:27'),
(14, 'profesor', 'profesore', 'професоре', 'vokativ', 'Звательный', 'm', 'профессор', '2025-11-18 00:07:27'),
(15, 'knjiga', 'knjiga', 'књига', 'nominativ', 'Именительный', 'f', 'книга', '2025-11-18 00:07:27'),
(16, 'knjiga', 'knjige', 'књиге', 'genitiv', 'Родительный', 'f', 'книга', '2025-11-18 00:07:27'),
(17, 'knjiga', 'knjizi', 'књизи', 'dativ', 'Дательный', 'f', 'книга', '2025-11-18 00:07:27'),
(18, 'knjiga', 'knjigu', 'књигу', 'akuzativ', 'Винительный', 'f', 'книга', '2025-11-18 00:07:27'),
(19, 'knjiga', 'knjigom', 'књигом', 'instrumental', 'Творительный', 'f', 'книга', '2025-11-18 00:07:27'),
(20, 'knjiga', 'knjizi', 'књизи', 'lokativ', 'Предложный', 'f', 'книга', '2025-11-18 00:07:27'),
(21, 'knjiga', 'knjigo', 'књиго', 'vokativ', 'Звательный', 'f', 'книга', '2025-11-18 00:07:27'),
(22, 'žena', 'žena', 'жена', 'nominativ', 'Именительный', 'f', 'женщина', '2025-11-18 00:07:27'),
(23, 'žena', 'žene', 'жене', 'genitiv', 'Родительный', 'f', 'женщина', '2025-11-18 00:07:27'),
(24, 'žena', 'ženi', 'жени', 'dativ', 'Дательный', 'f', 'женщина', '2025-11-18 00:07:27'),
(25, 'žena', 'ženu', 'жену', 'akuzativ', 'Винительный', 'f', 'женщина', '2025-11-18 00:07:27'),
(26, 'žena', 'ženom', 'женом', 'instrumental', 'Творительный', 'f', 'женщина', '2025-11-18 00:07:27'),
(27, 'žena', 'ženi', 'жени', 'lokativ', 'Предложный', 'f', 'женщина', '2025-11-18 00:07:27'),
(28, 'žena', 'ženo', 'жено', 'vokativ', 'Звательный', 'f', 'женщина', '2025-11-18 00:07:27'),
(29, 'mesto', 'mesto', 'место', 'nominativ', 'Именительный', 'n', 'место', '2025-11-18 00:07:27'),
(30, 'mesto', 'mesta', 'места', 'genitiv', 'Родительный', 'n', 'место', '2025-11-18 00:07:27'),
(31, 'mesto', 'mestu', 'месту', 'dativ', 'Дательный', 'n', 'место', '2025-11-18 00:07:27'),
(32, 'mesto', 'mesto', 'место', 'akuzativ', 'Винительный', 'n', 'место', '2025-11-18 00:07:27'),
(33, 'mesto', 'mestom', 'местом', 'instrumental', 'Творительный', 'n', 'место', '2025-11-18 00:07:27'),
(34, 'mesto', 'mestu', 'месту', 'lokativ', 'Предложный', 'n', 'место', '2025-11-18 00:07:27'),
(35, 'mesto', 'mesto', 'место', 'vokativ', 'Звательный', 'n', 'место', '2025-11-18 00:07:27'),
(36, 'more', 'more', 'море', 'nominativ', 'Именительный', 'n', 'море', '2025-11-18 00:07:27'),
(37, 'more', 'mora', 'мора', 'genitiv', 'Родительный', 'n', 'море', '2025-11-18 00:07:27'),
(38, 'more', 'moru', 'мору', 'dativ', 'Дательный', 'n', 'море', '2025-11-18 00:07:27'),
(39, 'more', 'more', 'море', 'akuzativ', 'Винительный', 'n', 'море', '2025-11-18 00:07:27'),
(40, 'more', 'morem', 'морем', 'instrumental', 'Творительный', 'n', 'море', '2025-11-18 00:07:27'),
(41, 'more', 'moru', 'мору', 'lokativ', 'Предложный', 'n', 'море', '2025-11-18 00:07:27'),
(42, 'more', 'more', 'море', 'vokativ', 'Звательный', 'n', 'море', '2025-11-18 00:07:27'),
(589, 'momak', 'momak', 'момак', 'nominativ', 'Именительный', 'm', 'юноша', '2025-11-19 06:53:51'),
(590, 'momak', 'momka', 'момка', 'genitiv', 'Родительный', 'm', 'юноша', '2025-11-19 06:53:51'),
(591, 'momak', 'momku', 'момку', 'dativ', 'Дательный', 'm', 'юноша', '2025-11-19 06:53:51'),
(592, 'momak', 'momka', 'момка', 'akuzativ', 'Винительный', 'm', 'юноша', '2025-11-19 06:53:51'),
(593, 'momak', 'momkom', 'момком', 'instrumental', 'Творительный', 'm', 'юноша', '2025-11-19 06:53:51'),
(594, 'momak', 'momku', 'момку', 'lokativ', 'Предложный', 'm', 'юноша', '2025-11-19 06:53:51'),
(595, 'momak', 'momče', 'момче', 'vokativ', 'Звательный', 'm', 'юноша', '2025-11-19 06:53:51'),
(596, 'kost', 'kost', 'кост', 'nominativ', 'Именительный', 'f', 'косточка', '2025-11-19 14:34:54'),
(597, 'kost', 'kosti', 'кости', 'genitiv', 'Родительный', 'f', 'косточка', '2025-11-19 14:34:54'),
(598, 'kost', 'kosti', 'кости', 'dativ', 'Дательный', 'f', 'косточка', '2025-11-19 14:34:54'),
(599, 'kost', 'kost', 'кост', 'akuzativ', 'Винительный', 'f', 'косточка', '2025-11-19 14:34:54'),
(600, 'kost', 'kosti', 'кости', 'instrumental', 'Творительный', 'f', 'косточка', '2025-11-19 14:34:54'),
(601, 'kost', 'kosti', 'кости', 'lokativ', 'Предложный', 'f', 'косточка', '2025-11-19 14:34:54'),
(602, 'kost', 'kosti', 'кости', 'vokativ', 'Звательный', 'f', 'косточка', '2025-11-19 14:34:54'),
(610, 'sestra', 'sestra', 'сестра', 'nominativ', 'Именительный', 'f', 'сестра', '2025-11-21 23:05:01'),
(611, 'sestra', 'sestre', 'сестре', 'genitiv', 'Родительный', 'f', 'сестра', '2025-11-21 23:05:01'),
(612, 'sestra', 'sestri', 'сестри', 'dativ', 'Дательный', 'f', 'сестра', '2025-11-21 23:05:01'),
(613, 'sestra', 'sestru', 'сестру', 'akuzativ', 'Винительный', 'f', 'сестра', '2025-11-21 23:05:01'),
(614, 'sestra', 'sestro', 'сестро', 'vokativ', 'Звательный', 'f', 'сестра', '2025-11-21 23:05:01'),
(615, 'sestra', 'sestrom', 'сестром', 'instrumental', 'Творительный', 'f', 'сестра', '2025-11-21 23:05:01'),
(616, 'sestra', 'sestri', 'сестри', 'lokativ', 'Предложный', 'f', 'сестра', '2025-11-21 23:05:01'),
(617, 'olovka', 'olovka', 'оловка', 'nominativ', 'Именительный', 'f', 'ручка', '2025-11-24 09:00:42'),
(618, 'olovka', 'olovke', 'оловке', 'genitiv', 'Родительный', 'f', 'ручка', '2025-11-24 09:00:42'),
(619, 'olovka', 'olovсi', 'оловци', 'dativ', 'Дательный', 'f', 'ручка', '2025-11-24 09:00:42'),
(620, 'olovka', 'olovku', 'оловку', 'akuzativ', 'Винительный', 'f', 'ручка', '2025-11-24 09:00:42'),
(621, 'olovka', 'olovko', 'оловко', 'vokativ', 'Звательный', 'f', 'ручка', '2025-11-24 09:00:42'),
(622, 'olovka', 'olovkom', 'оловком', 'instrumental', 'Творительный', 'f', 'ручка', '2025-11-24 09:00:42'),
(623, 'olovka', 'olovсi', 'оловци', 'lokativ', 'Предложный', 'f', 'ручка', '2025-11-24 09:00:42'),
(624, 'сто', 'сто', 'сто', 'nominativ', 'Именительный', 'm', 'стол', '2025-11-24 09:51:09'),
(625, 'сто', 'стa', 'ста', 'genitiv', 'Родительный', 'm', 'стол', '2025-11-24 09:51:09'),
(626, 'сто', 'стa', 'ста', 'dativ', 'Дательный', 'm', 'стол', '2025-11-24 09:51:09'),
(627, 'сто', 'сто', 'сто', 'akuzativ', 'Винительный', 'm', 'стол', '2025-11-24 09:51:09'),
(628, 'сто', 'стa', 'ста', 'vokativ', 'Звательный', 'm', 'стол', '2025-11-24 09:51:09'),
(629, 'сто', 'стa', 'ста', 'instrumental', 'Творительный', 'm', 'стол', '2025-11-24 09:51:09'),
(630, 'сто', 'стa', 'ста', 'lokativ', 'Предложный', 'm', 'стол', '2025-11-24 09:51:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sentences`
--
ALTER TABLE `sentences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `words`
--
ALTER TABLE `words`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `word_cases`
--
ALTER TABLE `word_cases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_word_case` (`base_word`,`case_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sentences`
--
ALTER TABLE `sentences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `words`
--
ALTER TABLE `words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `word_cases`
--
ALTER TABLE `word_cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=631;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
