<?php

require_once('php/config.php');
require_once('php/db.php');
require_once('php/dataobjects.php');
require_once('php/utils.php');
require_once('php/start.php');
require_once('php/session.php');
require_once ('php/controls.php');

$sql = "SELECT * FROM app_products";
$rs = $db1->getRS($sql);

for ($i=0; $i<count($rs); $i++) {
	$product = new app_products($db1, $rs[$i]['id'], $rs);
	$str = $product->downloads();
	if ($str!='') {
		$ar = explode("====", $str);
		$res = "";
		for ($k=1;$k<count($ar);$k++) {
			$res .= $ar[$k]."====";
		}
		$res = substr($res, 0, strlen($res)-4);
		//echo $res."<br/><br/>";
		
		$product->downloads($res);
		if ($product->Savedata()) {
			echo $product->get_id()." ok<br/>";	
		}
		else {
			echo $product->get_id()." error<br/>";	
		}	
	}
}


?>