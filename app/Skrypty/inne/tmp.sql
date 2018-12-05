SELECT
Order.id, DB_NR_2_HUMAN(Order.nr), Order.stop_day, Order.status,
Card.name, Card.serwis
FROM orders `Order` JOIN cards `Card` ON Order.id=Card.order_id
WHERE
Order.stop_day > '2018-11-28' AND Order.stop_day <= '2018-12-05' AND
Order.status NOT IN (0,77) AND Card.serwis=0
ORDER BY Order.nr;

SELECT Order.id, DB_NR_2_HUMAN(Order.nr), Order.status, Order.stop_day
FROM orders `Order` JOIN
(SELECT DISTINCT order_id FROM cards where serwis=0) AS `Card`
WHERE
Order.stop_day > '2018-11-28' AND Order.stop_day <= '2018-12-05' AND
Order.status NOT IN (0,77)
LIMIT 9;

SELECT
DB_NR_2_HUMAN(Order.nr), Order.status
FROM orders `Order` JOIN
(SELECT DISTINCT order_id FROM cards where serwis=0) AS `Card`
ON Order.id=Card.order_id
WHERE Order.stop_day > '2018-11-28' AND Order.stop_day <= '2018-12-05' AND Order.status NOT IN (0,77)