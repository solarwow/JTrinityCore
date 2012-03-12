<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');

 
/**
 * JTrinityCore Component Controller
 */
class JTrinityCoreController extends JController
{
	
	function listcharacters()
	{	
		$realm_id=JRequest::getVar( 'realm_id');
		$user =JFactory::getUser();
		$username=$user->username;
		$model = $this->getModel('DonationShop','JTrinityCoreModel');
		$characters = $model->getCharacters($realm_id, $username);
	
		$showgold=JRequest::getVar('showgold');
		
		if (!empty($showgold) && $showgold==1)
			$showgold=true;
		else
			$showgold=false;
		
		$return = "<?xml version=\"1.0\" encoding=\"utf8\" ?>";
		$return .= "<options>";
		$return .= "<option  id='0'>".JText::_( 'COM_JTRINITYCORE_SELECTCHARACTER' )."</option>";
		if(is_array($characters)) {
			foreach ($characters as $character) {
				if ($showgold)
					$goldstring=" - ".JText::_('COM_JTRINITYCORE_CHARACTER_GOLD')." ".floor(($character->money)/10000);
				else
					$goldstring="";
		
				$return .="<option id='".$character->guid."'>".JText::_($character->name)." - ".JText::_('COM_JTRINITYCORE_CHARACTER_LEVEL')." ".$character->level.$goldstring."</option>";
			}
		}
		$return .= "</options>";
		echo $return;
		
		
	
	
	}
	
	
	
}
