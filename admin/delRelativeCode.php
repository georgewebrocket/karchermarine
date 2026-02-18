<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

ini_set('display_errors',1); 
error_reporting(E_ALL);

require_once('php/config.php');
require_once('php/db.php');
require_once('php/dataobjects.php');
require_once('php/utils.php');
require_once('php/start.php');
require_once('php/session.php');
require_once ('php/controls.php');


$code = $_REQUEST['code'];
$productCodes = "";

if (isset($_POST['del'])) {
    $sql = "SELECT * FROM app_products WHERE accessories_ids LIKE CONCAT('%[', ?, ']%')
        OR related_product_ids LIKE CONCAT('%[', ?, ']%')
        OR cleaning_agents_ids LIKE CONCAT('%[', ?, ']%')
        OR standard_accessories_ids LIKE CONCAT('%[', ?, ']%')";
    $rs = $db1->getRS($sql, array($code,$code,$code,$code));
    
    if ($rs) {
        
        for ($i = 0; $i < count($rs); $i++) {
            $product = new app_products($db1, $rs[$i]['id'], $rs);
            
            $newIds = str_replace("[$code],", "", $product->accessories_ids()); //an einai endiamesa
            $newIds = str_replace(",[$code]", "", $newIds);
            $newIds = str_replace("[$code]", "", $newIds); //an einai sto telos
            $product->accessories_ids($newIds);
                        
            $newIds = str_replace("[$code],", "", $product->related_product_ids()); //an einai endiamesa
            $newIds = str_replace(",[$code]", "", $newIds);
            $newIds = str_replace("[$code]", "", $newIds); //an einai sto telos
            $product->related_product_ids($newIds);
                        
            $newIds = str_replace("[$code],", "", $product->cleaning_agents_ids()); //an einai endiamesa
            $newIds = str_replace(",[$code]", "", $newIds);
            $newIds = str_replace("[$code]", "", $newIds); //an einai sto telos
            $product->cleaning_agents_ids($newIds);
                        
            $newIds = str_replace("[$code],", "", $product->standard_accessories_ids()); //an einai endiamesa
            $newIds = str_replace(",[$code]", "", $newIds);
            $newIds = str_replace("[$code]", "", $newIds); //an einai sto telos
            $product->standard_accessories_ids($newIds);
                        
            $product->Savedata();
            $productCodes .= $product->item_code();
            if ($i<count($rs)-1) {
                $productCodes .= ", ";
            }
        
        }
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
    <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
    <!-- Add jQuery library -->
    <link href="fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" media="all"/>
        
    
    <script type="text/javascript" src="fancybox/jquery.fancybox.js"></script>
    <script type="text/javascript" src="js/code.js"></script>
    <script>
    $(document).ready(function() {	
            $("a.fancybox").fancybox({'type' : 'iframe', 'width' : 1000, 'height' : 1000 });	
    });

    </script>       
    <style>
        body {
            min-height: 400px;
        }
    </style>
</head>

<body>
    
    
        
    <form action="delRelativeCode.php?code=<?php echo $code; ?>" method="post">
        <?php 
        if (isset($_POST['del'])) { 
            echo "<h2>Διαγράφτηκε ο σχετιζόμενος κωδικός $code από τους ακόλουθους κωδικούς <br/><br/> $productCodes</h2>";            
        } 
        else { 
        ?>
        <h1>Διαγραφή σχετιζόμενου κωδικού: <?php echo $code; ?></h1>
        <input name="del" class="button" type="submit" value="Delete" />
        <?php } ?>
        
    </form>
    
    
</body>

</html>