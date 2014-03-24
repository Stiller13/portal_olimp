-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 24 2014 г., 00:14
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
    COMMENT 'Очистка таблиц для тестов'
BEGIN
TRUNCATE event;
TRUNCATE event_file;
TRUNCATE event_mg;
TRUNCATE event_user;
TRUNCATE file;
TRUNCATE message;
TRUNCATE messagegroup;
TRUNCATE messagegroup_user;
TRUNCATE message_file;
TRUNCATE post;
TRUNCATE post_user;
TRUNCATE user_file;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_event`(IN `title` VARCHAR(100) CHARSET utf8, IN `description_public` TEXT CHARSET utf8, IN `description_private` TEXT CHARSET utf8, IN `type` VARCHAR(10) CHARSET utf8, IN `confirm` BOOLEAN, IN `confirm_description` VARCHAR(100) CHARSET utf8, IN `groups` TEXT CHARSET utf8, IN `files` TEXT CHARSET utf8, IN `status` INT, OUT `id` INT)
    NO SQL
BEGIN
	START TRANSACTION;
	INSERT INTO event(event_title, event_description_public, event_description_private, event_type, event_confirm, event_confirm_description, event_status) VALUES (title, description_public, description_private, type, confirm, confirm_description, status);
	SET id=LAST_INSERT_ID();
	CALL insert_event_mg(groups, id);
	CALL insert_event_file(files, id);
	COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_event_file`(IN `mylist` TEXT CHARSET utf8, IN `id_event` INT)
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
    INSERT INTO `event_file` (`event_file_file`, `event_file_event`) VALUES (@saHead, id_event);
  END WHILE;
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_event_mg`(IN `mylist` TEXT, IN `id_event` INT)
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
    INSERT INTO `event_mg` (`event_mg_group`,`event_mg_event`) VALUES (@saHead, id_event);
  END WHILE;
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_event_user`(IN `id_user` INT, IN `id_event` INT, IN `id_rule` INT, IN `id_file` INT)
    NO SQL
BEGIN
	DECLARE id int;
	START TRANSACTION;
	SET id = (SELECT `event_user_id` FROM `event_user` WHERE `event_user_user` = id_user AND `event_user_event` = id_event);
	IF id > 0 THEN
		UPDATE `event_user` SET `event_user_file` = id_file, `event_user_rule` = id_rule WHERE `event_user_id` = id;
	ELSE
		INSERT INTO `event_user`(`event_user_user`, `event_user_event`, `event_user_file`, `event_user_rule`) value (id_user, id_event, id_file, id_rule);
	END IF;
	COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_file`(IN `file_name` VARCHAR(100) CHARSET utf8, IN `file_code` VARCHAR(50) CHARSET utf8, IN `file_type` INT, IN `file_status` INT, OUT `id` INT)
    NO SQL
BEGIN
	START TRANSACTION;
    INSERT INTO `file`(`file_name`, `file_code`, `file_type`, `file_status`) VALUES (file_name, file_code, file_type, file_status);
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
    INSERT INTO messagegroup (messagegroup_type, messagegroup_status, messagegroup_desc) VALUES (type_mg, status_mg, desc_mg);
	SET id=LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_messagegroup_user`(IN `id_user` INT, IN `id_group` INT, IN `id_rule` INT)
    NO SQL
