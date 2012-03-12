<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JRequest::checkToken() or die( 'Invalid Token' );

if ($this->unstuck(JRequest::getVar('realmid'), JRequest::getVar('characterid')))
{
	echo JText::_('COM_JTRINITYCORE_UNSTUCK_OK');
}
else
{
	echo JText::_('COM_JTRINITYCORE_UNSTUCK_ERROR');
}
