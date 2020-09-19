if(!defined(window.attachmentsObj)){
	window.attachmentsObj = {};
	attachmentsObj.showMore = function(self,total,limit,offset,link,selector){
		total = parseInt(total);
		limit = parseInt(limit);
		offset = parseInt(offset);
		$.ajax({
			url: link,
			method: 'GET',
			dataType: 'frame',
			data: {
				offset: limit+offset
			},
			complete: function(response){
				let body_html =  document.createElement("div");
				body_html.innerHTML = response.responseText;

				// удалить кнопку везде в кешируемом результате НАЧАЛО
				let button_class = $(self,document).parent().attr('class');
				if(button_class){
					let parent_selector = explode(' ',button_class);
					let str = '';
					$.each(parent_selector,function(i,v){
						if(empty(v)){ return false; }
						str += '.';
						str += v.trim();
					});
					$(str).remove();
				}
				// удалить кнопку в кешируемом результате КОНЕЦ

				let append_content = $(selector,body_html).html();
				$(selector,document).append(append_content);
			}
		});
	};

	attachmentsObj.getAttachments = function(self,comment_ids,link,selector_to_add_response){
		$(self).addClass('disabled');
		$.ajax({
			url: link,
			data:{
				attachments: comment_ids
			},
			dataType: 'frame',
			method: 'GET',
			complete: function(response){
				let body_html =  document.createElement("div");
				body_html.innerHTML = response.responseText;

				let append_content = $(body_html).html();
				$(selector_to_add_response,document).parent().append(append_content);
				$(self).remove();
			}
		});
	}
}