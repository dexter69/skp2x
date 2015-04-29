<?php
/**
 * ProjectFixture
 *
 */
class ProjectFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 45, 'collate' => 'utf8_polish_ci', 'comment' => 'Nazwa projektu', 'charset' => 'utf8'),
		'a_material' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 3, 'comment' => '1 - standard, 2 - BIO, 3 - TRANS'),
		'r_material' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 3, 'comment' => '1 - standard, 2 - BIO, 3 - TRANS'),
		'a_c' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'C z cmyk - 1 jest, 0 nie ma'),
		'r_c' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'C z cmyk - 1 jest, 0 nie ma'),
		'a_m' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'M z cmyk - 1 jest, 0 nie ma'),
		'r_m' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'M z cmyk - 1 jest, 0 nie ma'),
		'a_y' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Y z cmyk - 1 jest, 0 nie ma'),
		'r_y' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Y z cmyk - 1 jest, 0 nie ma'),
		'a_k' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'K z cmyk - 1 jest, 0 nie ma'),
		'r_k' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'K z cmyk - 1 jest, 0 nie ma'),
		'a_pant' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'comment' => 'liczba pantonów'),
		'r_pant' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'comment' => 'liczba pantonów'),
		'a_lam' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 3, 'comment' => 'laminat 0-brak, 1-błysk, 2-gład, 3-chrop'),
		'r_lam' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 3, 'comment' => 'laminat 0-brak, 1-błysk, 2-gład, 3-chrop'),
		'mag' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'comment' => 'pasek mag. 0-brak, 1-HiCo, 2-LoCo'),
		'cmyk_comment' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_polish_ci', 'charset' => 'utf8'),
		'a_podklad' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'comment' => 'podklad z sita, 0-brak, 1-inny, 2-... itd'),
		'a_wybr' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'wybranie w sicie - 1 jest, 0 nie ma'),
		'r_podklad' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'comment' => 'podklad z sita, 0-brak, 1-inny, 2-... itd'),
		'r_wybr' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'wybranie w sicie - 1 jest, 0 nie ma'),
		'a_zadruk' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'comment' => 'zadruk z sita, 0-brak, 1-inny, 2-... itd'),
		'r_zadruk' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'comment' => 'zadruk z sita, 0-brak, 1-inny, 2-... itd'),
		'a_podpis' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'comment' => 'pasek do podpisu, 0-brak, 1-przeźro, 2-biały'),
		'r_podpis' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'comment' => 'pasek do podpisu, 0-brak, 1-przeźro, 2-biały'),
		'a_zdrapka' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'zdrapka z sita - 1 jest, 0 nie ma'),
		'r_zdrapka' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'zdrapka z sita - 1 jest, 0 nie ma'),
		'a_lakpuch' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'lakier puchnący - 1 jest, 0 nie ma'),
		'r_lakpuch' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'lakier puchnący - 1 jest, 0 nie ma'),
		'a_lakblys' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'lakier błyszczący - 1 jest, 0 nie ma'),
		'r_lakblys' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'lakier błyszczący - 1 jest, 0 nie ma'),
		'sito_comment' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_polish_ci', 'charset' => 'utf8'),
		'isperso' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'czy jest personalizacja'),
		'perso' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_polish_ci', 'comment' => 'szczegóły dot. personalizacji', 'charset' => 'utf8'),
		'dziurka' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'comment' => 'dziurka, 0-brak, 1-inna, 2-standard, 3 -... itd'),
		'chip' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'comment' => 'chip, 0-brak, 1-inny, 2-unique, 3-mifare, 4-sle itd'),
		'ksztalt' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'comment' => 'nietypowy kształt karty, 0-brak, 1-inny, ... itd'),
		'hologram' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'hologram - 1 jest, 0 nie ma'),
		'option_comment' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_polish_ci', 'comment' => 'komentarz do opcji dodatkowych', 'charset' => 'utf8'),
		'project_comment' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_polish_ci', 'charset' => 'utf8'),
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
			'name' => 'Lorem ipsum dolor sit amet',
			'a_material' => 1,
			'r_material' => 1,
			'a_c' => 1,
			'r_c' => 1,
			'a_m' => 1,
			'r_m' => 1,
			'a_y' => 1,
			'r_y' => 1,
			'a_k' => 1,
			'r_k' => 1,
			'a_pant' => 1,
			'r_pant' => 1,
			'a_lam' => 1,
			'r_lam' => 1,
			'mag' => 1,
			'cmyk_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'a_podklad' => 1,
			'a_wybr' => 1,
			'r_podklad' => 1,
			'r_wybr' => 1,
			'a_zadruk' => 1,
			'r_zadruk' => 1,
			'a_podpis' => 1,
			'r_podpis' => 1,
			'a_zdrapka' => 1,
			'r_zdrapka' => 1,
			'a_lakpuch' => 1,
			'r_lakpuch' => 1,
			'a_lakblys' => 1,
			'r_lakblys' => 1,
			'sito_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'isperso' => 1,
			'perso' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'dziurka' => 1,
			'chip' => 1,
			'ksztalt' => 1,
			'hologram' => 1,
			'option_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'project_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2013-12-02 10:46:31',
			'modified' => '2013-12-02 10:46:31'
		),
	);

}
