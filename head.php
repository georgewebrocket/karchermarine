<meta name="viewport" content="width=device-width, initial-scale=1.0">

<base href="<?php echo app::$host; ?>" />

<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/grid.css" rel="stylesheet" type="text/css" />


<!--<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>-->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="js/jquery.cookie.js"></script>


<link rel="stylesheet" href="fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/styles2.css" rel="stylesheet" type="text/css" />
<script src="js/scripts.js"></script>
<script src="js/scripts2.js"></script>

<link href="css/font-awesome.css" rel="stylesheet" type="text/css" media="all"/>

<script>
jQuery(document).ready(function($) {
   
    $('#count-compare').text(<?php echo count($_SESSION['COMPARE_PRODUCT_IDS']); ?>);
	$('#count-compare-mobile').text(<?php echo count($_SESSION['COMPARE_PRODUCT_IDS']); ?>);
    $('#count-compare').show('slow');
    
    var arr = [<?php echo implode(",", $_SESSION['COMPARE_PRODUCT_IDS']); ?>];
    jQuery.each(arr, function(index, value){
        $(".chk-compare").each(function() {
            if($(this).val() == value){
                $(this).prop('checked', true);
                $(this).parent().parent(".compare").addClass('active-compare').removeClass('compare');
            }else{
                $(this).parent().parent('active-compare').addClass('compare').removeClass('active-compare');
            }
        });
    });

});
</script>