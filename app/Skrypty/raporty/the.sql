-- Wszystkie interesuj�ce nas zam�wienia Listopad do Luty
SELECT id, user_id, customer_id, nr, data_publikacji
FROM `orders`
where data_publikacji > '2017-11-01' AND data_publikacji < '2018-03-01' AND user_id != 17
ORDER BY user_id

-- To samo jak wy�ej, tylko mamy nazwy klient�w
SELECT orders.id, orders.user_id, orders.customer_id, customers.name, orders.nr, orders.data_publikacji
FROM orders
INNER JOIN customers ON orders.customer_id=customers.id
where data_publikacji > '2017-11-01' AND data_publikacji < '2018-03-01' AND orders.user_id != 17
ORDER BY user_id

-- Jw, tylko �wiczymy na ma�ej ilo�ci (Piotrek)
SELECT orders.id, orders.user_id, orders.customer_id, customers.name, orders.nr, orders.data_publikacji
FROM orders
INNER JOIN customers ON orders.customer_id=customers.id
where data_publikacji > '2017-11-01' AND data_publikacji < '2018-03-01' AND orders.user_id = 31

-- Tu mamy karty dla Piotra
SELECT cards.id, cards.name, cards.quantity, orders.id, orders.user_id, orders.customer_id, orders.nr, orders.data_publikacji
FROM cards
INNER JOIN orders ON cards.order_id=orders.id
where orders.data_publikacji > '2017-11-01' AND orders.data_publikacji < '2018-03-01' AND orders.user_id = 31

-- TO JEST TO! Listopad odpowiednio posortowany
SELECT
orders.customer_id AS idKlienta,
customers.name AS nazwaKlienta,
customers.user_id AS opiekun,
orders.user_id,
orders.id AS idZamowienia,
orders.nr,
cards.id AS idKarty,
cards.name AS nazwaKarty,
cards.quantity AS ILE,
orders.data_publikacji AS data
FROM (( cards
INNER JOIN orders ON cards.order_id=orders.id )
INNER JOIN customers ON orders.customer_id=customers.id)
WHERE orders.data_publikacji > '2017-11-01' AND orders.data_publikacji < '2017-11-31' AND orders.user_id != 17
ORDER BY opiekun, idKlienta, nr

-- A TAK NAPRAWDĘ TO! Chcemy opiekuna (przypisanego do klienta) a nie tego, który złożył to zamówienie
SELECT
customers.user_id AS opiekun,
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
WHERE orders.data_publikacji > '2017-11-01' AND orders.data_publikacji < '2017-11-31' AND customers.user_id != 17
ORDER BY opiekun, idKlienta, nr