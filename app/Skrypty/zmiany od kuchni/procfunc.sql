-- Tu chcemy tworzyć procedury i funkcje na stałe przechowywane w bazie

DELIMITER $$

DROP FUNCTION IF EXISTS IMIE_HANDLOWCA
$$

-- Chcemy funkcję zwracającą imię handlowca w zależności od jego id
CREATE FUNCTION IMIE_HANDLOWCA(handlowiecId INT) RETURNS VARCHAR(25)
BEGIN
    
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

DROP FUNCTION IF EXISTS KSZTALT_KARTY
$$

-- Chcemy funkcję zwracającą rodzaj kształtu karty w zależności od wartości tego kształtu w bazie
CREATE FUNCTION KSZTALT_KARTY(nr INT) RETURNS VARCHAR(25)
BEGIN
    IF nr = 0 THEN
        RETURN "Standard";
    ELSEIF nr = 1 THEN
        RETURN "INNY";
    ELSEIF nr = 2 THEN
        RETURN "2+1";
    ELSEIF nr = 3 THEN
        RETURN "Brelokx3";    
    ELSE 
        RETURN "O CHOLERA!";
    END IF;
END
$$

DROP FUNCTION IF EXISTS RODZAJ_CHIPA
$$

-- Chcemy funkcję zwracającą rodzaj chipa w zależności od wartości w bazie
CREATE FUNCTION RODZAJ_CHIPA(nr INT) RETURNS VARCHAR(25)
BEGIN
    IF nr = 0 THEN
        RETURN "BRAK";
    ELSEIF nr = 1 THEN
        RETURN "INNY";
    ELSEIF nr = 2 THEN
        RETURN "Unique";
    ELSEIF nr = 3 THEN
        RETURN "Mifare";    
    ELSEIF nr = 4 THEN
        RETURN "SLE";
    ELSE 
        RETURN "O CHOLERA!";
    END IF;
END
$$

DELIMITER ;