<?php
/**
 * CardFixture
 *
 */
class CardFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'customer_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'order_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'job_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_polish_ci', 'charset' => 'utf8'),
		'quantity' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'comment' => 'ilosc kart'),
		'price' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '6,4'),
		'wzor' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'comment' => 'załączniki/wzory: 0-brak, 1-karta wzorc, 2-cromalin, 3-powtórka edycji'),
		'comment' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_polish_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'comment' => 'status, co się dzieje z kartą'),
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
			'customer_id' => 1,
			'project_id' => 1,
			'order_id' => 1,
			'job_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'quantity' => 1,
			'price' => 1,
			'wzor' => 1,
			'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'status' => 1,
			'created' => '2013-12-02 10:44:56',
			'modified' => '2013-12-02 10:44:56'
		),
	);

}
