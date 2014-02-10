-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 10 2014 г., 04:10
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `clear_tables`()
    NO SQL
    COMMENT 'Очистка таблиц'
BEGIN
TRUNCATE account;
TRUNCATE user;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_account`(IN `login` VARCHAR(25) CHARSET utf8, IN `password` VARCHAR(40) CHARSET utf8, IN `salt` VARCHAR(255) CHARSET utf8, OUT `id` INT)
    NO SQL
BEGIN
START TRANSACTION;
INSERT INTO user(user_id) VALUES (NULL);
SET id=LAST_INSERT_ID();
INSERT INTO account(account_id, account_login, account_password, account_salt) VALUES (id, login, password, salt);
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_event`(IN `title` VARCHAR(255), IN `description_public` TEXT, IN `description_private` TEXT, IN `type` VARCHAR(10), IN `confirm` BOOLEAN, IN `confirm_description` TEXT, OUT `id` INT)
    NO SQL
BEGIN
START TRANSACTION;
INSERT INTO userset(userset_id) VALUES (NULL);
SET id=LAST_INSERT_ID();
INSERT INTO user_userset(user_userset_userset_id) VALUES (id);
INSERT INTO event(event_title, event_description_public, event_description_private, event_type, event_confirm, event_confirm_description, event_userset_id, event_messagegroup_id) VALUES (title, description_public, description_private, type, confirm, confirm_description, id, id);
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_account`(IN `login` VARCHAR(25), IN `password` VARCHAR(40) CHARSET utf8, IN `salt` VARCHAR(255) CHARSET utf8)
    NO SQL
BEGIN
START TRANSACTION;
UPDATE `account` SET `account_password`=password, `account_salt`=salt WHERE `account_login`=login;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_event`(IN `id` INT, IN `title` VARCHAR(255), IN `description_public` TEXT, IN `description_private` TEXT, IN `type` VARCHAR(10), IN `confirm` BOOLEAN, IN `confirm_description` TEXT)
    NO SQL
BEGIN
START TRANSACTION;
UPDATE `event` SET `event_title`=title, `event_description_public`=description_public,`event_description_private`=description_private, `event_type`=type, `event_confirm`=confirm, `event_confirm_description`=event_confirm_description WHERE `event_id`=id;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_user`(IN `name` VARCHAR(25) CHARSET utf8, IN `surname` VARCHAR(25) CHARSET utf8, IN `patronymic` VARCHAR(25) CHARSET utf8, IN `birthday` DATE, IN `residence` VARCHAR(50) CHARSET utf8, IN `gender` VARCHAR(6) CHARSET utf8, IN `mail` VARCHAR(32) CHARSET utf8, IN `telephone` VARCHAR(11) CHARSET utf8, IN `id` INT)
    NO SQL
BEGIN
START TRANSACTION;
UPDATE `user` SET `user_name`=name, `user_surname`=surname, `user_patronymic`=patronymic, `user_date`=birthday, `user_residence`=residence, `user_gender`=gender, `user_mail`=mail, `user_telephone`=telephone WHERE `user_id`=id;
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Дамп данных таблицы `account`
--

INSERT INTO `account` (`account_id`, `account_login`, `account_password`, `account_salt`) VALUES
(15, 'qwe', '26e48a2f89e8b948eb7aa0c444b3c9e9240ea28d', '#pkc$3ort~brt'),
(16, 'tom', 'f9ee1af57ba88fe3612922e209bdce2649027eb1', '_3k*k*pt&gg+e'),
(17, 'dim', '92dbc51328f6f1cf62700ff2e993249d86a4a9cf', 'zrhv+m%fj&ijyq'),
(18, 'dim2', '203b306a46e1a296bfbf2d5a237d9708b471f070', '5%hc#nv_jl$!q'),
(19, 'fffaf', '2222231', 'dadsad'),
(20, 'qqq', 'f29e05566dbf26107dede7ffe71cd29032929cb1', 'dl6w%xt8yi6z3');

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
-- Структура таблицы `contest`
--

CREATE TABLE IF NOT EXISTS `contest` (
  `contest_d` int(11) NOT NULL AUTO_INCREMENT,
  `contest_event_id` int(11) NOT NULL,
  `contest_contest_id` int(11) NOT NULL,
  PRIMARY KEY (`contest_d`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_title` varchar(255) NOT NULL,
  `event_description_public` text NOT NULL,
  `event_description_private` text NOT NULL,
  `event_type` varchar(10) NOT NULL,
  `event_confirm` tinyint(1) NOT NULL,
  `event_confirm_description` text NOT NULL,
  `event_userset_id` int(11) NOT NULL,
  `event_messagegroup_id` int(11) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `event`
--

INSERT INTO `event` (`event_id`, `event_title`, `event_description_public`, `event_description_private`, `event_type`, `event_confirm`, `event_confirm_description`, `event_userset_id`, `event_messagegroup_id`) VALUES
(1, 'even_changed', 'public', 'private', 'closed', 1, 'qqwe', 1, 1);

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
  `user_name` varchar(25) NOT NULL,
  `user_surname` varchar(25) NOT NULL,
  `user_patronymic` varchar(25) NOT NULL,
  `user_date` date NOT NULL,
  `user_gender` varchar(6) NOT NULL,
  `user_residence` varchar(50) NOT NULL,
  `user_role` int(11) NOT NULL,
  `user_mail` varchar(32) NOT NULL,
  `user_telephone` varchar(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_surname`, `user_patronymic`, `user_date`, `user_gender`, `user_residence`, `user_role`, `user_mail`, `user_telephone`) VALUES
(15, '1', '', '', '0000-00-00', '', '', 0, '', ''),
(16, '2', '2312', '332', '0000-00-00', '', '', 0, '', ''),
(17, 'dim', 'zal', 'andr', '0000-00-00', '', '', 0, '', ''),
(18, '', '', '', '0000-00-00', '', '', 0, '', ''),
(19, '', '', '', '0000-00-00', '', '', 0, '', ''),
(20, '', '', '', '0000-00-00', '', '', 0, '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `userset`
--

CREATE TABLE IF NOT EXISTS `userset` (
  `userset_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`userset_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `userset`
--

INSERT INTO `userset` (`userset_id`) VALUES
(1);

-- --------------------------------------------------------

--
-- Структура таблицы `user_userset`
--

CREATE TABLE IF NOT EXISTS `user_userset` (
  `user_userset_user_id` int(11) NOT NULL,
  `user_userset_userset_id` int(11) NOT NULL,
  `user_userset_rule_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_userset`
--

INSERT INTO `user_userset` (`user_userset_user_id`, `user_userset_userset_id`, `user_userset_rule_id`) VALUES
(0, 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
