<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * JTrinityCores View
 */
class JTrinityCoreViewSearchItems extends JView
{
	protected $items;
	protected $pagination;
	protected $state;
	
	/**
	 * SearchItems view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		
		
		
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		
				
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
			// Class  filter.
			$options	= array();
			$options[]	= JHtml::_('select.option', '0', JText::_('Consumable'));
			$options[]	= JHtml::_('select.option', '1', JText::_('Container'));
			$options[]	= JHtml::_('select.option', '2', JText::_('Weapon'));
			$options[]	= JHtml::_('select.option', '3', JText::_('Gem'));
			$options[]	= JHtml::_('select.option', '4', JText::_('Armor'));
			$options[]	= JHtml::_('select.option', '5', JText::_('Reagent'));
			$options[]	= JHtml::_('select.option', '6', JText::_('Projectile'));
			$options[]	= JHtml::_('select.option', '7', JText::_('Trade Goods'));
			//$options[]	= JHtml::_('select.option', '8', JText::_('J8'));
			$options[]	= JHtml::_('select.option', '9', JText::_('Recipe'));
			//$options[]	= JHtml::_('select.option', '10', JText::_('J10'));	
			$options[]	= JHtml::_('select.option', '11', JText::_('Quiver'));
			$options[]	= JHtml::_('select.option', '12', JText::_('Quest'));
			$options[]	= JHtml::_('select.option', '13', JText::_('Key'));
			//$options[]	= JHtml::_('select.option', '14', JText::_('J10'));		
			$options[]	= JHtml::_('select.option', '15', JText::_('Miscellaneous'));
			$options[]	= JHtml::_('select.option', '16', JText::_('Glyph'));
			
			$this->assign('f_class', $options);
			
			// Quality  filter.
			$quality	= array();
			$quality[]	= JHtml::_('select.option', '0', JText::_('Poor - Grey'));
			$quality[]	= JHtml::_('select.option', '1', JText::_('Common - White'));
			$quality[]	= JHtml::_('select.option', '2', JText::_('Uncommon - Green'));
			$quality[]	= JHtml::_('select.option', '3', JText::_('Rare - Blue'));
			$quality[]	= JHtml::_('select.option', '4', JText::_('Epic - Purple'));
			$quality[]	= JHtml::_('select.option', '5', JText::_('Legendary - Orange'));
			$quality[]	= JHtml::_('select.option', '6', JText::_('Artifact - Red'));
			$quality[]	= JHtml::_('select.option', '7', JText::_('Bind to Account - Gold'));			
			
			$this->assign('f_quality', $quality);
			
			// Inventory Type  filter.
			$inventory	= array();
			$inventory[]	= JHtml::_('select.option', '0', JText::_('Non equipable'));
			$inventory[]	= JHtml::_('select.option', '1', JText::_('Head'));
			$inventory[]	= JHtml::_('select.option', '2', JText::_('Neck'));
			$inventory[]	= JHtml::_('select.option', '3', JText::_('Shoulder'));
			$inventory[]	= JHtml::_('select.option', '4', JText::_('Shirt'));
			$inventory[]	= JHtml::_('select.option', '5', JText::_('Chest'));
			$inventory[]	= JHtml::_('select.option', '6', JText::_('Waist'));
			$inventory[]	= JHtml::_('select.option', '7', JText::_('Legs'));
			$inventory[]	= JHtml::_('select.option', '8', JText::_('Feet'));
			$inventory[]	= JHtml::_('select.option', '9', JText::_('Wrists'));
			$inventory[]	= JHtml::_('select.option', '10', JText::_('Hands'));
			$inventory[]	= JHtml::_('select.option', '11', JText::_('Finger'));
			$inventory[]	= JHtml::_('select.option', '12', JText::_('Trinket'));
			$inventory[]	= JHtml::_('select.option', '13', JText::_('Weapon'));
			$inventory[]	= JHtml::_('select.option', '14', JText::_('Shield'));
			$inventory[]	= JHtml::_('select.option', '15', JText::_('Ranged (Bows)'));
			$inventory[]	= JHtml::_('select.option', '16', JText::_('Back'));
			$inventory[]	= JHtml::_('select.option', '17', JText::_('Two-Hand'));
			$inventory[]	= JHtml::_('select.option', '18', JText::_('Bag'));
			$inventory[]	= JHtml::_('select.option', '19', JText::_('Tabard'));
			$inventory[]	= JHtml::_('select.option', '20', JText::_('Robe'));
			$inventory[]	= JHtml::_('select.option', '21', JText::_('Main hand'));
			$inventory[]	= JHtml::_('select.option', '22', JText::_('Off hand'));
			$inventory[]	= JHtml::_('select.option', '23', JText::_('Holdable (Tome)'));
			$inventory[]	= JHtml::_('select.option', '24', JText::_('Ammo'));
			$inventory[]	= JHtml::_('select.option', '25', JText::_('Thrown'));
			$inventory[]	= JHtml::_('select.option', '26', JText::_('Ranged right (Wands, Guns)'));
			$inventory[]	= JHtml::_('select.option', '27', JText::_('Quiver'));
			$inventory[]	= JHtml::_('select.option', '28', JText::_('Relic'));
			
			$this->assign('f_inventory', $inventory);
			
			
			// Allowable class  filter.
			$allowableclass	= array();
			$allowableclass[]	= JHtml::_('select.option', '1', JText::_('Warrior'));
			$allowableclass[]	= JHtml::_('select.option', '2', JText::_('Paladin'));
			$allowableclass[]	= JHtml::_('select.option', '4', JText::_('Hunter'));
			$allowableclass[]	= JHtml::_('select.option', '8', JText::_('Rogue'));
			$allowableclass[]	= JHtml::_('select.option', '16', JText::_('Priest'));
			$allowableclass[]	= JHtml::_('select.option', '32', JText::_('Death Knight'));
			$allowableclass[]	= JHtml::_('select.option', '64', JText::_('Shaman'));
			$allowableclass[]	= JHtml::_('select.option', '128', JText::_('Mage'));
			$allowableclass[]	= JHtml::_('select.option', '256', JText::_('Warlock'));
			$allowableclass[]	= JHtml::_('select.option', '1024', JText::_('Druid'));
			
			$this->assign('f_allowableclass', $allowableclass);
			
			
		
		parent::display($tpl);
		//JRequest::setVar('hidemainmenu', true);
		
		
	}
	
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JController
	 * @since   1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
					'itemid', 'itemid',
					'name', 'name',
					'itemlevel', 'itemlevel',
					'requiredlevel', 'requiredlevel',
				);
		}
	
		parent::__construct($config);
	}
	
	
	
	
	
}