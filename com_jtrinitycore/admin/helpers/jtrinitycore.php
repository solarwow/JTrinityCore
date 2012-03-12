<?php
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * JrinityCore component helper.
 */
abstract class JTrinityCoreHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($submenu) 
	{
		JSubMenuHelper::addEntry(JText::_('COM_JTRINITYCORE_SUBMENU_ITEMS'),
		                         'index.php?option=com_jtrinitycore&view=items', $submenu == 'items');
		JSubMenuHelper::addEntry(JText::_('COM_JTRINITYCORE_SUBMENU_ITEMS_CATEGORIES'),
		                         'index.php?option=com_categories&view=categories&extension=com_jtrinitycore',
		                         $submenu == 'categories');
		// set some global property
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-48-jtrinitycore ' .
		                               '{background-image: url(../media/com_jtrinitycore/images/jtrinitycore48x48.png);}');
		if ($submenu == 'categories') 
		{
			$document->setTitle(JText::_('COM_JTRINITYCORE_ADMINISTRATION_CATEGORIES'));
		}
	}
	
	/**
	 * Get the actions
	 */
	public static function getActions($messageId = 0)
	{
		jimport('joomla.access.access');
		$user	= JFactory::getUser();
		$result	= new JObject;
	
		if (empty($messageId)) {
			$assetName = 'com_jtrinitycore';
		}
		else {
			$assetName = 'com_jtrinitycore.item.'.(int) $messageId;
		}
	
		$actions = JAccess::getActions('com_jtrinitycore', 'component');
	
		foreach ($actions as $action) {
			$result->set($action->name, $user->authorise($action->name, $assetName));
		}
	
		return $result;
	}
}