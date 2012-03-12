<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers/paypal'.DS.'PaypalExpressCheckout.php' );

$gateway = new PaypalGateway();
$params = JComponentHelper::getParams( 'com_jtrinitycore' );

$gateway->apiUsername = $params->get("api_username");
$gateway->apiPassword = $params->get("api_password");
$gateway->apiSignature = $params->get("api_signature");

$gateway->testMode = false;

// Return (success) and cancel url setup

$gateway->returnUrl = JURI::root()."index.php?option=com_jtrinitycore&amp;view=buypoints&amp;layout=paypalexpresscheckout&amp;action=success";
$gateway->cancelUrl = JURI::root()."index.php?option=com_jtrinitycore&amp;view=buypoints&amp;layout=paypalexpresscheckout&amp;action=cancel";
//$gateway->cancelUrl = JURI::root()."index.php";

$paypal = new PaypalExpressCheckout($gateway);
$shipping=false;

switch (JRequest::getVar('action')) {
    case "": // Index page, here you should be redirected to Paypal
    	JLog::add('doExpressCheckout - Begin',JLog::INFO,'paypal');
        $paypal->doExpressCheckout(JRequest::getVar('points'), 'Donationshop get points', '', $params->get("currency"), $shipping, $resultData);
        //JLog::add('doExpressCheckout - Result Data='.print_r($resultData),JLog::INFO,'paypal');
        JLog::add('doExpressCheckout - End',JLog::INFO,'paypal');
        break;
    
    case "success": // Paypal says everything's fine, do the charge (user redirected to $gateway->returnUrl)
    	$user=JFactory::getUser();
    	$model=$this->getModel();
        //if ($result = $paypal->doPayment($_GET['token'], $_GET['PayerID'], $resultData)) {
    	if ($result = $paypal->doPayment(JRequest::getVar('token'), JRequest::getVar('PayerID'), $resultData)) {
			//echo "Success! Transaction ID: ".$result['TRANSACTIONID'];
			foreach($result as $c=>$v)
				JLog::add('doPayment - '.$c.'='.$v,JLog::INFO,'paypal');
			
			JLog::add('doPayment - End',JLog::INFO,'paypal');
			//print_r($resultData);			
			
			// Add points to the user
			
			$amount= $result['AMT'];
			$paypal_txn_id=$result['TRANSACTIONID'];
			$model->addUserPoints($user->id, $amount);
			
			// Add transaction ID to the database with status COMPLETED	
			$model->insertDonation($user->id, $amount, $paypal_txn_id, true);
			
			// Send notification mail			
			$mail=JMail::getInstance();
			$mail->setSubject(JText::_('COM_JTRINITYCORE_PAYPAL_EMAIL_NOTIFICATION_SUBJECT'));
			$mail->setBody(JText::sprintf('COM_JTRINITYCORE_PAYPAL_EMAIL_NOTIFICATION_BODY',$paypal_txn_id,$user->username,$amount));
			$mail->addRecipient($params->get("notificationmail"));
			$mail->SetFrom($params->get("paypal_from"));
			
			//$mail->AddAddress($params->get("notificationmail"));
			if (!$err=$mail->Send())
			{
				JLog::add('Error sending paypal notification mail.',JLog::ERROR,'paypal');
			}	
					
			// Send mail to buyer
			$mail->ClearAddresses();
			$mail->ClearAllRecipients();
			$mail->ClearReplyTos();
			$mail->setSubject(JText::_('COM_JTRINITYCORE_PAYPAL_EMAIL_NOTIFICATION_USER_SUBJECT'));
			$mail->setBody(JText::sprintf('COM_JTRINITYCORE_PAYPAL_EMAIL_NOTIFICATION_USER_BODY',$user->username,$amount ,$paypal_txn_id));
			$mail->addRecipient($user->email);
			
			$mail->SetFrom($params->get("paypal_from"));
			if (!$err=$mail->Send())
			{
				JLog::add('Error sending paypal notification mail to user mail '.$user->email,JLog::ERROR,'paypal');
			}
			
			// Show points and message OK
			echo JText::_('COM_JTRINITYCORE_PAYPAL_OPERATION_SUCCESS');
			JTrinityCoreUtilities::ShowUserPoints(false);
			
			
		} else {
			echo JText::_('COM_JTRINITYCORE_PAYPAL_OPERATION_ERROR');
			//print_r($resultData);
			foreach($result as $c=>$v)
				JLog::add('doPayment - '.$c.'='.$v,JLog::ERROR,'paypal');
			
			// Add failure transaction into the DB
			$amount= $result['AMT'];
			$paypal_txn_id=$result['TRANSACTIONID'];
			
			$model->insertDonation($user->id, $amount, $paypal_txn_id, false);
			
		}
	break;

    case "refund":
        $transactionId = '9SU82364E9556505C';
        if ($paypal->doRefund($transactionId, 'inv123', false, 0, 'USD', '', $resultData))
            //echo 'Refunded: '.$resultData['GROSSREFUNDAMT'];
        	JLog::add('doRefund - '.$resultData['GROSSREFUNDAMT'],JLog::INFO,'paypal');
            else {
                //echo "Debugging what went wrong: ";
                //print_r($resultData);
        	foreach($resultData as $c=>$v)
        		JLog::add('doRefund - '.$v,JLog::ERROR,'paypal');
            }
        break;
    
    case "cancel": // User canceled and returned to your store (to $gateway->cancelUrl)
    	
        echo JText::_('COM_JTRINITYCORE_PAYPAL_OPERATION_CANCELLED');        
        break;
}

?>
