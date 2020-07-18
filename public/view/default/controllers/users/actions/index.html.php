<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $users
	 */
?>

<div class="row justify-content-center users">

	<div class="col-md-12 col-sm-12 col-12 col-lg-10 col-xl-10 p-0 list-group users-list">

		<?php foreach($users as $user){ ?>

			<?php $online = fx_is_online($user['u_date_log']) ?>

			<div class="list-group-item list-group-item-action users-item-link pb-1 pt-1">

				<div class="users-info row ">

					<a href="<?php print fx_get_url('users','item',$user['u_id']) ?>" class="col-11 row ml-0">

						<div class="col-md-3 col-sm-3 col-5 col-lg-2 col-xl-2">

							<div class="users-item-avatar">

								<img src="<?php $this->printUploadSiteRoot('images/avatars/micro122b22ae96d2c8e934e31b6c84ced4d1e.jpeg') ?>" title="<?php print $user['u_full_name'] ?>" alt="<?php print $user['u_full_name'] ?>">

								<div title="<?php print($online?fx_lang('users.user_is_online'):fx_lang('users.user_is_offline')) ?>" class="status status-<?php print($online?'online':'offline') ?>">
									<?php print fx_get_icon_logged($user['u_log_type']) ?>
								</div>

							</div>
						</div>

						<div class="col-md-7 col-sm-8 col-7 col-lg-10 col-xl-10">

							<div class="list-group-item-heading users-item-info mt-1 mb-3">

								<?php print $user['u_full_name'] ?>

							</div>

							<div class="list-group-item-text users-item-descriptions">
								<?php print 'г. Крыжопиль' ?>
							</div>

						</div>

					</a>

				</div>

			</div>

		<?php } ?>

	</div>

</div>