<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $users
	 */
	$lang = $this->language->getLanguageKey();
?>

<div class="row justify-content-center users-list">

	<div class="col-md-12 col-sm-12 col-12 col-lg-11 col-xl-11 p-0 list-group users">

		<?php foreach($users as $user){ ?>

			<?php $online = fx_is_online($user['u_date_log']) ?>

			<div class="list-group-item list-group-item-action users-item pb-1 pt-1 radius-0">

				<div class="users-info row ">

					<a href="<?php print fx_get_url('users','item',$user['u_id']) ?>" class="col-11 row ml-0">

						<div class="users-item-avatar col-md-3 col-sm-3 col-3 col-lg-2 col-xl-2">

							<div class="avatar">

								<?php fx_print_avatar($user['p_small'],'small',$user['u_gender'],$user['u_full_name'],$user['u_full_name']) ?>

								<div title="<?php print($online?fx_lang('users.user_is_online'):fx_lang('users.user_is_offline')) ?>" class="status status-<?php print($online?'online':'offline') ?>">
									<?php print fx_get_icon_logged($user['u_log_type']) ?>
								</div>

							</div>
						</div>

						<div class="col-md-7 col-sm-8 col-9 col-lg-10 col-xl-10 users-item-info">

							<div class="list-group-item-heading info full-name mt-1 mb-1">

								<?php print fx_get_full_name($user['u_full_name'],$user['u_gender']) ?>

							</div>

							<div class="list-group-item-text users-item-descriptions">

								<?php print($user["g_title_{$lang}"] ? $user["g_title_{$lang}"] . ", " : null) ?>
								<?php print($user["gr_title_{$lang}"] ? $user["gr_title_{$lang}"] . ", " : null) ?>
								<?php print($user["gc_area"] ? $user['gc_area'] . ", " : null) ?>
								<?php print($user["gc_title_{$lang}"] ? $user["gc_title_{$lang}"] : null) ?>

							</div>

						</div>

					</a>

				</div>

			</div>

		<?php } ?>

	</div>

</div>