<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script>
<?php foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo $item->id; ?>
		</td>		
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<?php echo $item->itemid; ?>
		</td>
		<td>
		<a href="<?php echo JTrinityCoreDBHelper::getWowHeadLink().'item='.$item->itemid; ?>" >
			<img src="<?php echo "../media/com_jtrinitycore/items/small/".$item->icon; ?> " alt="<?php echo $item->name; ?>">
			<span class="<?php echo JTrinityCoreDBHelper::getColourClassCode($item->color); ?>">
			<?php echo $item->name; ?>
			</span>
			</a>
		</td>
		<td>
			<?php echo $item->description; ?>
		</td>
		<td>
			<?php echo $item->category; ?>
		</td>
		<td>
			<?php echo $item->requiredlevel; ?>
		</td>
		<td>
			<?php echo $item->itemlevel; ?>
		</td>
		<td>
			<?php echo $item->icon; ?>
		</td>
		<td>
			<?php echo $item->color; ?>
		</td>
		<td>
			<?php echo $item->cost; ?>
		</td>		
		<td>
			<?php echo $item->realmid; ?>
		</td>
	</tr>
<?php endforeach; ?>