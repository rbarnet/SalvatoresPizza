<div class="orderDetailToppings view">
<h2><?php echo __('Order Detail Topping'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($orderDetailTopping['OrderDetailTopping']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Order Detail'); ?></dt>
		<dd>
			<?php echo $this->Html->link($orderDetailTopping['OrderDetail']['id'], array('controller' => 'order_details', 'action' => 'view', $orderDetailTopping['OrderDetail']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Topping'); ?></dt>
		<dd>
			<?php echo $this->Html->link($orderDetailTopping['Topping']['title'], array('controller' => 'toppings', 'action' => 'view', $orderDetailTopping['Topping']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php echo h($orderDetailTopping['OrderDetailTopping']['price']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Order Detail Topping'), array('action' => 'edit', $orderDetailTopping['OrderDetailTopping']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Order Detail Topping'), array('action' => 'delete', $orderDetailTopping['OrderDetailTopping']['id']), null, __('Are you sure you want to delete # %s?', $orderDetailTopping['OrderDetailTopping']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Detail Toppings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Detail Topping'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Details'), array('controller' => 'order_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Detail'), array('controller' => 'order_details', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Toppings'), array('controller' => 'toppings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Topping'), array('controller' => 'toppings', 'action' => 'add')); ?> </li>
	</ul>
</div>
