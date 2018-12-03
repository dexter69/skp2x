select orders.id AS 'id Zamowienia', orders.nr AS 'numer Zamowienia'
FROM `orders` INNER JOIN
(SELECT DISTINCT cards.order_id
FROM `cards`
where serwis=1) AS karts
ON orders.id=karts.order_id;

-- %%%%%%%%%%%%%%%%%%%%%%%%

SELECT
o.id, o.nr, c.id, c.name, o.status, o.stop_day
FROM `customers` c JOIN `orders` o ON o.customer_id=c.id
JOIN
(SELECT DISTINCT cards.order_id
FROM `cards` 
where serwis=1) AS k
ON o.id=k.order_id;


-- 2018-12-03
SELECT o.id, o.nr, o.status, o.nr FROM `orders` o
JOIN (SELECT DISTINCT cards.order_id FROM `cards` where serwis=1) AS k
ON o.id=k.order_id;