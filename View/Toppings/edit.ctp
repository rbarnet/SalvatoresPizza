<div class="toppings form">
<?php echo $this->Form->create('Topping'); ?>
	<fieldset>
		<legend><?php echo __('Edit Topping'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('price');
		echo $this->Form->input('item');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Topping.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Topping.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Toppings'), array('action' => 'index')); ?></li>
	</ul>
</div>
