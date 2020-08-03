<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $user */
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
					<img src="<?php print $this->getUploadSiteRoot($avatar['p_big']) ?>?v=<?php print $avatar['p_date_updated'] ?>">
				</div>

				<div class="links-block mt-2 col-12 row justify-content-center p-0 ml-0 mr-0">
					<a class="col-6 mx-auto size-original-link" href="<?php print $this->getUploadSiteRoot($avatar['p_original']) ?>">
						<i class="fas fa-search-plus"></i>
						<?php print fx_lang('avatar.show_original_image') ?>
					</a>
					<a class="col-6 mx-auto get-original-link" href="javascript:void(0)" onclick="indexObj.downloadFile(this,'<?php print $this->getUploadSiteRoot($avatar['p_original']) ?>','<?php print $avatar['p_mime'] ?>',<?php print $avatar['p_size'] ?>,'<?php print $avatar['p_name'] ?>','<?php print fx_lang('avatar.download_image_description',array('%image%'=> $avatar['p_name'])) ?>')">
						<i class="fas fa-download"></i>
						<?php print fx_lang('avatar.download_original_image') ?>
					</a>
				</div>

			</div>

			<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-4 avatar-description mt-4 mt-sm-4 mt-md-4 mt-xl-0 mt-lg-0">

				<a class="user-info-link" href="<?php print fx_get_url('users','item',$user['u_id']) ?>">

					<div class="user-info row col-12 pl-0 pr-0 mr-0 ml-0">

						<div class="user-avatar">

							<?php fx_print_avatar($user['p_micro'],'micro',$user['p_date_updated'],$user['u_gender']) ?>

						</div>

						<div class="user-name ml-3">

							<?php print fx_get_full_name($user['u_full_name'],$user['u_gender']) ?>

						</div>

						<div class="add-date ml-2">

							<?php print fx_lang('avatar.avatar_added_in') ?>

							(<?php print fx_get_date(($avatar['p_date_updated'] ? $avatar['p_date_updated'] : $avatar['p_date_created'])) ?>)

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



