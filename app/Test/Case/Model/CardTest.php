<?php
App::uses('Card', 'Model');

/**
 * Card Test Case
 *
 */
class CardTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.card',
		'app.user',
		'app.customer',
		'app.project',
		'app.order',
		'app.job',
		'app.event'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Card = ClassRegistry::init('Card');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Card);

		parent::tearDown();
	}

}
