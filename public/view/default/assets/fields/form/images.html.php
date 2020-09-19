<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $attributes */
	/** @var array $errors */
	/** @var string $field_string */

	$errors_status = isset($errors) && !empty($errors);

	$attributes['value'] = htmlspecialchars($attributes['value']);

	if($attributes['params']['validate_status'] && $attributes['params']['show_validation']){
		$attributes['class'] .= " is-";
		if($errors_status){
			$attributes['class'] .= "in";
		}
		$attributes['class'] .= "valid";
	}

	if(!$attributes['params']['show_title_in_form']){ unset($attributes['title']); }

	$attributes['class'] .= " hidden";
	$field_string = $this->getAttributesStringFromArray($attributes);
?>

<div class="images-type-field form-group form-block <?php print $attributes['params']['original_name'] ?> <?php print $attributes['params']['field_sets_field_class'] ?>">

	<?php if($errors_status){ ?>

		<?php foreach($errors as $item) { ?>

			<div class="invalid-feedback">

				<?php print $item ?>

			</div>

		<?php } ?>

	<?php } ?>
	<?php if($attributes['required']){ ?>
		<span class="required text-danger">
			*
		</span>
	<?php } ?>
	<label class="row justify-content-center images images-field-block">
		<div class="images col-8 text-center upload-image">
			<i class="fas fa-camera"></i>
		</div>
		<div class="btn btn-success col-8 upload-button">
			<?php print $attributes['params']['label'] ?>
		</div>
		<input data-id="orig" <?php print $field_string ?>>
	</label>

</div>

<div class="col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12 p-0 list-group photos-list hidden"></div>

<script>
	$(document).ready(function(){
		photosObj.form_object = $('.images-type-field').parents('form');
		photosObj.button_submit = $('[type=submit]',photosObj.form_object);
		photosObj.button_submit.hide();
	});
	$('.images-type-field input[type=file]').change(function(){

		if(this.files && this.files[0]){
			let photos_list = $('.photos-list');
			photosObj.button_submit.show();

			$('.images-field-block').hide();

			$.each(this.files,function(i,v){

				photos_list.removeClass('hidden');
				photos_list.append('<div id="iterator-' + i + '" class="list-group-item list-group-item-action photos-item pb-1 pt-1 radius-0">\n' +
						'\n' +
						'<div class="photos-info row">\n' +
						'<div class="col-4 col-sm-4 col-md-3 col-xl-2 col-lg-3">\n' +
						'<img id="' + i + '" src="">\n' +
						'</div>\n' +
//						'<div class="col-6 col-sm-6 col-md-7 col-xl-8 col-lg-7">\n' +
						'<div class="col-8 col-sm-8 col-md-9 col-xl-10 col-lg-9">\n' +
						'<div class="name">\n' +
						v.name +
						'</div>\n' +
						'<div class="size">\n' +
						indexObj.prepareMemory(v.size) +
						'</div>' +
						'</div>\n' +
//					<<кнопка `[trash_box_icon] удалить` бегин>>
//
//						'<div class="col-2 buttons">\n' +
//							'<a class="row p-1" href="javascript:photosObj.removeImagePreview(' + i + ')">\n' +
//								'<i class="mr-2 far fa-trash-alt"></i>' +
//								'<?php //print fx_lang('photos.delete_link_value') ?>' +
//							'</a>\n' +
//						'</div>\n' +
//
//					<<кнопка `[trash_box_icon] удалить` енд>>
						'\n' +
						'</div>\n' +
						'\n' +
						'</div>'
					);

				let reader = new FileReader();
				reader.onload = function(event){
					$('img#' + i).attr('src',event.target.result)
				};
				reader.readAsDataURL(v);
			});
		}
	});
</script>














