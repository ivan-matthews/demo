window.scrollObj = {
	upToTop: function(){
		scrollObj.scrolling = $(window).scrollTop();
		let panel = $('.top_up_panel_button');
		let opacity = scrollObj.scrolling/10000;
		opacity = (opacity<0.1)?0.1:opacity;
		opacity = (opacity>0.5)?0.5:opacity;
		panel.css('background','rgba(74, 118, 166, ' + opacity + ')');
		if(scrollObj.scrolling > 0){
			panel.show();
			$('#up',panel).show();
			$('#down',panel).hide();
		}else{
			if(!isset(scrollObj.backScroll)){
				panel.hide();
			}
			$('#up',panel).hide();
			$('#down',panel).show();
		}
		return false;
	},
	upToTopClick: function(){
		let scroll_speed = 250;
		if(scrollObj.scrolling > 0){
			scrollObj.backScroll = scrollObj.scrolling;
			$("html, body").stop().animate({scrollTop:0},scroll_speed, 'swing');
		}else{
			if(isset(scrollObj.backScroll)){
				$("html, body").stop().animate({scrollTop:scrollObj.backScroll},scroll_speed, 'swing');
			}
		}
		return false;
	},
};
$(window).scroll(scrollObj.upToTop);
$(document).ready(scrollObj.upToTop);
