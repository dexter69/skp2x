-- Poprawienie statusu w kartach

-- STATUSY
-- 31 --> SPRAWDZONA
-- 41 --> P.D.P

-- Ustawiamy zmienne
SET 
-- id zamówienia
@order_id=

5816

-- nr statusu jaki ma być
, @new_status=41;


-- Zmieniamy status
UPDATE `cards`
SET
`status`=@new_status
, `remstatus`=0 -- zeruj remstatus
where `order_id`=@order_id;

-- I podejrzyj rezultat
SELECT
`id`, `order_id`, `job_id`, `name`, `status`, `remstatus`
FROM `cards`
WHERE `order_id`=@order_id;