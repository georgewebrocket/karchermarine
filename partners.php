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

$id = 516;

$post = new wp_post($db1, $id, conn1::$tprefix);
$title = $post->get_custom_field('H1');
$shortDescription = $post->get_custom_field('SUBTITLE');
$featuredImage = $post->get_feature_image();
$content = $post->get_post_content();
$content = content::richcontent($content);
$breadcrumbs_str = content::breadcrumbs('wp', $post);

$partners = explode("====", $post->get_custom_field('PARTNERS'));

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
                    
                    <div class="partners">
                    	
                        <?php 
						$div = -1;
						for ($i=0;$i<count($partners);$i++) { 
						$div = $i;
						if (fmod($i,3) == 0) {echo '<div class="col-12">';}
						$partner = func::clearHtml($partners[$i]);
						$partner_parts = explode("==",$partner);
						$partner_img = trim($partner_parts[0]); 
						$partner_title = trim($partner_parts[1]); 
						$partner_text = trim($partner_parts[2]);
							echo '<div class="col-4 col-sm-12">';
								echo '<div class="partner" style="height:100px; padding-bottom:20px;">';
									echo '<div class="col-4">';
										echo '<img src="'.$partner_img.'"/>';
									echo '</div>';
									echo '<div class="col-8">';
										echo '<p style="font-weight: bold;">'.$partner_title.'</p>';
										echo '<p>'.$partner_text.'</p>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						if (fmod($i,3) == 2) {echo '</div>';}
					}
                        if (fmod($div,3) <> 2 && $div <> -1){echo '</div>';}
                        ?>
                    
                    </div>
                    
                    <div style="clear:both; height:100px"></div>
                    
                    
                </div>
            </div>
        </div>
    </div>
    
    <?php include "blocks/footer.php"; ?>
</body>
</html>

