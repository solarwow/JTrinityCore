<?php

/**
 * This is view file for cpanel
 *
 * PHP version 5
 *
 * @category   JTrinityCore
 * @package    ViewsAdmin
 * @subpackage Cpanel
 */
// no direct access
defined('_JEXEC') or die('Restricted access');


//echo JText::_('COM_JTRINITYCORE_ABOUT_TEXT');

//display the paypal donation button
JTrinityCoreUtilities::displayDonate();

//$params = JComponentHelper::getParams( 'com_jtrinitycore' );
//$version = $params->get('version');

//$param=JComponentHelper::getParams('com_jtrinitycore');
//$version= $param->get('version');
//$comp=JComponentHelper::getComponent('com_jtrinitycore');

//$version=$comp->get('manifest')->attributes()->version;

$version="1.0.0";

?>

<br/>

<h1 class="componentcontent">JTrinityCore v<?php echo $version?> </h1>
<h2>Install instructions</h2>
<ol>
<li>Activate the "User - Trinity" plugin in Joomla plugin manager.</li>
<li>Configure JTrinityCore component in the Options panel.</li>
<li>Configure your Realms.</li>
<li>Add the JTrinityCore menu items to your menu.</li>
<li>You can integrate your favorite forum with <a href="http://www.jfusion.org">JFusion</a></li>

</ol>


<strong><a href='http://cosmowow.elementfx.com'>http://cosmowow.elementfx.com</a><br/><br/></strong>
Under GPL v2 license
