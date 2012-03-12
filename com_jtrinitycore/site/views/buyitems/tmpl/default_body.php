<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script>


<?php foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
		<a href="<?php echo JTrinityCoreDBHelper::getWowHeadLink().'item='.$item->itemid; ?>" >	
		  <img src="<?php echo "media/com_jtrinitycore/items/medium/".$item->icon; ?> " alt="<?php echo $item->name; ?>">
		 </a>
		</td>
		
		<td >
		<a href="<?php echo JTrinityCoreDBHelper::getWowHeadLink().'item='.$item->itemid; ?>" >	
			<span class="<?php echo $item->color;?>">		 
			<?php echo $item->name; ?>
			</span>
			</a>
		
		</td>
		<td >
			<?php echo $item->requiredlevel; ?>
		</td>
		<td>
			<?php echo $item->category_title; ?>
		</td>		
		<td>
			<?php echo $item->cost; ?>
		</td>
		
		<td>
			
			<button type="button" onclick="setData('<?php echo $item->id; ?>');this.form.submit();"><?php echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_GETIT'); ?></button>
			
		</td>
	</tr>
<?php endforeach; ?>

       
