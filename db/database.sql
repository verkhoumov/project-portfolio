-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 18 2017 г., 02:01
-- Версия сервера: 5.6.33-79.0
-- Версия PHP: 5.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `u0037136_profile`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `code` varchar(20) DEFAULT NULL COMMENT 'Ссылка на категорию',
  `name` varchar(30) DEFAULT NULL COMMENT 'Название',
  `title` varchar(100) DEFAULT NULL COMMENT 'Текст, подставляющийся в заголовок',
  `description` varchar(200) DEFAULT NULL COMMENT 'Текст, подставляющийся в описание',
  `text` text COMMENT 'Описание'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Список категорий проектов';

-- --------------------------------------------------------

--
-- Структура таблицы `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `type` enum('default','social') NOT NULL DEFAULT 'default' COMMENT 'Тип контакта (обычная информация, социальная сеть)',
  `code` varchar(15) DEFAULT NULL COMMENT 'Кодовое имя для иконки из icons.css',
  `name` varchar(25) DEFAULT NULL COMMENT 'Название контакта',
  `link` varchar(100) DEFAULT NULL COMMENT 'Ссылка (если нужна)',
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Позиция в списке',
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Видимость на странице'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Контактная информация';

-- --------------------------------------------------------

--
-- Структура таблицы `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `type` enum('doc','pdf','xls','ppt','txt') DEFAULT NULL COMMENT 'Тип документа',
  `name` varchar(100) DEFAULT NULL COMMENT 'Название',
  `link` varchar(100) DEFAULT NULL COMMENT 'Ссылка',
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Видимость'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Список документов';

-- --------------------------------------------------------

--
-- Структура таблицы `education`
--

CREATE TABLE IF NOT EXISTS `education` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `name` varchar(25) DEFAULT NULL COMMENT 'Название ВУЗа',
  `faculty` varchar(75) DEFAULT NULL COMMENT 'Факультет',
  `specialization` varchar(75) DEFAULT NULL COMMENT 'Специализация/направление',
  `city` varchar(50) DEFAULT NULL COMMENT 'Местоположение ВУЗа',
  `image` varchar(100) DEFAULT NULL COMMENT 'Логотип ВУЗа (папка /upload/education)',
  `created` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата добавления информации',
  `started` date DEFAULT NULL COMMENT 'Начало обучение',
  `finished` date DEFAULT NULL COMMENT 'Конец обучения',
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Видимость записи об обучении'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Образование';

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `session_id` int(10) unsigned DEFAULT NULL COMMENT 'ID сессии',
  `name` varchar(50) DEFAULT NULL COMMENT 'Имя отправителя',
  `email` varchar(60) DEFAULT NULL COMMENT 'Email',
  `message` text COMMENT 'Сообщение',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата отправки',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Результат отправки сообщения (0 - нет, 1 - успешно)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Обращения через формы обратной связи';

-- --------------------------------------------------------

--
-- Структура таблицы `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `year` year(4) DEFAULT NULL COMMENT 'Год',
  `text` text COMMENT 'Текст событий',
  `created` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата добавления истории',
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Видимость записи'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='История в разделе "Обо мне"';

-- --------------------------------------------------------

--
-- Структура таблицы `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `name` varchar(75) DEFAULT NULL COMMENT 'Имя [Фамилия]',
  `city` varchar(50) DEFAULT NULL COMMENT '[Страна,] Город',
  `birthday` date DEFAULT NULL COMMENT 'Дата рождения',
  `experience` date DEFAULT NULL COMMENT 'Дата, от которой считать опыт',
  `profession` varchar(100) DEFAULT NULL COMMENT 'Профессия',
  `email` varchar(60) DEFAULT NULL COMMENT 'Email',
  `link` varchar(100) DEFAULT NULL COMMENT 'Ссылка на основной профиль (используется в подвале сайта)',
  `image` varchar(100) DEFAULT NULL COMMENT 'Изображение'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Профиль разработчика';

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `category_id` int(10) unsigned DEFAULT '1' COMMENT 'Категория проекта',
  `name` varchar(100) DEFAULT NULL COMMENT 'Название проекта',
  `title` varchar(100) DEFAULT NULL COMMENT 'Заголовок',
  `description` varchar(200) DEFAULT NULL COMMENT 'Описание',
  `link` varchar(50) DEFAULT NULL COMMENT 'Ссылка',
  `text` text COMMENT 'Текст',
  `file` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Загрузка текста из файла (0 - нет, 1 - да). Если 1, то будет взят макет из `/views/pages/special/[ID]/index`.',
  `image` varchar(100) DEFAULT NULL COMMENT 'Изображение',
  `started` date DEFAULT NULL COMMENT 'Дата начала разработки',
  `finished` date DEFAULT NULL COMMENT 'Дата примерного завершения разработки',
  `personal` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Личный ли проект? (0 - нет, 1 - да)',
  `example` varchar(100) DEFAULT NULL COMMENT 'Ссылка на пример/реальный проект',
  `github` varchar(100) DEFAULT NULL COMMENT 'Ссылка на проект в GitHub',
  `login` varchar(20) DEFAULT NULL COMMENT 'Логин',
  `password` varchar(20) DEFAULT NULL COMMENT 'Пароль',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата создания записи о проекте',
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Показывать ли проект?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Список проектов';

-- --------------------------------------------------------

--
-- Структура таблицы `projects_documents`
--

CREATE TABLE IF NOT EXISTS `projects_documents` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `project_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ID проекта',
  `document_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ID документа'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Связанные с проектом документы и файлы';

-- --------------------------------------------------------

--
-- Структура таблицы `projects_skills`
--

