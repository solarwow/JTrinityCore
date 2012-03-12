<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modellist');

/**
 * JTrinityCore Model
 */
class JTrinityCoreModelDonationShop extends JModel
{

	/**
	 * Get the characters of the user_name in the realm_id
	 * @param int $realm_id
	 * @param int $user_name
	 */
	public function getCharacters($realm_id, $username=null)
	{
		if ($realm_id==0)
			return;

		if (!$username)
		{
			$user =JFactory::getUser();
			$username=$user->username;
		}

		// Get accountid if from username
		$dbo=JTrinityCoreDBHelper::getDB();
		$accdb=JTrinityCoreDBHelper::getAuthDBName();
		$query="SELECT id FROM ".$accdb.".account WHERE UPPER(username)=UPPER('".$username ."')";
		$dbo->setQuery($query);
		$accid=$dbo->loadResult();

		
		// Get Character DB name
		$database=JTrinityCoreUtilities::getCharacterDBName($realm_id);

		// open the characters db
		
		$query="SELECT guid, name, level, money FROM ".$database.".characters where account=".$accid;
		$dbo->setQuery($query);

		return $dbo->loadObjectList();
	}

	

	

	public function getCharacterInfo($realmid, $characterid)
	{
		// Get Character DB name
		$database=JTrinityCoreUtilities::getCharacterDBName($realmid);

		// open the characters db
		$cdb=JTrinityCoreDBHelper::getDB();
		$query="SELECT guid, name, level, money, race, class, gender FROM ".$database.".characters where guid=".$characterid;
		$cdb->setQuery($query);

		return $cdb->loadObject();
	}



	public function getItemInfo($productid)
	{
		
		$query="SELECT * FROM #__jtc_items where id=".$productid;
		$this->_db->setQuery($query);
		
		return $this->_db->loadObject();
		
		
		
	}

	public function getPowerlevelingInfo($id)
	{
		// open the characters db
		$query="SELECT id, minLevel, maxLevel, cost FROM #__jtc_powerleveling where id=".$id;
		$this->_db->setQuery($query);

		return $this->_db->loadObject();
	}

	public function getCharacterLevel($realmid, $characterid)
	{
		$character=$this->getCharacterInfo($realmid, $characterid);
		return $character->level;
	}


	

	

	public function buyPowerleveling($character, $pl, $realmid)
	{
		// Update the character level
		$chardbname=JTrinityCoreUtilities::getCharacterDBName($realmid);
		$dbo=JTrinityCoreDBHelper::getDB();
		$sql="UPDATE ".$chardbname.".characters SET level=".$pl->maxLevel." WHERE guid=".$character->guid;
		$dbo->setQuery($sql);
		if (!$dbo->query())
		{
			JLog::add("Error updating characters db. SQL=".$sql,JLog::ERROR,'donationshop->buyPowerleveling()');
			return false;
		}
		
		// Insert into the order table
		$user =JFactory::getUser();			
		$description="Powerleveling ".$pl->minLevel."-".$pl->maxLevel;
		$productid=$pl->id;
		$cost=$pl->cost;
		$donationtype=DONATIONTYPE_POWERLEVELING;
		$userid=$user->id;
		if (!JTrinityCoreUtilities::insertOrderTable($userid, $productid, $description, $cost, $donationtype, $character->guid, $realmid))
			return false;
			
		// Update the new points to the user
		if (!JTrinityCoreUtilities::substractUserPoints($user->id, $pl->cost))
			return false;


		return true;
	}
	
	protected function getMaxDurability($itemid, $realmid)
	{
		
		$worlddbname=JTrinityCoreUtilities::getWorldDBName($realmid);
		$dbo=JTrinityCoreDBHelper::getDB();
		$sql="SELECT maxDurability FROM ".$worlddbname.".item_template WHERE entry=".$itemid;
		$dbo->setQuery($sql);
		$max=$dbo->loadResult();
		if (!$max) $max=0;
		
		return $max;
	}


