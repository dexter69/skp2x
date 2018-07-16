-- Tu chcemy tworzyć procedury i funkcje na stałe przechowywane w bazie

DROP FUNCTION IF EXISTS IMIE_HANDLOWCA;

DELIMITER $$

-- Chcemy funkcję zwracającą imię handlowca w zależności od jego id
CREATE FUNCTION IMIE_HANDLOWCA(handlowiecId INT) RETURNS VARCHAR(25)
BEGIN
    -- DECLARE WYNIK VARCHAR(25) DEFAULT "INNY";
    IF handlowiecId = 2 THEN
        RETURN "Beata";
    ELSEIF handlowiecId = 3 THEN
        RETURN "Agnieszka";
    ELSEIF handlowiecId = 10 THEN
        RETURN "Renata";
    ELSEIF handlowiecId = 11 THEN
        RETURN "Marzena";
    ELSEIF handlowiecId = 31 THEN
        RETURN "Piotr";
    ELSE 
        RETURN "INNY";
    END IF;    
END
$$

DELIMITER ;