<?php

ini_set('display_errors',1); 
error_reporting(E_ALL);

require_once('php/config.php');
require_once('php/db.php');
require_once('php/dataobjects.php');
require_once('php/utils.php');
require_once('php/start.php');
require_once('php/session.php');
require_once ('php/controls.php');

function getArrayFromStrIds($strIds) {
    $strIds = str_replace("[", "", $strIds);
    $strIds = str_replace("]", "", $strIds);
    $myArray = explode(",", $strIds);
    return $myArray;
}

function checkCodes($arrCodes, &$arNewCodes, &$arNewCodesExt, &$arExistingCodes, 
        $arInactiveCodesExt, $db1) {
    for ($k = 0; $k < count($arrCodes); $k++) {
        if (!in_array($arrCodes[$k], $arExistingCodes) 
                && !in_array($arrCodes[$k], $arNewCodes)) {

            $sql = "SELECT * FROM app_products WHERE item_code LIKE ?";
            //echo $sql."<br/>";
            //echo $arrCodes[$k]."<br/>";
            $rsCheck = $db1->getRS($sql, array($arrCodes[$k]));
            //var_dump($rsCheck);
            if ($rsCheck) {
                array_push($arExistingCodes, $arrCodes[$k]);

                $checkProduct = new app_products($db1, $rsCheck[0]['id'], $rsCheck);
                if ($checkProduct->active()==0) {
                    array_push($arInactiveCodesExt, 
                        array($arrCodes[$k], 
                            $checkProduct->get_id(), 
                            $checkProduct->title()
                        )
                        );
                }

            }
            else {
                array_push($arNewCodes, $arrCodes[$k]);
                array_push($arNewCodesExt, array($arrCodes[$k], 0, ''));
            }

        }
    }
}

$itemid = isset($_REQUEST['itemid'])? $_REQUEST['itemid']: 0;
if ($itemid>0) {
    $sql = "SELECT * FROM app_products WHERE id=?";
    $rs = $db1->getRS($sql, array($itemid));
    $item = new app_products($db1, $rs[0]['id'], $rs);
}
else {
    $idStart = isset($_REQUEST['start'])? $_REQUEST['start']: 0;
    $idStop = isset($_REQUEST['stop'])? $_REQUEST['stop']: 100000;
    $sql = "SELECT * FROM app_products WHERE id>=? AND id<=?";
    $rs = $db1->getRS($sql, array($idStart, $idStop));
}


