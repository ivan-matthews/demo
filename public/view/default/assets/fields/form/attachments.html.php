<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $attributes */
	/** @var array $errors */
	/** @var string $field_string */

	$errors_status = isset($errors) && !empty($errors);

	if($attributes['params']['validate_status'] && $attributes['params']['show_validation']){
		$attributes['class'] .= " is-";
		if($errors_status){
			$attributes['class'] .= "in";
		}
		$attributes['class'] .= "valid";
	}

	if(!$attributes['params']['show_title_in_form']){ unset($attributes['title']); }

	//	$attributes['value'] = htmlspecialchars($attributes['value']);

	$field_string = $this->getAttributesStringFromArray($attributes);
	$close_modal_button_value = fx_lang('attachments.close_modal_window');
	$ready_modal_button_value = fx_lang('attachments.ready_modal_window');

	$this->prependCSS('attachments');
	$this->prependJS('attachments');
	$attachments = $attributes['params']['variants'];

	$attachments_ids['photos'] = isset($attachments['ids']['photos']) && $attachments['ids'] ? $attachments['ids']['photos'] : array();
	$attachments_ids['videos'] = isset($attachments['ids']['videos']) && $attachments['ids'] ? $attachments['ids']['videos'] : array();
	$attachments_ids['audios'] = isset($attachments['ids']['audios']) && $attachments['ids'] ? $attachments['ids']['audios'] : array();
	$attachments_ids['files']  = isset($attachments['ids']['files'])  && $attachments['ids'] ? $attachments['ids']['files'] : array();

	$attachments_data = isset($attachments['data']) && $attachments['data'] ? $attachments['data'] : array();

	$photos = isset($attachments_data['photos']) &&  $attachments_data['photos'] ? $attachments_data['photos'] : array();
	$videos = isset($attachments_data['videos']) &&  $attachments_data['videos'] ? $attachments_data['videos'] : array();
	$audios = isset($attachments_data['audios']) &&  $attachments_data['audios'] ? $attachments_data['audios'] : array();
	$files = isset($attachments_data['files'])  &&  $attachments_data['files']  ? $attachments_data['files']  : array();
?>

