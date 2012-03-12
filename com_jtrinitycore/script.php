<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

 
/**
 * Script file of JTrinityCore  component
 */
class com_jtrinitycoreInstallerScript
{
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) 
	{
		// $parent is the class calling this method
		$parent->getParent()->setRedirectURL('index.php?option=com_jtrinitycore&view=about');
	}
 
	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
		// $parent is the class calling this method
		echo '<p>' . JText::_('UNINSTALL_TEXT') . '</p>';
	}
 
	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) 
	{
		// $parent is the class calling this method
		echo '<p>' . JText::_('UPDATE_TEXT') . '</p>';
	}
 
	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent) 
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		//echo '<p>' . JText::_('PREFLIGHT_' . $type . '_TEXT') . '</p>';
		
		// Check if JFusion is installed
	/*	$db=JFactory::getDbo();
		$sql="SELECT name FROM #__extensions WHERE type='component' AND element='com_jfusion'";
		$db->setQuery($sql);
		if (!$obj=$db->loadObject())
		{
			//Jerror::raiseWarning(null, "<p><strong>You need to install JFusion Component before installing JTrinityCore component.</string><br/>Get JFusion <a href='http://www.jfusion.org'>here.</a><br/></p>");
			//Jerror::raiseError(500, 'Joomla 1.5 version of Ignite Gallery uploaded, please install the Joomla 1.6 version');
			//$str= "<p><strong>You need to install JFusion Component before installing JTrinityCore component.</string><br/>";
			//$str.="Get JFusion <a href='http://www.jfusion.org'>here.</a><br/></p>";
			Jerror::raiseWarning(null, JText::_('COM_JTRINITYCORE_INSTALL_ERROR_JFUSION'));
			//throw new Exception($str);
			return false;
		}
		
		return true;*/
	}
	
	/**
	 * Method to recursively rebuild the nested set tree.
	 *
	 * @param   integer  $parent_id  The root of the tree to rebuild.
	 * @param   integer  $left       The left id to start with in building the tree.
	 *
	 * @return  boolean  True on success
	 *
	 * @since   11.1
	 */
	protected function rebuild($parent_id = 0, $left = 0)
	{
		
		
		// get the database object
		$db =JFactory::getDbo();
	
		// get all children of this node
		$db->setQuery('SELECT id FROM #__usergroups WHERE parent_id=' . (int) $parent_id . ' ORDER BY parent_id, title');
		$children = $db->loadColumn();
	
		// the right value of this node is the left value + 1
		$right = $left + 1;
	
		// execute this function recursively over all children
		for ($i = 0, $n = count($children); $i < $n; $i++)
		{
		// $right is the current right value, which is incremented on recursion return
		$right = $this->rebuild($children[$i], $right);
	
			// if there is an update failure, return false to break out of the recursion
			if ($right === false)
			{
				return false;
			}
		}
	
		// we've got the left value, and now that we've processed
		// the children of this node we also know the right value
		$db->setQuery('UPDATE #__usergroups SET lft=' . (int) $left . ', rgt=' . (int) $right . ' WHERE id=' . (int) $parent_id);
		// if there is an update failure, return false to break out of the recursion
		if (!$db->query())
		{
			return false;
		}
	
			// return the right value of this node + 1
			return $right + 1;
	}
	
 
	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		//echo '<p>' . JText::_('POSTFLIGHT_' . $type . '_TEXT') . '</p>';
		
		if ($type=='install')
		{
			
			$db=JFactory::getDbo();
			
			// Check if already exist group
			$sql="SELECT * FROM #__usergroups WHERE title LIKE 'Wow%' ";
			$db->setQuery($sql);
			
			if (!$db->loadObject())
			{
				//JLoader::register('JTrinityCoreDBHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'jtrinitycoredb.php');
				require_once( JPATH_SITE . DS . 'administrator' . DS . 'components' . DS . 'com_jtrinitycore'.DS.'helpers'.DS.'jtrinitycoredb.php' );
				
				// Install the groups
				$groups=JTrinityCoreDBHelper::getWowGroups();
				// Add groups
				
				foreach ($groups as $v)
				{
					$obj=new stdClass();
					$obj->id=NULL;
					$obj->parent_id=2; // Registered Users Id
					//Jerror::raiseWarning(null, 'name='.$v['name']);
					$obj->title=$v['name'];
					if (!$db->insertObject('#__usergroups',$obj,'id'))
					{
						throw new Exception('Error inserting in usergroups. name='.$v['name']);
					}
					$this->rebuild();
				}
				
				
				
				
			}
			
			
		}
	}
}
