/*
Chcemy wszystkie karty (ilosci), które zostały zkończone (zamknięte zamówienie)
w danym misiącu - tu listopad */

SET -- Ustawiamy zmienne
@mies = "11";

SET
@od = CONCAT("2018-", @mies, "-01 00:00:00"), -- data od
@do = CONCAT("2018-", @mies, "-31 23:59:00"), -- data do
@zakoncz = 17; -- rodzaj zdarzenia (zakończenie zamówienia)

SELECT -- events.id, events.user_id,
-- events.order_id AS `id Zamówinia`,
cards.name AS `Nazwa karty`, cards.quantity AS 'Ilość', customers.name AS Klient, -- , cards.mnoznik, cards.ilosc
SUBSTRING(events.created,1,10) AS `Data zakończenia`, cards.mnoznik, -- <= wypełniacze
events.url, DB_NR_2_HUMAN(orders.nr) AS Nr
-- , events.co, events.url, events.created
FROM `events` JOIN `orders` ON events.order_id=orders.id
JOIN `cards` ON cards.order_id=orders.id JOIN `customers` ON orders.customer_id=customers.id
WHERE
events.created >= @od AND events.created <= @do -- Data zdarzenia
AND events.co = @zakoncz -- Rodzj zdrzenia - tylko zamknięcia
ORDER BY orders.nr, cards.id;