<div class="menuItems view">
<h2><?php echo __('Menu Item'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($menuItem['MenuItem']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Menu Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($menuItem['MenuCategory']['title'], array('controller' => 'menu_categories', 'action' => 'view', $menuItem['MenuCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Current Special'); ?></dt>
		<dd>
			<?php echo h($menuItem['MenuItem']['currentspecial']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($menuItem['MenuItem']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tagline'); ?></dt>
		<dd>
			<?php echo h($menuItem['MenuItem']['tagline']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php echo h($menuItem['MenuItem']['price']); ?>
			&nbsp;
		</dd>
		
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Menu Item'), array('action' => 'edit', $menuItem['MenuItem']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Menu Item'), array('action' => 'delete', $menuItem['MenuItem']['id']), null, __('Are you sure you want to delete # %s?', $menuItem['MenuItem']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Menu Items'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Menu Item'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Menu Categories'), array('controller' => 'menu_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Menu Category'), array('controller' => 'menu_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Details'), array('controller' => 'order_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Detail'), array('controller' => 'order_details', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Order Details'); ?></h3>
	<?php if (!empty($menuItem['OrderDetail'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Order Id'); ?></th>
		<th><?php echo __('Menu Item Id'); ?></th>
		<th><?php echo __('Price'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($menuItem['OrderDetail'] as $orderDetail): ?>
		<tr>
			<td><?php echo $orderDetail['id']; ?></td>
			<td><?php echo $orderDetail['order_id']; ?></td>
			<td><?php echo $orderDetail['menu_item_id']; ?></td>
			<td><?php echo $orderDetail['price']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'order_details', 'action' => 'view', $orderDetail['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'order_details', 'action' => 'edit', $orderDetail['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'order_details', 'action' => 'delete', $orderDetail['id']), null, __('Are you sure you want to delete # %s?', $orderDetail['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Order Detail'), array('controller' => 'order_details', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
