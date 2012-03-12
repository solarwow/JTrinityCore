<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * JTrinityCore Model
 */
class JTrinityCoreModelRealm extends JModelAdmin
{
	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param	array	$data	An array of input data.
	 * @param	string	$key	The name of the key for the primary key.
	 *
	 * @return	boolean
	 * @since	1.7
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		// Check specific edit permission then general edit permission.
		return JFactory::getUser()->authorise('core.edit', 'com_jtrinitycore.realm.'.
				((int) isset($data[$key]) ? $data[$key] : 0))
				or parent::allowEdit($data, $key);
	}
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.7
	 */
	public function getTable($type = 'Realm', $prefix = 'JTrinityCoreTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.7
	 */
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_jtrinitycore.realm', 'realm',
		                        array('control' => 'jform', 'load_data' => $loadData));
		
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}
	/**
	 * Method to get the script that have to be included on the form
	 *
	 * @return string	Script files
	 */
	/*public function getScript()
	{
		return 'administrator/components/com_jtrinitycore/models/forms/jtrinitycore.js';
	}*/
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.7
	 */
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_jtrinitycore.edit.realm.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
	
	public function save($data)
	{
		
		try {		
			// check if a new record		
			$table = $this->getTable();
			$key = $table->getKeyName();
			$pk = (!empty($data[$key])) ? $data[$key] : (int) $this->getState($this->getName() . '.id');
			$isNew=true;
			// Load the row if saving an existing record.
			if ($pk > 0)
			{
				//$table->load($pk);
				$isNew = false;
			}
			if ($isNew)
			{
				//insert on tc ddb
				$dbo=JTrinityCoreDBHelper::getAuthDB();
				$obj =new stdClass();
				$obj->id = NULL;				
				$obj->name = $data['realmname'];
				$obj->address = $data['ip'];
				$obj->port = $data['port'];
				$obj->population = $data['population'];
				
				$accdb=JTrinityCoreDBHelper::getAuthDBName();
				
				
				if (!$dbo->insertObject($accdb.'.realmlist', $obj, 'id')) {
					$this->setError("Error inerting on realmlist table");
					return false;
				}
				// set realmid on joomla db
				$data['realmid']=$obj->id;
				$res=parent::save($data);				
				
			}
			else
			{
				// Update
				if ($res=parent::save($data))
				{
					
						// Update on TC server
						$dbo=JTrinityCoreDBHelper::getDB();
						$accdb=JTrinityCoreDBHelper::getAuthDBName();
						$query="UPDATE ".$accdb.".realmlist SET name='".$data['realmname'].
						"' , address='".$data['ip']."' , port='".$data['port'].
						"' , population= ".$data['population'];
						$query.=" WHERE id=".$data['realmid'];			
						$dbo->setQuery($query);
						if ($dbo->query())
							$res=true;
						else $res=false;
					}
			}
			
		
			return $res;
	}
		catch (Exception $e)
		{
			$this->setError($e->getMessage());
		
			return false;
		}
	}
	
	public function delete(&$pks)
	{
		try {
			// delete from tc db
			$dbo=JTrinityCoreDBHelper::getDB();
			$accdb=JTrinityCoreDBHelper::getAuthDBName();
			// Iterate the items to delete each one.
			$res=true;
			$pks = (array) $pks;
			$table = $this->getTable();
			foreach ($pks as $i => $pk)
			{
				$realmid=0;
				// Get realmid
				if ($table->load($pk))
				{
					$realmid=$table->realmid;
				}
				
				$query="DELETE FROM ".$accdb.".realmlist WHERE id=".$realmid;
				$dbo->setQuery($query);
				$res=$res && $dbo->query();			
			}
			
			if ($res)
				$res=parent::delete($pks);
			
			return $res;
		}
			catch (Exception $e)
			{
				$this->setError($e->getMessage());
			
				return false;
			}
		
	}
}