BEGIN
	DECLARE id_mgu int;
	START TRANSACTION;
	SET id_mgu = (SELECT `messagegroup_user_id` FROM `messagegroup_user` WHERE `messagegroup_user_user` = id_user AND `messagegroup_user_group` = id_group);

	IF id_mgu > 0  THEN
		UPDATE `messagegroup_user` SET `messagegroup_user_rule` = id_rule WHERE `messagegroup_user_id` = id_mgu;
	ELSE
	    INSERT INTO `messagegroup_user` (`messagegroup_user_user`, `messagegroup_user_group`, `messagegroup_user_rule`) VALUES (id_user, id_group, id_rule);
	END IF;
	COMMIT;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_post`(IN `id_post` INT(100), IN `title_post` VARCHAR(100) CHARSET utf8, IN `text_post` TEXT CHARSET utf8, IN `id_mg` INT, IN `status_post` INT, IN `type_post` INT, OUT `id` INT)
    NO SQL
BEGIN
	IF id_post > 0 THEN
		UPDATE `post` SET `post_title`  = title_post, `post_text` = text_post, `post_status` = status_post WHERE `post_id` = id_post;
		SET id = id_post;
	ELSE
		INSERT INTO `post`(`post_title`, `post_text`, `post_comment_mg`, `post_status`, `post_type`) VALUES (title_post, text_post, id_mg, status_post, type_post);
		SET id = LAST_INSERT_ID();
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_post_user`(IN `id_user` INT, IN `id_post` INT, IN `id_rule` INT, IN `ratio` INT)
    NO SQL
BEGIN
	DECLARE id int;
	START TRANSACTION;
	SET id = (SELECT `post_user_id` FROM `post_user` WHERE `post_user_user` = id_user AND `post_user_post` = id_post);
	IF id > 0 THEN
		UPDATE `post_user` SET `post_user_ratio` = ratio, `post_user_rule` = id_rule WHERE `post_user_id` = id;
	ELSE
		INSERT INTO `post_user`(`post_user_user`, `post_user_post`, `post_user_ratio`, `post_user_rule`) value (id_user, id_post, ratio, id_rule);
	END IF;
	COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_role`(IN `id_user` INT, IN `id_role` INT, OUT `id` INT)
    NO SQL
BEGIN
	DECLARE idd int;
	START TRANSACTION;
	SET idd = (SELECT `role_id` FROM `role` WHERE `role_user` = id_user AND `role_role` = id_role);
	IF idd > 0 THEN
		SET id = idd;
	ELSE
		INSERT INTO `role`(`role_user`, `role_role`) VALUES (id_user, id_role);
		SET id = LAST_INSERT_ID();
	END IF;
	COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_user_file`(IN `id_user` INT, IN `id_file` INT)
    NO SQL
BEGIN
	INSERT INTO `user_file` (`user_file_user`,`user_file_file`) VALUES (id_user, id_file);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_account`(IN `login` VARCHAR(25), IN `password` VARCHAR(40) CHARSET utf8, IN `salt` VARCHAR(255) CHARSET utf8)
    NO SQL
BEGIN
START TRANSACTION;
UPDATE `account` SET `account_password`=password, `account_salt`=salt WHERE `account_login`=login;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_event`(IN `title` VARCHAR(100) CHARSET utf8, IN `desc_publ` TEXT CHARSET utf8, IN `desc_priv` TEXT CHARSET utf8, IN `type` VARCHAR(10) CHARSET utf8, IN `confirm` BOOLEAN, IN `confirm_desc` VARCHAR(100) CHARSET utf8, IN `groups` TEXT CHARSET utf8, IN `files` TEXT CHARSET utf8, IN `status` INT, IN `e_id` INT)
    NO SQL
BEGIN
	START TRANSACTION;
	UPDATE `event` SET `event_title`=title, `event_description_public`=desc_publ,`event_description_private`=desc_priv, `event_type`=type, `event_confirm`=confirm, `event_confirm_description`=confirm_desc, `event_status`=status WHERE `event_id`=e_id;
	DELETE FROM `event_mg` WHERE `event_mg_event` = e_id;
	CALL insert_event_mg(groups, e_id);
	DELETE FROM `event_file` WHERE `event_file_event` = e_id;
	CALL insert_event_file(files, e_id);
	COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_message`(IN `text_m` TEXT, IN `status_m` INT, IN `id_m` INT)
    NO SQL
BEGIN
	START TRANSACTION;
	UPDATE message SET message_text = text_m, message_status = status_m WHERE message_id = id_m;
	COMMIT;
	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_messagegroup`(IN `desc_mg` VARCHAR(100) CHARSET utf8, IN `status_mg` INT, IN `id_mg` INT)
    NO SQL
