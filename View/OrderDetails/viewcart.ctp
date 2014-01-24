<div class="orderDetails index">
    <div class="actionscart">
	<h2><?php echo __('Your Cart for '. $locationtitle); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo ('Menu Item   '); ?></th>
                        <th><?php echo ('Toppings'); ?></th>
<!--			<th><?php// echo ('Base Price'); ?></th>
                        <th><?php// echo  ('Topping Price'); ?></th>-->
                        <th><?php echo  ('Item Price'); ?></th>
                        
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php $count = 0;   foreach ($orderDetails as $orderDetail): ?>
	<tr>
                        
		<td>
			<?php echo ($orderDetail['MenuItem']['title']); ?>
		</td>
                <td> <?php echo($toppingstitlearray[$count]);?></td>
<!--		<td><?php// echo h('$ ' .  $orderDetail['OrderDetail']['price']); ?>&nbsp;</td>
                <td><?php// echo h('$ ' .  $toppingsubtotalarray[$count]); ?>&nbsp;</td>-->
                <td><?php $itemprice = $orderDetail['OrderDetail']['price'] + $toppingsubtotalarray[$count];   echo ('$' . $itempricearray[$count]);?></td>
                
                <td> <?php if($toppings[$count] != null){
                    ?></td>
                
		<td class="actionscart">
                    <button><?php echo $this->HTML->link(__('Add/Remove/View Toppings'), array('action' => 'addtopping', $orderDetail['OrderDetail']['id']), null);} ?></button>
                    <button><?php echo $this->HTML->link(__('Remove from Cart'), array('action' => 'deleteitemcustomer', $orderDetail['OrderDetail']['id']), null, __('Are you sure you want to remove this item from your cart?', $orderDetail['OrderDetail']['id'])); ?></button>
		</td>
	</tr>
<?php $count++; endforeach; 
?>
	</table>
        <br></br>
	<?php echo("Total without Toppings: $". $ordertotal);?>
        <?php echo("<br></br>")?>
        <?php echo("Total of Toppings Selected: $". $toppingstotal);?>
        <?php echo("<br></br>")?>
        <?php echo("Projected Total without Tax: $" .$projectedtotal)?>
        <?php echo("<br></br>")?>
        <?php echo("Tax: $" .$tax)?>
    </div>
    <br></br>
   <a href="/SalvatoresPizza/orders/checkout/<?php echo $orderDetails[0]['Order']['id']?>" data-paypal-button="true">
  <img src="//www.paypalobjects.com/en_US/i/btn/btn_xpressCheckout.gif" alt="Check out with PayPal" />
</a>
</div>

