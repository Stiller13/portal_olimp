-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 13 2014 г., 18:18
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_message`(IN `text_message` TEXT, IN `id_user` INT, IN `id_group` INT, IN `id_message` INT, IN `status_message` INT, OUT `id` INT)
    NO SQL
BEGIN
	START TRANSACTION;
	INSERT INTO message (message_text, message_user, message_group, message_message, message_status) VALUES (text_message, id_user, id_group, id_message, status_message);
	SET id=LAST_INSERT_ID();
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_messagegroup`(IN `type_mg` INT, IN `status_mg` INT, OUT `id` INT)
    NO SQL
BEGIN
	CALL insert_userset(@k);
    INSERT INTO messagegroup (messagegroup_partners, messagegroup_type, messagegroup_status) VALUES (@k, type_mg, status_mg);
	SET id=LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_userset`(OUT `id` INT)
    NO SQL
BEGIN
START TRANSACTION;
INSERT INTO userset(userset_id) value (NULL);
SET id=LAST_INSERT_ID();
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_user_userset`(IN `id_user` INT, IN `id_userset` INT, IN `id_rule` INT)
    NO SQL
BEGIN
    INSERT INTO user_userset (user_userset_user_id, user_userset_userset_id, user_userset_rule_id) VALUES (id_user, id_userset, id_rule);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_visit`(IN `id_user` INT, IN `id_group` INT)
    NO SQL
BEGIN
	START TRANSACTION;
    INSERT INTO `user_mg_read` (`user_mg_read_user`,`user_mg_read_mg`) VALUES (id_user, id_group);
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_message`(IN `text_m` TEXT, IN `status_m` INT, IN `id_m` INT)
    NO SQL
BEGIN
	START TRANSACTION;
	UPDATE message SET message_text = text_m, message_status = status_m WHERE message_id = id_m;
	COMMIT;
	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_messagegroup`(IN `status_mg` INT, IN `id_mg` INT)
    NO SQL
BEGIN
    UPDATE messagegroup SET messagegroup_status = status_mg WHERE messagegroup_id = id_mg;	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_user`(IN `name` VARCHAR(25) CHARSET utf8, IN `surname` VARCHAR(25) CHARSET utf8, IN `patronymic` VARCHAR(25) CHARSET utf8, IN `birthday` DATE, IN `residence` VARCHAR(50) CHARSET utf8, IN `gender` VARCHAR(6) CHARSET utf8, IN `mail` VARCHAR(32) CHARSET utf8, IN `telephone` VARCHAR(11) CHARSET utf8, IN `id` INT)
    NO SQL
BEGIN
START TRANSACTION;
UPDATE `user` SET `user_name`=name, `user_surname`=surname, `user_patronymic`=patronymic, `user_date`=birthday, `user_residence`=residence, `user_gender`=gender, `user_mail`=mail, `user_telephone`=telephone WHERE `user_id`=id;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_user_userset`(IN `id_user` INT, IN `id_userset` INT, IN `id_rule` INT)
    NO SQL
BEGIN
    UPDATE user_userset SET user_userset_rule_id = id_rule WHERE user_userset_userset_id = id_userset AND user_userset_user_id = id_user;	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_visit`(IN `id_user` INT, IN `id_group` INT)
    NO SQL
BEGIN
    UPDATE `user_mg_read`  SET user_mg_read_last_date=NULL WHERE user_mg_read_user=id_user AND user_mg_read_mg=id_group;
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `event`
--

