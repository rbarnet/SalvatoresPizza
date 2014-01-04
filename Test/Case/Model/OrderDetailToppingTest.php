<?php
App::uses('OrderDetailTopping', 'Model');

/**
 * OrderDetailTopping Test Case
 *
 */
class OrderDetailToppingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.order_detail_topping',
		'app.order_detail',
		'app.topping'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->OrderDetailTopping = ClassRegistry::init('OrderDetailTopping');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->OrderDetailTopping);

		parent::tearDown();
	}

}
