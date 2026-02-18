<?php

//ini_set('display_errors',1); 
//error_reporting(E_ALL);

require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
require_once('php/session.php');
require_once('php/content.php');
require_once('php/dataobjects.php');

$inc_product_ids = "0";
$inc_product_codes = "0";
$inc_category_id = "0";
$inc_query = "";
$inc_extra_products = "";
$product_inc = "";
$container = "";
$order_by = " ORDER BY clicks_counter DESC";
$class_compare = "compare";
$arr_compare_product_ids = array();
$compare_product_ids = "";
$sort_by = "popular";
$class_sort_title="";$class_sort_popularity="sort-active";


$myurl = '';

if(isset($_GET['PRODUCT-INC'])){ $product_inc = $_GET['PRODUCT-INC'];}
if($product_inc !=""){
    switch ($product_inc){
        case "accessories":
            $container = "container-accessories";
            break;
        case "cleaning_agents":
            $container = "container-cleaning-agents";
            break;
        case "related_product":
            $container = "container-related-product";
            break;    
    }
}

//for products sort------begin

if(isset($_POST['COMPARE_PRODUCT_IDS'])){
    $compare_product_ids = $_POST['COMPARE_PRODUCT_IDS'];
    $arr_compare_product_ids = explode(",", $compare_product_ids);
}

if(isset($_POST['SORT'])){
    $sort_by = $_POST['SORT'];
    switch ($sort_by){
        case "title":
            $order_by = " ORDER BY title";
            $class_sort_title="sort-active";$class_sort_popularity="";
            break;
        case "popular":
            $order_by = " ORDER BY clicks_counter DESC";
            $class_sort_title="";$class_sort_popularity="sort-active";
            break;
        default :
            
    }
//    if($_POST['SORT'] == "title"){$order_by = " ORDER BY title";}
}

//if(isset($_POST['SORT'])){
//    if($_POST['SORT'] == "popular"){$order_by = " ORDER BY clicks_counter DESC";}
//}

if(isset($_POST['CATEGORY_ID'])){
    $inc_category_id = $_POST['CATEGORY_ID'];  
    $inc_query = " WHERE active=1 AND category_id = ".$inc_category_id;
	$nrOfRows = 10000;
}
//for products sort------end

if(isset($_GET['EXTRA_PRODUCTS'])){
    $inc_extra_products = $_GET['EXTRA_PRODUCTS'];
}

if(isset($_GET['PRODUCT_IDS'])){
    $inc_product_ids = $_GET['PRODUCT_IDS'];
    $inc_query = " WHERE active=1 AND id IN (".$inc_product_ids.")";
}

if(isset($_GET['PRODUCT_CODES'])){
    $inc_product_codes = $_GET['PRODUCT_CODES'];
    $inc_query = " WHERE active=1 AND item_code IN (".$inc_product_codes.")";
	$myurl = app::$host.'products-inc.php?PRODUCT_CODES='.$inc_product_codes.'&EXTRA_PRODUCTS=extra&PRODUCT-INC='.$product_inc.'&page=';
	$nrOfRows = 8;
}

if(isset($_GET['CATEGORY_ID'])){
    $inc_category_id = $_GET['CATEGORY_ID'];  
    $inc_query = " WHERE active=1 AND category_id = ".$inc_category_id;
	$nrOfRows = 10000;
}

if(isset($_POST['t_search'])){
    $inc_search = $_POST['t_search'];  
    $inc_query = " WHERE active=1 AND (item_code LIKE '%$inc_search%' OR title LIKE '%$inc_search%' OR category_id IN (SELECT id FROM app_categories WHERE title LIKE '%$inc_search%'))";
	$nrOfRows = 10000;
}

$sql = "SELECT * FROM app_products ".$inc_query.$order_by;
//$rs = $db1->getRS($sql);