	/**
	 * Send the item purchased to the mailbox character
	 * @param unknown_type $item  item object from joomla database
	 * @param unknown_type $realmid the realm of the character
	 * @param unknown_type $character character object
	 */
	public function sendItem($item, $realmid, $character)
	{
		// Get character DB
		$chardbname=JTrinityCoreUtilities::getCharacterDBName($realmid);
		$dbo=JTrinityCoreDBHelper::getDB();
		$characterid=$character->guid;
		$itemid=$item->itemid;

		//JLog::add("characterid=".$characterid."   productid=".$productid."   realmid=".$realmid." item name=".$item->name);

		// Get the mail id to insert
		// Start transaction
		$dbo->transactionStart();

		try
		{
			$ok=true;
			$sql="SELECT MAX(id) FROM ".$chardbname.".mail";
			$dbo->setQuery($sql);
			$id=$dbo->loadResult();
			if (!$id) $id=0;
			$id=$id+1;
	
			
			$mail=new stdClass();
			$mail->id=$id;
			$mail->messageType=5;
			$mail->stationery=41;
			$mail->sender=0; // Should  be the admin GM
			$mail->receiver=$characterid;
			$mail->has_items=1;
			$mail->subject=JText::_('COM_JTRINITYCORE_MAIL_ITEM_SUBJECT');
			$mail->body=JText::sprintf('COM_JTRINITYCORE_MAIL_ITEM_BODY',$character->name, $item->name);
			
								
			// Insert into mail table
			if ($dbo->insertObject($chardbname.'.mail',$mail,'id'))
			{
				// Insert into item instance table
				$sql="SELECT MAX(guid) FROM ".$chardbname.".item_instance";
				$dbo->setQuery($sql);
				$iteminstanceid=$dbo->loadResult();
				if (!$iteminstanceid) $iteminstanceid=0;
				
				
				
				$iteminstanceid=$iteminstanceid+1;
				$item_instance=new stdClass();
				$item_instance->guid=$iteminstanceid;
				$item_instance->itemEntry=$item->itemid;
				$item_instance->owner_guid=$characterid;
				$item_instance->durability=$this->getMaxDurability($item->itemid, $relmid); // $item->maxdurability;
				
				if ($dbo->insertObject($chardbname.'.item_instance',$item_instance,'guid'))
				{				
					// Insert into mail_items table
					$mail_item=new stdClass();
					$mail_item->mail_id=$id;
					$mail_item->item_guid=$iteminstanceid;
					$mail_item->receiver=$characterid;
					if (!$dbo->insertObject($chardbname.'.mail_items',$mail_item))
					{
						$ok=false;
						JLog::add("sendItem(): Error inserting item_instance. ",JLog::ERROR,'donationshop');
					}
				}
				else $ok=false;
				
			
				
			}
			else {
				$ok=false;
				JLog::add("sendItem(): Error inserting table mail. ",JLog::ERROR,'donationshop');
			}			
			
				
			if (!$ok)		{
				$dbo->transactionRollback();
				return false;
			}	
				
			
			$dbo->transactionCommit();
			
			 
			$user =JFactory::getUser();
			$cost=$item->cost;
			
			// Update the new points to the user
			if (!JTrinityCoreUtilities::substractUserPoints($user->id, $cost))
				return false;		
			
			// Insert into the order table
			$description=$item->name." (Level=".$item->itemlevel.")";				
			$donationtype=DONATIONTYPE_ITEM;
			$userid=$user->id;
			
			if (!JTrinityCoreUtilities::insertOrderTable($userid, $item->id, $description, $cost, $donationtype,$characterid, $realmid))
				return false;	
			
			return true;
		}
		catch (Exception $e)
		{
			JLog::add("Error: ".$e->getMessage(),JLog::ERROR,"donationhop->sendItem");
			$dbo->transactionRollback();
			return false;
		}



	}
}
