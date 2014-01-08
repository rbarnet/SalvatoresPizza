<?php
App::uses('AppController', 'Controller');
/**
 * OrderDetails Controller
 *
 * @property OrderDetail $OrderDetail
 * @property PaginatorComponent $Paginator
 */
class OrderDetailsController extends AppController {

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
		$this->OrderDetail->recursive = 0;
		$this->set('orderDetails', $this->Paginator->paginate());
	}
        
        public function addtocart($id = null, $location = null){
        if ($this->Session->read('Auth.User')) {
            $this->loadModel('Order');
            $this->loadModel('MenuItem');
            $userid = $this->Auth->user('id');
            $usersorders = $this->Order->find('all', array(
            'conditions' => array('Order.user_id' => $userid, 'Order.location_id' => $location, 'Order.stage_id' => 1)
            ));
        $menuitem = $this->MenuItem->find('all', array('conditions' => array('MenuItem.id' => $id)));
        if(empty($usersorders)){
            $this->Order->set('user_id', $userid);
            $date = date('Y-m-d H:i:s');
            $count = $this->Order->find('count');
            $count = $count + 1;
            $this->Order->create();
            $menuitem = $this->MenuItem->find('all', array('conditions' => array('MenuItem.id' => $id)));
            $this->Order->set(array('location_id' => $location,
                'stage_id' => 1,
                'orderdate' => $date,
                'total' => $menuitem[0]['MenuItem']['price'],
                'paid' => $menuitem[0]['MenuItem']['price'],
                'user_id' =>$userid,
                ));
            $this->Order->save();
            $orderid = $this->Order->getInsertID();
            $this->OrderDetail->create();
            $this->OrderDetail->set(array('order_id' => $orderid,
            'menu_item_id' => $id,
            'price' => $menuitem[0]['MenuItem']['price']));
           $this->OrderDetail->save(); 
           $this->Session->setFlash("Successfully added to cart");
           return $this->redirect($this->redirect($this->referer()));
        }
        else{
        $this->OrderDetail->create();
        $this->OrderDetail->set(array('order_id' => $usersorders[0]['Order']['id'],
            'menu_item_id' => $id,
            'price' => $menuitem[0]['MenuItem']['price']));
        $this->OrderDetail->save(); 
        $this->Session->setFlash("Successfully added to cart");
        return $this->redirect($this->redirect($this->referer()));
        }
    }
        $this->Session->setFlash(__('You must be logged in to use this function.'));
        $this->redirect(array('controller' => 'user', 'action' => 'login'));
   
        }
        
        public function viewcart($location = null){
            $this->layout = 'customer';
            $userid = $this->Auth->user('id');
            $this->loadModel('Order');
            $this->loadModel('Location');
            $usersorders = $this->Order->find('all', array(
            'conditions' => array('Order.user_id' => $userid, 'Order.location_id' => $location, 'Order.stage_id' => 1)
            ));
            $count = 0;
            
            $orderDetails = $this->OrderDetail->find('all', array(
            'conditions' => array('order_id' => $usersorders[$count]['Order']['id'])
            ));
            $locations = $this->Location->find('all', array(
            'conditions' => array('id' => $location)));
            $this->set('orderDetails');
            $this->set('orderDetails', $orderDetails);
            $this->set('locationtitle', $locations[0]['Location']['title']);
        }
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->OrderDetail->exists($id)) {
			throw new NotFoundException(__('Invalid order detail'));
		}
		$options = array('conditions' => array('OrderDetail.' . $this->OrderDetail->primaryKey => $id));
		$this->set('orderDetail', $this->OrderDetail->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->OrderDetail->create();
			if ($this->OrderDetail->save($this->request->data)) {
				$this->Session->setFlash(__('The order detail has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order detail could not be saved. Please, try again.'));
			}
		}
		$orders = $this->OrderDetail->Order->find('list');
		$menuItems = $this->OrderDetail->MenuItem->find('list');
		$this->set(compact('orders', 'menuItems'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->OrderDetail->exists($id)) {
			throw new NotFoundException(__('Invalid order detail'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->OrderDetail->save($this->request->data)) {
				$this->Session->setFlash(__('The order detail has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order detail could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('OrderDetail.' . $this->OrderDetail->primaryKey => $id));
			$this->request->data = $this->OrderDetail->find('first', $options);
		}
		$orders = $this->OrderDetail->Order->find('list');
		$menuItems = $this->OrderDetail->MenuItem->find('list');
		$this->set(compact('orders', 'menuItems'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->OrderDetail->id = $id;
		if (!$this->OrderDetail->exists()) {
			throw new NotFoundException(__('Invalid order detail'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->OrderDetail->delete()) {
			$this->Session->setFlash(__('Order detail deleted'));
			return $this->redirect($this->referer());
		}
		$this->Session->setFlash(__('Order detail was not deleted'));
		return $this->redirect($this->referer());
	}
}
