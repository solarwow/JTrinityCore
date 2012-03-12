<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

//$document = JFactory::getDocument();
//JText::script('COM_JTRINITYCORE_ALERT_SELECTCHARACTER');
include 'media/com_jtrinitycore/js/listcharacters.php';

$params = JComponentHelper::getParams( 'com_jtrinitycore');
$teleportercost=$params->get( 'teleportergold' );

?>



<?php echo '<h1 class="contentheading">'.JText::_('COM_JTRINITYCORE_CHARACTER_TELEPORTER').'</h1></br>';?>

<form action="<?php echo JRoute::_('index.php?option=com_jtrinitycore&amp;view=teleporter&amp;layout=teleport');?>" onsubmit="return validateForm();" method="post" name="frmBuy" id="frmBuy">

<?php 
JTrinityCoreUtilities::getRealmsOptionHTML(true);

?>

 <select name="characterid" id="characterid">
<option  value="0"><?php echo JText::_( 'COM_JTRINITYCORE_SELECTCHARACTER' );?></option>
</select>
<br/> <br/>
<h1>
<?php echo JText::_( 'COM_JTRINITYCORE_SELECT_CITY' );?>
</h1>
<br/>


<select name="location" id="location">
<option value='1'>Stormwind</option>
<option value='2'>Ironforge</option>
<option value='3'>Darnassus</option>
<option value='4'>Exodar</option>
<option value='---------'>------------------</option>
<option value='5'>Orgrimmar</option>
<option value='6'>Thunder Bluff</option>
<option value='7'>Undercity</option>
<option value='8'>Silvermoon</option>
<option value='---------'>------------------</option>
<option value='9'>Shattrath</option>
</select>
<br>
<br>
<?php 
	if ($teleportercost==0)
		echo JText::_('COM_JTRINITYCORE_TELEPORTER_COST_FREE');
	else
		echo JText::sprintf('COM_JTRINITYCORE_TELEPORTER_COST',$teleportercost);
	?>

          
<br/><br>	
<strong>
<?php  echo JText::_('COM_JTRINITYCORE_TELEPORTER_LOGGEDOUT');?>
</strong>

<br><br>

<input type="submit" value="<?php  echo JText::_('COM_JTRINITYCORE_BUTTON_TELEPORTER');?>">

<?php echo JHTML::_( 'form.token' ); ?>

</form>

