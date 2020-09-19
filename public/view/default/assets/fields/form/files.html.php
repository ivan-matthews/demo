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

<div class="files-type-field form-group form-block <?php print $attributes['params']['original_name'] ?> <?php print $attributes['params']['field_sets_field_class'] ?>">

	<?php if($errors_status){ ?>

		<?php foreach($errors as $item) { ?>

			<div class="invalid-feedback">

				<?php print $item ?>

			</div>

		<?php } ?>

	<?php } ?>

	<label class="row justify-content-center files files-field-block">
		<div class="files col-8 text-center upload-file">
			<i class="fas fa-file-upload mb-4"></i>
		</div>
		<div class="btn btn-success col-8 upload-button">
			<?php print $attributes['params']['label'] ?>
		</div>
		<input data-id="orig" <?php print $field_string ?>>
	</label>

</div>

<div class="col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12 p-0 list-group files-list hidden"></div>

<script>
	$(document).ready(function(){
		indexObj.form_object = $('.files-type-field').parents('form');
		indexObj.button_submit = $('[type=submit]',indexObj.form_object);
		indexObj.button_submit.hide();
	});
	$('.files-type-field input[type=file]').change(function(){

		if(this.files && this.files[0]){
			let file_icon;
			let files_list = $('.files-list');
			indexObj.button_submit.show();

			$('.files-field-block').hide();

			$.each(this.files,function(i,v){
				file_icon = indexObj.getFileIcon(v.name);

				files_list.removeClass('hidden');
				files_list.append('<div id="iterator-' + i + '" class="list-group-item list-group-item-action files-item pb-1 pt-1 radius-0">\n' +
						'\n' +
						'<div class="files-info row">\n' +
						'<div class="col-2 col-sm-2 col-md-1 col-xl-1 col-lg-1">\n' +
						'<div class="icon"><i class="' + file_icon + '"></i></div>\n' +
						'</div>\n' +
						'<div class="col-10 col-sm-10 col-md-11 col-xl-11 col-lg-11">\n' +
						'<div class="name">\n' +
						v.name +
						'</div>\n' +
						'<div class="size">\n' +
						indexObj.prepareMemory(v.size) +
						'</div>' +
						'</div>\n' +
						'\n' +
						'</div>\n' +
						'\n' +
						'</div>'
					);
			});
		}
	});
</script>














