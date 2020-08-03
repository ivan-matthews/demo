window.indexObj = {};

// dropdown keep open
$(document).ready(function(){
	$(this).on("click.bs.dropdown", ".do-not-close,.clickable-geo-fields,.closable", function (e) {
		e.stopPropagation();
	});
});

// copy debug query
indexObj.debugQueryToClipper = function(incoming){
	let div = $(incoming).parent();
	let li = div.parent();

	let copyText = $('code',li).text();
	let textarea = $("<textarea>");
	$(li).append(textarea);
	textarea.val(copyText).select();
	document.execCommand("copy");
	textarea.remove();
	$(li).fadeOut(500).fadeIn(500,function(){
		$('.clipper .success').remove();
		$(div).prepend('<div class="success"><i class="fa fa-check text-success" aria-hidden="true"></i></div>');
	});
};

// sidebar button
$(window).resize(function(e){
	indexObj.closeSidebar($('.sidebar-parent'),$('body'));
});
indexObj.sidebarActions = function(){
	let sidebar = $('.sidebar-parent');
	let body = $('body');
	if(sidebar.hasClass('sidebar-display-block')){
		indexObj.closeSidebar(sidebar,body);
	}else{
		indexObj.openSidebar(sidebar,body);
	}
};
indexObj.openSidebar = function(sidebar,body){
	$('html body').addClass('unscrollable');
	sidebar.addClass('sidebar-display-block');
	$(body).prepend('<div class="black-fon-bg" onclick="indexObj.sidebarActions()"></div>');
};
indexObj.closeSidebar = function(sidebar,body){
	$('html body').removeClass('unscrollable');
	sidebar.removeClass('sidebar-display-block');
	$('.black-fon-bg',body).remove();
};