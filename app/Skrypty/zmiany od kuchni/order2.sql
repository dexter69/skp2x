-- Zmiana „właściciela” zamówienia „głębsza” BETTER Version
-- Ustawiamy odpowiednie id użytkownika w kartach, w zamówieniu i u klienta

SET -- Ustawiamy zmienne

@nrOfAnOrder=1800001,   -- nr zamówienia w formie bazodanowej

@new_user_id=2;         -- id nowego użytkownika


set @theId=(select id from orders where nr=@nrOfAnOrder); -- potrzebne nam znalezienie id zamówienia

-- i zmieniamy włąściciela zamówienia, jego kard i klienta
CALL CHANGE_OWNER_OF_AN_ORDER_DEEP(@theId, @new_user_id);


