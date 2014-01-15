<div class="orderDetails index">
	<h2><?php echo __('Your Cart for '. $locationtitle); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo ('Menu Item   '); ?></th>
			<th><?php echo ('Price'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php $count = 0;   foreach ($orderDetails as $orderDetail): ?>
	<tr>
		
		<td>
			<?php echo ($orderDetail['MenuItem']['title']); ?>
		</td>
		<td><?php echo h($orderDetail['OrderDetail']['price']); ?>&nbsp;</td>
                
                <td> <?php if($toppings[$count] != null){
                    ?></td>
                
		<td class="actions">
                <?php echo $this->Form->postLink(__('Add Topping'), array('action' => 'addtopping', $orderDetail['OrderDetail']['id']), null);} ?>
			<?php echo $this->Form->postLink(__('Remove from Cart'), array('action' => 'delete', $orderDetail['OrderDetail']['id']), null, __('Are you sure you want to remove this item from your cart?', $orderDetail['OrderDetail']['id'])); ?>
		</td>
	</tr>
<?php $count++; endforeach; 
?>
	</table>
        <br></br>
	<?php echo("Total: $". $ordertotal);?>
</div>

