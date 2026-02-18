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

//$id = $_GET['id'];

$post = new wp_post($db1, $id, conn1::$tprefix);
$title = $post->get_custom_field('H1');
$shortDescription = $post->get_custom_field('SUBTITLE');
$featuredImage = $post->get_feature_image();
$content = $post->get_post_content();
$content = content::richcontent($content);
$breadcrumbs_str = content::breadcrumbs('wp', $post);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $post->get_custom_field('SEO-PAGE-TITLE'); ?></title>
	<meta name="Description" content="<?php echo $post->get_custom_field('SEO-PAGE-DESCRIPTION'); ?>" />
    
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
                </div>
            </div>
        </div>
    </div>
    
    <?php include "blocks/footer.php"; ?>
</body>
</html>

