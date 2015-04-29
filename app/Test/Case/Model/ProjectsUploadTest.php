<?php
App::uses('ProjectsUpload', 'Model');

/**
 * ProjectsUpload Test Case
 *
 */
class ProjectsUploadTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.projects_upload',
		'app.project',
		'app.card',
		'app.user',
		'app.customer',
		'app.order',
		'app.event',
		'app.job',
		'app.upload'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ProjectsUpload = ClassRegistry::init('ProjectsUpload');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ProjectsUpload);

		parent::tearDown();
	}

}
