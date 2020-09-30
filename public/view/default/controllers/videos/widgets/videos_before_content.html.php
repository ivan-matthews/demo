<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $content
	 * @var array $options
	 */
	$this->appendCSS('videos');
//fx_die($options)
?>
<?php if($content){ ?>
	<?php if($options['wa_show_title']){ ?>
		<a href="<?php print fx_get_url('videos','index') ?>" class="before-content-widget-header">
			<div class="row justify-content-center widget-header">
				<div class="col-12 before-content-title title">
					<?php print fx_lang($options['wa_title']) ?>
				</div>
			</div>
		</a>
	<?php } ?>
	<div class="videos-list row justify-content-center before-content-widget-body">
		<div class="col-12 videos row">
			<?php foreach($content as $video){ ?>

				<a href="<?php print fx_get_url('videos','item',$video['v_id']) ?>" class="list-group-item list-group-item-action video-item radius-0">

					<div class="video-info row ">
						<div class="video-icon col-3 col-sm-3 col-md-3 col-xl-2 col-lg-2 text-center">
							<div class="icon">
								<?php print fx_get_file_icon($video['v_name']) ?>
							</div>
						</div>

						<div class="video-name col-9 col-sm-9 col-md-9 col-xl-10 col-lg-10">

							<div class="name">
								<?php print $video['v_name'] ?>
							</div>

							<div class="description">
								<?php print fx_crop_string($video['v_description'],100) ?>
							</div>
						</div>

						<div class="mt-2 video-details col-12">
							<div class="row pt-2">
								<div class="video-user mr-2">
									<?php fx_print_avatar(
										$video['p_micro'],
										'micro',
										$video['p_date_updated'],
										$video['u_gender']
									) ?>
									<?php print fx_get_full_name($video['u_full_name'],$video['u_gender']) ?>
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

				</a>

			<?php } ?>
		</div>
	</div>
<?php } ?>