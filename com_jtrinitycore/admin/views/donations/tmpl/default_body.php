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
			<?php echo $item->username; ?>
		</td>	
		
		<td>
			<?php echo $item->amount; ?>
		</td>
		
		<td>
			<?php echo $item->donationdate; ?>
		</td>
		<td>
			<?php echo ($item->completed?1:0); ?>
		</td>
		<td>
			<?php echo $item->paypal_txn_id; ?>
		</td>
		
	</tr>
<?php endforeach; ?>
