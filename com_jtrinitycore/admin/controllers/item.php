<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * JTrinityCore Controller
 */
class JTrinityCoreControllerItem extends JControllerForm
{
	
	/**
	 * Method to save a record.
	 *
	 * @param   string  $key     The name of the primary key of the URL variable.
	 * @param   string  $urlVar  The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	 *
	 * @return  boolean  True if successful, false otherwise.
	 *
	 * @since   11.1
	 */
	public function save($key = null, $urlVar = null)
	{
		if (!parent::save($key, $urlVar))
			return false;
		
		// Get Itemid
		$recordId = JRequest::getInt($urlVar);
		$db=JFactory::getDbo();
		
		if ($recordId==0)
		{
			//$model=$this->getModel();
			//$table = $model->getTable();
			//$recordId = $model->getState($this->context . '.id');
			
			//$recordId=$table->id;
			$sql="SELECT MAX(id) FROM #__jtc_items";
			$db->setQuery($sql);
			if (!$recordId=$db->loadResult())
			{
				JLog::add('item.save: Error getting id. SQL='.$sql,JLog::ERROR,'com_jtrinitycore');
				return false;
			}		
		}
		
		//$data = JRequest::getVar('jform', array(), 'post', 'array');
		//$recordId=$data['id'];
		
		//JLog::add('item.save: saving item with id='.$recordId,JLog::INFO,'com_jtrinitycore');
		
		$sql="SELECT itemid FROM #__jtc_items WHERE id=".$recordId;
		
		$db->setQuery($sql);
		if (!$itemid=$db->loadResult())
		{
			JLog::add('item.save: Error getting itemid. SQL='.$sql,JLog::ERROR,'com_jtrinitycore');
			return false;
		}
		
		$xmlurl="http://www.wowhead.com/item=".$itemid."?xml";
		$xml = file_get_contents($xmlurl);
		if ($xml == false) {		
			// an error happened
			JLog::add('item.save: Error getting XML. URL='.$xmlurl,JLog::ERROR,'com_jtrinitycore');
			return false;
		}
		
		// Parse XML
		$item=new SimpleXMLElement($xml);		
		$icon=strtolower($item->item->icon).".jpg";
		
		$imageurl="http://wow.zamimg.com/images/wow/icons/";  //large/";
		
		// Get the small image
		$urlsmall=$imageurl."small/".$icon;
		
		$image = file_get_contents($urlsmall);
		if ($image == false) {
			// an error happened
			JLog::add('item.save: Error getting small image. URL='.$urlsmall,JLog::ERROR,'com_jtrinitycore');
			return false;
		}
		
		$dest="../media/com_jtrinitycore/items/small/".$icon;
		// Write file
		$fp = fopen($dest, 'w');
		fwrite($fp, $image);
		fclose($fp);
		
		// Get the medium image
		$urlmedium=$imageurl."medium/".$icon;	
		$image = file_get_contents($urlmedium);
		if ($image == false) {
			// an error happened
			JLog::add('item.save: Error getting medium image. URL='.$urlmedium,JLog::ERROR,'com_jtrinitycore');
			return false;
		}
		
		$dest="../media/com_jtrinitycore/items/medium/".$icon;
		// Write file
		$fp = fopen($dest, 'w');
		fwrite($fp, $image);
		fclose($fp);
		
		// Get the large image
		$urllarge=$imageurl."large/".$icon;
		$image = file_get_contents($urllarge);
		if ($image == false) {
			// an error happened
			JLog::add('item.save: Error getting large image. URL='.$urllarge,JLog::ERROR,'com_jtrinitycore');
			return false;
		}
		
		$dest="../media/com_jtrinitycore/items/large/".$icon;
		// Write file
		$fp = fopen($dest, 'w');
		fwrite($fp, $image);
		fclose($fp);		
		
		
		// Update the database
		$sql="UPDATE #__jtc_items SET icon='".$icon."' WHERE id=".$recordId;
		$db->setQuery($sql);
		if (!$db->query())
		{
			JLog::add('item.save: Error updating icon in database. SQL='.$sql,JLog::ERROR,'com_jtrinitycore');
			return false;
		}
		
		return true;
	}
}
