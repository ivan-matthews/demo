window.indexObj = {
	// copy debug query
	debugQueryToClipper: function(incoming){
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
	},
	sidebarActions: function(){
		let sidebar = $('.sidebar-parent');
		let body = $('body');
		if(sidebar.hasClass('sidebar-display-block')){
			indexObj.closeSidebar(sidebar,body);
		}else{
			indexObj.openSidebar(sidebar,body);
		}
	},
	openSidebar: function(sidebar,body){
		$('html body').addClass('unscrollable');
		sidebar.addClass('sidebar-display-block');
		$(body).prepend('<div class="black-fon-bg" onclick="indexObj.sidebarActions()"></div>');
	},
	closeSidebar: function(sidebar,body){
		$('html body').removeClass('unscrollable');
		sidebar.removeClass('sidebar-display-block');
		$('.black-fon-bg',body).remove();
	},
	downloadFile: function(self,link,mime,size,name,description){
		let selfObj = $(self);
		let selfObjParent = selfObj.parent();
		$.ajax({
			beforeSend:function(){
				selfObjParent.prepend(
					'\t<div class="progress mx-auto col-12 progress-bar-ajax m-0 p-0 mb2 radius-0" style="height:24px; position: relative">\n' +
					'<div class="percents" style="position: absolute;left: 45%;right: 45%;font-size: 15px;text-shadow: 1px 1px 0 #fff;font-weight: bold;">0%</div>' +
					'\t\t<div class="progress-bar progress-bar-striped progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style=""></div>\n' +
					'\t</div>'
				);
			},
			xhr: function(){
				let percents;
				let int_percents;
				let percents_bar = $('.progress-bar-ajax>.percents');
				let progress_bar = $('.progress-bar-ajax>.progress-bar');
				let xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function(evt){
					if (evt.lengthComputable) {
						percents = (evt.loaded / evt.total) * 100;
						int_percents = parseInt(percents);
						percents_bar.html(int_percents + '%');
						progress_bar.css('width',percents + '%');
						progress_bar.attr('aria-valuenow',percents);
						if(int_percents > 55){
							percents_bar.css('color','#FFFFFF');
							percents_bar.css('text-shadow','none');
						}
					}
				}, false);
				xhr.addEventListener("progress", function(evt){
					if (evt.lengthComputable) {
						percents = (evt.loaded / evt.total) * 100;
						int_percents = parseInt(percents);
						percents_bar.html(int_percents + '%');
						progress_bar.css('width',percents + '%');
						progress_bar.attr('aria-valuenow',percents);
						if(int_percents > 55){
							percents_bar.css('color','#FFFFFF');
							percents_bar.css('text-shadow','none');
						}
					}
				}, false);
				return xhr;
			},
			cache:false,
			url: link,
			dataType: 'binary',
			xhrFields: {
				'responseType': 'blob'
			},
			headers: {
				'Content-Type': mime,
				'Content-Disposition': 'attachment; filename="' + name + '"',
			},
			method: 'GET',
			success: function(data, status, xhr) {
				let blob = new Blob([data], {mime});
				let link = document.createElement('a');
				link.href = window.URL.createObjectURL(blob);
				link.download = name;
				link.click();
				$('.progress-bar-ajax').remove();
			}
		});
	},
	getLanguagePack: function(){
		let language_content = $('.language-invisible-json-content').html();
		if(language_content){
			if(!isset(indexObj.lang)){
				indexObj.lang = JSON.parse(language_content);
			}
			return indexObj.lang;
		}
		return false;
	},
	getConfig: function(){
		let config_content = $('.config-invisible-json-content').html();
		if(config_content){
			if(!isset(indexObj.config)){
				indexObj.config = JSON.parse(config_content);
			}
			return indexObj.config;
		}
		return false;
	},
	brokenImage : function(image_object,image_size){
		if(!indexObj.getConfig()){ return false; }

		let img = indexObj.config.view.broken_image[image_size];
		$(image_object).attr('src',indexObj.config.uploads_root + img);
		return true;
	},
	setActiveClassToSidebarLink: function(){
		let sidebar = $('.main-content .sidebar-parent>.sidebar-main');
		let links = $('ul>li>a',sidebar);
		let current_link = parse_url(window.location.href);
		let current_link_string = current_link.pathname + current_link.search + current_link.hash;
		$.each(links,function(key,val){
			if(equal($(this).attr('href'),current_link_string)){
				$(this).parent().addClass('active');
			}
		});
	},
	prepareMemory: function(mem_size){
		mem_size = parseInt(mem_size);
		switch(true){
			case mem_size < 1024:
				return parseInt(mem_size) + ' B';
			case mem_size < 1024*1024:
				return parseInt(mem_size/1024) + ' KB';
			case mem_size < 1024*1024*1024:
				return parseInt(mem_size/1024/1024) + ' MB';
			case mem_size < 1024*1024*1024*1024:
				return parseInt(mem_size/1024/1024/1024) + ' GB';
			case mem_size < 1024*1024*1024*1024*1024:
				return parseInt(mem_size/1024/1024/1024/1024) + ' TB';
			case mem_size < 1024*1024*1024*1024*1024*1024:
				return parseInt(mem_size/1024/1024/1024/1024/1024) + ' PB';
			default:
				return parseInt(mem_size) + ' B';
		}
	},
	getFileIcon: function(file_name){
		let conf = indexObj.getConfig();

		let file_name_segments = file_name.split('.');
		let file_extension = file_name_segments[file_name_segments.length-1];

		return isset(conf.view.files_icons[file_extension]) ?
			conf.view.files_icons[file_extension] : conf.view.files_icons.default;
	},
};

// sidebar button
$(document).on("click.bs.dropdown", ".do-not-close,.clickable-geo-fields,.closable", function(e){
	e.stopPropagation();
});
// set active class to sidebar links
$(document).ready(indexObj.setActiveClassToSidebarLink);

// sidebar button
$(window).resize(function(e){
	indexObj.closeSidebar($('.sidebar-parent'),$('body'));
});

$.ajaxSetup({
	accepts: {
		frame: 'application/frame'
	},
	converters: {
		'internal frame': function(result){
			return result;
		}
	},
});
