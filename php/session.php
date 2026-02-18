<?php
session_start(); 

if(!isset($_SESSION['COMPARE_PRODUCT_IDS'])){$_SESSION['COMPARE_PRODUCT_IDS'] = array();}

$rfqListCount = 0;
if(!isset($_SESSION['karcher_rfq'])){
	$_SESSION['karcher_rfq'] = array(array());
}
else {
	$rfqItems = $_SESSION['karcher_rfq'];
	for ($i=0;$i<count($rfqItems);$i++) {
		if ($rfqItems[$i][1]=='') {
			unset($rfqItems[$i]);	
		}
	}
	$rfqListCount = count($rfqItems);	
}
?>