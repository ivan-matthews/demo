<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $groups
	 * @var array $user
	 */
?>

<div class="col-12 user-info-panel m-0 p-0">
	<div class="card radius-0 col-12 p-0 m-0 mt-2 user-card">

		<div class="card-header pt-2 pb-2">
			<?php print fx_lang('users.registration_date') ?>
		</div>
		<ul class="list-group list-group-flush card-body p-0 pb-0 mb-0">
			<li class="list-group-item pt-2 pb-2 reg-date">
				<?php print fx_get_date($user['u_date_created']) ?>
			</li>
		</ul>
		<div class="card-header pt-2 pb-2">
			<?php print fx_lang('users.user_groups_list',array('%full_name%'=>'')) ?>
		</div>
		<ul class="list-group list-group-flush card-body p-0 pt-0 pb-0">
			<li class="list-group-item pt-2 pb-2 user-groups">
				<?php
					$groups_string = '';
					foreach($groups as $group){
						$groups_string .= "<div class=\"user-group {$group['ug_name']}\">";
						$groups_string .= fx_lang("users.user_group_{$group['ug_name']}");
						$groups_string .= "</div> ";
					}
					$groups_string = rtrim($groups_string,', ');
					print $groups_string
				?>
			</li>
		</ul>
	</div>
</div>