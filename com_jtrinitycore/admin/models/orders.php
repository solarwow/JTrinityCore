<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * Items Model
 */
class JTrinityCoreModelOrders extends JModelList
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
		$query->select('i.*, u.username');
		// From the hello table
		$query->from('#__jtc_orders as i');
		$query->innerJoin('#__users as u on i.userid=u.id');	
		$query->order('i.id ASC');
				
		return $query;
	}
}