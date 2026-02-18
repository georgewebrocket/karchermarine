<?php
/*
ini_set('display_errors',1); 
error_reporting(E_ALL);
*/
require_once('php/session.php');
header('Content-Type: text/html; charset=utf-8');
require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
require_once('php/dataobjects.php');
require_once('php/content.php');


$recaptcha = false;
include "recaptcha.php";
if ($recaptcha) {
	die('ERROR');
}


$str = $_REQUEST['details'];
//echo $str;
$company = $_REQUEST['company'];
$vessel = $_REQUEST['vessel'];
$imo = $_REQUEST['imo'];
$port = $_REQUEST['port'];
$eta = $_REQUEST['eta'];
$contact = $_REQUEST['contact'];
$email = $_REQUEST['email'];
$phone = $_REQUEST['phone'];
$address = $_REQUEST['address'];
$message = $_REQUEST['message'];
$sendcopy = $_REQUEST['sendcopy'];

$rfqItems = explode("||",$str);
$rfqItemId = array(); $rfqItemQuantity = array();
$itemIds = '';
for ($i=0;$i<count($rfqItems);$i++) {
	$itemDetails = explode("|", $rfqItems[$i]);
	$itemId = $itemDetails[0];
	$itemQuantity = $itemDetails[1];
	$itemIds .= $itemId . ", ";
	$rfqItemId[$i] = $itemId;
	$rfqItemQuantity[$i] = $itemQuantity;
	
}
$itemIds = substr($itemIds,0,strlen($itemIds)-1);

$sql = "SELECT * FROM app_products WHERE id IN ($itemIds)";
$rsItems = $db1->getRS($sql);

$itemsTable = "<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\"><tr><td width=\"100\">CODE</td><td width=\"400\">DESCRIPTION</td><td width=\"100\">QUANTITY</td><td width=\"100\">PRICE</td></tr>";
for ($i=0;$i<count($rfqItemId);$i++) {
	$item = new app_products($db1, $rfqItemId[$i], $rsItems);
	$itemsTable .= "<tr><td>".$item->item_code()."</td>"; 
	$itemsTable .= "<td>".$item->title()."</td>"; 
	$itemsTable .= "<td>".$rfqItemQuantity[$i]."</td>";
	$itemsTable .= "<td>&nbsp;</td></tr>"; 
}
$itemsTable .= "</table>";


require 'phpmailer/PHPMailerAutoload.php';
$mail = new PHPMailer();
$mail->CharSet = 'UTF-8';
$mail->setFrom("website@karcher-marine.com", "KARCHER-MARINE");
$mail->addReplyTo($email, $company);
$mail->addAddress("jmav@karcher-marine.com", 'KARCHER-MARINE');
if ($sendcopy==1) {
	$mail->AddCC($email, $company);	
}
//$mail->addAddress("george.apollo@gmail.com", 'KARCHER-MARINE');
$mail->AddCC('george.apollo@gmail.com', 'admin');

//Set the subject line
$mail->Subject = "Message from KARCHER-MARINE.COM";

$body = "COMPANY: " . $company . "<br/>" .
	"VESSEL: " . $vessel . "<br/>" .
	"IMO NR: " . $imo . "<br/>" .
	"NEXT PORT OF CALL: " . $port . "<br/>" .
	"ETA: " . $eta . "<br/>" .
	"CONTACT: " . $contact . "<br/>" .
	"EMAIL: " . $email . "<br/>" .
	"PHONE: " . $phone . "<br/>" .
	"ADDRESS: " . $address . "<br/>" .
	"MESSAGE: " . $message . "<br/><br/>" .
	$itemsTable;
$mail->msgHTML($body);
$mail->AltBody = '';

if (!$mail->send()) {
		$err = 'ERROR';
} else {
		$err = 'OK';
}

echo $err;

//unset($_SESSION['karcher_rfq']);
$_SESSION['karcher_rfq'] = array(array());

?>