<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $user
	 * @var array $fields
	 */
?>

<div class="user-invisible-info mb-4">
	<div class="simple-accordion accordion">
		<div class="accordion-buttons-link justify-content-center row collapsed" data-toggle="collapse" data-target="#hidden-info" aria-expanded="false" aria-controls="collapseOne">
			<div class="col-12 accordion-buttons-block justify-content-center row">
				<span id="hidden-info" class="accordion-button collapse show">
					<?php print fx_lang('home.show_more_info') ?>
				</span>
				<span id="hidden-info" class="accordion-button collapse">
					<?php print fx_lang('home.hide_more_info') ?>
				</span>
			</div>
		</div>
		<div class="dropdown-user-info col-12 row collapse mt-2" id="hidden-info" aria-expanded="true" style="">
			<?php foreach($fields as $field_set=>$field){ ?>
				<?php
					$fields_string_result = null;
					foreach($field as $key=>$value){
						if(!$value['attributes']['params']['show_in_item']){ continue; }
						if(fx_equal($value['attributes']['params']['item_position'],'visible')){ continue; }
						$value['value'] = $user[$key];

						$fields_string_result .= "<div class=\"col-4\">{$value['attributes']['params']['label']}:</div>";
						$fields_string_result .= "<div class=\"col-8\">";
						$fields_string_result .= !$user[$key] ? '<div class="empty-value"></div>' : $this->renderField(
							$value,"controllers/users/fields/{$value['attributes']['params']['render_type']}"
						);
						$fields_string_result .= "</div>";
					}
				?>

				<?php if($fields_string_result){ ?>
					<div class="field-set-value col-12 p-0">
						<?php print fx_lang("users.{$field_set}") ?>
					</div>
					<?php print $fields_string_result ?>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>