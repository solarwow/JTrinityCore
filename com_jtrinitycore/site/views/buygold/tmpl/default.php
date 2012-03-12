
<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JTrinityCoreUtilities::CheckUserLogged();

//$document = JFactory::getDocument();
//JText::script('COM_JTRINITYCORE_ALERT_SELECTCHARACTER');
include 'media/com_jtrinitycore/js/listcharacters.php';


?>



<?php echo '<h1 class="contentheading">'.JText::_('COM_JTRINITYCORE_DONATION_SHOP_GOLD').'</h1>';
// show user points
JTrinityCoreUtilities::ShowUserPoints(false);

?>


<form action="<?php echo JRoute::_('index.php?option=com_jtrinitycore&amp;view=buygold&amp;layout=buygold');?>" onsubmit="return validateForm();" method="post" name="frmBuy" id="frmBuy">

<?php 
JTrinityCoreUtilities::getRealmsOptionHTML(true);
?>
<select name="characterid" id="characterid">
<option  value="0"><?php echo JText::_( 'COM_JTRINITYCORE_SELECTCHARACTER' );?></option>
</select>
<br/> <br/>

<h3>
<?php echo JText::_( 'COM_JTRINITYCORE_SELECT_GOLD' );?>
</h3>

<select name="gold" id="gold">
<?php foreach($this->items as $i => $item): ?>
<option value="<?php echo $item->id; ?>">
<?php echo $item->quantity.' Gold = '.$item->cost.' '.JText::_('COM_JTRINITYCORE_POINTS'); ?>
</option>	
<?php endforeach;?>
</select>


          
<br/><br>	


<input type="submit" value="<?php  echo JText::_('COM_JTRINITYCORE_BUTTON_GETIT');?>">
<input type="hidden" name="productid" id="productid" value="0" />
<input type="hidden" name="donationtype" value="<?php echo DONATIONTYPE_GOLD; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>

</form>
