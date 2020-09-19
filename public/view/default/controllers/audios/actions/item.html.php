<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $audio */

	$this->prependCSS("{$this->theme_path}/css/audios");
	$this->prependJS("{$this->theme_path}/js/audios");
?>

	<div class="audios-item row justify-content-center">

		<div class="col-12 audio-item">

			<div class="col-12 audio-name">
				<?php print $audio['au_name'] ?>
			</div>

			<div class="audio-info row col-12 ml-0">
				<div class="d-none d-sm-none d-md-none d-lg-block d-xl-block col-lg-2 col-xl-2 icon">
					<?php print fx_get_file_icon($audio['au_name'])  ?>
				</div>

				<div class="item-content col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 mt-4">

					<audio controls loop preload="none" class="col-12">
						<source src="<?php print fx_get_upload_path($audio['au_path']) ?>" type="<?php print $audio['au_mime'] ?>">
					</audio>

					<div class="col-12 description mt-4">
						<?php print $audio['au_description'] ?>
					</div>

				</div>
			</div>

			<div class="col-12 row justify-content-center">
				<div class="list-group-item-heading info item-link mt-4 mb-2 btn-group col-8">
					<a href="<?php print fx_get_url('audios','download',$audio['au_id']) ?>" class="btn btn-success">
						<i class="fas fa-download"></i>
						<?php print fx_lang('audios.download_audio_btn_value') ?>
					</a>
					<?php if(fx_me($audio['au_user_id'])){ ?>
						<a class="btn btn-default link-follow" href="<?php print fx_get_url('audios','edit',$audio['au_id']) ?>">
							<i class="fas fa-marker"></i>
							<?php print fx_lang('audios.edit_btn_value') ?>
						</a>
						<a class="btn btn-danger link-follow" href="<?php print fx_get_url('audios','delete',$audio['au_id']) ?>">
							<i class="fas fa-recycle"></i>
							<?php print fx_lang('audios.delete_btn_value') ?>
						</a>
					<?php } ?>
				</div>
			</div>

			<div class="mt-2 audio-details col-12 header-line pt-2 mb-4">
				<div class="row pt-2">
					<div class="audio-user mr-2">
						<a href="<?php print fx_get_url('users','item',$audio['au_user_id']) ?>">
							<?php fx_print_avatar(
								$audio['p_micro'],
								'micro',
								$audio['p_date_updated'],
								$audio['u_gender']
							) ?>
							<?php print fx_get_full_name($audio['u_full_name'],$audio['u_gender']) ?>
						</a>
					</div>
					<div class="audio-date mr-2">
						<i class="fas fa-clock"></i>
						<?php print fx_get_date($audio['au_date_created']) ?>
					</div>
					<div class="audio-size mr-2">
						<i class="fas fa-sd-card"></i>
						<?php print fx_prepare_memory($audio['au_size']) ?>
					</div>
					<div class="audio-views mr-2">
						<i class="fas fa-eye"></i>
						<?php print $audio['au_total_views'] ?>
					</div>
					<div class="audio-comments mr-2">
						<i class="fas fa-comments"></i>
						<?php print $audio['au_total_comments'] ?>
					</div>
				</div>
			</div>
		</div>

	</div>


