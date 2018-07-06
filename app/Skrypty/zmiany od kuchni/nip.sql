-- chcemy wywalić wszystkie spacje z vatno i vatno_txt

-- Deklarujemy funkcję, która zmieni nam vatno i vatno_txt dla zadanego rekordu

DROP FUNCTION IF EXISTS WYWAL_SPACJE;

-- procedura wywalenie spacji z pewnego zakresu rekordow
DROP PROCEDURE IF EXISTS WYWAL_OD_DO;

DELIMITER $$

CREATE FUNCTION WYWAL_SPACJE(customerId INT) RETURNS INT
BEGIN
   -- DECLARE JEST INT DEFAULT 0;
   DECLARE WYNIK INT DEFAULT 2; -- INT DEFAULT 0;
   DECLARE VATNOTXT VARCHAR(45) DEFAULT "";
   DECLARE VATNONR VARCHAR(45) DEFAULT "";
   DECLARE VACIK  VARCHAR(45) DEFAULT "";

   IF EXISTS(SELECT * FROM `customers` WHERE id=customerId) > 0 THEN -- Jeżeli taki rekord istnieja
    SET VACIK = (SELECT  vatno FROM `customers` WHERE id=customerId); 
    SET VATNONR = (SELECT REPLACE(VACIK, ' ', ''));
    SET VACIK = (SELECT  vatno_txt FROM `customers` WHERE id=customerId); 
    SET VATNOTXT = (SELECT REPLACE(VACIK, ' ', ''));

    -- UAKTUALNIJ NRy, ale bez SPACJI
    UPDATE `customers`
        SET vatno = VATNONR, vatno_txt = VATNOTXT
    WHERE id=customerId;

    SET WYNIK = 1; 

   ELSE
    SET WYNIK = 0;
   END IF;

   RETURN WYNIK;   
END
$$

CREATE PROCEDURE WYWAL_OD_DO(od INT, do INT)
BEGIN
    DECLARE theId INT;    
    SET theId = od;

    REPEAT
        SELECT WYWAL_SPACJE(theId);
        SET theId = theId + 1;
    UNTIL theId > do
    END REPEAT;
END
$$

DELIMITER ;

-- select WYWAL_SPACJE(82) INTO @zmienna;
-- SET @zmienna = WYWAL_SPACJE(282); SELECT @zmienna;

CALL WYWAL_OD_DO(1, 1070);
