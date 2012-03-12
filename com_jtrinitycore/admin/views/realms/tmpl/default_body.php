<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>

<?php foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo $item->realmid; ?>
		</td>		
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<?php echo $item->realmname; ?>
		</td>
		
		<td>
			<?php echo $item->charactersdb; ?>
		</td>
		<td>
			<?php echo $item->worlddb; ?>
		</td>		
		<td>
			<?php echo $item->versionserver; ?>
		</td>
		<td>
			<?php echo $item->servertype; ?>
		</td>
		<td>
			<?php echo $item->descriptiontitle; ?>
		</td>
		<td>
			<?php echo $item->description; ?>
		</td>
		<td>
			<?php echo $item->ip; ?>
		</td>
		<td>
			<?php echo $item->port; ?>
		</td>
		<td>
			<?php echo $item->population; ?>
		</td>
		
		
	</tr>
<?php endforeach; ?>