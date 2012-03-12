<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JRequest::checkToken() or die( 'Invalid Token' );


// Check if the character has enough gold
$params = JComponentHelper::getParams( 'com_jtrinitycore');
$teleportercost=$params->get( 'teleportergold' );
$guid=JRequest::getVar('characterid');
$realmid=JRequest::getVar('realmid');
$location=JRequest::getVar('location');
$model=$this->getModel();

if ($teleportercost>0)
{
	// Get character gold
	$gold=$model->getCharacterGold($realmid, $guid);
	
	if ($gold< (int) $teleportercost)
	{
		echo "<strong>".JText::sprintf('COM_JTRINITYCORE_TELEPORTER_NOT_ENOUGHGOLD',$gold)."</strong>";
		return;
	}
}

$map = "";
$x = "";
$y = "";
$z = "";
$place = "";

switch($location)
{
	//stormwind
	case 1:
		$map = "0";
		$x = "-8913.23";
		$y = "554.633";
		$z = "93.7944";
		$place = "Stormwind City";
		break;
		//ironforge
	case 2:
		$map = "0";
		$x = "-4981.25";
		$y = "-881.542";
		$z = "501.66";
		$place = "Ironforge";
		break;
		//darnassus
	case 3:
		$map = "1";
		$x = "9951.52";
		$y = "2280.32";
		$z = "1341.39";
		$place = "Darnassus";
		break;
		//exodar
	case 4:
		$map = "530";
		$x = "-3987.29";
		$y = "-11846.6";
		$z = "-2.01903";
		$place = "The Exodar";
		break;
		//orgrimmar
	case 5:
		$map = "1";
		$x = "1676.21";
		$y = "-4315.29";
		$z = "61.5293";
		$place = "Orgrimmar";
		break;
		//thunderbluff
	case 6:
		$map = "1";
		$x = "-1196.22";
		$y = "29.0941";
		$z = "176.949";
		$place = "Thunder Bluff";
		break;
		//undercity
	case 7:
		$map = "0";
		$x = "1586.48";
		$y = "239.562";
		$z = "-52.149";
		$place = "The Undercity";
		break;
		//silvermoon
	case 8:
		$map = "530";
		$x = "9473.03";
		$y = "-7279.67";
		$z = "14.2285";
		$place = "Silvermoon City";
		break;
		//shattrath
	case 9:
		$map = "530";
		$x = "-1863.03";
		$y = "4998.05";
		$z = "-21.1847";
		$place = "Shattrath";
		break;
		//for unknowness -> shattrath
	default:
		JLog::add('teleport.php: Invalid location. Location='.$location,JLog::ERROR);
		echo "<strong>Invalid location.</strong>";
		return;		
	break;
}

if (!$char=JTrinityCoreDBHelper::getCharacterInfo($realmid, $guid))
{
	JLog::add('Error getting char info. Realmid='.$realmid.'  guid='.$guid,JLog::ERROR);
	die("Error getting char info. Contact administrator or GM.");
}

// Disallows factions to use enemy portals
switch($char->race)
{
	//alliance race
	case 1:
	case 3:
	case 4:
	case 7:
	case 11:
		if((($location >=5) && ($location <=8)) && ($location != 9))
		{		
			echo JText::_('COM_JTRINITYCORE_NOTELEPORT_ALLIANCE_HORDE');
			return;
		}
		break;
	//horde race
	case 2:
	case 5:
	case 6:
	case 8:
	case 10:
		if ((($location >=1) && ($location <=4)) && ($location != 9))
		{			
			echo JText::_('COM_JTRINITYCORE_NOTELEPORT_HORDE_ALLIANCE');
			return;
		}
		break;
	default:
		die("<strong>The selected race is not valid.<br><br></strong>");
	break;
}

// Check the character has the required level
if($char->level < 58 && $location == 9)
{	
	echo JText::_('COM_JTRINITYCORE_NOTELEPORT_LEVEL');
	return;
}

$newMoney=$char->money-$teleportercost*10000;
$newGold=floor($newMoney/10000);
if ($model->teleport($realmid, $guid,$x,$y,$z,$map,$newMoney))
{
	echo JText::sprintf('COM_JTRINITYCORE_TELEPORTER_OK', $place,$newGold);
}
else
{
	echo JText::_('COM_JTRINITYCORE_TELEPORTER_ERROR');
}

