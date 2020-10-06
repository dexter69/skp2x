SELECT `filename`, `role`, `filesize`, `created`, `id`, `uuidname`, `new-uuidname`
FROM `uploads`
WHERE `job_id`=0
ORDER BY `filesize` DESC, `created` ASC
LIMIT 2007

-- SECOND APPROACH - lepsze
SELECT `filename`, `role`, `filesize`, `created`, `id`, `uuidname`, `new-uuidname`
FROM `uploads`
WHERE `job_id`=0 AND `filesize` >= 7174470
ORDER BY `filename` ASC, `filesize` DESC, `created` ASC