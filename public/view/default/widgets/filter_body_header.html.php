<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $content
	 */

	$form_attributes_string = $this->getAttributesStringFromArray($content['form']);
	$content['fields'] = $this->prepareFormFieldsToFieldSets($content['fields']);
	unset($content['fields']['csrf']);
?>

<div class="filter">

	<div class="filter-panel">

		<form <?php print $form_attributes_string?>>
			<div class="input-group mt-3">
				<?php foreach($content['fields'] as $field_set_key=>$field_set_value){ ?>

					<?php foreach($field_set_value as $field){ ?>

						<?php if(!$field['attributes']['params']['show_in_filter']){ continue; } ?>

						<?php if(fx_equal('visible',$field['attributes']['params']['filter_position'])){ ?>

							<?php if($content['form']['name'] && !fx_equal($field['attributes']['name'],$this->config->session['csrf_key_name'])){
								$field['attributes']['name'] = "{$content['form']['name']}[{$field['attributes']['name']}]";
							} ?>

							<?php print $this->renderField($field,"assets/fields/filter/{$field['attributes']['params']['field_type']}") ?>

						<?php } ?>

					<?php } ?>

				<?php } ?>
				<div class="input-group-append">

					<button type="button" class="btn btn-light more" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-search" aria-hidden="true"></i>
					</button>
					<button class="btn btn-primary" type="submit">
						Искать
					</button>

					<div class="dropdown-menu dropdown-menu-right pb-0 pt-0 pr-3 pl-3 radius-0 do-not-close">

						<?php foreach($content['fields'] as $field_set_key=>$field_set_value){ ?>
							<?php foreach($field_set_value as $field){ ?>
								<?php if(!$field['attributes']['params']['show_in_filter']){ continue; } ?>

								<?php if(!fx_equal('visible',$field['attributes']['params']['filter_position'])){ ?>
									<?php if($content['form']['name'] && !fx_equal($field['attributes']['name'],$this->config->session['csrf_key_name'])){
										$field['attributes']['name'] = "{$content['form']['name']}[{$field['attributes']['name']}]";
									} ?>

									<div class="field mt-2">
										<?php print $this->renderField($field,"assets/fields/filter/{$field['attributes']['params']['field_type']}") ?>

									</div>

								<?php } ?>
							<?php } ?>
						<?php } ?>

						<div class="field mb-2 mt-2">

							<button class="btn btn-success" type="submit">
								Искать
							</button>
							<a href="<?php print $content['form']['action'] ?>" class="btn btn-danger" type="submit">
								сбросить фильтр
							</a>
						</div>
					</div>
				</div>
			</div>
		</form>

	</div>
</div>