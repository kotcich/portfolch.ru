-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 08, 2021 at 03:30 PM
-- Server version: 10.3.22-MariaDB
-- PHP Version: 7.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `text` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`id`, `text`, `user_id`) VALUES
(1, 'Создатель этого прекрасного детища.', 1),
(2, 'Рассказываю о себе, вооооооот.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Иммиграция'),
(2, 'Японская культура'),
(3, 'Техника и софт'),
(4, 'Разное');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `answer_user_id` int(11) DEFAULT 0,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `text`, `date`, `user_id`, `answer_user_id`, `post_id`) VALUES
(1, 'Eva\r\nteenage power fantasies\r\n\r\nUh', '2021-02-25 18:50:29', 1, 0, 17),
(2, 'Hell yeah clinical depression is my favorite teenage power fantasy.\r\n\r\nJokes aside, NGE is the one show that can actually claim it saved the anime industry as a whole. Its animation is way above average too so when you refer to mediocre animation I assume you\'re talking about the artstlye?\r\n\r\nIt\'s a wonderful character study and in my opinion no other show has managed to portray its characters motivations and emotions in such a realistic manner.', '2021-02-25 19:23:52', 2, 0, 17),
(7, 'You lost me at \"mish-mash of teenage power fantasies\" m8', '2021-02-25 20:22:26', 3, 0, 17),
(8, 'Wait what? How can one single anime save an entire industry?', '2021-02-26 13:25:00', 1, 2, 17),
(10, 'Yeah he probably didn\'t get far.', '2021-03-01 14:26:55', 2, 1, 17),
(11, 'In short: it helped revive anime as a medium worth putting money in.', '2021-03-01 14:28:30', 2, 1, 17),
(12, 'teenage power fantasies\r\n\r\nmediocre animation\r\n\r\nmeandering, listless plot\r\n\r\nreally makes you think', '2021-03-01 14:31:38', 3, 1, 17),
(13, 'Theyre all on Hulu, 12$ USD a month. Not a bad deal considering all the other Hulu content.\r\n\r\nAnd outside of VRV (Crunchy Roll) Hulu has the better anime selection over Netflix (with a few exceptions).', '2021-03-01 14:40:16', 5, 0, 14),
(14, 'If you\'re talking about the specials like episode of the east blue those aren\'t dubbed but they did dubbed a special for alabasta.', '2021-03-01 14:41:25', 2, 0, 14),
(15, 'No, I mean when they remastered the old One Piece episodes to fit widescreen. Some people edited the dubs from funimation into them.', '2021-03-01 14:42:17', 1, 2, 14),
(16, 'I have collected many websites in File where you can download and watch One Piece:', '2021-03-01 14:46:10', 3, 1, 14),
(17, 'Согласен с тобой, но в некоторые моменты эта тня полезна(2 сезон).', '2021-03-01 19:24:47', 2, 0, 20),
(18, 'КИШИМОТО ЛЮБИТ ЖЕНЩИН', '2021-03-01 19:25:45', 3, 0, 20),
(19, 'Можно еще вспомнить Еву Хайнман из \"Монстра\": персонаж был заведомо сделан так, чтобы поначалу раздражать своим поведением и мировоззрением, но к концу повествования стала совершенно другим человеком. А Сакура изначально и до самого конца — просто персонаж-затычка, как и Тенатен.', '2021-03-01 19:27:35', 5, 2, 20);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `text` text NOT NULL,
  `sub_category_id` tinyint(4) NOT NULL,
  `date_add` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `img` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `name`, `text`, `sub_category_id`, `date_add`, `user_id`, `img`) VALUES
