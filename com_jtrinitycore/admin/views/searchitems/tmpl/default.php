<?php
/**
 * @subpackage	com_jtrinitycore
 * @copyright	Copyright (C) 2012 - Francisco Meneu
 * @license		GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

//JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');

$field		= JRequest::getCmd('field');
$function	= JRequest::getCmd('function', 'jSelectItem');
$realmid	= JRequest::getCmd('realmid');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));

?>


<script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script>
<form action="<?php echo JRoute::_('index.php?option=com_jtrinitycore&amp;view=searchitems&amp;tmpl=component');?>" method="post" name="adminForm" id="adminForm">
	<fieldset class="filter">
		<div class="left">
			<label for="filter_search"><?php echo JText::_('JSEARCH_FILTER'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" size="40" title="<?php echo JText::_('COM_JTRINITYCORE_SEARCH_IN_ITEM'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="javascript:document.id('filter_search').value='';this.form.reset(); this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
			<button type="button" onclick="if (window.parent) window.parent.<?php echo $this->escape($function);?>('', '<?php echo JText::_('COM_JTRINITYCORE_SELECT_ITEM') ?>');"><?php echo JText::_('COM_JTRINITYCORE_NOITEM')?></button>
		</div>
		
		<div class="filter-select fltrt">		
			
			<select name="filter_class_id" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_JTRINITYCORE_SELECT_CLASS');?></option>
				<?php echo JHtml::_('select.options', $this->f_class, 'value', 'text', $this->state->get('filter.class_id'));?>
			</select>		
			
		</div>
		
		<div class="filter-select fltrt">		
			
			<select name="filter_quality_id" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_JTRINITYCORE_SELECT_QUALITY');?></option>
				<?php echo JHtml::_('select.options', $this->f_quality, 'value', 'text', $this->state->get('filter.quality_id'));?>
			</select>		
			
		</div>
		
		<div class="filter-select fltrt">		
			
			<select name="filter_inventory_id" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_JTRINITYCORE_SELECT_INVENTORY');?></option>
				<?php echo JHtml::_('select.options', $this->f_inventory, 'value', 'text', $this->state->get('filter.inventory_id'));?>
			</select>		
			
		</div>
		
		<div class="filter-select fltrt">		
			
			<select name="filter_allowableclass" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_JTRINITYCORE_SELECT_ALLOWABLECLASS');?></option>
				<?php echo JHtml::_('select.options', $this->f_allowableclass, 'value', 'text', $this->state->get('filter.allowableclass'));?>
			</select>		
			
		</div>
		
	</fieldset>
	
<div style="background-color:black">
	<table style="background-color:black" >
		<thead>
			<tr>
				<th class="left" width="10%">
					
				</th>
				<th class="left" width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_JTRINITYCORE_ITEMS_HEADING_ITEMID', 'itemid', $listDirn, $listOrder); ?>
				</th>
				<th class="nowrap" >
					<?php echo JHtml::_('grid.sort', 'COM_JTRINITYCORE_ITEMS_HEADING_NAME', 'name', $listDirn, $listOrder); ?>
				</th>
				<th class="nowrap" width="%5">
					<?php echo JHtml::_('grid.sort', 'COM_JTRINITYCORE_ITEMS_HEADING_ITEMLEVEL', 'itemlevel', $listDirn, $listOrder); ?>
				</th>	
				<th class="nowrap" width="%5">
					<?php echo JHtml::_('grid.sort', 'COM_JTRINITYCORE_ITEMS_HEADING_REQUIREDLEVEL', 'requiredlevel', $listDirn, $listOrder); ?>
				</th>				
				
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="15">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody style="background-color:black">
		<?php
			$i = 0;
			foreach ($this->items as $item) : 
			$item_name=(empty($item->name)?$item->englishname:$item->name); ?>
			<tr >
			
			<td style="background-color:black; color:cyan">
					 					
						
		<button type="button" onclick="if (window.parent) window.parent.<?php echo $function."('".$item->itemid."','".addslashes($this->escape($item_name))."','".JTrinityCoreDBHelper::getColourClassCode($item->quality)."',".$item->allowablerace.",".$item->itemlevel.",".$item->requiredlevel.",".$item->quality.",".$item->subclass.",".$item->class.",".$item->inventorytype.");"; ?>;">
		<?php echo JText::_('COM_JTRINITYCORE_GETIT'); ?></button>
						
						
						
				</td>
				<td style="background-color:black; color:cyan">
						<?php echo $item->itemid; ?>						
						
				</td>
				<td align="center"  style="background-color:black">
				    
					<a href="<?php echo JTrinityCoreDBHelper::getWowHeadLink().'item='.$item->itemid; ?>">
					
					<span class="<?php echo JTrinityCoreDBHelper::getColourClassCode($item->quality); ?>">
					<?php echo $item_name; ?>
					</span>
					</a>
					
				</td>
				<td align="center" style="background-color:black; color:cyan">
					<?php echo $item->itemlevel; ?>
				</td>
				<td align="center" style="background-color:black; color:cyan">
					<?php echo $item->requiredlevel; ?>
				</td>
				
				
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	</div>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="function" value="<?php echo $function; ?>" />
		<input type="hidden" name="realmid" value="<?php echo $realmid; ?>" />
		<input type="hidden" name="field" value="<?php echo $this->escape($field); ?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