CREATE TABLE IF NOT EXISTS `projects_skills` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `project_id` int(10) unsigned DEFAULT '0' COMMENT 'ID проекта',
  `skill_id` int(10) unsigned DEFAULT '0' COMMENT 'ID навыка'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Навыки, применённые в проектах';

-- --------------------------------------------------------

--
-- Структура таблицы `projects_tags`
--

CREATE TABLE IF NOT EXISTS `projects_tags` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `project_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ID проекта',
  `tag_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ID метки'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Метки проекта';

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID сессии',
  `user_host` varchar(15) DEFAULT NULL COMMENT 'IP пользователя',
  `user_agent` varchar(200) DEFAULT NULL COMMENT 'Информация о браузере',
  `created` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата первого захода',
  `updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Дата последней активности',
  `session_hash` varchar(64) DEFAULT NULL COMMENT 'Хеш сессии',
  `hash_updated` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата обновления хеша сессии',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Статус (0 - обычный, 9 - заблокированный)',
  `status_message` varchar(200) DEFAULT NULL COMMENT 'Причина блокировки'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Сессии пользователей';

-- --------------------------------------------------------

--
-- Структура таблицы `skills`
--

CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `type` enum('main','other') NOT NULL DEFAULT 'other' COMMENT 'Тип навыка (основной, прочий)',
  `code` varchar(25) DEFAULT NULL COMMENT 'Кодовое имя',
  `name` varchar(40) DEFAULT NULL COMMENT 'Название',
  `title` varchar(100) DEFAULT NULL COMMENT 'Текст, подставляющийся в заголовок',
  `description` varchar(200) DEFAULT NULL COMMENT 'Текст, подставляющийся в описание',
  `text` text COMMENT 'Описание',
  `percent` decimal(3,2) unsigned NOT NULL DEFAULT '0.00' COMMENT 'Уровень знания (от 0 до 1)',
  `image` varchar(100) DEFAULT NULL COMMENT 'Изображение',
  `color` varchar(30) NOT NULL DEFAULT '#aaaaaa' COMMENT 'Цвет (если основной)',
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Позиция в списке',
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Видимость навыка'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Навыки (технологии)';

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `code` varchar(30) DEFAULT NULL COMMENT 'Код',
  `name` varchar(50) DEFAULT NULL COMMENT 'Название',
  `tooltip` varchar(200) DEFAULT NULL COMMENT 'Описание',
  `title` varchar(100) DEFAULT NULL COMMENT 'Текст, подставляющийся в заголовок',
  `description` varchar(200) DEFAULT NULL COMMENT 'Текст, подставляющийся в описание',
  `text` text COMMENT 'Описание',
  `created` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата добавления метки'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Метки';

-- --------------------------------------------------------

--
-- Структура таблицы `theses`
--

CREATE TABLE IF NOT EXISTS `theses` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `title` varchar(100) DEFAULT NULL COMMENT 'Заголовок',
  `text` text COMMENT 'Текст',
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Позиция в списке',
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Видимость тезиса'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Тезисы из раздела "Почему я?"';

-- --------------------------------------------------------

--
-- Структура таблицы `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `title` varchar(75) DEFAULT NULL COMMENT 'Заголовок',
  `video` varchar(100) DEFAULT NULL COMMENT 'Ссылка на видео под Magnific-Popup',
  `preview` varchar(100) DEFAULT 'default.png' COMMENT 'Превью',
  `duration` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Длительность в секундах',
  `created` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата добавления ролика',
  `position` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'Номер блока (1, 2, 3)',
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Видимость (0 - нет, 1 - да)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Видео-ролики в разделе "Почему я?"';

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visible` (`visible`,`position`);

--
-- Индексы таблицы `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visible` (`visible`,`finished`);

--
-- Индексы таблицы `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`);

--
-- Индексы таблицы `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visible` (`visible`,`year`);

--
-- Индексы таблицы `profile`
--
ALTER TABLE `profile`
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `visible` (`visible`),
  ADD KEY `visible_2` (`visible`,`finished`),
  ADD KEY `link` (`link`,`visible`);

--
-- Индексы таблицы `projects_documents`
--
ALTER TABLE `projects_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`,`document_id`),
  ADD KEY `document_id` (`document_id`);

--
-- Индексы таблицы `projects_skills`
--
ALTER TABLE `projects_skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_id` (`project_id`,`skill_id`),
  ADD KEY `skill_id` (`skill_id`),
  ADD KEY `project_id_2` (`project_id`);

--
-- Индексы таблицы `projects_tags`
--
ALTER TABLE `projects_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`),
  ADD KEY `project_id_2` (`project_id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`session_hash`);

--
-- Индексы таблицы `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `percent` (`percent`),
  ADD KEY `visible` (`visible`,`position`,`percent`),
  ADD KEY `id` (`id`,`name`);

--
-- Индексы таблицы `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`name`);

--
-- Индексы таблицы `theses`
--
ALTER TABLE `theses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visible` (`visible`,`position`);

--
-- Индексы таблицы `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visible` (`visible`,`position`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `education`
--
ALTER TABLE `education`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `history`
--
ALTER TABLE `history`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `projects_documents`
--
ALTER TABLE `projects_documents`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `projects_skills`
--
ALTER TABLE `projects_skills`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `projects_tags`
--
ALTER TABLE `projects_tags`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID сессии';
--
-- AUTO_INCREMENT для таблицы `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `theses`
--
ALTER TABLE `theses`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `video`
--
ALTER TABLE `video`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `projects_documents`
--
ALTER TABLE `projects_documents`
  ADD CONSTRAINT `projects_documents_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_documents_ibfk_2` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `projects_skills`
--
ALTER TABLE `projects_skills`
  ADD CONSTRAINT `projects_skills_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_skills_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `projects_tags`
--
ALTER TABLE `projects_tags`
  ADD CONSTRAINT `projects_tags_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
