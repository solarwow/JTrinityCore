<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th></th>
	<th width="50%">		
		<?php //echo JHtml::_('grid.sort', 'COM_JTRINITYCORE_ITEMS_HEADING_NAME', 'i.name', $listDirn, $listOrder);
		   echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_NAME');
		?>
	</th>	
	<th width="10%">		
		<?php //echo JHtml::_('grid.sort', 'COM_JTRINITYCORE_ITEMS_HEADING_REQUIREDLEVEL', 'i.itemlevel', $listDirn, $listOrder); 
		echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_REQUIREDLEVEL');
		?>
	</th>
	<th>
	<?php //echo JHtml::_('grid.sort', 'COM_JTRINITYCORE_ITEMS_HEADING_CATEGORY', 'category_title', $listDirn, $listOrder);
		echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_CATEGORY');
		?>
		
	</th>
	
	<th>
		<?php echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_COST'); ?>
	</th>	
	<th>
		<?php echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_SELECT'); ?>
	</th>
</tr>