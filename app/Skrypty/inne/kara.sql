SELECT id, name, user_id FROM `customers`
WHERE id NOT IN 
(SELECT DISTINCT customer_id
FROM `orders`
WHERE status>0
)
ORDER BY name
;
