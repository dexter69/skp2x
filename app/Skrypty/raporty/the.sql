-- A TAK NAPRAWDĘ TO! Chcemy opiekuna stałego (opiekun_id)
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
WHERE orders.data_publikacji > '2018-02-31' AND orders.data_publikacji < '2018-04-01' AND customers.user_id != 17
ORDER BY opiekun, idKlienta, nr

-- Teraz chcemy wszystkich klientów posortowanych po opiekunach i nazwach klientów, wszystkich handlowców za wyjątkiem Anii
SELECT
customers.id AS idKlienta,
users.name AS Opiekun,
customers.name AS Klient
FROM customers
INNER JOIN users ON customers.user_id = users.id
WHERE customers.user_id!=1 AND customers.user_id!=17
ORDER BY Opiekun, Klient

-- Przypisanie nowemu id (opiekun_id) wartości user_id
UPDATE `customers`
SET opiekun_id=user_id