-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 21 2014 г., 23:19
-- Версия сервера: 5.1.40-community
-- Версия PHP: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `portal_olimp`
--
CREATE DATABASE IF NOT EXISTS `portal_olimp` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `portal_olimp`;

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
TRUNCATE messagegroup;
TRUNCATE message;
TRUNCATE userset;
TRUNCATE user_userset;
TRUNCATE user_mg_read;
TRUNCATE event;
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
	CALL insert_userset(@k);
	CALL insert_messagegroup(@e);
	INSERT INTO event(event_title, event_description_public, event_description_private, event_type, event_confirm, event_confirm_description, event_userset_id, event_messagegroup_id) VALUES (title, description_public, description_private, type, confirm, confirm_description, @k, @e);
	COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_file`(IN `name` VARCHAR(100), IN `code` VARCHAR(50), OUT `id` INT)
    NO SQL
BEGIN
	START TRANSACTION;
    INSERT INTO `file`(`file_name`, `file_code`) VALUES (`name`, `code`);
    SET id=LAST_INSERT_ID();
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_message`(IN `text_message` TEXT, IN `id_user` INT, IN `id_group` INT, IN `id_message` INT, IN `status_message` INT, IN `files` TEXT, OUT `id` INT)
    NO SQL
BEGIN
	START TRANSACTION;
	INSERT INTO message (message_text, message_user, message_group, message_message, message_status) VALUES (text_message, id_user, id_group, id_message, status_message);
	SET id=LAST_INSERT_ID();
	CALL insert_message_file(files, id);
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_messagegroup`(IN `desc_mg` VARCHAR(100), IN `type_mg` INT, IN `status_mg` INT, OUT `id` INT)
    NO SQL
BEGIN
	CALL insert_userset(@k);
    INSERT INTO messagegroup (messagegroup_partners, messagegroup_type, messagegroup_status, messagegroup_desc) VALUES (@k, type_mg, status_mg, desc_mg);
	SET id=LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_message_file`(IN `mylist` TEXT, IN `id_message` INT)
    NO SQL
body:
BEGIN
 
IF mylist = '' THEN LEAVE body; END IF;
  START TRANSACTION;
  SET @saTail = mylist;
  WHILE @saTail != '' DO
    SET @saHead = SUBSTRING_INDEX(@saTail, ',', 1);    
    SET @i=LENGTH(@saHead)+1;
    SET @saTail = SUBSTRING( @saTail, @i+1 );
    INSERT INTO `message_file` (`file_id`,`message_id`) VALUES (@saHead, id_message);
  END WHILE;
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_userset`(OUT `id` INT)
    NO SQL
BEGIN
	START TRANSACTION;
	INSERT INTO userset(userset_id) value (NULL);
	SET id=LAST_INSERT_ID();
	COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_user_userset`(IN `id_user` INT, IN `id_obj` INT, IN `id_rule` INT, IN `obj_type` VARCHAR(10) CHARSET utf8)
    NO SQL
BEGIN
	DECLARE userset_id, old_rule int;
START TRANSACTION;
	CASE obj_type
		WHEN 1 THEN
			SET userset_id = (SELECT messagegroup_partners FROM messagegroup WHERE messagegroup_id = id_obj);
		WHEN 2 THEN
			SET userset_id = (SELECT event_userset_id FROM event WHERE event_id = id_obj);
	END CASE;

	SET old_rule = (SELECT user_userset_rule_id FROM user_userset WHERE user_userset_user_id = id_user AND user_userset_userset_id = userset_id);
	
	IF old_rule > 0 THEN
		UPDATE user_userset SET user_userset_rule_id = id_rule WHERE user_userset_userset_id = userset_id AND user_userset_user_id = id_user;
	ELSE
		INSERT INTO user_userset(user_userset_user_id, user_userset_userset_id, user_userset_rule_id) value (id_user, userset_id, id_rule);
	END IF;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_visit`(IN `id_user` INT, IN `id_group` INT)
    NO SQL
BEGIN
	DECLARE id int;
	START TRANSACTION;
	SET id = (SELECT user_mg_read_id FROM user_mg_read WHERE user_mg_read_user=id_user AND user_mg_read_mg=id_group);

	IF id > 0  THEN
		UPDATE `user_mg_read`  SET user_mg_read_last_date=NULL WHERE user_mg_read_user=id_user AND user_mg_read_mg=id_group;
	ELSE
	    INSERT INTO `user_mg_read` (`user_mg_read_user`,`user_mg_read_mg`) VALUES (id_user, id_group);
	END IF;
	COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_account`(IN `login` VARCHAR(25), IN `password` VARCHAR(40) CHARSET utf8, IN `salt` VARCHAR(255) CHARSET utf8)
    NO SQL
