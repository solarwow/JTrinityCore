<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modellist');
 
/**
 * JTrinityCore Model
 */
class JTrinityCoreModelBuyPowerleveling extends JModelList
{	
	
 
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
	
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('i.id, i.minLevel, i.maxLevel, i.cost');
		// From the hello table
		$query->from('#__jtc_powerleveling as i');
		
	
	
		return $query;
	}
}