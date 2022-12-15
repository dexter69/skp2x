/*
Chcemy sumę ilości wszystkich wyprodukowanych kart, które zostały zkończone (zamknięte zamówienie)
w danym misiącu - tu styczeń */
SET -- Ustawiamy zmienne
@mies = "01",
@rok = "2022-";

SET
@od = CONCAT(@rok, @mies, "-01 00:00:00"), -- data od
@do = CONCAT(@rok, @mies, "-31 23:59:00"), -- data do
@zakoncz = 17; -- rodzaj zdarzenia (zakończenie zamówienia)



CREATE TEMPORARY TABLE IF NOT EXISTS karty AS (
    SELECT cards.name AS `Nazwa karty`, cards.quantity AS 'ile'
    FROM `events` JOIN `orders` ON events.order_id=orders.id
    JOIN `cards` ON cards.order_id=orders.id JOIN `customers` ON orders.customer_id=customers.id
    WHERE
    events.created >= @od AND events.created <= @do -- Data zdarzenia
    AND events.co = @zakoncz -- Rodzaj zdrzenia - tylko zamknięcia
    ORDER BY orders.nr, cards.id
);

SELECT SUM(ile)
FROM karty;