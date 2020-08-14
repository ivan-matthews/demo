window.commentOBbj = {
	hideCommentButton: function(self,comment_id){
		$('blockquote#content' + comment_id).hide();
		$('div#comment' + comment_id).show();
	},
};