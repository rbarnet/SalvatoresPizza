<?php
App::uses('Topping', 'Model');

/**
 * Topping Test Case
 *
 */
class ToppingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.topping'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Topping = ClassRegistry::init('Topping');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Topping);

		parent::tearDown();
	}

}
