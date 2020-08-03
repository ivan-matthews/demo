<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $notices */
	/** @var string $total */

	$this->addCSS("{$this->theme_path}/css/notify");
	$this->prependJS("{$this->theme_path}/js/notify");
?>

<div class="m-0 mb-4 notices-list row justify-content-center">

	<div class="col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12 notices row list-group p-0">

		<?php foreach($notices as $notice){ ?>

			<?php $notice_manager_name	= "notice_manager_name_{$notice['n_manager_id']}" ?>

			<div class="list-group-item list-group-item-action notices-item pb-1 pt-1 radius-0 status-<?php print $notice['n_status'] ?>">

				<div class="notices-info row ">

					<div class="col-12 row ml-0">

						<div class="notices-item-image col-md-3 col-sm-3 col-3 col-lg-2 col-xl-2 p-0 pl-2 pr-2">
							<div class="item-photo row justify-content-center">
								<div class="user-info">
									<div class="user-info-avatar" id="avatar"></div>
									<div class="user-info-name" id="name">
										<?php print fx_lang("notify.{$notice_manager_name}") ?>
									</div>
								</div>
							</div>
							<div class="list-group-item-text item-date">
								<?php print fx_get_date($notice['n_date_created']) ?>
							</div>
							<?php if($notice['n_date_updated']){ ?>
								<div class="list-group-item-text item-date-readed">
									<?php print fx_lang('notify.notice_is_readed') ?>
									<?php print fx_get_date($notice['n_date_updated']) ?>
								</div>
							<?php }else{ ?>
								<div class="list-group-item-text item-new">
									<?php print fx_lang('notify.new_notice') ?>
								</div>
							<?php } ?>
						</div>

						<div class="col-md-7 col-sm-8 col-9 col-lg-10 col-xl-10 notices-item-info">
							<div class="list-group-item-heading info item-title mt-1 mb-1">
								<?php print fx_lang($notice['n_theme']) ?>
							</div>
							<div class="list-group-item-heading info item-content mt-1 mb-1">
								<?php if($notice['u_id']){ ?>
									<div class="content-user">
										<?php print fx_lang("notify.notice_content_head",array(
											'%user_link%'	=> fx_get_url('users','item',$notice['u_id']),
											'%user_image%'	=> fx_avatar($notice['p_micro'],'micro',$notice['u_gender']),
											'%user_name%'	=> fx_get_full_name($notice['u_full_name'],$notice['u_gender']),
										)) ?>
										<div class="content-notice">
											<blockquote class="quote">
												<?php print fx_lang($notice['n_content']) ?>
											</blockquote>
										</div>
									</div>
								<?php }else{ ?>
									<div class="content-notice">
										<?php print fx_lang($notice['n_content']) ?>
									</div>
								<?php } ?>
							</div>
							<div class="list-group-item-heading info item-link mt-1 mb-1">
								<a href="<?php print fx_get_url('notify','item',$notice['n_receiver_id'],$notice['n_id']) ?>">
									<?php print fx_lang("notify.follow_to_page") ?>
								</a>
							</div>
						</div>

					</div>

				</div>

			</div>

		<?php } ?>

	</div>

</div>