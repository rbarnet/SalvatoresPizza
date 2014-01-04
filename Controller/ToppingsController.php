<?php
App::uses('AppController', 'Controller');
/**
 * Toppings Controller
 *
 * @property Topping $Topping
 * @property PaginatorComponent $Paginator
 */
class ToppingsController extends AppController {

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
		$this->Topping->recursive = 0;
		$this->set('toppings', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Topping->exists($id)) {
			throw new NotFoundException(__('Invalid topping'));
		}
		$options = array('conditions' => array('Topping.' . $this->Topping->primaryKey => $id));
		$this->set('topping', $this->Topping->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Topping->create();
			if ($this->Topping->save($this->request->data)) {
				$this->Session->setFlash(__('The topping has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The topping could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Topping->exists($id)) {
			throw new NotFoundException(__('Invalid topping'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Topping->save($this->request->data)) {
				$this->Session->setFlash(__('The topping has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The topping could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Topping.' . $this->Topping->primaryKey => $id));
			$this->request->data = $this->Topping->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Topping->id = $id;
		if (!$this->Topping->exists()) {
			throw new NotFoundException(__('Invalid topping'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Topping->delete()) {
			$this->Session->setFlash(__('The topping has been deleted.'));
		} else {
			$this->Session->setFlash(__('The topping could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
