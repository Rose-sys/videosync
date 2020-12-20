SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `videosync`
--

-- --------------------------------------------------------


CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `sessionid` varchar(255) DEFAULT NULL,
  `clientid` varchar(255) DEFAULT NULL,
  `lastactive` int(11) DEFAULT NULL,
  `curtime` int(11) DEFAULT NULL,
  `url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `sessionid` varchar(255) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `action` int(11) DEFAULT NULL COMMENT '0=pause, 1=play',
  `actionid` int(11) DEFAULT NULL COMMENT 'increases per action',
  `url` text DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `lastactive` bigint(20) DEFAULT NULL,
  `totaltime` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `display` int(11) DEFAULT 0,
  `title` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

*-
-- --------------------------------------------------------



CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` text DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



INSERT INTO `users` (`userid`, `username`, `password`, `email`, `salt`) VALUES
(1, 'videosyncmaster', '$2y$12$1iG6hImxdsQCVzq/55l07eoEn1VzxfVyuiZ9CfvwdfTEXEtYBSNEa', NULL, NULL);

ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;
