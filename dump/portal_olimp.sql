-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 06 2014 г., 11:46
-- Версия сервера: 5.6.14
-- Версия PHP: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `portal_olimp`
--

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_account`(IN `login` VARCHAR(25) CHARSET utf8, IN `password` VARCHAR(40) CHARSET utf8, IN `salt` VARCHAR(255) CHARSET utf8, OUT `id` INT)
    NO SQL
BEGIN
START TRANSACTION;
INSERT INTO user(user_id) VALUES (NULL);
SET id=LAST_INSERT_ID();
INSERT INTO account(account_id, account_login, account_password, account_salt) VALUES (id, login, password, salt);
COMMIT;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_login` varchar(25) NOT NULL,
  `account_password` varchar(40) NOT NULL,
  `account_salt` varchar(14) NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `account`
--

INSERT INTO `account` (`account_id`, `account_login`, `account_password`, `account_salt`) VALUES
(15, 'qwe', '8c15479e69a9ab8e3f74823367aed3ddb7f5718b', '+ojz3#5x55om8s'),
(16, 'tom', 'f9ee1af57ba88fe3612922e209bdce2649027eb1', '_3k*k*pt&gg+e');

-- --------------------------------------------------------

--
-- Структура таблицы `anket`
--

CREATE TABLE IF NOT EXISTS `anket` (
  `anket_id` int(11) NOT NULL AUTO_INCREMENT,
  `anket_user_id` int(11) NOT NULL,
  `anket_question_id` int(11) NOT NULL,
  `anket_answer` varchar(50) NOT NULL,
  PRIMARY KEY (`anket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_text` varchar(50) NOT NULL,
  `question_grouplist` int(11) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `question`
--

INSERT INTO `question` (`question_id`, `question_text`, `question_grouplist`) VALUES
(1, 'Имя', 0),
(2, 'Фамилия', 0),
(3, 'Отчество', 0),
(4, 'вуз', 0),
(5, 'курс', 0),
(6, 'специальность', 0),
(7, 'уровень', 0),
(8, 'школа', 0),
(9, 'класс', 0),
(10, 'должность', 0),
(11, 'ученная степень', 0),
(12, 'ученное звание', 0),
(13, 'год рождения', 0),
(14, 'пол', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(15) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `rule`
--

CREATE TABLE IF NOT EXISTS `rule` (
  `rule_id` int(11) NOT NULL AUTO_INCREMENT,
  `rule_name` varchar(15) NOT NULL,
  PRIMARY KEY (`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role` int(11) NOT NULL,
  `user_mail` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`user_id`, `user_role`, `user_mail`) VALUES
(15, 0, ''),
(16, 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `userset`
--

CREATE TABLE IF NOT EXISTS `userset` (
  `userset_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`userset_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_userset`
--

CREATE TABLE IF NOT EXISTS `user_userset` (
  `user_userset_user_id` int(11) NOT NULL,
  `user_userset_userset_id` int(11) NOT NULL,
  `user_userset_rule_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
