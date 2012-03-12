<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_jtrinitycore'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Set some global property
//$document = JFactory::getDocument();
//$document->addStyleDeclaration('.icon-48-jtrinitycore {background-image: url(../media/com_jtrinitycore/images/jtrinitycore48x48.png);}');

// require helper file
JLoader::register('JTrinityCoreHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'jtrinitycore.php');
JLoader::register('JTrinityCoreUtilities', dirname(__FILE__) . DS . 'helpers' . DS . 'jtrinitycoreutilities.php');
JLoader::register('JTrinityCoreDBHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'jtrinitycoredb.php');
require_once( JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'global.php' );

// import joomla controller library
jimport('joomla.application.component.controller');

// Set log
$date = JFactory::getDate()->format('Y-m-d');
$options['format'] = '{DATE}\t {TIME} \t{LEVEL} \t{CODE} \t{MESSAGE}';
$options['text_file'] = 'jtrinitycore.'.$date.'.php';
JLog::addLogger($options, JLog::ALL,'com_jtrinitycore');
 
// Get an instance of the controller prefixed by JTrinityCore
$controller = JController::getInstance('JTrinityCore');
 
$task=JRequest::getCmd('task');

// Perform the Request task
$controller->execute($task);
 
// Redirect if set by the controller
$controller->redirect();

