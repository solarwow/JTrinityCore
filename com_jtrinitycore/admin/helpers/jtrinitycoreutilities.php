<?php

/**
 * Model for all jtrinitycore related function
*
* PHP version 5
*
* @category  JTrinityCore
* @package   Helpers

*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Class for general JTrinityCore functions
 *
 * @category  JTrinityCore
 * @package   Helpers
**/
class JTrinityCoreUtilities
{
/**
 * Raise warning function that can handle arrays
 *
 * @return string display donate information
 */
public static function displayDonate()
{
	?>
<table class="adminform"><tr>
<td><img src="../media/com_jtrinitycore/images/logo_small.png"></td>
<td style="width: 90%;"><font size="3"><b><?php echo JText::_('COM_JTRINITYCORE_DONATION_MESSAGE'); ?></b></font></td>
<td style="width: 10%; text-align: right;">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="2V8TYZPAXWZHE">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif"  name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/es_ES/i/scr/pixel.gif" width="1" height="1">
</form>


</td></tr></table>
<?php
}


public function getAdminComponentPath()
{
	return JURI::base().'component'.DS.JApplicationHelper::getComponentName().DS;
}

/**
 * Returns the currency simbol for a given currency
 * @param string  $currency
 */
public static function getCurrencySymbol($currency)
{
	
	switch ($currency)
	{
		case "EUR":
			$symbol="€";
			break;
		case "USD":
			$symbol="$";
			break;
		case "GBP":
			$symbol="£";
			break;
		default:
			$symbol="€";
			
	}
	return $symbol;
	}
	
	/**
	 * Get the currency from params
	 */
	public static function getCurrency()
	{
		$params = JComponentHelper::getParams( 'com_jtrinitycore');
		$currency=$params->get( 'currency' );
		return $currency;
	}
	
	/**
	 * Get locale from params
	 */
	public static function getLocale()
	{
		$params = JComponentHelper::getParams( 'com_jtrinitycore');
		$locale=$params->get( 'locale' );
		return $locale;
	}
	
	/**
	 * Get the current date time in mysql format
	 */
	public static function getCurrentDatetime()
	{
			
		//return date("Y-m-d H:i:s");
		$date=JFactory::getDate();
		
		return $date->toSql();
		//return $date->toFormat();
		
	}
	
