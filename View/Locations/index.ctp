<div class="locations index">
	<h2><?php echo __('Locations'); ?></h2>
	<table cellpadding="0" cellspacing="0">
<!--	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('addr1'); ?></th>
			<th><?php echo $this->Paginator->sort('addr2'); ?></th>
			<th><?php echo $this->Paginator->sort('phone'); ?></th>
			<th><?php echo $this->Paginator->sort('hourshtml'); ?></th>
			<th><?php echo $this->Paginator->sort('googlemapcode'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>-->
	<?php foreach ($locations as $location): ?>
	
		
		<h3><?php echo h($location['Location']['title']); ?>&nbsp;</h3>
                <p><?php echo "<b> </b>"; ?> </p>
		<p><?php echo h($location['Location']['addr1']); ?>&nbsp;</p>
                <p><?php echo "<b> </b>"; ?> </p>
		<p><?php echo h($location['Location']['addr2']); ?>&nbsp;</p>
                <p><?php echo "<b> </b>"; ?> </p>
		<p><?php echo h($location['Location']['phone']); ?>&nbsp;</p>
                <p><?php echo "<b> </b>"; ?> </p>
		<p><?php echo h($location['Location']['hourshtml']); ?>&nbsp;</p>
                <p><?php echo "<b> </b>"; ?> </p>
		<p><?php echo "<img src = \" " .($location['Location']['googlemapcode']) . "\" > </img>"; ?>&nbsp;</p>
                <p><?php echo "<b> </b>"; ?> </p>
		
	
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

