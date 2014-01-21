<div class="order index">
    <div class="actionscart">
	<h2><?php echo __('Confirm Your Order'); ?></h2>
        <?php foreach($paymentdetails as $items){
            echo $items->Name;//print the name of the item
            echo (" $");
            echo $items->Amount->value;//print the amount of the item
            
            echo("<br></br>");
        }?>
        <br></br>
        <?php echo("Your order total is: $". $ordertotal);?>
        <br></br>
        <button><?php echo $this->HTML->link(__('Confirm Checkout'), array('action' => 'finishcheckout', $id), null);?></button>
	
        
    </div>
     
</div>