BEGIN
START TRANSACTION;
UPDATE `account` SET `account_password`=password, `account_salt`=salt WHERE `account_login`=login;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_event`(IN `title` VARCHAR(255) CHARSET utf8, IN `desc_publ` TEXT CHARSET utf8, IN `desc_priv` TEXT CHARSET utf8, IN `type` VARCHAR(10) CHARSET utf8, IN `confirm` BOOLEAN, IN `confirm_desc` TEXT CHARSET utf8, IN `e_id` INT)
    NO SQL
BEGIN
	START TRANSACTION;
	UPDATE `event` SET `event_title`=title, `event_description_public`=desc_publ,`event_description_private`=desc_priv, `event_type`=type, `event_confirm`=confirm, `event_confirm_description`=confirm_desc WHERE `event_id`=e_id;
	COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_message`(IN `text_m` TEXT, IN `status_m` INT, IN `id_m` INT)
    NO SQL
BEGIN
	START TRANSACTION;
	UPDATE message SET message_text = text_m, message_status = status_m WHERE message_id = id_m;
	COMMIT;
	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_messagegroup`(IN `desc_mg` VARCHAR(100), IN `status_mg` INT, IN `id_mg` INT)
    NO SQL
BEGIN
    UPDATE messagegroup SET messagegroup_status = status_mg, messagegroup_desc = desc_mg WHERE messagegroup_id = id_mg;	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_user`(IN `name` VARCHAR(25) CHARSET utf8, IN `surname` VARCHAR(25) CHARSET utf8, IN `patronymic` VARCHAR(25) CHARSET utf8, IN `birthday` DATE, IN `residence` VARCHAR(50) CHARSET utf8, IN `gender` VARCHAR(6) CHARSET utf8, IN `mail` VARCHAR(32) CHARSET utf8, IN `telephone` VARCHAR(11) CHARSET utf8, IN `status` INT, IN `id` INT)
    NO SQL
BEGIN
	START TRANSACTION;
	UPDATE `user` SET `user_name`=name, `user_surname`=surname, `user_patronymic`=patronymic, `user_date`=birthday, `user_residence`=residence, `user_gender`=gender, `user_mail`=mail, `user_telephone`=telephone, `user_status` = status WHERE `user_id`=id;
	COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_user_userset`(IN `id_user` INT, IN `id_userset` INT, IN `id_rule` INT)
    NO SQL
BEGIN
    UPDATE user_userset SET user_userset_rule_id = id_rule WHERE user_userset_userset_id = id_userset AND user_userset_user_id = id_user;	
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
(17, 'dim', '5e35c69583248f72d56c9643f97f43c2016ba39a', '#m+n28h+r*2ejs'),
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
  `event_status` int(11) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `event`
--

INSERT INTO `event` (`event_id`, `event_title`, `event_description_public`, `event_description_private`, `event_type`, `event_confirm`, `event_confirm_description`, `event_userset_id`, `event_messagegroup_id`, `event_status`) VALUES
(1, 'Тестовое', '<p style="text-align: left;"><strong>Приветствую на тестовом мероприятии!</strong></p>\r\n<p style="text-align: left;">Список далее:</p>\r\n<ol style="text-align: left;">\r\n<li>Пункт1</li>\r\n<li>&nbsp;Пункт2</li>\r\n<li>&nbsp;Пункт3</li>\r\n</ol>\r\n<p style="text-align: left;"><span style="text-decoration: line-through;">&nbsp;не нужно</span></p>', '<p style="text-align: center;">Закрытая часть</p>', '0', 1, '<p>qqwe</p>', 1, 1, 0),
(2, '1212', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br />tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br />quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo<br />consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse<br />cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non<br />proident, sunt in culpa qui <em>officia</em> <strong>deserunt</strong></p>\r\n<ol>\r\n<li>mollit&nbsp;</li>\r\n<li>anim&nbsp;</li>\r\n<li>id&nbsp;</li>\r\n<li>est&nbsp;</li>\r\n<li>laborum.</li>\r\n</ol>', '<p>12</p>', '1', 0, '', 57, 57, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `file_code` varchar(255) NOT NULL,
  `file_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `file`
