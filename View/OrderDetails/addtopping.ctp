<div class="orderDetails index">
<?php echo $this->Form->create('OrderDetail'); ?>
	<fieldset>
		<legend><?php echo __('Add Toppings to Your ' .$item); ?></legend>
               
                    
	<h3><?php
        echo("Topping and Price");?></h3>
        <?php foreach($toppingssofar as $toppingschosen){?>
                    
                    <?php echo ($toppingschosen['Topping']['title'] . "   $" .$toppingschosen['Topping']['price']);
                    ?>
                <button><?php  echo $this->HTML->link(__('Remove topping'), array('controller' => 'OrderDetailToppings','action' => 'deletetoppingcustomer', $toppingschosen['OrderDetailTopping']['id']), null, __('Are you sure you want to remove this topping?', $toppingschosen['OrderDetailTopping']['id']));?></button>
            <?php echo("<br></br>");?>
        <?php } ?>
        
        <?php echo $this->Form->input('toppings');
		
	?>
	</fieldset>

<?php echo $this->Form->end(__('Add Topping')); ?>
</div>

