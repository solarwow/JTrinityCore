<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 


//require_once dirname(__FILE__) . '/../../helpers/searchitem.php';
//jimport('joomla.form.fields.media');
//jimport('joomla.form.helper');
//JFormHelper::loadFieldClass('media');
//JFormHelper::loadFieldClass('user');
//jimport( 'joomla.form.formfield' );
 
// The class name must always be the same as the filename (in camel case)
class JFormFieldSearchItems extends JFormField {
 
	//The field class must know its own type through the variable $type.
	public $type = 'SearchItems';
 
	public function getLabel() {
		// code that returns HTML that will be shown as the label
		 return '<span style="">' . parent::getLabel() . '</span>';
	}
 
	
	
	/**
	 * Method to get the user field input markup.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.1
	 */
	public function getInput()
	{
		// Load modal behavior
		//JHtml::_('behavior.modal', 'a.modal');
		JHtml::_('behavior.modal');
		
		// Initialize variables.
		$html = array();
		
		$link = 'index.php?option=com_jtrinitycore&view=searchitems&tmpl=component&function=jSelectItem';
	
		// Initialize some field attributes.
		$attr = $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
		$attr .= $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
	
		// Initialize JavaScript field attributes.
		$onchange = (string) $this->element['onchange'];
	
		// Load the modal behavior script.
		//JHtml::_('behavior.modal', 'a.modal_' . $this->id);
	
		// Build the script.
		$script = array();
		$script[] = '	function jSelectItem (itemid, name, color, allowablerace, itemlevel, requiredlevel, quality, subclass, argclass, inventorytype) {';
		//$script[] = '		var old_itemid = document.getElementById("' . $this->getId("itemid","itemid"). '").value;';
		//$script[] = '		if (old_itemid != itemid) {';
		$script[] = '			document.getElementById("' . $this->id . '_itemid").value = name;';
		$script[] = '			document.getElementById("' . $this->getId("itemid","itemid") . '").value = itemid;';
		$script[] = '			document.getElementById("' . $this->getId("color","color") . '").value = color;';
		$script[] = '			document.getElementById("' . $this->getId("allowablerace","allowablerace") . '").value = allowablerace;';
		$script[] = '			document.getElementById("' . $this->getId("itemlevel","itemlevel") . '").value = itemlevel;';
		$script[] = '			document.getElementById("' . $this->getId("requiredlevel","requiredlevel") . '").value = requiredlevel;';
		$script[] = '			document.getElementById("' . $this->getId("quality","quality") . '").value = quality;';
		$script[] = '			document.getElementById("' . $this->getId("subclass","subclass") . '").value = subclass;';
		$script[] = '			document.getElementById("' . $this->getId("class","class") . '").value = argclass;';
		$script[] = '			document.getElementById("' . $this->getId("inventorytype","inventorytype") . '").value = inventorytype;';
		$script[] = '			document.getElementById("' . $this->id . '_name").value = name;';
		$script[] = '			' . $onchange;
		//$script[] = '		}';
		$script[] = '		SqueezeBox.close();';
		$script[] = '	}';
		
		$script[] = '	function checkRealm() {';
		$script[] = '	   var adr="'.$link.'";    ';
		$script[] = '	if (document.getElementById("'. $this->getId("realmid","realmid") .'").value==0) { ';
		$script[] = '	   alert("'. JText::_('COM_JTRINITYCORE_SELECT_REALM_MESSAGE') .'");';	
		$script[] = '	   return false;';
		$script[] = '	}';
		$script[] = '	else {';		
		$script[] = '	   adr=adr+"&realmid="+document.getElementById("'. $this->getId("realmid","realmid") .'").value;    ';
		$script[] ='       SqueezeBox.open(adr, { handler: \'iframe\', size: { x: 700, y: 600 } });';
		$script[] = '	   return true;';
		$script[] = '	}';
		$script[] = '	}';
	
		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
	
				
		if (empty($title)) {
			$title = JText::_('COM_JTRINITYCORE_SELECT_ITEM');
		}
		$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
		
		// The current item name display field.
		$html[] = '<div class="fltlft">';
		$html[] = '  <input type="text" id="'.$this->id.'_name" value="'.$title.'"  size="35" />';
		$html[] = '</div>';
		
	
		// Create the user select button.
		//$html[] = '<div class="button2-left">';
		$html[] = '  <div class="blank">';
		if ($this->element['readonly'] != 'true')
		{
			//$html[]='<form method="post" class="modal" onsubmit="return checkRealm();"> ';
			//$html[] = '		<a id="selectitem" class="modal" title="' . JText::_('COM_JTRINITYCORE_SELECT_ITEM_BUTTON') . '"  '
			//.' onClick="checkRealm();">';
			//. ' rel="{handler: \'iframe\', size: {x: 800, y: 450}}"  onClick="checkRealm();">';
			//$html[] = '			' . JText::_('COM_JTRINITYCORE_SELECT_ITEM_BUTTON') . '</a>';
			$html[]='<input type="button" value="'. JText::_('COM_JTRINITYCORE_SELECT_ITEM_BUTTON') .'"  onclick="return checkRealm();">';
			//$html[]='</form>';
		}
		//$html[] = '  </div>';
		$html[] = '</div>';
	
		
		$value='';
		// Create the real field, hidden, that stored the item id.
		$html[] = '<input type="hidden" id="' . $this->id . '_itemid" name="' . $this->name . '" value="' . $value . '" />';
	
		return implode("\n", $html);
	}
	
	
}