<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>

<?php foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo $item->id; ?>
		</td>		
		<td>
			<?php echo  JTrinityCoreUtilities::getOrderTypeText($item->ordertype); ?>
		</td>
		<td>
			<?php echo $item->description; ?>
		</td>	
		
		<td>
			<?php echo $item->points; ?>
		</td>
		
		<td>
			<?php echo $item->username; ?>
		</td>
		<td >
			<?php echo $item->charid; ?>
		</td>
		<td >
			<?php echo $item->realmid; ?>
		</td>
		<td>
			<?php echo $item->orderdate; ?>
		</td>	
		
	</tr>
<?php endforeach; ?>