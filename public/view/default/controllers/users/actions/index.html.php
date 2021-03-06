<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $users
	 */
	$lang = $this->language->getLanguageKey();
?>

<div class="row justify-content-center users-list mt-4">

	<div class="col-md-12 col-sm-12 col-12 col-lg-11 col-xl-11 p-0 list-group users">

		<?php foreach($users as $user){ ?>

			<?php $online = fx_is_online($user['u_date_log']) ?>

			<div class="list-group-item list-group-item-action users-item pb-1 pt-1 radius-0">

				<div class="users-info row ">

					<a href="<?php print fx_get_url('users','item',$user['u_id']) ?>" class="col-10 col-sm-10 col-md-10 col-xl-11 col-lg-11 row ml-0">

						<div class="users-item-avatar col-md-3 col-sm-3 col-4 col-lg-2 col-xl-2">

							<div class="avatar">

								<?php fx_print_avatar($user['p_small'],'small',$user['p_date_updated'],$user['u_gender'],$user['u_full_name'],$user['u_full_name']) ?>

								<div title="<?php print($online?fx_lang('users.user_is_online'):fx_lang('users.user_is_offline')) ?>" class="status status-<?php print($online?'online':'offline') ?>">
									<?php print fx_get_icon_logged($user['u_log_type']) ?>
								</div>

							</div>
						</div>

						<div class="col-md-7 col-sm-8 col-8 col-lg-10 col-xl-10 users-item-info">

							<div class="list-group-item-heading info full-name mt-1 mb-1">

								<?php print fx_get_full_name($user['u_full_name'],$user['u_gender']) ?>

							</div>

							<div class="list-group-item-text users-item-descriptions">

								<?php print($user["country"] ? $user["country"] . ", " : null) ?>
								<?php print($user["city"] ? $user["city"] : null) ?>

							</div>

						</div>

					</a>
					<?php if(isset($user['menu'])){ ?>
						<div class="dropdown col-2 col-sm-2 col-md-2 col-xl-1 col-lg-1 drop-down-user-menu">

							<button class="btn btn-info radius-0 dropdown-toggle menu-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-plus text-white"></i>
							</button>

							<div class="dropdown-menu dropdown-menu-right radius-0 menu-links pt-0 pb-0" aria-labelledby="dropdownMenuButton">

								<ul class="list-group menu-list">

									<?php foreach($user['menu'] as $user_menu_item){ ?>

										<li class="list-group-item radius-0 menu-list-item">

											<a class="p-2 menu-list-item-link <?php print $user_menu_item['link_class'] ?>" href="<?php print $user_menu_item['link'] ?>">

												<?php if($user_menu_item['link']){ ?>
													<i class="menu-list-item-link-icon <?php print $user_menu_item['icon'] ?>"></i>
												<?php } ?>

												<?php print $user_menu_item['value'] ?>
											</a>

										</li>

									<?php } ?>

								</ul>

							</div>
						</div>
					<?php } ?>
				</div>

			</div>

		<?php } ?>

	</div>

</div>