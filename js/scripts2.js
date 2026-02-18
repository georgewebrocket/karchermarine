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
	
	$('#item-rfq').click(function() {
		var itemid = $(this).data('productid');
		var quantity = $('#rfq-quantity').val();
		msg = 'The item was added to RFQ list';
		AddProductToRFQList(itemid, quantity, 1, msg);
		});
		
	$('#rfq-update').click(function() {
		UpdateRFQ();
	});
	
	$('#rfq-send').click(function() {
		SendRFQ();
	});
	
	$('.err-msg').click(function() {
		$('#cover').hide();
		$('#status').html('');							 
	});
	
	$('.del-rfq-item').click(function() {
		var itemid = $(this).data('itemid');
		console.log(itemid);
		var msg = 'The current item was removed from the RFQ list';
		AddProductToRFQList(itemid, 0, 0, msg);
		$(this).parent().parent().hide();
		
	});
	
	$('#rfq-delete-all').click(function() {
		DeleteRFQList();
	});
	
	$('#chk-compare').click(function() {
		var productId;
		if($(this).is(':checked')){
			productId = $(this).val();
			$(this).parent().parent().addClass('active-compare').removeClass('compare');
			prodauctAddRemoveId(productId,'add');
		}
		else{
			productId = $(this).val();
			prodauctAddRemoveId(productId,'remove');
		}
	});
	
	$('#cookiesdirective_continue').click(function() {
		acceptCookies();	
	});
	
	$('#fb-share').click(function() {
		myShare();
	});


});

//fancybox
$(function() {
   $('a.fancybox').fancybox(); 
   $("a.fancyframe").fancybox({'type' : 'iframe', 'width' : 1200, 'height' : 600 });
   $("a.fancyframe600").fancybox({'type' : 'iframe', 'width' : 600, 'height' : 600 });
   $("a.fancyframe800").fancybox({'type' : 'iframe', 'width' : 800, 'height' : 600 });
   
});

function acceptCookies() {
	$('#cookies-message-container').animate({
		'margin-top': '-130px'
	  }, 2000, function() {
		$('#cookies-message-container').hide();
	  });
	$.post( "acceptcookies.php", {})
		.done(function( data ) {
			//
		});	
}


function myalert(msg) {
	$('#cover').show();
	$('#status').html(msg);
}


function SendRFQ() {
	
	var company = $('#t_company').val();
	var vessel = $('#t_vessel').val();
	var imo = $('#t_imo').val();
	var port = $('#t_port').val();
	var eta = $('#t_eta').val();
	var contact = $('#t_contact').val();
	var email = $('#t_email').val();
	var phone = $('#t_phone').val();
	var address = $('#t_address').val();
	var message = $('#t_message').val();
	var sendcopy = $('#rfq-send-copy').is(':checked')? 1: 0;
	
	var err = false;
	
	if (company.trim()=='' 
		|| vessel.trim() =='' 
		|| imo.trim() =='' 
		|| contact.trim() ==''
		|| email.trim() ==''
		|| phone.trim() =='') {
		err = true;
		myalert('You must fill all fields');                            
	}
	
	if (!err) {
		var params = new Object(); 
		params['minLength'] = '3'; params['maxLength'] = '50';
		if (!validateField('TEXT', company, $('#t_company'), params)) { err=true; }
		
		params = new Object(); 
		params['minLength'] = 3; params['maxLength'] = 50;
		if (!validateField('TEXT', vessel, $('#t_vessel'), params)) { err=true; }
		
		params = new Object(); 
		params['minLength'] = 3; params['maxLength'] = 50;
		if (!validateField('TEXT', imo, $('#t_imo'), params)) { err=true; }
		
		params = new Object(); 
		params['minLength'] = 3; params['maxLength'] = 50;
		if (!validateField('TEXT', port, $('#t_port'), params)) { err=true; }
		
		params = new Object(); 
		params['minLength'] = 3; params['maxLength'] = 20;
		if (!validateField('DATE', eta, $('#t_eta'), params)) { err=true; }
		
		params = new Object(); 
		params['minLength'] = 3; params['maxLength'] = 50;
		if (!validateField('TEXT', contact, $('#t_contact'), params)) { err=true; }
		
		params = new Object(); 
		params['minLength'] = 3; params['maxLength'] = 50;
		if (!validateField('EMAIL', email, $('#t_email'), params)) { err=true; }
		
		params = new Object(); 
		params['minLength'] = 10; params['maxLength'] = 30;
		if (!validateField('TEXT', phone, $('#t_phone'), params)) { err=true; }
		
		params = new Object(); 
		params['minLength'] = 10; params['maxLength'] = 30;
		if (!validateField('TEXT', address, $('#t_address'), params)) { err=true; }
		
		params = new Object(); 
		params['maxLength'] = 500;
		if (!validateField('TEXT', message, $('#t_message'), params)) { err=true; }
		
		if (err) {
			myalert('The marked fields are not filled correctly');
		}
	}
	
	if (!err) {
		var v = grecaptcha.getResponse();
		if(v.length == 0)
		{
			err = true;
			myalert( "You must check the option <br/>I am not a robot.");
		}	
	}
	
	if (!err) {
		var details = '';
		$('.rfq-list-item').each(function() {
			var itemid = $(this).data('itemid');
			var quantity = $(this).find('.rfq-quantity').val();
			details += itemid+'|'+quantity+'||';
		});
		details = details.substring(0, details.length - 2);
		
		$.post( "sendrfq.php", 
				{ 
				details: details,
				company: $('#t_company').val(),
				vessel: $('#t_vessel').val(),
				imo: $('#t_imo').val(),
				port: $('#t_port').val(),
				eta: $('#t_eta').val(),
				contact: $('#t_contact').val(),
				email: $('#t_email').val(),
				phone: $('#t_phone').val(),
				address: $('#t_address').val(),
				message: $('#t_message').val(),
				sendcopy: sendcopy
				})
		.done(function( data ) {
			if (data=='OK') {
				myalert("Your RFQ was sent successfully. <br/>We will contact you soon");
			}
			else {
				myalert("Something went wrong. <br/>Please try again");
			}
			
		});	
		
		$.cookie('karchermarine-company', $('#t_company').val(), { expires: 36500 });
		$.cookie('karchermarine-vessel', $('#t_vessel').val(), { expires: 36500 });
		$.cookie('karchermarine-imo', $('#t_imo').val(), { expires: 36500 });
		$.cookie('karchermarine-port', $('#t_port').val(), { expires: 36500 });
		$.cookie('karchermarine-eta', $('#t_eta').val(), { expires: 36500 });
		$.cookie('karchermarine-contact', $('#t_contact').val(), { expires: 36500 });
		$.cookie('karchermarine-email', $('#t_email').val(), { expires: 36500 });
		$.cookie('karchermarine-phone', $('#t_phone').val(), { expires: 36500 });
		$.cookie('karchermarine-address', $('#t_address').val(), { expires: 36500 });
		$.cookie('karchermarine-message', $('#t_message').val(), { expires: 36500 });
	
	}
	
}

