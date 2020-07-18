<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $user
	 * @var array $fields
	 */
	$lang = $this->language->getLanguageKey();
?>

<div class="user-visible-info col-12 row pt-2 mb-2">
	<div class="col-4">
		<?php print fx_lang('users.gender') ?>:
	</div>
	<div class="col-8">
		<a href="<?php print fx_make_url(array('users','index'),array('u_gender' => $user['u_gender'])) ?>">
			<?php print fx_lang("users.user_gender_{$user['u_gender']}") ?>
		</a>
	</div>
	<div class="col-4">
		<?php print fx_lang('users.field_set_birth_date') ?>:
	</div>
	<div class="col-8">
		<a href="<?php print fx_make_url(array('users','index'),array('u_birth_day' => $user['u_birth_day'],'u_birth_month' => $user['u_birth_month'])) ?>">
			<?php print $user['u_birth_day'] ?>
			<?php print fx_lang("home.month_gen_{$user['u_birth_month']}") ?>
		</a>
		<a href="<?php print fx_make_url(array('users','index'),array('u_birth_year' => $user['u_birth_year'])) ?>">
			<?php print $user['u_birth_year'] ?>
		</a>
	</div>
	<div class="col-4">
		<?php print fx_lang('users.family') ?>:
	</div>
	<div class="col-8">
		<a href="<?php print fx_make_url(array('users','index'),array('u_family' => $user['u_family'])) ?>">
			<?php print fx_lang("users.users_family_{$user['u_family']}") ?>
		</a>
	</div>
	<div class="col-4">
		<?php print fx_lang('users.city') ?>:
	</div>
	<div class="col-8">
		<a href="<?php print fx_make_url(array('users','index'),array('u_country_id' => $user['u_country_id'],'u_city_id' => $user['u_city_id'])) ?>">
			<?php print $user["g_title_{$lang}"] ?>,
			<?php print($user["gc_area"] ? $user['gc_area'] . ", " : null) ?>
			<?php print $user["gc_title_{$lang}"] ?>
		</a>
	</div>
</div>