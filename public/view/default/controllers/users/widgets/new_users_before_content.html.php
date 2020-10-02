<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $content
	 * @var array $options
	 */
//fx_die($content)
?>
<?php if($content){ ?>
	<?php if($options['wa_show_title']){ ?>
		<a href="<?php print fx_get_url('users','index','all') ?>" class="before-content-widget-header">
			<div class="row justify-content-center widget-header">
				<div class="col-12 before-content-title title">
					<?php print fx_lang($options['wa_title']) ?>
				</div>
			</div>
		</a>
	<?php } ?>
	<div class="users-list row justify-content-center before-content-widget-body">
		<div class="col-12 users row">
			<?php foreach($content as $user){ ?>

				<?php $online = fx_is_online($user['u_date_log']) ?>

				<div class="users-item col-4 col-sm-4 col-md-4 col-lg-3 col-xl-2 mt-2 mb-2">

					<a class="users-item-link" href="<?php print fx_get_url('users','item',$user['u_id']) ?>">

						<div class="avatar">
							<?php fx_print_avatar($user['p_medium'],'medium',$user['p_date_updated'],$user['u_gender'],$user['u_full_name'],$user['u_full_name']) ?>
							<div title="<?php print($online?fx_lang('users.user_is_online'):fx_lang('users.user_is_offline')) ?>" class="status status-<?php print($online?'online':'offline') ?>">
								<?php print fx_get_icon_logged($user['u_log_type']) ?>
							</div>
						</div>
						<div class="users-item-title">
							<?php print fx_get_full_name($user['u_full_name'],$user['u_gender']) ?>
						</div>

					</a>

				</div>

			<?php } ?>
		</div>
	</div>
<?php } ?>