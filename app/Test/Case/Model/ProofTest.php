<?php
App::uses('Proof', 'Model');

/**
 * Proof Test Case
 *
 */
class ProofTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.proof',
		'app.card',
		'app.user',
		'app.customer',
		'app.address',
		'app.order',
		'app.event',
		'app.job',
		'app.upload',
		'app.cards_upload'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Proof = ClassRegistry::init('Proof');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Proof);

		parent::tearDown();
	}

}
