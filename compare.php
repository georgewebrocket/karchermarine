<?php

//ini_set('display_errors',1); 
//error_reporting(E_ALL);

require_once('php/session.php');

$err = '';
$id = 0;
$compareProducts = 0;
$addRemove = '';

if(isset($_REQUEST['id'])){$id = $_REQUEST['id'];}

if(isset($_REQUEST['addRemove'])){$addRemove = $_REQUEST['addRemove'];}

if(isset($_SESSION['COMPARE_PRODUCT_IDS'])){
    if($err != 'ERROR'){    
        switch ($addRemove) {
            case 'add':
                if(!in_array($id, $_SESSION['COMPARE_PRODUCT_IDS'])){
                    $_SESSION['COMPARE_PRODUCT_IDS'][] = $id;
                }
                break;
            case 'remove':
                $key = array_search($id, $_SESSION['COMPARE_PRODUCT_IDS']);
                if($key !== FALSE){
                    unset($_SESSION['COMPARE_PRODUCT_IDS'][$key]);
                    $_SESSION['COMPARE_PRODUCT_IDS'] = array_values($_SESSION['COMPARE_PRODUCT_IDS']);                
                }
                break;
        }
    }
    $compareProducts = count($_SESSION['COMPARE_PRODUCT_IDS']);
}
 else {
    $compareProducts = 0;
}
echo $compareProducts;

?>