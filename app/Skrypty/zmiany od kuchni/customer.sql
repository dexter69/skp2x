-- Chcemy zmienić klienta przypisnego do istniejącgo juz zamówienia

SET

@customerAdr=228,   -- adres nowego klienta, adres siedziby
@customerId=140,    -- id nowego klienta
@orderId=6169;      -- id zamówienia w którym mamy to zrobić


-- zmieniawy wpis odnośnie kienta w kartach tego zamówienia

UPDATE `cards`
SET customer_id=@customerId
WHERE order_id=@orderId;

-- wpisy w zamówieniu

UPDATE `orders`
SET
customer_id=@customerId,
siedziba_id=@customerAdr,
wysylka_id=@customerAdr
WHERE id=@orderId;