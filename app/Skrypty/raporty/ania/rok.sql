/*
Ilość kart wyprodukowanych w danym roku.
Jako datę decydującą o przyporządkowaniu do danego roku, bierzemy datę wysłania,
czyli zakończenia zamówienia przez Krystynę */

SET -- Ustawiamy zmienne
@rok = "2018-";

SET
@od = CONCAT(@rok, "01-01 00:00:00"), -- data od
@do = CONCAT(@rok, "12-31 23:59:00"), -- data do
@zakoncz = 17; -- rodzaj zdarzenia (zakończenie zamówienia)

SELECT 
#cards.name AS `Nazwa karty`, cards.quantity AS 'Ilość', cards.mnoznik AS 'Mnożnik', cards.ilosc AS 'ILE', SUBSTRING(events.created,1,10) AS `Data zakończenia`
sum(cards.quantity) AS 'Suma'

FROM `events` JOIN `orders` ON events.order_id=orders.id
JOIN `cards` ON cards.order_id=orders.id 
WHERE
events.created >= @od AND events.created <= @do -- Data zdarzenia
AND events.co = @zakoncz -- Rodzj zdrzenia - tylko zamknięcia
ORDER BY
#cards.mnoznik DESC
#orders.nr, cards.id;
events.created