INSERT INTO `event` (`event_id`, `event_title`, `event_description_public`, `event_description_private`, `event_type`, `event_confirm`, `event_confirm_description`, `event_userset_id`, `event_messagegroup_id`, `event_status`) VALUES
(1, 'even_changed', 'public', 'private', 'closed', 1, 'qqwe', 1, 1, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

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
(8, '1', '2014-02-11 05:49:02', 17, 1, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `messagegroup`
--

CREATE TABLE IF NOT EXISTS `messagegroup` (
  `messagegroup_id` int(11) NOT NULL AUTO_INCREMENT,
  `messagegroup_partners` int(11) NOT NULL,
  `messagegroup_type` int(11) NOT NULL,
  `messagegroup_status` int(11) NOT NULL,
  PRIMARY KEY (`messagegroup_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `messagegroup`
--

INSERT INTO `messagegroup` (`messagegroup_id`, `messagegroup_partners`, `messagegroup_type`, `messagegroup_status`) VALUES
(1, 2, 1, 1),
(2, 3, 1, 1),
(3, 4, 1, 1),
(4, 5, 1, 1),
(5, 6, 1, 1),
(6, 7, 1, 1),
(7, 8, 1, 1),
(8, 9, 1, 1);

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
(16, 'kol', '2312', '332', '0000-00-00', '', '', 0, '', ''),
(17, 'dim', 'zal', 'andr', '2014-02-04', '', '', 0, '', '3434'),
(18, 'aaaa', '', '', '0000-00-00', '', '', 0, '', ''),
(19, 'sss', '', '', '0000-00-00', '', '', 0, '', ''),
(20, 'ddddd', '', '', '0000-00-00', '', '', 0, '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `userset`
--

CREATE TABLE IF NOT EXISTS `userset` (
  `userset_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`userset_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

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
(9);

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
-- Дублирующая структура для представления `user_group2`
--
CREATE TABLE IF NOT EXISTS `user_group2` (
`user_id` int(11)
,`user_name` varchar(25)
,`user_surname` varchar(25)
,`user_patronymic` varchar(25)
,`user_date` date
,`user_gender` varchar(6)
,`user_residence` varchar(50)
,`user_role` int(11)
,`user_mail` varchar(32)
,`user_telephone` varchar(11)
,`messagegroup_id` int(11)
);
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Дамп данных таблицы `user_mg_read`
--

INSERT INTO `user_mg_read` (`user_mg_read_id`, `user_mg_read_user`, `user_mg_read_mg`, `user_mg_read_last_date`) VALUES
(1, 17, 1, '2014-02-12 03:05:00'),
(2, 17, 7, '2014-02-12 02:54:26'),
(3, 17, 3, '2014-02-12 02:53:59'),
(4, 16, 1, '2014-01-11 09:12:58'),
(5, 17, 4, '2014-02-12 02:54:10'),
(6, 17, 5, '2014-02-12 02:54:03'),
(7, 16, 5, '2014-02-11 09:20:55'),
(8, 17, 6, '2014-02-12 02:54:07'),
(9, 16, 6, '2014-02-11 09:27:37'),
(10, 18, 6, '2014-02-11 09:27:37'),
(11, 19, 6, '2014-02-11 09:27:37'),
(12, 16, 6, '2014-02-12 02:53:24'),
(13, 18, 6, '2014-02-12 02:53:24'),
(14, 19, 6, '2014-02-12 02:53:24'),
(15, 18, 6, '2014-02-12 02:54:07'),
(16, 19, 6, '2014-02-12 02:54:07'),
(17, 17, 8, '2014-02-12 02:54:12'),
(18, 18, 7, '2014-02-12 02:54:21'),
(19, 19, 7, '2014-02-12 02:54:21');

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
(17, 2, 1),
(17, 4, 1),
(17, 5, 1),
(17, 5, 1),
(17, 6, 1),
(17, 7, 1),
(16, 1, 1),
(16, 6, 1),
(16, 7, 1),
(18, 7, 1),
(19, 7, 1),
(16, 7, 1),
(18, 7, 1),
(19, 7, 1),
(18, 7, 1),
(19, 7, 1),
(17, 8, 1),
(18, 8, 1),
(19, 8, 1);

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
-- Структура для представления `user_group2`
--
DROP TABLE IF EXISTS `user_group2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_group2` AS select `user`.`user_id` AS `user_id`,`user`.`user_name` AS `user_name`,`user`.`user_surname` AS `user_surname`,`user`.`user_patronymic` AS `user_patronymic`,`user`.`user_date` AS `user_date`,`user`.`user_gender` AS `user_gender`,`user`.`user_residence` AS `user_residence`,`user`.`user_role` AS `user_role`,`user`.`user_mail` AS `user_mail`,`user`.`user_telephone` AS `user_telephone`,`user_group`.`user_group_messagegroup_id` AS `messagegroup_id` from (`user` join `user_group`) where (`user`.`user_id` = `user_group`.`user_group_user_id`);

-- --------------------------------------------------------

--
-- Структура для представления `visit`
--
DROP TABLE IF EXISTS `visit`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `visit` AS select `b`.`user_mg_read_id` AS `visit_id`,`b`.`user_mg_read_user` AS `visit_user`,`b`.`user_mg_read_mg` AS `visit_group`,`b`.`user_mg_read_last_date` AS `visit_datetime`,count(`a`.`message_id`) AS `visit_count_message` from (`user_mg_read` `b` left join `message` `a` on(((`a`.`message_group` = `b`.`user_mg_read_mg`) and (`b`.`user_mg_read_last_date` < `a`.`message_date`)))) group by `b`.`user_mg_read_mg`,`b`.`user_mg_read_user`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
