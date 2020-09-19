<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $photos */

	$this->prependCSS("{$this->theme_path}/css/photos");
	$this->prependJS("{$this->theme_path}/js/photos");
?>
	<div class="buttons-panel col-12 text-right mb-1 mt-1">
		<div class="btn-group">
			<a class="add-post btn-success radius-0 p-2" href="<?php print fx_get_url('photos','add') ?>">
				 <i class="fas fa-plus"></i>
				<?php print fx_lang('photos.add_photos_button') ?>
			</a>
		</div>
	</div>

	<div class="photos-list row justify-content-center">

		<div class="col-12 photos row">

			<?php foreach($photos as $photo){ ?>

				<div class="photos-item col-4 col-sm-4 col-md-4 col-lg-3 col-xl-2 mt-2 mb-2">

					<div class="photos-item-title">

						<?php print $photo['p_name'] ?>

					</div>

					<a class="photos-item-link" href="<?php print fx_get_url('photos','item',$photo['p_id']) ?>">

						<img class="photos-item-image" src="<?php print fx_get_image_src($photo['p_medium'],$photo['p_date_updated'],'medium') ?>"/>

						<div class="photos-item-date">

							<?php print fx_get_date($photo['p_date_created']) ?>

						</div>

					</a>

				</div>

			<?php } ?>

		</div>

	</div>
