<?php

ini_set('display_errors',1); 
error_reporting(E_ALL);

require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/start.php');
require_once('php/content.php');
require_once('php/dataobjects.php');

$sql = "SELECT * FROM app_categories WHERE parent_id = 2";
$rs = $db1->getRS($sql);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>karcher-marine</title>
<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/grid.css" rel="stylesheet" type="text/css" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php
for ($i=0;$i<count($rs);$i++) {
	$cat = new app_categories($db1, $rs[$i]['id'], $rs);
?>
<div class="col-3">
<a href="category/<?php echo $cat->get_id(); ?>">
<div style="background-color:#fff; margin:5px; padding:10px; height:200px; overflow:hidden">
  	<img src="<?php echo $cat->photo(); ?>" width="100%" height="auto" alt=""/><br>
	<h3 style="padding:20px 0px"><?php echo $cat->title(); ?></h3>
 </div>
 </a>
</div>
<?php
}
?>
</body>
</html>