<?php
require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
require_once('php/content.php');
require_once('php/dataobjects.php');

$product1 = $_REQUEST['product1'];
$product2 = $_REQUEST['product2'];
$sql = "SELECT * FROM app_adapter_data WHERE (product1=? AND product2=?)"
        . " OR (product1=? AND product2=?)";
$rs = $db1->getRS($sql,array($product1,$product2,$product2,$product1));
//var_dump($rs);
if ($rs) {
    $adapterid = $rs[0]['adapter'];
    if ($adapterid!=0) {
        $adapter = new app_products($db1, $adapterid);    
        $photo = $adapter->photo();
        $item_code = MyUtils::str_code_replace($adapter->item_code(), array(".","-","."), array(array(0,1),array(1,3),array(4,3),array(7,1)));
        $title = $adapter->title();
        $normdescr = func::normURL($adapter->title());
        $link = app::$host . "product/" . $adapterid . "/" . $normdescr;

        echo "<div class=\"col-12\"><div class=\"af-adapter-product\" data-id=\"$adapterid\" >";    
        echo "<img src=\"$photo\" />";
        echo "<a href=\"$link\"><h2>$title</h2></a>";
        echo "<a href=\"$link\"><h3>Order number: $item_code</h3></a>";
        echo "</div></div>"; 
        echo "<div class=\"af-adapter-link\">";    
        echo "<a href=\"$link\">VIEW DETAILS</a></div>";
        echo "</div>"; 
    }
    else {
        echo "<div class=\"col-12\"><div class=\"af-adapter-product\" data-id=\"$adapterid\" >"; 
        echo "No adapter is required in this combination.";
        echo "</div>";
    }
}
echo "<div class=\"clear\"></div>";