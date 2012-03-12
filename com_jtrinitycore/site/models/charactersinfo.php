<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modellist');

/**
 * Chractersinfo Model
 */
class JTrinityCoreModelCharactersInfo extends JModelList
{

	protected function getListQuery()
	{
	
		// Create a new query object.
				
		$query = $this->_db->getQuery(true);
		// Select some fields
		$query->select('i.*');
		// From the hello table
		$query->from('#__jtc_realms as i');
	
	
	
		return $query;
	}
	
	
	
	public function getCharacters($realmid)
	{
		$chardb=JTrinityCoreUtilities::getCharacterDBName($realmid);
		$accid=JTrinityCoreDBHelper::getAccId();
		
		$sql="SELECT * FROM ".$chardb.".characters  WHERE account=".$accid;
		
		$db=JTrinityCoreDBHelper::getDB();
		$db->setQuery($sql);
		
		return $db->loadObjectList();
		
	}
	

}

