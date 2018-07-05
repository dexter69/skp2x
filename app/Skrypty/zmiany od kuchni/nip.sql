-- chcemy wywalić wszystkie spacje z vatno i vatno_txt

-- Deklarujemy funkcję, która zmieni nam vatno i vatno_txt dla zadanego rekordu

DROP FUNCTION IF EXISTS WYWAL_SPACJE;

DELIMITER $$

CREATE FUNCTION WYWAL_SPACJE(customerId INT) RETURNS VARCHAR(45) -- INT
BEGIN
   DECLARE JEST INT DEFAULT 0;
   DECLARE WYNIK VARCHAR(45) DEFAULT ""; -- INT DEFAULT 0;
   DECLARE VATNO_TXTB VARCHAR(45) DEFAULT "ALA MA KOTA";

   -- SET JEST = EXISTS(SELECT * FROM `customers` WHERE id=customerId);

   IF EXISTS(SELECT * FROM `customers` WHERE id=customerId) > 0 THEN
   -- IF JEST > 0 THEN
    -- SET WYNIK = "A";
    -- SET VATNO_TXT = (SELECT  vatno_txt FROM `customers` WHERE id=customerId);
    -- SET VATNO_TXT = (SELECT  vatno_txt FROM `customers` WHERE id=customerId);
    -- SELECT  vatno_txt FROM `customers` WHERE id=customerId;

    SET WYNIK = (SELECT  vatno_txt FROM `customers` WHERE id=customerId); -- = VATNO_TXT;

   ELSE
    SET WYNIK = "DUPA!";
   END IF;

   RETURN WYNIK;   
END
$$

DELIMITER ;

-- select WYWAL_SPACJE(82) INTO @zmienna;
SET @zmienna = WYWAL_SPACJE(82);

SELECT @zmienna;

-- SELECT IF(@zmienna>0, "Rekord istnieje", "Nie ma takiego rekordu");
