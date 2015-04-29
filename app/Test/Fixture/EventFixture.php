<?php
/**
 * EventFixture
 *
 */
class EventFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'order_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'job_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'card_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'co' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'comment' => 'co się stało, nr wydrzenia'),
		'post' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_polish_ci', 'charset' => 'utf8'),
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
			'order_id' => 1,
			'job_id' => 1,
			'card_id' => 1,
			'co' => 1,
			'post' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2013-12-02 10:46:01',
			'modified' => '2013-12-02 10:46:01'
		),
	);

}
