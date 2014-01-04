<?php
App::uses('AppModel', 'Model');
/**
 * OrderDetailTopping Model
 *
 * @property OrderDetail $OrderDetail
 * @property Topping $Topping
 */
class OrderDetailTopping extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'order_detail_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'topping_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'OrderDetail' => array(
			'className' => 'OrderDetail',
			'foreignKey' => 'order_detail_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Topping' => array(
			'className' => 'Topping',
			'foreignKey' => 'topping_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
