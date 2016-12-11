
CREATE TABLE proofs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    card_id  INT UNSIGNED,    
    cr SMALLINT UNSIGNED DEFAULT NULL COMMENT 'czas realizacji',
    waluta CHAR(3) DEFAULT NULL,
    a_kolor TEXT DEFAULT NULL COMMENT 'kolory awers opis ewentualny',
    r_kolor TEXT DEFAULT NULL COMMENT 'kolory rewers opis ewentualny',
    size VARCHAR(255) DEFAULT NULL COMMENT 'rozmiar karty tekstowo',
    uwagi TEXT DEFAULT NULL COMMENT 'uwagi proofowe',    
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL
);