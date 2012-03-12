<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<?php 

echo "<strong>".$helper->getSetRealmlist()."</strong><br/><br/>";



// Auth server
/*echo "<table border=0 cellspacing=0 cellpadding=3>
<tr>
<td align=\"left\" valign=\"middle\">Login Server:</td>";
echo '<td align="left" valign="middle">';

if (! $sock = @fsockopen($authserverip, $auth_port, $num, $error, 4))	
	echo "<FONT COLOR=red>Offline</font>";
else{	
	echo "<FONT COLOR=green>Online</font>";
	fclose($sock);
}
echo "</td></tr>";*/


// For each realm print status
// World server

foreach($items as $i => $item):?>
	
	<h2> <?php echo $item->realmname; ?> </h2>
	
	<?php echo JText::_('COM_JTRINITYCORE_GAMESERVER'); 
	
	if (! $sock = @fsockopen($item->ip, $item->port, $num, $error, 4))
		echo "<FONT COLOR=red>".JText::_('COM_JTRINITYCORE_OFFLINE')."</font>";
	else{
		echo "<FONT COLOR=green>".JText::_('COM_JTRINITYCORE_ONLINE')."</font>";
		fclose($sock);
	}
	?>
	<br/>
	 <?php  echo JText::_('COM_JTRINITYCORE_VERSION');	
	   		echo $item->versionserver; ?>
	   		<br/>
	 <?php  echo JText::_('COM_JTRINITYCORE_SERVERTYPE');	
	   		echo $item->servertype; ?>
	   		<br/>
	 <?php  echo JText::_('COM_JTRINITYCORE_ONLINEPLAYERS');	
	   		echo $helper->getOnlinePlayers($item->charactersdb); ?>
	   		<br/>
	   	
	 <?php  echo $item->descriptiontitle;	
	   		echo $item->description; ?>
	   		<br/>
	 <?php  echo JText::_('COM_JTRINITYCORE_UPTIME');	
	   		echo $helper->getUptimeServer($item->realmid); ?>
	 
	 
	<br/><br/>
	<?php 	
	

endforeach;


?>
