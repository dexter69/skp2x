-- Poprawienie statusu w kartach

-- STATUSY
-- 31 --> SPRAWDZONA
-- 41 --> P.D.P
-- 42 --> W_PROD
-- 51 --> W4D
-- 52 --> W4DP

-- Ustawiamy zmienne
SET 
-- id zamówienia
@order_id=

6238

-- nr statusu jaki ma być
, @new_status=51;


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