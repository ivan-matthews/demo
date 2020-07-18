<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $user
	 * @var array $fields
	 */
?>

<div class="user-header-info row">
	<div class="user-name col-6">
		<?php print fx_get_full_name($user['u_full_name'],$user['u_gender']) ?>
	</div>
	<div class="user-date-log col-6 text-right<?php print(fx_is_online($user['u_date_log'])?' online':' offline') ?>">
		<span class="icon-logged">
			<?php print fx_get_icon_logged($user['u_log_type']) ?>
		</span>
		<span class="date-logged">
			<?php print fx_online_status($user['u_date_log']) ?>
		</span>
	</div>
</div>