<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * JTrinityCore Form Field class for the JTrinityCore component
 */
class JFormFieldJTrinityCore extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'JTrinityCore';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
		echo "Dentro de getOptions() de Fields...<br>";
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('#__helloworld.id as id,greeting,#__categories.title as category,catid');
		$query->from('#__helloworld');
		$query->leftJoin('#__categories on catid=#__categories.id');
		$db->setQuery((string)$query);
		$messages = $db->loadObjectList();
		echo "Dentro de getOptions() de Fields...despues de ejecutar query <br>";
		$options = array();
		if ($messages)
		{
			foreach($messages as $message)
			{
				$options[] = JHtml::_('select.option', $message->id, $message->greeting .
						($message->catid ? ' (' . $message->category . ')' : ''));
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}