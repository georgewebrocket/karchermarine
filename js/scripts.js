// JavaScript Document


$(function() {
    
	//smooth scrolling
	$('a[href^="#"]').on('click', function(event) {	
		var target = $( $(this).attr('href') );
		//alert(target.offset().top);
		var time = 1000;
		if (target.offset().top == 0) {
			time = 2000;
		}
	
		if( target.length ) {
			event.preventDefault();
			$('html, body').animate({
				scrollTop: target.offset().top - 170
			}, 1000);
		}
	
	});
	
	$('a.navlink').click(function(e) {
        e.preventDefault();
        $('a.navlink').parent().css( "background-color", "transparent" );        
        
        if($(this).hasClass('active')){
            $('a.navlink').removeClass('active');
        }else{
            $('a.navlink').removeClass('active');
            $(this).addClass('active');
        }
        
        if ( !$( '#mega-menu' ).is( ':hidden' )){
            $('#mega-menu').slideUp();            
        }        
        
        if ($(this).hasClass('active')){            
            $.get($(this).attr('href'), function(data) {
                $('#mega-menu').html(data);
                $('#mega-menu').slideDown();                
            });
            $(this).parent().css( "background-color", "#ededed" );
        }
         
        $('html, body').animate({
                scrollTop: 0
        }, 1000);
    });
    
    $(document).mouseup(function (e){ // событие клика по веб-документу
        var div = $("#mega-menu"); // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            && div.has(e.target).length === 0) { // и не по его дочерним элементам
                div.slideUp();
                $('a.navlink').parent().css( "background-color", "transparent" );
        }
    });
    
    

    //Check to see if the window is top if not then display button
    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
                $('.scrollToTop').fadeIn();
        } else {
                $('.scrollToTop').fadeOut();
            }
    });

    //Click event to scroll to top
    $('.scrollToTop').click(function(){
        $('html, body').animate({scrollTop : 0},800);
        return false;
    });
	
	
	
});


function getTopPos(el, units) {
	if (units === undefined ) {
		units = 'px';	
	}
	var top = $(window).scrollTop();
	var topEl = top - el.offset().top;	
	if (units == 'px') {
		return topEl;	
	}
	else {
		var H = $(window).innerHeight();
		return topEl / H * 100;
	}
}

function getBottomPos(el, units) {
	if (units === undefined ) {
		units = 'px';	
	}
	var top = $(window).scrollTop();
	var H = $(window).innerHeight();
	var bottomEl = top + H - el.offset().top;
	if (units == 'px') {
		return bottomEl;
	}
	else {
		return bottomEl / H * 100;
	}
}


$(function() {
		
        var topMenuHeight = $('#sticky-header').outerHeight();
        var topTabMenu = 0;
		var topTabMenuInit = 0;
        if ($('#tab-menu').length) {
                topTabMenuInit = $('#tab-menu').offset().top;
                console.log(topTabMenu);
        }

        $(window).load(function() {
                if ($('#tab-menu').length) {
                topTabMenuInit = $('#tab-menu').offset().top;
                //console.log(topTabMenu);
                }
                });

        $(window).scroll(function() {
                var top = $(window).scrollTop();			

                if (top>50) {
                        $('#sticky-header').css('position','fixed');
                        $('#sticky-header').css('top','0px');
                }
                else {
                        $('#sticky-header').css('position','relative');
                }
				
				/*if ($('#tab-menu').length) {
                	topTabMenu = $('#tab-menu').offset().top;
                }*/					

                if ($('#tab-menu').length) {				
                        //console.log(top);
                        //if (top>topTabMenu-150) {
						if (top>300) {
                                $('#tab-menu').css('position','fixed');
                                //$('#tab-menu').css('top',topMenuHeight+'px');
								$('#tab-menu').css('top','95px');

                                //$('#tab-menu').css('width', '1260px');
                        }
                        else {
                                $('#tab-menu').css('position','relative');
                                $('#tab-menu').css('top','0px');
                        }
                }


                //console.log(topTabMenu + '//' + topMenuHeight);
        });
        
        $('#tab-menu li a').click(function() {
            if($(this).parent().hasClass('active')){
            $('#tab-menu li').removeClass('active');
            }else{
                $('#tab-menu li').removeClass('active');
                $(this).parent().addClass('active');
            }
        });
		
		
		$( "a.remove" ).click(function( event ) {
               event.preventDefault();
			   /*$("td").click(function(){
					var columnNo = $(this).index();
					$(this).closest("table")
						.find("tr td:nth-child(" + (columnNo+1) + ")")
						.css("color", "red");
				});*/
			   var prodauctId = $(this).attr('id').substring(3);
                prodauctAddRemoveId(prodauctId,'remove', 'refresh');

            });
		
		
        
        /*
        $(function(){
            $(".product-ref").hover(function(){
              //$(this).find(".compare").show();
              $(this).find(".compare").addClass('active-compare').removeClass('compare');
              $(this).find(".detail").show();
              $(this).find(".detail").css("background-color", "#FFED00");
              $(this).css("border", "3px solid #FFED00");
            }
                ,function(){
                    //$(this).find(".compare").hide();
                    if(!$(this).find(".chk-compare").is(':checked')){
                        $(this).find(".active-compare").addClass('compare').removeClass('active-compare');
                    }
                    $(this).find(".detail").hide();
                    $(this).css("border", "3px solid transparent");
                }
               );        
        });
        
		
        $(function() {    
            $('.chk-compare').click(function() {
                var prodauctId;
                if($( this ).is(':checked')){
                    prodauctId = $( this ).val();
                    $( this ).parent().parent().addClass('active-compare').removeClass('compare');
                    prodauctAddRemoveId(prodauctId,'add');
                }else{
                    prodauctId = $( this ).val();
//                    $(this).parent().parent().addClass('compare').removeClass('active-compare');
                    prodauctAddRemoveId(prodauctId,'remove');
                }
            });
            
            $( "a.remove" ).click(function( event ) {
               var prodauctId = $(this).attr('id').substring(3);
                prodauctAddRemoveId(prodauctId,'remove');

            });
            
            $( "a.product-addcompare" ).click(function( event ) {
               var prodauctId = $(this).attr('id').substring(3);
                prodauctAddRemoveId(prodauctId,'add');

            });
            
        });*/

        

});


function prodauctAddRemoveId(id, addRemove, doRefresh) {        
	$.post( "compare.php", 
			{ 
			id: id,
			addRemove: addRemove
			})
	.done(function( data ) {
		$('#count-compare').text(data);
		$('#count-compare-mobile').text(data);
		if($('#count-compare').text() != ''){
			$('#count-compare').show('slow');
			if (doRefresh=='refresh') {
				location.reload();
			}
		}
	});
}


function scrollToClass(MyClass) {
	var target = $('.'+MyClass);
		var time = 1000;
		if (target.offset().top == 0) {
			time = 2000;
		}	
		if( target.length ) {
			$('html, body').animate({
				scrollTop: target.offset().top - 170
			}, 1000);
		}	
}