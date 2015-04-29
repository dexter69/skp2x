<?php
/**
 * JobFixture
 *
 */
class JobFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'offset' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 10, 'comment' => 'używane do tworzenia numeru zlecenia'),
		'stop_day' => array('type' => 'date', 'null' => true, 'default' => null),
		'rodzaj_arkusza' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'comment' => 'osobno czy przewrotka?'),
		'arkusze_netto' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'dla_laminacji' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'dla_drukarzy' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'forum' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_polish_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'comment' => 'status zlecenia'),
		'comment' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_polish_ci', 'charset' => 'utf8'),
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
			'user_id' => 1,
			'offset' => 1,
			'stop_day' => '2013-12-02',
			'rodzaj_arkusza' => 1,
			'arkusze_netto' => 1,
			'dla_laminacji' => 1,
			'dla_drukarzy' => 1,
			'forum' => 'Lorem ipsum dolor sit amet',
			'status' => 1,
			'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2013-12-02 10:46:09',
			'modified' => '2013-12-02 10:46:09'
		),
	);

}
