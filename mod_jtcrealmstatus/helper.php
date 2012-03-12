<?php
/**
 * Helper class for Hello World! module
 * 
 * @package    Joomla.Tutorials
 * @subpackage Modules
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:modules/
 * @license        GNU/GPL, see LICENSE.php
 * mod_helloworld is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

//jimport( 'joomla.application.component.helper' );
class modJtcRealmStatusHelper
{
	 protected $params;
	 protected $db;
	
	 function __construct()
	{
		
		$this->params=JComponentHelper::getParams('com_jtrinitycore');
		$this->db=JFactory::getDbo();
		
	}
        
     public function getIPDatabase()
    {
        return $this->params->get('database_host');
    }
    
     public function getPortDatabase()
    {
    	return $this->params->get('database_port');
    }
    
     public function getUserDatabase()
    {
    	return $this->params->get('database_user');
    }
    
     public function getPasswordDatabase()
    {
    	return $this->params->get('database_pwd');
    }
     public function getDBNameAuth()
    {
    	return $this->params->get('database_auth');
    }
     public function getAuthServerPort()
    {
    	return $this->params->get('auth_server_port');
    }
    
     public function getServerIP()
    {
    	return $this->params->get('serverip');
    }
    public function getSetRealmlist()
    {
    	return $this->params->get('setrealm');
    }
    
    public function getRealms()
    {
    	$query = $this->db->getQuery(true);
    	// Select some fields
    	$query->select('i.*');
    	// From the hello table
    	$query->from('#__jtc_realms as i');
    	
    	$this->db->setQuery($query);
    	return $this->db->loadObjectList();    	
    	
    }
    
   
    
    public function getOnlinePlayers($charactersdb)
    {
    	
    
    	$db=JTrinityCoreDBHelper::getDB();
    	
    	$query="SELECT COUNT(*) FROM ".$charactersdb.".characters WHERE online=1";
    	$db->setQuery($query);
    	if (!$num = $db->loadResult())
    	{
    		$num=0;
    	}
    	return $num;
    }
    
    /**
     * Convert number of seconds into hours, minutes and seconds
     * and return an array containing those values
     *
     * @param integer $seconds Number of seconds to parse
     * @return array
     */
    protected function secondsToTime($seconds)
    {
    	
    	// days
    	$days=round(( $seconds / 86400),2);
    	
    	// extract hours
    	$hours = floor($seconds / (60 * 60));
    
    	// extract minutes
    	$divisor_for_minutes = $seconds % (60 * 60);
    	$minutes = floor($divisor_for_minutes / 60);
    
    	// extract the remaining seconds
    	$divisor_for_seconds = $divisor_for_minutes % 60;
    	$seconds = ceil($divisor_for_seconds);
    
    	// return the final array
    	$obj = array(
    			"d" => (int) $days,
    			"h" => (int) $hours,
    			"m" => (int) $minutes,
    			"s" => (int) $seconds,
    	);
    	return $obj;
    }
    
    public function getUptimeServer($realmid)
    {
    	
    	$db=JTrinityCoreDBHelper::getDB();
    	$accdb=JTrinityCoreDBHelper::getAuthDBName();
    	
    	$query="SELECT uptime FROM ".$accdb.".uptime WHERE realmid=".$realmid." ORDER BY starttime DESC LIMIT 1";
    	$db->setQuery($query);
    	if (!$uptime_res = $db->loadResult())
    	{
    		$uptime='0';
    	}
    	else 
    	{
    		$obj=$this->secondsToTime($uptime_res);
    		$uptime='';
    		if ($obj['d']>0)
    			$uptime=$obj['d'].JText::_('COM_JTRINITYCORE_DAYS');
    		if ($obj['h']>0)
    			$uptime.=' '.$obj['h'].JText::_('COM_JTRINITYCORE_HOURS');
    		if ($obj['m']>0)
    			$uptime.=' '.$obj['m'].JText::_('COM_JTRINITYCORE_MINS');
    		
    	}
    	return $uptime;
    	
    }
}
?>
