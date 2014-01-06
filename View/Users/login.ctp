<div class="users form">
	<h2>Login</h2>
<?php
echo $this->Form->create('User', array(
    'url' => array(
        'controller' => 'users',
        'action' => 'login'
    )
));
echo $this->Form->input('User.email');
echo $this->Form->input('User.password');
echo $this->Form->end('Login');
?>

</div>
<!--<?php echo $this->element('menu'); ?>-->

<div class="actions">
	<h3><?php echo __('Are you a new user?'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Create New Account'), array('action' => 'add')); ?> </li>
                
	</ul>
</div>
