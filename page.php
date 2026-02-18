<?php
/*
ini_set('display_errors',1); 
error_reporting(E_ALL);*/

require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
//require_once('php/session.php');
require_once('php/content.php');
require_once('php/dataobjects.php');

$id = $id>0? $id: $_GET['id'];

$post = new wp_post($db1, $id, conn1::$tprefix);
$title = $post->get_custom_field('H1');
$shortDescription = $post->get_custom_field('SUBTITLE');
$featuredImage = $post->get_feature_image();
$content = $post->get_post_content();
$content = content::richcontent($content);

if ($post->get_custom_field("BREADCRUMBS")=="") {
    $breadcrumbs_str = content::breadcrumbs('wp', $post);
}
else {
    $ar = explode("====", $post->get_custom_field("BREADCRUMBS"));
    $breadcrumbs_str = "<ul><li><a href=\"".HOST."\">Home</a></li>";
    for ($i = 0; $i < count($ar); $i++) {
        $details = explode("==",$ar[$i]);
        $bcText = $details[0];
        if (count($details)>1) {
            $bcLink = $details[1];
            $bc = "<li><a href=\"$bcLink\">$bcText</a></li>";
        }
        else {
            $bc = "<li>$bcText</li>";
        }
        $bcLink = count($details)>1? $details[1]: "";
        $breadcrumbs_str .= $bc;
    }
    $breadcrumbs_str .= "</ul>";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $post->get_custom_field('SEO-PAGE-TITLE'); ?></title>
    <meta name="Description" content="<?php echo $post->get_custom_field('SEO-PAGE-DESCRIPTION'); ?>" />
	<meta name="Keywords" content="<?php echo $post->get_custom_field('SEO-PAGE-KEYWORDS'); ?>" />
    
    <meta property="og:title" content="<?php echo $post->get_custom_field('SEO-PAGE-TITLE'); ?>" />
    <meta property="og:image" content="<?php echo $post->get_feature_image(); ?>" />
	<meta property="og:image:url" content="<?php echo $post->get_feature_image(); ?>" />
	<meta property="og:description" content="<?php echo $post->get_custom_field('SEO-PAGE-DESCRIPTION'); ?>" />
    
	<?php include 'head.php'; ?>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <style>
    .ui-tooltip, .arrow:after {
        background: #ffed00;
        border: 1px solid rgb(200,200,200);
    }
    .ui-tooltip {
        padding: 10px;
        color: black;
        border-radius: 1px;
        font: bold 14px "Helvetica Neue", Sans-Serif;
        /*text-transform: uppercase;*/
        border: 1px solid rgb(200,200,200);
        box-shadow: none;
    }
    .arrow {
        width: 70px;
        height: 16px;
        overflow: hidden;
        position: absolute;
        left: 50%;
        margin-left: -35px;
        bottom: -16px;
    }
    .arrow.top {
        top: -16px;
        bottom: auto;
    }
    .arrow.left {
        left: 20%;
      }
    .arrow:after {
        content: "";
        position: absolute;
        left: 20px;
        top: -20px;
        width: 25px;
        height: 25px;
    /*    box-shadow: 6px 5px 9px -9px black;*/
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
    .arrow.top:after {
        bottom: -20px;
        top: auto;
    }
  
    .tooltip {
        cursor:pointer;
    }
        
        
    </style>    
    <script></script>
    
    <script>
    $(function() {
        $(".tooltip").tooltip({
      position: {
        my: "center bottom-20",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      }
    });
    });
    </script>
    
    
</head>

<body>
    <?php include "blocks/header.php"; ?>
        
    <div class="main">
        <div id="ribbon">
            <div class="wraper">
                <div id="breadcrumbs">
                    <?php echo $breadcrumbs_str; ?>
                </div>
                <h1><?php echo $title; ?></h1>
                <div style="max-width: 900px; line-height: 20px;">
                    <?php echo $shortDescription; ?>
                </div>
            </div>
        </div>
        <div class="wraper">
            <div class="post-mar-bottom4">
                <?php if ($featuredImage!='') { ?>
                <div class="post-image post-mar-bottom">
                    <img src="<?php echo $featuredImage; ?>"/>
                </div>
                <?php } ?>
                <div class="post-content post-mar-bottom5">
                    <?php echo $content; ?>
                    
                    <?php 
                    if ($post->get_custom_field("FIND-ADAPTER")!="") { 
                        include "_findadapter.php";
                    }
                    ?> 
                    
                </div>
            </div>
        </div>
    </div>
    
    <?php include "blocks/footer.php"; ?>
</body>
</html>

