<?php

	/** @var array $data */
	/** @var array $form */
	/** @var array $fields */
	/** @var array $errors */

	/** @var \Core\Classes\View $this */

	$submit = $form['submit'];

	unset($form['submit']);

	$form_attributes_string = $this->getAttributesStringFromArray($form);
?>

<form <?php print $form_attributes_string?>>

	<?php foreach($this->prepareFormFieldsToFieldSets($fields) as $field_set_key=>$field_set_value){ ?>

		<fieldset class="form-group <?php print $field_set_key ?>">

			<div class="form-row">

				<?php foreach($field_set_value as $field){ ?>

					<?php if(!$field['attributes']['params']['show_in_form']){ continue; } ?>

					<?php if($form['name'] && !fx_equal($field['attributes']['name'],$this->config->session['csrf_key_name'])){
						$field['attributes']['name'] = "{$form['name']}[{$field['attributes']['name']}]";
					} ?>

					<?php $field_path = "assets/fields/form/{$field['attributes']['params']['field_type']}"; ?>

					<?php print $this->renderField($field,$field_path) ?>

				<?php } ?>

			</div>

		</fieldset>

	<?php } ?>

	<?php if(!$submit){ ?>

		<div class="text-center submit">
			<input class="btn btn-primary" type="submit">
		</div>

	<?php } ?>

</form>
