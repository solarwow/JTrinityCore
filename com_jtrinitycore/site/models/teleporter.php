<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modellist');

/**
 * JTrinityCore Model
 */
class JTrinityCoreModelTeleporter extends JModel
{
	public function getCharacterGold($realmid, $guid)
	{
	
		// Homebind
		$db=JTrinityCoreDBHelper::getDB();
		$database=JTrinityCoreUtilities::getCharacterDBName($realmid);
		$query = 'SELECT money FROM '.$database.'.characters WHERE guid = '.$guid.' LIMIT 1';
		$db->setQuery($query);
		if (!$money=$db->loadResult())
		{
			JLog::add("getCharacterGold: error. sql=".$query,JLog::ERROR);
			$gold=0;
		}
		else {
			// Convert to gold
			$gold=(int) floor($money/10000);
		}
		
		
		return $gold;
	
		
	}
	
	public function teleport($realmid, $guid, $x, $y, $z, $map, $newGold)
	{
		$chardb=JTrinityCoreUtilities::getCharacterDBName($realmid);
		$db=JTrinityCoreDBHelper::getDB();
		
		$query ='UPDATE '. $chardb.'.characters SET position_x="'.$x.'", position_y="'.$y.'", position_z="'.$z.'", map="'.$map.'", money="'.$newGold.'" WHERE guid="'.$guid.'"';
		$db->setQuery($query);
		
		if (!$db->query()) {
			JLog::add("Error teleporting. SQL=".$query,JLog::ERROR);
			return false;
		}
		
		return true;
	}
}
