window.photosObj = {
	removeImagePreview: function(id){
		let photos_list = $('.photos-list');
		let files_list = $('.images-type-field input[type=file]');
		$('#iterator-' + id,photos_list).remove();
		if(isset(files_list[0].files[id])){
			delete files_list[0].files[id];
		}
		console.log(files_list[0].files);
	}
};