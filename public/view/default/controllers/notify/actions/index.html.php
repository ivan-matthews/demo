<?php
	use Core\Classes\Mail\Notice;
	use \Core\Classes\View;

	/** @var View $this */
	/** @var array $data */
	/** @var array $notices */
	/** @var string $total */
	/** @var integer $user */

	$this->prependCSS("{$this->theme_path}/css/notify");
	$this->prependJS("{$this->theme_path}/js/notify");

	$unreaded = null;
?>

<div class="m-0 mb-4 notices-list row justify-content-center">

	<div class="col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12 notices row list-group p-0">

		<?php foreach($notices as $notice){ ?>

			<?php $notice_manager_name	= "notice_manager_name_{$notice['n_manager_id']}" ?>
			<?php $reading	= $notice['n_date_updated'] && fx_equal((int)$notice['n_status'],Notice::STATUS_READED) ?>

			<?php if(!$reading){$unreaded = true; } ?>

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
							<?php if($reading){ ?>
								<div class="list-group-item-text item-date-readed">
									<?php print fx_lang('notify.notice_is_readed') ?>
									<?php print fx_get_date($notice['n_date_updated']) ?>
								</div>
							<?php } ?>
						</div>

						<div class="col-md-9 col-sm-9 col-9 col-lg-10 col-xl-10 notices-item-info">
							<div class="list-group-item-heading info item-title mt-1 mb-1 pl-0">
								<?php if(!$reading){ ?>
									<span class="list-group-item-text item-new bg-danger text-white mr-2 p-1 pl-2 pr-2">
										<?php print fx_lang('notify.new_notice') ?>
									</span>
								<?php } ?>
								<?php print fx_lang($notice['n_theme'],fx_arr($notice['n_theme_data_to_replace'])) ?>
								<?php if($notice['n_unique_count']){ ?>
									<div class="float-right list-group-item-text item-new bg-danger text-white pl-2 pr-2">
										<?php print $notice['n_unique_count'] ?>
									</div>
								<?php } ?>
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
												<?php print fx_lang($notice['n_content'],fx_arr($notice['n_content_data_to_replace'])) ?>
											</blockquote>
										</div>
									</div>
								<?php }else{ ?>
									<div class="content-notice">
										<?php print fx_lang($notice['n_content'],fx_arr($notice['n_content_data_to_replace'])) ?>
									</div>
								<?php } ?>
							</div>
							<div class="list-group-item-heading info item-link mt-1 mb-1 text-right">
								<?php if($notice['n_action']){ ?>
									<a class="btn bg-success text-white link-follow" href="<?php print fx_get_url('notify','item',$notice['n_id']) ?>">
										<?php print fx_lang("notify.follow_to_page") ?>
									</a>
								<?php } ?>
								<?php if(!$reading){ ?>
									<a class="btn bg-warning text-white link-follow" href="<?php print fx_get_url('notify','read',$notice['n_id']) ?>">
										<?php print fx_lang("notify.mark_as_read") ?>
									</a>
								<?php } ?>
								<a class="btn bg-danger text-white link-follow" href="<?php print fx_get_url('notify','delete',$notice['n_id']) ?>">
									<?php print fx_lang("notify.delete_notice") ?>
								</a>
							</div>
						</div>

					</div>

				</div>

			</div>

		<?php } ?>

		<div class="text-center mt-4 notify-all-links">

			<div class="btn-group col-11 col-sm-11 col-md-11 col-lg-6 col-xl-6 m-0 p-0">
				<?php if($unreaded){ ?>
					<a class="btn btn-warning text-white" href="<?php print fx_get_url('notify','read') ?>">
						<?php print fx_lang('notify.read_unreaded_notices') ?>
					</a>
				<?php } ?>
				<a class="btn btn-danger" href="<?php print fx_get_url('notify','delete') ?>">
					<?php print fx_lang('notify.delete_all_notices') ?>
				</a>
			</div>
		</div>

	</div>

</div>