<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Sign Up for Specials'); ?></legend>
	<?php
		echo $this->Form->input('group_id');
		echo $this->Form->input('email');
		echo $this->Form->input('password');
		echo $this->Form->input('addr1');
		echo $this->Form->input('addr2');
		echo $this->Form->input('phone');
		echo $this->Form->input('firstname');
		echo $this->Form->input('lastname');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

