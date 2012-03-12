<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JRequest::checkToken() or die( JText::_( 'Invalid Token' ) );

// Check if the user has enough points
if ($this->user_points<$this->cost)
{
	echo "<h3>".JText::_('COM_JTRINITYCORE_NOT_ENOUGH_POINTS')."</h3></br>";
	JTrinityCoreUtilities::ShowUserPoints(false);
	return;
}

//$document = JFactory::getDocument();
//$document->addScript( 'media/com_jtrinitycore/js/listcharacters.js' );
//JText::script('COM_JTRINITYCORE_ALERT_SELECTCHARACTER');
include 'media/com_jtrinitycore/js/listcharacters.php';
?>



<?php echo '<h1 class="contentheading">'.JText::_('COM_JTRINITYCORE_SELECTCHARACTER_TITLE')."</h1></br>";?>

<form action="<?php echo JRoute::_('index.php?option=com_jtrinitycore&amp;view=donationshop&amp;layout=buyproduct');?>" onsubmit="return validateForm();" method="post" name="frmBuy" id="frmBuy">

<?php 
JTrinityCoreUtilities::getRealmsOptionHTML();
echo JHTML::_( 'form.token' ); 
?>

 <select name="characterid" id="characterid">
<option  value="0"><?php echo JText::_( 'COM_JTRINITYCORE_SELECTCHARACTER' );?></option>
</select>
<br/> <br/>
<input type="submit" value="<?php  echo JText::_('COM_JTRINITYCORE_BUTTON_CONTINUE');?>">



</form>





