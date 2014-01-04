<div class="toppings view">
<h2><?php echo __('Topping'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($topping['Topping']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($topping['Topping']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php echo h($topping['Topping']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Item'); ?></dt>
		<dd>
			<?php echo h($topping['Topping']['item']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Topping'), array('action' => 'edit', $topping['Topping']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Topping'), array('action' => 'delete', $topping['Topping']['id']), null, __('Are you sure you want to delete # %s?', $topping['Topping']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Toppings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Topping'), array('action' => 'add')); ?> </li>
	</ul>
</div>
