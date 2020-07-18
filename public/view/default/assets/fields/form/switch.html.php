<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $attributes */
	/** @var array $errors */
	/** @var string $field_string */

	$errors_status = isset($errors) && !empty($errors);

	if(!empty($attributes['value'])){
		$attributes['checked'] = true;
	}

	if($attributes['params']['validate_status'] && $attributes['params']['show_validation']){
		$attributes['class'] .= " is-";
		if($errors_status){
			$attributes['class'] .= "in";
		}
		$attributes['class'] .= "valid";
	}

	$attributes['class'] .= ' custom-control-input';

	if(!$attributes['params']['show_title_in_form']){ unset($attributes['title']); }

	$field_string = $this->getAttributesStringFromArray($attributes);
?>

<div class="form-check form-block <?php print $attributes['params']['original_name'] ?> custom-control custom-switch <?php print $attributes['params']['field_sets_field_class'] ?>">

	<?php if($errors_status){ ?>

		<?php foreach($errors as $item) { ?>

			<div class="invalid-feedback">

				<?php print $item ?>

			</div>

		<?php } ?>

	<?php } ?>

	<input <?php print $field_string ?>>

	<?php if($attributes['params']['show_label_in_form']){ ?>

		<label class="custom-control-label" for="<?php print $attributes['id'] ?>">

			<?php print $attributes['params']['label'] ?>

		</label>

	<?php } ?>

</div>