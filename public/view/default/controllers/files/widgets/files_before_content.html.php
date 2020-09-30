<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $content
	 * @var array $options
	 */
	$this->appendCSS('files');
//fx_die($options)
?>
<?php if($content){ ?>
	<?php if($options['wa_show_title']){ ?>
		<a href="<?php print fx_get_url('files','index') ?>" class="before-content-widget-header">
			<div class="row justify-content-center widget-header">
				<div class="col-12 before-content-title title">
					<?php print fx_lang($options['wa_title']) ?>
				</div>
			</div>
		</a>
	<?php } ?>
	<div class="files-list row justify-content-center before-content-widget-body">
		<div class="col-12 files row">
			<?php foreach($content as $file){ ?>

				<a href="<?php print fx_get_url('files','item',$file['f_id']) ?>" class="list-group-item list-group-item-action file-item radius-0">

					<div class="file-info row ">
						<div class="file-icon col-3 col-sm-3 col-md-3 col-xl-2 col-lg-2 text-center">
							<div class="icon">
								<?php print fx_get_file_icon($file['f_name']) ?>
							</div>
						</div>

						<div class="file-name col-9 col-sm-9 col-md-9 col-xl-10 col-lg-10">

							<div class="name">
								<?php print $file['f_name'] ?>
							</div>

							<div class="description">
								<?php print fx_crop_string($file['f_description'],100) ?>
							</div>
						</div>

						<div class="mt-2 file-details col-12">
							<div class="row pt-2">
								<div class="file-user mr-2">
									<?php fx_print_avatar(
										$file['p_micro'],
										'micro',
										$file['p_date_updated'],
										$file['u_gender']
									) ?>
									<?php print fx_get_full_name($file['u_full_name'],$file['u_gender']) ?>
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

				</a>

			<?php } ?>
		</div>
	</div>
<?php } ?>