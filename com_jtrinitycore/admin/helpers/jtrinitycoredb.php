<?php
// No direct access to this file
defined('_JEXEC') or die;
//jimport( 'joomla.database.database' );
/**
 * JrinityCoreDB component helper.
 */
 class JTrinityCoreDBHelper
{

	//static protected $dbo_world=array();
	//static protected $dbo_auth=null;
	//static protected $dbo_characters=array();
	static protected $db=null;
	
	
	/*
	 * Get database options
	 */
	protected static function getDBOptions($database_name='')
	{
		$params = JComponentHelper::getParams( 'com_jtrinitycore' );
		
		/*if (empty($database))
		 $databse=$params->get( 'database_auth' );*/
		
		$dbOptions = array (
				'driver' => $params->get( 'database_driver' ),  // mysql or mysqli
				//'host' => $params->get( 'database_host' ).':'.$params->get( 'database_port' ),
				'host' => $params->get( 'database_host' ),
				'port'=> $params->get( 'database_port' ),
				'user' => $params->get( 'database_user' ),
				'password' => $params->get( 'database_pwd' ),
				'database' => $database_name,
				'prefix' => '');
		
		return $dbOptions;
		
	}
	
	/**
	 * Get Auth database name from params
	 */
	public static function getAuthDBName()
	{
		$params = JComponentHelper::getParams( 'com_jtrinitycore');
		$database=$params->get( 'database_auth' );
		return $database;
	}
	
	
	
	/**
	 * Returns a object with the list of realms
	 */
	public static function getRealms()
	{
		
		
		//self::getAuthDB();
		
		$accdb=self::getAuthDBName();
		
		self::$db->setQuery("SELECT id , name FROM ".$accdb.".realmlist");
		$options = self::$db->loadObjectList();
		//$db=&self::$dbo_auth;
		//JError::raiseError(0, JText::sprintf('DB Name antes='.$db->getDatabase()."  Version=".$db->getVersion()."  connected=".$db->connected(), 'hola'));
		return $options;
	} 
	/**
	 * Return DB object
	 * Returns the $database object to trinity 
	 */
	public static function getDB()
	{
		
	
		if (!isset(self::$db))
		{
			$db= JDatabase::getInstance(self::getDBOptions());
			if ($db instanceof Exception)
			{
				jexit('Database Error: ' . (string) $db);
			}
			else self::$db=$db;
		}
	
		return self::$db;
	
	
	}
	
	/**
	 * Return World Database object
	 * Returns the $database passed or the default database from the params
	 */
	/*public static function getWorldDB($database=null)
	{
		if (!$database)
			$database=self::getWorldDBName();  // Default world database

		
		if (empty(self::$dbo_world) || empty(self::$dbo_world[$database])) 
		{
			$db= JDatabase::getInstance(self::getDBOptions($database));
			if ($db instanceof Exception)
			{				
				jexit('Database Error: ' . (string) $db);
			}
			
			
			self::$dbo_world[$database]=$db;
		}
		
		return self::$dbo_world[$database];
			
		
	}*/
	
	/**
	 * Get colour code from quality
	 */
	public static function getColourCode($quality)
	{
		$color = array (
				'0'=>'gray',
				'1'=>'white',
				'2'=>'green',
				'3'=>'blue',
				'4'=>'purple',
				'5'=>'orange',
				'6'=>'red',
				'7'=>'gold',
		);
		
		if ((int) $quality > 7)
			$color_code="gray";
		else
			$color_code=$color[$quality];
		
		return $color_code;
	}
	
	/**
	 * Get colour code from quality
	 */
	public static function getColourClassCode($quality)
	{
		$color = array (
				'0'=>'q0',
				'1'=>'q1',
				'2'=>'q2',
				'3'=>'q3',
				'4'=>'q4',
				'5'=>'q5',
				'6'=>'q6',
				'7'=>'q7',
		);
	
		if ((int) $quality > 7)
			$color_code="q0";
		else
			$color_code=$color[$quality];
	
		return $color_code;
	}
	
	
	
	/**
	 * Return Auth Database object
	 */
	/*public static function getAuthDB()
	{
		$database=self::getAuthDBName();
		if (!self::$dbo_auth) 
		{
			$db= JDatabase::getInstance(self::getDBOptions($database));
			if ($db instanceof Exception)
			{				
				jexit('Database Error: ' . (string) $db);
				
			}
						
			self::$dbo_auth=$db;
		}
		
		return self::$dbo_auth;
			
	
	}*/
	
