<?php
	use Core\Classes\View;

	/** @var View $this */
	/** @var array $data */
	/** @var array $attributes */
	/** @var array $errors */
	/** @var string $field_string */

	$errors_status = isset($errors) && !empty($errors);

	$field_string = $this->getAttributesStringFromArray($attributes);

	$preview_content_orig = "<i class=\"fas fa-camera\"></i>";

	$image_params = $attributes['params'];

?>

<div class="image-preview <?php print $attributes['id'] ?> <?php print $attributes['params']['field_sets_field_class'] ?>" style="display:none">
	<div class="img position-relative">

	</div>
</div>

<div class="image-field form-group form-block <?php print $attributes['params']['original_name'] ?> <?php print $attributes['params']['field_sets_field_class'] ?>">

	<div class="image-inputs <?php print $attributes['id'] ?>">
		<input <?php print $field_string ?> >
		<input id="<?php print $attributes['id'] ?>" class="image-preview-src" type="hidden" name="preview_image">
	</div>

	<a type="button" class="btn btn-primary select-image-button" data-toggle="modal" data-target=".bd-example-modal-lg">
		<?php print $attributes['params']['label']  ?>
	</a>

	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel">
						<?php print fx_lang('avatar.select_image_modal_head') ?>
					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					...
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

</div>

<script>
	selectImageAndAddToPreview = function(image_id,image_src){
		$('.image-inputs.<?php print $attributes['id'] ?> input[name="<?php print $attributes['name'] ?>"]').val(image_id);
		$('.image-inputs.<?php print $attributes['id'] ?> input[name="preview_image"]').val(image_src);

		$('div.image-preview.<?php print $attributes['id'] ?> .img').html(
			'<img src="' + image_src + '"/>' +
			'<div class="deletion-link mt-2">' +
			'<a href="javascript:deleteImageFromPreviewList()" class="p-1 mt-1">' +
			'<i class="fas fa-times mr-2"></i>' +
			'<?php print fx_lang('avatar.delete_preview_image') ?></a>' +
			'</div>'
		);
		$('div.image-preview.<?php print $attributes['id'] ?>').show();
		$('a.select-image-button').hide();
		$('button[data-dismiss="modal"]').click();
	};

	deleteImageFromPreviewList = function(){
		$('.image-inputs.<?php print $attributes['id'] ?> input[name="<?php print $attributes['name'] ?>"]').val('');
		$('.image-inputs.<?php print $attributes['id'] ?> input[name="preview_image"]').val('');

		$('div.image-preview.<?php print $attributes['id'] ?>').hide();
		$('a.select-image-button').show();
	};

	$(".image-field > .modal").on("show.bs.modal", function(e){
		let self = this;
		$.ajax({
			url:'<?php print fx_get_url('avatar','images') ?>',
			method: 'GET',
			dataType: 'frame',
			complete: function(response){
				$('.modal-content>.modal-body').html(response.responseText);
			}
		});
	});
</script>