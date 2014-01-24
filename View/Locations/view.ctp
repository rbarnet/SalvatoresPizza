<div class="locations view">
<h2><?php echo __('Location'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($location['Location']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($location['Location']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Addr1'); ?></dt>
		<dd>
			<?php echo h($location['Location']['addr1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Addr2'); ?></dt>
		<dd>
			<?php echo h($location['Location']['addr2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($location['Location']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hourshtml'); ?></dt>
		<dd>
			<?php echo h($location['Location']['hourshtml']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Googlemapcode'); ?></dt>
		<dd>
			<?php echo h($location['Location']['googlemapcode']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Tax Rate'); ?></dt>
		<dd>
			<?php echo h($location['Location']['taxrate']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Location'), array('action' => 'edit', $location['Location']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Location'), array('action' => 'delete', $location['Location']['id']), null, __('Are you sure you want to delete # %s?', $location['Location']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Locations'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Location'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Orders'); ?></h3>
	<?php if (!empty($location['Order'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Location Id'); ?></th>
		<th><?php echo __('Orderdate'); ?></th>
		<th><?php echo __('Stage Id'); ?></th>
		<th><?php echo __('Total'); ?></th>
		<th><?php echo __('Paid'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($location['Order'] as $order): ?>
		<tr>
			<td><?php echo $order['id']; ?></td>
			<td><?php echo $order['user_id']; ?></td>
			<td><?php echo $order['location_id']; ?></td>
			<td><?php echo $order['orderdate']; ?></td>
			<td><?php echo $order['stage_id']; ?></td>
			<td><?php echo $order['total']; ?></td>
			<td><?php echo $order['paid']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'orders', 'action' => 'view', $order['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'orders', 'action' => 'edit', $order['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'orders', 'action' => 'delete', $order['id']), null, __('Are you sure you want to delete # %s?', $order['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
