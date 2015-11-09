<?php
/**
 * ProofFixture
 *
 */
class ProofFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'card_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true),
		'eng' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => 'czy angielska wersja, 0 oznacza nie'),
		'cr' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 5, 'unsigned' => true, 'comment' => 'czas realizacji'),
		'waluta' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3, 'collate' => 'utf8_polish_ci', 'charset' => 'utf8'),
		'a_kolor' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_polish_ci', 'comment' => 'kolory awers opis ewentualny', 'charset' => 'utf8'),
		'r_kolor' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_polish_ci', 'comment' => 'kolory rewers opis ewentualny', 'charset' => 'utf8'),
		'size' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_polish_ci', 'comment' => 'rozmiar karty tekstowo', 'charset' => 'utf8'),
		'uwagi' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_polish_ci', 'comment' => 'uwagi proofowe', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_polish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'card_id' => 1,
			'eng' => 1,
			'cr' => 1,
			'waluta' => 'L',
			'a_kolor' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'r_kolor' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'size' => 'Lorem ipsum dolor sit amet',
			'uwagi' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2015-11-09 14:54:26',
			'modified' => '2015-11-09 14:54:26'
		),
	);

}
