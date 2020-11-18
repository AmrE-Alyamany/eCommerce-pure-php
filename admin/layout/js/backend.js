$(function(){

	"use strict";

	/*$('select').selectBoxIt({

		autoWidth:false
		
	});*/

	$('.toggle-info').click(function () {
		$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(300);
		if ($(this).hasClass('selected')) {
			$(this).html('<i class="fa fa-plus fa-lg"></i>');
		} else {
			$(this).html('<i class="fa fa-minus fa-lg"></i>');
		}
	});
});

// viewport
$(document).ready(function run() {
		$(".form").slideDown(1000, function() { });
});

	if(screen.width<=300){
		document.getElementById("myViewport").setAttribute("content","width=300, user-scalable=no");
	
	}else{
		document.getElementById("myViewport").setAttribute("content","width=device-width , user-scalable=no");
	}
$(function(){

	'use strict';
	$('[placeholder]').focus(function() {
		$(this).attr('data-text',$(this).attr('placeholder'));
		$(this).attr('placeholder' , '');
	}).blur(function() {
		$(this).attr('placeholder' , $(this).attr('data-text'));
	});

	$('input').each(function() {
		if ($(this).attr('required') === "required") {
			$(this).after('<span class="asterisk">*</span>');
			}
		});

	var pass = $('.password');

	$('.show-pass').hover(function () {
		pass.attr('type' , 'text');
		}, function () {
			pass.attr('type' , 'password');
		});

	$('.confirm').click(function () {
		return confirm('Are you sure?');
		});

	$('.cat h3').click(function() {
		$(this).next('.full-view').fadeToggle(300);
	});

	$(' .loading .spinner ').fadeOut(2000);
	$(' .loading ').fadeOut(3000);
});

/*$(window).load(function() {
	$(' .loading ').fadeOut(1000);
});*/
