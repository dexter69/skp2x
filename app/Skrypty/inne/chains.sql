-- Skrypt do wypełnienia tabeli `chins`

DROP TABLE IF EXISTS `chains`;
CREATE TABLE `chains` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `chain` varchar(128) COLLATE utf8_polish_ci NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Czy jest aktywny, uzywany rekord',
  `type` char(3) COLLATE utf8_polish_ci DEFAULT 'CUL' COMMENT 'Rodzaj stringu, wskazówka do czego służy, CUL -> client upload link',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chain` (`chain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `chains` (`chain`, `created`) VALUES
('XXXXXXXX', '2019-05-30 10:45:00'),
('YYYYYYYY', '2019-05-30 10:45:00')
-- ....
;