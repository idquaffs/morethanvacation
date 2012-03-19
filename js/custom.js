$(function(){
	$('div#user-login button.button').click(function(e){
		var target = $( this );
		target.next('div.loginbox').toggle();
		$('div.mask').show();
	});
	$('div.mask').click(function(e){
		var target = $( this );
		target.hide();
		$('div.loginbox').hide();
	});
	$('#profile').click(function(e){
		var target = $( this );
		target.children('#navi').toggle();
	});
	

	/**
	 * HOME
	 **/
	$('div#wrap-flag-category').prepend($('<div id="flag-head"></div><div class="clear"></div>'))
	$('div#wrap-flag-category div.flag').append($('<div class="clear" style="height:10px"></div>'));
	$('div.flag').each(function(e){
		var target = $( this );
		$('div#wrap-flag-category div#flag-head').append($('<div class="flag-head">'+target.children('h2').html()+'</div>'));
		target.hide();
	});
	$('div.flag-head').click(function(e){
		var target = $( this );
		$('div.flag-head').removeClass('active')
		$('div.flag').hide();
		target.addClass('active');
		var index = $('div.flag-head').index(target) + 0;
		$('div.flag:nth('+index+')').show();
	});
	$('div.flag-head:nth(0)').click();
});

function flashMsg (key,msg) {
	if ($('div.flash-notify').length==0) {
		var html = $('<div class="flash-notify clicktohide" >'+
		'<div class="flash-'+key+'">'+msg+'</div></div>').click(function(){$(this).fadeOut()});
		$('#wrap-head').append(html);
	} else {
		var html = $('<div class="flash-'+key+'">'
					+msg+'</div>').click(function(){$(this).hide()});
		$('div.flash-notify').append(html);
	}
}