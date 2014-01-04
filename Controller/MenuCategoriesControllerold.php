<?php
App::uses('AppController', 'Controller');
/**
 * MenuCategories Controller
 *
 * @property MenuCategory $MenuCategory
 * @property PaginatorComponent $Paginator
 */
class MenuCategoriesController extends AppController {

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
		$this->MenuCategory->recursive = 0;
		$this->set('menuCategories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->MenuCategory->exists($id)) {
			throw new NotFoundException(__('Invalid menu category'));
		}
		$options = array('conditions' => array('MenuCategory.' . $this->MenuCategory->primaryKey => $id));
		$this->set('menuCategory', $this->MenuCategory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MenuCategory->create();
			if ($this->MenuCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The menu category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The menu category could not be saved. Please, try again.'));
			}
		}
		$parentMenuCategories = $this->MenuCategory->ParentMenuCategory->find('list');
		$this->set(compact('parentMenuCategories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->MenuCategory->exists($id)) {
			throw new NotFoundException(__('Invalid menu category'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->MenuCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The menu category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The menu category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('MenuCategory.' . $this->MenuCategory->primaryKey => $id));
			$this->request->data = $this->MenuCategory->find('first', $options);
		}
		$parentMenuCategories = $this->MenuCategory->ParentMenuCategory->find('list');
		$this->set(compact('parentMenuCategories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->MenuCategory->id = $id;
		if (!$this->MenuCategory->exists()) {
			throw new NotFoundException(__('Invalid menu category'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->MenuCategory->delete()) {
			$this->Session->setFlash(__('The menu category has been deleted.'));
		} else {
			$this->Session->setFlash(__('The menu category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
