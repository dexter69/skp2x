-- Chcemy lepszy skrypt do raportów dl Beaty

SET -- Ustawiamy zmienne
@od = '2018-06-01 00:00:00', -- data od
@do = '2018-06-30 23:59:00'; -- data do

CREATE TEMPORARY TABLE IF NOT EXISTS table1 AS (
SELECT
customers.opiekun_id AS opiekun,
orders.customer_id AS idKlienta,
customers.name AS nazwaKlienta,
orders.id AS idZamowienia,
orders.nr,
cards.name AS nazwaKarty,
cards.quantity AS ILE,
orders.data_publikacji AS data
FROM (( cards
INNER JOIN orders ON cards.order_id=orders.id )
INNER JOIN customers ON orders.customer_id=customers.id)
WHERE orders.data_publikacji >= @od AND orders.data_publikacji < @do AND customers.user_id != 17
ORDER BY opiekun, idKlienta, nr);

CREATE TEMPORARY TABLE IF NOT EXISTS table2 AS
(SELECT idZamowienia, SUM(ILE) AS iloscKart FROM table1 GROUP BY idZamowienia);

CREATE TEMPORARY TABLE IF NOT EXISTS table3 AS (
SELECT
customers.opiekun_id AS opiekun,
orders.customer_id AS idKlienta,
customers.name AS nazwaKlienta,
orders.id AS idZamowienia,
orders.nr,
orders.data_publikacji AS data
FROM orders INNER JOIN customers ON orders.customer_id=customers.id
WHERE orders.data_publikacji >= @od AND orders.data_publikacji < @do AND customers.user_id != 17
ORDER BY idZamowienia);

SELECT table3.opiekun, table3.nazwaKlienta, table3.idZamowienia, table3.nr, table2.iloscKart, table3.data FROM table3 INNER JOIN table2 ON table3.idZamowienia = table2.idZamowienia ORDER BY opiekun, idKlienta, nr;