BEGIN
    UPDATE messagegroup SET messagegroup_status = status_mg, messagegroup_desc = desc_mg WHERE messagegroup_id = id_mg;	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_messagegroup_user`(IN `id_user` INT, IN `id_group` INT)
    NO SQL
BEGIN
	UPDATE `messagegroup_user` SET `messagegroup_user_date` = NULL WHERE `messagegroup_user_user` = id_user AND `messagegroup_user_group` = id_group;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_user`(IN `name` VARCHAR(25) CHARSET utf8, IN `surname` VARCHAR(25) CHARSET utf8, IN `patronymic` VARCHAR(25) CHARSET utf8, IN `birthday` DATE, IN `residence` VARCHAR(50) CHARSET utf8, IN `gender` VARCHAR(6) CHARSET utf8, IN `mail` VARCHAR(32) CHARSET utf8, IN `telephone` VARCHAR(11) CHARSET utf8, IN `status` INT, IN `id` INT)
    NO SQL
BEGIN
	START TRANSACTION;
	UPDATE `user` SET `user_name`=name, `user_surname`=surname, `user_patronymic`=patronymic, `user_date`=birthday, `user_residence`=residence, `user_gender`=gender, `user_mail`=mail, `user_telephone`=telephone, `user_status` = status WHERE `user_id`=id;
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Дамп данных таблицы `account`
--

INSERT INTO `account` (`account_id`, `account_login`, `account_password`, `account_salt`) VALUES
(15, 'qwe', '26e48a2f89e8b948eb7aa0c444b3c9e9240ea28d', '#pkc$3ort~brt'),
(16, 'tom', 'f9ee1af57ba88fe3612922e209bdce2649027eb1', '_3k*k*pt&gg+e'),
(17, 'dim', '5e35c69583248f72d56c9643f97f43c2016ba39a', '#m+n28h+r*2ejs'),
(18, 'dim2', '203b306a46e1a296bfbf2d5a237d9708b471f070', '5%hc#nv_jl$!q'),
(19, 'fffaf', '2222231', 'dadsad'),
(20, 'qqq', 'f29e05566dbf26107dede7ffe71cd29032929cb1', 'dl6w%xt8yi6z3'),
(21, 'admin', '74f123b3aa8a73ad89e336696a68eb82934bd708', 'm8!e##5r%l*1i');

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
-- Структура таблицы `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_title` varchar(255) NOT NULL,
  `event_description_public` text NOT NULL,
  `event_description_private` text NOT NULL,
  `event_type` int(11) NOT NULL,
  `event_confirm` tinyint(1) NOT NULL,
  `event_confirm_description` text NOT NULL,
  `event_status` int(11) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `event_file`
--

