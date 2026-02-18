<?php
require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
require_once('php/content.php');
require_once('php/dataobjects.php');

$catid = $_REQUEST['catid'];
$product1 = $_REQUEST['product1'];

$cat = new app_categories($db1, $catid);
echo "<h2>".$cat->title()."</h2>";

if ($product1==0) {
    $sql = "SELECT * FROM app_products WHERE adapter_category=?";
    $rs = $db1->getRS($sql, array($catid));
}
else {
    $sql0 = "SELECT * FROM app_adapter_data WHERE product1=? OR product2=?";
    $rs0 = $db1->getRS($sql0, array($product1,$product1));
    $ids = "";
    for ($i = 0; $i < count($rs0); $i++) {
        if ($rs0[$i]['product1']==$product1) {
            $ids .= $rs0[$i]['product2'].",";
        }
        else {
            $ids .= $rs0[$i]['product1'].",";
        }
        
    }
    $ids = substr($ids,0,strlen($ids)-1);
    $sql = "SELECT * FROM app_products WHERE adapter_category=? AND id IN ($ids)";
    //echo $sql;
    $rs = $db1->getRS($sql, array($catid));
}


if ($rs) {
    for ($i = 0; $i < count($rs); $i++) {
        $product = new app_products($db1, $rs[$i]['id'], $rs);
        $photo = $product->photo();
        $productid = $product->get_id();
        //$codetitle = $product->item_code() . " " . $product->title();
        $codetitle = $product->title();
        echo "<div class=\"col-6\"><div class=\"af-product\" data-id=\"$productid\" >";
        echo "<h3>$codetitle</h3>";
        echo "<img src=\"$photo\" />";
        echo "</div></div>";    
    }
    echo "<div class=\"clear\"></div>";
}
