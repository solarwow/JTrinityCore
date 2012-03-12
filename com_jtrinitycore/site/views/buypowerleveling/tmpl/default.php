<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JTrinityCoreUtilities::CheckUserLogged();

 
// load tooltip behavior
JHtml::_('behavior.tooltip');



?>

<script type="text/javascript" >
function setData(id)
{
	document.getElementById("productid").value = id;	
}
</script>
<h1 class="contentheading"><?php  echo JText::_('COM_JTRINITYCORE_BUYPOWERLEVELING_TITLE');?>
</h1>
<?php 
// show user points
JTrinityCoreUtilities::ShowUserPoints(false);
?>


<form action="<?php echo JRoute::_('index.php?option=com_jtrinitycore&view=donationshop&layout=selectcharacter'); ?>" method="post" name="adminForm">
	<table class="tablelist">
		<thead><tr><th width="25%"></th>
		<th width="15%"></th></tr>
		</thead>
		<tfoot></tfoot>
		<tbody>
<?php foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">		
		<td>		
			Powerleveling
		</td>
		<td >
			<?php echo $item->minLevel.'-'.$item->maxLevel; ?>
		</td>			
		<td>
			<?php echo $item->cost.' '.JText::_('COM_JTRINITYCORE_POINTS'); ?>
		</td>
		
		<td>			
			<button type="button" onclick="setData('<?php echo $item->id; ?>');this.form.submit();"><?php echo JText::_('COM_JTRINITYCORE_ITEMS_HEADING_GETIT'); ?></button>
			
		</td>
	</tr>
<?php endforeach; ?>
		
		
		</tbody>
	</table>
	<div>
		<input type="hidden" name="task" value="" />		
		<input type="hidden" name="productid" id="productid" value="0" />
		<input type="hidden" name="donationtype" value="<?php echo DONATIONTYPE_POWERLEVELING; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>





