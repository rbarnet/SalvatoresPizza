<div class="actions" id="login">
	<table>
            <tr>
		<td><?php echo $this->Html->link((__('Login')),array('controller'=>'users','action'=>'login')); ?>&nbsp;</td>
                <td><?php echo $this->Html->link((__('Logout')),array('controller'=>'users','action'=>'logout')); ?>&nbsp;</td>
		<td><?php echo $this->Html->link((__('Sign Up')),array('controller'=>'users','action'=>'add')); ?>&nbsp;</td>
            </tr>
	</table>
</div>
