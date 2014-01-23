<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'paypal', array
(
    'file' => 'merchant-sdk-php' . DS . 'lib' . DS . 'PayPal' . DS. 'EBLBaseComponents' . DS . 'PaymentDetailsType'
));
        
/**
 * Orders Controller
 *
 * @property Order $Order
 * @property PaginatorComponent $Paginator
 */
class OrdersController extends AppController {

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
		$this->Order->recursive = 0;
		$this->set('orders', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Order->exists($id)) {
			throw new NotFoundException(__('Invalid order'));
		}
		$options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
		$this->set('order', $this->Order->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Order->create();
			if ($this->Order->save($this->request->data)) {
				$this->Session->setFlash(__('The order has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order could not be saved. Please, try again.'));
			}
		}
		$users = $this->Order->User->find('list');
		$locations = $this->Order->Location->find('list');
                $stages = $this->Order->Stage->find('list', array('fields' => array('description')));
		$this->set(compact('users', 'locations', 'stages'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Order->exists($id)) {
			throw new NotFoundException(__('Invalid order'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Order->save($this->request->data)) {
				$this->Session->setFlash(__('The order has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
			$this->request->data = $this->Order->find('first', $options);
		}
		$users = $this->Order->User->find('list');
		$locations = $this->Order->Location->find('list');
                $stages = $this->Order->Stage->find('list', array('fields' => array('description')));
		$this->set(compact('users', 'locations', 'stages'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Order->id = $id;
		if (!$this->Order->exists()) {
			throw new NotFoundException(__('Invalid order'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Order->delete()) {
			$this->Session->setFlash(__('Order deleted'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Order was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
        
        public function checkout($id = null){
            require_once('F:/xampp/htdocs/SalvatoresPizza/Vendor/autoload.php');//Not sure if this necessary  
            $this->loadModel('OrderDetail');
            $this->loadModel('OrderDetailTopping');
            //We need these models loaded to work with them
           $orderDetails = $this->OrderDetail->find('all', array(
            'conditions' => array('order_id' => $id)
            ));//find all the items associated with this particular order
            $toppingsarray = array();
            $toppingstotal = 0;//keeps track of the price of all the toppings associated with this order
            $toppingstitlearray = array();//keeps track of the titles of the toppings
            $toppingssubtotalarray = array();//Keeps track of the subtotal of all the toppings
            //each index in each of these arrays is associated with an item in the orderdetails array
            //orderDetails[0] is associated with $toppingstitlearray[0] and $toppingssubtotalarray[0]
            $count = 0;  //Counter for the loop
            $config = array (
                'mode' => 'sandbox' , 
                'acct1.UserName' => 'rbarnett-facilitator_api1.samford.edu',
                'acct1.Password' => '1390242393', 
                'acct1.Signature' => 'A45Zwph8ENxkLQByx2YROFuxVw1NAVZ52ufdW0M5hOQzy1vZVjnR7kQt'
            );//configuration array
            $paymentDetails= new \PayPal\EBLBaseComponents\PaymentDetailsType();
            $paypalService = new \PayPal\Service\PayPalAPIInterfaceServiceService($config);
            $total = 0;
            while($count < count($orderDetails)){
                $toppingsonitem = $this->OrderDetailTopping->find('all', array('conditions' => array('OrderDetailTopping.order_detail_id' => $orderDetails[$count]['OrderDetail']['id'])));
                $toppingsstring = ' with ';
                $toppingssubtotal = 0;
                foreach($toppingsonitem as $itemtoppings){
                    //for each topping on the item add the price of the topping to the toppings total for 
                    //the entire order
                    $toppingstotal += $itemtoppings['OrderDetailTopping']['price'];
                    //Add the price each topping on this item for the subtotal of all the toppings on this particular
                    //item
                    $toppingssubtotal += $itemtoppings['OrderDetailTopping']['price'];
                    //keep track of all the toppings on this particular item
                    $toppingsstring .= $itemtoppings['Topping']['title'] . ' ';
                }
            if($toppingsstring === ' with '){
                $toppingsstring = '';
            }
            $total += $orderDetails[$count]['MenuItem']['price'] + $toppingssubtotal;
            $itemDetails = new PayPal\EBLBaseComponents\PaymentDetailsItemType();
            $itemDetails->Name = $orderDetails[$count]['MenuItem']['title'] . $toppingsstring;
            $itemAmount = $orderDetails[$count]['MenuItem']['price'] + $toppingssubtotal;
            $itemDetails->Amount = $itemAmount;
            $itemQuantity = '1';
            //specify the quantity of the item and put it in the quantity for the item details object
            $itemDetails->Quantity = $itemQuantity;
             //put the item in the payment details array or object
            $paymentDetails->PaymentDetailsItem[$count] = $itemDetails;
                //first find all the toppings associated with a certain item
                $count++;
            }
            //calculate the total for the entire order
            $projectedtotal = $total;
            

            $orderTotal = new \PayPal\CoreComponentTypes\BasicAmountType();
            $orderTotal->currencyID = 'USD';
            $orderTotal->value = $projectedtotal; 

            $paymentDetails->OrderTotal = $orderTotal;
            $paymentDetails->PaymentAction = 'Sale';

            $setECReqDetails = new PayPal\EBLBaseComponents\SetExpressCheckoutRequestDetailsType();
            $setECReqDetails->PaymentDetails = $paymentDetails;
            $setECReqDetails->CancelURL = 'http://localhost/SalvatoresPizza/orders/checkoutcancelled/';
            $setECReqDetails->ReturnURL = 'http://localhost/SalvatoresPizza/orders/confirmcheckout/' . $id;

            $setECReqType = new \PayPal\PayPalAPI\SetExpressCheckoutRequestType();
            $setECReqType->Version = '106.0';
            $setECReqType->SetExpressCheckoutRequestDetails = $setECReqDetails;

            $setECReq = new \PayPal\PayPalAPI\SetExpressCheckoutReq();
            $setECReq->SetExpressCheckoutRequest = $setECReqType;

            $setECResponse = $paypalService->SetExpressCheckout($setECReq);
            
            debug($setECResponse->Errors);
            $this->redirect('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $setECResponse->Token);
        }
        public function checkoutcancelled(){
            //this is just in case they hit the cancel checkout button.  nothing is actually removed from the cart  
            $this->Session->setFlash(__("Checkout cancelled."));
            $this->redirect(array('controller' => 'menucategories', 'action' => 'home'));
        }
        
        public function confirmcheckout($id = null){
            $this->layout = 'customer';
            $config = array (
            'mode' => 'sandbox' , 
            'acct1.UserName' => 'rbarnett-facilitator_api1.samford.edu',
            'acct1.Password' => '1390242393', 
            'acct1.Signature' => 'A45Zwph8ENxkLQByx2YROFuxVw1NAVZ52ufdW0M5hOQzy1vZVjnR7kQt'
        );
$paypalService = new \PayPal\Service\PayPalAPIInterfaceServiceService($config);
$Token = $_GET['token'];
$PayerID = $_GET['PayerID'];
$getExpressCheckoutDetailsRequest = new PayPal\PayPalAPI\GetExpressCheckoutDetailsRequestType($Token);
$getExpressCheckoutDetailsRequest->Version = '106.0';
$getExpressCheckoutReq = new \PayPal\PayPalAPI\GetExpressCheckoutDetailsReq();
$getExpressCheckoutReq->GetExpressCheckoutDetailsRequest = $getExpressCheckoutDetailsRequest;

$getECResponse = $paypalService->GetExpressCheckoutDetails($getExpressCheckoutReq);
$paymentdetails = $getECResponse->GetExpressCheckoutDetailsResponseDetails;
$paymentdetailsdeeper = $paymentdetails->PaymentDetails;
$ordertotal = $paymentdetailsdeeper[0]->OrderTotal->value;
//debug($paymentdetailsdeeper[0]);
$this->set('paymentdetails', $paymentdetailsdeeper[0]->PaymentDetailsItem);
$this->set('ordertotal',$ordertotal);
$this->set('id', $id);
$this->Session->write('payerid', $PayerID);
$this->Session->write('token', $Token);
//$this->set('items', $paymentdetails->PaymentDetails);      
        }
        
        public function finishcheckout($id = null){
            $config = array (
 	'mode' => 'sandbox' , 
 	'acct1.UserName' => 'rbarnett-facilitator_api1.samford.edu',
	'acct1.Password' => '1390242393', 
	'acct1.Signature' => 'A45Zwph8ENxkLQByx2YROFuxVw1NAVZ52ufdW0M5hOQzy1vZVjnR7kQt'
);
$paypalService = new \PayPal\Service\PayPalAPIInterfaceServiceService($config);

$getExpressCheckoutDetailsRequest = new PayPal\PayPalAPI\GetExpressCheckoutDetailsRequestType($this->Session->read('token'));
$getExpressCheckoutDetailsRequest->Version = '106.0';
$getExpressCheckoutReq = new \PayPal\PayPalAPI\GetExpressCheckoutDetailsReq();
$getExpressCheckoutReq->GetExpressCheckoutDetailsRequest = $getExpressCheckoutDetailsRequest;

$getECResponse = $paypalService->GetExpressCheckoutDetails($getExpressCheckoutReq);
$paymentdetails = $getECResponse->GetExpressCheckoutDetailsResponseDetails;
$paymentDetails = new \PayPal\EBLBaseComponents\PaymentDetailsType();
$paymentDetails->PaymentAction = 'Sale';
$paymentDetails->NotifyURL = "http://localhost/SalvatoresPizza/";


$DoECRequestDetails = new PayPal\EBLBaseComponents\DoExpressCheckoutPaymentRequestDetailsType();
$DoECRequestDetails->PayerID = $this->Session->read('payerid');
$DoECRequestDetails->Token = $this->Session->read('token');
$DoECRequestDetails->PaymentAction = 'Sale';
$DoECRequestDetails->OrderURL = "http://localhost/SalvatoresPizza/";
$DoECRequestDetails->PaymentDetails = $paymentdetails->PaymentDetails;

$DoECRequest = new PayPal\PayPalAPI\DoExpressCheckoutPaymentRequestType();
$DoECRequest->DoExpressCheckoutPaymentRequestDetails = $DoECRequestDetails;
$DoECRequest->Version = '106.0';

$DoECReq = new PayPal\PayPalAPI\DoExpressCheckoutPaymentReq();
$DoECReq->DoExpressCheckoutPaymentRequest = $DoECRequest;

$DoECResponse = $paypalService->DoExpressCheckoutPayment($DoECReq);
debug($DoECResponse);
if($DoECResponse->Ack === 'Success'){
 $this->Session->setFlash(__('Successfully ordered'));
$this->redirect(array('controller' => 'menucategories', 'action' => 'home'));
}
else{
 $this->Session->setFlash(__('Order could not be completed.'));
$this->redirect(array('controller' => 'menucategories', 'action' => 'home'));
}
 //debug($this->Session->read('payerid') . "  A break " . $this->Session->read('token
 //debug($paymentdetails);
 //debug($DoECReq);
//debug($DoECResponse);

        }
}
