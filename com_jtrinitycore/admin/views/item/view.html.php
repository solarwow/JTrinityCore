<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Item View to edit/add items
 */
class JTrinityCoreViewItem extends JView
{
	/**
	 * display method of TrinityCore view
	 * @return void
	 */
	public function display($tpl = null) 
	{
		
		// get the Data
		// Calls the getForm() method of the model
		$this->form = $this->get('Form');
		
		// Calls the getItem() method of the model
		 $this->item = $this->get('Item');
		
		// Calls the geScript() method of the model
		//$this->script = $this->get('Script');
	
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		
 
		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
		
		// Set the document
		$this->setDocument();
		
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		// Main menu inactive until apply or edit
		JRequest::setVar('hidemainmenu', true);
		$user = JFactory::getUser();
		$userId = $user->id;
		$isNew = $this->item->id == 0;
		$canDo = JTrinityCoreHelper::getActions($this->item->id);
		JToolBarHelper::title($isNew ? JText::_('COM_JTRINITYCORE_MANAGER_ITEM_NEW')
		                             : JText::_('COM_JTRINITYCORE_MANAGER_ITEM_EDIT'));
		// Built the actions for new and existing records.
		if ($isNew) 
		{
			// For new records, check the create permission.
			if ($canDo->get('core.create')) 
			{
				JToolBarHelper::apply('item.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('item.save', 'JTOOLBAR_SAVE');
				JToolBarHelper::custom('item.save2new', 'save-new.png', 'save-new_f2.png',
				                       'JTOOLBAR_SAVE_AND_NEW', false);
			}
			JToolBarHelper::cancel('item.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			if ($canDo->get('core.edit'))
			{
				// We can save the new record
				JToolBarHelper::apply('item.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('item.save', 'JTOOLBAR_SAVE');
 
				// We can save this record, but check the create permission to see
				// if we can return to make a new one.
				if ($canDo->get('core.create')) 
				{
					JToolBarHelper::custom('item.save2new', 'save-new.png', 'save-new_f2.png',
					                       'JTOOLBAR_SAVE_AND_NEW', false);
				}
			}
			if ($canDo->get('core.create')) 
			{
				JToolBarHelper::custom('item.save2copy', 'save-copy.png', 'save-copy_f2.png',
				                       'JTOOLBAR_SAVE_AS_COPY', false);
			}
			JToolBarHelper::cancel('item.cancel', 'JTOOLBAR_CLOSE');
		}
	}
	
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
protected function setDocument() 
	{
		$isNew = ($this->item->id < 1);
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('COM_JTRINITYCORE_MANAGER_ITEM_NEW')
		                           : JText::_('COM_JTRINITYCORE_MANAGER_ITEM_EDIT'));
		//$document->addScript(JURI::root() . $this->script);
		//$document->addScript(JURI::root() . "/administrator/components/com_jtrinitycore"
		  //                                . "/views/jtrinitycore/submitbutton.js");
		//JText::script('COM_HELLOWORLD_HELLOWORLD_ERROR_UNACCEPTABLE');
	}
}