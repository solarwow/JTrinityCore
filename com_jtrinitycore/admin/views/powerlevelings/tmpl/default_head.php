<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th width="5">
		<?php echo JText::_('COM_JTRINITYCORE_POWERLEVELINGS_HEADING_ID'); ?>
	</th>
	<th width="20">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>			
	<th width="100">
		<?php echo JText::_('COM_JTRINITYCORE_POWERLEVELINGS_HEADING_MIN'); ?>
	</th>
	<th width="100">
		<?php echo JText::_('COM_JTRINITYCORE_POWERLEVELINGS_HEADING_MAX'); ?>
	</th>
	<th align="left">
		<?php echo JText::_('COM_JTRINITYCORE_POWERLEVELINGS_HEADING_COST'); ?>
	</th>

</tr>
