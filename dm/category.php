<?php

ini_set('display_errors',1); 
error_reporting(E_ALL);

require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
require_once('php/session.php');
require_once('php/content.php');
require_once('php/dataobjects.php');

//$id = $_GET['id'];
if (isset($_GET['id'])) { $id = $_GET['id']; }
$cat = new app_categories($db1, $id);

$title = $cat->title();
$shortdescr = $cat->short_description();
$content = $cat->description();
$content = content::richcontent($content, $id);
$featuredImage = $cat->photo();

/*============ begin breadcrumbs ================*/
$sql = "SELECT id, title AS name, parent_id FROM  app_categories";

$cat_view = new categories_view($db1,$sql,0,0);
if($cat->parent_id() > 0){
    $breadcrumbs = $cat_view->display_parent_nodes($cat->parent_id(), TRUE);
}else{
    $breadcrumbs = Array();
}
$breadcrumbs_str = '';
$breadcrumbs_str = '<ul>';
$breadcrumbs_str .= '<li><a href="home.php">Home</a>></li>';
foreach ($breadcrumbs as $key => $value) {
    $breadcrumbs_str .= '<li><a href="category/'.$breadcrumbs[$key]['id'].'">'.$breadcrumbs[$key]['name'].'</a>></li>';
}
$breadcrumbs_str .= '<li class="current-product">'.$title.'</li>';;
$breadcrumbs_str .= '</ul>';
/*============ end breadcrumbs ================*/

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    
    <?php include 'head.php'; ?>

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
                <?php echo $shortdescr; ?>
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