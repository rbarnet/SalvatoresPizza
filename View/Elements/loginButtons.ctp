<div class="actions" id="login">
	<table>
            <tr>
                <?php if ($this->Session->read('Auth.User')){ ?>
                <td><?php echo $this->Html->link((__('Logout')),array('controller'=>'users','action'=>'logout'));
                
                } else{?>&nbsp;</td>
                
                <td><?php echo $this->Html->link((__('Login')),array('controller'=>'users','action'=>'login')); }?>&nbsp;</td>
                <?php if ($this->Session->read('Auth.User')){?>
                   
                <td><?php echo $this->Html->link((__('View Cart Hoover')),array('controller'=>'orderdetails','action'=>'viewcart', 1)); ?></td>
                <td><?php echo $this->Html->link((__('View Cart Trussville')),array('controller'=>'orderdetails','action'=>'viewcart', 2));} ?></td>
		<td><?php echo $this->Html->link((__('Sign Up')),array('controller'=>'users','action'=>'add')); ?>&nbsp;</td>
            </tr>
	</table>
</div>
