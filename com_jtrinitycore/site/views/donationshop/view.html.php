<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class
 */
class JTrinityCoreViewDonationShop extends JView
{
	protected $user_points=0;
	protected $cost;
	
	
	protected function getUserData()
	{
		$this->user_points=JTrinityCoreUtilities::getPoints();
		$id=JRequest::getVar('productid',0);
		if (JRequest::getVar('donationtype')==DONATIONTYPE_ITEM)
		{
			$this->cost=JTrinityCoreUtilities::getItemCost($id);
		}
		if (JRequest::getVar('donationtype')==DONATIONTYPE_POWERLEVELING)
		{
			$this->cost=JTrinityCoreUtilities::getPowerlevelingCost($id);
		}
		
		if ($this->cost < 0)
			$this->setError('Not cost found for id='.$id);
		
	}
	
	
	
	public function buyPowerleveling($productid, $realmid, $characterid)
	{
		$model=$this->getModel();
		$character=$model->getCharacterInfo($realmid, $characterid);
		$pl=$model->getPowerlevelingInfo($productid);
		
		if ($character->level<$pl->minLevel)
		{
			// The character does not have the minimum level to apply the powerleveling
			echo "<strong>".JText::_( 'COM_JTRINITYCORE_CHARACTER_NOMINLEVEL' )."</strong><br/>";
			return false;
		}
		
		
		// Buy powerleveling
		if (!$model->buyPowerLeveling($character,$pl, $realmid))
		{
			echo "<strong>Error updating database. Contact administrator.</strong><br/>";
			JTrinityCoreUtilities::ShowUserPoints(false);
			return false;
		}
		
		
		// Show custom message ok
		print JText::sprintf('COM_JTRINITYCORE_BUYPOWERLEVELING_OK',$character->name,$pl->maxLevel);
		
		return true;
	
	}
	
	public function buyItem($productid, $realmid, $characterid)
	{
		
		// Send the item to the character mailbox
		$model=$this->getModel();
		$character=$model->getCharacterInfo($realmid, $characterid);
		$item=$model->getItemInfo($productid);
	    if (!$model->sendItem($item, $realmid, $character))
	    {
	    	echo "<strong>Error sending item to character. Contact administrator.</strong><br/><br/>";
	    	JTrinityCoreUtilities::ShowUserPoints(false);
	    	return false;
	    }
	    
	    // Show custom message ok
	    print JText::sprintf('COM_JTRINITYCORE_BUYITEM_OK',$item->name, $character->name);
		
	}
	
	// Overwriting JView display method
	public function display($tpl = null) 
	{
		// Assign data to the view
		$layout=JRequest::getVar('layout');
		if ($layout=="selectcharacter")
		{
			$this->getUserData();
			$app=JFactory::getApplication();
			$app->setUserState("productid", JRequest::getVar("productid"));
			$app->setUserState("donationtype", JRequest::getVar("donationtype"));			
		}
		
		 
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
