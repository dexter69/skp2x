/*
Chcemy wszystkie karty (ilosci), które zostały zkończone (zamknięte zamówienie)
w danym misiącu - tu listopad */

SET -- Ustawiamy zmienne
@od = '2018-11-01 00:00:00', -- data od
@do = '2018-11-31 23:59:00', -- data do
@zakoncz = 17; -- rodzaj zdarzenia (zakończenie zamówienia)

SELECT -- events.id, events.user_id,
events.order_id AS `id Zamówinia`, DB_NR_2_HUMAN(orders.nr) AS Nr, cards.name AS `Nazwa karty`, cards.quantity, cards.mnoznik, cards.ilosc
, events.created AS `Data zakończenia`
-- , events.co, events.url, events.created
FROM `events` JOIN `orders` ON events.order_id=orders.id
JOIN `cards` ON cards.order_id=orders.id
WHERE
events.created >= @od AND events.created <= @do -- Data zdarzenia
AND events.co = @zakoncz -- Rodzj zdrzenia - tylko zamknięcia
ORDER BY orders.nr;
-- AND orders.id=7161;