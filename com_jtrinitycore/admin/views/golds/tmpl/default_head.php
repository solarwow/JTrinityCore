<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th width="5">
		<?php echo JText::_('COM_JTRINITYCORE_HEADING_ID'); ?>
	</th>
	<th width="10">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>			
	<th width="60">
		<?php echo JText::_('COM_JTRINITYCORE_HEADING_QUANTITY'); ?>
	</th>
	<th >
		<?php echo JText::_('COM_JTRINITYCORE_HEADING_COST'); ?>
	</th>
	

</tr>