if (isset($_GET['page'])) {$curpage = $_GET['page'];}else{$curpage = 0;}
$link = $myurl;
$rspage = new RS_PAGE($db1, $sql, "", "", 
	$nrOfRows, $curpage, NULL, $link);
$rspage->set_pageSClass("paginate paginate-$product_inc");
$rspage->setPrev("<span class=\"fa fa-arrow-left\"></span>");
$rspage->setNext("<span class=\"fa fa-arrow-right\"></span>");
$rs = $rspage->getRS();

if ($rs) {
    if($inc_category_id > 0){
    echo "<div id=\"products-container\">";
    //echo "COMPARE_PRODUCT_IDS - ". implode(",", $_SESSION['COMPARE_PRODUCT_IDS']);
    echo "<div>";    
    echo "<div id=\"btn-sort-title\" class=\"".$class_sort_title."\"> by name</div><div class=\"sort-sep\">|</div>";
    echo "<div id=\"btn-sort-popular\" class=\"".$class_sort_popularity."\">sort by popularity</diva>";    
    echo "</div>";
    echo "<div style=\"clear:both;\"></div>";
    echo "<div style=\"padding-top: 7px;\" class=\"line\"></div>";
    
    }

    $rs_products = array_chunk($rs, 4);

    for ($i=0;$i<count($rs_products);$i++) {
        echo '<div class="col-12">';
        foreach ($rs_products[$i] as $key => $rs_product) {
            $id = $rs_product['id'];
            $title = $rs_product['title'];
            $arrWithReplacement = array(".","-",".");
            $arrPossitions = array(array(0,1),array(1,3),array(4,3),array(7,1));
            //$itemcode = $rs_product['item_code'];
            $itemcode = MyUtils::str_code_replace($rs_product['item_code'], 
            $arrWithReplacement, $arrPossitions);
            $photo = $rs_product['photo'];
            $short_description = $rs_product['short_description'];
            $normdescr = func::normURL($rs_product['title']);

            ?>
            <div class="col-3 col-sm-6 sort">
                <div class="product-ref">
                    <a class="<?php echo $inc_extra_products; ?>" href="<?php echo app::$host; ?>product/<?php echo $id."/".$normdescr; ?>">
                        <div class='product-ref-image'>
                            <img class="feature_image" src="<?php echo $photo; ?>"/>
                        </div>
                        <div class="product-ref-title">
                            <?php if($inc_extra_products === 'extra'){echo "<h5>".$title."</h5><h6>$itemcode</h6>";}else{echo "<h2>".$title."</h2><h3>$itemcode</h3>";} ?>
                            <div style="display: none;" class="sort-title"><?php echo $title; ?></div>
                            <div style="display: none;" class="sort-popular"><?php echo $counter_click; ?></div>
                        </div>
                    </a>
                        <div class="compare-container">
                            <?php if (in_array($id, $arr_compare_product_ids)){$class_compare = 'active-compare';}else{$class_compare = 'compare';} ?>
                            <div class="<?php echo $class_compare; ?>">
                                <label><input class="chk-compare" type="checkbox" 
                                    name="Compare<?php echo $id; ?>" value="<?php echo $id; ?>" <?php if (in_array($id, $arr_compare_product_ids)){echo 'checked';} ?>>Compare</label>
                            </div>
                        </div>
                    
                    <a href="<?php echo app::$host; ?>product/<?php echo $id; ?>">
                        <div class="product-ref-description">
                           <p><?php if($inc_extra_products != 'extra'){echo "".$short_description."";} ?></p>
                        </div> 
                        <div class="detail-container">
                            <div class="detail" style="cursor:default; text-align:center"> 
                                <a href="<?php echo app::$host; ?>product/<?php echo $id."/".$normdescr; ?>">
                                VIEW DETAILS
                                </a>
                                <div>
                                <span data-productid="<?php echo $id; ?>" class="button-yellow items-rfq">RFQ</span> Quantity: <input type="number" class="rfq-quantity-small" min="0" max="100" value="1">
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <?php
        }
        echo '</div>';
    }
    echo '<div style="clear:both;"></div>';
}