--

INSERT INTO `file` (`file_id`, `file_name`, `file_code`, `file_date`) VALUES
(2, 'portal_olimp.sql', '51be78a67665650b76bac01827f48aea', '2014-02-14 07:20:39'),
(3, 'portal_olimp.sql', '6496434e9a379882189b81dd11aab097', '2014-02-14 12:16:35'),
(4, 'Задания.todo', 'e450e6671442a27b4765b9d368c60681', '2014-02-17 10:42:58'),
(5, 'Задания.todo', '07ad369356baf2374fb74428c8f706d8', '2014-02-17 13:04:19'),
(6, 'Minecraft.exe', '979d68536d00d981f4f18c918f418c0f', '2014-02-19 10:35:45');

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_text` text NOT NULL,
  `message_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message_user` int(11) NOT NULL,
  `message_group` int(11) DEFAULT NULL,
  `message_message` int(11) NOT NULL,
  `message_status` smallint(6) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`message_id`, `message_text`, `message_date`, `message_user`, `message_group`, `message_message`, `message_status`) VALUES
(2, 'hi', '2014-02-10 12:36:23', 17, 6, 0, 1),
(3, '123', '2014-02-11 05:36:43', 1, 2, 0, 1),
(4, 'q', '2014-02-11 05:38:40', 17, 1, 0, 0),
(5, 'q', '2014-02-11 05:47:49', 17, 1, 0, 0),
(6, 'qwwww', '2014-02-11 05:48:04', 17, 1, 0, 0),
(7, 'wee', '2014-02-11 05:48:59', 17, 1, 0, 0),
(8, '1', '2014-02-11 05:49:02', 17, 1, 0, 0),
(9, '2', '2014-02-13 10:12:44', 17, 8, 0, 0),
(10, '11', '2014-02-14 06:07:01', 16, 18, 0, 0),
(11, '2', '2014-02-14 06:47:49', 16, 18, 0, 0),
(13, '3', '2014-02-14 07:09:43', 16, 18, 0, 0),
(14, '4', '2014-02-14 07:10:23', 16, 18, 0, 0),
(15, '5', '2014-02-14 07:10:50', 16, 18, 0, 0),
(16, '6', '2014-02-14 07:15:15', 16, 18, 0, 0),
(17, '7', '2014-02-14 07:17:02', 16, 18, 0, 0),
(18, '8', '2014-02-14 07:18:38', 16, 18, 0, 0),
(19, '9', '2014-02-14 07:19:46', 16, 18, 0, 0),
(20, '11', '2014-02-14 07:20:39', 16, 18, 0, 0),
(21, '1', '2014-02-14 11:16:15', 17, 21, 0, 0),
(22, '1', '2014-02-14 11:26:27', 17, 3, 0, 0),
(23, '', '2014-02-14 12:16:35', 17, 4, 0, 0),
(24, '1', '2014-02-17 10:42:58', 17, 16, 0, 0),
(25, '1', '2014-02-17 13:04:19', 17, 5, 0, 0),
(26, 'уииииииииииииииииииииииииииии', '2014-02-18 10:06:34', 17, 6, 0, 0),
(27, '212', '2014-02-18 10:30:51', 16, 15, 0, 0),
(28, '1', '2014-02-18 10:33:25', 17, 34, 0, 0),
(29, '2', '2014-02-18 10:33:27', 17, 34, 0, 0),
(30, '3', '2014-02-18 10:34:11', 16, 34, 0, 0),
(31, '2', '2014-02-18 10:35:39', 16, 34, 0, 0),
(32, '5', '2014-02-18 10:36:16', 16, 34, 0, 0),
(33, '32222', '2014-02-18 10:37:40', 17, 34, 0, 0),
(34, '111', '2014-02-18 10:43:12', 16, 34, 0, 0),
(35, 'hi', '2014-02-18 11:18:51', 16, 34, 0, 0),
(40, '2', '2014-02-19 06:32:11', 17, 38, 0, 0),
(39, '1', '2014-02-19 02:43:27', 17, 38, 0, 0),
(41, '3', '2014-02-19 10:31:48', 17, 38, 0, 0),
(42, '3', '2014-02-19 10:31:57', 17, 38, 0, 0),
(43, '4', '2014-02-19 10:32:03', 17, 38, 0, 0),
(44, '5', '2014-02-19 10:32:08', 17, 38, 0, 0),
(45, '6', '2014-02-19 10:32:15', 17, 38, 0, 0),
(46, '7', '2014-02-19 10:35:45', 17, 38, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `messagegroup`
--

CREATE TABLE IF NOT EXISTS `messagegroup` (
  `messagegroup_id` int(11) NOT NULL AUTO_INCREMENT,
  `messagegroup_partners` int(11) NOT NULL,
  `messagegroup_type` int(11) NOT NULL,
  `messagegroup_status` int(11) NOT NULL,
  `messagegroup_desc` varchar(100) NOT NULL,
  PRIMARY KEY (`messagegroup_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Дамп данных таблицы `messagegroup`