CREATE TABLE IF NOT EXISTS `event_file` (
  `event_file_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_file_event` int(11) NOT NULL,
  `event_file_file` int(11) NOT NULL,
  PRIMARY KEY (`event_file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `event_mg`
--

CREATE TABLE IF NOT EXISTS `event_mg` (
  `event_mg_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_mg_event` int(11) NOT NULL,
  `event_mg_group` int(11) NOT NULL,
  PRIMARY KEY (`event_mg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `event_user`
--

CREATE TABLE IF NOT EXISTS `event_user` (
  `event_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_user_user` int(11) NOT NULL,
  `event_user_event` int(11) NOT NULL,
  `event_user_rule` int(11) NOT NULL,
  `event_user_file` int(11) NOT NULL,
  PRIMARY KEY (`event_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `file_code` varchar(255) NOT NULL,
  `file_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `file_type` int(11) NOT NULL,
  `file_status` int(11) NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `file`
--

INSERT INTO `file` (`file_id`, `file_name`, `file_code`, `file_date`, `file_type`, `file_status`) VALUES
(2, 'Безымянный.png', '7135905e759008a2201d488467aa9f28', '2014-03-22 07:54:21', 200, 201);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`message_id`, `message_text`, `message_date`, `message_user`, `message_group`, `message_message`, `message_status`) VALUES
(1, '1', '2014-03-22 07:51:30', 17, 1, 0, 201),
(2, '2', '2014-03-22 07:51:44', 17, 1, 0, 201),
(3, '2', '2014-03-22 07:53:04', 17, 1, 0, 201),
(4, '2', '2014-03-22 07:53:39', 17, 1, 0, 201),
(5, '2', '2014-03-22 07:54:21', 17, 1, 0, 201);

-- --------------------------------------------------------

--
-- Структура таблицы `messagegroup`
--

CREATE TABLE IF NOT EXISTS `messagegroup` (
  `messagegroup_id` int(11) NOT NULL AUTO_INCREMENT,
  `messagegroup_type` int(11) NOT NULL,
  `messagegroup_status` int(11) NOT NULL,
  `messagegroup_desc` varchar(100) NOT NULL,
  PRIMARY KEY (`messagegroup_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `messagegroup`
--

INSERT INTO `messagegroup` (`messagegroup_id`, `messagegroup_type`, `messagegroup_status`, `messagegroup_desc`) VALUES
(1, 4, 201, ''),
(2, 5, 1, 'Комментарии для новости'),
(3, 5, 1, 'Комментарии для новости');

-- --------------------------------------------------------

--
-- Структура таблицы `messagegroup_user`
--

CREATE TABLE IF NOT EXISTS `messagegroup_user` (
  `messagegroup_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `messagegroup_user_group` int(11) NOT NULL,
  `messagegroup_user_user` int(11) NOT NULL,
  `messagegroup_user_rule` int(11) NOT NULL,
  `messagegroup_user_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`messagegroup_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `messagegroup_user`
--

INSERT INTO `messagegroup_user` (`messagegroup_user_id`, `messagegroup_user_group`, `messagegroup_user_user`, `messagegroup_user_rule`, `messagegroup_user_date`) VALUES
(1, 1, 17, 5, '2014-03-22 09:24:18'),
(2, 1, 19, 6, '2014-03-22 07:51:26');

-- --------------------------------------------------------

--
-- Структура таблицы `message_file`
--

CREATE TABLE IF NOT EXISTS `message_file` (
  `message_file_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  PRIMARY KEY (`message_file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `message_file`
--

INSERT INTO `message_file` (`message_file_id`, `file_id`, `message_id`) VALUES
(1, 2, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` varchar(100) COLLATE utf8_bin NOT NULL,
  `post_text` text COLLATE utf8_bin NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_comment_mg` int(11) NOT NULL,
  `post_status` int(11) NOT NULL,
  `post_type` int(11) NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `post`
--

INSERT INTO `post` (`post_id`, `post_title`, `post_text`, `post_date`, `post_comment_mg`, `post_status`, `post_type`) VALUES
(1, 'Это первая новость', '<p style="text-align: center;">йййцуцйуйцуфывфывфывфыв</p>', '2014-03-22 09:24:42', 2, 1, 10),
(2, 'Эталонная модель взаимодействия открытых систем', '<p style="text-align: center;">В соответствии с моделью OSI выделяются следующие иерархические уровни (см. <br />рис. 1.13): физический (Physical); канальный (Data Link); сетевой (Network); <br />транспортный (Transport); сеансовый (Session); уровень представления (Presentation); <br />прикладной (Application). <br /> В соответствии с эталонной моделью OSI эти уровни взаимодействуют так, как <br />показано на рис. 1.14. Таким образом, сложная задача обмена информацией между <br />компьютерами в сети разбивается на ряд относительно независимых и менее сложных <br />подзадач взаимодействия между соседними уровнями. Каждая такая подзадача <br />выполняется в соответствии с унифицированными правилами &ndash; протоколом <br />взаимодействия.</p>', '2014-03-23 15:46:06', 3, 1, 10);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `post_ratio_down`
--
CREATE TABLE IF NOT EXISTS `post_ratio_down` (
`post_id` int(11)
,`post_ratio_down` bigint(21)
);
-- --------------------------------------------------------

--
-- Дублирующая структура для представления `post_ratio_up`
--
CREATE TABLE IF NOT EXISTS `post_ratio_up` (
`post_id` int(11)
,`post_ratio_up` bigint(21)
);
-- --------------------------------------------------------

--
-- Структура таблицы `post_user`
--

CREATE TABLE IF NOT EXISTS `post_user` (
  `post_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_user_post` int(11) NOT NULL,
  `post_user_user` int(11) NOT NULL,
  `post_user_rule` int(11) NOT NULL,
  `post_user_ratio` int(11) NOT NULL,
  PRIMARY KEY (`post_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `post_user`
--

INSERT INTO `post_user` (`post_user_id`, `post_user_post`, `post_user_user`, `post_user_rule`, `post_user_ratio`) VALUES
(2, 1, 17, 9, -1),
(3, 1, 15, 10, 1),
(4, 1, 16, 10, 1),
(5, 2, 17, 9, 0);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `post_wratio`
--
CREATE TABLE IF NOT EXISTS `post_wratio` (
`post_id` int(11)
,`post_title` varchar(100)
,`post_text` text
,`post_date` timestamp
,`post_comment_mg` int(11)
,`post_status` int(11)
,`post_type` int(11)
,`post_ratio_up` bigint(21)
,`post_ratio_down` bigint(21)
);
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
-- Структура таблицы `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_user` int(11) NOT NULL,
  `role_role` int(11) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`role_id`, `role_user`, `role_role`) VALUES
(3, 21, 404),
(4, 17, 2);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `rule`
--
CREATE TABLE IF NOT EXISTS `rule` (
`obj_id` int(11)
,`user_id` int(11)
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_surname`, `user_patronymic`, `user_date`, `user_gender`, `user_residence`, `user_status`, `user_mail`, `user_telephone`) VALUES
(15, 'Feed', 'Stret', '', '0000-00-00', '', '', 0, '', ''),
(16, 'Николай', 'Петров', 'Иванович', '2014-02-06', 'male', 'Улан-Удэ', 0, '', ''),
(17, 'Дмитрий', 'Залуцкий', 'Андреевич', '2014-02-04', 'male', 'Улан-Удэ', 3, '', '66543567890'),
(18, 'Алексей', 'Bold', '', '0000-00-00', '', '', 0, '', ''),
(19, 'Bon', 'Asdf', '', '0000-00-00', '', '', 0, '', ''),
(20, 'Nil', 'Asdinger', '', '0000-00-00', '', '', 0, '', ''),
(21, 'Адиминистратор', '', '', '0000-00-00', '', '', 0, '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `user_file`
--

CREATE TABLE IF NOT EXISTS `user_file` (
  `user_file_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_file_user` int(11) NOT NULL,
  `user_file_file` int(11) NOT NULL,
  PRIMARY KEY (`user_file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `visit1`
--
CREATE TABLE IF NOT EXISTS `visit1` (
`user_id` int(11)
,`group_id` int(11)
,`datetime` timestamp
,`count_message` bigint(21)
);
-- --------------------------------------------------------

--
-- Дублирующая структура для представления `visit2`
--
CREATE TABLE IF NOT EXISTS `visit2` (
`user_id` int(11)
,`type` int(11)
,`count_message` decimal(41,0)
);
-- --------------------------------------------------------

--
-- Дублирующая структура для представления `visit3`
--
CREATE TABLE IF NOT EXISTS `visit3` (
`user_id` int(11)
,`count_message` decimal(41,0)
);
-- --------------------------------------------------------

--
-- Структура для представления `post_ratio_down`
--
DROP TABLE IF EXISTS `post_ratio_down`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `post_ratio_down` AS select `post`.`post_id` AS `post_id`,count(`post_user`.`post_user_id`) AS `post_ratio_down` from (`post` left join `post_user` on(((`post`.`post_id` = `post_user`.`post_user_post`) and (`post_user`.`post_user_ratio` < 0))));

-- --------------------------------------------------------

--
-- Структура для представления `post_ratio_up`
--
DROP TABLE IF EXISTS `post_ratio_up`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `post_ratio_up` AS select `post`.`post_id` AS `post_id`,count(`post_user`.`post_user_id`) AS `post_ratio_up` from (`post` left join `post_user` on(((`post`.`post_id` = `post_user`.`post_user_post`) and (`post_user`.`post_user_ratio` > 0))));

-- --------------------------------------------------------

--
-- Структура для представления `post_wratio`
--
DROP TABLE IF EXISTS `post_wratio`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `post_wratio` AS select `post`.`post_id` AS `post_id`,`post`.`post_title` AS `post_title`,`post`.`post_text` AS `post_text`,`post`.`post_date` AS `post_date`,`post`.`post_comment_mg` AS `post_comment_mg`,`post`.`post_status` AS `post_status`,`post`.`post_type` AS `post_type`,`post_ratio_up`.`post_ratio_up` AS `post_ratio_up`,`post_ratio_down`.`post_ratio_down` AS `post_ratio_down` from ((`post` left join `post_ratio_up` on((`post`.`post_id` = `post_ratio_up`.`post_id`))) left join `post_ratio_down` on((`post`.`post_id` = `post_ratio_down`.`post_id`)));

-- --------------------------------------------------------

--
-- Структура для представления `rule`
--
DROP TABLE IF EXISTS `rule`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rule` AS select `event`.`event_id` AS `obj_id`,`event_user`.`event_user_user` AS `user_id`,`event_user`.`event_user_rule` AS `rule_id`,2 AS `obj_type` from (`event` join `event_user`) where (`event_user`.`event_user_event` = `event`.`event_id`) union all select `messagegroup`.`messagegroup_id` AS `obj_id`,`messagegroup_user`.`messagegroup_user_user` AS `user_id`,`messagegroup_user`.`messagegroup_user_rule` AS `rule_id`,1 AS `obj_type` from (`messagegroup` join `messagegroup_user`) where (`messagegroup_user`.`messagegroup_user_group` = `messagegroup`.`messagegroup_id`) union all select `post`.`post_id` AS `obj_id`,`post_user`.`post_user_user` AS `user_id`,`post_user`.`post_user_rule` AS `rule_id`,3 AS `obj_type` from (`post` join `post_user`) where (`post_user`.`post_user_post` = `post`.`post_id`);

-- --------------------------------------------------------

--
-- Структура для представления `status`
--
DROP TABLE IF EXISTS `status`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `status` AS select `messagegroup`.`messagegroup_id` AS `obj_id`,`messagegroup`.`messagegroup_status` AS `obj_status`,1 AS `obj_type` from `messagegroup` union all select `event`.`event_id` AS `obj_id`,`event`.`event_status` AS `obj_status`,2 AS `obj_type` from `event` union all select `post`.`post_id` AS `obj_id`,`post`.`post_status` AS `obj_status`,3 AS `obj_type` from `post`;

-- --------------------------------------------------------

--
-- Структура для представления `visit1`
--
DROP TABLE IF EXISTS `visit1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `visit1` AS select `b`.`messagegroup_user_user` AS `user_id`,`b`.`messagegroup_user_group` AS `group_id`,`b`.`messagegroup_user_date` AS `datetime`,count(`a`.`message_id`) AS `count_message` from (`messagegroup_user` `b` left join `message` `a` on(((`a`.`message_group` = `b`.`messagegroup_user_group`) and (`b`.`messagegroup_user_date` < `a`.`message_date`)))) group by `b`.`messagegroup_user_group`,`b`.`messagegroup_user_user`;

-- --------------------------------------------------------

--
-- Структура для представления `visit2`
--
DROP TABLE IF EXISTS `visit2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `visit2` AS select `a`.`user_id` AS `user_id`,`b`.`messagegroup_type` AS `type`,sum(`a`.`count_message`) AS `count_message` from (`visit1` `a` left join `messagegroup` `b` on((`a`.`group_id` = `b`.`messagegroup_id`))) group by `a`.`user_id`,`b`.`messagegroup_type`;

-- --------------------------------------------------------

--
-- Структура для представления `visit3`
--
DROP TABLE IF EXISTS `visit3`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `visit3` AS select `a`.`user_id` AS `user_id`,sum(`a`.`count_message`) AS `count_message` from `visit1` `a` group by `a`.`user_id`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
