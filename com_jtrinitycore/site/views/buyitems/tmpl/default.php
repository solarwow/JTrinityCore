<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JTrinityCoreUtilities::CheckUserLogged();


// load tooltip behavior
//JHtml::_('behavior.tooltip');
//JHtml::_('behavior.multiselect');



?>

<script type="text/javascript" >
function setData(id)
{
	document.getElementById("productid").value = id;	
}
</script>
<h1 class="contentheading"><?php  echo JText::_('COM_JTRINITYCORE_BUYITEMS_TITLE');?>
</h1>
<?php 
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));


// show user points
JTrinityCoreUtilities::ShowUserPoints(false);
?>


<form action="<?php echo JRoute::_('index.php?option=com_jtrinitycore&view=buyitems');?>" method="post" name="adminForm" id="adminForm">
<table>
<tr>
<td>
<fieldset id="filter-bar">
<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_JTRINITYCORE_FILTER_SEARCH_DESC'); ?>" />

			<button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>		
		<div class="filter-select fltrt">
		&nbsp;
			<select name="filter_category_id" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_CATEGORY');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('category.options', 'com_jtrinitycore'), 'value', 'text', $this->state->get('filter.category_id'));?>
			</select>
		</div>
		
		<div style="float:right;">		
			
			<select name="filter_class_id" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_JTRINITYCORE_SELECT_CLASS');?></option>
				<?php echo JHtml::_('select.options', $this->f_class, 'value', 'text', $this->state->get('filter.class_id'));?>
			</select>		
			
		</div>
		
		<div style="float:right;">		
			
			<select name="filter_quality_id" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_JTRINITYCORE_SELECT_QUALITY');?></option>
				<?php echo JHtml::_('select.options', $this->f_quality, 'value', 'text', $this->state->get('filter.quality_id'));?>
			</select>		
			
		</div>
		
		<div style="float:right;">		
			
			<select name="filter_inventory_id" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_JTRINITYCORE_SELECT_INVENTORY');?></option>
				<?php echo JHtml::_('select.options', $this->f_inventory, 'value', 'text', $this->state->get('filter.inventory_id'));?>
			</select>		
			
		</div>
		
		<div style="float:right;">		
			
			<select name="filter_allowableclass" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_JTRINITYCORE_SELECT_ALLOWABLECLASS');?></option>
				<?php echo JHtml::_('select.options', $this->f_allowableclass, 'value', 'text', $this->state->get('filter.allowableclass'));?>
			</select>		
			
		</div>
</fieldset>
<div>
<input type="hidden" name="task" value="" />
<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
</div>

</td>
</tr>
</table>

</form>

<form action="<?php echo JRoute::_('index.php?option=com_jtrinitycore&view=donationshop&layout=selectcharacter'); ?>" method="post" name="dataForm">

	<table class="tablelist">
		<thead><?php echo $this->loadTemplate('head');?></thead>
		<tfoot><?php echo $this->loadTemplate('foot');?></tfoot>	
		<tbody><?php echo $this->loadTemplate('body');?></tbody>
	</table>
	
<div>
		<input type="hidden" name="task" value="" />		
		<input type="hidden" name="productid" id="productid" value="0" />
		<input type="hidden" name="donationtype" value="<?php echo DONATIONTYPE_ITEM; ?>" />
		
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
