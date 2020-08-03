<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $attributes */
	/** @var array $errors */
	/** @var string $field_string */

	$errors_status = isset($errors) && !empty($errors);

	$attributes['class'] .= " hidden";

	$field_string = $this->getAttributesStringFromArray($attributes);

	$preview_content_orig = "<i class=\"fas fa-camera\"></i>";

	$this->prependCSS("{$this->theme_path}/css/libs/rcrop");
	$this->prependJS("{$this->theme_path}/js/libs/rcrop");

	$image_params = $attributes['params']['image_params'];
?>

<div class="form-group row m-0 justify-content-center form-block <?php print $attributes['params']['original_name'] ?> <?php print $attributes['params']['field_sets_field_class'] ?>">

	<?php if($errors_status){ ?>

		<?php foreach($errors as $item) { ?>

			<div class="invalid-feedback">

				<?php print $item ?>

			</div>

		<?php } ?>

	<?php } ?>

	<div class="col-6 original">
		<div id="image-wapper"></div>
		<div class="image-form">
			<label class="form-check-label image-label">
			<span id="image">
				<?php print $preview_content_orig ?>
			</span>
				<input <?php print $field_string ?>>
			</label>
		</div>
	</div>

	<div class="col-6 preview hidden justify-content-center">

		<?php foreach($image_params as $param_key_block=>$param_value_block){ ?>

			<div class="preview-content <?php print $param_key_block ?>">

				<?php print $preview_content_orig ?>

			</div>

		<?php } ?>

	</div>

</div>

<script>
	$('[name=avatar]').on("change",function(){
		$('.avatar .preview').removeClass('hidden');
		if(this.files && this.files[0]){
			let image_block = $('#image-wapper');

			$('.original .image-form').hide();
			image_block.html("<img id=\"image_avatar\" class=\"preview-avatar\" src=\"\">");

			let reader = new FileReader();

			reader.onload = function(e){
				$('#image_avatar',image_block).attr('src',e.target.result);
				cropAvatar();
			};
			reader.readAsDataURL(this.files[0]);
		}
	});

	cropAvatar = function(){
		let image = $('#image_avatar');
		image.rcrop({
			minSize : [<?php print $image_params['normal']['width'] ?>,<?php print $image_params['normal']['height'] ?>],
			maxSize : [<?php print $image_params['normal']['width'] ?>,<?php print $image_params['normal']['height'] ?>],
			preserveAspectRatio : true,
		});

		image.on('rcrop-changed', function(){

			<?php foreach($image_params as $param_key=>$param_value){ ?>

				let <?php print $param_key ?> = $(this).rcrop('getDataURL', <?php print $param_value['width'] ?>,<?php print $param_value['height'] ?>);
				$('.avatar .preview .<?php print $param_key ?>').html('<img src="' + <?php print $param_key ?> + '">');

			<?php } ?>
		})
	};


</script>