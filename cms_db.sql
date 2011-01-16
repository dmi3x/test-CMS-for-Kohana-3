-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Янв 12 2011 г., 23:45
-- Версия сервера: 5.0.45
-- Версия PHP: 5.2.4
-- 
-- БД: `cms_db`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `config`
-- 

CREATE TABLE `config` (
  `group_name` varchar(128) character set utf8 NOT NULL,
  `config_key` varchar(128) character set utf8 NOT NULL,
  `config_value` text character set utf8,
  `name` varchar(255) character set utf8 default NULL,
  `description` varchar(255) character set utf8 default NULL,
  PRIMARY KEY  (`group_name`,`config_key`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `config`
-- 

INSERT INTO `config` VALUES ('db_main', 'sitename', 's:62:"Название сайта из конфига админки";', 'Sitename', '');
INSERT INTO `config` VALUES ('db_main', 'admin_pass', 's:3:"123";', 'Admin password', 'Used to enter the admin panel');
INSERT INTO `config` VALUES ('db_main', 'email', 's:0:"";', 'email', '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `news`
-- 

CREATE TABLE `news` (
  `id` int(11) NOT NULL auto_increment,
  `alias` varchar(100) NOT NULL,
  `date` int(10) NOT NULL,
  `dateAdd` int(10) NOT NULL,
  `structureId` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `news`
-- 

INSERT INTO `news` VALUES (1, 'zxczxc', 1294552800, 1294602172, 14);

-- --------------------------------------------------------

-- 
-- Структура таблицы `newsLocale`
-- 

CREATE TABLE `newsLocale` (
  `localeId` int(11) NOT NULL auto_increment,
  `newsId` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`localeId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `newsLocale`
-- 

INSERT INTO `newsLocale` VALUES (1, 1, 'ru', 'zxczxc', '<p>\n	xcvxcvxcv</p>\n');

-- --------------------------------------------------------

-- 
-- Структура таблицы `structure`
-- 

CREATE TABLE `structure` (
  `id` int(11) NOT NULL auto_increment,
  `parentId` int(11) NOT NULL,
  `folder` int(1) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `module` varchar(20) NOT NULL,
  `pos` int(11) NOT NULL,
  `dateAdd` int(10) NOT NULL,
  `hasChildren` int(1) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `parent_id` (`parentId`,`alias`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- 
-- Дамп данных таблицы `structure`
-- 

INSERT INTO `structure` VALUES (1, 0, 2, '', 'home', 0, 0, 0);
INSERT INTO `structure` VALUES (2, 0, 2, '404', 'err404', 2, 1291726549, 0);
INSERT INTO `structure` VALUES (15, 9, 0, 'chto-to-tam-eshe', 'page', 0, 1294607930, 0);
INSERT INTO `structure` VALUES (9, 0, 1, 'about-us', 'page', 0, 1291885557, 0);
INSERT INTO `structure` VALUES (14, 0, 2, 'news', 'news', 1, 1294601154, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `structureLocale`
-- 

CREATE TABLE `structureLocale` (
  `localeId` int(11) NOT NULL auto_increment,
  `structureId` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`localeId`),
  UNIQUE KEY `common_id` (`structureId`,`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- 
-- Дамп данных таблицы `structureLocale`
-- 

INSERT INTO `structureLocale` VALUES (1, 1, 'ru', 'Home', 'Сайт на CMS', 'Кейвордсы', 'Дескришпенсы', '<h1>\n	Внимание!</h1>\n<p>\n	Эта CMS на Kohana 3 предназначена для ознакомления, является лишь демонстрационным материалом реализации некоторых идей.</p>\n<p>\n	Крайне не рекомендуется использовать её для релизов, в том виде котором она есть на данный момент.</p>\n<p>\n	В этой версии CMS локализированн только контент из структуры.</p>\n<p>\n	Дла локализации надписей, сообщений и тп - пока что используйте стандартные средства Коханы, </p>\n<p>\n	в следующих версиях CMS предполагается полное управление локализацией из админки (есть наработки)</p>\n');
INSERT INTO `structureLocale` VALUES (3, 2, 'ru', 'Страница не найдена', '', '', '', '<h1>\n	Страница не найдена</h1>\n<p>\n	Что то пошло не так</p>\n');
INSERT INTO `structureLocale` VALUES (27, 15, 'ru', 'Что то там ещё', '', '', '', '<h1>\n	Что то там ещё</h1>\n');
INSERT INTO `structureLocale` VALUES (26, 2, 'en', 'Page not found', '', '', '', '<h1>\n	404 Error</h1>\n<div style="font-family: Arial, Verdana, sans-serif; font-size: 12px; color: rgb(34, 34, 34); background-color: rgb(255, 255, 255); font-weight: normal; ">\n	<p>\n		the page you are looking for was not found</p>\n</div>\n');
INSERT INTO `structureLocale` VALUES (23, 14, 'ru', 'Новости', '', '', '', '');
INSERT INTO `structureLocale` VALUES (10, 9, 'ru', 'О нас', '', '', '', '<h1>\n	О нас</h1>\n<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget justo in sapien condimentum blandit auctor at elit. Sed sed orci ac urna consequat commodo. Etiam nulla nunc, pellentesque sed vehicula ac, tempor at odio. Donec luctus odio ut lorem varius suscipit. Etiam non enim ac augue porttitor ullamcorper ac nec turpis. Sed tincidunt aliquet nulla ac congue. Aliquam sodales lectus ac sem tempor fringilla. Mauris quam sem, gravida eu scelerisque non, lobortis quis velit. Fusce ut purus urna, vitae elementum libero. Cras ut odio felis, auctor interdum enim.</p>\n<p>\n	Donec porttitor, libero id tempor lobortis, eros risus cursus nibh, ut tempus dolor purus accumsan ipsum. Phasellus vel quam arcu, nec laoreet enim. Phasellus quis velit libero. Phasellus blandit rhoncus luctus. Nam tortor velit, placerat vitae molestie non, blandit sit amet augue. Donec leo lacus, volutpat at interdum et, laoreet nec ligula. Fusce vel purus id purus fringilla bibendum a eget odio. Vivamus vitae tellus a ipsum facilisis adipiscing at quis elit. Duis egestas ligula non quam consectetur nec faucibus nibh iaculis. Fusce convallis pretium convallis. Vestibulum ut sagittis est. Pellentesque massa nulla, semper et posuere mattis, facilisis a augue. Donec egestas tristique orci at imperdiet. Donec lacinia, nibh eu viverra eleifend, velit elit commodo massa, ut placerat velit eros sit amet turpis. Quisque dapibus nunc ac orci lobortis nec facilisis leo dignissim. Etiam sollicitudin libero quis tortor sodales et laoreet neque ultrices. Proin ultrices condimentum nunc, in ullamcorper mauris facilisis eu. Suspendisse volutpat diam nec velit tincidunt convallis. Fusce blandit volutpat massa, quis aliquam orci iaculis non. Etiam molestie, nisl non scelerisque tempor, elit libero tincidunt neque, vel vestibulum orci justo et dui.</p>\n<p>\n	Cras nisl massa, aliquet non ornare commodo, pellentesque ac quam. Cras mattis venenatis accumsan. Nam vel velit feugiat tellus aliquam vulputate et a felis. Donec in porttitor purus. Duis ultrices mi eu risus fermentum iaculis. Aliquam sem nulla, condimentum eu porttitor at, convallis mollis ligula. Etiam bibendum mollis nibh et vehicula. Vivamus tristique mauris at nibh malesuada at adipiscing orci semper. Nullam tristique mauris vel elit consequat et pellentesque risus facilisis. Praesent ipsum justo, dictum placerat varius non, tincidunt vitae ante. In imperdiet nulla sit amet elit luctus porta. Integer ipsum leo, accumsan vitae ornare ut, lacinia quis leo. Sed risus nisl, feugiat sed auctor lacinia, fermentum a erat. Nulla tempus scelerisque tincidunt. Maecenas et arcu ut lectus sodales iaculis. Suspendisse potenti.</p>\n');
INSERT INTO `structureLocale` VALUES (24, 9, 'en', 'About us', '', '', '', '<h1>\n	About us</h1>\n<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget justo in sapien condimentum blandit auctor at elit. Sed sed orci ac urna consequat commodo. Etiam nulla nunc, pellentesque sed vehicula ac, tempor at odio. Donec luctus odio ut lorem varius suscipit. Etiam non enim ac augue porttitor ullamcorper ac nec turpis. Sed tincidunt aliquet nulla ac congue. Aliquam sodales lectus ac sem tempor fringilla. Mauris quam sem, gravida eu scelerisque non, lobortis quis velit. Fusce ut purus urna, vitae elementum libero. Cras ut odio felis, auctor interdum enim.</p>\n<p>\n	Donec porttitor, libero id tempor lobortis, eros risus cursus nibh, ut tempus dolor purus accumsan ipsum. Phasellus vel quam arcu, nec laoreet enim. Phasellus quis velit libero. Phasellus blandit rhoncus luctus. Nam tortor velit, placerat vitae molestie non, blandit sit amet augue. Donec leo lacus, volutpat at interdum et, laoreet nec ligula. Fusce vel purus id purus fringilla bibendum a eget odio. Vivamus vitae tellus a ipsum facilisis adipiscing at quis elit. Duis egestas ligula non quam consectetur nec faucibus nibh iaculis. Fusce convallis pretium convallis. Vestibulum ut sagittis est. Pellentesque massa nulla, semper et posuere mattis, facilisis a augue. Donec egestas tristique orci at imperdiet. Donec lacinia, nibh eu viverra eleifend, velit elit commodo massa, ut placerat velit eros sit amet turpis. Quisque dapibus nunc ac orci lobortis nec facilisis leo dignissim. Etiam sollicitudin libero quis tortor sodales et laoreet neque ultrices. Proin ultrices condimentum nunc, in ullamcorper mauris facilisis eu. Suspendisse volutpat diam nec velit tincidunt convallis. Fusce blandit volutpat massa, quis aliquam orci iaculis non. Etiam molestie, nisl non scelerisque tempor, elit libero tincidunt neque, vel vestibulum orci justo et dui.</p>\n<p>\n	Cras nisl massa, aliquet non ornare commodo, pellentesque ac quam. Cras mattis venenatis accumsan. Nam vel velit feugiat tellus aliquam vulputate et a felis. Donec in porttitor purus. Duis ultrices mi eu risus fermentum iaculis. Aliquam sem nulla, condimentum eu porttitor at, convallis mollis ligula. Etiam bibendum mollis nibh et vehicula. Vivamus tristique mauris at nibh malesuada at adipiscing orci semper. Nullam tristique mauris vel elit consequat et pellentesque risus facilisis. Praesent ipsum justo, dictum placerat varius non, tincidunt vitae ante. In imperdiet nulla sit amet elit luctus porta. Integer ipsum leo, accumsan vitae ornare ut, lacinia quis leo. Sed risus nisl, feugiat sed auctor lacinia, fermentum a erat. Nulla tempus scelerisque tincidunt. Maecenas et arcu ut lectus sodales iaculis. Suspendisse potenti.</p>\n');
INSERT INTO `structureLocale` VALUES (25, 1, 'en', 'Home', 'Site with CMS', 'Keywords', 'Description', '<h1>\n	Text from admin area</h1>\n<p>\n	test</p>\n');
