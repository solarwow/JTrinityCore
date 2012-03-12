<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modellist');
 
/**
 * JTrinityCore Model
 */
class JTrinityCoreModelBuyItems extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param	array	An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
					'id', 'i.id',
					'itemid', 'i.itemid',					
					'catid', 'i.catid', 'category_title',
					'itemlevel', 'i.itemlevel',					
					'requiredlevel', 'i.requiredlevel',
					'class', 'i.class',
					'inventorytype', 'i.inventorytype',
					'quality', 'i.quality',
					'allowableclass', 'i.allowableclass'
			);
		}
	
		parent::__construct($config);
	}
	
	/**
	 * Method to auto-populate the model state.
	 *
	 * This method should only be called once per instantiation and is designed
	 * to be called on the first call to the getState() method unless the model
	 * configuration flag to ignore the request is set.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 *
	 * @since   11.1
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();
		// Get the message id
		//$name = JRequest::getInt('name');
		//$this->setState('item.name', $name);
		
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);
		
		$categoryId = $this->getUserStateFromRequest($this->context.'.filter.category_id', 'filter_category_id');
		$this->setState('filter.category_id', $categoryId);
		
		$search = $this->getUserStateFromRequest($this->context.'.filter.class_id', 'filter_class_id');
		$this->setState('filter.class_id', $search);
		
		
		$qualityid = $this->getUserStateFromRequest($this->context.'.filter.quality_id', 'filter_quality_id', '');
		$this->setState('filter.quality_id', $qualityid);
		
		$inventoryId = $this->getUserStateFromRequest($this->context.'.filter.inventory_id', 'filter_inventory_id');
		$this->setState('filter.inventory_id', $inventoryId);
		
		$allowableclass = $this->getUserStateFromRequest($this->context.'.filter.allowableclass', 'filter_allowableclass');
		$this->setState('filter.allowableclass', $allowableclass);
 
		// Load the parameters.
		//$params = $app->getParams();
		//$this->setState('params', $params);
		//parent::populateState($ordering, $direction);
		parent::populateState('i.name', 'asc');
	}
	
	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 *
	 * @return	string		A store id.
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.search');		
		$id	.= ':'.$this->getState('filter.category_id');
		$id	.= ':'.$this->getState('filter.allowableclass');
		$id	.= ':'.$this->getState('filter.class_id');
		$id	.= ':'.$this->getState('filter.quality_id');
		$id	.= ':'.$this->getState('filter.inventory_id');
		
	
		return parent::getStoreId($id);
	}
 
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
		$query->select($this->getState('list.select','i.*,  c.title as category_title'));
		
		// From the hello table
		$query->from('#__jtc_items as i');
		$query->leftJoin('#__categories as c ON i.catid=c.id');
		
		// Filter by search in title.
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'itemid:') === 0) {
				$query->where('i.itemid = '.(int) substr($search, 7));
			}
			elseif (stripos($search, 'itemlevel:') === 0) {
				$query->where('i.itemlevel = '.(int) substr($search, 10));
			}		
			else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('(i.name LIKE '.$search.')');
			}
		}
		
		// Filter by class state
		$class = $this->getState('filter.class_id');
		if (is_numeric($class)) {
			$query->where('i.class = ' . (int) $class);
		}
		
		// Filter on quality.
		$quality = $this->getState('filter.quality_id');
		if (is_numeric($quality)) {
			$query->where('i.quality ='.$quality);
		}
		
		// Filter on Inventory Type.
		$inventory = $this->getState('filter.inventory_id');
		if (is_numeric($inventory)) {
			$query->where('i.inventorytype ='.$inventory);
		}
		
		// Filter on allowable class
		$allowableclass = $this->getState('filter.allowableclass');
		if (is_numeric($allowableclass)) {
			$query->where('i.allowablerace ='.$allowableclass);
		}
		
		// Filter by a single or group of categories.
		$baselevel = 1;
		$categoryId = $this->getState('filter.category_id');
		if (is_numeric($categoryId)) {
			$cat_tbl = JTable::getInstance('Category', 'JTable');
			$cat_tbl->load($categoryId);
			$rgt = $cat_tbl->rgt;
			$lft = $cat_tbl->lft;
			$baselevel = (int) $cat_tbl->level;
			$query->where('c.lft >= '.(int) $lft);
			$query->where('c.rgt <= '.(int) $rgt);
		}
		elseif (is_array($categoryId)) {
			JArrayHelper::toInteger($categoryId);
			$categoryId = implode(',', $categoryId);
			$query->where('i.catid IN ('.$categoryId.')');
		}
		
		
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'i.name');
		$orderDirn	= $this->state->get('list.direction', 'asc');
		if ($orderCol == 'i.name' || $orderCol=='name') {
			$orderCol = 'i.name ';
		}
		//sqlsrv change
		if($orderCol == 'category')
			$orderCol = 'c.title';
		if($orderCol == 'itemid')
			$orderCol = 'i.itemid';
		if($orderCol == 'itemlevel')
			$orderCol = 'i.itemlevel';
		$query->order($db->escape($orderCol.' '.$orderDirn));
		
	
		return $query;
	}
}