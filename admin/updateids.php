<?php

require_once('php/config.php');
require_once('php/db.php');
require_once('php/dataobjects.php');
require_once('php/utils.php');
require_once('php/start.php');
//require_once('php/session.php');
require_once ('php/controls.php');

$sql = "SELECT * FROM app_products";
$rs = $db1->getRS($sql);

for ($i=0; $i<count($rs); $i++) {
	$product = new app_products($db1, $rs[$i]['id'], $rs);
	
	$str = $product->related_product_ids();
	if (strpos($str, "[")===FALSE && $str!='') {
		$accessories = explode(",", $str);
		$strAccessories = "";
		for ($k=0; $k<count($accessories); $k++) {
			$strAccessories .= "[".$accessories[$k]."],";
		}
		$strAccessories = substr($strAccessories, 0, strlen($strAccessories)-1);
		$product->related_product_ids($strAccessories);
		echo "related_product_ids=".$strAccessories."<br/><br/>";		
	}
	
	
	$str = $product->accessories_ids();
	if (strpos($str, "[")===FALSE && $str!='') {
		$accessories = explode(",", $str);
		$strAccessories = "";
		for ($k=0; $k<count($accessories); $k++) {
			$strAccessories .= "[".$accessories[$k]."],";
		}
		$strAccessories = substr($strAccessories, 0, strlen($strAccessories)-1);
		//$product->accessories_ids($strAccessories);
		//echo $strAccessories."<br/><br/>";		
	}
	
	$str = $product->cleaning_agents_ids();
	if (strpos($str, "[")===FALSE && $str!='') {
		$accessories = explode(",", $str);
		$strAccessories = "";
		for ($k=0; $k<count($accessories); $k++) {
			$strAccessories .= "[".$accessories[$k]."],";
		}
		$strAccessories = substr($strAccessories, 0, strlen($strAccessories)-1);
		//$product->cleaning_agents_ids($strAccessories);
		//echo "cleaning_agents_ids=".$strAccessories."<br/><br/>";		
	}
	
	$str = $product->standard_accessories_ids();
	if (strpos($str, "[")===FALSE && $str!='') {
		$accessories = explode(",", $str);
		$strAccessories = "";
		for ($k=0; $k<count($accessories); $k++) {
			$strAccessories .= "[".$accessories[$k]."],";
		}
		$strAccessories = substr($strAccessories, 0, strlen($strAccessories)-1);
		//$product->standard_accessories_ids($strAccessories);
		//echo "standard_accessories_ids=".$strAccessories."<br/><br/>";		
	}
	
	$product->Savedata();
	
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php echo $i; ?>

</body>
</html>