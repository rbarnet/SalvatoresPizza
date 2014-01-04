<div class="orderDetailToppings form">
<?php echo $this->Form->create('OrderDetailTopping'); ?>
	<fieldset>
		<legend><?php echo __('Edit Order Detail Topping'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('order_detail_id');
		echo $this->Form->input('topping_id');
		echo $this->Form->input('price');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('OrderDetailTopping.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('OrderDetailTopping.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Order Detail Toppings'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Order Details'), array('controller' => 'order_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Detail'), array('controller' => 'order_details', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Toppings'), array('controller' => 'toppings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Topping'), array('controller' => 'toppings', 'action' => 'add')); ?> </li>
	</ul>
</div>
