<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modellist');

/**
 * JTrinityCore Model
 */
class JTrinityCoreModelBuypoints extends JModel
{

	public function addUserPoints($userid, $points)
	{

		$sql="UPDATE #__jtc_userpoints SET points=(points+".$points."), lastdate=NOW() WHERE userid=".$userid;
		$this->_db->setQuery($sql);
		if (!$this->_db->query())
		{
			JLog::add("buypoints::updateUserPoints(): Error updating userpoints table. Cost=".$cost." UserId=".$userid,JLog::ERROR);
			return false;
		}

		return true;
	}

	
	public function insertDonation($userid, $amount, $paypal_txn_id, $completed=true)
	{
		// Insert the orders table
		$order=new stdClass();
		$order->id=NULL;
		$order->userid=$userid;		
		$order->amount=$amount;
		$order->completed=($completed?1:0);
		$order->paypal_txn_id=$paypal_txn_id;
		$order->donationdate=JTrinityCoreUtilities::getCurrentDatetime();
		if (!$this->_db->insertObject('#__jtc_donations',$order,'id'))
		{
			JLog::add("insertDonation(): Error inserting jtc_donations. userid=".$userid."  points=".$points,JLog::ERROR);
			return false;
		}
		
		return true;
		
	}

	


}
