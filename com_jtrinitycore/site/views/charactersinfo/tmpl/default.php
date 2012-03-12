<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$images="media/com_jtrinitycore/images/";
$model=$this->getModel();
$html="";
echo '<h1 class="contentheading">'.JText::_('COM_JTRINITYCORE_CHARSINFO').'</h1>';

$gold_image='&nbsp;<img src="'.$images.'gold.png" border=0>&nbsp;';
$silver_image='&nbsp;<img src="'.$images.'silver.png" border=0>&nbsp;';
$copper_image='&nbsp;<img src="'.$images.'copper.png" border=0>&nbsp;';


// For each realm
foreach($this->items as $i => $item):


	$html.="<h2>".$item->realmname."</h2>";
	$chars=$model->getCharacters($item->realmid);	
	
	foreach($chars as $c => $char):
	
		//set race
		if ($char->race=="1" || $char->race=="3" || $char->race=="4" || $char->race=="7" || $char->race=="11")
			$side="0";  
		else 
			$side="1";
		
		//set avvy
		if ($char->level<=50) 
		{
			$avvy = '<img src="'.$images.'portraits/wow-default/'.$char->gender.'-'.$char->race.'-'.$char->class.'.gif" border=0 >'; 
		} 
		elseif ($char->level>=51 && $char->level<=69 )
		{
			$avvy = '<img src="'.$images.'portraits/wow/'.$char->gender.'-'.$char->race.'-'.$char->class.'.gif" border=0 >';  
		}
		else 
		{
			$avvy = '<img src="'.$images.'portraits/wow-70/'.$char->gender.'-'.$char->race.'-'.$char->class.'.gif" border=0 >'; 
		}
		
	
		// money
		$gold=substr($char->money, 0, -4); if ($gold=='') {$gold="0";}
		$silver=substr($char->money, 0, -2); 
		$silver2=substr($silver, -2); if ($silver2=='') { $silver2="0";}
		$copper=substr($char->money, -2); if ($copper=='') { $copper="0";}		
	
		$gold=(int) $gold;
		$silver2=(int) $silver2;
		$copper=(int) $copper;
		
		$html.= '<br>';
		$html.= '<table width="100%" border="0" style="border: solid 1px black;" cellpadding="3">
		<tr>
		<td width="70">'.$avvy.'</td>
		<td valign="top" align="right">
		<strong>'.$char->name.'</strong> -   '.JText::_('COM_JTRINITYCORE_LEVEL').$char->level.'   -   '.
		JText::_('COM_JTRINITYCORE_MONEY').$gold_image.$gold.$silver_image.$silver2.$copper_image.$copper.' 
		<br><br><img src="'.$images.'icon/class/'.$char->class.'.gif" title="'.JText::_('COM_JTRINITYCORE_CLASS').'" />&nbsp;&nbsp;
		<img src="'.$images.'icon/race/'.$char->race.'-'.$char->gender.'.gif"  title="'.JText::_('COM_JTRINITYCORE_RACE').'" />&nbsp;&nbsp;
		<img src="'.$images.'icon/pvpranks/rank_default_'.$side.'.gif"  title="'.JText::_('COM_JTRINITYCORE_FACTION').'" /><br>
		</td>
		
		</tr>
		</table>';
	
	
endforeach;

endforeach;

echo $html;
