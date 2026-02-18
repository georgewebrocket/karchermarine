<?php
$sql = "SELECT * FROM app_categories WHERE parent_id = 100 AND id <> 106";
$rsCat1 = $db1->getRS($sql);

$cat1 = "";
if ($rsCat1) {
    for ($i = 0; $i < count($rsCat1); $i++) {
        $cat = new app_categories($db1, $rsCat1[$i]['id'], $rsCat1);
        $cat1 .= "<div class=\"af-cat af-cat-1\" title=\"".$cat->title()."\" data-id=\"".$cat->get_id()."\" >";
        $cat1 .= "<img src=\"". $cat->photo() ."\" />";
        $cat1 .= "</div>";
    }
}
?>

<div class="col-4 col-sm-12 af-1">    
    <div class="af-1-inside">
        <h2 style="font-weight: bold">Select the first product</h2>
        <div class="af-categories-1">
            <?php echo $cat1; ?>  
            <div class="clear"></div>
        </div>
        <div id="af-products-1" class="af-products-1">
            Select a product group
        </div>
        <div id="af-products-1-product" style="display:none">            
        </div>
    </div>
</div>

<div class="col-4 col-sm-12"></div>

<div class="col-4 col-sm-12 af-2">
    <div class="af-2-inside">
        <h2 style="font-weight: bold">Select the second product</h2>
        <div id="af-categories-2" class="af-categories-2"></div>
        <div id="af-products-2" class="af-products-2">
            
        </div>
        <div id="af-products-2-product" style="display:none">            
        </div>
    </div>
</div>

<div class="clear"></div>

<div class="col-4 col-sm-12"></div>

<div class="col-4 col-sm-12">
    <div class="col-2 col-sm-0">
        <div class="af-line"></div>
    </div>
    <div class="col-8 col-sm-12">
        <div class="af-3">
            <h2 style="text-align: center">YOUR ADAPTER</h2>
            <div id="af-adapter" class="af-adapter">
                <img src="img/adapter.png" width="83" height="47" alt="adapter"/>
            </div>
        </div>
    </div>
    <div class="col-2 col-sm-0">
        <div class="af-line"></div>
    </div>
</div>

<div class="col-4 col-sm-12"></div>

<div class="spacer-50"></div>
<div class="spacer-50"></div>
<div class="spacer-50"></div>
<div class="spacer-50"></div>

<style>

    
    
    
    
    .af-cat-selected {
        border-color: #ffed00;
    }
    
    .af-cat-selected:after {
        top: 100%;
        left: 50%;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border: 10px solid rgba(255,237,0,0);
        border-top-color: #FFED00;
        margin-left: -10px;
        margin-top: 15px;
    }
    
    .af-products-1, .af-products-2 {
        border:1px solid #e3e3e3;
        text-align: center;
        padding:10px;
        min-height: 200px;
    }
    
    #af-products-1-product, #af-products-2-product {
        border:2px solid #ffed00;
        text-align: center;
        padding:20px;
        min-height: 200px;
        position:relative;
    }
    
    #af-products-1-product:before, #af-products-2-product:before {
        position:absolute;
        top:5px;
        right:5px;
        width:20px;
        height: 20px;
        content: "\f00d";
        font-family: "FontAwesome";
        font-size: 20px;
        cursor:pointer;
    }
    
    .af-categories-1, .af-categories-2 {
        min-height: 100px;
    }
    
    .af-product {
        height:250px; 
        overflow:hidden;
        cursor: pointer;
        padding:10px;
    }
    
    .af-product h3, #af-products-1-product h3, #af-products-2-product h3 {
        font-weight: bold;
    }
    
    #af-adapter {
        margin:20px 0px;
        text-align: center;
    }
    
    .af-adapter-product {
        border:2px solid #ffed00;
        padding:20px;
        text-align: center;
        position: relative;
    }
    .af-adapter-link {
        position: absolute;
        bottom:0px;
        right:0px;
        left:0px;
        padding:10px;
        text-align: center;
        font-weight: bold;
        background-color: #ffed00;
    }
    
    .af-line {
        height: 100px;
        border-bottom: 2px solid #ffed00;
        display: none;
    }
    
</style>

