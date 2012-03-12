<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * Items Model
 */
class JTrinityCoreModelRealms extends JModelList
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
		$query->select('i.*');
		// From the hello table
		$query->from('#__jtc_realms as i');
	
		
				
		return $query;
	}
	
	public function getItems()
	{	
		
		$items=parent::getItems();
		
		// If current realm list is empty populate from TC database
		if ($this->getTotal()<=0)
		{
			$authdb=JTrinityCoreDBHelper::getAuthDBName();
			$sql="SELECT id, name, address, port, population FROM ".$authdb.".realmlist";
			$dbo=JTrinityCoreDBHelper::getDB();
			$dbo->setQuery($sql);
			$results = $dbo->loadObjectList();
			
			if(count($results)) {
				foreach($results as $row) {
				   $data =new stdClass();
				   $data->id = NULL;
				   $data->realmid = $row->id;
				   $data->realmname = $row->name;
				   $data->ip = $row->address;
				   $data->port = $row->port;
				   $data->population = $row->population;
				
				  
				   $this->_db->insertObject('#__jtc_realms', $data, 'id');
				}
				$items=parent::getItems();
			}				
		
		}
		return $items;
	}
}