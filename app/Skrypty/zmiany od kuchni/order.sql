-- Zmiana „właściciela” zamówienia.
-- Ustawiamy odpowiednie id użytkownika w kartach i w zamówieniu
SET -- Ustawiamy zmienne

@idv=5834, -- id zamówienia
@new_user_id=2; -- id nowego użytkownika

-- Aktualizujemy karty...
update cards
set user_id=@new_user_id, owner_id=@new_user_id
where order_id=@idv;

-- Oraz zmówienie
update orders
set user_id=@new_user_id
where id=@idv;

-- I sprawdzamy rezultat
select id, user_id, owner_id, name, order_id, customer_id
from cards
where order_id=@idv;

select id, user_id, nr, osoba_kontaktowa, tel
from orders
where id=@idv;