<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $file */

	$this->prependCSS("files");
	$this->prependJS("files");
?>

	<div class="files-item row justify-content-center">

		<div class="col-12 file-item">

			<div class="col-12 file-name">
				<?php print $file['f_name'] ?>
			</div>

			<div class="file-info row col-12 ml-0">
				<div class="col-3 col-sm-3 col-md-3 col-lg-2 col-xl-2 icon">
					<?php print fx_get_file_icon($file['f_name'])  ?>
				</div>

				<div class="col-9 col-sm-9 col-md-9 col-lg-10 col-xl-10 description mt-4">
					<?php print $file['f_description'] ?>
				</div>
			</div>

			<div class="row justify-content-center">
				<div class="info item-link row col-12 col-sm-12 col-md-8 col-xl-6 col-lg-7">
					<a href="<?php print fx_get_url('files','download',$file['f_id']) ?>" class="col btn btn-success">
						<i class="fas fa-download"></i>
						<?php print fx_lang('files.download_file_btn_value') ?>
					</a>
					<?php if(fx_me($file['f_user_id'])){ ?>
						<a class="col btn btn-default link-follow" href="<?php print fx_get_url('files','edit',$file['f_id']) ?>">
							<i class="fas fa-marker"></i>
							<?php print fx_lang('files.edit_btn_value') ?>
						</a>
						<a class="col btn btn-danger link-follow" href="<?php print fx_get_url('files','delete',$file['f_id']) ?>">
							<i class="fas fa-recycle"></i>
							<?php print fx_lang('files.delete_btn_value') ?>
						</a>
					<?php } ?>
				</div>
			</div>

			<div class="mt-2 file-details col-12 header-line pt-2 mb-4">
				<div class="row pt-2">
					<div class="file-user mr-2">
						<a href="<?php print fx_get_url('users','item',$file['f_user_id']) ?>">
							<?php fx_print_avatar(
								$file['p_micro'],
								'micro',
								$file['p_date_updated'],
								$file['u_gender']
							) ?>
							<?php print fx_get_full_name($file['u_full_name'],$file['u_gender']) ?>
						</a>
					</div>
					<div class="file-date mr-2">
						<i class="fas fa-clock"></i>
						<?php print fx_get_date($file['f_date_created']) ?>
					</div>
					<div class="file-size mr-2">
						<i class="fas fa-sd-card"></i>
						<?php print fx_prepare_memory($file['f_size']) ?>
					</div>
					<div class="file-views mr-2">
						<i class="fas fa-eye"></i>
						<?php print $file['f_total_views'] ?>
					</div>
					<div class="file-comments mr-2">
						<i class="fas fa-comments"></i>
						<?php print $file['f_total_comments'] ?>
					</div>
				</div>
			</div>
		</div>

	</div>



