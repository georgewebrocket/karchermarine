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

if(isset($_GET['EXTRA_PRODUCTS'])){
    $inc_extra_products = $_GET['EXTRA_PRODUCTS'];
}

if(isset($_GET['PRODUCT_IDS'])){
    $inc_product_ids = $_GET['PRODUCT_IDS'];
    $inc_query = " WHERE id IN (".$inc_product_ids.")";
    
}

if(isset($_GET['PRODUCT_CODES'])){
    $inc_product_codes = $_GET['PRODUCT_CODES'];
    $inc_query = " WHERE item_code IN (".$inc_product_codes.")";
    
    $myurl = app::$host.'products-inc.php?PRODUCT_CODES='.$inc_product_codes.'&EXTRA_PRODUCTS=extra&PRODUCT-INC='.$product_inc.'&page=';
    //$myurl = 'products-inc.php?PRODUCT-INC='.$product_inc.'&page=';
}

if(isset($_GET['CATEGORY_ID'])){
    $inc_category_id = $_GET['CATEGORY_ID'];  
    $inc_query = " WHERE category_id = ".$inc_category_id;
}

$sql = "SELECT * FROM app_products ".$inc_query;

$nrOfRows = 8;
if (isset($_GET['page'])) {$curpage = $_GET['page'];}else{$curpage = 0;}
$link = $myurl;
$rspage = new RS_PAGE($db1, $sql, "", "", 
	$nrOfRows, $curpage, NULL, $link);
$rs = $rspage->getRS();


?>
<script>
$(function() {
    $(".paginate").each(function(){            
        var url = $(this).attr("href");
        $(".paginate").click(function(e){
            e.preventDefault();
            $.post( "<?php echo $myurl; ?>", 
                    { 
                    page : url
                    })
            .done(function( data ) {
                $('#<?php echo $container; ?>').html(data);
            });
        });
    });
//    $(".paginate").each(function(){
//        var page = $(this).attr("href");
//        $(".paginate").click(function(e){
//            e.preventDefault();
//            $.ajax({    
//                type: "GET",
//                url: <?php //echo $myurl; ?>,
//                data: "page=" + page, 
//                success: function(data) {
//                      // data is ur summary
//                     $('#<?php //echo $container; ?>').html(data);
//                }
//            });
//        });
//    });
});
    
</script>
<?php
if ($rs) {
    $array8 = array_chunk($rs, 8);
    foreach ($array8 as $key => $value8) {
        $array8[$key] = array_chunk($value8, 4);
    }
    
    echo "<div class=\"extra-products-slides\">";
    foreach ($array8 as $key => $value_li) {
        echo '<div>';
        foreach ($value_li as $key => $value_col12) {
            echo '<div class="col-12">';
            foreach ($value_col12 as $key => $value_col3) {
                $id = $value_col3['id'];
                $title = $value_col3['title'];
                $photo = $value_col3['photo'];
                $short_description = $value_col3['short_description'];
                echo '<div class="col-3">';
                ?>
                <div class="product-ref">
                    <a class="<?php echo $inc_extra_products; ?>" href="<?php echo app::$host; ?>product.php?id=<?php echo $id; ?>">
                        <div class='product-ref-image'>
                            <img class="feature_image" src="<?php echo $photo; ?>"/>
                        </div>
                        <div class="product-ref-title">
                            <?php if($inc_extra_products === 'extra'){echo "<h6>".$title."</h6>";}else{echo "<h2>".$title."</h2>";} ?>
                        </div>
                    </a>
                        <div class="compare-container">
                            <div class="compare">
                                <label><input class="chk-compare" type="checkbox" name="Compare<?php echo $id; ?>" value="<?php echo $id; ?>">Compare</label>
                            </div>
                        </div>
                    <a href="<?php echo app::$host; ?>product.php?id=<?php echo $id; ?>">
                        <div class="product-ref-description">
                           <p><?php if($inc_extra_products != 'extra'){echo "".$short_description."";} ?></p>
                        </div>   
                        <div class="detail-container">
                            <div class='detail'>
                                VIEW DETAILS
                            </div>
                        </div>
                    </a>
                </div>
                <?php echo '</div>';
            }
            echo '</div>';
        }
        echo '</div>';
    }
    echo '<div class="extra-products-slides-pg">';
    if ($rspage->getCount() > $nrOfRows){
        echo $rspage->getPrev();
        echo $rspage->getPageLinks();
        echo $rspage->getNext();
    }
    echo '</div>';
    echo "</div>";
}
?>

<div style="clear:both; height:40px"></div>