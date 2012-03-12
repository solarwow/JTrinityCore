<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modellist');
 
/**
 * JTrinityCore Model
 */
class JTrinityCoreModelBuyGold extends JModelList
{	
	
 
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
	
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('i.*');
		// From the hello table
		$query->from('#__jtc_gold as i');
		
	
	
		return $query;
	}
	
	public function getGoldInfo($id)
	{
		
		$query="SELECT * FROM #__jtc_gold where id=".$id;
		$this->_db->setQuery($query);
		
		return $this->_db->loadObject();	
		
		
	}
	
	/**
	 * Buy gold to a character
	 * @param unknown_type $gold Gold object
	 * @param unknown_type $realmid Realmid
	 * @param unknown_type $char  Character object
	 */
	public function buyGold($gold, $realmid, $char)
	{
		
		
		// Start transaction
		$this->_db->transactionStart();
		try
		{
			// Update user points
			$user=JFactory::getUser();
			$userid=$user->id;
			if (!JTrinityCoreUtilities::substractUserPoints($userid, $gold->cost, $this->_db))
			{
				$this->_db->transactionRollback();
				return false;
			}
			$description="Gold ".$gold->quantity;
			$donationtype=DONATIONTYPE_GOLD;
			// Update order table
			if (!JTrinityCoreUtilities::insertOrderTable($userid, $gold->id, $description, $gold->cost, $donationtype, $char->guid, $realmid, $this->_db))
			{
				$this->_db->transactionRollback();
				return false;
			}
			
			// Update Gold to character
			// Add gold to character
			// Get character DB
			$chardbname=JTrinityCoreUtilities::getCharacterDBName($realmid);
			$dbtc=JTrinityCoreDBHelper::getDB();
			$addmoney=$gold->quantity*10000;
			$sql="UPDATE ".$chardbname.".characters SET money=money+".$addmoney." WHERE guid=".$char->guid;
			$dbtc->setQuery($sql);
			if (!$dbtc->query())
			{
				$this->_db->transactionRollback();
				return false;
			}
					
			$this->_db->transactionCommit();
			return true;
		}
		catch (Exception $e)
		{
			JLog::add("Error buygold(): ".$e->getMessage(),JLog::ERROR);
			$this->_db->transactionRollback();
			return false;
		}
		
		
	}
}