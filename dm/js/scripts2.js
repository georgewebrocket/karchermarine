// JavaScript Document


$(function() {
		   
	$('#mobile-menu-launch').click(function() {
		toggleVisible($('#mobile-menu'));
		
	});
	
	var mobilelevel = 1;
	
	$('#mobile-menu li.level1.nolink').click(function(e) {		
		if (mobilelevel==1) {
			e.preventDefault();
			var childUl = $(this).find('ul.level2');
			toggleVisible(childUl);
		}
		else {
			mobilelevel = 1;
		}
	});
	
	$('#mobile-menu li.level2.nolink').click(function(e) {		
		if (mobilelevel!=3) {
			e.preventDefault();
			mobilelevel = 2;
			var childUl = $(this).find('ul.level3');
			toggleVisible(childUl);
		}
		else {
			mobilelevel = 2;
		}
	});
	
	$('#mobile-menu li.level3').click(function() {
		mobilelevel = 3;
	});


});


function toggleVisible(el) {
	if (el.css('display') == "none") {
		el.fadeIn();
	}
	else {
		el.fadeOut();
	}	
}