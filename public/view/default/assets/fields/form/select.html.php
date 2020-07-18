<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $attributes */
	/** @var array $errors */
	/** @var string $field_string */

	if(!$attributes['params']['show_title_in_form']){ unset($attributes['title']); }

	$attributes['class'] .= ' mb-3';

	$field_string = $this->getAttributesStringFromArray($attributes);
?>

<?php if($attributes['params']['show_label_in_form']){ ?>

	<label class="form-check-label" for="<?php print $attributes['id'] ?>">

		<?php print $attributes['params']['label'] ?>

	</label>

<?php } ?>

<select <?php print $field_string ?> value="0">
	<option value="0" class="empty-value"><?php print fx_lang('fields.selected_not_select') ?></option>
	<?php foreach($attributes['params']['variants'] as $key=>$variant){ ?>
		<option value="<?php print $key ?>"<?php print(fx_equal((int)$attributes['value'],$key) ? ' selected':'') ?>><?php print $variant ?></option>
	<?php } ?>
</select>
