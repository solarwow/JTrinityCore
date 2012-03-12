<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<h1 class="contentheading">
<?php 

echo JText::_('COM_JTRINITYCORE_BUYPOINTS_TITLE');


?>
</h1 class="contentheading">
<?php $user_points=JTrinityCoreUtilities::ShowUserPoints(); ?>
<br/><br/>
<form action="<?php echo JRoute::_('index.php?option=com_jtrinitycore&amp;view=buypoints&amp;layout=paypalexpresscheckout');?>" method="post" name="frmPuntos" id="frmPuntos">
<p style="padding-right: 25px;">
 
</p>
<input type="radio" name="typebuy" checked value="custom">
<?php  echo JText::_('COM_JTRINITYCORE_ENTER_POINTS');?>
<input type="text" size=6 name="points" value="5"><br/><br/>
<?php /*
<input type="radio" name="typebuy"  value="pack">&nbsp;&nbsp;<?php  echo JText::_('COM_JTRINITYCORE_ENTER_POINTS_SELECT_PACK');?> <br/>

<p style="padding-left: 25px;">
<input type="radio" name="pointscost" checked value="20,15"> 20 <?php echo JText::_('COM_JTRINITYCORE_POINTS'). " 15".$currency_symbol; ?> <br/>
<input type="radio" name="pointscost" value="25,20"> 25 <?php echo JText::_('COM_JTRINITYCORE_POINTS'). " 20".$currency_symbol; ?> <br/>
<input type="radio" name="pointscost" value="30,25"> 30 <?php echo JText::_('COM_JTRINITYCORE_POINTS'). " 25".$currency_symbol; ?> <br/>
<input type="radio" name="pointscost" value="35,30"> 35 <?php echo JText::_('COM_JTRINITYCORE_POINTS'). " 30".$currency_symbol; ?> <br/>
<input type="radio" name="pointscost" value="40,35"> 40 <?php echo JText::_('COM_JTRINITYCORE_POINTS'). " 35".$currency_symbol; ?> <br/>
<input type="radio" name="pointscost" value="50,40"> 50 <?php echo JText::_('COM_JTRINITYCORE_POINTS'). " 40".$currency_symbol; ?> <br/>
</p>*/

?>

<input type="submit" value="<?php  echo JText::_('COM_JTRINITYCORE_BUTTON_BUY');?>">
<input type="hidden" name="token" value="buypoints">

</form>


