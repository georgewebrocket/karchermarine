<?php
//ini_set('display_errors',1); 
//error_reporting(E_ALL);

require_once('php/session.php');
require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
require_once('php/content.php');
require_once('php/dataobjects.php');

$breadcrumbs_str = '<ul>';
$breadcrumbs_str .= '<li><a href="home.php">Home</a>></li>';
$breadcrumbs_str .= '<li class="current-product">Product comparison</li>';;
$breadcrumbs_str .= '</ul>';

$result = "";
$alert = "<div class=\"alert-warning alert\"><p>You have not added any products to the comparison.</p></div>";


$compare_product_ids = $_SESSION['COMPARE_PRODUCT_IDS'];
if(isset($compare_product_ids)){
    if(count($compare_product_ids) > 0){$ids = implode(",", $compare_product_ids);
        $sql = "SELECT id,item_code,title,photo,short_description FROM app_products WHERE id in(".$ids.")";
        
        $rs = $db1->getRS($sql);
        $rsCompareProducts = array();
        //sort array with products
        foreach ($rs as $key => $value) {
            $product_index = array_search($value['id'], $compare_product_ids);
            $rsCompareProducts[$product_index] = $value;
        }
        ksort($rsCompareProducts);    
        
        $table_width = 0;
        $td_width = 0;
        $td_title_width = 300;
        $count_product_compare = count($compare_product_ids);
        
        switch ($count_product_compare) {
            case 1:
            case 2:
            case 3:   
                $table_width = 1260;
                $td_width = intval(1000/$count_product_compare);
                break;
            case 4:
                $table_width = 1260;
                $td_width = 250;
                break;
            default:
                $td_width = 250;
                $table_width = $count_product_compare*$td_width+$td_title_width;
                break;
        }
        
        $result = "<table id=\"table-compare-products\" style=\"width:".$table_width."px;\">";
        //header
        $result .= "<tr><td style=\"width:".$td_title_width."px;\"></td>";
        foreach ($rsCompareProducts as $key => $product) {
            $item_code = MyUtils::str_code_replace($product['item_code'], array(".","-","."), array(array(0,1),array(1,3),array(4,3),array(7,1)));
			$result .= "<td style=\"width:".$td_width."px;\"><div class=\"product-ref\"><a style=\"color: #2b2b2b;\" href=\"product/".$product['id']."\">"
                    . "<div style=\"text-align: center;\"><img style=\"height: 200px;vertical-align: middle;\" src=\"".$product['photo']."\"/></div>";
            $result .= "<div style=\"text-align: left;padding-left:10px;\"><h5 style=\"font-size: 20px;font-weight: 500;line-height: 26px; margin-bottom:10px\">"
                    . "".$product['title']."</h5><h6 style=\"margin-bottom:20px\">".$item_code."</h6></div></a>";
            $result .= "<div style=\"text-align: left; margin-bottom:30px;padding-left:10px;\"><i style=\"margin-right:10px\" class=\"fa fa-chevron-right\"></i>"
                    . "<a id=\"cpr".$product['id']."\" class=\"remove\" href=\"product-comparison.php\">remove</a></div></div>".
					'<div><span data-productid="'. $product['id'] . '" class="button-yellow items-rfq">RFQ</span> Quantity: <input type="number" class="rfq-quantity-small" min="0" max="100" value="1"></div>'
					."</td>";
        }
        $result .= "</tr>";
		
		
		
		
		
		
		
        
        //end header
        //table body
		
		//Description
		//$result .= "<tr><td >"
         //       . "<h4 style=\"margin-top: 30px;\">Description</h4></td><td></td></tr>";
        $result .= "<tr><td><h4 style=\"margin-top: 30px;\">Description</h4></td>";
        foreach ($rsCompareProducts as $key => $product) {
            $result .= "<td><div style=\"margin-top: 30px;\">".$product['short_description']."</div></td>";
        }
        $result .= "</tr>";
		
		
		
        //Technical data
        $result .= "<tr><td><h4 style=\"margin-top: 30px;\">Technical data</h4></td></tr>";
        
        $sql = "SELECT DISTINCT AA.id, AA.title "
                . "FROM app_attributes AS AA INNER JOIN app_product_attributes AS APA ON AA.id = APA.attribute_id "
                . "WHERE attr_category_id = 1 AND APA.product_id IN(".$ids.") ORDER BY APA.attr_order";
        
        $rsCompareProductAttrTD = $db1->getRS($sql);
        $i=0;
        if($rsCompareProductAttrTD){
            foreach ($rsCompareProductAttrTD as $key => $productAttrTD) {
                $i++;
                if(fmod($i,2) == 0){$class="white";}else{$class="bez";}   
                $result .= "<tr class=\"".$class."\">";
                $result .= "<td>".$productAttrTD['title']."</td>";
                foreach ($compare_product_ids as $key => $value_cpid) {
                    $sqlPrAttrTD = "SELECT APA.value, AA.attr_type_id "
                            . "FROM app_product_attributes AS APA INNER JOIN app_attributes AS AA ON APA.attribute_id = AA.id "
                            . "WHERE attribute_id=".$productAttrTD['id']." AND product_id in (".$value_cpid.")";
                    $rsPrAttrTD = $db1->getRS($sqlPrAttrTD);
                    if($rsPrAttrTD){                        
                        if($rsPrAttrTD[0]['attr_type_id'] <> "2"){
                            $result .= "<td>".$rsPrAttrTD[0]['value']."</td>";                       
                        }else{
                            $result .= "<td><i class=\"fa fa-check-circle fa-2x check-ok\"></i></td>";
                        }
                    }
                    else{
                        $result .= "<td>-</td>";
                    }
                }            
                $result .= "</tr>";
            }
        }
        
        //Equipment
        $result .= "<tr><td ><h4 style=\"margin-top: 30px;\">Equipment</h4></td></tr>";
        $sql = "SELECT DISTINCT AA.id, AA.title "
                . "FROM app_attributes AS AA INNER JOIN app_product_attributes AS APA ON AA.id = APA.attribute_id "
                . "WHERE attr_category_id = 2 AND APA.product_id IN(".$ids.") ORDER BY APA.attr_order";
        
        //standart accesories products
        //get standart accesories code for products with these $ids
        $sqlSAP_codes = "SELECT standard_accessories_ids FROM app_products WHERE id IN (".$ids.")";
        $rsSAP_codes = $db1->getRS($sqlSAP_codes);        
        if(is_array($rsSAP_codes)){
            foreach ($rsSAP_codes as $key => $rsSAP_code) {
                if($rsSAP_code['standard_accessories_ids'] != ""){
                    $arr_SAP_codes[] = $rsSAP_code['standard_accessories_ids'];
                }
            }
        }
        
        //get standart accesories id and title for products with these standart accesories ids
        if(is_array($arr_SAP_codes)){
            $str_SAP_codes = str_replace(array("[","]"),"",implode(",", $arr_SAP_codes));
            $sqlSAPs = "SELECT item_code, title FROM app_products where item_code in (".$str_SAP_codes.")";
            $rsSAPs = $db1->getRS($sqlSAPs);
        }
        $i=0;
        if(is_array($rsSAPs)){
            foreach ($rsSAPs as $key => $rsSAP) {
                $i++;
                if(fmod($i,2) == 0){$class="white";}else{$class="bez";}   
                $result .= "<tr class=\"".$class."\">";
                $result .= "<td>".$rsSAP['title']."</td>";
                foreach ($compare_product_ids as $key => $value_cpid) {
                    //check if standart accesori exist for products whith these ids
                    if($db1->getRS("SELECT id FROM app_products WHERE id = ".$value_cpid." AND standard_accessories_ids LIKE '%[".$rsSAP['item_code']."]%'")){
                        $result .= "<td><i class=\"fa fa-check-circle fa-2x check-ok\"></i></td>";
                    }else{
                         $result .= "<td>-</td>";
                    }
                }            
                $result .= "</tr>";            
            }
        }
        
        
        $rsCompareProductAttrE = $db1->getRS($sql);
        if($rsCompareProductAttrE){
            foreach ($rsCompareProductAttrE as $key => $productAttrE) {
                $i++;
                if(fmod($i,2) == 0){$class="white";}else{$class="bez";}   
                $result .= "<tr class=\"".$class."\">";
                $result .= "<td>".$productAttrE['title']."</td>";
                foreach ($compare_product_ids as $key => $value_cpid) {
                    $sqlPrAttrE = "SELECT APA.value, AA.attr_type_id "
                            . "FROM app_product_attributes AS APA INNER JOIN app_attributes AS AA ON APA.attribute_id = AA.id "
                            . "WHERE attribute_id=".$productAttrE['id']." AND product_id in (".$value_cpid.")";
                    $rsPrAttrE = $db1->getRS($sqlPrAttrE);
                    if($rsPrAttrE){                        
                        if($rsPrAttrE[0]['attr_type_id'] <> "2"){
                            $result .= "<td>".$rsPrAttrE[0]['value']."</td>";                       
                        }else{
                            $result .= "<td><i class=\"fa fa-check-circle fa-2x check-ok\"></i></td>";
                        }
                    }
                    else{
                        $result .= "<td>-</td>";
                    }
                }            
                $result .= "</tr>";            
            }
        }
        //end table body
        //footer
        //$result .= "<tr><td >"
//                . "<h4 style=\"margin-top: 30px;\">Description</h4></td><td></td></tr>";
//        $result .= "<tr><td></td>";
//        foreach ($rsCompareProducts as $key => $product) {
//            $result .= "<td><div>".$product['short_description']."</div></td>";
//        }
//        $result .= "</tr>";
        //end footer
        $result .= "</table>";
        
    }else{
        $result = $alert;
    }
}else{
    $result = $alert;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Product comparison</title>
    
    <?php include 'head.php'; ?>
</head>

<body>

	<?php include "blocks/header.php"; ?>
    
    <div class="main">   
        <div class="wraper">
            <div id="breadcrumbs">
                <?php echo $breadcrumbs_str; ?>
            </div>
            <div class="col-12">
                <h1>Product comparison</h1>
            </div>
            <div  style="margin: 90px 0px 40px;">
                <!--<a class="button btn1 return" href="javascript:history.go(-1)"><i class="fa fa-chevron-left"></i>return to previous page</a>-->
            </div>      
            <div id="product-comparison">
                <?php echo $result; ?>
            </div>            
        </div>
    </div>
    
    <?php include "blocks/footer.php"; ?>
    
    <script>
    
    $(function() {
		$('.items-rfq').click(function(e) {		
		e.preventDefault();
		var itemid = $(this).data('productid');
		var quantity = $(this).parent().find('.rfq-quantity-small').val();
		msg = 'The item was added to RFQ list';
		AddProductToRFQList(itemid, quantity, 1, msg);		
	});
	});
    
    
    </script>


</body>
</html>