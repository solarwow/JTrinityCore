<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

//$document = JFactory::getDocument();
//JText::script('COM_JTRINITYCORE_ALERT_SELECTCHARACTER');
include 'media/com_jtrinitycore/js/listcharacters.php';

?>



<?php echo '<h1 class="contentheading">'.JText::_('COM_JTRINITYCORE_CHARACTER_UNSTUCK').'</h1></br>';?>

<form action="<?php echo JRoute::_('index.php?option=com_jtrinitycore&amp;view=unstucker&amp;layout=unstuck');?>" onsubmit="return validateForm();" method="post" name="frmBuy" id="frmBuy">

<?php 
JTrinityCoreUtilities::getRealmsOptionHTML();

?>

 <select name="characterid" id="characterid">
<option  value="0"><?php echo JText::_( 'COM_JTRINITYCORE_SELECTCHARACTER' );?></option>
</select>
<br/> <br/>
<input type="submit" value="<?php  echo JText::_('COM_JTRINITYCORE_BUTTON_UNSTUCK');?>">

<?php echo JHTML::_( 'form.token' ); ?>

</form>
