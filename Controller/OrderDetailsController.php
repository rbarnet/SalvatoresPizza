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
            $this->loadModel('MenuItem');//These models need to be loaded in order to add an item to the cart.  
            $userid = $this->Auth->user('id');//Gets the id of the user making this request to ensure that only the user with which the order is associated
            //can add anything to the cart.  
            $usersorders = $this->Order->find('all', array(
            'conditions' => array('Order.user_id' => $userid, 'Order.location_id' => $location, 'Order.stage_id' => 1)
            ));
            //Finds all the orders associated with this particular user at a particular location (either Hoover or Trussville) and sees if there is an order
            //whose stage is currently in cart.  Items can only be added to a particular order if there is an order for a particular location that's status is 
            //currently in the cart.
        $menuitem = $this->MenuItem->find('all', array('conditions' => array('MenuItem.id' => $id)));
        //Find the menuitem that is trying to be added
        if(empty($usersorders)){
            //If no order was found for this particular location that's status is currently in the cart.  Create a new order.  
            $this->Order->set('user_id', $userid);
            $date = date('Y-m-d H:i:s');
            $count = $this->Order->find('count');
            $count = $count + 1;
            //the count fields may be unecessary too because that was going to be used to ensure when creating a new order entry in the database that
            //the id is set to 1 higher than the current highest id
            $this->Order->create();
            //$menuitem = $this->MenuItem->find('all', array('conditions' => array('MenuItem.id' => $id)));  This line is unnecessary
            $this->Order->set(array('location_id' => $location,
                'stage_id' => 1,
                'orderdate' => $date,
                'note' => '',
                'total' => $menuitem[0]['MenuItem']['price'],
                'paid' => $menuitem[0]['MenuItem']['price'],
                'user_id' =>$userid,
                ));//Create a new entry in the order table and save that entry
            //The date, the total is set to the price of the menu item as is the amount paid.  
            $this->Order->save();
            $orderid = $this->Order->getInsertID();
            $this->OrderDetail->create();
            $this->OrderDetail->set(array('order_id' => $orderid,
            'menu_item_id' => $id,
            'price' => $menuitem[0]['MenuItem']['price']));
            //Create the new order detail entry that will be associated with the order entry that was just created
           $this->OrderDetail->save(); 
           $this->Session->setFlash("Successfully added to cart");
           return $this->redirect($this->redirect($this->referer()));
           //Redirect the user back to the page that they clicked the button.
        }
        else{
        $this->OrderDetail->create();
        //Reset the order detail model  
        $this->OrderDetail->set(array('order_id' => $usersorders[0]['Order']['id'],
            'menu_item_id' => $id,
            'price' => $menuitem[0]['MenuItem']['price']));
        $usersorders[0]['Order']['total'] = $usersorders[0]['Order']['total'] + $menuitem[0]['MenuItem']['price'];
        $this->Order->read(null, $usersorders[0]['Order']['id']);
        $this->Order->set('total', $usersorders[0]['Order']['total']);
        $this->Order->set('paid', $usersorders[0]['Order']['total']);
        //Update the total and the amount paid
        $this->Order->save();
        //Update price
        $this->OrderDetail->save(); 
        //Save the order detail
        $this->Session->setFlash("Successfully added to cart");
        return $this->redirect($this->redirect($this->referer()));
        //Redirect the user back to where they came from.
        }
    }
    //The user is obviously not logged in.
        $this->Session->setFlash(__('You must be logged in to use this function.'));
        $this->redirect(array('controller' => 'user', 'action' => 'login'));
   
        }
        
        public function viewcart($location = null){
            //location needs to be passed in because you can have a cart for one of two locations.  
            $this->layout = 'customer';
            //We want the view to be rendered with the customer layout.  
            $userid = $this->Auth->user('id');
            //Get the user id of the customer that is currently logged in.  
            $this->loadModel('Order');
            $this->loadModel('Location');
            $this->loadModel('OrderDetailTopping');
            $this->loadModel('MenuItem');
            $this->loadModel('Topping');
            //These models need to be loaded in order to view the cart.  
            
            $usersorders = $this->Order->find('all', array(
            'conditions' => array('Order.user_id' => $userid, 'Order.location_id' => $location, 'Order.stage_id' => 1)
            ));//Find the order for this particular user associated with this particular location that is currently in the cart.  
            $taxrate = $usersorders[0]['Location']['taxrate'];
            $taxtotal = 0;
            $count = 0;
            //A counter.
            $orderDetails = $this->OrderDetail->find('all', array(
            'conditions' => array('order_id' => $usersorders[$count]['Order']['id'])
            ));
            
            //Find all the items that are currently associated with this particular order.  
            $toppingsarray = array();
            $toppingstotal = 0;
            //The total price of the toppings associated with this particular order.  
            $toppingstitlearray = array();
            //Two arrays that are used to keep track of the title of the topping and the subtotals for the toppings.  
            $toppingssubtotalarray = array();
            $itempricearray = array();
            //loop through all the items associated with a particular order.  Find out if any toppings are already associated with it in the order details toppings table
            while($count < count($orderDetails)){
                $toppingsonitem = $this->OrderDetailTopping->find('all', array('conditions' => array('OrderDetailTopping.order_detail_id' => $orderDetails[$count]['OrderDetail']['id'])));
                //Finds the toppings currently on the item
                array_push($toppingsarray, $toppingsonitem);//Push the result of this onto the toppings array.  This may be unnecessary.  
                $toppingsstring = '';
                $toppingssubtotal = 0;
                $count2 = 0;
                //Initialize the toppingstring and set the subtotal to zero
                foreach($toppingsonitem as $itemtoppings){
                    //For each of the toppings currently on the item add the title to the toppings string.  Add the price of the topping to the current subtotal
                    //Add the price of topping to the total of all toppings currently associated with the order.
                    $toppingstotal += $itemtoppings['OrderDetailTopping']['price'];
                    $toppingssubtotal += $itemtoppings['OrderDetailTopping']['price'];
                    $toppingsstring .= $itemtoppings['Topping']['title'] . ' ';
                }
                array_push($toppingstitlearray, $toppingsstring);
                array_push($toppingssubtotalarray, $toppingssubtotal);
                //Push the subtotal of the toppings for a particular item and the string of the toppingss currently associated with the item on the order
                //to the array that will then be passed to the view.  
                //These nested if statements are only there to determine if an add toppings button needs to be rendered in the view.  
                //This could simply be one if statement.  
                if($orderDetails[$count]['MenuItem']['title'] == 'Personal 10"'){
                    //$toppings[$count] = $this->Topping->find('list', array('conditions' => array('Topping.item' => 'Personal 10"')));
                    $toppings[$count] = 'Topping found';
                }
                else if($orderDetails[$count]['MenuItem']['title'] == 'Medium 14"'){
                    //$toppings[$count] = $this->Topping->find('list', array('conditions' => array('Topping.item' => 'Medium 14"')));
                    $toppings[$count] = 'Topping found';
                }
                else if($orderDetails[$count]['MenuItem']['title'] == 'Large 16"'){
                    //$toppings[$count] = $this->Topping->find('list', array('conditions' => array('Topping.item' => 'Large 16"')));
                    $toppings[$count] = 'Topping found';
                }
                else if($orderDetails[$count]['MenuItem']['title'] == 'Extra Large 18"'){
                    //$toppings[$count] = $this->Topping->find('list', array('conditions' => array('Topping.item' => 'Extra Large 18"')));
                    $toppings[$count] = 'Topping found';
                }
                else if($orderDetails[$count]['MenuItem']['title'] == 'Cheese' || $orderDetails[$count]['MenuItem']['menu_category_id'] == 5 || $orderDetails[$count]['MenuItem']['menu_category_id'] == 2){
                    //$toppings[$count] = $this->Topping->find('list', array('conditions' => array('Topping.item' => 'Cheese')));
                    $toppings[$count] = 'Topping found';
                }
                else{
                    $toppings[$count] = null;
                }
                $itemprice = 0;
                $itemprice = $orderDetails[$count]['OrderDetail']['price'] + $toppingssubtotal;
                $taxforitem = $itemprice * $taxrate;
                //$taxrounded = round($taxforitem, 2);
                $taxtotal += $taxforitem;
                array_push($itempricearray, $itemprice);
                $count++;
            }
            $taxafterround = round($taxtotal, 2);
            $count = 0;
            //debug($toppingsarray);
            //pass the titles of the toppings and the subtotal of the toppings in respect to each item to the view
            $this->set('toppingstitlearray', $toppingstitlearray);
            $this->set('toppingsubtotalarray', $toppingssubtotalarray);
            $this->set(compact('toppings'));
            $this->set('itempricearray', $itempricearray);
            $locations = $this->Location->find('all', array(
            'conditions' => array('id' => $location)));
            $this->set('orderDetails');
            $this->set('orderDetails', $orderDetails);
            //Pass the items associated with the order to the view.  
            $this->set('locationtitle', $locations[0]['Location']['title']);
            //Pass the title of the location to the view
            $this->set('ordertotal', $usersorders[0]['Order']['total']);
            //Pass the total of the order without toppings and the total of the toppings to the view
            $this->set('toppingstotal', $toppingstotal);
            $this->set('tax', $taxafterround);
            $projectedtotal = $toppingstotal + $usersorders[0]['Order']['total'];
            $this->set('projectedtotal', $projectedtotal);//Pass the projected total which adds toppingstotal to the total of the order without toppings.
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
            $this->layout = 'customer';//Set the layout to the customer
            $this->loadModel('MenuItem');
            $this->loadModel('Topping');
            $this->loadModel('OrderDetailTopping');//We need to load these models in order to add a topping.  In the database, toppings are not directly
            //connected to MenuItems.  They are connected indirectly.  The topping.item field holds the title of the item to which the topping belongs too.
            //For instance, there are 25 toppings that can be put on a pizza, and there are four types of New York Style Thin Crust Cheese "Personal 10"", "Medium 14 "" etc.
            //So there are 100 toppings for these pizzas.  In other words, each topping even though it is the same is listed differently in the toppings table because the 
            //price changes depending on the item.  
            $thisitem = $this->OrderDetail->find('all', array('conditions' => array('OrderDetail.id' => $id)));//Find the orderdetail using the id passed in.  This may be uneccesary.
            $toppingssofar = $this->OrderDetailTopping->find('all', array('conditions' => array('OrderDetailTopping.order_detail_id' => $id)));
            //Find the toppings that are so far on the order detail.  That is why this one is querying the OrderDetailTopping table.  
            $this->set('toppingssofar', $toppingssofar);
            //Pass this to the view
            $itemtitle = $thisitem[0]['MenuItem']['title'];//This is used to get the item title from the first query.
            $toppings = $this->Topping->find('list', array('conditions' => array('Topping.item' => $itemtitle)));
            //The item title is used to find all the possible toppings that can be put on an item in order to fill the combo box.  
            if ($this->request->is('post')) {
                        //adds a topping if the submit button on the form to add a topping has been pressed.
			
                        $this->OrderDetailTopping->create();
                        //Clear the order details model
                        $toppingselected = $this->Topping->find('all', array('conditions' => array('Topping.id' => $this->request->data['OrderDetail']['toppings'])));
                        //Takes the selected topping id from the input and gets the record field associated with it in the toppings table.
                        $this->OrderDetailTopping->set(array('order_detail_id' => $id, 
                            'topping_id' => $this->request->data['OrderDetail']['toppings'],
                            'price' => $toppingselected[0]['Topping']['price']));
                        //Sets the neccessary fields in the OrderDetailTopping model in order to create an entry in the database
                        $this->OrderDetailTopping->save();
                        //Saves it
                        $this->Session->setFlash(__('Topping successfully added.'));
                        return $this->redirect($this->redirect($this->referer()));
                        //Redirects the user back to this page.
                        
		}
                $this->set('item', $itemtitle);
                //Passes the item title to the view for display purposes.
                $this->set(compact('toppings'));
                //Passes the toppings to the view to the combo box
           
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
                $this->loadModel('OrderDetailTopping');
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
