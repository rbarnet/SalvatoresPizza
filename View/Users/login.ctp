<div class="users form">
<?php echo $this->Form->create('Login'); ?>
	<fieldset>
		
	<?php
		echo $this->Form->create('User', array('action' => 'login'));
echo $this->Form->inputs(array(
    'legend' => __('Login'),
    'username',
    'password'
));
echo $this->Form->end('Login')
	?>
	</fieldset>

</div>
<!--<?php echo $this->element('menu'); ?>-->

<div class="actions">
	<h3><?php echo __('Are you a new user?'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Create New Account'), array('action' => 'add')); ?> </li>
                
	</ul>
</div>
