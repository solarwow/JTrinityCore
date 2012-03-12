<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * JTrinityCores View
 */
class JTrinityCoreViewCPanel extends JView
{
	/**
	 * CPanel view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		
						
		// Display the template
		parent::display($tpl);
		
		$this->addToolBar();
		
		// Set the document
		$this->setDocument();
		
		
	}
	
	
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_JTRINITYCORE_CPANEL'));
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		$canDo = JTrinityCoreHelper::getActions();
		JToolBarHelper::title(JText::_('COM_JTRINITYCORE_CPANEL'), 'cpanel');
		//lBarHelper::deleteList('', 'items.delete', 'JTOOLBAR_DELETE');
		
		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::divider();
			// Global preferences of jtrinitycore component
			JToolBarHelper::preferences('com_jtrinitycore');
		}
	}
	
}