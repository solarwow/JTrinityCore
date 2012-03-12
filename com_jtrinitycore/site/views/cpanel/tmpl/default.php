<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JTrinityCoreUtilities::CheckUserLogged();


// Get user name
$user =JFactory::getUser();
$user_name = $user->name;
$user_username=$user->username;

$acc=JTrinityCoreDBHelper::getAccountData($user_username);
if (!$acc) return false;
$remote_IP=JTrinityCoreUtilities::getRemoteIP();
$last_login=$acc->last_login;
$last_ip=$acc->last_ip;
$banned=$acc->locked;
$expansion_string=JTrinityCoreDBHelper::getExpansionString($acc->expansion);
$images="media/com_jtrinitycore/images/";
//$style="media/com_jtrinitycore/styles/style.css";
// <link href="" rel="stylesheet" type="text/css" />
?>
<h1 class="contentheading"><?php echo JText::_('COM_JTRINITYCORE_CUSER_CONTROL_PANEL'); ?></h1>
<?php 

JTrinityCoreUtilities::ShowUserPoints(false);

// Donation shop banner
/*echo '<div style="float: right;">

<a href="index.php?option=com_jtrinitycore&view=donationshop"><img src="'.$images.'donationshop.png"></a>
</div>
';*/
?>

<div id="flashContent" style="float: right;">
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="350" height="90" id="bannernow" align="middle">
				<param name="movie" value="media/com_jtrinitycore/images/donationshop.swf" />
				<param name="quality" value="high" />
				<param name="bgcolor" value="#ffffff" />
				<param name="play" value="true" />
				<param name="loop" value="true" />
				<param name="wmode" value="window" />
				<param name="scale" value="showall" />
				<param name="menu" value="true" />
				<param name="devicefont" value="false" />
				<param name="salign" value="" />
				<param name="allowScriptAccess" value="sameDomain" />
				<!--[if !IE]>-->
				<object type="application/x-shockwave-flash" data="media/com_jtrinitycore/images/donationshop.swf" width="350" height="90">
					<param name="movie" value="media/com_jtrinitycore/images/donationshop.swf" />
					<param name="quality" value="high" />
					<param name="bgcolor" value="#ffffff" />
					<param name="play" value="true" />
					<param name="loop" value="true" />
					<param name="wmode" value="window" />
					<param name="scale" value="showall" />
					<param name="menu" value="true" />
					<param name="devicefont" value="false" />
					<param name="salign" value="" />
					<param name="allowScriptAccess" value="sameDomain" />
				<!--<![endif]-->
					<a href="http://www.adobe.com/go/getflash">
						<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
					</a>
				<!--[if !IE]>-->
				</object>
				<!--<![endif]-->
			</object>
		</div>

<?php 


$html='';
$html.=JText::_('COM_JTRINITYCORE_HELLO').' '.'<strong>'.$user_name.'</strong>!<br /><br />'
		.JText::_('COM_JTRINITYCORE_ACCOUNTID').' '.'<strong>'.$user_username.'</strong><br />
		'.JText::_('COM_JTRINITYCORE_ACCOUNT_LAST_USED').' <strong>'. $last_login.'</strong><br />
		'.JText::_('COM_JTRINITYCORE_ACCOUNT_LAST_IP').' <strong>'. $last_ip.'</strong><br />
		'.JText::_('COM_JTRINITYCORE_ACCOUNT_CURRENT_IP').' <strong>'. $remote_IP.'</strong><br />';
$html.= JText::_('COM_JTRINITYCORE_YOUR_EXPANSION')." ";
							
$html.= '<strong>'.$expansion_string.'</strong>';							
$html.='<br />';
$html.= JText::_('COM_JTRINITYCORE_YOUR_ACCOUNT_IS')." "; 
							
