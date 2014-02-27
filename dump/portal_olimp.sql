-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 27 2014 г., 23:34
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

-- --------------------------------------------------------

--
-- Структура таблицы `user_userset`
--

CREATE TABLE IF NOT EXISTS `user_userset` (
  `user_userset_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_userset_user_id` int(11) NOT NULL,
  `user_userset_userset_id` int(11) NOT NULL,
  `user_userset_rule_id` int(11) NOT NULL,
  PRIMARY KEY (`user_userset_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `user_userset`
--

INSERT INTO `user_userset` (`user_userset_id`, `user_userset_user_id`, `user_userset_userset_id`, `user_userset_rule_id`) VALUES
(1, 17, 10, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
