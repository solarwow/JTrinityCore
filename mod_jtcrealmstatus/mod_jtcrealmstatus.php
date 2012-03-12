<?php
/**
 * realm status Module Entry Point
 * 
 * @package    Joomla.Tutorials
 * @subpackage Modules
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:modules/
 * @license        GNU/GPL, see LICENSE.php
 * mod_helloworld is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );
require_once( JPATH_SITE . DS . 'administrator' . DS . 'components' . DS . 'com_jtrinitycore'.DS.'helpers'.DS.'jtrinitycoreutilities.php' );
require_once( JPATH_SITE . DS . 'administrator' . DS . 'components' . DS . 'com_jtrinitycore'.DS.'helpers'.DS.'jtrinitycoredb.php' );

JTrinityCoreDBHelper::createDatabases();

$helper=new modJtcRealmStatusHelper();

$authserverip = $helper->getServerIP();
$auth_port=$helper->getAuthServerPort();

$items=$helper->getRealms();


// Load layout template
require( JModuleHelper::getLayoutPath( 'mod_jtcrealmstatus' ) );
?>
