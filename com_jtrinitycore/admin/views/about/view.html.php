<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * JTrinityCores View
 */
class JTrinityCoreViewAbout extends JView
{
	/**
	 * CPanel view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		$this->addToolBar();
						
		// Display the template
		parent::display($tpl);
		
		
		
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
		$document->setTitle(JText::_('COM_JTRINITYCORE_ABOUT'));
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
	
		JToolBarHelper::title(JText::_('COM_JTRINITYCORE_ABOUT'),'user-profile');
		JToolBarHelper::back();
		
		//JToolBarHelper::custom('cpanel', 'back.png', 'back_f2.png','JTOOLBAR_CPANEL', false);
		
		
	}
	
}
