<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $photo */

	$this->prependCSS("photos");
	$this->prependJS("photos");
?>

	<div class="photos-item row justify-content-center">

		<div class="col-10 mb-2 image-title">
			<?php print $photo['p_name'] ?>
		</div>

		<div class="col-12 photos-block row">

			<div class="col-12 col-sm-12 col-md-12 col-lg-5 col-xl-5 photos-image">

				<div class="image-block">
					<img src="<?php print fx_get_image_src($photo['p_big'],$photo['p_date_updated'],'big') ?>">
				</div>

				<?php if($photo['p_date_updated'] > $photo['p_date_created']){ ?>
					<div class="upd-date mt-2">

						(<?php print fx_lang('photos.photo_updated_in') ?>

						<?php print fx_get_date($photo['p_date_updated']) ?>)

					</div>
				<?php } ?>

				<div class="links-block m-0 p-0 row mt-2 mb-2 col-12 col-sm-9 col-md-6 col-lg-12 col-xl-12">

					<?php if(fx_me($photo['u_id'])){ ?>

						<a class="col-6 mx-auto size-original-link" href="<?php print fx_get_upload_path($photo['p_original']) ?>">
							<i class="fas fa-search-plus"></i>
							<?php print fx_lang('photos.show_original_image') ?>
						</a>
						<a download="<?php print $photo['p_name'] ?>" class="col-5 mx-auto get-original-link" href="<?php print fx_get_url('photos','download',$photo['p_id']) ?>">
							<i class="fas fa-download"></i>
							<?php print fx_lang('photos.download_original_image') ?>
						</a>
						<div class="drop-down-menu">
							<a class="col-1 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>

							<div class="dropdown-menu dropdown-menu-right radius-0">
								<?php if(!fx_equal($photo['u_avatar_id'],$photo['p_id'])){ ?>
									<a class="dropdown-item size-original-link pb-2 pt-2" href="<?php print fx_get_url('avatar','set',$photo['p_id']) ?>">
										<i class="fa fa-plus" aria-hidden="true"></i>
										<?php print fx_lang('photos.set_image_as_avatar') ?>
									</a>
								<?php } ?>
								<a class="dropdown-item size-original-link pb-2 pt-2" href="<?php print fx_get_url('photos','edit',$photo['p_id']) ?>">
									<i class="fas fa-pen" aria-hidden="true"></i>
									<?php print fx_lang('photos.edit_image') ?>
								</a>
								<a class="dropdown-item size-original-link pb-2 pt-2" href="<?php print fx_get_url('photos','delete',$photo['p_id']) ?>">
									<i class="fa fa-times" aria-hidden="true"></i>
									<?php print fx_lang('photos.delete_image') ?>
								</a>
							</div>
						</div>

					<?php }else{ ?>

						<a class="col-6 mx-auto size-original-link" href="<?php print fx_get_upload_path($photo['p_original']) ?>">
							<i class="fas fa-search-plus"></i>
							<?php print fx_lang('photos.show_original_image') ?>
						</a>
						<a download="<?php print $photo['p_name'] ?>" class="col-5 mx-auto get-original-link" href="<?php print fx_get_url('photos','download',$photo['p_id']) ?>">
							<i class="fas fa-download"></i>
							<?php print fx_lang('photos.download_original_image') ?>
						</a>

					<?php } ?>
				</div>

			</div>

			<div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xl-7 mb-4 photos-description mt-4 mt-sm-4 mt-md-4 mt-xl-0 mt-lg-0">

				<a class="m-0 p-0 user-info-link" href="<?php print fx_get_url('users','item',$photo['u_id']) ?>">

					<div class="user-info row col-12">

						<div class="col-1 m-0 p-0">
							<div class="user-photo">
								<?php fx_print_avatar($photo['micro'],'micro',$photo['updated'],$photo['u_gender']) ?>

							</div>
						</div>

						<div class="col-11">
							<div class="row col-12 m-0 p-0 mb-1">
								<div class="user-name pr-2">
									<?php print fx_get_full_name($photo['u_full_name'],$photo['u_gender']) ?>
								</div>

								<div class="add-date">
									<?php print fx_lang('photos.photo_added_in') ?>
									<?php print fx_get_date($photo['p_date_created']) ?>
								</div>
							</div>
							<div class="photo-views col-12 row">
								<div class="icon pr-1">
									<i class="fas fa-eye"></i>
								</div>
								<div class="text">
									<?php print fx_lang('photos.total_views_value',array(
										'%total%'	=> $photo['p_total_views']
									)) ?>
								</div>
							</div>
						</div>

					</div>

				</a>

				<?php if($photo['p_description']){ ?>
					<div class="description ml-4 pl-4 footer-line pb-2 mb-2">
						<?php print $photo['p_description'] ?>
					</div>
				<?php } ?>

<!--				<div class="photos-comments">
					<?php /*print $this->widget('photo_info') */?>
				</div>
-->
			</div>

		</div>

	</div>



