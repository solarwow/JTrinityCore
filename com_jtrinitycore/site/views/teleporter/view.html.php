<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class
 */
class JTrinityCoreViewTeleporter extends JView
{
	//protected $acc;
	
	// Overwriting JView display method
	public function display($tpl = null) 
	{
		// Assign data to the view
		//$this->acc = $this->get('AccountData');
		
		
		 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Display the view
		parent::display($tpl);
	}
	
	
}

