<?php
App::uses('Event', 'Model');

/**
 * Event Test Case
 *
 */
class EventTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.event',
		'app.user',
		'app.order',
		'app.job',
		'app.card',
		'app.customer',
		'app.project'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Event = ClassRegistry::init('Event');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Event);

		parent::tearDown();
	}

}