--

INSERT INTO `messagegroup` (`messagegroup_id`, `messagegroup_partners`, `messagegroup_type`, `messagegroup_status`, `messagegroup_desc`) VALUES
(1, 2, 1, 1, ''),
(2, 3, 1, 1, ''),
(3, 4, 1, 1, ''),
(4, 5, 1, 1, ''),
(5, 6, 1, 1, ''),
(6, 7, 1, 1, ''),
(7, 8, 1, 1, ''),
(8, 9, 1, 1, ''),
(9, 10, 1, 1, ''),
(10, 11, 1, 1, ''),
(11, 12, 1, 1, ''),
(12, 13, 1, 1, ''),
(13, 14, 1, 1, ''),
(14, 15, 1, 1, ''),
(15, 16, 1, 1, ''),
(16, 17, 1, 1, ''),
(17, 18, 1, 1, ''),
(18, 19, 1, 1, ''),
(19, 20, 1, 0, ''),
(20, 21, 1, 0, ''),
(21, 22, 1, 0, ''),
(22, 23, 1, 0, ''),
(23, 24, 1, 0, ''),
(24, 25, 1, 0, ''),
(25, 26, 1, 0, ''),
(26, 27, 1, 0, ''),
(27, 28, 1, 0, ''),
(28, 29, 1, 0, ''),
(29, 30, 1, 0, ''),
(30, 31, 1, 0, ''),
(31, 46, 1, 0, ''),
(32, 47, 1, 0, ''),
(33, 51, 1, 1, '11'),
(34, 52, 1, 0, ''),
(35, 53, 1, 0, ''),
(36, 54, 1, 0, ''),
(37, 55, 33, 1, 'Для всех'),
(38, 56, 3, 0, 'Для всех пользователей');

-- --------------------------------------------------------

--
-- Структура таблицы `message_file`
--

