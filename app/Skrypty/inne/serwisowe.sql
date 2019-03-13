-- Karty serwisowe
SELECT cards.id, cards.name, IMIE_HANDLOWCA(customers.opiekun_id)
FROM `cards` JOIN `customers` ON cards.customer_id=customers.id
WHERE serwis=1
ORDER BY customers.opiekun_id, cards.id