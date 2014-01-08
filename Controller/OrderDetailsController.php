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
            
      //if ($this->request->is('post')) {
        if ($this->Session->read('Auth.User')) {
        $this->loadModel('Order');
        $this->loadModel('MenuItem');
        $userid = $this->Auth->user('id');
        $usersorders = $this->Order->find('all', array(
        'conditions' => array('Order.user_id' => $userid, 'Order.location_id' => $location, 'Order.stage_id' => 1)
    ));
        //echo json_encode($usersorders);
                //exit;
        if(empty($usersorders)){
        
        $this->Order->set('user_id', $userid);
        $date = date('Y-m-d H:i:s');
        $count = $this->Order->find('count');
        $count = $count + 1;
        $this->Order->create();
        $menuitem = $this->MenuItem->find('all', array('conditions' => array('MenuItem.id' => $id)));
        //$this->Order->set('user_id', $id);
        //$this->OrderDetail->Order->set('id',$count);
        $this->Order->set(array('location_id' => $location,
            'stage_id' => 1,
            'orderdate' => $date,
            'total' => $menuitem[0]['MenuItem']['price'],
            'paid' => $menuitem[0]['MenuItem']['price'],
            'user_id' =>$userid,
            ));
//        $this->Order->set('stage_id', 1);
//        $this->Order->set('orderdate', $date);
       $menuitem = $this->MenuItem->find('all', array('conditions' => array('MenuItem.id' => $id)));
//        $this->Order->set('total', $menuitem[0]['MenuItem']['price']);
//        $this->Order->set('paid', $menuitem[0]['MenuItem']['price'] );
//        $this->Order->set('user_id', $userid);
        
        $this->Order->save();
        $orderid = $this->Order->getInsertID();
//        $this->OrderDetail->Order->set('id',$count);
//        $this->OrderDetail->Order->set('location_id', $location);
//        $this->OrderDetail->Order->set('stage_id', 1);
//        $this->OrderDetail->Order->set('orderdate', $date);
//        $this->OrderDetail->MenuItem->id = $id;
//        $menuitem = $this->MenuItem->find('all', array('conditions' => array('MenuItem.id' => $id)));
//        $this->OrderDetail->Order->set('total', $menuitem[0]['MenuItem']['price']);
//        $this->OrderDetail->Order->set('paid', $menuitem[0]['MenuItem']['price'] );
//        $this->OrderDetail->Order->set('user_id', $userid);
         $this->OrderDetail->save();
         $this->Session->setFlash("Successfully added to cart order id is " . $orderid);
         return $this->redirect($this->redirect($this->referer()));
        }
        else{echo "It's not empty";}
        exit;
       
        $this->Session->setFlash(__('Your authuser is' . $authuser));
        return $this->redirect('/');
    }
        if ($this->Auth->login()) {
            $this->Session->setFlash('You have been successfully logged in');
            return $this->redirect($this->Auth->redirect());
        }
        
        $this->Session->setFlash(__('Your email or password was incorrect.'));
    //}
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
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Order detail was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
}
