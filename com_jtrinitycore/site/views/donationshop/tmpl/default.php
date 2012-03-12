<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

JTrinityCoreUtilities::CheckUserLogged();



$images="media/com_jtrinitycore/images/";

?>


<?php 
$html='<h1 class="contentheading">'.JText::_('COM_JTRINITYCORE_DONATIONSHOP_TITLE').
'</h1>
<h5>'.JText::_('COM_JTRINITYCORE_DONATIONSHOP_SELECT_DONATION').'</h5><br/>';
// Items
$html.='															 
      <table style="border-spacing: 25px;" ><tr>
      <td valign="top"><img width="60" height="50" border="0" src="'.$images.'axe_trans.png"></td>
      <td valign="center">
      <a href="index.php?option=com_jtrinitycore&view=buyitems"> '.JText::_('COM_JTRINITYCORE_DONATION_SHOP_ITEMS').' </a> <br/>      
      </td>
      </tr></table>';

// Powerleveling
$html.='<br/>
<table ><tr>
<td valign="top"><img width="60" height="50" border="0" src="'.$images.'powerleveling.gif"></td>
<td valign="center">
<a href="index.php?option=com_jtrinitycore&view=buypowerleveling"> '.JText::_('COM_JTRINITYCORE_DONATION_SHOP_POWERLEVELING').' </a> <br/>
</td>
</tr></table>';

// Gold
$html.='<br/>
<table><tr>
<td valign="top"><img width="60" height="50" border="0" src="'.$images.'buygold.png"></td>
<td valign="center">
<a href="index.php?option=com_jtrinitycore&view=buygold"> '.JText::_('COM_JTRINITYCORE_DONATION_SHOP_GOLD').' </a> <br/>
</td>
</tr></table>';

															
echo $html;

?>