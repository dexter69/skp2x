<?php
/**
 * CustomerFixture
 *
 */
class CustomerFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_polish_ci', 'comment' => 'nazwa potoczna, np. Faktor', 'charset' => 'utf8'),
		'fullname' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_polish_ci', 'comment' => 'pełna nazwa', 'charset' => 'utf8'),
		'ulica' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_polish_ci', 'comment' => 'ulica', 'charset' => 'utf8'),
		'nr_budynku' => array('type' => 'string', 'null' => false, 'length' => 30, 'collate' => 'utf8_polish_ci', 'comment' => 'numer budynku', 'charset' => 'utf8'),
		'miasto' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_polish_ci', 'comment' => 'miasto', 'charset' => 'utf8'),
		'kod' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_polish_ci', 'comment' => 'kod pocztowy', 'charset' => 'utf8'),
		'kraj' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_polish_ci', 'comment' => 'kraj', 'charset' => 'utf8'),
		'osoba_kontaktowa' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 70, 'collate' => 'utf8_polish_ci', 'charset' => 'utf8'),
		'tel' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_polish_ci', 'comment' => 'telefon', 'charset' => 'utf8'),
		'vatno' => array('type' => 'string', 'null' => false, 'length' => 45, 'collate' => 'utf8_polish_ci', 'comment' => 'bez kresek', 'charset' => 'utf8'),
		'vatno_txt' => array('type' => 'string', 'null' => false, 'length' => 45, 'collate' => 'utf8_polish_ci', 'comment' => 'wprowadzony przez uzytkownika', 'charset' => 'utf8'),
		'waluta' => array('type' => 'string', 'null' => true, 'default' => 'PLN', 'length' => 3, 'collate' => 'utf8_polish_ci', 'comment' => 'PLN, EUR, USD, itd.', 'charset' => 'utf8'),
		'is_zaliczka' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'comment' => '0 - brak zaliczki, 1 - przelew, 2 - gotówka'),
		'wartosc_zaliczki' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'comment' => 'wartosc 1-100, jako warosc procentowa'),
		'platnosc' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 10, 'comment' => '0 - inna, 1 - przelew, 2 - gotówka, 3 - pobranie'),
		'termin_platnosci' => array('type' => 'integer', 'null' => false, 'default' => '7', 'length' => 10, 'comment' => 'ilosc dni'),
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
			'name' => 'Lorem ipsum dolor sit amet',
			'fullname' => 'Lorem ipsum dolor sit amet',
			'ulica' => 'Lorem ipsum dolor sit amet',
			'nr_budynku' => 'Lorem ipsum dolor sit amet',
			'miasto' => 'Lorem ipsum dolor sit amet',
			'kod' => 'Lorem ipsum dolor sit amet',
			'kraj' => 'Lorem ipsum dolor sit amet',
			'osoba_kontaktowa' => 'Lorem ipsum dolor sit amet',
			'tel' => 'Lorem ipsum dolor sit amet',
			'vatno' => 'Lorem ipsum dolor sit amet',
			'vatno_txt' => 'Lorem ipsum dolor sit amet',
			'waluta' => 'L',
			'is_zaliczka' => 1,
			'wartosc_zaliczki' => 1,
			'platnosc' => 1,
			'termin_platnosci' => 1,
			'created' => '2013-12-02 10:45:52',
			'modified' => '2013-12-02 10:45:52'
		),
	);

}
