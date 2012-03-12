<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JRequest::checkToken() or die( JText::_( 'Invalid Token' ) );


$app=JFactory::getApplication();
$productid=$app->getUserState("productid");
$donationtype=$app->getUserState("donationtype");
$realmid=JRequest::getVar("realmid");
$characterid=JRequest::getVar("characterid");

if ($donationtype==DONATIONTYPE_POWERLEVELING)
{
	if (!$this->buyPowerleveling($productid, $realmid, $characterid))
		return false;	
}
elseif ($donationtype==DONATIONTYPE_ITEM)
{
	if (!$this->buyItem($productid, $realmid, $characterid))
		return false;
}
else 
	die("Wrong donationtype");

// show user points
JTrinityCoreUtilities::ShowUserPoints(false);

?>

