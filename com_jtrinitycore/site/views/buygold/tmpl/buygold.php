<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JRequest::checkToken() or die( 'Invalid Token' );

// Get gold info
$model=$this->getModel();
$gold=$model->getGoldInfo(JRequest::getVar('gold'));
$characterid=JRequest::getVar('characterid');
$realmid=JRequest::getVar('realmid');

// Check if user has enough points
$userpoints= JTrinityCoreUtilities::getPoints();

if ($userpoints < $gold->cost )
{
	echo JText::_('COM_JTRINITYCORE_NOT_ENOUGH_POINTS');
	return;
}
$char=JTrinityCoreDBHelper::getCharacterInfo($realmid, $characterid);
if ($model->buyGold($gold, $realmid, $char)){
	
	echo JText::sprintf('COM_JTRINITYCORE_BUYGOLD_OK', $char->name, (int) floor($char->money/10000)+$gold->quantity);
}
else
{
	echo JText::_('COM_JTRINITYCORE_BUYGOLD_ERROR');
}





