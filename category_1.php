<?php
/*
ini_set('display_errors',1); 
error_reporting(E_ALL);
*/
require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
//require_once('php/session.php');
require_once('php/content.php');
require_once('php/dataobjects.php');
require_once('abeautifulsite/SimpleImage.php');

//$id = $_GET['id'];
if (isset($_GET['id'])) { $id = $_GET['id']; }
$cat = new app_categories($db1, $id);

$title = $cat->title();
$shortdescr = $cat->short_description();
$content = $cat->description();
//echo "category-curpage=".$curpage;
$content = content::richcontent($content, array($id, $curpage, $sort));
$featuredImage = $cat->photo();

if ($featuredImage!='') {
	try {
		$fbimg = app::$host . 'fbimgcat/'.$id.'.gif';
		if (!file_exists($fbimg)) {
			$imgAr = explode("/",$featuredImage);
			for ($i=1;$i<count($imgAr);$i++) {
				$imgAr[$i] = rawurlencode($imgAr[$i]);
			}
			$myImage = implode("/", $imgAr); 
			$img = new abeautifulsite\SimpleImage($myImage);
			$img->best_fit(600, 300)->save('fbimgcat/'.$id.'.gif');
		}
		
	} catch(Exception $e) {
		//echo 'Error: ' . $e->getMessage();
	}
}


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
$breadcrumbs_str .= '<li><a href="'.app::$host.'">Home</a></li>';
foreach ($breadcrumbs as $key => $value) {
    $friendlyUrl = func::normURL($breadcrumbs[$key]['name']);
	$anchorTitle = $breadcrumbs[$key]['name'];
	$breadcrumbs_str .= '<li><a title="'.$anchorTitle.'" href="category/'.$breadcrumbs[$key]['id']."/".$friendlyUrl.'">'.$breadcrumbs[$key]['name'].'</a></li>';
}
$breadcrumbs_str .= '<li class="current-product">'.$title.'</li>';;
$breadcrumbs_str .= '</ul>';
$altImgTxt = strip_tags($breadcrumbs_str);
$ar = explode(">", $altImgTxt);
array_shift($ar);
$altImgTxt = implode("-", $ar);


$seoTitle = "Karcher Marine "; $seoDescription = ""; $seoKeywords = "";
for ($i=0; $i<count($breadcrumbs);$i++) {
	$seoTitle .= $breadcrumbs[$i]['name']. " ";
	$seoDescription .= $breadcrumbs[$i]['name']. " ";
	$seoKeywords .= $breadcrumbs[$i]['name']. ", ";
}
$seoTitle .= $title;
$seoDescription .= $title;
$seoKeywords .= $title;


/*============ end breadcrumbs ================*/


?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $seoTitle; ?></title>
    
    <meta name="Description" content="<?php echo $seoDescription . " " . $shortdescr; ?>" />
	<meta name="Keywords" content="<?php echo $seoKeywords; ?>" />
    
    <meta property="og:title" content="<?php echo $seoTitle; ?>" />
    <meta property="og:image" content="<?php echo $featuredImage; ?>" />
	<meta property="og:image:url" content="<?php echo $featuredImage; ?>" />
	<meta property="og:description" content="<?php echo $seoDescription . " " . $shortdescr; ?>" />
    
    <?php include 'head.php'; ?>
    
    <script>
    
	var pagetypeproduct = false;
    
    </script>

</head>

<body>

	<?php include "blocks/header_1.php"; ?>
    
    <div class="main">
        <div id="ribbon" style="background-color: #fff">
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
                    <img src="<?php echo $featuredImage; ?>" alt="<?php echo $altImgTxt; ?>" />
                </div>
                <?php } ?>               
                
                <div class="post-content post-mar-bottom5">
                    <?php echo $content;                  
                    
                    include "social-share.php";
					
					?>
                    
                 </div>
            </div>
        </div>
    </div>
    
    <?php include "blocks/footer.php"; ?>


</body>
</html>