<?php

//ini_set('display_errors',1); 
//error_reporting(E_ALL);

require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
require_once('php/session.php');

//if(isset($_GET['cat_id'])){$cat_id = $_GET['cat_id'];}
$cat_id=9;
$category = new wp_category($db1, $cat_id, conn1::$tprefix);
$sql = $category->get_sql();
$rs = $db1->getRS($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>kaercher-marine</title>
    <?php include 'head.php'; ?>
    
    <style>
        .wraper{
            width: 1260px;
            margin: 0 auto;
        }
        .feature_image {
/*            width: 317px;
            height: 317px;*/
            width: 100%;
        }
        .compare{
            height: 44px;
            text-align: right;
        }
        .product{
            padding: 5px 3px 50px;
        }
        .product-info{
            padding: 10px;
        }        
    </style>
    <script type="text/javascript">
    $(function() {
    
        $('.chk-compare').change(function() {
            var prodauctId;
            if($( this ).is(':checked')){
                prodauctId = $( this ).val();
                prodauctAddRemoveId(prodauctId,'add')
            }else{
                prodauctId = $( this ).val();
                prodauctAddRemoveId(prodauctId,'remove')
            }
        });
        
    });
    
    $(function() {
        $('#count-compare').text(<?php echo count($_SESSION['Ids']); ?>);
        $('#count-compare').show('slow')       
    });
    
    function prodauctAddRemoveId(id, addRemove) {        
        $.post( "compare.php", 
                { 
                id: id,
                addRemove: addRemove
                })
        .done(function( data ) {
            $('#count-compare').text(data);
            if($('#count-compare').text() != ''){
                $('#count-compare').show('slow')
            }
        });
    }
    
    </script>
    
</head>

<body>
    <?php include "blocks/header.php"; ?>
        
    <div class="main">
        <div class="wraper">
            <div class="col-12">
                <a></a>
                <hr>
            </div>
            <div class="col-12">

        <?php
                    if ($rs) {
                    $div = -1;
                    for ($i=0;$i<count($rs);$i++) {
                            $div = $i;
                            $post = new wp_post($db1, $rs[$i]['ID'], conn1::$tprefix, $rs);
                            if (fmod($i,4) == 0) {echo '<div class="col-12">';}
                            $postId = $post->get_id();

                   ?>
                    <div class="col-3">
                        <div class="product">
                            <div>
                                <img class="feature_image" src="<?php echo $post->get_feature_image(); ?>"/>
                            </div>
                            <div class="product-info">
                                <div>
                                    <h2><?php echo $post->get_post_title(); ?></h2>
                                </div>
                                <div class="compare">
                                    <label><input class="chk-compare" type="checkbox" 
                                                  name="Compare<?php echo $postId; ?>" value="<?php echo $postId; ?>" 
                                                   <?php if(isset($_SESSION['Ids'])){ if(in_array($postId, $_SESSION['Ids'])){ echo 'checked';}} ?>>Compare</label>
                                </div>
                                <div>
                                    <p><?php echo $post->get_post_excerpt(); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

            <?php
                            if (fmod($i,4) == 3) {echo '</div>';}

                        }
                        if (fmod($div,4) <> 3 && $div <> -1){echo '</div>';}
                    }
                    ?>
            </div>
        </div>
    </div>
    <?php include "blocks/footer.php"; ?>
</body>
</html>
