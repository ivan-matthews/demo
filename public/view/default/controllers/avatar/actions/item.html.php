<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $avatar */

	$this->addCSS("{$this->theme_path}/css/avatar");
	$this->addJS("{$this->theme_path}/js/avatar");
?>

	<div class="avatar-item row justify-content-center">

		<div class="col-10 mb-2 image-title">
			<?php print $avatar['p_name'] ?>
		</div>

		<div class="col-10 avatar-block row">

			<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 avatar-image row">

				<div class="image-block">
					<img onerror="indexObj.brokenImage(this,'big')" src="<?php print $this->getUploadSiteRoot($avatar['p_big']) ?>?v=<?php print $avatar['p_date_updated'] ?>">
				</div>

				<div class="links-block mt-2 col-12 row justify-content-center p-0 ml-0 mr-0">

					<?php if(fx_me($avatar['u_id'])){ ?>

						<a class="col-6 mx-auto size-original-link" href="<?php print $this->getUploadSiteRoot($avatar['p_original']) ?>">
							<i class="fas fa-search-plus"></i>
							<?php print fx_lang('avatar.show_original_image') ?>
						</a>
						<a class="col-5 mx-auto get-original-link" href="javascript:void(0)" onclick="indexObj.downloadFile(this,'<?php print $this->getUploadSiteRoot($avatar['p_original']) ?>','<?php print $avatar['p_mime'] ?>',<?php print $avatar['p_size'] ?>,'<?php print $avatar['p_name'] ?>','<?php print fx_lang('avatar.download_image_description',array('%image%'=> $avatar['p_name'])) ?>')">
							<i class="fas fa-download"></i>
							<?php print fx_lang('avatar.download_original_image') ?>
						</a>
						<div class="drop-down-menu">
							<a class="col-1 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>

							<div class="dropdown-menu dropdown-menu-right radius-0">
								<?php if(!fx_equal($avatar['u_avatar_id'],$avatar['p_id'])){ ?>
									<a class="dropdown-item size-original-link pb-2 pt-2" href="<?php print fx_get_url('avatar','set',$avatar['u_id'],$avatar['p_id']) ?>">
										<i class="fa fa-plus" aria-hidden="true"></i>
										<?php print fx_lang('avatar.set_image_as_avatar') ?>
									</a>
								<?php } ?>
								<a class="dropdown-item size-original-link pb-2 pt-2" href="<?php print fx_get_url('avatar','edit',$avatar['u_id'],$avatar['p_id']) ?>">
									<i class="fas fa-pen" aria-hidden="true"></i>
									<?php print fx_lang('avatar.edit_image') ?>
								</a>
								<a class="dropdown-item size-original-link pb-2 pt-2" href="<?php print fx_get_url('avatar','unlink',$avatar['u_id'],$avatar['p_id']) ?>">
									<i class="fa fa-times" aria-hidden="true"></i>
									<?php print fx_lang('avatar.delete_image') ?>
								</a>
							</div>
						</div>

					<?php }else{ ?>

						<a class="col-6 mx-auto size-original-link" href="<?php print $this->getUploadSiteRoot($avatar['p_original']) ?>">
							<i class="fas fa-search-plus"></i>
							<?php print fx_lang('avatar.show_original_image') ?>
						</a>
						<a class="col-6 mx-auto get-original-link" href="javascript:void(0)" onclick="indexObj.downloadFile(this,'<?php print $this->getUploadSiteRoot($avatar['p_original']) ?>','<?php print $avatar['p_mime'] ?>',<?php print $avatar['p_size'] ?>,'<?php print $avatar['p_name'] ?>','<?php print fx_lang('avatar.download_image_description',array('%image%'=> $avatar['p_name'])) ?>')">
							<i class="fas fa-download"></i>
							<?php print fx_lang('avatar.download_original_image') ?>
						</a>

					<?php } ?>
				</div>

			</div>

			<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-4 avatar-description mt-4 mt-sm-4 mt-md-4 mt-xl-0 mt-lg-0">

				<a class="user-info-link" href="<?php print fx_get_url('users','item',$avatar['u_id']) ?>">

					<div class="user-info row col-12 pl-0 pr-0 mr-0 ml-0">

						<div class="user-avatar">

							<?php fx_print_avatar($avatar['p_micro'],'micro',$avatar['p_date_updated'],$avatar['u_gender']) ?>

						</div>

						<div class="user-name ml-3">

							<?php print fx_get_full_name($avatar['u_full_name'],$avatar['u_gender']) ?>

						</div>

						<div class="add-date ml-2">

							<?php print fx_lang('avatar.avatar_added_in') ?>

							(<?php print fx_get_date($avatar['p_date_updated']) ?>)

						</div>

					</div>

				</a>

				<!--<div class="comments mt-2">
					<div class="comments-title">
						<h5>Камменты</h5>
					</div>
					<div class="comments-form">
						<input type="text" class="form-control" placeholder="пиши что-нибуть">
					</div>
					<div class="comments-items">

					</div>
				</div>-->

			</div>

		</div>

	</div>