echo '<div class="extra-products-slides-pg">';
if ($rspage->getCount() > $nrOfRows){
	echo "<div class=\"paginate-prev\">";
	$rspage->getPrev();
	echo "</div>";
	echo $rspage->getPageLinks();
	echo "<div class=\"paginate-next\">";
	$rspage->getNext();
	echo "</div>";
}
echo '</div>';
	
?>            
<div style="clear:both; height:40px"></div>
<script>
$(function() {
    var w = window.innerWidth;
	$(".paginate-<?php echo $product_inc; ?>").click(function(e){
            e.preventDefault();
			var url = $(this).attr("href");
			//console.log(url);
            $.post( url, 
                    { 
                    page : url
                    })
            .done(function( data ) {
                console.log(data);
				$('.<?php echo $container; ?>').html(data);
            });
        });
    //.....
	$(".product-ref").unbind();
	$(".product-ref").hover(
		function(){
			  //mouse over
			  if (w>960) {
				  $(this).find(".compare").addClass('active-compare').removeClass('compare');
				  $(this).find(".detail").css('opacity','1');
				  $(this).find(".detail").css("background-color", "#FFED00");
				  $(this).css("border", "3px solid #FFED00");
			  }
		}
		,function(){
			//mouse out
			if (w>960) {
				if(!$(this).find(".chk-compare").is(':checked')){
					$(this).find(".active-compare").addClass('compare').removeClass('active-compare');
				}
				$(this).find(".detail").css('opacity','0');
				$(this).css("border", "3px solid transparent");
			}
		}
	   );        
	//..... 
	$('.chk-compare').unbind();
	$('.chk-compare').click(function() {
		var prodauctId;
		if($( this ).is(':checked')){
			prodauctId = $( this ).val();
			$( this ).parent().parent().addClass('active-compare').removeClass('compare');
			prodauctAddRemoveId(prodauctId,'add');
		}
		else{
			prodauctId = $( this ).val();
			prodauctAddRemoveId(prodauctId,'remove');
		}
	});
	//.....
	$( "a.product-addcompare").unbind();
	$( "a.product-addcompare").click(function( event ) {
	   var prodauctId = $(this).attr('id').substring(3);
		prodauctAddRemoveId(prodauctId,'add');
	});
	//......
	$('.items-rfq').unbind();
	$('.items-rfq').click(function(e) {		
		e.preventDefault();
		var itemid = $(this).data('productid');
		var quantity = $(this).parent().find('.rfq-quantity-small').val();
		msg = 'The item was added to RFQ list';
		AddProductToRFQList(itemid, quantity, 1, msg);		
	});
	//....
	$('.detail').unbind();
	$('.detail').click(function(e) {
		e.preventDefault();
	});
        
        
        $('#btn-sort-popular').on('click', function(){
           $("#products-container").load(
                "products-inc.php",
                {
                  CATEGORY_ID: <?php echo $inc_category_id; ?>,
                  SORT: 'popular',
                  COMPARE_PRODUCT_IDS: get_compare_ids()
                }
              );
        });
        
        $('#btn-sort-title').on('click', function(){
            $("#products-container").load(
                "products-inc.php",
                {
                  CATEGORY_ID: <?php echo $inc_category_id; ?>,
                  SORT: 'title',
                  COMPARE_PRODUCT_IDS: get_compare_ids()
                }
             );
        });
        
        
});
function get_compare_ids() {
    var arr_compare_ids = new Array();
    var str_compare_ids = "";
    $(".chk-compare").each(function(){
        if ($(this).is(':checked')) {
            arr_compare_ids.push($(this).val());
        }
    });
    str_compare_ids = arr_compare_ids.toString();
    return str_compare_ids;
}
</script>