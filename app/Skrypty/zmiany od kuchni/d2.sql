CREATE TEMPORARY TABLE `cards_uploads2`
SELECT `card_id`, `upload_id`
FROM `cards_uploads`
WHERE `card_id` >= '11145' AND `card_id` <= '11168';

UPDATE `cards_uploads2`
SET `card_id`=11488
WHERE `card_id`=11145;

UPDATE `cards_uploads2`
SET `card_id`=11489
WHERE `card_id`=11146;

UPDATE `cards_uploads2`
SET `card_id`=11490
WHERE `card_id`=11147;

UPDATE `cards_uploads2`
SET `card_id`=11491
WHERE `card_id`=11148;

UPDATE `cards_uploads2`
SET `card_id`=11492
WHERE `card_id`=11149;

UPDATE `cards_uploads2`
SET `card_id`=11493
WHERE `card_id`=11150;

UPDATE `cards_uploads2`
SET `card_id`=11494
WHERE `card_id`=11151;

UPDATE `cards_uploads2`
SET `card_id`=11495
WHERE `card_id`=11152;

UPDATE `cards_uploads2`
SET `card_id`=11496
WHERE `card_id`=11153;

UPDATE `cards_uploads2`
SET `card_id`=11497
WHERE `card_id`=11154;

UPDATE `cards_uploads2`
SET `card_id`=11498
WHERE `card_id`=11155;

UPDATE `cards_uploads2`
SET `card_id`=11499
WHERE `card_id`=11156;

UPDATE `cards_uploads2`
SET `card_id`=11500
WHERE `card_id`=11157;

UPDATE `cards_uploads2`
SET `card_id`=11501
WHERE `card_id`=11158;

UPDATE `cards_uploads2`
SET `card_id`=11502
WHERE `card_id`=11159;

UPDATE `cards_uploads2`
SET `card_id`=11503
WHERE `card_id`=11160;

UPDATE `cards_uploads2`
SET `card_id`=11504
WHERE `card_id`=11161;

UPDATE `cards_uploads2`
SET `card_id`=11505
WHERE `card_id`=11162;

UPDATE `cards_uploads2`
SET `card_id`=11506
WHERE `card_id`=11163;

UPDATE `cards_uploads2`
SET `card_id`=11507
WHERE `card_id`=11164;

UPDATE `cards_uploads2`
SET `card_id`=11508
WHERE `card_id`=11165;

UPDATE `cards_uploads2`
SET `card_id`=11509
WHERE `card_id`=11166;

UPDATE `cards_uploads2`
SET `card_id`=11510
WHERE `card_id`=11167;

UPDATE `cards_uploads2`
SET `card_id`=11511
WHERE `card_id`=11168;

INSERT INTO `cards_uploads`(`card_id`, `upload_id`) SELECT `card_id`, `upload_id` FROM `cards_uploads2`;

DROP TABLE `cards_uploads2`;