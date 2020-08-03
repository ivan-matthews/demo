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
			<div class="input-group mt-2">
				<div class="input-group-prepend">

					<div class="input-group-text radius-0 search-icon">

						<i class="fa fa-search" aria-hidden="true"></i>

					</div>
				</div>
				<?php foreach($content['fields'] as $field_set_key=>$field_set_value){ ?>

					<?php foreach($field_set_value as $field){ ?>

						<?php if(!$field['attributes']['params']['show_in_filter']){ continue; } ?>

						<?php $field['attributes']['class'] .= " input-group-internal" ?>

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
						<i class="fa fa-filter" aria-hidden="true"></i>
					</button>
					<button class="btn btn-default" type="submit">
						<i class="fa fa-search" aria-hidden="true"></i>
					</button>
					<?php if($content['data']){ ?>
						<a href="<?php print $content['form']['action'] ?>" class="btn btn-danger radius-0" type="submit">
							<i class="fa fa-times" aria-hidden="true"></i>
						</a>
					<?php } ?>

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

						<div class="field mb-2 mt-2 btn-group btn-group-toggle row col-12">
							<button class="btn btn-success radius-0" type="submit">
								<i class="fa fa-search" aria-hidden="true"></i>
								<?php print fx_lang('home.filter_button_search_value') ?>
							</button>
							<?php if($content['data']){ ?>
								<a href="<?php print $content['form']['action'] ?>" class="btn btn-danger radius-0" type="submit">
									<i class="fa fa-times" aria-hidden="true"></i>
									<?php print fx_lang('home.filter_button_drop_value') ?>
								</a>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</form>

	</div>
</div>