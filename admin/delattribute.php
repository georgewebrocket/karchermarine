<?php
//ini_set('display_errors',1); 
//error_reporting(E_ALL);
require_once('php/config.php');
require_once('php/db.php');
require_once('php/dataobjects.php');
require_once('php/utils.php');
require_once('php/start.php');
require_once('php/session.php');
require_once('php/controls.php');

$id=0;
$msg='';
if(isset($_GET['id'])){$id=$_GET['id'];}

if (isset($_GET['del']) && $_GET['del'] == 1) {
    $attribute = new app_attributes($db1, $id);
    if($attribute->Delete()) {
        $id = 0;
        $msg = "<h2 style='color:green;' class='msg'>Attribute διαγράφτηκε με επιτυχία</h2>";
    }
    else{
        $msg = "<h2 style='color:red;' class='msg'>Παρουσιάστηκε σφάλμα. Παρακαλώ δοκιμάστε ξανά.</h2>";
    }
}

?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Kaercher-marine CRM</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="css/reset.css" rel="stylesheet" type="text/css"  media="all" />
        <link href="css/style.css" rel="stylesheet" type="text/css"  media="all" />
        <link href="css/grid.css" rel="stylesheet" type="text/css"  media="all" />
    </head>
	<body>
            <div class="wrap">
                <div class="content">
                    <div class="col-12">
                        <h1>Διαγρφή Attribute</h1>
                        <?php if ($msg!="") { echo $msg;}  ?>
                        <form id="formDel" action="delattribute.php?id=<?php echo $id; ?>&del=1" method="POST">
                            <?php
                            //submit
                            if(!isset($_GET['del'])){
                                $btnOK = new button("BtnOk", "Διαγραφή"); 
                                echo "<div class=\"col-4\"></div><div class=\"col-8\">";
                                $btnOK->get_button_simple();
                            }
                            $strUrl = app::$host."attributes.php";
                            echo "<input style='margin-left: 10px;' onclick='window.parent.location=\"".$strUrl."\";' type='button' value='Κλείσιμο και ενημέρωση' />";                            
                            echo "</div>";
                            echo '<div style="clear:both"></div>';
                            ?>
                        </form>
                        <div style="clear:both"></div>
                    </div>                                 
                </div>
                <div class="clear"> </div>
            </div>
	</body>
</html>