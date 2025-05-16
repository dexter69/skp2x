--
-- Modyfikacja tabeli `groups`
-- Dodanie pola:
-- `allowed_by_default`
-- Pole typu boolean, domyślnie false
-- Znaczenie:
-- dotyczy użytkowników przypisanych do tej grupy,
-- 1.
-- false => oznacza, że domyślnie wszystkie akcje w kontrolerach są ZABRONIONE.

-- Zatem jeżeli nie zdefiniujemy żadnych uprawnień dla tej grupy, to żadna akcja nie będzie dozwlona.
-- Każda definicja uprawnienia PODNOSI zatem poziom uprawnień dla danego zasobu.

-- 2.
-- true => oznacza, że domyślnie wszystkie akcje w kontrolerach są DOZWOLONE.

-- Zatem jeżeli nie zdefiniujemy żadnych uprawnień dla tej grupy, to każda akcja będzie dozwlona.
-- Każda definicja uprawnienia OBNIŻA zatem poziom uprawnień dla danego zasobu.

ALTER TABLE `groups` ADD COLUMN `allowed_by_default` BOOLEAN DEFAULT 0 COMMENT 'false-true => domyślnie wszystkie akcje w kontrolerach zabronione-dozwolone dla tej grupy' AFTER `description`;