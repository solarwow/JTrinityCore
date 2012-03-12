<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * TrinityCore View
 */
class JTrinityCoreViewJTrinityCore extends JView
{
	/**
	 * display method of TrinityCore view
	 * @return void
	 */
	public function display($tpl = null) 
	{
		echo "Dentro de JTrinityCore View.display.<br>";
		
		// get the Data
		// Calls the getForm() method of the model
		$form = $this->get('Form');
		echo "From  ";
		// Calls the getItem() method of the model
		$item = $this->get('Item');
		echo "Item  ";
		// Calls the geScript() method of the model
		$script = $this->get('Script');
		echo "Script  ";
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		// Assign the Data
		$this->form = $form;
		$this->item = $item;
		$this->script = $script;
 
		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
		
		// Set the document
		$this->setDocument();
		
		echo "Fin de JTrinityCore View.display   ";
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JRequest::setVar('hidemainmenu', true);
		$user = JFactory::getUser();
		$userId = $user->id;
		$isNew = $this->item->id == 0;
		$canDo = JTrinityCoreHelper::getActions($this->item->id);
		JToolBarHelper::title($isNew ? JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLD_NEW')
		                             : JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLD_EDIT'), 'jtrinitycore');
		// Built the actions for new and existing records.
		if ($isNew) 
		{
			// For new records, check the create permission.
			if ($canDo->get('core.create')) 
			{
				JToolBarHelper::apply('jtrinitycore.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('jtrinitycore.save', 'JTOOLBAR_SAVE');
				JToolBarHelper::custom('jtrinitycore.save2new', 'save-new.png', 'save-new_f2.png',
				                       'JTOOLBAR_SAVE_AND_NEW', false);
			}
			JToolBarHelper::cancel('jtrinitycore.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			if ($canDo->get('core.edit'))
			{
				// We can save the new record
				JToolBarHelper::apply('jtrinitycore.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('jtrinitycore.save', 'JTOOLBAR_SAVE');
 
				// We can save this record, but check the create permission to see
				// if we can return to make a new one.
				if ($canDo->get('core.create')) 
				{
					JToolBarHelper::custom('jtrinitycore.save2new', 'save-new.png', 'save-new_f2.png',
					                       'JTOOLBAR_SAVE_AND_NEW', false);
				}
			}
			if ($canDo->get('core.create')) 
			{
				JToolBarHelper::custom('jtrinitycore.save2copy', 'save-copy.png', 'save-copy_f2.png',
				                       'JTOOLBAR_SAVE_AS_COPY', false);
			}
			JToolBarHelper::cancel('jtrinitycore.cancel', 'JTOOLBAR_CLOSE');
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
		$document->setTitle($isNew ? JText::_('COM_HELLOWORLD_HELLOWORLD_CREATING')
		                           : JText::_('COM_HELLOWORLD_HELLOWORLD_EDITING'));
		$document->addScript(JURI::root() . $this->script);
		$document->addScript(JURI::root() . "/administrator/components/com_jtrinitycore"
		                                  . "/views/jtrinitycore/submitbutton.js");
		JText::script('COM_HELLOWORLD_HELLOWORLD_ERROR_UNACCEPTABLE');
	}
}