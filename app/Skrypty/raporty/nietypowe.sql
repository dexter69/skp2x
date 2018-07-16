-- Raport - nietypowe karty
SET -- Ustawiamy zmienne
-- data od
@od = '2018-01-01 00:00:00',
-- data do
@do = '2018-06-30 23:59:00';

SELECT
cards.name AS 'Nazwa karty',
KSZTALT_KARTY(cards.ksztalt) AS 'Kształt',
RODZAJ_CHIPA(cards.chip) AS "Rodzaj chip'a",
cards.ilosc AS 'Ilość',
cards.price AS 'Kwota jednostkowa',
cards.ilosc * cards.price AS 'Kwota netto',
IMIE_HANDLOWCA(customers.opiekun_id) AS Opiekun,
orders.data_publikacji AS 'Data publikacji',
-- orders.stop_day AS Termin,
orders.id AS idZamówienia,
orders.nr AS 'Nr Handlowy'
FROM
( cards INNER JOIN orders ON cards.order_id=orders.id )
INNER JOIN customers ON orders.customer_id=customers.id
WHERE 
        (cards.ksztalt>0 OR cards.chip>0) AND
        orders.data_publikacji >= @od AND
        orders.data_publikacji <= @do AND
        customers.opiekun_id IN (2,11)
ORDER BY customers.opiekun_id, orders.nr;