(14, 'Anyone know where I can download One Piece English Dubbed Episodes remastered?', 'Most downloadable sites only contain the normal square screen. I remember there were sites for the remastered widescreen episodes but it seems they\'ve removed them for some particular reason.', 5, '2021-02-23 19:41:43', 1, '5986912410_682fed19e2_b.jpg'),
(15, '[Spoilers] Could someone explain the ending of Neon Genesis Evangelion?', 'I finished both the original anime and movie last night, and I\'m a little lost. Not that I can\'t comprehend it, but it\'s very abstract. The original anime ending seemed very out of place compared to the entire season, it was mainly several episodes focusing on Shinji\'s internal struggle and in the end accepting himself, but does nothing to explain what happens to everyone else, the Angels, and the Evas. It was like he killed kaworu, and they found Asuka in a bathtub, and then it was just 44 minutes of inside Shinji\'s mind.\r\n\r\nAs for the movie, I think it\'s a little bit more clear as to what happened, but at the same time some of the fine details feel lost to me. I get that in some facet I guess Shinji and Unit 01 are the catalysts for the Apocalypse/rebirth of life on earth and that he originally chooses to make life as one entity (the soup thing) while he chose to maintain his physical form, but then allows anyone with a strong sense of consciousness to find their own form if they do so choose or have the power to, but why exactly is Asuka there? Was she simply one of the first to find her way back to physical form? Did Shinji choose to allow her to keep her form? Is he surprised when he sees Rei because he\'s been alone for so long, or is he surprised when he sees Asuka? Does he choke her because he doesn\'t know if she is actually there or if he\'s going crazy? and why does she seem so disgusted by him and call him pathetic in the end?', 5, '2021-02-23 19:53:52', 1, 'end-of-evangelion.jpg'),
(16, 'Evangelion is the best anime I\'ve ever seen. What else can I watch that\'s comparable to it?', '', 5, '2021-02-23 19:56:05', 1, 'neon-genesis-evangelion-04-gq-7jun19_b.jpg'),
(17, 'Why is Neon Genesis Evangelion so highly regarded', 'I\'m a relative newcomer to the anime world, having only started watching it seriously since 2015. When I first started researching shows to watch, Neon Genesis Evangelion was being constantly suggested as the \"pinnacle\" of what anime had to offer. I decided to hold off on watching it, since it was supposedly so overwhelmingly good, and this anticipation probably contributed to my eventual horror when I did start to watch the series two years ago or so. I found that the series was nothing more than a mish-mash of teenage power fantasies mixed up with mediocre animation (in relation to more modern shows) and a meandering, listless plot. I gave up about halfway through the series on my first watch, and slapped a score of 2 on it out of spite since I\'d been so hyped up to watch it.\r\n\r\nRecently, I\'ve tried to watch it, and while it definitely isn\'t as bad as my initial impression would have suggested, I honestly don\'t feel like continuing to watch it, as it doesn\'t seem to offer much in comparison to more modern anime.\r\n\r\nI understand that perhaps nostalgia and the fact that many of the tropes and cliches present in Evangelion may have originated with that anime have contributed to it\'s popularity, I\'m slightly confused as to how it\'s considered by some to be the absolute best anime of all time. Maybe the second half of the series is much better and I just need to stick with it and then I\'ll get it, so as to speak? Or is Evangelion merely an influential, but antiquated relic of the previous millenium, kept alive by the fans of it\'s original run?', 5, '2021-02-23 20:00:34', 1, 'evangelion5.jpg'),
(18, 'Is the Berserk anime worth watching?', 'I caught up to the manga a few days ago and am wondering if either the 1997 or 2016 anime is worth it.', 5, '2021-02-23 20:02:29', 1, '93a356c3e5118359befcc6f242a2c570.jpg'),
(20, 'Как же я ненавижу эту мразоту №2', 'Уже делал похожий тред, но в нем, я не заострил внимание на прошлом данного индивидуума. То что Сакура - это олицетворение большинства тней, нет никаких сомнений. Сейчас, смотря на ее бой с Ино, где во флешбеках показывают их прошлое, я просто хуею с того, как это все преподносит автор. Мы можем для примера вспомнить прошлое, Наруто которого травили всей деревней, Саске чьих родственников вырезали прямо у него на глазах, Хаку который не осознанно убил своего отца и пытаясь защититься от него, Рок Ли который не мог использовать чакру, но при этом не сдавался и превозмогал, и Сакура которая просто была чуть-чуть замкнутой и неуверенной девчушкой. Но ее прошлое преподносят так, что это должно выглядеть ни менее трагично, чем прошлое вышеперечисленных парней. Точно так же, многие девушки и в реальной жизни, преподносят свои не значительные маняпроблемы и говорят, что они прекрасно понимают парней, которые росли в настоящем мордере, были всю жизнь изгоем и одиночками.\r\nЯ совершенно не удивлюсь, если Хишимота, при создании Сакуры ссылался на какой-то свой неудачный опыт с девушками и таким образом, пытается показать, что их проблемы - залупа из под коня, по сравнению с проблемами многих мужчин.', 5, '2021-03-01 19:20:02', 1, '16144156651340s.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `category_id`) VALUES
(1, 'США', 1),
(2, 'Канада', 1),
(3, 'Чехия', 1),
(4, 'Польша', 1),
(5, 'Аниме', 2),
(6, 'Манга', 2),
(7, 'Программирование', 3),
(8, 'Гейм дев', 3),
(9, 'Знакомства', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(535) NOT NULL,
  `email` varchar(64) NOT NULL,
  `date_birth` date NOT NULL,
  `date_registration` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `date_birth`, `date_registration`, `status`) VALUES
(1, 'kotcich', '$2y$10$dSk2CePfWzU87Tf2marpae.0.2Z6WLRC2OxWmG.yxrqzhizgHj7y.', 'punchesgt@mail.ru', '1999-07-07', '2021-02-19', 3),
(2, 'verkey', '$2y$10$hcRNETyVSxIGZ/Ytw1.No.KWCrrm/F9kdy0afQNUxSgCzCkpHlFh6', 'artem8656taka@mail.ru', '1999-07-07', '2021-02-19', 2),
(3, 'punches', '$2y$10$/2tZzcQJZYjsMfLVKcF3sOfcLXIB2W7A5sVOyeH7XWmD9NsVfLkgS', 'kotcich@mail.ru', '1999-07-07', '2021-02-19', 1),
(5, 'snorki', '$2y$10$pcYbDQb8KGAQ7Jgwg6y7JOi5GJxq0QyqWVwq4FFlM4LPkWGaqvvhS', 'kotcich@gmail.com', '2000-07-05', '2021-03-01', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
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
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
