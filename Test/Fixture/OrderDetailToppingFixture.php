<?php
/**
 * OrderDetailToppingFixture
 *
 */
class OrderDetailToppingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'order_detail_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'topping_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'price' => array('type' => 'float', 'null' => false, 'default' => null, 'comment' => 'the price of the topping at the time the order was made'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_order_detail_toppings_order_details1_idx' => array('column' => 'order_detail_id', 'unique' => 0),
			'fk_order_detail_toppings_toppings1_idx' => array('column' => 'topping_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'order_detail_id' => 1,
			'topping_id' => 1,
			'price' => 1
		),
	);

}
