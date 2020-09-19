<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $audios */

	$this->prependCSS("audios");
	$this->prependJS("audios");
?>
	<?php if(fx_logged()){ ?>
		<div class="buttons-panel col-12 text-right mb-1 mt-1">
			<div class="btn-group">
				<a class="add-post btn-success radius-0 p-2" href="<?php print fx_get_url('audios','add') ?>">
					<i class="fas fa-plus"></i>
					<?php print fx_lang('audios.add_audios_button') ?>
				</a>
			</div>
		</div>
	<?php } ?>


<div class="audios-list form row form-auth justify-content-center mb-4">

	<div class="col-12 list-group audios row pl-3">

		<?php foreach($audios as $audio){ ?>

			<a href="<?php print fx_get_url('audios','item',$audio['au_id']) ?>" class="list-group-item list-group-item-action audio-item radius-0">

				<div class="audio-info row ">
					<div class="audio-icon col-3 col-sm-3 col-md-3 col-xl-2 col-lg-2 text-center">
						<div class="icon">
							<?php print fx_get_file_icon($audio['au_name']) ?>
						</div>
					</div>

					<div class="audio-name col-9 col-sm-9 col-md-9 col-xl-10 col-lg-10">

						<div class="name">
							<?php print $audio['au_name'] ?>
						</div>

						<div class="description">
							<?php print fx_crop_string($audio['au_description'],100) ?>
						</div>
					</div>

					<div class="mt-2 audio-details col-12">
						<div class="row pt-2">
							<div class="audio-user mr-2">
								<?php fx_print_avatar(
									$audio['p_micro'],
									'micro',
									$audio['p_date_updated'],
									$audio['u_gender']
								) ?>
								<?php print fx_get_full_name($audio['u_full_name'],$audio['u_gender']) ?>
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

			</a>

		<?php } ?>

	</div>
</div>
