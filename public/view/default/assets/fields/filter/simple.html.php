<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $attributes */
	/** @var array $errors */
	/** @var string $field_string */

	if(!$attributes['params']['show_title_in_form']){ unset($attributes['title']); }

	$field_string = $this->getAttributesStringFromArray($attributes);
?>

<?php if($attributes['params']['show_label_in_form']){ ?>

	<label class="form-check-label" for="<?php print $attributes['id'] ?>">

		<?php print $attributes['params']['label'] ?>

	</label>

<?php } ?>

<input <?php print $field_string ?>>
