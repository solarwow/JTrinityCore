<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * JTrinityCores View
 */
class JTrinityCoreViewJTrinityCores extends JView
{
	/**
	 * JTrinityCore view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		echo "JTrinityCores View <br>";
		
		// Get data from the model. Calls the getItems() funtion of the model
		echo "JTrinityCores View getItems <br>";
		$items = $this->get('Items');
		echo "JTrinityCores View getPagination <br>";
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
 
		echo "JTrinityCores View añadir  ToolBar <br>";
		// Set the toolbar
		$this->addToolBar();
		
		
		// Display the template
		parent::display($tpl);
		
		// Set the document
		$this->setDocument();
		
		echo "FIN JTrinityCores View <br>";
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		$canDo = JTrinityCoreHelper::getActions();
		JToolBarHelper::title(JText::_('COM_JTRINITYCORE_MANAGER_HELLOWORLDS'), 'jtrinitycore');
		if ($canDo->get('core.create')) 
		{
			JToolBarHelper::addNew('jtrinitycore.add', 'JTOOLBAR_NEW');
		}
		if ($canDo->get('core.edit')) 
		{
			JToolBarHelper::editList('jtrinitycore.edit', 'JTOOLBAR_EDIT');
		}
		if ($canDo->get('core.delete')) 
		{
			JToolBarHelper::deleteList('', 'jtrinitycores.delete', 'JTOOLBAR_DELETE');
		}
		if ($canDo->get('core.admin')) 
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_jtrinitycore');
		}
	}
	
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_JTRINITYCORE_ADMINISTRATION'));
	}
}