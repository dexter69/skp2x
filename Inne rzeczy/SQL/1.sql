--
-- Modyfikacja bazy danych pood nowy system uprawnień.
--

-- Tabela grup uprawnień
-- Użytkownicy będę przypisani do konkretnych grup 
CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'Opisowa, zrozumiała nazwa grupy',  
  `description` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Tabela uprawnień dla grup
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `resource` varchar(100) NOT NULL COMMENT 'Zasób do którego odnosi się uprawnienie. Np. orders_view, cards_edit, itp.',
  `permission_level` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '0 oznacza brak uprawnień',
  `description` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Dodanie kolumny group_id do tabeli users
ALTER TABLE `users` ADD COLUMN `group_id` int(10) unsigned DEFAULT NULL AFTER `id`;
ALTER TABLE `users` ADD KEY `group_id` (`group_id`);
ALTER TABLE `users` ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);