-- Duplikujemy karty z zamówienia wejściowego
-- Zmieniamy niektóre wartości
-- Przypisujemy do 

SET
@newOrderId=6138; -- id zamówienia do którego kopiujemy

-- tworzymy tymczasową tabelę, do której kopiujemy rekordy nas interesujące
CREATE TEMPORARY TABLE `cards2`
SELECT 
`user_id`,
`owner_id`,
`customer_id`,
`order_id`,
`name`,
`price`,
`quantity`,
`ilosc`,
`mnoznik`,
`ishotstamp`,
`a_material`,
`r_material`,
`a_c`,
`r_c`,
`a_m`,
`r_m`,
`a_y`,
`r_y`,
`a_k`,
`r_k`,
`a_pant`,
`r_pant`,
`a_lam`,
`r_lam`,
`mag`,
`cmyk_comment`,
`a_podklad`,
`a_wybr`,
`r_podklad`,
`r_wybr`,
`a_zadruk`,
`r_zadruk`,
`a_podpis`,
`r_podpis`,
`a_zdrapka`,
`r_zdrapka`,
`a_lakpuch`,
`r_lakpuch`,
`a_lakblys`,
`r_lakblys`,
`a_lakmat`,
`r_lakmat`,
`sito_comment`,
`isperso`,
`pl`,
`pt`,
`pe`,
`perso`,
`dziurka`,
`chip`,
`ksztalt`,
`hologram`,
`option_comment`,
`wzor`,
`comment`,
`tech_comment`,
`customer_nr`,
`etykieta`,
`etylang`

FROM `cards`
WHERE order_id=5965;

-- Uaktualnij order_id w skopiowanych
UPDATE `cards2`
SET `order_id`=@newOrderId;

INSERT INTO `cards`(
`user_id`,
`owner_id`,
`customer_id`,
`order_id`,
`name`,
`price`,
`quantity`,
`ilosc`,
`mnoznik`,
`ishotstamp`,
`a_material`,
`r_material`,
`a_c`,
`r_c`,
`a_m`,
`r_m`,
`a_y`,
`r_y`,
`a_k`,
`r_k`,
`a_pant`,
`r_pant`,
`a_lam`,
`r_lam`,
`mag`,
`cmyk_comment`,
`a_podklad`,
`a_wybr`,
`r_podklad`,
`r_wybr`,
`a_zadruk`,
`r_zadruk`,
`a_podpis`,
`r_podpis`,
`a_zdrapka`,
`r_zdrapka`,
`a_lakpuch`,
`r_lakpuch`,
`a_lakblys`,
`r_lakblys`,
`a_lakmat`,
`r_lakmat`,
`sito_comment`,
`isperso`,
`pl`,
`pt`,
`pe`,
`perso`,
`dziurka`,
`chip`,
`ksztalt`,
`hologram`,
`option_comment`,
`wzor`,
`comment`,
`tech_comment`,
`customer_nr`,
`etykieta`,
`etylang`    
)

SELECT * FROM `cards2`;

DROP TABLE `cards2`;

-- I sprawdzamy
SELECT *
FROM `cards`
WHERE `order_id`=@newOrderId;