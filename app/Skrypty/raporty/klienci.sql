-- Chcemy listę klientów dla każdego handlowca, przykładowo dla jednego użytkownika

SELECT customers.id, customers.opiekun_id, addresses.name
FROM `customers` JOIN `addresses` ON customers.id = addresses.customer_id
where opiekun_id=10
-- ORDER BY addresses.name <= jeżeli chcemy alafabetycznie