CREATE TABLE IF NOT EXISTS `message_file` (
  `message_file_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  PRIMARY KEY (`message_file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `message_file`
--

INSERT INTO `message_file` (`message_file_id`, `file_id`, `message_id`) VALUES
(3, 2, 20),
(4, 23, 22),
(5, 3, 23),
(6, 4, 24),
(7, 5, 25),
(8, 26, 35),
(9, 6, 46);

-- --------------------------------------------------------

--
-- Структура таблицы `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_text` varchar(50) NOT NULL,
  `question_grouplist` int(11) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `question`
--

INSERT INTO `question` (`question_id`, `question_text`, `question_grouplist`) VALUES
(4, 'вуз', 0),
(5, 'курс', 0),
(6, 'специальность', 0),
(7, 'уровень', 0),
(8, 'школа', 0),
(9, 'класс', 0),
(10, 'должность', 0),
(11, 'ученная степень', 0),
(12, 'ученное звание', 0);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `rule`
--
CREATE TABLE IF NOT EXISTS `rule` (
`obj_id` int(11)
,`user_id` int(11)
,`userset_id` int(11)
,`rule_id` int(11)
,`obj_type` bigint(20)
);
-- --------------------------------------------------------

--
-- Дублирующая структура для представления `status`
--
CREATE TABLE IF NOT EXISTS `status` (
`obj_id` int(11)
,`obj_status` int(11)
,`obj_type` bigint(20)
);
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
  `user_status` int(11) NOT NULL,
  `user_mail` varchar(32) NOT NULL,
  `user_telephone` varchar(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_surname`, `user_patronymic`, `user_date`, `user_gender`, `user_residence`, `user_status`, `user_mail`, `user_telephone`) VALUES
(15, 'Feed', 'Stret', '', '0000-00-00', '', '', 0, '', ''),
(16, 'Николай', 'Петров', 'Иванович', '2014-02-06', 'male', 'Улан-Удэ', 0, '', ''),
(17, 'Дмитрий', 'Залуцкий', 'Андреевич', '2014-02-04', 'male', 'Улан-Удэ', 3, '', '66543567890'),
(18, 'Алексей', 'Bold', '', '0000-00-00', '', '', 0, '', ''),
(19, 'Bon', 'Asdf', '', '0000-00-00', '', '', 0, '', ''),
(20, 'Nil', 'Asdinger', '', '0000-00-00', '', '', 0, '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `userset`
--

CREATE TABLE IF NOT EXISTS `userset` (
  `userset_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`userset_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Дамп данных таблицы `userset`
--

INSERT INTO `userset` (`userset_id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(24),
(25),
(26),
(27),
(28),
(29),
(30),
(31),
(32),
(33),
(34),
(35),
(36),
(37),
(38),
(39),
(40),
(41),
(42),
(43),
(44),
(45),
(46),
(47),
(48),
(49),
(50),
(51),
(52),
(53),
(54),
(55),
(56),
(57);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `user_group`
--
CREATE TABLE IF NOT EXISTS `user_group` (
`user_group_messagegroup_id` int(11)
,`user_group_user_id` int(11)
);
-- --------------------------------------------------------

--
-- Структура таблицы `user_group2`
--
-- используется(#1356 - View 'portal_olimp.user_group2' references invalid table(s) or column(s) or function(s) or definer/invoker of view lack rights to use them)
-- Ошибка считывания данных: (#1356 - View 'portal_olimp.user_group2' references invalid table(s) or column(s) or function(s) or definer/invoker of view lack rights to use them)

-- --------------------------------------------------------

--
-- Структура таблицы `user_mg_read`
--

CREATE TABLE IF NOT EXISTS `user_mg_read` (
  `user_mg_read_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_mg_read_user` int(11) DEFAULT NULL,
  `user_mg_read_mg` int(11) DEFAULT NULL,
  `user_mg_read_last_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_mg_read_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=119 ;

--
-- Дамп данных таблицы `user_mg_read`
--

INSERT INTO `user_mg_read` (`user_mg_read_id`, `user_mg_read_user`, `user_mg_read_mg`, `user_mg_read_last_date`) VALUES
(35, 17, 10, '2014-02-13 13:54:14'),
(2, 17, 7, '2014-02-21 07:35:28'),
(99, 19, 32, '2014-02-17 13:21:12'),
(4, 16, 1, '2014-01-11 09:12:58'),
(95, 15, 16, '2014-02-17 10:42:41'),
(103, 16, 5, '2014-02-18 10:43:04'),
(116, 19, 38, '2014-02-19 00:23:38'),
(111, 17, 37, '2014-02-18 23:10:15'),
(114, 17, 38, '2014-02-19 10:36:10'),
(113, 16, 38, '2014-02-19 00:23:38'),
(112, 15, 38, '2014-02-19 00:23:38'),
(110, 16, 36, '2014-02-18 10:35:31'),
(107, 16, 34, '2014-02-18 11:18:51'),
(106, 17, 34, '2014-02-18 11:19:06'),
(15, 18, 6, '2014-02-12 02:54:07'),
(16, 19, 6, '2014-02-12 02:54:07'),
(34, 17, 8, '2014-02-13 10:57:07'),
(18, 18, 7, '2014-02-12 02:54:21'),
(19, 19, 7, '2014-02-12 02:54:21'),
(20, 17, 9, '2014-02-13 09:45:23'),
(21, 16, 8, '2014-02-14 05:52:33'),
(22, 16, 8, '2014-02-14 05:52:33'),
(23, 16, 8, '2014-02-14 05:52:33'),
(24, 16, 8, '2014-02-14 05:52:33'),
(25, 16, 8, '2014-02-14 05:52:33'),
(26, 20, 8, '2014-02-13 09:49:04'),
(36, 17, 12, '2014-02-13 13:56:49'),
(37, 17, 13, '2014-02-13 13:56:52'),
(38, 17, 14, '2014-02-13 13:58:52'),
(39, 17, 15, '2014-02-18 10:31:24'),
(40, 18, 15, '2014-02-13 14:02:45'),
(41, 16, 15, '2014-02-18 10:34:04'),
(42, 17, 16, '2014-02-17 10:42:58'),
(43, 17, 17, '2014-02-14 04:26:52'),
(44, 15, 3, '2014-02-14 04:36:49'),
(45, 16, 3, '2014-02-18 10:15:33'),
(47, 15, 3, '2014-02-14 04:37:20'),
(102, 17, 8, '2014-02-18 10:05:33'),
(115, 18, 38, '2014-02-19 00:23:38'),
(50, 15, 5, '2014-02-14 05:52:08'),
(51, 16, 18, '2014-02-14 07:32:57'),
(52, 17, 18, '2014-02-14 10:59:06'),
(53, 1, 21, '2014-02-14 11:02:44'),
(54, 0, 21, '2014-02-14 11:02:44'),
(55, 17, 21, '2014-02-14 11:16:15'),
(56, 1, 22, '2014-02-14 11:03:30'),
(57, 0, 22, '2014-02-14 11:03:30'),
(58, 1, 23, '2014-02-14 11:05:28'),
(59, 0, 23, '2014-02-14 11:05:28'),
(60, 17, 23, '2014-02-14 11:05:33'),
(61, 17, 23, '2014-02-14 11:05:33'),
(62, 17, 23, '2014-02-14 11:05:33'),
(63, 17, 24, '2014-02-14 11:06:41'),
(64, 17, 25, '2014-02-14 11:06:44'),
(65, 17, 26, '2014-02-14 11:21:08'),
(66, 17, 27, '2014-02-14 11:07:00'),
(67, 17, 20, '2014-02-14 11:08:26'),
(68, 17, 28, '2014-02-14 11:08:59'),
(69, 17, 29, '2014-02-14 11:10:22'),
(70, 17, 30, '2014-02-14 11:20:24'),
(71, 16, 30, '2014-02-14 11:11:46'),
(72, 15, 30, '2014-02-14 11:11:48'),
(74, 17, 21, '2014-02-14 11:16:15'),
(75, 1, 23, '2014-02-14 11:16:52'),
(76, 0, 23, '2014-02-14 11:16:52'),
(88, 17, 26, '2014-02-14 11:21:08'),
(90, 17, 21, '2014-02-14 11:22:32'),
(91, 17, 22, '2014-02-18 10:42:57'),
(96, 17, 16, '2014-02-17 10:42:58'),
(94, 17, 1, '2014-02-15 02:56:48'),
(100, 17, 32, '2014-02-17 13:21:12'),
(117, 20, 38, '2014-02-19 00:23:38'),
(118, 0, 38, '2014-02-19 01:32:26');

-- --------------------------------------------------------

--
-- Структура таблицы `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `user_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_status_name` varchar(15) NOT NULL,
  PRIMARY KEY (`user_status_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `user_role`
--

INSERT INTO `user_role` (`user_status_id`, `user_status_name`) VALUES
(1, 'pmg_admin'),
(2, 'pmg_partner');

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
(0, 1, 0),
(16, 1, 1),
(16, 6, 1),
(18, 7, 1),
(19, 7, 1),
(18, 7, 1),
(19, 7, 1),
(18, 7, 1),
(19, 7, 1),
(17, 8, 1),
(18, 8, 1),
(19, 8, 1),
(17, 9, 1),
(16, 9, 1),
(20, 9, 1),
(17, 16, 1),
(18, 16, 1),
(16, 16, 1),
(17, 17, 2),
(17, 18, 1),
(16, 4, 1),
(15, 4, 1),
(15, 6, 1),
(16, 19, 1),
(17, 19, 7),
(17, 21, 1),
(17, 22, 5),
(17, 23, 5),
(15, 17, 6),
(19, 47, 6),
(17, 47, 5),
(17, 52, 5),
(17, 53, 6),
(18, 53, 6),
(16, 54, 6),
(18, 54, 6),
(16, 52, 6),
(15, 56, 7),
(16, 56, 7),
(17, 56, 7),
(18, 56, 7),
(19, 56, 7),
(20, 56, 7),
(0, 57, 0),
(17, 1, 1),
(17, 57, 1);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `visit`
--
CREATE TABLE IF NOT EXISTS `visit` (
`visit_id` int(11)
,`visit_user` int(11)
,`visit_group` int(11)
,`visit_datetime` timestamp
,`visit_count_message` bigint(21)
);
-- --------------------------------------------------------

--
-- Структура для представления `rule`
--
DROP TABLE IF EXISTS `rule`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rule` AS select `event`.`event_id` AS `obj_id`,`user_userset`.`user_userset_user_id` AS `user_id`,`user_userset`.`user_userset_userset_id` AS `userset_id`,`user_userset`.`user_userset_rule_id` AS `rule_id`,2 AS `obj_type` from (`event` join `user_userset`) where (`user_userset`.`user_userset_userset_id` = `event`.`event_userset_id`) union all select `messagegroup`.`messagegroup_id` AS `obj_id`,`user_userset`.`user_userset_user_id` AS `user_id`,`user_userset`.`user_userset_userset_id` AS `userset_id`,`user_userset`.`user_userset_rule_id` AS `rule_id`,1 AS `obj_type` from (`messagegroup` join `user_userset`) where (`user_userset`.`user_userset_userset_id` = `messagegroup`.`messagegroup_partners`);

-- --------------------------------------------------------

--
-- Структура для представления `status`
--
DROP TABLE IF EXISTS `status`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `status` AS select `messagegroup`.`messagegroup_id` AS `obj_id`,`messagegroup`.`messagegroup_status` AS `obj_status`,1 AS `obj_type` from `messagegroup` union all select `event`.`event_id` AS `obj_id`,`event`.`event_status` AS `obj_status`,2 AS `obj_type` from `event`;

-- --------------------------------------------------------

--
-- Структура для представления `user_group`
--
DROP TABLE IF EXISTS `user_group`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_group` AS select `messagegroup`.`messagegroup_id` AS `user_group_messagegroup_id`,`user_userset`.`user_userset_user_id` AS `user_group_user_id` from (`messagegroup` join `user_userset`) where (`messagegroup`.`messagegroup_partners` = `user_userset`.`user_userset_userset_id`);

-- --------------------------------------------------------

--
-- Структура для представления `visit`
--
DROP TABLE IF EXISTS `visit`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `visit` AS select `b`.`user_mg_read_id` AS `visit_id`,`b`.`user_mg_read_user` AS `visit_user`,`b`.`user_mg_read_mg` AS `visit_group`,`b`.`user_mg_read_last_date` AS `visit_datetime`,count(`a`.`message_id`) AS `visit_count_message` from (`user_mg_read` `b` left join `message` `a` on(((`a`.`message_group` = `b`.`user_mg_read_mg`) and (`b`.`user_mg_read_last_date` < `a`.`message_date`)))) group by `b`.`user_mg_read_mg`,`b`.`user_mg_read_user`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
