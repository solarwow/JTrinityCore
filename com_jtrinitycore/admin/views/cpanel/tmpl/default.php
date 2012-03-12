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


//display the paypal donation button
JTrinityCoreUtilities::displayDonate();

?>
<table class="adminform"><tr><td width="55%" valign="top">

<div id="cpanel">
   
    <div style="float:left;">
            <div class="icon">
                <a href="index.php?option=com_jtrinitycore&view=items" >
                <img src="../media/com_jtrinitycore/images/items.png" height="50px" width="50px">
                <span><?php echo JText::_('COM_JTRINITYCORE_ITEMS'); ?></span>
                </a>
            </div>
    </div>
    <div style="float:left;">
            <div class="icon">
                <a href="index.php?option=com_jtrinitycore&view=powerlevelings" >
                <img src="../media/com_jtrinitycore/images/powerleveling.gif" height="50px" width="50px">
                <span><?php echo JText::_('COM_JTRINITYCORE_POWERLEVELING'); ?></span>
                </a>
            </div>
    </div>
    <div style="float:left;">
            <div class="icon">
                <a href="index.php?option=com_jtrinitycore&view=golds" >
                <img src="../media/com_jtrinitycore/images/buygold.png" height="50px" width="50px">
                <span><?php echo JText::_('COM_JTRINITYCORE_GOLD'); ?></span>
                </a>
            </div>
    </div>
    <div style="float:left;">
            <div class="icon">
                <a href="index.php?option=com_jtrinitycore&view=realms" >
                <img src="../media/com_jtrinitycore/images/rolerealms.png" height="50px" width="50px">
                <span><?php echo JText::_('COM_JTRINITYCORE_REALMS'); ?></span>
                </a>
            </div>
    </div>
    <div style="float:left;">
            <div class="icon">
                <a href="index.php?option=com_jtrinitycore&view=orders" >
                <img src="../media/com_jtrinitycore/images/orders.png" height="50px" width="50px">
                <span><?php echo JText::_('COM_JTRINITYCORE_ORDERS'); ?></span>
                </a>
            </div>
    </div>
    
    <div style="float:left;">
            <div class="icon">
                <a href="index.php?option=com_jtrinitycore&view=donations" >
                <img src="../media/com_jtrinitycore/images/star.png" height="50px" width="50px">
                <span><?php echo JText::_('COM_JTRINITYCORE_DONATIONS'); ?></span>
                </a>
            </div>
    </div>
    <div style="float:left;">
            <div class="icon">
                <a href="index.php?option=com_jtrinitycore&view=userpoints" >
                <img src="../media/com_jtrinitycore/images/chars.png" height="50px" width="50px">
                <span><?php echo JText::_('COM_JTRINITYCORE_USERPOINTS'); ?></span>
                </a>
            </div>
    </div>
    <div style="float:left;">
            <div class="icon">
                <a href="index.php?option=com_jtrinitycore&view=about" >
                <img src="../media/com_jtrinitycore/images/about.png" height="50px" width="50px">
                <span><?php echo JText::_('COM_JTRINITYCORE_ABOUT'); ?></span>
                </a>
            </div>
    </div>




</div>

<td width="45%" valign="top">

<?php

// Check if TC server is online
//$isonline = JTrinityCoreUtilities::isServerOnline();

/*if ($isonline) {
    ?>
    <table bgcolor="#d9f9e2" width ="100%"><tr><td width="50px"><td>
    <img src="components/com_jtrinitycore/images/online.png" height="30px" width="30px">
    <td><h2><?php echo JText::_('SERVER_ONLINE'); ?></h2></td><td></td></tr></table>
    <?php
} else {
    ?>
    <table bgcolor="#f9ded9" width ="100%"><tr><td width="50px"><td>
    <img src="components/com_jtrinitycore/images/offline.png" height="30px" width="30px">
    <td><h2><?php echo JText::_('SERVER_OFFLINE'); ?></h2></td><td></td></tr></table>
    <?php
}*/

?>
</td></tr></table>