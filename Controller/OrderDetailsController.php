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
        $usersorders[0]['Order']['total'] = $usersorders[0]['Order']['total'] + $menuitem[0]['MenuItem']['price'];
        $this->Order->read(null, $usersorders[0]['Order']['id']);
        $this->Order->set('total', $usersorders[0]['Order']['total']);
        $this->Order->set('paid', $usersorders[0]['Order']['total']);
        $this->Order->save();
        //Update price
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
            $this->loadModel('OrderDetailTopping');
            $this->loadModel('MenuItem');
            $this->loadModel('Topping');
            $usersorders = $this->Order->find('all', array(
            'conditions' => array('Order.user_id' => $userid, 'Order.location_id' => $location, 'Order.stage_id' => 1)
            ));
            $count = 0;
            
            $orderDetails = $this->OrderDetail->find('all', array(
            'conditions' => array('order_id' => $usersorders[$count]['Order']['id'])
            ));
            
            while($count < count($orderDetails)){
                
                if($orderDetails[$count]['MenuItem']['title'] == 'Personal 10"'){
                    $toppings[$count] = $this->Topping->find('list', array('conditions' => array('Topping.item' => 'Personal 10"')));  
                }
                else if($orderDetails[$count]['MenuItem']['title'] == 'Medium 14"'){
                    $toppings[$count] = $this->Topping->find('list', array('conditions' => array('Topping.item' => 'Medium 14"')));
                }
                else if($orderDetails[$count]['MenuItem']['title'] == 'Large 16"'){
                    $toppings[$count] = $this->Topping->find('list', array('conditions' => array('Topping.item' => 'Large 16"')));
                }
                else if($orderDetails[$count]['MenuItem']['title'] == 'Extra Large 18"'){
                    $toppings[$count] = $this->Topping->find('list', array('conditions' => array('Topping.item' => 'Extra Large 18"')));
                }
                else if($orderDetails[$count]['MenuItem']['title'] == 'Cheese'){
                    $toppings[$count] = $this->Topping->find('list', array('conditions' => array('Topping.item' => 'Cheese')));
                }
                else{
                    $toppings[$count] = null;
                }
                $count++;
            }
            $count = 0;
            $this->set(compact('toppings'));
            $locations = $this->Location->find('all', array(
            'conditions' => array('id' => $location)));
            $this->set('orderDetails');
            $this->set('orderDetails', $orderDetails);
            $this->set('locationtitle', $locations[0]['Location']['title']);
            $this->set('ordertotal', $usersorders[0]['Order']['total']);
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
        
        public function addtopping($id = null){
            $this->layout = 'customer';
            $this->loadModel('MenuItem');
            $this->loadModel('Topping');
            $this->loadModel('OrderDetailTopping');
            $thisitem = $this->OrderDetail->find('all', array('conditions' => array('OrderDetail.id' => $id)));
            $toppingssofar = $this->OrderDetailTopping->find('all', array('conditions' => array('OrderDetailTopping.order_detail_id' => $id)));
            $this->set('toppingssofar', $toppingssofar);
            $itemtitle = $thisitem[0]['MenuItem']['title'];
            $toppings = $this->Topping->find('list', array('conditions' => array('Topping.item' => $itemtitle)));
            if ($this->request->is('post')) {
                        
			
                        $this->OrderDetailTopping->create();
                        $toppingselected = $this->Topping->find('all', array('conditions' => array('Topping.id' => $this->request->data['OrderDetail']['toppings'])));
                        $this->OrderDetailTopping->set(array('order_detail_id' => $id, 
                            'topping_id' => $this->request->data['OrderDetail']['toppings'],
                            'price' => $toppingselected[0]['Topping']['price']));
                        $this->OrderDetailTopping->save();
                        
		}
                $this->set('item', $itemtitle);
                
                $this->set(compact('toppings'));
                
           
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
                $this->loadModel('Order');
                $userorderdetail = $usersorders = $this->OrderDetail->find('all', array(
            'conditions' => array('OrderDetail.id' => $id)
            ));
                $usersorders = $this->Order->find('all', array(
            'conditions' => array('Order.id' => $userorderdetail[0]['OrderDetail']['order_id'])
            ));
                $toppingsforitem = $this->OrderDetailTopping->find('all', array('conditions' => array('OrderDetailTopping.order_detail_id' => $id)));
                foreach($toppingsforitem as $toppings){
                    $this->OrderDetailTopping->id = $toppings['OrderDetailTopping']['id'];
                    $this->OrderDetailTopping->delete();
                }
                //update the total for the order...because once an order detail is removed the total must be updated
                //paid is updated to because it is kept the same as total until tax is calculated in.
                $newtotal = $usersorders[0]['Order']['total'] - $userorderdetail[0]['OrderDetail']['price'];
                $this->Order->read(null, $usersorders[0]['Order']['id']);
                $this->Order->set('total', $newtotal);
                $this->Order->set('paid', $newtotal);
                $this->Order->save();
                
		if ($this->OrderDetail->delete()) {
			$this->Session->setFlash(__('Order detail deleted'));
			return $this->redirect($this->referer());
		}
		$this->Session->setFlash(__('Order detail was not deleted'));
		return $this->redirect($this->referer());
	}
        
        public function deleteitemcustomer($id = null){
            $this->OrderDetail->id = $id;
		if (!$this->OrderDetail->exists()) {
			throw new NotFoundException(__('Invalid order detail'));
		}
		$this->request->onlyAllow('post', 'delete', 'get');
                $this->loadModel('Order');
                $this->loadModel('OrderDetailTopping');
                $userorderdetail = $usersorders = $this->OrderDetail->find('all', array(
            'conditions' => array('OrderDetail.id' => $id)
            ));
                $usersorders = $this->Order->find('all', array(
            'conditions' => array('Order.id' => $userorderdetail[0]['OrderDetail']['order_id'])
            ));
                $toppingsforitem = $this->OrderDetailTopping->find('all', array('conditions' => array('OrderDetailTopping.order_detail_id' => $id)));
                if($usersorders[0]['Order']['user_id'] == $this->Auth->user('id')){
                //update the total for the order...because once an order detail is removed the total must be updated
                //paid is updated to because it is kept the same as total until tax is calculated in.
                foreach($toppingsforitem as $toppings){
                    $this->OrderDetailTopping->id = $toppings['OrderDetailTopping']['id'];
                    $this->OrderDetailTopping->delete();
                }
                $newtotal = $usersorders[0]['Order']['total'] - $userorderdetail[0]['OrderDetail']['price'];
                $this->Order->read(null, $usersorders[0]['Order']['id']);
                $this->Order->set('total', $newtotal);
                $this->Order->set('paid', $newtotal);
                $this->Order->save();
                
		if ($this->OrderDetail->delete()) {
			$this->Session->setFlash(__('Item removed from cart'));
			return $this->redirect($this->referer());
		}
                }
                else{
		$this->Session->setFlash(__('Order detail was not deleted'));
		return $this->redirect($this->referer());
                }
            
        }
}
