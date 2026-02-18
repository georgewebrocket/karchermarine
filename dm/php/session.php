<?php
session_start(); 

if(!isset($_SESSION['COMPARE_PRODUCT_IDS'])){$_SESSION['COMPARE_PRODUCT_IDS'] = array();}

$rfqListCount = 0;
if(!isset($_SESSION['karcher_rfq'])){
	$_SESSION['karcher_rfq'] = array(array());
}
else {
	$myAr = $_SESSION['karcher_rfq'];
	$rfqListCount = count($myAr);	
}
?>