<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * Items Model
 */
class JTrinityCoreModelSearchItems extends JModelList
{
	
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JController
	 * @since   1.6
	 */
	public function __construct($config = array())
	{
	if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'a.itemid', 'itemid',
				'a.name', 'name',				
				'a.itemlevel', 'itemlevel', 
				'a.requiredlevel', 'requiredlevel',
				'a.class', 'class',
				'a.InventoryType', 'InventoryType', 	
				'a.Quality', 'Quality',
				'a.AllowableClass', 'AllowableClass',
			);
		}
		
		//echo "Construct JModel <br>";
		//echo "__state_set=" . $this->__state_set."<br>";
	
		parent::__construct($config);
		
		
		$db=JTrinityCoreDBHelper::getDB();
		
		
		// I have to set the DB object for the model, if not gets the joomla db
		parent::setDbo($db);
	}
	
	/**
	 * Method to get a list of items.
	 * Overridden 
	 *
	 * @return	mixed	An array of data items on success, false on failure.
	 * @since	1.6.1
	 */
	public function getItems()
	{
		
		$items	= parent::getItems();
		
		return $items;
	}
	
	/**
	 * Build an SQL query to load the list data.
	 *	
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		
		$worlddb=JTrinityCoreUtilities::getWorldDBName(JRequest::getVar('realmid'));
		$db=JTrinityCoreDBHelper::getDB();
		$query	= $db->getQuery(true);
		
				
		// Select the required fields from the table.
		$query->select(
				$this->getState(
						'list.select',
						'DISTINCT a.entry as itemid, itemlevel, requiredlevel, a.name as englishname, quality, allowablerace, subclass, class, inventorytype'
				)
		);
		$query->from($worlddb.'.item_template AS a');
		$query->where('a.flags<>16 AND (a.name IS NOT NULL) AND (a.name not like \'%deprecated%\') AND (a.name not like \'%test%\')');
		
		$name="a.name";
		$locale=JTrinityCoreUtilities::getLocale();
		if ($locale>1)
		{
			$name="name_loc".$locale;
			$query->select($name." as name");
			$query->where($name." IS NOT NULL");			
			$query->join('INNER', $worlddb.'.locales_item AS li ON li.entry=a.entry ');
			#__users AS uc ON uc.id=a.checked_out
		}
		else
			$query->select("a.name as name");
		
		
		// Filter by class state
		$class = $this->getState('filter.class_id');
		if (is_numeric($class)) {
			$query->where('a.class = ' . (int) $class);
		}	
		
		
		
		// Filter on quality.
		$quality = $this->getState('filter.quality_id');
		if (is_numeric($quality)) {
			$query->where('a.Quality ='.$quality);
		}
		
		// Filter on Inventory Type.
		$inventory = $this->getState('filter.inventory_id');
		if (is_numeric($inventory)) {
			$query->where('a.InventoryType ='.$inventory);
		}
		
		// Filter on allowable class
		$allowableclass = $this->getState('filter.allowableclass');
		if (is_numeric($allowableclass)) {
			$query->where('a.AllowableClass ='.$allowableclass);
		}
		
		// Filter by search in title.
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'itemid:') === 0) {
				$query->where('a.displayid = '.(int) substr($search, 7));
			}	
			else if (stripos($search, 'itemlevel:') === 0) {
				$query->where('itemlevel = '.(int) substr($search, 10));
			}
			if (stripos($search, 'requiredlevel:') === 0) {
				$query->where('requiredlevel = '.(int) substr($search, 14));
			}	
			else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('('.$name.' LIKE '.$search.')');
			}
		}
		
		// Add the list ordering clause.		
		$orderCol	= $this->state->get('list.ordering', 'i.name');
		$orderDirn	= $this->state->get('list.direction', 'asc');
		//echo "Order field=".$orderCol."---<br>";
		
		if ($orderCol == 'a.name' || $orderCol=='name' ) {
			$orderCol = 'name ';
		}
		if ($orderCol == 'a.itemid' || $orderCol=='itemid' ) {
			$orderCol = 'itemid ';
		}
		if ($orderCol == 'a.itemlevel' || $orderCol=='itemlevel' ) {
			$orderCol = 'itemlevel ';
		}
		//sqlsrv change		
		/*if($orderCol == 'access_level')
			$orderCol = 'ag.title';*/
		
		$query->order($db->escape($orderCol.' '.$orderDirn));
		
		// echo nl2br(str_replace('#__','jos_',$query));
		
		//JLog::add('Query='.$query, JLog::WARNING, 'deprecated');
		//JError::raiseError(0, JText::sprintf('DB Name antes='.$db->getDatabase()."  Version=".$db->getVersion()."  connected=".$db->connected(), 'hola'));
		
		return $query;
	}
	
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		//$app = JFactory::getApplication('administrator');
	
			
		// Initialise variables.
		$app = JFactory::getApplication();
		$session = JFactory::getSession();
		
		// Adjust the context to support modal layouts.
		if ($layout = JRequest::getVar('layout')) {
			$this->context .= '.'.$layout;
		}
		
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);
		
		$search = $this->getUserStateFromRequest($this->context.'.filter.class_id', 'filter_class_id');
		$this->setState('filter.class_id', $search);
		
						
		$qualityid = $this->getUserStateFromRequest($this->context.'.filter.quality_id', 'filter_quality_id', '');
		$this->setState('filter.quality_id', $qualityid);
		
		$inventoryId = $this->getUserStateFromRequest($this->context.'.filter.inventory_id', 'filter_inventory_id');
		$this->setState('filter.inventory_id', $inventoryId);
		
		$allowableclass = $this->getUserStateFromRequest($this->context.'.filter.allowableclass', 'filter_allowableclass');
		$this->setState('filter.allowableclass', $allowableclass);
		
		//$level = $this->getUserStateFromRequest($this->context.'.filter.level', 'filter_level', 0, 'int');
		//$this->setState('filter.level', $level);		
		
		
		// List state information.
		parent::populateState('name', 'asc');
		
	
		
	}
	
	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id  A prefix for the store id.
	 *
	 * @return  string  A store id.
	 *
	 * @since   1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.search');
		$id	.= ':'.$this->getState('filter.allowableclass');
		$id	.= ':'.$this->getState('filter.class_id');
		$id	.= ':'.$this->getState('filter.quality_id');
		$id	.= ':'.$this->getState('filter.inventory_id');
	
	
		return parent::getStoreId($id);
	}
}