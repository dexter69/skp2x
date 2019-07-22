-- Tu chcemy tworzyć procedury i funkcje na stałe przechowywane w bazie

DELIMITER $$

-- chcemy procedurę, która zmienia statusy kart dodanych później do zamówienia
-- czyli tajich, które mają status 0
-- STATUSY
-- 31 --> SPRAWDZONA
-- 41 --> P.D.P
-- 42 --> W_PROD
-- 51 --> W4D
-- 52 --> W4DP

DROP PROCEDURE IF EXISTS UPDATE_STATUS_KART
$$

CREATE PROCEDURE UPDATE_STATUS_KART( idZam INT, newStatus INT)
BEGIN

    -- Zmieniamy status
    UPDATE `cards`
    SET
    `status`=newStatus
    , `remstatus`=0 -- zeruj remstatus
    where `order_id`=idZam AND `status`=0;

    -- I podejrzyj rezultat
    SELECT
    `id`, `order_id`, `job_id`, `name`, `status`, `remstatus`
    FROM `cards`
    WHERE `order_id`=idZam;    
    
END
$$

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

DROP FUNCTION IF EXISTS DB_NR_2_HUMAN
$$

-- Chcemy funkcję zaminiającą bazodanowy format numeru na ludzki
CREATE FUNCTION DB_NR_2_HUMAN(dbnr VARCHAR(7)) RETURNS VARCHAR(8)
BEGIN
    RETURN CONCAT(
                    CONVERT( SUBSTRING(dbnr, 3, 5), UNSIGNED INTEGER ),
                    "/",
                    SUBSTRING(dbnr, 1, 2)
            );
    -- RETURN SUBSTRING(dbnr, 1, 2);
    
END
$$

-- chcemy procedurę, która zmienia "właściciela" podanego zamówienia (id)
-- zmienia również opiekuna klienta (DEEP), którego to było zamówienie
DROP PROCEDURE IF EXISTS CHANGE_OWNER_OF_AN_ORDER_DEEP
$$

CREATE PROCEDURE CHANGE_OWNER_OF_AN_ORDER_DEEP( idZam INT, newOwner INT)
BEGIN

    DECLARE theCustomerId INT; 
    SET theCustomerId = (select customer_id from orders where id=idZam);   
    
    -- Aktualizujemy karty...
    update cards
    set user_id=newOwner, owner_id=newOwner
    where order_id=idZam;

    -- Oraz zmówienie
    update orders
    set user_id=newOwner
    where id=idZam;

    -- Oraz klienta
    update customers
    set user_id=newOwner, owner_id=newOwner, opiekun_id=newOwner
    where id=theCustomerId;
    
END
$$

-- chcemy procedurę, która zmienia "właściciela" podanego zamówienia (id)
-- ale bez zmiany stałego opiekuna
DROP PROCEDURE IF EXISTS CHANGE_OWNER_OF_AN_ORDER
$$

CREATE PROCEDURE CHANGE_OWNER_OF_AN_ORDER( idZam INT, newOwner INT)
BEGIN

    DECLARE theCustomerId INT; 
    SET theCustomerId = (select customer_id from orders where id=idZam);   
    
    -- Aktualizujemy karty...
    update cards
    set user_id=newOwner, owner_id=newOwner
    where order_id=idZam;

    -- Oraz zmówienie
    update orders
    set user_id=newOwner
    where id=idZam;

    -- Oraz klienta tymczasowego opiekuna
    update customers
    set user_id=newOwner, owner_id=newOwner
    where id=theCustomerId;
    
END
$$

DELIMITER ;