<div class="attachments-field form-group form-block <?php print $attributes['params']['original_name'] ?> <?php print $attributes['params']['field_sets_field_class'] ?>">

	<?php if($attributes['params']['show_label_in_form']){ ?>

		<label class="form-check-label col-12 row" for="<?php print $attributes['id'] ?>">
			<?php if($attributes['required']){ ?>
				<span class="required text-danger">
					*
				</span>
			<?php } ?>
			<?php print $attributes['params']['label'] ?>

		</label>

	<?php } ?>

	<?php if($errors_status){ ?>

		<?php foreach($errors as $item) { ?>

			<div class="invalid-feedback">

				<?php print $item ?>

			</div>

		<?php } ?>

	<?php } ?>

	<div class="<?php print $attributes['class'] ?>">
		<button type="button" class="btn btn-success radius-0 attachments-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<?php print fx_lang('attachments.add_attachments_button_value') ?>
		</button>
		<div class="dropdown-menu">
			<div class="dropdown-item btn btn-light radius-0 pl-4 pr-4 p-2" data-toggle="modal" data-target="#<?php print $attributes['name'] ?>-photos">
				<i class="far fa-file-image"></i>
				<?php print fx_lang('attachments.attachments_type_photo') ?>
			</div>
			<div class="dropdown-item btn btn-light radius-0 pl-4 pr-4 p-2" data-toggle="modal" data-target="#<?php print $attributes['name'] ?>-videos">
				<i class="far fa-file-video"></i>
				<?php print fx_lang('attachments.attachments_type_video') ?>
			</div>
			<div class="dropdown-item btn btn-light radius-0 pl-4 pr-4 p-2" data-toggle="modal" data-target="#<?php print $attributes['name'] ?>-audios">
				<i class="far fa-file-audio"></i>
				<?php print fx_lang('attachments.attachments_type_audio') ?>
			</div>
			<div class="dropdown-item btn btn-light radius-0 pl-4 pr-4 p-2" data-toggle="modal" data-target="#<?php print $attributes['name'] ?>-files">
				<i class="far fa-file-alt"></i>
				<?php print fx_lang('attachments.attachments_type_file') ?>
			</div>
		</div>
	</div>

	<div class="attachments-ids-block hidden">
		<input id="photos" type="hidden" name="attachments[<?php print $attributes['params']['original_name'] ?>][photos]" value="<?php print implode(',',$attachments_ids['photos']) ?>">
		<input id="audios" type="hidden" name="attachments[<?php print $attributes['params']['original_name'] ?>][audios]" value="<?php print implode(',',$attachments_ids['audios']) ?>">
		<input id="videos" type="hidden" name="attachments[<?php print $attributes['params']['original_name'] ?>][videos]" value="<?php print implode(',',$attachments_ids['videos']) ?>">
		<input id="files" type="hidden" name="attachments[<?php print $attributes['params']['original_name'] ?>][files]" value="<?php print implode(',',$attachments_ids['files']) ?>">
	</div>

	<div class="attachments-data-block-previews<?php if(!$attachments_data){ ?> hidden<?php } ?>">
		<div class="preview-photos<?php if(!$photos){ ?> hidden<?php } ?>">
			<div class="preview-head">
				<?php print fx_lang('attachments.photos_field_head') ?>
			</div>
			<div class="row row-style col-12 m-0 p-0 content-block">
				<?php if($photos){ ?>
					<?php foreach($photos as $photo){ ?>
						<div id="photo-<?php print $photo['p_id'] ?>" class="photo-item photo-item-<?php print $photo['p_id'] ?>" onclick="attachmentsObj.selectAttachment(this,'photos',<?php print $photo['p_id'] ?>)">
							<img src="<?php print fx_get_image_src($photo['p_medium'],$photo['p_date_updated'],'medium') ?>">
						</div>
					<?php } ?>
				<?php } ?>
			</div>
		</div>

		<div class="preview-videos<?php if(!$videos){ ?> hidden<?php } ?>">
			<div class="preview-head">
				<?php print fx_lang('attachments.videos_field_head') ?>
			</div>
			<div class="content-block">
				<?php if($videos){ ?>
					<?php foreach($videos as $video){ ?>
						<div id="video-<?php print $video['v_id'] ?>" class="video-item col-12 row m-0 p-0" onclick="attachmentsObj.selectAttachment(this,'videos',<?php print $video['v_id'] ?>)">
							<div class="icon col-1">
								<?php print fx_get_file_icon($video['v_name']) ?>
							</div>
							<div class="name col-8">
								<?php print fx_crop_string($video['v_name'],50) ?>
							</div>
							<div class="size col-2">
								<i class="fas fa-sd-card"></i>
								<?php print fx_prepare_memory($video['v_size']) ?>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
		</div>

		<div class="preview-audios<?php if(!$audios){ ?> hidden<?php } ?>">
			<div class="preview-head">
				<?php print fx_lang('attachments.audios_field_head') ?>
			</div>
			<div class="content-block">
				<?php if($audios){ ?>
					<?php foreach($audios as $audio){ ?>
						<div id="audio-<?php print $audio['au_id'] ?>" class="audio-item col-12 row m-0 p-0" onclick="attachmentsObj.selectAttachment(this,'audios',<?php print $audio['au_id'] ?>)">
							<div class="icon col-1">
								<?php print fx_get_file_icon($audio['au_name']) ?>
							</div>
							<div class="name col-8">
								<?php print fx_crop_string($audio['au_name'],50) ?>
							</div>
							<div class="size col-2">
								<i class="fas fa-sd-card"></i>
								<?php print fx_prepare_memory($audio['au_size']) ?>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
		</div>

		<div class="preview-files<?php if(!$files){ ?> hidden<?php } ?>">
			<div class="preview-head">
				<?php print fx_lang('attachments.files_field_head') ?>
			</div>
			<div class="content-block">
				<?php if($files){ ?>
					<?php foreach($files as $file){ ?>
						<div id="file-<?php print $file['f_id'] ?>" class="file-item col-12 row m-0 p-0" onclick="attachmentsObj.selectAttachment(this,'files',<?php print $file['f_id'] ?>)">
							<div class="icon col-1">
								<?php print fx_get_file_icon($file['f_name']) ?>
							</div>
							<div class="name col-8">
								<?php print fx_crop_string($file['f_name'],50) ?>
							</div>
							<div class="size col-2">
								<i class="fas fa-sd-card"></i>
								<?php print fx_prepare_memory($file['f_size']) ?>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>

	<div id="<?php print $attributes['name'] ?>-photos" data-type="photos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel">
						<?php print fx_lang('attachments.select_photos_modal_head') ?>
					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					...
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						<?php print $close_modal_button_value ?>
					</button>
					<button type="button" class="btn btn-success" data-dismiss="modal">
						<?php print $ready_modal_button_value ?>
					</button>
				</div>
			</div>
		</div>
	</div>
	<div id="<?php print $attributes['name'] ?>-videos" data-type="videos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel">
						<?php print fx_lang('attachments.select_videos_modal_head') ?>
					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					...
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						<?php print $close_modal_button_value ?>
					</button>
					<button type="button" class="btn btn-success" data-dismiss="modal">
						<?php print $ready_modal_button_value ?>
					</button>
				</div>
			</div>
		</div>
	</div>
	<div id="<?php print $attributes['name'] ?>-audios" data-type="audios" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel">
						<?php print fx_lang('attachments.select_audios_modal_head') ?>
					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					...
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						<?php print $close_modal_button_value ?>
					</button>
					<button type="button" class="btn btn-success" data-dismiss="modal">
						<?php print $ready_modal_button_value ?>
					</button>
				</div>
			</div>
		</div>
	</div>
	<div id="<?php print $attributes['name'] ?>-files" data-type="files" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel">
						<?php print fx_lang('attachments.select_files_modal_head') ?>
					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					...
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						<?php print $close_modal_button_value ?>
					</button>
					<button type="button" class="btn btn-success" data-dismiss="modal">
						<?php print $ready_modal_button_value ?>
					</button>
				</div>
			</div>
		</div>
	</div>

	<div class="photos-block-ajax-response hidden"></div>
	<div class="videos-block-ajax-response hidden"></div>
	<div class="audios-block-ajax-response hidden"></div>
	<div class="files-block-ajax-response hidden"></div>

</div>

<script>
	$(".attachments-field > .modal").on("show.bs.modal", function(){
		let self = this;
		let attachments_type = $(this).attr('data-type');
		let attachments_hidden_old_block = $('.' + attachments_type + '-block-ajax-response');
		let old_result = attachments_hidden_old_block.html();

		if(old_result){
			$('.modal-content>.modal-body',self).html(old_result);
			return true;
		}
		let selector_obj = $('.attachments-field.form-group.form-block.<?php print $attributes['params']['original_name'] ?>');
		let fields = $('.attachments-ids-block.hidden',selector_obj);

		let type_field = $('#' + attachments_type, fields);

		let field_values = type_field.attr('value');

		if(field_values){
			field_values = '/' + field_values;
		}

		$.ajax({
			url:'/attachments/' + attachments_type + field_values,
			method: 'GET',
			dataType: 'frame',
			complete: function(response){
				let result = response.responseText;
				$('.modal-content>.modal-body',self).html(result);
				attachments_hidden_old_block.html(result);				// футуре (селектед в старый аякс)
			}
		});
	});
	attachmentsObj.selectAttachment = function(self,attachment_type,attachment_id){
		attachment_id = attachment_id.toString();

		let values_array;
		let indexOf;

		let selector_obj = $('.attachments-field.form-group.form-block.<?php print $attributes['params']['original_name'] ?>');
		let fields = $('.attachments-ids-block.hidden',selector_obj);
		let previews = $('.attachments-data-block-previews',selector_obj);

		let type_field = $('#' + attachment_type, fields);
		let type_preview = $('.preview-' + attachment_type, previews);

		let field_values = type_field.attr('value');
		if(isset(field_values)){
			values_array = explode(',',field_values);
			indexOf = values_array.indexOf(attachment_id);

			let short_type = attachment_type.substr(0,attachment_type.length-1);

			if(indexOf === -1){
				attachmentsObj.addAttachment(self,field_values,attachment_id,type_preview,type_field,attachment_type,short_type);
				previews.removeClass('hidden');
				$(type_preview).removeClass('hidden');
				$(self).addClass('selected');
				$('a#' + attachment_id,'.' + attachment_type + '-block-ajax-response').addClass('selected');
			}else{
				attachmentsObj.removeAttachment(values_array,indexOf,type_field,attachment_type,attachment_id,type_preview,short_type);
				$(self).removeClass('selected');
				if($('.content-block',type_preview).text().trim().length === 0){
					$(type_preview).addClass('hidden');
				}
				$('a#' + attachment_id,'.' + attachment_type + '-block-ajax-response').removeClass('selected');
			}
		}
	};
	attachmentsObj.addAttachment = function(self,field_values,attachment_id,type_preview,type_field,attachment_type,short_type){
		let previewAttachmentString = '';
		field_values += ',' + attachment_id;
		type_field.attr('value',field_values.replace(/^,/,''));

		if(equal(attachment_type,'photos')){
			let image = $('img',self).attr('src');
			previewAttachmentString += '<div id="photo-' + attachment_id + '" class="photo-item" onclick="attachmentsObj.selectAttachment(this,\'' + attachment_type + '\',' + attachment_id + ')">'+
				'<img src="' + image + '">' +
				'</div>';
			$('.content-block',type_preview).append(previewAttachmentString);
		}else{
			previewAttachmentString += '<div id="' + short_type + '-' + attachment_id + '" class="' + short_type + '-item col-12 row m-0 p-0" onclick="attachmentsObj.selectAttachment(this,\'' + attachment_type + '\',' + attachment_id + ')">\n'+
				'<div class="icon col-1">\n' + $('.icon',self).html() + '</div>\n' +
				'<div class="name col-8">\n' + $('.name',self).html() + '</div>\n' +
				'<div class="size col-2">\n' + $('.size',self).html() + '</div>\n' +
				'<div>';
			$('.content-block',type_preview).append(previewAttachmentString);
		}
	};
	attachmentsObj.removeAttachment = function(values_array,indexOf,type_field,attachment_type,attachment_id,type_preview,short_type){
		values_array.splice(indexOf,1);
		type_field.attr('value',implode(',',values_array).replace(/^,/,''));
		if(equal(attachment_type,'photos')){
			$('.content-block #photo-' + attachment_id,type_preview).remove();
		}else{
			$('#' + short_type + '-' + attachment_id,type_preview).remove();
		}
	};
</script>
