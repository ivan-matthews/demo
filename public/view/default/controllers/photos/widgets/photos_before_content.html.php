<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $content
	 * @var array $options
	 */
	$this->appendCSS('photos');
//fx_die($options)
?>
<?php if($content){ ?>
	<?php if($options['wa_show_title']){ ?>
		<a href="<?php print fx_get_url('photos','index') ?>" class="before-content-widget-header">
			<div class="row justify-content-center widget-header">
				<div class="col-12 before-content-title title">
					<?php print fx_lang($options['wa_title']) ?>
				</div>
			</div>
		</a>
	<?php } ?>
	<div class="photos-list row justify-content-center before-content-widget-body">
		<div class="col-12 photos row">
			<?php foreach($content as $photo){ ?>

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
<?php } ?>