if (!$banned) { 
	$html.= "<span style='color:green'><strong>".JText::_('COM_JTRINITYCORE_NOT_BANNED')."</strong></span>";
} else 
	{
		$html.= "<span style='color:red><strong>".JText::_('COM_JTRINITYCORE_BANNED')."</strong></span>";
	};
							

	$html.="<br/><br/><table><tr><td>";
		// Change Password
		$html.='<table style="border-collapse: collapse;border:0;padding:0" ><tr>
     <td valign="top"><img width="60" height="50"  src="'.$images.'icon_lock.png"></td>
     <td valign="top">
       <a href="index.php?option=com_users&view=profile&layout=edit">'.JText::_('COM_JTRINITYCORE_CHANGE_PASSWORD').'</a> <br/>
       '.JText::_('COM_JTRINITYCORE_CHANGE_PASSWORD_DESC').'
      </td>
     </tr></table>';
							
							
							 // Character teleporter
							  $html.='
							 
                                <table ><tr>
                                <td valign="top"><img width="60" height="50" border="0" src="'.$images.'movecharact.png"></td>
                                <td valign="top">
                                <a href="index.php?option=com_jtrinitycore&view=teleporter">'.JText::_('COM_JTRINITYCORE_CHARACTER_TELEPORTER'). '</a> <br/>
                                '.JText::_('COM_JTRINITYCORE_CHARACTER_TELEPORTER_DESC').'
                                </td>
                                </tr></table>';
							  
							 // Character unstucker
							  $html.='							  
							    <table ><tr>
                                <td valign="top"><img width="60" height="50" border="0" src="'.$images.'chars.png"></td>
                                <td valign="top">
                                <a href="index.php?option=com_jtrinitycore&view=unstucker">'.JText::_('COM_JTRINITYCORE_CHARACTER_UNSTUCK').' </a> <br/>
                                '.JText::_('COM_JTRINITYCORE_CHARACTER_UNSTUCK_DESC').'
                                </td>
                                </tr></table>';
							 
							  
							// Character transfer
							  $html.='
							  
							     <table ><tr>
                                <td valign="top"><img width="60" height="50" border="0" src="'.$images.'transfercharacters.png"></td>
                                <td valign="top">
                                <a href="index.php?option=com_jtrinitycore&view=cpanel&layout=commingsoon"> Character Transfer </a> <br/>
                                 Migrate your character to another account. 
                                </td>
                                </tr></table> '; 
							  
							  // Characters info
							  $html.='
							  <table ><tr>
							  <td valign="top"><img width="60" height="50" border="0" src="'.$images.'chars_info.png"></td>
							  <td valign="top">
							  <a href="index.php?option=com_jtrinitycore&view=charactersinfo">'.JText::_('COM_JTRINITYCORE_CHARSINFO').'</a> <br/>
							  '.JText::_('COM_JTRINITYCORE_CHARSINFO_DESC').'
							  </td>
							  </tr></table> ';
							  
							  
							  // Vote
							  $html.='
							  
							   <table ><tr>
							  <td valign="top"><img width="60" height="50" border="0" src="'.$images.'voteshop.png"></td>
							  <td valign="top">
							  <a href="index.php?option=com_jtrinitycore&view=cpanel&layout=commingsoon"> Vote Shop </a> <br/>
							   Migrate your character to another account. 
							  </td>
							  </tr></table>  </td>';
							  
							  // Get points with paypal
							  $html.='<td>   <div style="float:right">							  
							   <table ><tr>
							  <td valign="top"><img width="60" height="50" border="0" src="'.$images.'paypal.png"></td>
							  <td valign="top">
							  <a href="index.php?option=com_jtrinitycore&view=buypoints">'.JText::_('COM_JTRINITYCORE_DONATE_GET_POINTS').'</a> <br/>
							   '.JText::_('COM_JTRINITYCORE_DONATE_GET_POINTS_DESC').' 
							  </td>
							  </tr></table> ';
							  
							  // Get points with SMS
							  $html.='
							   <table ><tr>
							  <td valign="top"><img width="60" height="50" border="0" src="'.$images.'sms.png"></td>
							  <td valign="top">
							  <a href="index.php?option=com_jtrinitycore&view=cpanel&layout=commingsoon">'.JText::_('COM_JTRINITYCORE_DONATE_GET_POINTS_SMS').'</a> <br/>
							   '.JText::_('COM_JTRINITYCORE_DONATE_GET_POINTS_SMS_DESC').' 
							  </td>
							  </tr></table> ';
							  
							  // Donation Shop
							  $html.='
							   <table ><tr>
							  <td valign="top"><img width="60" height="50" src="'.$images.'items.png"></td>
							  <td valign="top">
							  <a href="index.php?option=com_jtrinitycore&view=donationshop">'.JText::_('COM_JTRINITYCORE_DONATE_WITH_PAYPAL').'</a> <br/>
							   '.JText::_('COM_JTRINITYCORE_DONATE_WITH_PAYPAL_DESC').' 
							  </td>
							  </tr></table></div> </td></tr></table>';
							  
							  
							  
										 	
							  
							  print $html;
							  
							 
?>
