<?php
/**
 * OrderFixture
 *
 */
class OrderFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'customer_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'offset' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 10, 'comment' => 'używane do tworzenia numeru zlecenia'),
		'stop_day' => array('type' => 'date', 'null' => true, 'default' => null, 'comment' => 'termin realizacji'),
		'inny_adres' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'fullname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_polish_ci', 'comment' => 'pełna nazwa', 'charset' => 'utf8'),
		'ulica' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_polish_ci', 'comment' => 'ulica', 'charset' => 'utf8'),
		'nr_budynku' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'utf8_polish_ci', 'comment' => 'numer budynku', 'charset' => 'utf8'),
		'miasto' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_polish_ci', 'comment' => 'miasto', 'charset' => 'utf8'),
		'kod' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_polish_ci', 'comment' => 'kod pocztowy', 'charset' => 'utf8'),
		'osoba_kontaktowa' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 70, 'collate' => 'utf8_polish_ci', 'charset' => 'utf8'),
		'tel' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_polish_ci', 'comment' => 'telefon', 'charset' => 'utf8'),
		'kraj' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_polish_ci', 'comment' => 'kraj', 'charset' => 'utf8'),
		'is_zaliczka' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'comment' => '0 - brak zaliczki, 1 - przelew, 2 - gotówka'),
		'wartosc_zaliczki' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'comment' => 'wartosc 1-100, jako warosc procentowa'),
		'platnosc' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 10, 'comment' => '0 - inna, 1 - przelew, 2 - gotówka, 3 - pobranie'),
		'termin_platnosci' => array('type' => 'integer', 'null' => false, 'default' => '7', 'length' => 10, 'comment' => 'ilosc dni'),
		'comment' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_polish_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'comment' => 'status zlecenia'),
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
			'offset' => 1,
			'stop_day' => '2013-12-02',
			'inny_adres' => 1,
			'fullname' => 'Lorem ipsum dolor sit amet',
			'ulica' => 'Lorem ipsum dolor sit amet',
			'nr_budynku' => 'Lorem ipsum dolor sit amet',
			'miasto' => 'Lorem ipsum dolor sit amet',
			'kod' => 'Lorem ipsum dolor sit amet',
			'osoba_kontaktowa' => 'Lorem ipsum dolor sit amet',
			'tel' => 'Lorem ipsum dolor sit amet',
			'kraj' => 'Lorem ipsum dolor sit amet',
			'is_zaliczka' => 1,
			'wartosc_zaliczki' => 1,
			'platnosc' => 1,
			'termin_platnosci' => 1,
			'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'status' => 1,
			'created' => '2013-12-02 10:46:22',
			'modified' => '2013-12-02 10:46:22'
		),
	);

}
