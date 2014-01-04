<div class="toppings index">
	<h2><?php echo __('Toppings'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('price'); ?></th>
			<th><?php echo $this->Paginator->sort('item'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($toppings as $topping): ?>
	<tr>
		<td><?php echo h($topping['Topping']['id']); ?>&nbsp;</td>
		<td><?php echo h($topping['Topping']['title']); ?>&nbsp;</td>
		<td><?php echo h($topping['Topping']['price']); ?>&nbsp;</td>
		<td><?php echo h($topping['Topping']['item']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $topping['Topping']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $topping['Topping']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $topping['Topping']['id']), null, __('Are you sure you want to delete # %s?', $topping['Topping']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Topping'), array('action' => 'add')); ?></li>
	</ul>
</div>