	/**
	 * Get Remote IP address
	 */
	public static function getRemoteIP()
	{
		
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$_SERVER['REMOTE_ADDR']=$_SERVER['HTTP_X_FORWARDED_FOR'];
			} 
			elseif (isset($_SERVER['HTTP_X_REAL_IP'])) {
				$_SERVER['REMOTE_ADDR']=$_SERVER['HTTP_X_REAL_IP'];
			}
			return $_SERVER['REMOTE_ADDR'];
		
	}
	
	/**
	 * Check is user is logged
	 */
	public static function CheckUserLogged()
	{
		// Check if user logged
		$user =JFactory::getUser();
		if(!$user->id)
		{
			//do user logged off  stuff
			die('Restricted access');
		
		}
	}
	
	/**
	* Get the user points
	* @return int get current User points
	*/
	public static  function getPoints()
	{
	
	
		$user =JFactory::getUser();
		$user_id = $user->id;
		$db=JFactory::getDbo();
		$db->setQuery($db->getQuery(true)
				->from('#__jtc_userpoints ')
				->select('points')
				->where('userid=' . $user_id));
	
		//JError::raiseError(500, "query=".$this->_db->getQuery());
		if (!$row = $db->loadObject())
		{
			//$this->setError($this->_db->getError());
			// If its empty inserts new one
			/*$userpoints = new stdClass;
			 $userpoints->id = NULL;
			$userpoints->userid = $user_id;
			$userpoints->points = "0.0";
			$userpoints->active=true;
			$userpoints->lastdate=JTrinityCoreUtilities::getCurrentDatetime();*/
			//JError::raiseError(500, "active=".$userpoints->active."    userpoints.lastdate=".$userpoints->lastdate);
			$query="INSERT INTO #__jtc_userpoints (userid,points,active,lastdate) ";
			$query.="VALUES (".$user_id.", 0.0, 1, '".JTrinityCoreUtilities::getCurrentDatetime() ."') ";
			$db->setQuery($query);
			$db->query();
	
			$points=0.0;
	
	
			/*if (!$database->insertObject( '#__jtc_userpoints', $userpoints, 'id' )) {
			 $this->setError($this->_db->getError());
			JError::raiseError(500, "error=".$this->_db->getError());
			}*/
		}
		else
			$points=$row->points;
	
	
		return $points;
	}
	
	/**
	 * Get the item cost
	 */
	public static function getItemCost($id)
	{
		$db=JFactory::getDbo();
		$db->setQuery($db->getQuery(true)
				->from('#__jtc_items ')
				->select('cost')
				->where('id=' . $id));
		
		if (!$cost = $db->loadResult())
		{
			$cost=-1;
		}
		return $cost;
	} 
	
	/**
	 * Get powerleveling cost
	 */
	public static function getPowerlevelingCost($id)
	{
		$db=JFactory::getDbo();
		$db->setQuery($db->getQuery(true)
				->from('#__jtc_powerleveling ')
				->select('cost')
				->where('id=' . $id));
		
		if (!$cost = $db->loadResult())
		{
			$cost=-1;
		}
		return $cost;
	}
		
	
	/**
	 * Show user points.
	 * @return The current user points
	 */
	public static function ShowUserPoints($showCost=true)
	{
		$points=self::getPoints();
		
		
		$html='<h5>'.JText::_('COM_JTRINITYCORE_YOU_HAVE').' '.$points.' '
		. JText::_('COM_JTRINITYCORE_POINTS').'<br/><br/>';
		
		
		if ($showCost) 
		{
			$currency_symbol=self::getCurrencySymbol(self::getCurrency());
			$html.=JText::_('COM_JTRINITYCORE_POINT_COST').$currency_symbol;
		}
		
		$html.= '</h5>';
		
		echo $html;
		
		return $points;
	}
	
	/**
	 * Get ordertype text
	 */
	public static function getOrderTypeText($ordertype)
	{
		
		switch ((int) $ordertype)
		{
			case DONATIONTYPE_ITEM:
				$str= JText::_('COM_JTRINITYCORE_ITEM');
				break;
			case DONATIONTYPE_POWERLEVELING:
				$str=JText::_('COM_JTRINITYCORE_POWERLEVELING');
				break;
			case DONATIONTYPE_GOLD:
				$str=JText::_('COM_JTRINITYCORE_GOLD');
				break;
			default:
				$str="N/A";				
		}
		
		return $str;
	}
	
	public static function getRealmsOptionHTML($showgold=null)
	{
		$sql="SELECT realmid, realmname FROM #__jtc_realms";
		$db=JFactory::getDbo();
		$db->setQuery($sql);
		if (!empty($showgold))
			echo '<select name="realmid" id="realmid" onchange="ajxGetCharacters(this.value,1);">';
		else echo '<select name="realmid" id="realmid" onchange="ajxGetCharacters(this.value);">';
		echo '<option  value="0">'.JText::_( 'COM_JTRINITYCORE_SELECTREALM' ).'</option>';
		$results = $db->loadObjectList();
		foreach($results as $row) {
			echo '<option   value="'.$row->realmid.'">'.JText::_($row->realmname);
			echo "</option>";
		}
		echo "</select>";
	}
	
	public static function getCharacterDBName($realm_id)
	{
		$db=JFactory::getDbo();
		$db->setQuery("SELECT charactersdb FROM #__jtc_realms WHERE realmid=".$realm_id);
		$database=$db->loadResult();
		return $database;
	}
	
	public static function getWorldDBName($realm_id)
	{
		$db=JFactory::getDbo();
		$db->setQuery("SELECT worlddb FROM #__jtc_realms WHERE realmid=".$realm_id);
		$database=$db->loadResult();
		return $database;
	}
	
	
	
	public static function insertOrderTable($userid, $productid, $description, $cost, $donationtype, $charid=null, $realmid=null, $db=null)
	{
		// Insert the orders table
		$order=new stdClass();
		$order->id=NULL;
		$order->userid=$userid;
		$order->description=$description;
		$order->productid=$productid;
		$order->points=$cost;
		if ($charid)
			$order->charid=$charid;
		if ($realmid)
			$order->realmid=$realmid;
		
		$order->ordertype=$donationtype;
		$order->orderdate=JTrinityCoreUtilities::getCurrentDatetime();
		if (!$db)
			$db=JFactory::getDbo();
		if (!$db->insertObject('#__jtc_orders',$order,'id'))
		{
			JLog::add("insertOrderTable(): Error inserting jtc_orders. Userid=".$userid." producti=".$productid,JLog::ERROR);
			return false;
		}
		
	
		return true;
	
	}
	
	public static function addUserPoints($userid, $points)
	{
	
		$sql="UPDATE #__jtc_userpoints SET points=(points+".$points."), lastdate=NOW() WHERE userid=".$userid;
		$db=JFactory::getDbo();
		$db->setQuery($sql);
		if (!$db->query())
		{
			JLog::add("addUserPoints(): Error updating userpoints table. SQL=".$sql." UserId=".$userid,JLog::ERROR);
			return false;
		}
	
		return true;
	}
	
	public static function substractUserPoints($userid, $points, $db=null)
	{
	
		$sql="UPDATE #__jtc_userpoints SET points=(points-".$points."), lastdate=NOW() WHERE userid=".$userid;
		if (!$db)
			$db=JFactory::getDbo();
		$db->setQuery($sql);
		if (!$db->query())
		{
			JLog::add("substractUserPoints(): Error updating userpoints table. SQL=".$sql." UserId=".$userid,JLog::ERROR);
			return false;
		}
	
		return true;
	}
		
		

}