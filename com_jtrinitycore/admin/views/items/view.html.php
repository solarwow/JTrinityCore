<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Items View
 */
class JTrinityCoreViewItems extends JView
{
	/**
	 * Items  view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
				
		// Get data from the model. Calls the getItems() funtion of the model	
		$items = $this->get('Items');	
		$pagination = $this->get('Pagination');
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;
 
		
		// Set the toolbar
		$this->addToolBar();
		
		
		// Display the template
		parent::display($tpl);
		
		// Set the document
		$this->setDocument();
		
		// Add submenu 
		JTrinityCoreHelper::addSubmenu('items');
		
		
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		$canDo = JTrinityCoreHelper::getActions();
		//JToolBarHelper::title(JText::_('COM_JTRINITYCORE_ITEMS'), 'items.png');
		JToolBarHelper::title(JText::_('COM_JTRINITYCORE_ITEMS'));
		if ($canDo->get('core.create')) 
		{
			JToolBarHelper::addNew('item.add', 'JTOOLBAR_NEW');
		}
		if ($canDo->get('core.edit')) 
		{
			JToolBarHelper::editList('item.edit', 'JTOOLBAR_EDIT');
		}
		if ($canDo->get('core.delete')) 
		{
			JToolBarHelper::deleteList('', 'items.delete', 'JTOOLBAR_DELETE');
		}
		/*if ($canDo->get('core.admin')) 
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_items');
		}*/
		JToolBarHelper::custom('cpanel', 'back.png', 'back_f2.png',
					                       'JTOOLBAR_CPANEL', false);
	}
	
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_JTRINITYCORE_ITEMS'));
	}
}