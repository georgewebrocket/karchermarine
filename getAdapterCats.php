<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);

require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
require_once('php/content.php');
require_once('php/dataobjects.php');

$productId = $_REQUEST['productid'];
$sql = "SELECT * FROM app_adapter_data WHERE product1=? OR product2=?";
$rsAD = $db1->getRS($sql, array($productId, $productId));
//var_dump($rsAD);
$ids = "";
for ($i = 0; $i < count($rsAD); $i++) {
    if ($rsAD[$i]['product1']!=$productId) {
        $ids .= $rsAD[$i]['product1'] . ",";
    }
    else {
        $ids .= $rsAD[$i]['product2'] . ",";
    }    
}
if (strlen($ids)>0) {
    $ids = substr($ids, 0, strlen($ids)-1);
}
$sqlProd = "SELECT adapter_category FROM app_products WHERE id IN ($ids)";
$sql = "SELECT * FROM app_categories WHERE id IN ($sqlProd)";
$rsCat1 = $db1->getRS($sql);
//echo $sql;
//var_dump($rsCat1);
$cat1 = "";
if ($rsCat1) {
    for ($i = 0; $i < count($rsCat1); $i++) {
        $cat = new app_categories($db1, $rsCat1[$i]['id'], $rsCat1);
        $cat1 .= "<div class=\"af-cat af-cat-2\" data-id=\"".$cat->get_id()."\" >";
        $cat1 .= "<img src=\"". $cat->photo() ."\" />";
        $cat1 .= "</div>";
    }
}
echo $cat1;
//echo "........";