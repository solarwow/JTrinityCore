<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class
 */
class JTrinityCoreViewUnstucker extends JView
{
	//protected $acc;
	
	// Overwriting JView display method
	public function display($tpl = null) 
	{
		// Assign data to the view
		//$this->acc = $this->get('AccountData');
		
		
		 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Display the view
		parent::display($tpl);
	}
	
	protected function unstuck($realmid, $guid)
	{	
			
		// Homebind
		$db=JTrinityCoreDBHelper::getDB();
		$database=JTrinityCoreUtilities::getCharacterDBName($realmid);
		$query = 'SELECT * FROM '.$database.'.character_homebind WHERE guid = '.$guid.' LIMIT 1';
		$db->setQuery($query);
		if (!$obj=$db->loadObject())
		{
			JLog::add("Unstuck: error. sql=".$query,JLog::ERROR);
			return false;
		}
	
		
		$query ='UPDATE '.$database.'.characters SET position_x="'.$obj->position_x.'", position_y="'.$obj->position_y.'", position_z="'.$obj->position_z.'", map="'.$obj->map.'", zone="'.$obj->zone.'" WHERE guid='.$guid.' LIMIT 1';
		$db->setQuery($query);
		if (!$db->query())
		{
			JLog::add("Unstuck: error. sql=".$query,JLog::ERROR);
			return false;
		}
		
		return true;
	}
}