if ($rs) {
    
    $arNewCodes = array();
    $arNewCodesExt = array();
    $arInactiveCodes = array();
    $arInactiveCodesExt = array();
    $arExistingCodes = array();
    
    
    
    for ($i = 0; $i < count($rs); $i++) {
        $product = new app_products($db1, $rs[$i]['id'], $rs);
        
        $accessoriesCodes = getArrayFromStrIds($product->accessories_ids());
        checkCodes($accessoriesCodes, $arNewCodes, $arNewCodesExt, $arExistingCodes, 
                $arInactiveCodesExt, $db1);
        
        $relatedCodes = getArrayFromStrIds($product->related_product_ids());
        checkCodes($relatedCodes, $arNewCodes, $arNewCodesExt, $arExistingCodes, 
                $arInactiveCodesExt, $db1);
        
        $cleaningagentsCodes = getArrayFromStrIds($product->cleaning_agents_ids());
        checkCodes($cleaningagentsCodes, $arNewCodes, $arNewCodesExt, $arExistingCodes, 
                $arInactiveCodesExt, $db1);
        
        $standardAccessoriesCodes = getArrayFromStrIds($product->standard_accessories_ids());
        checkCodes($standardAccessoriesCodes, $arNewCodes, $arNewCodesExt, $arExistingCodes, 
                $arInactiveCodesExt, $db1);
        
    }
    
    array_multisort($arNewCodesExt);    
        
    $rsNewCodes = array();
    for ($i = 0; $i < count($arNewCodesExt); $i++) {
        $newCode = $arNewCodesExt[$i][0];
        $rsNewCodes[$i]['code'] = $newCode;
        $rsNewCodes[$i]['description'] = $arNewCodesExt[$i][2];
        $newId = $arNewCodesExt[$i][1]; 
        $rsNewCodes[$i]['id'] = $newId; 
        $rsNewCodes[$i]['counter'] = $i +1;
        
        $rsNewCodes[$i]['delitem'] = "<a class=\"fancybox\" href=\"delRelativeCode.php?code=$newCode\" title=\"Διαγραφή κωδικού από όλα τα είδη\" style=\"/*color:#ccc*/\"><span class=\"fa fa-close\"</a>";
        $rsNewCodes[$i]['createnew'] = "<a title=\"Δημιουργία είδους\" class=\"fancybox\" href=\"editproduct.php?id=$newId&newcode=$newCode\"><span class=\"fa fa-plus\"</a>";  
        
    }
    $gridNew = new datagrid("gridNew", $db1, "", 
            array('counter','code', 'description', 'delitem', 'createnew'), 
            array('#', 'CODE', 'DESCRIPTION', 'DELETE', 'CREATE'), 
            "GR");
    $gridNew->set_rs($rsNewCodes);
    
    
    $rsInactiveCodes = array();
    for ($i = 0; $i < count($arInactiveCodesExt); $i++) {
        $newCode = $arInactiveCodesExt[$i][0];
        $rsInactiveCodes[$i]['code'] = $newCode;
        $rsInactiveCodes[$i]['description'] = $arInactiveCodesExt[$i][2];
        $newId = $arInactiveCodesExt[$i][1]; 
        $rsInactiveCodes[$i]['id'] = $newId; 
        $rsInactiveCodes[$i]['counter'] = $i +1;
        
        $rsInactiveCodes[$i]['finditems'] = "<a class=\"fancybox\" href=\"delRelativeCode.php?code=$newCode\" title=\"Διαγραφή κωδικού από όλα τα είδη\" style=\"/*color:#ccc*/\"><span class=\"fa fa-close\"</a>";
        $rsInactiveCodes[$i]['createnew'] = "<a title=\"Ανοιγμα είδους\" class=\"fancybox\" href=\"editproduct.php?id=$newId&newcode=$newCode\"><span class=\"fa fa-plus\"</a>";  
        
    }
    $gridInactive = new datagrid("gridInactive", $db1, "", 
            array('counter','code', 'description', 'delitem', 'createnew'), 
            array('#', 'CODE', 'DESCRIPTION', 'DELETE', 'CREATE'), 
            "GR");
    $gridInactive->set_rs($rsInactiveCodes);
    
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
        #gridNew td, #gridInactive td {
            vertical-align: top;
        }
        #gridNew, #gridInactive {
            max-width:700px;
        }
        #gridNew tr td:nth-child(4), #gridNew tr td:nth-child(5),
        #gridInactive tr td:nth-child(4), #gridInactive tr td:nth-child(5)
        {
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Header Begin-->
    <?php include 'blocks/header.php'; ?>
    <!-- Header End-->
    <div class="clear"> </div>
    <div class="wrap">
        <div class="content">
            
            <h1>Νέοι Σχετιζόμενοι Κωδικοί</h1>
            
            <?php
            if ($itemid>0) {
                echo "<h2>για το προϊόν " . $item->item_code() . "</h2>";
            }
            ?>
            
            <?php
            if ($arNewCodesExt) {
                $gridNew->get_datagrid();
            }
            else {
                echo "<h3>Δεν βρεθηκαν εγγραφές</h3>";
            }
            ?>
            
            
            <div class="clear" style="height: 50px"></div>
            <h2>Κωδικοί που είναι ανενεργοί</h1>
            
            <?php
            if ($arInactiveCodesExt) {
                $gridInactive->get_datagrid();
            }
            else {
                echo "<h3>Δεν βρεθηκαν εγγραφές</h3>";
            }
            ?>
            
        </div>
        
    </div>
    
</body>

</html>