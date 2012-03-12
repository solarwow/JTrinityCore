<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th width="10">
		<?php echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_ID'); ?>
	</th>
	<th width="20">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>			
	<th width="50">
		<?php echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_ITEMID'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_NAME'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_DESCRIPTION'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_CATEGORY'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_REQUIREDLEVEL'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_ITEMLEVEL'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_ICON'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_COLOR'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_COST'); ?>
	</th>	
	<th>
		<?php echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_REALMID'); ?>
	</th>
</tr>