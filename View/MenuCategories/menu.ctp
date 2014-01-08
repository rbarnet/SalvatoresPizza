<div class="menuCategories index">
    <table cellpadding="0" cellspacing="0">
    <?php if (isset($subCategories)) {
            foreach ($subCategories as $cat) { 
                echo $this->Html->link($cat['MenuCategory']['title'],array('action'=>'menu',$cat['MenuCategory']['id']));
                echo "<br />";
            }
          } else  {
            echo "<h2>".$category['MenuCategory']['title']."</h2>";
            foreach ($menuItems as $item) {?> <tr><td><?php
                echo $item['MenuItem']['title'] . '       ' . $item['MenuItem']['price']."\n";?>
                </td>
    
                <td class="actions">
			<?php  echo $this->Html->link(__('Add to Cart Hoover'), array('controller' => 'orderdetails','action' => 'addtocart', $item['MenuItem']['id'], 1));
                echo $this->Html->link(__('Add to Cart Trussville'), array('controller' => 'orderdetails','action' => 'addtocart', $item['MenuItem']['id'], 2));
                 echo "<br />";
                 echo "<br />";
            }  
          }
    ?>
		</td>
</tr>
</table>
</div>
 