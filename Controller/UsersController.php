<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        
        public function beforeFilter() {
    parent::beforeFilter();

    // For CakePHP 2.0
    //$this->Auth->allow('*');

    // For CakePHP 2.1 and up
    $this->Auth->allow('add', 'login', 'logout');
}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
            $this->layout = 'customer';
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				return $this->redirect(array('controller' => 'menucategories','action' => 'menu'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}
        
        public function addbackoffice() {
            $this->layout = 'customer';
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				return $this->redirect(array('action' => 'home'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}
        
        public function mobile_add_user() {
            $this->layout = 'customermobile';
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				return $this->redirect(array('action' => 'home'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
        
//        public function login() {
//            $this->layout = 'customer';
//            if ($this->request->is('post')) {
//                $users = $this->User->find('all', array('conditions' => array("username='{$this->request->data['User']['username']}'", "password='{$this->request->data['User']['password']}'")));
//                if (count($users) > 0) {
//                    $this->Session->setFlash('valid username password: you are in!');
//                    $this->Session->write('username',$this->request->data['User']['username']);
//                    $this->Session->write('userid',$users[0]['User']['id']);
//                    $this->set('currentUser',$this->request->data['User']['username']);
//                    $this->redirect(array('controller'=>'inventories','action'=>'shop'));
//                } else {
//                    $this->Session->setFlash('invalid, try again');
//                }
//            }
//        }
        
        public function login() {
            $this->layout = "customer";
    if ($this->request->is('post')) {
        if ($this->Session->read('Auth.User')) {
        $this->Session->setFlash('You are already logged in!');
        return $this->redirect('/');
    }
        if ($this->Auth->login()) {
            $this->Session->setFlash('You have been successfully logged in');
            return $this->redirect($this->Auth->redirect());
        }
        
        $this->Session->setFlash(__('Your email or password was incorrect.'));
    }
}

public function logout(){
    $this->Session->setFlash('You have been successfully logged out');
    $this->redirect($this->Auth->logout());
}
}
