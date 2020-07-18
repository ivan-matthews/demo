<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $user
	 * @var array $fields
	 */
?>

<div class="user-visible-info col-12 row pt-2 mb-2">
	<div class="col-4">
		<?php print fx_lang('users.gender') ?>:
	</div>
	<div class="col-8">
		<?php print fx_lang("users.user_gender_{$user['u_gender']}") ?>
	</div>
	<div class="col-4">
		<?php print fx_lang('users.field_set_birth_date') ?>:
	</div>
	<div class="col-8">
		<?php print $user['u_birth_day'] ?>
		<?php print fx_lang("home.month_gen_{$user['u_birth_month']}") ?>
		<?php print $user['u_birth_year'] ?>
	</div>
	<div class="col-4">
		<?php print fx_lang('users.family') ?>:
	</div>
	<div class="col-8">
		<?php print fx_lang("users.users_family_{$user['u_family']}") ?>
	</div>
</div>