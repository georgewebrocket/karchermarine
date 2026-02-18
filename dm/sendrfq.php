<?php

ini_set('display_errors',1); 
error_reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8');
require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
require_once('php/dataobjects.php');
require_once('php/content.php');

$str = $_REQUEST['details'];
$rfqItems = explode("||",$str);
$itemIds = '';
for ($i=0;$i<count($rfqItems);$i++) {
	$itemDetails = explode("|", $items[$i]);
	$itemId = $itemDetails[0];
	$itemQuantity = $itemDetails[1];
	$itemIds .= $itemId . ", ";
}
$itemIds = substr($itemIds,0,strlen($itemIds)-1);

$sql = "SELECT * FROM app_products WHERE id IN ($itemIds)";
$rsItems = $db1->getRS($sql);

require 'phpmailer/PHPMailerAutoload.php';
$mail = new PHPMailer();
$mail->CharSet = 'UTF-8';
$mail->setFrom("dms@dietsystem.gr", "DIETSYSTEM-DMS");
$mail->addReplyTo($t_email, '');
$mail->addAddress($mailTo, 'DietSystem');
$mail->AddCC('george@webrocket.gr', 'admin');
//$mail->AddCC($t_email, "");
//
//Set the subject line
$mail->Subject = "Message from DietSystem.GR: DMS Analysis";

?>