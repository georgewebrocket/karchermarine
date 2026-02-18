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

$id = 0;
if(isset($_GET['id'])){$id = $_GET['id'];}

$post = new wp_post($db1, $id, conn1::$tprefix);

/*============ breadcrumbs ================*/
if(count($post->get_post_categories_ids()) > 0){
    $cat_id = $post->get_post_categories_ids()[0];
}else{
    $cat_id = 0;
}

$sql = "SELECT B5iyk_terms.term_id AS id, B5iyk_terms.name, B5iyk_term_taxonomy.parent AS parent_id FROM  B5iyk_term_taxonomy "
        . " INNER JOIN B5iyk_terms on B5iyk_term_taxonomy.term_id = B5iyk_terms.term_id WHERE  taxonomy =  'category'";

$cat_view = new categories_view($db1,$sql,0,0);
$breadcrumbs = $cat_view->display_parent_nodes($cat_id, TRUE);
$breadcrumbs_str = '';
$breadcrumbs_str = '<ul>';
$breadcrumbs_str .= '<li><a href="home.php">Home</a></li>';
/*foreach ($breadcrumbs as $key => $value) {
    $breadcrumbs_str .= '<li><a href="wpcategory/'.$breadcrumbs[$key]['id'].'">'.$breadcrumbs[$key]['name'].'</a>></li>';
}*/

//$mycat = $_REQUEST['cat'];
//$mycatlink = $_REQUEST['catlink'];

$mycatdescr = "";
$mycatlink = "";

$catids = $post->get_post_categories_ids();
$mycat = $catids[0];

switch ($mycat) {
	case 28:
		$mycatdescr = "News";
		$mycatlink = "news";
		break;
	default:
		break;
}

$breadcrumbs_str .= "<li><a href=\"$mycatlink\">$mycatdescr</a></li>";

$breadcrumbs_str .= '<li class="current">'.$post->get_custom_field('H1').'</li>';;
$breadcrumbs_str .= '</ul>';
/*============ end breadcrumbs ================*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>kaercher-marine</title>
    <?php include 'head.php'; ?>
    
    <style>
        
        
    </style>
</head>

<body>
    <?php include "blocks/header.php"; ?>
        
    <div class="main">
        <div id="ribbon">
            <div class="wraper">
                <div id="breadcrumbs">
                    <?php echo $breadcrumbs_str; ?>
                </div>
                <h1><?php echo $post->get_custom_field('H1'); ?></h1>
            </div>
        </div>
        <div class="wraper">
            <div class="post-mar-bottom4">
                <div class="post-image post-mar-bottom">
                    <img src="<?php echo $post->get_feature_image(); ?>"/>
                </div>
                <div class="post-content post-mar-bottom5">
                    <?php 
					//echo str_replace("\r\n","<br/>",$post->get_post_content()); 
					$content = content::richcontent($post->get_post_content());
					echo $content;
					?>
                </div>
            </div>
        </div>
    </div>
    
    <?php include "blocks/footer.php"; ?>
</body>
</html>

