<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of JTrinityCore component
 */
class JTrinityCoreController extends JController
{
	/**
	 * display task
	 *
	 * @return void
	 */
	public function display($cachable = false, $urlparams = false) 
	{
		// if task, set the view task
		/*$task=JRequest::getCmd('task');
		$view=JRequest::getCmd('view');
		if (!empty($task) && empty($view))		
			$default_view=$task;		
		else
			$default_view="cpanel";*/
		
		// set default view if not set
		//JRequest::setVar('view', $default_view);
		JRequest::setVar('view', JRequest::getVar('view','cpanel'));
			
		
 
		// call parent behavior
		parent::display($cachable);
		
		// Set the submenu
		//JTrinityCoreHelper::addSubmenu('items');
		
	}
}