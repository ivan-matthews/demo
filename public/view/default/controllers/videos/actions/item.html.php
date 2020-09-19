<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $video */

	$this->prependCSS("videos");
	$this->prependJS("videos");
?>

	<div class="videos-item row justify-content-center">

		<div class="col-12 video-item">

			<div class="col-12 video-name">
				<?php print $video['v_name'] ?>
			</div>

			<div class="video-info row col-12 ml-0">
				<div class="d-none d-sm-none d-md-none d-lg-block d-xl-block col-lg-2 col-xl-2 icon">
					<?php print fx_get_file_icon($video['v_name'])  ?>
				</div>

				<div class="item-content col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 mt-4">

					<video controls loop preload="auto" class="col-12">
						<source src="<?php print fx_get_upload_path($video['v_path']) ?>" type="<?php print $video['v_mime'] ?>">
					</video>

					<div class="col-12 description mt-4">
						<?php print $video['v_description'] ?>
					</div>

				</div>
			</div>

			<div class="col-12 row justify-content-center m-0 p-0">
				<div class="list-group-item-heading info item-link mt-4 mb-2 btn-group col-12 col-md-8 p-0 m-0">
					<a href="<?php print fx_get_url('videos','download',$video['v_id']) ?>" class="btn btn-success">
						<i class="fas fa-download"></i>
						<?php print fx_lang('videos.download_video_btn_value') ?>
					</a>
					<?php if(fx_me($video['v_user_id'])){ ?>
						<a class="btn btn-default link-follow" href="<?php print fx_get_url('videos','edit',$video['v_id']) ?>">
							<i class="fas fa-marker"></i>
							<?php print fx_lang('videos.edit_btn_value') ?>
						</a>
						<a class="btn btn-danger link-follow" href="<?php print fx_get_url('videos','delete',$video['v_id']) ?>">
							<i class="fas fa-recycle"></i>
							<?php print fx_lang('videos.delete_btn_value') ?>
						</a>
					<?php } ?>
				</div>
			</div>

			<div class="mt-2 video-details col-12 header-line pt-2 mb-4">
				<div class="row pt-2">
					<div class="video-user mr-2">
						<a href="<?php print fx_get_url('users','item',$video['v_user_id']) ?>">
							<?php fx_print_avatar(
								$video['p_micro'],
								'micro',
								$video['p_date_updated'],
								$video['u_gender']
							) ?>
							<?php print fx_get_full_name($video['u_full_name'],$video['u_gender']) ?>
						</a>
					</div>
					<div class="video-date mr-2">
						<i class="fas fa-clock"></i>
						<?php print fx_get_date($video['v_date_created']) ?>
					</div>
					<div class="video-size mr-2">
						<i class="fas fa-sd-card"></i>
						<?php print fx_prepare_memory($video['v_size']) ?>
					</div>
					<div class="video-views mr-2">
						<i class="fas fa-eye"></i>
						<?php print $video['v_total_views'] ?>
					</div>
					<div class="video-comments mr-2">
						<i class="fas fa-comments"></i>
						<?php print $video['v_total_comments'] ?>
					</div>
				</div>
			</div>
		</div>

	</div>



