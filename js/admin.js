var icoDown = '<div class="ico"><span action="icodown" class="ico icomovedown" ></span></div>';
var icoUp 	= '<div class="ico"><span action="icoup" class="ico icomoveup" ></span></div>';
var icoDel	= '<div class="ico"><span action="icodel" class="ico icodelete" ></span></div>';
var icoEdit	= '<div class="ico"><span action="icoedit" class="ico icoedit" ></span></div>';



$(function(){
	$('div#wrap-navi ul > li > a').click(function(e){
		var target = $( this ).parent('li');
		if (target.hasClass('collapse')) {
			target.children('ul').slideDown('fast');
			target.removeClass('collapse');
		} else {
			target.children('ul').slideUp('fast');
			target.addClass('collapse');
		}
	});
	$('a.clickfalse').click(function(e){
		return false;
	});
	$('li.active').parent().parent('li').addClass('active');
});