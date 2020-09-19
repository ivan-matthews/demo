<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $attributes */
	/** @var array $errors */
	/** @var string $field_string */

	$errors_status = isset($errors) && !empty($errors);

	$value = $attributes['value'];
	unset($attributes['value']);

	if($attributes['params']['validate_status'] && $attributes['params']['show_validation']){
		$attributes['class'] .= " is-";
		if($errors_status){
			$attributes['class'] .= "in";
		}
		$attributes['class'] .= "valid";
	}

	if(!$attributes['params']['show_title_in_form']){ unset($attributes['title']); }

	$field_string = $this->getAttributesStringFromArray($attributes);

	$this->renderAsset("../wysiwygs/{$attributes['params']['wysiwyg']}/config",$attributes);
?>

<div class="field-post form-group form-block <?php print $attributes['params']['original_name'] ?> <?php print $attributes['params']['field_sets_field_class'] ?>">

	<?php if($attributes['params']['show_label_in_form']){ ?>

		<label class="form-check-label" for="<?php print $attributes['id'] ?>">
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

	<textarea <?php print $field_string ?>><?php print $value ?></textarea>

</div>