<style>
  .ui-tooltip, .arrow:after {
    background: #ffed00;
    border: 1px solid rgb(200,200,200);
  }
  .ui-tooltip {
    padding: 10px;
    color: black;
    border-radius: 1px;
    font: bold 14px "Helvetica Neue", Sans-Serif;
    text-transform: uppercase;
    border: 1px solid rgb(200,200,200);
    box-shadow: none;
  }
  .arrow {
    width: 70px;
    height: 16px;
    overflow: hidden;
    position: absolute;
    left: 50%;
    margin-left: -35px;
    bottom: -16px;
  }
  .arrow.top {
    top: -16px;
    bottom: auto;
  }
  .arrow.left {
    left: 20%;
  }
  .arrow:after {
    content: "";
    position: absolute;
    left: 20px;
    top: -20px;
    width: 25px;
    height: 25px;
/*    box-shadow: 6px 5px 9px -9px black;*/
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  }
  .arrow.top:after {
    bottom: -20px;
    top: auto;
  }
  </style>
  

<script>
var product1 = 0;
var product2 = 0;

var adapterimg1 = "<img src=\"img/adapter.png\" width=\"83\" height=\"47\" alt=\"adapter\"/>";
var adapterimg2 = "<img src=\"img/adapter_selected.png\" width=\"83\" height=\"48\" alt=\"adapter\"/>";
var waitimg = "<div style=\"text-align:center\"><img src=\"img/wait.gif\" width=\"36\" height=\"36\" alt=\"wait\"/></div>";

$(".af-cat").tooltip({
      position: {
        my: "center bottom-20",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      }
    });

$(".af-cat-1").click(function() {
    var catid = $(this).data("id");
    
    $(".af-cat-1").each(function() {
        $(this).removeClass("af-cat-selected");
    });
    $(this).addClass("af-cat-selected");
    
    $("#af-categories-2").html("");
    $("#af-products-2").html("");
    $("#af-adapter").html(adapterimg1);
    $(".af-line").hide();
    $("#af-products-1-product").hide();
    $("#af-products-1").show();
    $("#af-products-2-product").hide();
    $("#af-products-2").show();    
    
    $("#af-products-1").html(waitimg);    
    $.post("getAdapterProducts.php",
        {catid: catid, product1:0},
        function(data) {      
            populateProducts1(data);
        }
    );
});

function populateProducts1(data) {
    $("#af-products-1").html(data);
    $("#af-products-1 .af-product").click(function() {
        var productid = $(this).data("id");
        product1 = productid;

        $("#af-products-2").html("");
        $("#af-adapter").html(adapterimg2);
        $(".af-line").hide();
        
        $("#af-products-1-product").html($(this).html());
        $("#af-products-1-product").show();
        $("#af-products-1").hide();
        
        $("#af-categories-2").html(waitimg);
        $.post("getAdapterCats.php", 
        {productid:productid}, 
        function(data){   /*///////*/ 
            populateCats2(data);
        });
    });
}

function populateCats2(data) {
    $("#af-categories-2").html(data);
    $(".af-cat-2").click(function() {
        var catid = $(this).data("id");

        $(".af-cat-2").each(function() {
            $(this).removeClass("af-cat-selected");
        });
        $(this).addClass("af-cat-selected");

        $("#af-adapter").html(adapterimg2);
        $(".af-line").hide();
        $("#af-products-2-product").hide();
        $("#af-products-2").show(); 
        
        $("#af-products-2").html(waitimg);
        $.post("getAdapterProducts.php",
            {catid: catid, product1:product1},
            function(data) {    /*///////*/     
                populateProducts2(data);
            });
    });
}

function populateProducts2(data) {
    $("#af-products-2").html(data);
    $("#af-products-2 .af-product").click(function() {
        var productid = $(this).data("id");
        product2 = productid;
        
        $("#af-products-2-product").html($(this).html());
        $("#af-products-2-product").show();
        $("#af-products-2").hide();
        
        $("#af-adapter").html(waitimg);
        $.post("getAdapter.php",
            {product1: product1, product2: product2},
            function(data) {    /*///////*/ 
               $("#af-adapter").html(data);
               $(".af-line").show();
            });
    });
}

//$(function() {
    
    $("#af-products-1-product").before().click(function() {
        $("#af-products-1-product").hide();
        $("#af-products-1").show();
        
        $("#af-categories-2").html("");
        $("#af-products-2").html("");
        $("#af-adapter").html(adapterimg1);
        $(".af-line").hide();
        
        $("#af-products-2-product").hide();
        $("#af-products-2").show();
        
    });
    
    $("#af-products-2-product").before().click(function() {
        $("#af-products-2-product").hide();
        $("#af-products-2").show();
        
        $("#af-adapter").html(adapterimg2);
        $(".af-line").hide();
        
    });
    
//});

</script>