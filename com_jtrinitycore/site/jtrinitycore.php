<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import joomla controller library
jimport('joomla.application.component.controller');
 
//JLoader::register('JTrinityCoreUtilities', dirname(__FILE__) . DS . 'helpers' . DS . 'jtrinitycoreutilities.php');
require_once( JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'jtrinitycoreutilities.php' );
require_once( JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'jtrinitycoredb.php' );
require_once( JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'global.php' );


// Set log
$date = JFactory::getDate()->format('Y-m-d');
$options['format'] = '{DATE}\t {TIME} \t{LEVEL} \t{CODE} \t{MESSAGE}';
$options['text_file'] = 'jtrinitycore.'.$date.'.php';
JLog::addLogger($options, JLog::ALL,'com_jtrinitycore');	




// Get an instance of the controller prefixed by JTrinityCore
$controller = JController::getInstance('JTrinityCore');
 
// Perform the Request task
$controller->execute(JRequest::getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();