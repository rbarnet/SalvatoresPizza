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
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'location_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'location where this order should be picked up'),
		'orderdate' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'date and time the order was placed'),
		'stage_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'the stage that the order is in'),
		'total' => array('type' => 'float', 'null' => true, 'default' => null),
		'paid' => array('type' => 'float', 'null' => true, 'default' => null, 'comment' => 'difference b/t total and paid is the tip?'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_orders_users1_idx' => array('column' => 'user_id', 'unique' => 0),
			'fk_orders_locations1_idx' => array('column' => 'location_id', 'unique' => 0),
			'fk_orders_stages1_idx' => array('column' => 'stage_id', 'unique' => 0)
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
			'user_id' => 1,
			'location_id' => 1,
			'orderdate' => '2014-01-04 05:45:24',
			'stage_id' => 1,
			'total' => 1,
			'paid' => 1
		),
	);

}
