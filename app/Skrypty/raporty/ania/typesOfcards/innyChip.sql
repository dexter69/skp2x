/*
Chcemy rap. o kartach różnego rodzaju. Ile/jakie karty danego rodzaju z nr'ami zamówień
i klientem w danym okresie czasu. Data zakonczenia faktyczna nas interesuje

Tu chcemy karty z pozostałymi chipami */

SET
@od = "2018-01-01 00:00:00", -- data od
@do = "2018-01-21 23:59:00", -- data do
@zakoncz = 17; -- rodzaj zdarzenia (zakończenie zamówienia)

SELECT 
cards.name AS `Nazwa karty`,
cards.quantity AS 'Ilość',
customers.name AS Klient, -- , cards.mnoznik, cards.ilosc
SUBSTRING(events.created,1,10) AS `Data zakończenia`, cards.mnoznik, -- <= wypełniacze
events.url, DB_NR_2_HUMAN(orders.nr) AS Nr
-- , events.co, events.url, events.created
FROM `events` JOIN `orders` ON events.order_id=orders.id
JOIN `cards` ON cards.order_id=orders.id JOIN `customers` ON orders.customer_id=customers.id
WHERE
events.created >= @od AND events.created <= @do -- Data zdarzenia
AND events.co = @zakoncz -- Rodzj zdrzenia - tylko zamknięcia
AND cards.chip NOT IN (0,2,3) -- Karty z innym chipem
ORDER BY orders.nr, cards.id;