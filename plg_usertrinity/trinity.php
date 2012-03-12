<?php
/**
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die('Not direct access here.');

require_once( JPATH_SITE . DS . 'administrator' . DS . 'components' . DS . 'com_jtrinitycore'.DS.'helpers'.DS.'jtrinitycoredb.php' );
jimport('joomla.user.helper');

/**
 * Example User Plugin
 *
 * @package		Joomla.Plugin
 * @subpackage	User.example
 * @since		1.5
 */
class plgUserTrinity extends JPlugin
{
	protected $logcat='plg_usertrinity';
	protected $dbaccount;
	//protected $dbcharacters;
	
	
	public function __construct(& $subject, $config)
	{
		
		// Set log
		$date = JFactory::getDate()->format('Y-m-d');
		$options['format'] = '{DATE}\t {TIME} \t{LEVEL} \t{CODE} \t{MESSAGE}';
		$options['text_file'] = 'plg_usertrinity.'.$date.'.php';
		JLog::addLogger($options, JLog::ALL,$this->logcat);
		
		$this->dbaccount=JTrinityCoreDBHelper::getAuthDBName();
		//$this->dbcharacters=JTrinityCoreDBHelper::getCharactersDBName();
		
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	/**
	 * Example store user method
	 *
	 * Method is called before user data is stored in the database
	 *
	 * @param	array		$user	Holds the old user data.
	 * @param	boolean		$isnew	True if a new user is stored.
	 * @param	array		$new	Holds the new user data.
	 *
	 * @return	void
	 * @since	1.6
	 * @throws	Exception on error.
	 */
	public function onUserBeforeSave($user, $isnew, $new)
	{
		$app = JFactory::getApplication();

		// throw new Exception('Some error occurred. Please do not save me');
	}

	protected function createUser($userinfo)
	{
		$user = new stdClass;
		$user->id = null;
		$user->username = strtoupper($userinfo['username']);
		$user->email = $userinfo['email'];
				
		$user->sha_pass_hash = sha1(strtoupper($userinfo['username']) . ':' . strtoupper($userinfo['password_clear']));
		$user->joindate = date("Y-m-d H:i:s");
		
		// get locale		
		$cparams = JComponentHelper::getParams( 'com_jtrinitycore');
		$user->locale=$cparams->get('locale');
		
		
		$user->locked = 0;
		if (!empty($userinfo['block']) || !empty($userinfo['activation'])) {
			if ($userinfo['block']==1 || $userinfo['activation']==1)
				$user->locked = 1;
		}
		
		
		$user->last_ip = '127.0.0.1';
		$db = JTrinityCoreDBHelper::getDB();
		
		// Insert  the user in the DB
		if (!$db->insertObject($this->dbaccount.'.account', $user, 'id')) {
			JLog::add('Error creating account in trinity db. username= '.$user->username,JLog::ERROR, $this->logcat);
			return false;
		
		} else {
						
			$sql="INSERT INTO ".$this->dbaccount.".account_access (id, gmlevel) VALUES (".$user->id.", 0)";
			$db->setQuery($sql);
			
			if (!$db->query()) {
				JLog::add('Error creating account_access in trinity db. SQL='.$sql,JLog::ERROR, $this->logcat);
				return false;
			}
			else			
				return true;
		}
	}
	
	protected function updateUser($userinfo)
	{
		$locked=0;
		if (!empty($userinfo['block']) || !empty($userinfo['activation'])) {
			if ($userinfo['block']==1 || $userinfo['activation']==1)
				$locked= 1;
		}
		$password = sha1(strtoupper($userinfo['username']) . ':' . strtoupper($userinfo['password_clear']));
		$sql="UPDATE ".$this->dbaccount.".account SET email='".$userinfo['email']."', locked=".$locked.", sha_pass_hash='".$password."' WHERE UPPER(username)=UPPER('".$userinfo['username']."')";
		$db = JTrinityCoreDBHelper::getDB();
		$db->setQuery($sql);
		if (!$db->query())
		{
			JLog::add('Error updating account in trinity db. SQL= '.$sql,JLog::ERROR, $this->logcat);
			return false;
			
		}
		else
		{
			// Get joomla user groups
			
			$jgroups=JUserHelper::getUserGroups($userinfo['id']);
			$dbo=JFactory::getDbo();
			$query = $dbo->getQuery(true);
			$query->select($dbo->quoteName('id') . ', ' . $dbo->quoteName('title'));
			$query->from($dbo->quoteName('#__usergroups'));
			$query->where($dbo->quoteName('id') . ' = ' . implode(' OR ' . $dbo->quoteName('id') . ' = ', $jgroups));
			$dbo->setQuery($query);
			$results = $dbo->loadObjectList();
			
			// Update account_access table
			$groups=JTrinityCoreDBHelper::getWowGroups();
			$gmlevel=0;
			foreach ($groups as $v)
			{				
				foreach ($results as $g)
				{
					if (strtoupper($g->title)==strtoupper($v['name']))
							$gmlevel=$v['id'];
				}			
				
			}
			$sql="UPDATE ".$this->dbaccount.".account_access SET gmlevel=".$gmlevel;
			$db->setQuery($sql);
			if (!$db->query())
			{
				JLog::add('Error updating account_access in trinity db. SQL= '.$sql,JLog::ERROR, $this->logcat);
				return false;
			
			}
		}
		return true;
	}
	
	protected function getAccId($username)
	{
		$sql="SELECT id FROM ".$this->dbaccount.".account WHERE UPPER(username)=UPPER('".$username."')";
		$db = JTrinityCoreDBHelper::getDB();
		$db->setQuery($sql);
		if (!$accid=$db->loadResult())
		{
			JLog::add('Error getting accid. SQL='.$sql,JLog::ERROR, $this->logcat);
			return -1;
		}
		
		return $accid;
	}
	protected function deleteUser($user)
	{
		// deletion method
		$cparams = JComponentHelper::getParams( 'com_jtrinitycore');
		$db = JTrinityCoreDBHelper::getDB();
		$accid=$this->getAccId($user['username']);
		
		if ($accid==-1)
		{
			JLog::add('Error deleting user account. AccId=-1. User='.$user['username'],JLog::ERROR, $this->logcat);
			return false;
		}
		
		if ( ((int)$cparams->get('delete_method')) == 0 ) {
			//---- Lock User
		
			// Do not delete the user, just locks it
			
			$query = "UPDATE ".$this->dbaccount.".account SET  locked = 1 WHERE id=".$accid;
			$db->setQuery($query);
			if (!$db->query()) {
				JLog::add('Error locking user account in trinity db. SQL= '.$query,JLog::ERROR, $this->logcat);
				return false;
				
			} else {
				JLog::add('Locking user account in trinity db OK. SQL= '.$query,JLog::INFO, $this->logcat);
				return true;
			}
		} else
		{
			// TODO: ---- Delete user in Trinity Core
			
			$query = "DELETE FROM ".$this->dbaccount.".account WHERE id=".$accid;
			$db->setQuery($query);
			if (!$db->query()) {
				JLog::add('Error deleting from table account. SQL= '.$query,JLog::ERROR, $this->logcat);
				return false;						
			}
			$query = "DELETE FROM ".$this->dbaccount.".account_access WHERE id=".$accid;
			$db->setQuery($query);
			if (!$db->query()) {
				JLog::add('Error deleting from table account_access. SQL= '.$query,JLog::ERROR, $this->logcat);
				return false;	
			}
			
			$query = "DELETE FROM ".$this->dbaccount.".realmcharacters WHERE acctid  = " . $accid;
			$db->setQuery($query);
			if (!$db->query()) {
				JLog::add('Error deleting from table realmcharacters. SQL= '.$query,JLog::ERROR, $this->logcat);
				return false;	
			} 			
			
			// Delete from all DB characters
			$sql="SELECT charactersdb FROM #__jtc_realms ";
			$dbo=JFactory::getDbo();
			$dbo->setQuery($sql);
			
			if ($obj=$dbo->loadObjectList())
			{
				foreach($obj as $i => $item):
					$query = 'DELETE FROM '.$item->charactersdb .'.account_data WHERE accountId  = ' . $accid;
					$db->setQuery($query);
					if (!$db->query()) {
						JLog::add('Error deleting from table account_data. SQL= '.$query,JLog::ERROR, $this->logcat);
						return false;
					} 
				
					$query = 'UPDATE  '.$item->charactersdb .'.characters SET deleteDate=(SELECT UNIX_TIMESTAMP(\''. date("Y-m-d H:i:s") . '\')) WHERE account  = ' . $accid;
					//$query = 'DELETE FROM  #__characters WHERE account  = ' . (int)$userinfo->userid;
					$db->setQuery($query);
					if (!$db->query()) {
						JLog::add('Error deleting from table characters. SQL= '.$query,JLog::ERROR, $this->logcat);
						return false;
					} 
				endforeach;
			}
			else JLog::add('Error loading characters db from jtc_realms . SQL= '.$sql,JLog::ERROR, $this->logcat);
		
		}
		JLog::add('Deleted user from table characters OK.',JLog::INFO, $this->logcat);
		return true;
	}


	/**
	 * Example store user method
	 *
	 * Method is called after user data is stored in the database
	 *
	 * @param	array		$user		Holds the new user data.
	 * @param	boolean		$isnew		True if a new user is stored.
	 * @param	boolean		$success	True if user was succesfully stored in the database.
	 * @param	string		$msg		Message.
	 *
	 * @return	void
	 * @since	1.6
	 * @throws	Exception on error.
	 */
	public function onUserAfterSave($user, $isnew, $success, $msg)
	{
		$app = JFactory::getApplication();
		
		

		// convert the user parameters passed to the event
		// to a format the external application

		$args = array();
		$args['username']	= $user['username'];
		$args['email']		= $user['email'];
		$args['fullname']	= $user['name'];
		$args['password']	= $user['password'];

		JLog::add('onUserAfterSave event. User='.$user['username'].' Isnew='.$isnew.'  Success='.$success,JLog::INFO, $this->logcat);
					
		$ok=$success;
		if ($success)
		{
			if ($isnew) {
				// Call a function in the external app to create the user
				// ThirdPartyApp::createUser($user['id'], $args);
				JLog::add('Creating new user in trinity db. User='.$user['username'],JLog::INFO, $this->logcat);
				$ok=$this->createUser($user);
			}
			else  {
				// Call a function in the external app to update the user
				// ThirdPartyApp::updateUser($user['id'], $args);
				JLog::add('Updating user in trinity. User='.$user['username'],JLog::INFO, $this->logcat);
				$ok=$this->updateUser($user);
			}
		}
		else
			JLog::add('onUserAfterSave: do nothing. Success=false',JLog::INFO, $this->logcat);
			
		
		return $ok;
	}

	/**
	 * Example store user method
	 *
	 * Method is called before user data is deleted from the database
	 *
	 * @param	array		$user	Holds the user data.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public function onUserBeforeDelete($user)
	{
		$app = JFactory::getApplication();
	}

	/**
	 * Example store user method
	 *
	 * Method is called after user data is deleted from the database
	 *
	 * @param	array		$user	Holds the user data.
	 * @param	boolean		$success	True if user was succesfully stored in the database.
	 * @param	string		$msg	Message.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public function onUserAfterDelete($user, $success, $msg)
	{
		$app = JFactory::getApplication();

		// only the $user['id'] exists and carries valid information

		// Call a function in the external app to delete the user
		// ThirdPartyApp::deleteUser($user['id']);
		
		JLog::add('onUserAfterDelete event. User='.$user['username'].' Success='.$success,JLog::INFO, $this->logcat);
		$ok=$success;
		if ($success)
		{
			$ok=$this->deleteUser($user);
		}
		
		return $ok;
	}

	/**
	 * This method should handle any login logic and report back to the subject
	 *
	 * @param	array	$user		Holds the user data.
	 * @param	array	$options	Extra options.
	 *
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	public function onUserLogin($user, $options)
	{
		// Initialise variables.
		$success = true;

		// Here you would do whatever you need for a login routine with the credentials
		//
		// Remember, this is not the authentication routine as that is done separately.
		// The most common use of this routine would be logging the user into a third party
		// application.
		//
		// In this example the boolean variable $success would be set to true
		// if the login routine succeeds

		// ThirdPartyApp::loginUser($user['username'], $user['password']);

		return $success;
	}

	/**
	 * This method should handle any logout logic and report back to the subject
	 *
	 * @param	array	$user	Holds the user data.
	 *
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	public function onUserLogout($user)
	{
		// Initialise variables.
		$success = true;

		// Here you would do whatever you need for a logout routine with the credentials
		//
		// In this example the boolean variable $success would be set to true
		// if the logout routine succeeds

		// ThirdPartyApp::loginUser($user['username'], $user['password']);

		return $success;
	}
	
	/**
	 * @param	string	The context for the data
	 * @param	int		The user id
	 * @param	object
	 * @return	boolean
	 * @since	1.6
	 */
	function onContentPrepareData($context, $data)
	{
		// Check we are manipulating a valid form.
		if (!in_array($context, array('com_users.profile','com_users.registration','com_users.user','com_admin.profile'))){
			return true;
		}
	
		$userId = isset($data->id) ? $data->id : 0;
	
		// Load the profile data from the database.
		$db = &JFactory::getDbo();
		$db->setQuery(
				'SELECT profile_key, profile_value FROM #__user_profiles' .
				' WHERE user_id = '.(int) $userId .
				' AND profile_key LIKE \'trinity.%\'' .
				' ORDER BY ordering'
		);
		$results = $db->loadRowList();
	
		// Check for a database error.
		if ($db->getErrorNum()) {
			$this->_subject->setError($db->getErrorMsg());
			return false;
		}
	
		// Merge the profile data.
		$data->trinity = array();
		foreach ($results as $v) {
			$k = str_replace('trinity.', '', $v[0]);
			$data->trinity[$k] = $v[1];
		}
	
		return true;
	}
	
	/**
	 * @param	JForm	The form to be altered.
	 * @param	array	The associated data for the form.
	 * @return	boolean
	 * @since	1.6
	 */
	function onContentPrepareForm($form, $data)
	{
		// Load user_profile plugin language
		$lang = JFactory::getLanguage();
		$lang->load('plg_user_trinity', JPATH_ADMINISTRATOR);
	
		if (!($form instanceof JForm)) {
			$this->_subject->setError('JERROR_NOT_A_FORM');
			return false;
		}
		// Check we are manipulating a valid form.
		if (!in_array($form->getName(), array('com_users.profile', 'com_users.registration','com_users.user','com_admin.profile'))) {
			return true;
		}
		if ($form->getName()=='com_users.profile')
		{
			// Add the profile fields to the form.
			JForm::addFormPath(dirname(__FILE__).'/profiles');
			$form->loadFile('profile', false);
	
			// Toggle whether the something field is required.
			if ($this->params->get('profile-require_something', 1) > 0) {
				$form->setFieldAttribute('something', 'required', $this->params->get('profile-require_something') == 2, 'trinity');
			} else {
				$form->removeField('something', 'trinity');
			}
		}
	
		//In this example, we treat the frontend registration and the back end user create or edit as the same.
		elseif ($form->getName()=='com_users.registration' || $form->getName()=='com_users.user' )
		{
			// Add the registration fields to the form.
			JForm::addFormPath(dirname(__FILE__).'/profiles');
			$form->loadFile('profile', false);
	
			// Toggle whether the something field is required.
			if ($this->params->get('register-require_something', 1) > 0) {
				$form->setFieldAttribute('something', 'required', $this->params->get('register-require_something') == 2, 'trinity');
			} else {
				$form->removeField('something', 'trinity');
			}
		}
	}
}
