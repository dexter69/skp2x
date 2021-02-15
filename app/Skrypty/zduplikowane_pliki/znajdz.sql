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

-- THIRD APPROACH - more lepse -)
-- Otrzymujemy jedną nazwę dla pliku na dysku; dla ew. potrzeb mamy też id kart, pod które te pliki są podpięte
SELECT uploads.`id` AS Id_Pliku, uploads.`filename`, uploads.`filesize`, CONCAT(COALESCE(uploads.`uuidname`,''), COALESCE(uploads.`new-uuidname`,'')) AS lxname, cards_uploads.`card_id` AS Id_Karty
FROM `uploads` JOIN `cards_uploads` ON uploads.`id` = `cards_uploads`.upload_id
WHERE `job_id`=0 AND `filesize` >= 7174470
ORDER BY `filename` ASC, `filesize` DESC, `created` ASC