function DeleteRFQList() {
	$.post( "additemtorfq.php", 
			{ 
			itemid: 0,
			quantity: 0,
			add: 0,
			clear: 1
			})
	.done(function( data ) {
		$('#count-rfq').text(data);
		$('#count-rfq-mobile').text(data);
		if($('#count-rfq').text() != ''){
			$('#count-rfq').show('slow');
		}
		$('#items-container').hide();
		$('#no-items').show();		
		myalert('All items were removed from RFQ list');
	});
}


function UpdateRFQ() {
	$('.rfq-list-item').each(function() {
		var itemid = $(this).data('itemid');
		var quantity = $(this).find('.rfq-quantity').val();
		var msg ='The quantities were updated successfully';
		AddProductToRFQList(itemid, quantity, 0, msg);
	});
	
}

function AddProductToRFQList(itemid, quantity, add, msg) {
	console.log(itemid + '-' + quantity);
	$.post( "additemtorfq.php", 
			{ 
			itemid: itemid,
			quantity: quantity,
			add: add
			})
	.done(function( data ) {
		//alert(data);
		$('#count-rfq').text(data);
		$('#count-rfq-mobile').text(data);
		if($('#count-rfq').text() != ''){
			$('#count-rfq').show('slow');
		}
		if (msg!=undefined) {				
			myalert(msg);
		}
		
	});
}


function toggleVisible(el) {
	if (el.css('display') == "none") {
		el.fadeIn();
	}
	else {
		el.fadeOut();
	}	
}


function validateField(fieldType, theValue, theElement, params) {
	var validate = true;
	theElement.css('background-color', 'rgb(255,255,255)');
	
	console.log(params);
	if (theValue!='' && propertyExists(params, 'minLength')) {
		
		if (theValue.length<params['minLength']) {validate = false;}
	}
	if (propertyExists(params, 'maxLength')) {
		if (theValue.length>params['maxLength']) {validate = false;}
	}
	if (propertyExists(params, 'minValue')) {
		if (theValue<params['minValue']) {validate = false;}
	}
	if (propertyExists(params, 'maxValue')) {
		if (theValue>params['maxValue']) {validate = false;}
	}
	if (propertyExists(params, 'pattern')) {
		var re = new RegExp(params['pattern']);
		if (!re.test(theValue)) {validate = false;}
	}
	
	switch (fieldType) {
		case "TEXT":			
			break;
		case "NUMBER":
			if (isNaN(theValue)) { validate = false; }
			break;
		case "EMAIL":
			var emailFilter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
			if (!emailFilter.test(theValue)) { validate = false; }
			break;
		case "DATE":
			break;
	}
	
	if (!validate) {
		theElement.css('background-color', 'rgb(255,200,200)');
		//alert(theElement.attr('id'));
	}
	return validate;
}

function propertyExists(theObject, theProperty) {
	var result = true;
	try {
		var a = theObject.theProperty;
		result = true;	
	}
	catch(ex) {
		console.log(ex);
		result = false;
	}
	return result;
}