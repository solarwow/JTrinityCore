<?php
defined ( '_JEXEC' ) or die ();

jimport ( 'joomla.form.helper' );
JFormHelper::loadFieldClass ( 'list' );

class JFormFieldRealms extends JFormFieldList {

       protected $type = 'Realms';

       protected function getOptions() {
              
               $messages = JTrinityCoreDBHelper::getRealms();
               $options = array ();
               if ($messages) {
                       $options [] = JHtml::_ ( 'select.option', '0', JText::_
( 'JSELECT' ) );
                       foreach ( $messages as $message ) {
                               $options [] = JHtml::_ ( 'select.option', $message->id,
$message->name );
                       }
               }
               $options = array_merge ( parent::getOptions (), $options );
               return $options;
       }
}