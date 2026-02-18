<?php

/*ini_set('display_errors',1); 
error_reporting(E_ALL);*/

require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
//require_once('php/session.php');
require_once('php/content.php');

$post = new wp_post($db1, $id, conn1::$tprefix);
$title = $post->get_custom_field('H1');
$shortDescription = $post->get_custom_field('SUBTITLE');
$featuredImage = $post->get_feature_image();
$content = $post->get_post_content();
$content = content::richcontent($content);
$breadcrumbs_str = content::breadcrumbs('wp', $post);

$news = new wp_category($db1, $catid, conn1::$tprefix, "post_date DESC");
$sql = $news->get_sql();
//echo $sql;
$nrOfRows = 10;
$curpage = $url2 != ''? $url2: 0;
$link = app::$host."news/";
$rspage = new RS_PAGE($db1, $sql, "", "", $nrOfRows, $curpage, NULL, $link);
$rs = $rspage->getRS();
//print_r($rs);
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
    
    <style></style>
    
    <script>
    
    
    
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
                <?php echo $shortDescription; ?>
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
					if ($rs) {
					for ($i=0;$i<count($rs);$i++) {
						$newspost = new wp_post($db1, $rs[$i]['ID'], conn1::$tprefix, $rs);
					?>
                    <div class="col-3 col-sm-12">
                    	<div class="col-11 col-sm12"><img src="<?php echo $newspost->get_feature_image(); ?>" style="width:100%; height:auto" /></div>
                        	
                    </div>
                    
                    <div class="col-9 col-sm-12">
                    	<div style="margin-bottom:10px; color:rgb(150,150,150)"><?php echo $newspost->get_post_date(); ?></div>
                        <div style="font-weight:bold; font-size:16px; margin-bottom:10px; color:rgb(70,70,70)""><?php echo $newspost->get_post_title(); ?></div>
                        <div style="margin-bottom:10px"><?php echo $newspost->get_post_excerpt(); ?></div>
                        <div><a href="post.php?id=<?php echo $newspost->get_id(); ?>">MORE</a></div>
                    </div>
                    
                    <div style="clear:both; height:20px"></div>
                    
                    <?php
					}}
					?>
                    
                    <?php 
					
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
                    
                </div>
            </div>
        </div>
    </div>
    
    <?php include "blocks/footer.php"; ?>
</body>
</html>

