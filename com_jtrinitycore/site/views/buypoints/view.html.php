<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the JTrinityCore Component
 */
class JTrinityCoreViewBuyPoints extends JView
{
	//protected $points=0;
	protected $log;
	
	// Overwriting JView display method
	function display($tpl = null) 
	{
		$date = JFactory::getDate()->format('Y-m-d');
		$options['format'] = '{DATE}\t {TIME} \t{LEVEL} \t{CODE} \t{MESSAGE}';
		$options['text_file'] = 'paypal.'.$date.'php';
		JLog::addLogger($options, JLog::ALL,'paypal');		
		 
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