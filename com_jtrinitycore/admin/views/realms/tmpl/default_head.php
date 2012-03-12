<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th width="5">
		<?php echo JText::_('COM_JTRINITYCORE_REALMS_HEADING_REALMID'); ?>
	</th>
	<th width="20">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>			
	
	<th >
		<?php echo JText::_('COM_JTRINITYCORE_REALMS_HEADING_REALMNAME'); ?>
	</th>
	<th >
		<?php echo JText::_('COM_JTRINITYCORE_REALMS_HEADING_CHARACTERSDB'); ?>
	</th>
	<th >
		<?php echo JText::_('COM_JTRINITYCORE_REALMS_HEADING_WORLDDB'); ?>
	</th>
	<th >
		<?php echo JText::_('COM_JTRINITYCORE_REALMS_HEADING_VERSIONSERVER'); ?>
	</th>
	<th >
		<?php echo JText::_('COM_JTRINITYCORE_REALMS_HEADING_SERVERTYPE'); ?>
	</th>
	<th >
		<?php echo JText::_('COM_JTRINITYCORE_REALMS_HEADING_DESCRIPTIONTITLE'); ?>
	</th>
	<th >
		<?php echo JText::_('COM_JTRINITYCORE_REALMS_HEADING_DESCRIPTION'); ?>
	</th>
	<th >
		<?php echo JText::_('COM_JTRINITYCORE_REALMS_HEADING_IP'); ?>
	</th>
	<th align="left">
		<?php echo JText::_('COM_JTRINITYCORE_REALMS_HEADING_PORT'); ?>
	</th>
	<th align="left">
		<?php echo JText::_('COM_JTRINITYCORE_REALMS_HEADING_POPULATION'); ?>
	</th>
	

</tr>