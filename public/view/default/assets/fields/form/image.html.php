<?php
	use Core\Classes\View;

	/** @var View $this */
	/** @var array $data */
	/** @var array $attributes */
	/** @var array $errors */
	/** @var string $field_string */

	$errors_status = isset($errors) && !empty($errors);

	$field_string = $this->getAttributesStringFromArray($attributes);

	$image_params = $attributes['params'];

	$image_preview_value = $this->request->get('preview_image');

	$this->prependCSS("attachments");
	$this->prependJS("attachments");
?>

<div class="image-preview <?php print $attributes['id'] ?> <?php print $attributes['params']['field_sets_field_class'] ?>" <?php if(!$image_preview_value){ ?>style="display:none"<?php } ?>>
	<div class="img position-relative">
		<?php if($image_preview_value){ ?>
			<img src="<?php print $this->getUploadSiteRoot($image_preview_value) ?>"/>
			<div class="deletion-link mt-2">
				<a href="javascript:attachmentsObj.deleteImageFromPreviewList()" class="p-1 mt-1">
					<i class="fas fa-times mr-2"></i>
					<?php print fx_lang('photos.delete_preview_image') ?>
				</a>
			</div>
		<?php } ?>
	</div>
</div>

<div class="image-field form-group form-block <?php print $attributes['params']['original_name'] ?> <?php print $attributes['params']['field_sets_field_class'] ?>">

	<div class="image-inputs <?php print $attributes['id'] ?>">
		<input <?php print $field_string ?> >
		<input value="<?php print $image_preview_value ?>" id="<?php print $attributes['id'] ?>" class="image-preview-src" type="hidden" name="preview_image">
	</div>

	<?php if($errors_status){ ?>

		<?php foreach($errors as $item) { ?>

			<div class="invalid-feedback">

				<?php print $item ?>

			</div>

		<?php } ?>

	<?php } ?>

	<a type="button" class="btn btn-primary select-image-button" data-toggle="modal" data-target=".bd-example-modal-lg" <?php if($image_preview_value){ ?>style="display:none"<?php } ?>>
		<?php print $attributes['params']['label']  ?>
	</a>

	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel">
						<?php print fx_lang('photos.select_image_modal_head') ?>
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
						<?php print fx_lang('photos.close_modal_window') ?>
					</button>
				</div>
			</div>
		</div>
	</div>

</div>

<script>
	attachmentsObj.selectImageAndAddToPreview = function(image_id,image_src){
		let path = '<?php print $this->getUploadSiteRoot(null)  ?>';

		$('.image-inputs.<?php print $attributes['id'] ?> input[name="<?php print $attributes['name'] ?>"]').val(image_id);
		$('.image-inputs.<?php print $attributes['id'] ?> input[name="preview_image"]').val(image_src);

		$('div.image-preview.<?php print $attributes['id'] ?> .img').html(
			'<img src="' + path + image_src + '"/>' +
			'<div class="deletion-link mt-2">' +
			'<a href="javascript:attachmentsObj.deleteImageFromPreviewList()" class="p-1 mt-1">' +
			'<i class="fas fa-times mr-2"></i>' +
			'<?php print fx_lang('photos.delete_preview_image') ?></a>' +
			'</div>'
		);
		$('div.image-preview.<?php print $attributes['id'] ?>').show();
		$('a.select-image-button').hide();
		$('button[data-dismiss="modal"]').click();
	};

	attachmentsObj.deleteImageFromPreviewList = function(){
		$('.image-inputs.<?php print $attributes['id'] ?> input[name="<?php print $attributes['name'] ?>"]').val('');
		$('.image-inputs.<?php print $attributes['id'] ?> input[name="preview_image"]').val('');

		$('div.image-preview.<?php print $attributes['id'] ?>').hide();
		$('a.select-image-button').show();
	};

	$(".image-field > .modal").on("show.bs.modal", function(e){
		let self = this;
		let attachments_hidden_old_block = $('.photo-block-ajax-response');
		let old_result = attachments_hidden_old_block.html();

		if(old_result){
			$('.modal-content>.modal-body',self).html(old_result);
			return true;
		}
		$.ajax({
			url:'<?php print fx_get_url('attachments','photo') ?>',
			method: 'GET',
			dataType: 'frame',
			complete: function(response){
				$('.modal-content>.modal-body', self).html(response.responseText);
				attachments_hidden_old_block.html(response.responseText);
			}
		});
	});
</script>


<div class="hidden photo-block-ajax-response"></div>