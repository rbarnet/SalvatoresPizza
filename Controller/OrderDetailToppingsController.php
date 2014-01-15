<?php
App::uses('AppController', 'Controller');
/**
 * OrderDetailToppings Controller
 *
 * @property OrderDetailTopping $OrderDetailTopping
 * @property PaginatorComponent $Paginator
 */
class OrderDetailToppingsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->OrderDetailTopping->recursive = 0;
		$this->set('orderDetailToppings', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->OrderDetailTopping->exists($id)) {
			throw new NotFoundException(__('Invalid order detail topping'));
		}
		$options = array('conditions' => array('OrderDetailTopping.' . $this->OrderDetailTopping->primaryKey => $id));
		$this->set('orderDetailTopping', $this->OrderDetailTopping->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->OrderDetailTopping->create();
			if ($this->OrderDetailTopping->save($this->request->data)) {
				$this->Session->setFlash(__('The order detail topping has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order detail topping could not be saved. Please, try again.'));
			}
		}
		$orderDetails = $this->OrderDetailTopping->OrderDetail->find('list');
		$toppings = $this->OrderDetailTopping->Topping->find('list');
		$this->set(compact('orderDetails', 'toppings'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->OrderDetailTopping->exists($id)) {
			throw new NotFoundException(__('Invalid order detail topping'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->OrderDetailTopping->save($this->request->data)) {
				$this->Session->setFlash(__('The order detail topping has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order detail topping could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('OrderDetailTopping.' . $this->OrderDetailTopping->primaryKey => $id));
			$this->request->data = $this->OrderDetailTopping->find('first', $options);
		}
		$orderDetails = $this->OrderDetailTopping->OrderDetail->find('list');
		$toppings = $this->OrderDetailTopping->Topping->find('list');
		$this->set(compact('orderDetails', 'toppings'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->OrderDetailTopping->id = $id;
		if (!$this->OrderDetailTopping->exists()) {
			throw new NotFoundException(__('Invalid order detail topping'));
		}
		$this->request->onlyAllow('post', 'delete', 'get');
		if ($this->OrderDetailTopping->delete()) {
			$this->Session->setFlash(__('The order detail topping has been deleted.'));
		} else {
			$this->Session->setFlash(__('The order detail topping could not be deleted. Please, try again.'));
		}
		return $this->redirect($this->redirect($this->referer()));
	}}