	/**
	 * Return Auth Database object
	 */
	/*public static function getCharactersDB($database=null)
	{
		if (!$database)
			$database=self::getCharactersDBName();
		
		
		if (empty(self::$dbo_characters) || empty(self::$dbo_characters[$database])) 		{
			$db= JDatabase::getInstance(self::getDBOptions($database));
			if ($db instanceof Exception)
			{				
				jexit('Database Error: ' . (string) $db);
			}
			
			
			self::$dbo_characters[$database]=$db;
		}
		return self::$dbo_characters[$database];
			
	
	}*/
	
	/**
	 * Gets the wow head server link
	 */
	public static function getWowHeadLink()
	{
		
		$locale=JTrinityCoreUtilities::getLocale();
		$link="http://www.wowhead.com/";
		switch ($locale)
		{
			case 0:
				// English
				$link="http://en.wowhead.com/";
				break;
			case 1:
				break;
			case 2:
				// French
				$link="http://fr.wowhead.com/";
				break;
			case 3:
				// German
				$link="http://de.wowhead.com/";
				break;
			case 4:
				break;
			case 5:
				break;
			case 6:				
			case 7:
				// Spanish
				$link="http://es.wowhead.com/";
				break;
			case 8:
				// Russian
				$link="http://ru.wowhead.com/";
				break;
		}
	
		return $link;
	}
	
	
	
	/**
	 * Create the databases connection
	 */
	static public function createDatabases()
	{
		
		self::getDB();
	}
	
	
	
	/**
	 * Get Account data
	 */
	public static function getAccountData($username)
	{
		$accountdb=self::getAuthDBName();
		
			// Select the required fields from the table.
		$query="SELECT expansion, last_ip, last_login, locked, username ";
		$query.=" FROM ".$accountdb.".account ";
		$query.=" WHERE UPPER(username)=UPPER('". $username."')";
		//$query.=" WHERE username='". $username."'";
		
		
		$db=self::$db;
		$db->setQuery($query);		
		
			//if (!$acc_data = $db->loadRow())
			// Returns the first row
			if (!$acc_data = self::$db->loadObject())			
			{
				//JError::raiseError(500, implode('User '.$username.' not found in TC account.<br />'));
				echo 'FATAL ERROR: User '.$username.' not found in game database.<br />';
				return false;
			}
			
		
		return $acc_data;
	
	}
	
	/**
	 * Get expansion string
	 */
	public static function getExpansionString($expansionCode=0)
	{	
		
		switch ((int) $expansionCode) 
		{
			case 1:
				$expansion= 'The Burning Crusaide';
				break;
			case 2:
				$expansion= 'The Burning Crusaide';
				break;
			case 3:
				$expansion= 'Cataclysm';
				break;
			default:
				$expansion= 'You do not have an expantion set.';
		}
		
		
		
		return $expansion;
	}
	
	// Gets the account id of the current user
	public static function getAccId($username=null)
	{
		if (!$username)
		{
			$user=JFactory::getUser();
			$username=$user->username;
		}
		$accdb=self::getAuthDBName();
		$sql="SELECT id FROM ".$accdb.".account WHERE username='".$username."'";
		self::$db->setQuery($sql);
		
		
		if (!$id=self::$db->loadResult())
		{
			JLog::add("Error getAccId. sql=".$sql,JLog::ERROR);
			return -1;
		}
		
		return $id;
		
		
	
	}
	
	/**
	 * Returns a character info object
	 * @param int $realmid 
	 * @param int $guid
	 */
	public static function getCharacterInfo($realmid, $guid)
	{
		$chardb=JTrinityCoreUtilities::getCharacterDBName($realmid);
		$accid=JTrinityCoreDBHelper::getAccId();
	
		$sql="SELECT * FROM ".$chardb.".characters  WHERE account=".$accid." AND guid=".$guid;
	
		$db=JTrinityCoreDBHelper::getDB();
		$db->setQuery($sql);
	
		return $db->loadObject();
	
	}
	
	public static function getWowGroups()
	{
		$group = array(
				array(
						'id' => '0',
						'name' => 'Wow User'
				),
				array(
						'id' => '1',
						'name' => 'Wow Game Moderator'
				),
				array(
						'id' => '2',
						'name' => 'Wow Game Master'
				),
				array(
						'id' => '3',
						'name' => 'Wow Administrator'
				),
				array(
						'id' => '4',
						'name' => 'Wow Console user'
				)
		);
		
		return $group;
	}
	
}
JTrinityCoreDBHelper::createDatabases();
