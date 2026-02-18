<?php

/*ini_set('display_errors',1); 
error_reporting(E_ALL);*/

require_once('php/session.php');

if (isset($_REQUEST['clear'])) {
	$_SESSION['karcher_rfq'] = null;
	$rfqItems = $_SESSION['karcher_rfq'];
}
else {
	$rfqItems = array_filter($_SESSION['karcher_rfq']);
}

$itemid = isset($_REQUEST['itemid'])? $_REQUEST['itemid']: 0;
$quantity = isset($_REQUEST['quantity'])? $_REQUEST['quantity']: 0;
$add = $_REQUEST['add'];

$itemexists = false;
if (!empty($rfqItems)) {
for ($i=0;$i<count($rfqItems);$i++) {
	if ($rfqItems[$i][0]==$itemid) {
		if ($add==1) {
			$rfqItems[$i][1] = $rfqItems[$i][1] + $quantity;
		}
		else {
			if ($quantity==0 || $quantity=='0') {
				$rfqItems[$i][0] = '';
				$rfqItems[$i][1] = '';	
			}
			else {
				$rfqItems[$i][1] = $quantity;
			}
		}
		$itemexists = true;
		break 1;
	}
}
}

if (!$itemexists && $itemid!=0 && $quantity!=0) {
	$newid = count($rfqItems);
	$rfqItems[$newid][0] = $itemid;
	$rfqItems[$newid][1] = $quantity;
}


if ($rfqItems) {
for ($i=0;$i<count($rfqItems);$i++) {
	if ($rfqItems[$i][1]=='') {
		unset($rfqItems[$i]);	
	}
}
}
echo count($rfqItems);

$_SESSION['karcher_rfq'] = $rfqItems;

?>